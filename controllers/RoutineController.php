<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Routine;

class RoutineController extends Controller
{

    public function actionIndex()
    {

        $routines = Routine::find()->all();
        foreach ($routines as $routine) {

            if (true === $routine->isDue) {
                $routine->execute(false);
            }

        }

    }
}