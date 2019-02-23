<?php

namespace app\controllers;

use Yii;
use app\models\users\ar\User;
use app\models\users\forms\NewPasswordForm;
use app\models\users\forms\RestoreForm;
use app\controllers\BaseController;
use app\models\users\forms\LoginForm;
use app\models\users\forms\RegisterForm;
use app\models\users\forms\EditForm;
use app\models\users\forms\PasswordForm;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class UsersController
 * @package app\controllers
 */
class UsersController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'login', 'logout', 'register', 'edit', 'forgot'],
                'rules' => [
                    [
                        'actions' => ['index', 'logout', 'edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'register', 'forgot'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Registration
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();

            if ($user) {
                Yii::$app->getUser()->login($user, 3600 * 24 * 365);
                Yii::$app->session->setFlash('success','Your account has been created successfully. Please confirm your email address.');
                return $this->goHome();
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Login
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', Html::encode(Yii::$app->user->identity->username) . ', welcome back!');
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Account confirmation
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionConfirm()
    {
        $code = trim(Html::encode(Yii::$app->request->get('code')));

        if ($code) {
            $user = User::find()
                ->where("MD5(email) = :code", [':code' => $code])
                ->one();

            if ($user) {
                $user->status_id = User::STATUS_ACTIVE;
                $user->save();

                Yii::$app->session->setFlash('success','Your account has been activated successfully.');
                return $this->goHome();
            }
        }

        throw new NotFoundHttpException('User not found.');
    }

    /**
     * Edit profile
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        $model = new EditForm();
        $model->attributes = [
            "email" => Yii::$app->user->identity->email,
            "phoneNumber" => Yii::$app->user->identity->phone_number,
            "firstName" => Yii::$app->user->identity->first_name,
            "lastName" => Yii::$app->user->identity->last_name,
            "timeZone" => Yii::$app->user->identity->time_zone,
        ];

        $passwordModel = new PasswordForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->update()) {
                Yii::$app->session->setFlash('success','Your profile has been updated.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        if ($passwordModel->load(Yii::$app->request->post()) && $passwordModel->validate() && $passwordModel->change()) {
            Yii::$app->session->setFlash('success','Your password has been changed. Now you can use the new one.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('edit', [
            'model' => $model,
            'passwordModel' => $passwordModel,
        ]);
    }

    /**
     * Forgot password
     * @return string|\yii\web\Response
     */
    public function actionForgot()
    {
        $model = new RestoreForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->sendCode()) {
                Yii::$app->session->setFlash('success','Please, check your email address to restore your password.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('forgot', [
            'model' => $model,
        ]);
    }

    /**
     * Set new password
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSetNewPassword()
    {
        $code = Html::encode(Yii::$app->request->get('code'));
        $user = User::findByPasswordResetToken($code);

        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        $model = new NewPasswordForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->updatePassword($user)) {
                Yii::$app->session->setFlash('success','Your password has been changed. Now you can use the new one.');
                return $this->goHome();
            }
        }

        return $this->render('set-new-password', [
            'model' => $model,
            'code' => $code,
        ]);
    }

    /**
     * Logout
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
