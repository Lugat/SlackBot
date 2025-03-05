<?php

namespace app\components\slack\commands;

use Yii;

class TranslateCommand extends AbstractCommand implements CommandInterface
{

    public function execute(string $text): array|string
    {

        $x = '[a-z]{2}(-[a-z]{2})?';

        if (!preg_match("/^($x)(->($x))?\s(.*)/i", $text, $matches)) {
            return Yii::t('app', 'Target language missing!');
        }

        if (empty($matches[4])) {
            $targetLanguage = $matches[1];
        } else {
            $sourceLanguage = $matches[1];
            $targetLanguage = $matches[4];
        }

        $text = $matches[6];

        $translations = Yii::$app->translator->translate($text, $targetLanguage, $sourceLanguage ?? null);

        return array_map(
            fn($translation) => $translation['text'],
            $translations
        );

    }

}