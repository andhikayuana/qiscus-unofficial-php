<?php

namespace Yuana\Api\Multichannel\V1;

use Yuana\Api\BaseApi;

class Api extends BaseApi
{
    public function ping()
    {
        return $this->get('/ping');
    }

    //TODO HERE
}