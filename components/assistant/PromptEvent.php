<?php

namespace app\components\assistant;

use yii\base\Event;

class PromptEvent extends Event
{
    public array $messages;
}