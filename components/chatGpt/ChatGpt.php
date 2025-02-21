<?php

namespace app\components\chatGpt;

use app\components\AbstractApi;

class ChatGpt extends AbstractApi
{
    public string $baseUri;
    public string $apiKey;
    public string $model;

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
            'temperature' => .7
        ]);

        return $response['choices'] ?? [];
        
    }
}
