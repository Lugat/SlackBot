<?php

return [
    'class' => 'app\components\slack\Slack',
    'baseUri' => 'https://slack.com/api/',
    'commands' => [
        '/uuid' => [
            'class' => 'app\components\slack\commands\UuidCommand',
            'version' => 7
        ],
        '/joke' => [
            'class' => 'app\components\slack\commands\JokeCommand',
        ],
        '/password' => [
            'class' => 'app\components\slack\commands\PasswordCommand',
            'length' => 12
        ],
        '/translate' => [
            'class' => 'app\components\slack\commands\TranslateCommand',
        ],
        '/ask' => [
            'class' => 'app\components\slack\commands\AskCommand',
        ],
    ]
];