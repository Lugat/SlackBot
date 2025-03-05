<?php

namespace app\components\slack\commands;

class JokeCommand extends AbstractCommand implements CommandInterface
{

    public function execute(string $text): array|string
    {
        return json_decode(file_get_contents('https://witzapi.de/api/joke'))[0]->text;
    }

}