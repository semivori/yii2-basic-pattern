<?php

namespace app\models\users\forms;

use Yii;
use yii\base\Model;
use app\models\users\ar\User;

/**
 * Class NewPasswordForm
 * @package app\modules\user\forms
 */
class NewPasswordForm extends Model
{
    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $repeatPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'repeatPassword'], 'filter', 'filter' => 'trim'],
            [['password', 'repeatPassword'], 'required', 'message' => 'enter a value for {attribute}'],
            ['password', 'string', 'min' => 6, 'max' => 100, 'tooShort' => '{attribute} must be at least 6 characters', 'tooLong' => '{attribute} must be not more than 100 characters'],
            ['password', 'matchPasswords'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => 'New password',
            'repeatPassword' => 'Confirm new password',
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function matchPasswords($attribute, $params)
    {
        if ($this->password && $this->repeatPassword) {
            if ($this->password != $this->repeatPassword) {
                $this->addError($attribute, 'passwords are different');
            }
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public function updatePassword(User $user)
    {
        $user->removePasswordResetToken();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();

        return true;
    }
    
}