<?php
	if ((!isset($_SESSION['hostname']))|| (!isset($_SESSION['username'])) || (!isset($_SESSION['password']))){
		header("location: index.php");
	}else{
		include("routeros_api.class.php");

		$API = new RouterosAPI();

		if (!$API->connect($_SESSION['hostname'], $_SESSION['username'], $_SESSION['password'])){
			echo "Connection to Mikrotik Failed!";
		}
	}