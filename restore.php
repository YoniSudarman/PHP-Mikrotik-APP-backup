<?php
ob_start();
session_start();

include("config.php");
?>
<html>
<head>
	<title>Restore</title>
	<link rel="stylesheet" type="text/css" href="abj.css">
</head>
<body>
	<?php	
	$name=$_GET['name'];
	if (isset($_POST['btnsubmit'])){
		
			// mengambil inputan dari form
			$password = $_POST['txtpassword'];
			$old_name=$_POST['name'];			
			

			// Mengeksekusi perintah mikrotik CLI menggunakan method comm
			// dilakukan konversi perintah CLI mikrotik menjadi api
			// restore diubah menjadi /system/backup/load
			$result = $API->comm('/system/backup/load', array('name'=>$old_name, 'password'=>$password));
			
			if ($result) {
				echo '<font color="red"><b>Restore Failed!</b></font><br>';	
			}else{
				echo '<font color="green"><b>Restore Successfully!</b></font><br>';	
			}

	}
	
	?>
	<form name="frmrestore" method="post" action="restore.php?name=<?php echo $name ?>">
		<fieldset>
			<legend>Restore</legend>
			Password : <input type="text" name="txtpassword"><br>
			<input type="hidden" name="name" value="<?php echo $name; ?>">
			<input type="submit" name="btnsubmit" value="Submit">
			<input type="reset" name="btnreset" value="Reset">
		</fieldset>
	</form>
	<a href="files.php">files</a>
</body>
</html>
