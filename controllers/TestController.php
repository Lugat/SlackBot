<?php

namespace app\controllers;

use Yii;
use yii\base\Event;
use yii\web\Controller;
use app\components\assistant\AbstractAssistant;
use app\components\assistant\PromptEvent;

class TestController extends Controller
{

    public function actionIndex()
    {

        Event::on(AbstractAssistant::class, AbstractAssistant::EVENT_PROMPT, function(PromptEvent $event) {

            $event->messages = array_merge([
                ['role' => 'system', 'content' => 'You are funny.']
            ], $event->messages); 

            $event->temperature = 1.5;

        });

        $dump = Yii::$app->assistant->prompt('Was ist die Antwort auf das Leben und alles?');

        print '<pre>';
        print_r($dump);
        exit();

    }
}