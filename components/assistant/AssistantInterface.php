<?php

namespace app\components\assistant;

interface AssistantInterface
{
    public function prompt(string $prompt): array;
}
