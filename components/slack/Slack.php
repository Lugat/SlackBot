<?php

namespace app\components\slack;

use Yii;
use app\components\AbstractApi;
use app\components\slack\commands\CommandInterface;

class Slack extends AbstractApi
{
    public array $commands = [];

    public function getAuthorization(): ?string
    {

        if (null === Yii::$app->team->identity) {
            return null;
        }

        return 'Bearer '.Yii::$app->team->identity->bot_token;

    }

    public function sendMessage(string $channel, string|array $message, array $options = []): array
    {

        if (is_array($message)) {
            $message = implode("\n", $message);
        }

        return $this->request(self::POST, 'chat.postMessage', array_merge([
            'channel' => $channel,
            'text' => $message
        ], $options));

    }

    public function getReactions(string $channel, string $timestamp)
    {

        $response = $this->request(self::GET, 'reactions.get', [
            'channel' => $channel,
            'timestamp' => $timestamp
        ]);

        return $response['message']['reactions'] ?? [];

    }

    public function getUserPresence(string $userId): string
    {
        $response = $this->request(self::GET, 'users.getPresence', ['user' => $userId]);
        return $response['presence'] ?? 'unknown';
    }

    public function getUsers(array $params = []): array
    {
        $response = $this->request(self::GET, 'users.list', $params);
        return $response['members'] ?? [];
    }
    
    public function getCommand(string $command): ?CommandInterface
    {

        if (array_key_exists($command, $this->commands)) {
            // @todo merge with custom team config
            return Yii::createObject($this->commands[$command]);
        }
        
        return null;

    }

}
