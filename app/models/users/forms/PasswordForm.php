<?php

namespace app\models\users\forms;

use Yii;
use yii\base\Model;
use app\models\users\ar\User;

/**
 * Class PasswordForm
 * @package app\models\users\forms
 */
class PasswordForm extends Model
{
    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $new;

    /**
     * @var string
     */
    public $repeat;

    /**
     * @var null|User
     */
    private $user = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'new', 'repeat'], 'filter', 'filter' => 'trim'],
            [['password', 'new', 'repeat'], 'required', 'message' => 'enter a value for {attribute}'],
            ['password', 'validatePassword'],
            [['password', 'new', 'repeat'], 'string', 'min' => 6, 'max' => 100, 'tooShort' => '{attribute} must be at least 6 characters', 'tooLong' => '{attribute} must be not more than 100 characters'],
            ['repeat', 'matchPasswords']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Current password',
            'new' => 'New password',
            'repeat' => 'Confirm new password',
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->getUser()->validatePassword($this->password)) {
                $this->addError($attribute, 'wrong current password');
            }
            if ($this->getUser()->validatePassword($this->password) && $this->getUser()->validatePassword($this->new)) {
                $this->addError($attribute, 'nothing to change');
            }
        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function matchPasswords($attribute, $params)
    {
        if ($this->new && $this->repeat) {
            if ($this->new != $this->repeat) {
                $this->addError($attribute, 'passwords are different');
            }
        }
    }

    /**
     * @return bool
     */
    public function change()
    {
        if ($this->validate()) {
            $this->getUser()->setPassword($this->new);
            if (!$this->getUser()->save()) {
                return false;
            }

            return true;
        }
        return false;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User|null|\yii\web\IdentityInterface
     */
    private function getUser()
    {
        if (!$this->user) {
            $this->user = Yii::$app->user->identity;
        }
        return $this->user;
    }
}
