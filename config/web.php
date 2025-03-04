<?php

use app\components\slack\Slack;
use app\components\slack\commands\UuidCommand;
use app\components\slack\commands\JokeCommand;
use app\components\slack\commands\PasswordCommand;
use app\components\slack\commands\TranslateCommand;
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
        'slack' => [
            'class' => Slack::class,
            'baseUri' => 'https://slack.com/api/',
            'commands' => [
                '/uuid' => [
                    'class' => UuidCommand::class,
                    'version' => 7
                ],
                '/joke' => [
                    'class' => JokeCommand::class,
                ],
                '/password' => [
                    'class' => PasswordCommand::class,
                    'length' => 12
                ],
                '/translate' => [
                    'class' => TranslateCommand::class,
                ]
            ]
        ],
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
            'identityClass' => 'app\models\Team',
            'enableAutoLogin' => true,
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
