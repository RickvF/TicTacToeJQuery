// class MyConnect extends XMLHttpRequest{
// 	
	// constructor(object, target, appendto, resulthandler){
		// super();
		// this.appendResultTo = appendto;
		// if(resulthandler != null){
			// this.handleResultsWith = resulthandler;
		// }
		// this.onreadystatechange = this.ajaxin;
		// this.open("POST", target+".php",true);
		// this.setRequestHeader("Content-Type", "application/json");
		// let jsonout = JSON.stringify(object); 
		// this.send(jsonout);
	// }	
// 
	// ajaxin(){
		// if(this.readyState === 4){
			// if(this.status === 200){
				// let response = null;
				// try{
					// response = JSON.parse(this.responseText);
				// }
				// catch(exception){
					// console.log(exception);
					// console.log(this.responseText);
				// }
				// if(response != null){
					// this.handleResultsWith(response);
				// }
				// // let newdiv = document.createElement("div");
				// // let texttodiv = document.createTextNode(this.responseText);
				// // newdiv.appendChild(texttodiv);
				// // this.appendResultTo.appendChild(newdiv);
			// } else {
				// alert("Whoopsee... something failed...");
			// }
		// }
	// }
// }

gameStart = false;
canDoMove = false;
playerNumber = 0;
oldGameField = null;

function setNick(){
	let jsonObject = {nickname: $("#textbox").val()};
	$.post("startService.php", JSON.stringify(jsonObject), null, "json");
	setTimeout(timedMessageFetch, 1000);
	$("#setNickname").hide();
}

// function setNick(){
	// let jsonObject = {nickname: document.getElementById("textbox").value};
	// let connect = new MyConnect(jsonObject, "startService", document.body, null);
	// setTimeout(timedMessageFetch, 1000);	
	// document.getElementById("setNickname").style.display = "none"; 
// }

function startGame(responseText){
	localStorage.setItem("player", responseText.continue);
	window.location.replace("http://localhost/PHP/game.php");
}

// function startGame(responseText){
	// localStorage.setItem("player", responseText.continue);
	// window.location.replace("http://localhost/PHP/game.php");
// }

function startGamePart2(){
	responseText = localStorage.getItem("player");
	$("#readyButton").hide();
	$("#gameField").show();
	setTimeout(playTimer, 2500);
	if(responseText != null){
		if(responseText == "continueP1"){		
			gameStart = true;
			playerNumber = 1;
			canDoMove = true;
			console.log("player 1");
		} else if(responseText == "continueP2"){
			playerNumber = 2;
			gameStart = true;
			console.log("player 2");
		}
	}
}

// function startGamePart2(){
	// responseText = localStorage.getItem("player");
	// document.getElementById("readyButton").style.display = "none";
	// document.getElementById("gameField").style.display = "block";
	// setTimeout(playTimer, 2500);
	// if(responseText != null){
		// if(responseText == "continueP1"){		
			// gameStart = true;
			// playerNumber = 1;
			// canDoMove = true;
			// console.log("player 1");
		// } else if(responseText == "continueP2"){
			// playerNumber = 2;
			// gameStart = true;
			// console.log("player 2");
		// }
	// }
// }

function doMove(clicked_id){
	canDo = true;
	var id = clicked_id.toString();
	if($("#"+id).html() != "<h1>-</h1>"){
		canDo = false;
	}
	
	if(canDoMove && canDo){
		canDoMove = false;
		let jsonObject = {
			playerNumber: playerNumber,
			field: clicked_id
		};
		if(playerNumber == 1){
			$("#"+id).html("<h1>X</h1>");
		} else if(playerNumber == 2){
			$("#"+id).html("<h1>O</h1>");
		}
		
		$.post("gameService.php", JSON.stringify(jsonObject), winnerLoser, "json");
	}
}

// function doMove(clicked_id){
	// canDo = true;
	// var id = clicked_id.toString();
	// if(document.getElementById(id).innerHTML  != "<h1>-</h1>"){
		// canDo = false;
	// }
// 	
	// if(canDoMove && canDo){	
		// canDoMove = false;	
		// let jsonObject = {
			// playerNumber: playerNumber,
			// field: clicked_id
		// };
		// if(playerNumber == 1){
			// document.getElementById(id).innerHTML  = "<h1>X</h1>"; 
		// } else if(playerNumber == 2){
			// document.getElementById(id).innerHTML  = "<h1>O</h1>"; 
		// }
