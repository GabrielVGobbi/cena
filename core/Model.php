<?php
class Model {
	
	protected $db;

	public function __construct() {
		global $config;
		
		$this->db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
		$this->db->query("SET TIME_ZONE = '-03:00'");
		$this->db->exec("SET CHARACTER SET utf8");
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		date_default_timezone_set('America/Sao_Paulo');
	}

}
?>