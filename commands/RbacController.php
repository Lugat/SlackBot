<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    public function actionIndex()
    {

        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $admin = $auth->createRole('admin');

        $auth->add($admin);

        foreach (Yii::$app->slack->commands as $command => $config) {

            $command = Yii::$app->slack->getCommand($command);
            if (null !== $command->permission) {

                $permission = $auth->createPermission($command->permission);

                $auth->add($permission);
                $auth->addChild($admin, $permission);

            }

        }

    }

}