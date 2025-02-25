<?php

namespace app\components\assistant;

class ChatGpt extends AbstractAssistant implements AssistantInterface
{

    public string $baseUri = 'https://api.openai.com/v1/';
    public string $model = 'pt-3.5-turbo';

}