// 		
		// let connect = new MyConnect(jsonObject, "gameService", document.body, winnerLoser);
	// }
// }

function playTimer(){
	if(!canDoMove){
		$.post("getNewFieldService.php", {}, winnerLoser, "json");
	}
	setTimeout(playTimer, 2500);
}

// function playTimer(){
	// if(!canDoMove){
		// let connect = new MyConnect({}, "getNewFieldService", document.body, winnerLoser);
	// }
	// setTimeout(playTimer, 2500);
// }

function winnerLoser(responseText){
	if(responseText.winner > 0){
		if(responseText.winner == playerNumber){
			//WINNER
			canDoMove = false;
			console.log("Your the winner");
		} else {
			//LOSER
			canDoMove = false;
			console.log("Your the lost");
		}
	}
	if(!(responseText.newGameField == null)){
		//Update field
		gameField = null;
		try{
			gameField = JSON.parse(responseText.newGameField);
			for(var i = 0; i < gameField.length; i++){
				var id = i.toString();
				$("#"+id).html("<h1>"+gameField[i]+"</h1>");
			}	
			
			if(oldGameField == null){
				oldGameField = gameField;
			}
			
			if(!(oldGameField.toString() === gameField.toString())){
				canDoMove = true;
				console.log("your turn");
				oldGameField = gameField;
			}
			
		} catch(exception){
			alert("parse Field problem"); 
		}
		
	}
	if(responseText.didMove != null){
		if(responseText.didMove != 0){
			canDoMove = false;
		}
	}
	if(responseText.gameField != null){
		gameField = null;
		try{
			gameField = JSON.parse(responseText.gameField);
			for(var i = 0; i < gameField.length; i++){
				var id = i.toString();
				$("#"+id).html("<h1>"+gameField[i]+"</h1>");
			}	
		
			oldGameField = gameField;
			
		} catch(exception){
			alert("parse Field problem"); 
		}
	}
}

// function winnerLoser(responseText){
	// if(responseText.winner > 0){
		// if(responseText.winner == playerNumber){
			// //WINNER
			// canDoMove = false;
			// console.log("Your the winner");
		// } else {
			// //LOSER
			// canDoMove = false;
			// console.log("Your the lost");
		// }
	// }
	// if(!(responseText.newGameField == null)){
		// //Update field
		// gameField = null;
		// try{
			// gameField = JSON.parse(responseText.newGameField);
			// for(var i = 0; i < gameField.length; i++){
				// var id = i.toString();
				// document.getElementById(id).innerHTML  = "<h1>"+gameField[i]+"</h1>";
			// }	
// 			
			// if(oldGameField == null){
				// oldGameField = gameField;
			// }
// 			
			// if(!(oldGameField.toString() === gameField.toString())){
				// canDoMove = true;
				// console.log("your turn");
				// oldGameField = gameField;
			// }
// 			
		// } catch(exception){
			// alert("parse Field problem"); 
		// }
// 		
	// }
	// if(responseText.didMove != null){
		// if(responseText.didMove != 0){
			// canDoMove = false;
		// }
	// }
	// if(responseText.gameField != null){
		// gameField = null;
		// try{
			// gameField = JSON.parse(responseText.gameField);
			// for(var i = 0; i < gameField.length; i++){
				// var id = i.toString();
				// document.getElementById(id).innerHTML  = "<h1>"+gameField[i]+"</h1>";
			// }	
// 		
			// oldGameField = gameField;
// 			
		// } catch(exception){
			// alert("parse Field problem"); 
		// }
	// }
// }

function timedMessageFetch(){
	if($("#waitDiv").css('display') == 'none'){
		$("#waitDiv").show();
	} else {
		$("#waitDiv").hide();
	}
	$.post("waitingService.php", {}, startGame, "json");
	if(!gameStart){
		setTimeout(timedMessageFetch, 1000);
	}
}

// function timedMessageFetch(){
	// var x = document.getElementById("waitDiv");
    // if (x.style.display === "none") {
        // x.style.display = "block";
    // } else {
        // x.style.display = "none";
    // }
	// let connect = new MyConnect({}, "waitingService", document.body, startGame);
	// if(!gameStart){
		// setTimeout(timedMessageFetch, 1000);
	// }
// }