<?php

namespace App\Schedules;

use App\Services\SlackApi;

class OneOnOneSchedule extends AbstractSchedule
{

    protected string $file;

    public function __construct()
    {
        parent::__construct();
        $this->file = __DIR__.'/../../data/one-on-one.json';
    }

    public function execute(): void
    {

        $users = $this->getUsers();

        if (1 >= count($users)) {
            return;
        }

        $groups = $this->createGroups($users);

        $groups = array_map(
            function($names) {

                switch (count($names)) {
                    case 3:
                        $last = array_pop($names);
                        return implode(', ', $names).' und '.$last;
                    default:
                        return implode(' und ', $names);
                }

            },
            $groups
        );
        
        SlackApi::getInstance()->sendMessage('#allgemein', [
            'Es ist wieder Talky-Tuesday. Heute sprechen folgende Leute miteinander:',
            implode("\n", $groups)
        ]);

    }

    protected function loadPastGroups(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }
        $content = file_get_contents($this->file);
        return json_decode($content, true) ?: [];

    }

    protected function saveGroups(array $groups): void
    {
        file_put_contents($this->file, json_encode($groups, JSON_PRETTY_PRINT));
    }

    protected function createGroups(array $users): array
    {

        shuffle($users);
        $groups = [];
        
        $pastGroups = $this->loadPastGroups();
        
        while (count($users) > 1) {
            $found = false;
            
            for ($i = 1; $i < count($users); $i++) {
                $group = [$users[0], $users[$i]];
                sort($group);
                
                if (!in_array($group, $pastGroups)) {
                    $groups[] = $group;
                    array_splice($users, $i, 1);
                    array_splice($users, 0, 1);
                    $pastGroups[] = $group;
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $groups[] = [array_shift($users), array_shift($users)];
            }
        }
        
        if (count($users) == 1) {
            $groups[count($groups) - 1][] = array_shift($users);
        }
        
        $this->saveGroups($pastGroups);
        
        return $groups;  

    }

    protected function getUsers()
    {

        $slackApi = SlackApi::getInstance();

        $users = $slackApi->getUsers([
            'include_locale' => false
        ]);

        return array_map(
            fn($user) => $user['real_name'] ?? $user['name'],
            array_filter(
                $users,
                function($user) use($slackApi) {

                    if ($user['deleted'] === true) {
                        return false;
                    }

                    return $slackApi->getUserPresence($user['id']) === 'active';
                }
            )
        );
        
    }
}