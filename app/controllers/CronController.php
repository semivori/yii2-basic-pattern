<?php

namespace app\controllers;

use Yii;
use app\controllers\BaseController;
use app\services\common\QueueService;

/**
 * Class CronController
 * @package app\controllers
 */
class CronController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        ini_set('max_execution_time', 0); // 0 hrs
        ini_set('memory_limit', '500M'); // 500 Mb
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
       return false;
    }

    /**
     * Queue
     */
    public function actionQueue()
    {
        $start_time = microtime(true);

        $qService = new QueueService();
        $qService->execute();

        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time)/60;

        return 'Done... ' . round($execution_time, 2) . ' minutes...';
    }
}
