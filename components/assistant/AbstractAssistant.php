<?php

namespace app\components\assistant;

use app\components\AbstractApi;

abstract class AbstractAssistant extends AbstractApi
{
    public string $apiKey;
    public string $model;
    public float $temperature; 

    public function getBearer(): string
    {
        return $this->apiKey;
    }

    public function prompt(string $prompt): array
    {

        $response = $this->request(self::POST, 'chat/completions', [
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => $this->temperature
        ]);

        return $response['choices'] ?? [];
        
    }

}