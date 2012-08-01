<?php
	require_once("dblogin.php");
	mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
	mysql_select_db($db_database) or die(mysql_error());
	$username = $_POST["username"];
	
	$query = "SELECT * FROM users WHERE ip = '" . $_SERVER["REMOTE_ADDR"] . "'";
	$result = mysql_query($query) or DIE(mysql_error());
	if (mysql_num_rows($result) > 0){
		$row = mysql_fetch_row($result);
		echo $row[1] . ", " . $row[7];
	} 
	else{
		$query = "INSERT INTO users(username, games, wins, draws, losses, ip) VALUES('" . $username . "', 0, 0, 0, 0, '" . $_SERVER['REMOTE_ADDR'] . "')";
		mysql_query($query) or DIE(mysql_error());
		echo "New user created";
	}
?>