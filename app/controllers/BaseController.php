<?php

namespace app\controllers;

use Yii;
use yii\base\UserException;
use yii\web\Controller;

/**
 * Class BaseController
 * @package app\controllers
 */
class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // code...
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($event)
    {
        // If the account is activated?
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->isInactive()) {
                if (!$event instanceof \yii\web\ErrorAction) {
                    throw new UserException('Your account has been deleted.');
                }
            }
            if (Yii::$app->user->identity->isNotActivated() && !in_array($event->id, ['confirm', 'logout'])) {
                if (!$event instanceof \yii\web\ErrorAction) {
                    throw new UserException('Your account is not activated yet. Please go to your email address and activate your account.');
                }
            }
        }

        return parent::beforeAction($event);
    }
}
