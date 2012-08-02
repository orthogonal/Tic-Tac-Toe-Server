<?php
	require_once("dblogin.php");
	require("pusherkeys.php");
	mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
	mysql_select_db($db_database) or die(mysql_error());
	$query = "INSERT INTO games VALUES()";
	$result = mysql_query($query) OR DIE(mysql_error());
	$query = "SELECT MAX(id) FROM games";
	$result = mysql_query($query) OR DIE(mysql_error());
	$row = mysql_fetch_row($result);
	$gameid = $row[0];
	
	$gameauth = sha1("tttgame" . $gameid);
	
	$query = "UPDATE games SET gameauth = '" . $gameauth . "' WHERE id = " . $gameid;
	$result = mysql_query($query) OR DIE(mysql_error());
	
	$pusher = new Pusher($key, $secret, $app_id);
	$pusher->trigger('tictactoe', 'newgame', array("gameauth" => $gameauth));
	
?>