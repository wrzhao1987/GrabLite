<?php
include 'config.ini.php';
include 'database.ini.php';
include 'GrabImage.class.php';
include 'GrabUrl.class.php';

/**
* CREATE DATABASE
**/
$create_sql =
    "
    CREATE DATABASE IF NOT EXISTS spider;
    CREATE TABLE IF NOT EXISTS url_queue(
        id INT(10) NOT NULL AUTO_INCREMENT,
        url_hash CHAR(32) NOT NULL,
        url_content VARCHAR(255) NOT NULL DEFAULT '',
        status TINYINT(1) NOT NULL DEFAULT 0,
        add_time TIMESTAMP NOT NULLULL DEFAULT CURRENT_TIMESTAMP,
        update_time TIMESTAMP NOT NULL DEFAULT  CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY(`id`),
        UNIQUE KEY(`url_hash`),
        KEY `hash_status` (`url_hash`, `status`)
    )ENGINE=ENGINEInnoDB DEFAULT CHARSET=utf8;
    ";
$db = My_MySQL::getInstance();
$db->connection->exec($create_sql);
echo "Database Initialized.\n";

/**
*    DO FETCH
**/
$url = substr($argv[1], 0, 4) == 'http' ? $argv[1] : 'http://' . $argv[1];
$turns = isset ($argv[2]) ? intval ($argv[2]) : '';

$fetcher = new GrabUrl();
$fetcher->fetch(array($url), $turns);
