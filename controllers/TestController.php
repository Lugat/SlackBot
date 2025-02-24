<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {

        $dump = Yii::$app->mistral->prompt('Schreib mir einen kurzen witzigen Satz an das Team, dass wir gleich mit unserem Trainer Vlady dem Frühsport anfangen');

        print '<pre>';
        print_r($dump);
        exit();

    }
}