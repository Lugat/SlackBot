<?php

namespace app\components\slack\routines;

use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class VirtualCoffeeRoutine extends BaseObject implements RoutineInterface
{

    protected string $cacheKey;

    public function init()
    {

        parent::init();

        $this->cacheKey = get_called_class().'.'.Yii::$app->team->identity->id;

    }

    public function execute(): null|array|string
    {

        $users = $this->getActiveUsers();

        if (1 >= count($users)) {
            return null;
        }

        $groups = $this->createGroups($users);

        $groups = array_map(
            function($users) {

                switch (count($users)) {
                    case 3:
                        $last = array_pop($users);
                        return implode(', ', $users).' & '.$last;
                    default:
                        return implode(' & ', $users);
                }

            },
            $groups
        );

        return [
            'Es ist wieder Talky-Tuesday. Heute sprechen folgende Leute miteinander:',
            implode("\n", $groups)
        ];

    }

    protected function createGroups(array $users): array
    {

        shuffle($users);
        $groups = [];
        
        $groupHistory = Yii::$app->cache->get($this->cacheKey);
        if (false === $groupHistory) {
            $groupHistory = [];
        }
        
        while (count($users) > 1) {
            $found = false;
            
            for ($i = 1; $i < count($users); $i++) {

                $group = ArrayHelper::map([$users[0], $users[$i]], 'id', 'real_name');

                ksort($group);

                $userIds = array_keys($group);

                if (!in_array($userIds, $groupHistory)) {

                    $groups[] = array_values($group);
                    $groupHistory[] = $userIds;

                    array_splice($users, $i, 1);
                    array_splice($users, 0, 1);
                    
                    $found = true;
                    break;

                }

            }
            
            // all combinations are already taken, just match someone
            if (!$found) {

                $group = ArrayHelper::map(array_splice($users, 2), 'id', 'real_name');

                $groups[] = array_values($group);
                $groupHistory[] = array_keys($group);

            }

        }
        
        // add leftover user to last group
        if (count($users) === 1) {

            $i = count($groups) - 1;

            $additionalUser = array_shift($users);

            $groupHistory[$i][] = $additionalUser['id'];
            $groups[$i][] = $additionalUser['real_name'];

        }
        
        Yii::$app->cache->set($this->cacheKey, $groupHistory);
        
        return $groups;  

    }

    // @todo give user possibility to be not available
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