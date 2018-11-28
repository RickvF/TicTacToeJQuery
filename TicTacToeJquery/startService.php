<?php
	session_start();
	if(!isset($_SESSION["hassession"])){
		print "Invalid session, you have no business here!";
	} else {
		$database = new PDO('mysql:host=127.0.0.1;dbname=tictactoe', 'WATestUser1', 'WATestPwd1');
		
		//Delete previous sessions is still in waiting queue
		$delete = $database->prepare("DELETE FROM playerqueue WHERE id=:sessionid");
		$delete->bindValue(":sessionid", session_id());
		$delete->execute();
		$delete = NULL;
		
		$deleteGame = $database->prepare("DELETE FROM game WHERE player1ID=:sessionid OR player2ID=:sessionid");
		$deleteGame->bindValue(":sessionid", session_id());
		$deleteGame->execute();
		$deleteGame = NULL;
		
		$jsonObject = file_get_contents('php://input');
		$nickname = json_decode($jsonObject)->nickname;
		
		//Insert new nickname
		$insert = $database->prepare("INSERT into playerqueue (id,nickname) VALUES (:sessionid, :nickname)");
		$insert->bindValue(":sessionid", session_id());
		$insert->bindValue(":nickname", $nickname);
		$insert->execute();
		$insert = NULL;
	}
	
?>
