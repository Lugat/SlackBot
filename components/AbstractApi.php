<?php

namespace app\components;

use yii\base\Component;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

abstract class AbstractApi extends Component
{

    protected ?Client $client = null;

    const POST = 'POST';
    const GET = 'GET';

    public string $baseUri;

    public function init()
    {

        $bearer = $this->getBearer();

        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Authorization' => "Bearer {$bearer}",
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    abstract function getBearer(): string;

    public function request(string $method, string $endpoint, array $params = [], array $options = []): array
    {
        
        try {
            if (!empty($params)) {

                if (self::GET === $method) {
                    $options['query'] = $params;
                } elseif (self::POST === $method) {
                    $options['json'] = $params;
                }

            }

            $response = $this->client->request($method, $endpoint, $options);
            return json_decode($response->getBody()->getContents(), true);

        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }

}
