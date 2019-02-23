<?php

namespace app\services\common;

use Yii;
use app\models\users\ar\User;
use app\models\common\ar\Queue;
use yii\helpers\Json;

/**
 * Class QueueService
 * @package app\services\common
 */
class QueueService
{
    /**
     * Add a new record
     * @param string $type
     * @param object $object
     * @param null|array $data
     * @return Queue
     */
    public function add($type, $object, $data = null)
    {
        $model = new Queue();
        $model->type = $type;
        $model->object_id = $object->id;
        if ($data) {
            $model->data = Json::encode($data);
        }
        $model->save();

        return $model;
    }

    /**
     * Execute all new records
     * @throws \Exception
     * @throws \Throwable
     */
    public function execute()
    {
        $records = Queue::find()
            ->where("started_at IS NULL AND executed_at IS NULL")
            ->orderBy(['id' => SORT_ASC])
            ->all();

        /** @var Queue $record */
        foreach ($records as $record) {
            switch ($record->type) {
                case Queue::USER__REGISTER:
                case Queue::USER__PASSWORD_CHANGE:
                case Queue::USER__RESET_PASSWORD:
                    $user = User::findOne($record->object_id);

                    if ($user) {
                        $record->markAsStarted();
                        try {
                            $this->sendEmail($record->data);
                            $record->markAsExecuted();
                        } catch (\Exception $e) {
                            $this->errorLog($record, $e);
                        }
                    } else {
                        $record->delete();
                    }

                    break;

            }
        }
    }

    /**
     * Send an email
     * @param string $data
     */
    protected function sendEmail($data)
    {
        $data = Json::decode($data);
        $mailObject = unserialize($data['mail_object']);
        $mailObject->send();
    }

    /**
     * Log an error
     * @param Queue $queue
     * @param \Exception $e
     * @return bool
     */
    protected function errorLog(Queue $queue, \Exception $e)
    {
        $queue->started_at = null;
        $queue->error_data = Json::encode([
            "code" => $e->getCode(),
            "message" => $e->getMessage(),
            "file" => $e->getFile(),
            "line" => $e->getLine(),
            "trace" => $e->getTraceAsString(),
        ]);
        $queue->save();

        return true;
    }
}
