<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Routine;

class RoutineController extends Controller
{
    
    public function actionIndex()
    {

        $routines = Routine::find()->andWhere(['active' => 1])->all();
        foreach ($routines as $routine) {

            if (true === $routine->isDue) {
                $routine->execute();
            }

        }

    }

}