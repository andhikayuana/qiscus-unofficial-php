<?php

namespace Yuana;

use Yuana\Api\Sdk\{
    V2\Api as ApiV2,
    V21\Api as ApiV21
};

class QiscusSdkApi
{
    private $config = [];
    private $client;
    private $apiV2;
    private $ApiV21;

    private function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->config['qiscus_base_url'],
            'headers' => [
                'QISCUS_SDK_APP_ID' => $this->config['qiscus_app_id'],
                'QISCUS_SDK_SECRET' => $this->config['qiscus_secret_key']
            ]
        ]);

        $this->ApiV2 = new ApiV2($this->client);
        $this->ApiV21 = new ApiV21($this->client);
    }

    public static function create(array $config)
    {
        if (empty($config['qiscus_base_url'])) {
            throw new \Exception("Please setup qiscus_base_url first");
        }

        if (empty($config['qiscus_app_id'])) {
            throw new \Exception("Please setup qiscus_app_id first");
        }

        if (empty($config['qiscus_secret_key'])) {
            throw new \Exception("Please setup qiscus_secret_key first");
        }
    
        return new self($config);
    }

    public function v2()
    {
        return $this->ApiV2;
    }

    public function v21()
    {
        return $this->ApiV21;
    }
}
