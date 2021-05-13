<?php

	if (isset($_SESSION["type"])){
		if (strcmp($_SESSION["type"], "student")==0){
			header("location: core/test/test.php");
		}elseif (strcmp($_SESSION["type"], "teacher")==0){
			header("location: core/dashboard/dashboard.php");
		}
	}
	header("location: login.php");
?>

