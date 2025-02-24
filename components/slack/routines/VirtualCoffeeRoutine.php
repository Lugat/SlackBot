<?php

namespace app\components\slack\routines;

use Yii;
use yii\base\BaseObject;

class VirtualCoffeeRoutine extends BaseObject implements RoutineInterface
{

    public function execute(): null|array|string
    {

        $users = $this->getActiveUsers();

    }

    protected function getActiveUsers(): array
    {

        $users = Yii::$app->slack->getUsers([
            'include_locale' => false
        ]);

        return array_filter(
            $users,
            function($user) {

                if ($user['deleted'] === true) {
                    return false;
                }

                return Yii::$app->slack->getUserPresence($user['id']) === 'active';
            }
        );

    }

}