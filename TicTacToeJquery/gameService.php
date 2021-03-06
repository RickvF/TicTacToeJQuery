<?php
	session_start();
	if(!isset($_SESSION["hassession"])){
		print "Invalid session, you have no business here!";
	} else {
		$database = new PDO('mysql:host=127.0.0.1;dbname=tictactoe', 'WATestUser1', 'WATestPwd1');
		
		$getGames = $database->prepare("SELECT * FROM game WHERE player1ID=:sessionid OR player2ID=:sessionid");
		$getGames->bindValue(":sessionid", session_id());
		$getGames->execute();
		if($getGames->rowCount() > 0){
			for($i=0; $i<$getGames->rowCount(); $i++){
				$game = $getGames->fetch();
				
				$jsonObject = file_get_contents('php://input');
				$playerNumber = json_decode($jsonObject)->playerNumber;
				$field = json_decode($jsonObject)->field;
				
				$gameID = $game["gameID"];
				$gameField = json_decode($game["field"]);
				if($playerNumber == 1){
					$gameField[$field] = 'X';
				} else if($playerNumber == 2){
					$gameField[$field] = 'O';
				}
				
				$updateGame = $database->prepare("UPDATE game SET field=:field WHERE gameID=:gameID");
				$updateGame->bindValue(":field", json_encode($gameField));
				$updateGame->bindValue(":gameID", $gameID);
				$updateGame->execute();
				$updateGame = NULL;
				
				$winner = 0;
				// Player1 check
				if($gameField[0] == 'X' && $gameField[1] == 'X' && $gameField[2] == 'X'){$winner = 1;}
				if($gameField[3] == 'X' && $gameField[4] == 'X' && $gameField[5] == 'X'){$winner = 1;}
				if($gameField[6] == 'X' && $gameField[7] == 'X' && $gameField[8] == 'X'){$winner = 1;}
				if($gameField[0] == 'X' && $gameField[3] == 'X' && $gameField[6] == 'X'){$winner = 1;}
				if($gameField[1] == 'X' && $gameField[4] == 'X' && $gameField[7] == 'X'){$winner = 1;}
				if($gameField[2] == 'X' && $gameField[5] == 'X' && $gameField[8] == 'X'){$winner = 1;}
				if($gameField[0] == 'X' && $gameField[7] == 'X' && $gameField[8] == 'X'){$winner = 1;}
				if($gameField[6] == 'X' && $gameField[4] == 'X' && $gameField[2] == 'X'){$winner = 1;}
				
				//Player2 check
				if($gameField[0] == 'O' && $gameField[1] == 'O' && $gameField[2] == 'O'){$winner = 2;}
				if($gameField[3] == 'O' && $gameField[4] == 'O' && $gameField[5] == 'O'){$winner = 2;}
				if($gameField[6] == 'O' && $gameField[7] == 'O' && $gameField[8] == 'O'){$winner = 2;}
				if($gameField[0] == 'O' && $gameField[3] == 'O' && $gameField[6] == 'O'){$winner = 2;}
				if($gameField[1] == 'O' && $gameField[4] == 'O' && $gameField[7] == 'O'){$winner = 2;}
				if($gameField[2] == 'O' && $gameField[5] == 'O' && $gameField[8] == 'O'){$winner = 2;}
				if($gameField[0] == 'O' && $gameField[7] == 'O' && $gameField[8] == 'O'){$winner = 2;}
				if($gameField[6] == 'O' && $gameField[4] == 'O' && $gameField[2] == 'O'){$winner = 2;}
								
				$didMoveValue = 1;
				$sendmessage = new stdClass();
				$sendmessage->winner = $winner;
				$sendmessage->didMove = $didMoveValue;
				$sendmessage->gameField = json_encode($gameField);
				print json_encode($sendmessage);
			}
		}
		$getGames = NULL;
	}	
?>