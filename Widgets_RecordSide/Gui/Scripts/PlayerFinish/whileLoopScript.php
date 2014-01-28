foreach (Player in Players) {
	//If first checkpoint time or new checkpoint time
	if (!playerCheckPoint.existskey(Player.Login)){
		playerCheckPoint[Player.Login] = -1;
	}
	//First encounter get nicknamed
	if(!playerNickName.existskey(Player.Login)){
		playerNickName[Player.Login] = Player.Name;
	}
	
	if(playerCheckPoint[Player.Login] != Player.CurRace.Checkpoints.count) {
		
		//Update the current checkpoint of this user
		playerCheckPoint[Player.Login] = Player.CurRace.Checkpoints.count;
		curCp = Player.CurRace.Checkpoints.count;
		
		//If finish
		if (curCp > 0 && curCp == totalCp) {
			
			//If first finish or better time		
			if(!playerTimes.existskey(Player.Login)){
				playerTimes[Player.Login] = -1;
			}
			
			if(playerTimes[Player.Login] == -1 || playerTimes[Player.Login] > Player.CurRace.Checkpoints[curCp-1]){
				playerTimes[Player.Login] = Player.CurRace.Checkpoints[curCp-1];
				needUpdate = True;
			}else{
				log("Worse Time, no update");
			}
		
		} else {
			
		}
	}
}

if(needUpdate){	
	playerTimes = playerTimes.sort();
	needUpdate = False;
	
	declare i = 1;
	declare nbRec = 1;
	declare showed = False;
	
	declare myRank = -1;
	declare start = -1;
	declare end = -1;
	declare recCount = -1;
	
	if(playerTimes.count > nbShow){
		recCount = nbShow;
	}else{
		recCount = playerTimes.count;
	}
	
	i = 1;
	foreach (Login => Score in playerTimes) {
		if(Login == InputPlayer.Login){
			myRank = i;
			break;
		}
		i += 1;
	}
	
	if(myRank != -1){
		start = myRank - ((nbFields - nbFirstFields)/2);
		
		if(start <= nbFirstFields){
			start = nbFirstFields;
			end = start + (nbFields - nbFirstFields);
		}else{
			end = start + (nbFields - nbFirstFields);
			if(end > recCount){
				end = recCount;
				start = end - (nbFields - nbFirstFields);
			}
		}
	}else{
		start = nbFirstFields;
		end = start + (nbFields - nbFirstFields);
	}
	
	i = 1;
	nbRec = 1;
	foreach (Login => Score in playerTimes) {
        
		if((nbRec <= nbFirstFields || (nbRec > start && nbRec <= end) ) && nbRec <= nbShow && i <= nbFields){
	
			declare nickLabel = (Page.GetFirstChild("RecNick_"^i) as CMlLabel);
			declare timeLabel = (Page.GetFirstChild("RecTime_"^i) as CMlLabel);

			if(nickLabel != Null){
			
				putRecordTo(i, nbRec, Score, Login,  playerNickName[Login], Login == InputPlayer.Login);
				
				if(Login == InputPlayer.Login){
					showed = True;
				}
			}
			i += 1;
		}		
		nbRec += 1;		
		
		if(nbRec > nbShow){
		
		}
	}
	
	
}
