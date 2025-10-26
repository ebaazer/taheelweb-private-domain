<?php

/* 	
 * 	@author 	: taheelweb
 *      date		: 20/03/2023  
 *      MANAGE Include Databases
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

$is_div = 0;

if ($is_div == 1) {
    $db['operating_system'] = array(
        'dsn' => '',
        'hostname' => 'db',
        'username' => 'root',
        'password' => 'rootpass',
        'database' => 'operating_system',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => TRUE,
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

    $db['curriculum_scale'] = array(
        'dsn' => '',
        'hostname' => 'db',
        'username' => 'root',
        'password' => 'rootpass',
        'database' => 'curriculum_scale',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => TRUE,
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
} else {
    $db['operating_system'] = array(
        'dsn' => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'operating_system',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => TRUE,
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

    $db['curriculum_scale'] = array(
        'dsn' => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'curriculum_scale',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => TRUE,
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
}