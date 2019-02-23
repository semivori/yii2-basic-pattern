<?php
namespace app\components\user;

use Yii;
use yii\db\Expression;
use yii\base\BootstrapInterface;
use yii\base\Component;
use app\modules\user\models\User;

/**
 * Class OnlineManager
 * Component for updating online status of users.
 * @package app\components
 */
class OnlineManager extends Component implements BootstrapInterface
{
    /**
     * Bootstrap method for current component
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        if (!Yii::$app->user->isGuest) {
            $u = User::findOne(Yii::$app->user->id);

            if ($u) {
                $u->last_visit_at = new Expression('NOW()');
                $u->ip = Yii::$app->request->getUserIP();
                $u->ua = Yii::$app->request->getUserAgent();
                $u->save();
            }
        }

        return;
    }
}
