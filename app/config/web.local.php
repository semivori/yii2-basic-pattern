<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'name' => 'Test',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'onlineManager'],
    'timeZone' => 'UTC',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [

    ],
    'components' => [
        /**
         * @see https://www.yiiframework.com/doc/guide/2.0/en/output-theming
         */
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/bootstrap4/views',
                    '@app/modules' => '@app/themes/bootstrap4/views/modules',
                    '@app/widgets' => '@app/themes/bootstrap4/views/widgets',

                ],
                'basePath' => '@app/themes/bootstrap4',
                'baseUrl' => '@web/themes/bootstrap4',
            ],
        ],
        'formatter' => [
            'class'    => 'yii\i18n\Formatter',
            'timeZone' => 'UTC',
            'nullDisplay' => '-',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'onlineManager' => [
            'class' => 'app\components\user\OnlineManager',
        ],
        'request' => [
            'cookieValidationKey' => 'ANZTZGMYsShf0-_kZLIzS6IX7CZoi6tE',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\users\ar\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Site Controller
                '/' => 'site/index',
                '<alias:about|contact|terms>' => 'site/<alias>',

                // Other rules
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,

    'on beforeRequest' => function () {

        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->time_zone) {
                Yii::$app->setTimeZone(Yii::$app->user->identity->time_zone);
                Yii::$app->formatter->timeZone = Yii::$app->user->identity->time_zone;
            }
        }

    },


];

if (YII_ENV_DEV) {
    // mailer:
    $config['components']['mailer'] = [
        'class' => 'yii\swiftmailer\Mailer',
        'useFileTransport' => true,
    ];

    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
} else {
    // mailer:
    $config['components']['mailer'] = [
        'class' => 'yii\swiftmailer\Mailer',
        'useFileTransport' => false,
        'transport' => [
            'class' => 'Swift_MailTransport',
        ]
    ];
}

return $config;
