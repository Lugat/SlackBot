<?php

namespace app\components\slack\commands;

interface CommandInterface
{
    public function execute(string $text): array|string;
}