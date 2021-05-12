<?php


	class Database{

		public $conn = null;

		public function createConnectioon(){
			require(""); //TODO add db path
			try {
				$this->conn = new PDO("mysql:host=$servername;dbname=exam", $username, $password);
				// set the PDO error mode to exception
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//echo "Connected successfully";
				//echo "<br>";

				return $this->conn;
			} catch (PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
			}
		}
	}
	?>