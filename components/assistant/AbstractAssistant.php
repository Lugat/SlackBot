<?php

namespace app\components\assistant;

use app\components\AbstractApi;

abstract class AbstractAssistant extends AbstractApi
{
    public string $apiKey;
    public string $model;
    public float $temperature = .7; 

    const EVENT_PROMPT = 'prompt';

    public function getBearer(): string
    {
        return $this->apiKey;
    }

    public function prompt(string $prompt, ?float $temperature = null): array
    {

        $event = new PromptEvent([
            'model' => $this->model,
            'temperature' => $temperature ?? $this->temperature,
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        $this->trigger(self::EVENT_PROMPT, $event);

        $response = $this->request(self::POST, 'chat/completions', [
            'model' => $event->model,
            'messages' => $event->messages,
            'temperature' => $event->temperature
        ]);

        return $response['choices'] ?? [];
        
    }

}