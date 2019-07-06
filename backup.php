<?php
ob_start();
session_start();
include("config.php");
?>
<html>
<script src="jquery-1.8.1.min.js"></script>
<head>
	<title>Backup</title>
	<link rel="stylesheet" type="text/css" href="abj.css">
</head>

<body>
	<?php	
	// jika tombol submit ditekan
	if (isset($_POST['btnsubmit'])){

		/*$error = array();
		if (empty($_POST['txtname']))
		{
			$error[] = 'name is required!';
		}

		if (empty($_POST['txtpassword']))
		{
			$error[] = 'password is required!';
		}

		if (empty($_POST['lstencryption']) || $_POST['lstencryption'] == '')
		{
			$error[] = 'encryption is required!';
		}		

		if (count($error) > 0)
		{
			echo "<ul>";
			foreach ($error as $data)
			{
				echo "<li>$data</li>";
			}
			echo "</ul>";
		}
		else
		{*/
		
			// Mengeksekusi perintah mikrotik CLI menggunakan method comm
			// dilakukan konversi perintah CLI mikrotik menjadi api
			// backup name diubah menjadi /system/backup/save

		$centang=$_POST['cekbox'];

			if($centang=='yes'){
				$name = $_POST['txtname'];
				$dontencrypt = 'yes';
				$result = $API->comm('/system/backup/save', array('name'=>$name, 'dont-encrypt'=>$dontencrypt));

				echo "Name : $name<br>";
				echo "Encryption : no <br>";
			}else{
				$name = $_POST ['txtname'];
				$password = $_POST ['txtpassword'];
				$encryption = $_POST ['lstencryption'];
				$result = $API->comm('/system/backup/save', array('name'=>$name, 'password'=>$password, 'encryption'=>$encryption));

				echo "Name : $name<br>";
			//echo "password : $password<br>";
				echo "Encryption : $encryption<br>";
				echo "Dont Encrypt: no <br>";
			}


			// Pesan sukses
			
			if (is_array($result) && array_key_exists('!trap',$result)){
				
				echo '<font color="red"><b>Backup failed to save!</b></font><br>';	
			}else{
				echo '<font color="green"><b>Backup saved successfully!</b></font><br>';	
			}
		}
	//}
	?>
	<form name="frmbackup" method="post" action="backup.php">
		<fieldset>
			<legend>Backup</legend>
			<label>name :</label><br>  
			<input type="text" name="txtname" value="<?php if (isset($_POST['txtname'])) { echo $_POST['txtname']; } ?>"><br>
			<label>password :</label><br> 
			<input type="text" name="txtpassword" id="txtpassword" value="<?php if (isset($_POST['txtpassword'])) { echo $_POST['txtpassword']; } ?>"><br>
			<label>encryption :</label><br> 
			<?php
			echo '<select name="lstencryption" id="lstencryption">';
			echo '<option value="">Choose...</option>';
			echo '<option value="aes-sha256">aes-sha256</option>';
			echo '<option value="rc4">rc4</option>';
			echo '</select>';
			?><br>

			<label>
				<input type="checkbox" name="chkdontencrypt" id="chkdontencrypt" value="noncek"/> don't encrypt
			</label>
			<input type="hidden" name="cekbox" id="cekbox" value="no">

			<br><input type="submit" name="btnsubmit" value="Submit">
			<input type="reset" name="btnreset" value="Reset">
		</fieldset>
	</form>
	<a href="files.php">Files</a>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#chkdontencrypt").click(function(){
				$("#chkdontencrypt").val();

				if ($("#chkdontencrypt").is(":checked")) {
					$("#txtpassword").prop("disabled", true);
					$("#lstencryption").prop("disabled", true);
					$("#txtpassword").val('');
					$("#cekbox").val('yes');
				}
				else{
					$("#txtpassword").prop("disabled", false);
					$("#lstencryption").prop("disabled", false);
					$("#cekbox").val('no');
				}
			});
		});
	</script>
</body>
</html>
