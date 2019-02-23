<?php

namespace app\models\users\forms;

use Yii;
use app\modules\notify\services\MailService;
use yii\base\Exception;
use yii\base\Model;
use app\models\users\ar\User;

/**
 * Class RegisterForm
 * @package app\modules\user\forms
 */
class RegisterForm extends Model
{

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $repeatPassword;

    /**
     * @var User
     */
    protected $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'repeatPassword', 'email', 'firstName', 'lastName'], 'filter', 'filter' => 'trim'],
            [['username', 'password', 'repeatPassword', 'email', 'firstName', 'lastName'], 'required', 'message' => 'enter a value for {attribute}'],

            [['username', 'email', 'firstName', 'lastName'], 'string', 'min' => 2, 'max' => 50, 'tooShort' => '{attribute} must be at least 2 symbols', 'tooLong' => '{attribute} must be not more than 50 symbols'],

            ['email', 'email', 'message' => 'enter a valid email'],

            ['email', 'unique', 'targetClass' => '\app\modules\user\models\User', 'message' => 'this email address has already been taken'],
            ['username', 'unique', 'targetClass' => '\app\modules\user\models\User', 'message' => 'this username has already been taken'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z0-9-_\.]{2,}$/i', 'message' => 'invalid username'],

            ['password', 'string', 'min' => 6, 'max' => 100, 'tooShort' => '{attribute} must be at least 6 symbols', 'tooLong' => '{attribute} must be not more than 100 symbols'],
            ['password', 'matchPasswords']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'repeatPassword' => 'Confirm password',
            'email' => 'Email',
            'firstName' => 'First name',
            'lastName' => 'Last name',
        ];
    }

    /**
     * Match passwords
     * @param $attribute
     * @param $params
     */
    public function matchPasswords($attribute, $params)
    {
        if ($this->password && $this->repeatPassword) {
            if ($this->password != $this->repeatPassword) {
                $this->addError($attribute,'passwords are different');
            }
        }
    }

    /**
     * Add a new user to the app
     * @return User|bool
     * @throws Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->first_name = $this->firstName;
            $user->last_name = $this->lastName;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->ip = Yii::$app->request->getUserIP();
            $user->ua = Yii::$app->request->getUserAgent();
            if ($user->save()) {
                $this->user = $user;
                $this->sendMail();
                return $user;
            }
        }

        return false;
    }

    /**
     * Send email after registration
     */
    protected function sendMail()
    {
        $user = User::find()
            ->where(['id' => $this->user->id])
            ->one();

        $notificationManager = new MailService($user);
        $notificationManager->register();
    }
}
