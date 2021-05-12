<?php

include_once '/home/xhudaks/public_html/skuska/skuskoveZadanie/path.php';
include_once ROOT_PATH . '/connection/ConnectionFactory.php';

class Repository{
    protected $connection;

    public function __construct(){
        $connectionFactory = new ConnectionFactory();
        $this->connection = $connectionFactory->createConnection();
    }

    public function __destruct(){
        $this->connection->close();

    }
}

?>