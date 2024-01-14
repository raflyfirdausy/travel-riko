<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = [
	'dsn'			=> '',
	'hostname' 		=> env("DB_HOSTNAME"),
	'port' 			=> env("DB_PORT"),
	'username' 		=> env("DB_USERNAME"),
	'password' 		=> env("DB_PASSWORD"),
	'database' 		=> env("DB_NAME"),
	'dbdriver' 		=> env("DB_DRIVER"),
	'dbprefix' 		=> '',
	'pconnect' 		=> FALSE,
	'db_debug' 		=> TRUE,
	'cache_on' 		=> FALSE,
	'cachedir' 		=> '',
	'char_set' 		=> 'utf8',
	'dbcollat' 		=> 'utf8_general_ci',
	'swap_pre' 		=> '',
	'encrypt' 		=> FALSE,
	'compress' 		=> FALSE,
	'stricton' 		=> FALSE,
	'failover' 		=> [],
	'save_queries' 	=> TRUE,
];
