<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />			
		 <script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>		
		<script type="text/javascript" src="serviceconnect.js"></script>
		<title>TicTacToe</title>
	</head>
	<body style="background-color: #A0A0A0">
		<div align="center">
			<button type="button" id="readyButton" onclick="startGamePart2();"><h1>I'm ready</h1></button>
		</div>
		<div id="gameField" align="center" style="display: none">
			<div>
				<button type="button" id="0" onclick="doMove(this.id);"><h1>-</h1></button>
				<button type="button" id="1" onclick="doMove(this.id);"><h1>-</h1></button>
				<button type="button" id="2" onclick="doMove(this.id);"><h1>-</h1></button>
			</div>
			<div>
				<button type="button" id="3" onclick="doMove(this.id);"><h1>-</h1></button>
				<button type="button" id="4" onclick="doMove(this.id);"><h1>-</h1></button>
				<button type="button" id="5" onclick="doMove(this.id);"><h1>-</h1></button>
			</div>
			<div>
				<button type="button" id="6" onclick="doMove(this.id);"><h1>-</h1></button>
				<button type="button" id="7" onclick="doMove(this.id);"><h1>-</h1></button>
				<button type="button" id="8" onclick="doMove(this.id);"><h1>-</h1></button>
			</div>
		</div>
	</body>
</html>
