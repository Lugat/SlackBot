<?php

use app\components\chatGpt\ChatGpt;
use app\components\slack\Slack;
use app\components\slack\commands\UuidCommand;
use app\components\mistral\Mistral;
use app\components\slack\commands\JokeCommand;
use app\components\slack\commands\PasswordCommand;

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
                ]
            ]
        ],
        'chatGpt' => [
            'class' => ChatGpt::class,
            'baseUri' => 'https://api.openai.com/v1/',
            'model' => $_ENV['CHATGPT_MODEL'] ?? 'gpt-3.5-turbo',
            'apiKey' => $_ENV['CHATGPT_API_KEY']
        ],
        'mistral' => [
            'class' => Mistral::class,
            'baseUri' => 'https://api.mistral.ai/v1/',
            'model' => $_ENV['MISTRAL_MODEL'] ?? 'mistral-small-latest',
            'apiKey' => $_ENV['MISTRAL_API_KEY']
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'hyLBi22Vj_X-6wDKEzY_e6ZkdenPo7Ql',
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
