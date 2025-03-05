<?php

namespace app\components\slack\commands;

class AdminCommand extends AbstractCommand
{

    public function execute(string $text): array|string
    {
        return 'Du bist Admin!';
    }

}