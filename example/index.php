<?php

/**
 * this is example how to use QiscusApi
 */

 //TODO
 require __DIR__ . '/../vendor/autoload.php';

$config = [
    'qiscus_base_url' => 'https://api3.qiscus.com',
    'qiscus_app_id' => 'sdksample',
    'qiscus_secret_key' => '2820ae9dfc5362f7f3a10381fb89afc7',
];

 $sdk = \Yuana\QiscusSdkApi::create($config);

 $response = $sdk->v21()->loginOrRegister([
    'user_id' => 'jarjit@spam4.me',
    'password' => 'jarjitsingh123!@#',
    'username' => 'jarjitsingh'
 ]);

var_dump($response);

echo '<br><br>';

$res = $sdk->v21()->getUsers();

print_r($res->results->users[0]);

echo '<br><br>';

$res = $sdk->v2()->createRoom('nama room', 'jarjit@spam4.me', []);

print_r($res);

echo '<br><br>';

$res = $sdk->v2()->getUserRooms('arief92');

print_r($res);

echo '<br><br>';

$res = $sdk->v2()->getRoomParticipants('8d412fdd3411f5f261f8f30e0f90ff60');

print_r($res);


echo '<br><br>';

$res = $sdk->v21()->postComment('guest-101', '30275998', 'hello there');

$res = $sdk->v2()->postComment('guest-101', '30275998', 'hai', 'text', [], ['key'=>'val']);

print_r($res);


echo '<hr>';

$config = [
    'qiscus_base_url' => 'https://multichannel-indonesia-test.qiscus.com',
    'qiscus_app_id' => 'yst-bh3qrqekvmgn4db67',
    'qiscus_secret_key' => '89a7f870d84ad0c2c61c63ca15b7d1ba',
    'qiscus_agent_id' => 'yst-bh3qrqekvmgn4db67_admin@qismo.com'
];

$mc = \Yuana\QiscusMultichannelApi::create($config);

print_r($mc->v1()->ping());
