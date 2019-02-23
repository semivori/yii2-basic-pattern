<?php

namespace app\models\users\forms;

use Yii;
use yii\base\Model;
use app\models\users\ar\User;

/**
 * Class EditForm
 * @package app\modules\user\forms
 */
class EditForm extends Model
{
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
    public $email;

    /**
     * @var string
     */
    public $phoneNumber;

    /**
     * @var string
     */
    public $timeZone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'phoneNumber', 'firstName', 'lastName'], 'filter', 'filter' => 'trim'],
            [['email', 'firstName', 'lastName'], 'required', 'message' => 'enter a value for {attribute}'],

            [['email', 'firstName', 'lastName'], 'string', 'min' => 2, 'max' => 50, 'tooShort' => '{attribute} must be at least 2 symbols', 'tooLong' => '{attribute} must be not more than 50 symbols'],

            ['email', 'email', 'message' => 'enter a valid email'],
            ['email', 'checkEMail'],
            ['phoneNumber', 'match', 'pattern' => '/^\+[0-9]{8,}$/i', 'message' => 'wrong phone number'],
            [['timeZone'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'firstName' => 'First name',
            'lastName' => 'Last name',
            'email' => 'Email',
            'phoneNumber' => 'Phone Number',
            'timeZone' => 'Time Zone',
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function checkEmail($attribute, $params)
    {
        if ($this->email && $this->email != Yii::$app->user->identity->email) {
            $user = User::findByEmail($this->email);
            if ($user) {
                $this->addError($attribute, 'this email address has already been taken');
            }
        }
    }

    /**
     * @return bool
     */
    public function update()
    {
        $user = User::findOne(Yii::$app->user->id);

        if (!$user) {
            return false;
        }
        
        $user->first_name = $this->firstName;
        $user->last_name = $this->lastName;
        $user->email = $this->email;
        $user->phone_number = $this->phoneNumber;
        $user->time_zone = $this->timeZone;

        if ($user->save()) {
            return true;
        }

        return false;
    }
}
