<?php

namespace Yuana\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class BaseApi 
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function post($path, $params = [])
    {
        try {
            $response = $this->client->post($path, $params);
            return $this->parseResponse($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function get($path, $params = [])
    {
        try {
            $response = $this->client->get($path, $params);
            return $this->parseResponse($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($path, $params = [])
    {
        try {
            $response = $this->client->delete($path, $params);
            return $this->parseResponse($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function parseResponse(Response $response)
    {
        $body = (string) $response->getBody();
        $result = json_decode($body);
        return $result ?? $body;
    }


}