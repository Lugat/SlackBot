<?php

namespace app\components\slack\commands;

use yii\base\BaseObject;

class AbstractCommand extends BaseObject
{

    public bool $inChannel = false;

    public function getResponseType(): ?string
    {
        return $this->inChannel ? 'in_channel' : null;
    }

}