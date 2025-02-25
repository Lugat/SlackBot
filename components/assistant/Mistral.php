<?php


namespace app\components\assistant;

class Mistral extends AbstractAssistant implements AssistantInterface
{

    public string $baseUri = 'https://api.mistral.ai/v1/';
    public string $model = 'mistral-small-latest';

}