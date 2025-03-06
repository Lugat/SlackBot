<?php

namespace app\components\slack\commands;

use Yii;
use yii\base\BaseObject;

abstract class AbstractCommand extends BaseObject
{

    public bool $inChannel = false;
    public ?string $permission = null;

    public function getResponseType(): ?string
    {
        return $this->inChannel ? 'in_channel' : null;
    }

    public function canExecute(): bool
    {

        if (null !== $this->permission) {
            return Yii::$app->user->can($this->permission);
        }

        return true;
    }

}