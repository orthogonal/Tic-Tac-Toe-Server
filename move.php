<?php
	require("pusherkeys.php");
	$square = $_POST["square"];
	$circle = $_POST["circle"];
	$pusher = new Pusher($key, $secret, $app_id);
	$pusher->trigger('tictactoe', 'move', array('square' => $square, 'circle' => $circle));
?>