<?php

namespace app\components\slack\commands;

use Yii;

class AskCommand extends AbstractCommand implements CommandInterface
{

    public function execute(string $question): array|string
    {

        $response = Yii::$app->assistant->prompt($question);
        
        return array_map(
            fn($respons) => trim($respons['message']['content'], '"'),
            $response
        );

    }

}