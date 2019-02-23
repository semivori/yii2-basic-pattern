<?php

namespace app\models\users\forms;

use Yii;
use yii\base\Model;
use app\models\users\ar\User;

/**
 * Class LoginForm
 * @package app\modules\user\forms
 */
class LoginForm extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $rememberMe = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email', 'message' => 'wrong email address'],
            ['rememberMe', 'safe'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Password',
            'email' => 'Email',
        ];
    }

    /**
     * Validate password
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::find()
                ->where(['email' => $this->email])
                ->one();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'wrong email or password');
            }
        }
    }

    /**
     * Authorize
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            $user = User::find()
                ->where(['email' => $this->email])
                ->one();

            if ($user) {
                $user = User::findByUsername($user->username);
                return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 365 : 0);
            }
        }

        return false;
    }

}
