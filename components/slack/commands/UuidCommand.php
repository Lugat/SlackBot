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

        if (null !== $text && preg_match('/v\d/i', $text, $matches)) {
            $version = $matches[0];
        }

        if (!method_exists(Uuid::class, $version)) {
            return 'UUID Version not supported.';
        }

        $uuid = Uuid::$version();

        return [
            'Base32' => $uuid->toBase32(),
            'Base58' => $uuid->toBase58(),
            'Rfc4122' => $uuid->toRfc4122(),
            'Hex' => $uuid->toHex(),
            'String' => $uuid->toString(),
        ];
    }

}