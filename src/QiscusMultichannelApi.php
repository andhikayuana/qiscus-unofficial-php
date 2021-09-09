<?php

namespace Yuana;

use Yuana\Api\Multichannel\{
    V1\Api as ApiV1
};

class QiscusMultichannelApi
{
    private $config = [];
    private $client;
    private $apiV1;

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

        $this->ApiV1 = new ApiV1($this->client);
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

        if (empty($config['qiscus_agent_id'])) {
            throw new \Exception("Please setup qiscus_agent_id first");
        }
    
        return new self($config);
    }

    public function v1()
    {
        return $this->ApiV1;
    }

}
