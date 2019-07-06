<?php
	ob_start();
	session_start();
?>
<html>
<head>
<title>Mikrotik Login</title>
<link rel="stylesheet" type="text/css" href="abj.css">
<body>
<?php
	if (isset($_POST['btnconnect'])){
		$error = array();
		if (empty($_POST['txtConnectTo']))
		{
			$error[] = 'Connect To is required!';
		}

		if (empty($_POST['txtLogin']))
		{
			$error[] = 'Login is required!';
		}		

		if (empty($_POST['txtpassword']))
		{
			$error[] = 'Password is required!';
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
		{
			$connectto = $_POST['txtConnectTo'];
			$login = $_POST['txtLogin'];
			$password = $_POST['txtpassword'];
			
			include("routeros_api.class.php");
			$API = new RouterosAPI();

			if (!$API->connect($connectto, $login, $password)){
				echo "Koneksi ke Mikrotik gagal dilakukan!";
			}else{
				$_SESSION['hostname'] = $connectto;
				$_SESSION['username'] = $login;
				$_SESSION['password'] = $password;
				header('location: files.php');
			}
		}
	}
		
?>
<form name="frmlogin" method="post" action="index.php">
<fieldset>
<legend>Mikrotik Login</legend>
<label for="hostname">Connect to :</label> <br>
<input type="text" name="txtConnectTo" value="<?php if (isset($_POST['txtConnectTo'])) { echo $_POST['txtConnectTo']; } ?>"><br>
<label>Login :</label> <br>
<input type="text" name="txtLogin" value="<?php if (isset($_POST['txtLogin'])) { echo $_POST['txtLogin']; } ?>"><br>
<label>Password :</label> <br> 
<input type="password" name="txtpassword"><br>
<input type="submit" name="btnconnect" value="Login">
<input type="reset" name="btnreset" value="Reset">
</fieldset>
</form>
</body>
</head>
</html>
<?php
	ob_end_flush();
?>