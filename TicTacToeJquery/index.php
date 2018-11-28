<?php
	session_start();
	$_SESSION["hassession"] = true;
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<!-- include jquery -->
		 <script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>		 
		<script type="text/javascript" src="serviceconnect.js"></script>
		<title>TicTacToe</title>
	</head>
	<body style="background-color: #A0A0A0">
		<div id="setNickname">
			<textarea id="textbox" rows="1" cols="140"></textarea>
			<button type="button" id="dabutton" onclick="setNick();">Set nickname</button>
		</div>
		<div id="waitDiv" style="display: none">
			<h3 align="center" id="waitingText">Waiting for another player...</h3>
		</div>
	</body>
</html>
