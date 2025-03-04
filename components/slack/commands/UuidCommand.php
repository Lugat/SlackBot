<?php

namespace app\components\slack\commands;

use Symfony\Component\Uid\Uuid;
use yii\base\BaseObject;

class UuidCommand extends BaseObject implements CommandInterface
{

    public int $version;

    public function execute(string $text): array|string
    {

        $version = 'v'.$this->version;
        $n = 1;

        if (null !== $text && preg_match('/v\d/i', $text, $matches)) {
            $version = $matches[0];
        }

        if (null !== $text && preg_match('/x(\d{1,2})/i', $text, $matches)) {
            $n = (int) $matches[1];
        }

        if (!method_exists(Uuid::class, $version)) {
            return 'UUID Version not supported.';
        }

        $uuids = [];

        for ($i = 0; $i < $n; $i++) {
            $uuids[] = Uuid::$version()->toBase58();
        }
        
        return $uuids;
        
    }

}