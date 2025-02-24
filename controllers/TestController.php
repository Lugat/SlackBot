<?php

namespace app\controllers;

use Yii; 
use yii\web\Controller;
use yii\base\Event;
use app\components\assistant\AbstractAssistant;

class TestController extends Controller
{

    public function actionIndex()
    {

        Event::on(AbstractAssistant::class, AbstractAssistant::EVENT_PROMPT, function($event) {
            
            $event->messages = array_merge([
                ['role' => 'system', 'content' => 'You are a helpful assistant.']
            ], $event->messages);

        });

        $dump = Yii::$app->assistant->prompt('Schreib mir einen kurzen witzigen Satz an das Team, dass wir gleich mit unserem Trainer Vlady dem Frühsport anfangen');

        print '<pre>';
        print_r($dump);
        exit();

    }
}