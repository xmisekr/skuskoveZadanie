<?php

	include_once ("/home/xpolakovam/public_html/skuskoveZadanieWT2/path.php");
	require_once ROOT_PATH . '/config.php';
class ConnectionFactory{
    
    public function __construct(){}

    public function createConnection(){
        $config = new Configuration();
        
        $connection = new MySQLi($config->hostname, $config->username, $config->password, $config->databaseName);

        if ($connection->connect_error){
            die("Connection not estabilished: " . $connection->connect_error);
        }

        return $connection;
    }
}
?>