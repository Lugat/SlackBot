<?php

use app\components\assistant\Mistral;
use app\components\assistant\PromptEvent;
use app\components\translator\Deepl;

$config = [
    'id' => 'slack',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'slack' => require __DIR__ . '/slack.php',
        'translator' => [
            'class' => Deepl::class,
            'apiKey' => $_ENV['DEEPL_API_KEY'],
        ],
        'assistant' => [
            //'class' => ChatGpt::class,
            'class' => Mistral::class,
            'apiKey' => $_ENV['MISTRAL_API_KEY'], 
            'on prompt' => function(PromptEvent $event) {

                $event->messages = array_merge([
                    ['role' => 'system', 'content' => 'You are a helpful and assistant.']
                ], $event->messages);
    
            }
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $_ENV['COOKIE_VALIDATION_KEY'],
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'team' => [
            'class' => 'app\components\auth\Team',
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => [],
        ],
        'queue' => require __DIR__ . '/queue.php',
        'db' => require __DIR__ . '/db.php',
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => require __DIR__ . '/params.php',
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
