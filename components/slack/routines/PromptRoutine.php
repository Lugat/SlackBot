<?php

namespace app\components\slack\routines;

use Yii;
use yii\base\Component;

class PromptRoutine extends Component implements RoutineInterface
{

    public string $prompt;

    public function execute(): null|array|string
    {

        $response = Yii::$app->mistral->prompt($this->prompt);
        
        return array_map(
            fn($respons) => trim($respons['message']['content'], '"'),
            $response
        );
        
    }

}