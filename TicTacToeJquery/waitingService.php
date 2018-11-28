<?php
	session_start();
	if(!isset($_SESSION["hassession"])){
		print "Invalid session, you have no business here!";
	} else {
		$database = new PDO('mysql:host=127.0.0.1;dbname=tictactoe', 'WATestUser1', 'WATestPwd1');
		
		$player1Set = false;
		//getMessage
		$getPlayers = $database->prepare("SELECT * FROM playerqueue");
		$getPlayers->execute();
		if($getPlayers->rowCount() > 1){
			$game = array();
			for($i=0; $i<$getPlayers->rowCount(); $i++){
				$row = $getPlayers->fetch();
				$player = new \stdClass();
				$player->playerID = $row["id"];
				$player->playerName = $row["nickname"];
				array_push($game, json_encode($player));
				
				$delete = $database->prepare("DELETE FROM playerqueue WHERE id=:sessionid");
				$delete->bindValue(":sessionid", $row["id"]);
				$delete->execute();
				$delete = NULL;
			}
			
			$createGame = $database->prepare("INSERT into game (player1ID,player1Name,player2ID,player2Name,field) VALUES (:p1ID, :p1N, :p2ID, :p2N, :field)");
			$createGame->bindValue(":p1ID", json_decode($game[0])->playerID);
			$createGame->bindValue(":p1N", json_decode($game[0])->playerName);
			$createGame->bindValue(":p2ID", json_decode($game[1])->playerID);
			$createGame->bindValue(":p2N", json_decode($game[1])->playerName);
			$field = array_fill(0, 9, '-');
			$createGame->bindValue(":field", json_encode($field));
			$createGame->execute();
			$createGame = NULL;
			
			$sendmessage = new stdClass();
			$sendmessage->continue = "continueP1";
			print json_encode($sendmessage);
			
			$player1Set = true;
		}
		$getPlayers->closeCursor();
		$getPlayers = NULL;
		
		if($player1Set == false){
			$getGames = $database->prepare("SELECT * FROM game WHERE player1ID=:sessionid OR player2ID=:sessionid");
			$getGames->bindValue(":sessionid", session_id());
			$getGames->execute();
			if($getGames->rowCount() > 0){
				$sendmessage = new stdClass();
				$sendmessage->continue = "continueP2";
				print json_encode($sendmessage);
			}
		}
	}
	
?>
