<?php
error_reporting(E_ERROR);
//error_reporting(E_ALL);
$config = array (
    'memcached_servers' => array (
        array ('host' => '127.0.0.1', 'port' => 11211, 'weight' => 100),
    ),
    'pdo_config'      => array (
        'dsn'     => 'mysql:dbname=spider;host=127.0.0.1',
        'username' => 'root',
        'password' => '',
        'charset'  => 'utf8',
    ),
    'img_dir_prefix' => '/tmp/',
    'url_get_turns'        => 3,
);
