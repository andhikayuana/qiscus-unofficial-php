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

 $qiscus = \Yuana\QiscusApi::create($config);

 $response = $qiscus->v21()->loginOrRegister([
    'user_id' => 'jarjit@spam4.me',
    'password' => 'jarjitsingh123!@#',
    'username' => 'jarjitsingh'
 ]);

var_dump($response);

echo '<br><br>';

$res = $qiscus->v21()->getUsers();

print_r($res->results->users[0]);

echo '<br><br>';

$res = $qiscus->v2()->createRoom('nama room', 'jarjit@spam4.me', []);

print_r($res);

echo '<br><br>';

$res = $qiscus->v2()->getUserRooms('arief92');

print_r($res);

echo '<br><br>';

$res = $qiscus->v2()->getRoomParticipants('8d412fdd3411f5f261f8f30e0f90ff60');

print_r($res);


echo '<br><br>';

$res = $qiscus->v21()->postComment('guest-101', '30275998', 'hello there');

$res = $qiscus->v2()->postComment('guest-101', '30275998', 'hai', 'text', [], ['key'=>'val']);

print_r($res);