<?php

namespace app\models\users\forms;

use Yii;
use app\modules\notify\services\MailService;
use yii\base\Model;
use app\models\users\ar\User;

/**
 * Class RestoreForm
 * @package app\modules\user\forms
 */
class RestoreForm extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var User
     */
    protected $_user = false;


    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'enter a value for {attribute}'],
            ['email', 'email', 'message' => 'enter a valid email'],
            ['email', 'check']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function check($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = $this->getUser();

            if (!$this->_user || ($this->_user && ($this->_user->isNotActivated() || $this->_user->isInactive()))) {
                $this->addError($attribute,'wrong email, or your account is not activated or deleted');
            }

            if ($this->_user && $this->_user->password_reset_token) {
                $dateFromDatabase = strtotime($this->_user->password_reset_date);
                $dateTwelveHoursAgo = strtotime("-1 hours");

                if ($dateFromDatabase >= $dateTwelveHoursAgo) {
                    $this->addError($attribute,'you have already requested a password restoring less than an hour ago');
                } else {
                    $this->_user->removePasswordResetToken();
                    $this->_user->save();
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function sendCode()
    {
        $this->_user->generatePasswordResetToken();
        $this->_user->save();
        $this->_sendMail();

        return true;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    /**
     * @return bool
     */
    protected function _sendMail()
    {
        $notificationManager = new MailService($this->getUser());
        $notificationManager->reset();

        return true;
    }

}
