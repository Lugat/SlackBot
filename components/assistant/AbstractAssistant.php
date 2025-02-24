<?php

namespace app\components\assistant;

use app\components\AbstractApi;

abstract class AbstractAssistant extends AbstractApi
{
    public string $apiKey;
    public string $model;
    public float $temperature; 

    const EVENT_PROMPT = 'prompt';

    public function getBearer(): string
    {
        return $this->apiKey;
    }

    public function prompt(string $prompt, ?float $termperature = null): array
    {

        $event = new PromptEvent([
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        $this->trigger(self::EVENT_PROMPT, $event);

        $response = $this->request(self::POST, 'chat/completions', [
            'model' => $this->model,
            'messages' => $event->messages,
            'temperature' => $termperature ?? $this->temperature
        ]);

        return $response['choices'] ?? [];
        
    }

}