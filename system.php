<?php
	require("pusherkeys.php");
	$pusher = new Pusher($key, $secret, $app_id);
	
	$pusher->trigger('tictactoe', 'move', array('message' => 'hello world') );
?>