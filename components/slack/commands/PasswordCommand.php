<?php

namespace app\components\slack\commands;

class PasswordCommand extends AbstractCommand
{

    public int $length;

    public function execute(?string $text): array|string
    {

        if (preg_match('/(\d+)/', $text, $matches)) {
            $this->length = $matches[1];
        }

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+<>?';
        $charLen = strlen($characters);
        $password = '';

        for ($i = 0; $i < $this->length; $i++) {
            $password .= $characters[random_int(0, $charLen - 1)];
        }

        return $password;

    }

}