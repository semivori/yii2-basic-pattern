<?php

namespace app\models\common\ar;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "queue".
 *
 * @property string $id
 * @property string $type
 * @property string $object_id
 * @property string $created_at
 * @property string $started_at
 * @property string $executed_at
 * @property string $data
 * @property string $error_data
 */
class Queue extends ActiveRecord
{
    const USER__REGISTER = 'user__register';
    const USER__PASSWORD_CHANGE = 'user__password_change';
    const USER__RESET_PASSWORD = 'user__reset_password';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'queue';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'object_id'], 'required'],
            [['object_id'], 'integer'],
            [['created_at', 'executed_at', 'started_at'], 'safe'],
            [['data', 'error_data'], 'string'],
            [['type'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'object_id' => 'Object ID',
            'created_at' => 'Created At',
            'started_at' => 'Started At',
            'executed_at' => 'Executed At',
            'data' => 'Data',
            'error_data' => 'Error Data',
        ];
    }

    /**
     * Mark as started + update the counter
     */
    public function markAsStarted()
    {
        $this->started_at = new Expression('NOW()');
        $this->error_data = null;
        $this->save();
    }

    /**
     * Mark as executed
     */
    public function markAsExecuted()
    {
        $this->executed_at = new Expression('NOW()');
        $this->error_data = null;
        $this->save();
    }
}
