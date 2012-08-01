<?php
	require("pusherkeys.php");
	$square = $_POST["square"];
	$circle = $_POST["circle"];
	
	require("dblogin.php");
	mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
	mysql_select_db($db_database) or die(mysql_error());
	
	$query = "SELECT * FROM games WHERE id = 2";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$currentval = $row[intval($square)];
	if ($currentval != 0)
		echo "taken";
	else{
		$query = "UPDATE games SET `" . $square . "` = " . (($circle == "true") ? "1" : "2") . " WHERE id = 2";
		$result = mysql_query($query) OR DIE(mysql_error());
		$squares = array(array($row[1], $row[2], $row[3]), array($row[4], $row[5], $row[6]), array($row[7], $row[8], $row[9]));
		$squares[intval(floor(intval($square) / 3))][((intval($square) - 1) % 3)] = (($circle == "true") ? "1" : "2");
		//echo $squares[0][0] . $squares[0][1] . $squares[0][2] . $squares[1][0] . $squares[1][1] . $squares[1][2] . $squares[2][0] . $squares[2][1] . $squares[2][2];
		echo (checkvictory($squares)) ? "win" : ((checkdraw($squares)) ? "draw" : "continue");
	}
	
	function checkvictory($squares){
		$victory = false;
		if (($squares[0][0] == $squares[0][1]) && ($squares[0][1] == $squares[0][2]) && ($squares[0][0] != 0)) $victory = true;
		if (($squares[1][0] == $squares[1][1]) && ($squares[1][1] == $squares[1][2]) && ($squares[1][0] != 0)) $victory = true;
		if (($squares[2][0] == $squares[2][1]) && ($squares[2][1] == $squares[2][2]) && ($squares[2][0] != 0)) $victory = true;
		
		if (($squares[0][0] == $squares[1][0]) && ($squares[1][0] == $squares[2][0]) && ($squares[0][0] != 0)) $victory = true;
		if (($squares[0][1] == $squares[1][1]) && ($squares[1][1] == $squares[2][1]) && ($squares[0][1] != 0)) $victory = true;
		if (($squares[0][2] == $squares[1][2]) && ($squares[1][2] == $squares[2][2]) && ($squares[0][2] != 0)) $victory = true;
		
		if (($squares[0][0] == $squares[1][1]) && ($squares[1][1] == $squares[2][2]) && ($squares[0][0] != 0)) $victory = true;
		if (($squares[0][2] == $squares[1][1]) && ($squares[1][1] == $squares[2][0]) && ($squares[0][2] != 0)) $victory = true;
		return $victory;
	}
	
	function checkdraw($squares){
		$i = 0;
		while ($i < 3){
			$j = 0;
			while ($j < 3){
				if ($squares[$i][$j] == 0) return false;
				$j++;
			}
			$i++;
		}
		return true;
	}
	
	
	
	$pusher = new Pusher($key, $secret, $app_id);
	$pusher->trigger('tictactoe', 'move', array('square' => $square, 'circle' => $circle));
?>