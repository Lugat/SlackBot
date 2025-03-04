<?php

namespace app\components\translator;

class Deepl extends AbstractTranslator implements TranslatorInterface
{

    public string $baseUri = 'https://api-free.deepl.com/v2/';

    public function getAuthorization(): string
    {
        return "DeepL-Auth-Key {$this->apiKey}";
    }

    public function translate(string $text, string $targetLanguage, ?string $sourceLanguage = null): array
    {

        $response = $this->request(self::POST, 'translate', array_filter([
            'text' => [$text],
            'source_lang' => $sourceLanguage,
            'target_lang' => $targetLanguage
        ]));
        
        return $response['translations'] ?? [];

    }

}