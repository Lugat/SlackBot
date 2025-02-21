<?php

namespace app\components\slack\routines;

use Yii;
use app\models\User;

class BirthdayRoutine implements RoutineInterface
{

    public function execute(): null|array|string
    {

        $users = User::find()->where([
            'team_id' => Yii::$app->user->identity->id,
        ])->andWhere(['LIKE', 'birthdate', date('%-m-d'), false])->all();

        if (empty($users)) {
            return null;
        }
        
        $names = array_map(
            fn(User $user) => $user->name,
            $users
        );

        $n = count($users);

        $last = array_pop($names);
        $names = implode(', ', $names).' und '.$last;

        return Yii::t('app', 'Heute {n,plural,=1{hat {name} Geburtstag. Happy Birthday!} other{haben {names} Geburtstag. Happy Birthday!}}!', [
            'n' => $n,
            'name' => $last,
            'names' => $names
        ]);

    }

}