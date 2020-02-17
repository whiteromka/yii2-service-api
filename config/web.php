<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'A_ZrvOMWso92yvAg5MdxmeqdAjKKRF_e',
            'baseUrl'=>'',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            "enableSession" => false
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
                    'c' => 'site/contact',
                    'l' => 'site/login',
                    'a' => 'site/about',
                    [ // пользаки
                        'class' => 'yii\rest\UrlRule',
                        'controller' => 'api/user',
                        'pluralize' => false,
                    ],

                    [ // заказы
                        'class' => 'yii\rest\UrlRule',
                        'controller' => 'api/order',
                        'pluralize' => false,
                    ],
                    [
                        'pattern' => 'api/order/done',
                        'route' => 'api/order/done',
                        'verb' => 'POST'
                    ],
                    [
                        'pattern' => 'api/order/create',
                        'route' => 'api/order/create',
                        'verb' => 'POST'
                    ],

                    [ // заявки
                        'class' => 'yii\rest\UrlRule',
                        'controller' => 'api/offer',
                        'pluralize' => false,
                    ],
                    [
                        'pattern' => 'api/offer/cancel',
                        'route' => 'api/offer/cancel',
                        'verb' => 'POST'
                    ],
                    [
                        'pattern' => 'api/offer/confirm',
                        'route' => 'api/offer/confirm',
                        'verb' => 'POST'
                    ],


            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
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
}

return $config;