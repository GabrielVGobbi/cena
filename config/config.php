<?php
require 'environment.php';

global $config;
$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://www2.cena.com.br/admin/");
	$config['dbname'] = 'cena';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL", "http://www.nasai.com.br/admin/");
	$config['dbname'] 	= 'landsolucoes';
	$config['host'] 	= 	'23.229.232.193';
	$config['dbuser'] 	= 'marcos_cena';
	$config['dbpass'] 	= '6y9eJtMAEZx2qqK';
}
?>