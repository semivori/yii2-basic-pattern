<?php

namespace app\models\users\ar;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $phone_number
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $status_id
 * @property string $time_zone
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 * @property string $last_visit_at
 * @property string $password_reset_date
 * @property string $ip
 * @property string $ua
 *
 * @property string $full_name
 * @property string $short_full_name
 */

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_INACTIVE = -1;

    /**
     * @var string
     */
    public $full_name;

    /**
     * @var string
     */
    public $short_full_name;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->on(ActiveRecord::EVENT_BEFORE_INSERT, function($event) {

        });

        $this->on(ActiveRecord::EVENT_AFTER_INSERT, function($event) {

        });

        $this->on(ActiveRecord::EVENT_AFTER_FIND, function ($event) {

        });

        $this->on(ActiveRecord::EVENT_BEFORE_UPDATE, function ($event) {

        });


        $this->on(ActiveRecord::EVENT_AFTER_DELETE, function ($event) {

        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'email', 'first_name', 'last_name'], 'filter', 'filter' => 'trim'],
            [['email', 'username', 'first_name', 'last_name'], 'required', 'message' => 'enter a value for {attribute}'],
            [['email', 'first_name', 'last_name'], 'string', 'min' => 2, 'max' => 50, 'tooShort' => '{attribute} must be at least 2 symbols', 'tooLong' => '{attribute} must be not more than 50 symbols'],
            ['email', 'email', 'message' => 'enter a valid email'],
            ['password', 'string', 'min' => 6, 'max' => 100, 'tooShort' => '{attribute} must be at least 6 symbols', 'tooLong' => '{attribute} must be not more than 100 symbols'],
            [['status_id'], 'integer'],
            [['username', 'password_reset_token', 'auth_key'], 'string', 'max' => 128],
            [['ip', 'ua'], 'string', 'max' => 256],
            ['phone_number', 'match', 'pattern' => '/^\+[0-9]{8,}$/i', 'message' => 'wrong phone number'],
            [['created_at', 'updated_at', 'last_visit_at', 'password_reset_date', 'time_zone', 'avatar'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'username' => 'Username',
            'status_id' => 'Status',
            'created_at' => 'Date of registration',
            'updated_at' => 'Date of update',
            'last_visit_at' => 'Last activity',
            'password_reset_date' => 'Password reset date',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'password' => 'Password',
            'ip' => 'IP address',
            'ua' => 'Browser',
            'time_zone' => 'Time Zone',
            'avatar' => 'Avatar',
        ];
    }

    public function __toString() {
        return (string)$this->id;
    }
    
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    
    public static function findByPasswordResetToken($token)
    {
        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }
    
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }
    
    public function setPassword($password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }
    
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }
    
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = \Yii::$app->security->generateRandomString() . '_' . time();
        $this->password_reset_date = new Expression('NOW()');
    }
    
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
        $this->password_reset_date = null;
    }
    
    public static function getNewPassword()
    {
        return strtolower(substr(\Yii::$app->security->generateRandomString(), 0, 6));
    }

    /**
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_NOT_ACTIVE => 'Not activated',
        ];
    }

    /**
     * @return string
     */
    public function getConfirmAccountCode()
    {
        $code = md5($this->email);
        return $code;
    }

    /**
     * @return bool
     */
    public function isInactive()
    {
        return $this->status_id == self::STATUS_INACTIVE;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status_id == self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isNotActivated()
    {
        return $this->status_id == self::STATUS_NOT_ACTIVE;
    }
}
