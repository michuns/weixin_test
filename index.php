<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/19
 * Time: 15:47
 */

//require_once 'autoload.php';
include  'src/wxapi.php';
include  'src/HttpCurl.php';

$config = [
    'app_id' => 'wxf584b571fce44bc8',
    'app_secret' => 'd4624c36b6795d1d99dcf0547af5443d'
];
$api = new \wxchat\wxapi($config);
$token = $api->getAccessToken();
var_dump($token);
