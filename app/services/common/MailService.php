<?php

namespace app\services\common;

use Yii;
use app\models\users\ar\User;
use app\services\common\QueueService;
use app\models\common\ar\Queue;

/**
 * Class MailService
 * @package app\services\common
 */
class MailService
{
    /** @var User */
    protected $user;

    /**
     * Mail constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Registration email
     */
    public function register()
    {
        $title = 'You have registered on ' . Yii::$app->name . '.';
        $view = "@app/mail/users/register";
        $params = [
            "title" => $title,
            "user" => $this->user,
        ];
        $htmlMessage = Yii::$app->controller->renderPartial($view, $params);

        $m = Yii::$app->mailer->compose($view, $params)
            ->setTo($this->user->email)
            ->setFrom([Yii::$app->params['mail']['from'] => Yii::$app->name])
            ->setSubject($title);

        $qService = new QueueService();
        $qService->add(Queue::USER__REGISTER, $this->user, [
            'email' => $this->user->email,
            'subject' => $title,
            'html_message' => $htmlMessage,
            'mail_object' => serialize($m),
        ]);
    }

    /**
     * Reset password email
     */
    public function reset()
    {
        $title = 'You have requested a password restoring on ' . Yii::$app->name . '.';
        $view = "@app/mail/users/restore";
        $params = [
            "title" => $title,
            "user" => $this->user,
        ];
        $htmlMessage = Yii::$app->controller->renderPartial($view, $params);

        $m = Yii::$app->mailer->compose($view, $params)
            ->setTo($this->user->email)
            ->setFrom([Yii::$app->params['mail']['from'] => Yii::$app->name])
            ->setSubject($title);

        $qService = new QueueService();
        $qService->add(Queue::USER__RESET_PASSWORD, $this->user, [
            'email' => $this->user->email,
            'subject' => $title,
            'html_message' => $htmlMessage,
            'mail_object' => serialize($m),
        ]);
    }

    /**
     * Password changed email
     * @param string $password
     */
    public function passwordChanged($password)
    {
        $title = 'Your password has been changed.';
        $view = "@app/mail/users/password_changed";
        $params = [
            "title" => $title,
            "user" => $this->user,
            "password" => $password,
        ];
        $htmlMessage = Yii::$app->controller->renderPartial($view, $params);

        $m = Yii::$app->mailer->compose($view, $params)
            ->setTo($this->user->email)
            ->setFrom([Yii::$app->params['mail']['from'] => Yii::$app->name])
            ->setSubject($title);

        $qService = new QueueService();
        $qService->add(Queue::USER__PASSWORD_CHANGE, $this->user, [
            'email' => $this->user->email,
            'subject' => $title,
            'html_message' => $htmlMessage,
            'mail_object' => serialize($m),
        ]);
    }
}
