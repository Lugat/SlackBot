<?php

namespace app\components\translator;

interface TranslatorInterface
{
    public function translate(string $text, string $targetLanguage, ?string $sourceLanguage = null): array;
}
