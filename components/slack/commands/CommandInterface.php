<?php

namespace app\components\slack\commands;

abstract class CommandInterface
{
    
    abstract public function execute(?string $text): array|string;

}