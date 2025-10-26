<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $source = $_SERVER['HTTP_X_FORWARDED_HOST'];
} else {
    $source = $_SERVER['HTTP_HOST'];
}
$databaseName = explode(".", $source)[0];

if (empty($databaseName)) {
    $databaseName = "";
}

$db['default'] = array(
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => $databaseName,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

include 'inc_db.php';
