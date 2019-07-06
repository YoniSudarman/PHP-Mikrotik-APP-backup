<?php
	ob_start();
	session_start();
	
	//1. Menyisipkan file config.php
	include("config.php");

	// 2. Mengambil parameter id dari querystring
	$id = $_GET['id'];
	
	// 3. Mengeksekusi perintah mikrotik CLI menggunakan method comm
	// dilakukan konversi perintah CLI mikrotik menjadi api
	// backup remove ? diubah menjadi /system/backup/remove
	$API->comm('/file/remove',array('.id'=>$id));
		
	header("location: files.php");
	