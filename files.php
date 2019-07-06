<?php
	ob_start();
	session_start();
	include('config.php');
?>
<html>
<head>
<title>Mikrotik Backup & Restore</title>
<link rel="stylesheet" type="text/css" href="abj.css">
</head>
<body>
<?php
	echo "<b>Mikrotik Session</b> [ Hostname : ".$_SESSION['hostname']." | ";
	echo "Username : ".$_SESSION['username']." | ";
	echo '<a href="logout.php">Logout</a> ]';
	
	echo '<hr>';
	
	$results = $API->comm('/file/getall', array("?type"=>"backup"));
	
	echo '<table id="backup">';
	echo '<tr>';
	echo '<th>No</th>';
	echo '<th>.id</th>';
	echo '<th>name</th>';
	echo '<th>type</th>';
	echo '<th>creation-time</th>';
	echo '<th>action</th>';
	echo '</tr>';
	$i=1;
	foreach ($results as $data){
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$data['.id'].'</td>';
		echo '<td>'.$data['name'].'</td>';
		echo '<td>'.$data['type'].'</td>';
		echo '<td>'.$data['creation-time'].'</td>';	
		echo '<td><a href="restore.php?name='.$data['name'].'">Restore</a> | <a href="remove.php?id='.$data['.id'].'">remove</a></td>';
		echo '</tr>';
		$i++;
	}
	echo '</table>';
	
	echo '<hr>';
	
	echo '<a href="backup.php">Backup</a>';
?>
</body>
</html>