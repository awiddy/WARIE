#get all availability for all weeks from the owners warehouse
#add all the space requests into the schedule for every week regardless of max space requirments
#Score each of the requests that are in the first week, for each week that a Contracts belongs to,Total Score = SUM for all weeks(Score for week i = (current space - MaxCapacity) - requestedspace)
#Pick the Contracts with the highest score and remove it
#Move onto the next week if max capacity constraints are met


require(RMySQL) ##need this package
args<- commandArgs(TRUE)
OWNERID<- as.numeric(args[1]) ##passes in OWNER ID for the logged in person
##mysql connection
mydb<-dbConnect(MySQL(),user="g1090423",password="marioboys",dbname="g1090423",host = "mydb.ics.purdue.edu")
##The warehouses that belong to the owner
tmpQRY<- paste0('SELECT ID AS ID From Warehouse WHERE Owner_ID =' ,OWNERID,'')
WAREHOUSEIDDF <-fetch(dbSendQuery(mydb,tmpQRY),n=-1) 
remove(OPTCONTRACTS) ##You can never be too sure
OPTCONTRACTS <- "0" 
###################################Algorithm Start####################################
for(WAREHOUSEID in WAREHOUSEIDDF[,1]){##Ensures that multiple warehouses can be scored seperatly
  
  ##gets current date
  currentDay <- Sys.Date() 
  #Gets the max capacity of the Warehouse and sets it MaxCapacity
  tmpQRY<- paste0('SELECT StorageCapacity From Warehouse W WHERE W.ID =' ,WAREHOUSEID,'')
  MaxCapacity<- fetch(dbSendQuery(mydb,tmpQRY),n=0)
  ##Loads the Availability  of the warehouse From the Availabilty table and puts it in a dataframe Avail
  tmpQRY<-paste0('SELECT WeekFromDate, Open_Space FROM Availability A WHERE A.WarehouseID = ',WAREHOUSEID,'')
  Avail<- fetch(dbSendQuery(mydb,tmpQRY),n=-1)
  ##Gets all info for the unapproved contracts and puts it in dataframe Contracts 
  tmpQRY<-paste0('SELECT ID,Rented_Space,`Start Date`,`End Date` FROM Contract WHERE Approval = 0 AND Warehouse_ID =',WAREHOUSEID,'')
  Contracts<-fetch(dbSendQuery(mydb,tmpQRY),n=-1)
  
  ## Lines 26-30:TRansforms the Start/End Dates from date format into integer Weeks(matches Avail DF) 
  tmpDF<-data.frame()
  for(index in 1:nrow(Contracts)){
    tmpDF<- rbind(tmpDF,c(Contracts[index, "ID"],Contracts[index,"Rented_Space"],ceiling((as.Date(Contracts[index,"Start Date"]) - currentDay)/7),ceiling((as.Date(Contracts[index,"End Date"]) - currentDay)/7)))
  }
  Contracts<-tmpDF
  ##Renames the columns of Contracts and Avail Like they are in Database
  colnames(Contracts)<-c("ContractID","Rented_Space","WeeksToStart","WeeksToEnd")
  colnames(Avail)<- c("WeekFromDate", "Open_Space")
  
  ##subtracts the unnapproved Contract's rented space from Avail for every week 
  ##between the start and end date of the corresponding Contracts
  ##(there will be negative int in availability)
  for (row in 1:nrow(Contracts))
  {
    ##Assings the variables for the specific contract
  	weekStart <- Contracts[row , "WeeksToStart"]
  	weekEnd <- Contracts[row, "WeeksToEnd"]
  	RequestSpace <- Contracts[row, "Rented_Space"]
  	
  	##subsets Avail to only select relevant WeekFromDate and OpenSpace to the specific Contract
  	newdata<-Avail[((Avail$WeekFromDate %in% c(weekStart:weekEnd))),1:2]
  	##Takes out the data from Avail that is going to be Altered
  	Avail<-Avail[(!(Avail$WeekFromDate %in% c(weekStart:weekEnd))),1:2]
  	##subtracts the Requested Space from Avail for the Contract
  	newdata[,"Open_Space"] <- sapply(newdata[,"Open_Space"],function(x) x<- (x - RequestSpace))
  	##Binds the two DF together before the proccess is iterated again for the next contract 
  	Avail<- rbind(Avail,newdata) 
  }
  Avail<-Avail[with(Avail, order(WeekFromDate)),] ##Sorts it by increasing WeekFromdate(Not neccessary)
  
  ## Lines 56-107 are for Scoring all of the requests and removing the non-optimal requests
  #The higher the score, the worse the contract is ranked(Lower Scores are better)
  
  ##Total amount of time that we need to be iterating thru, dont care about the rest
  FirstDate <- min(Contracts$WeeksToStart, na.rm = TRUE)
  LastDate <- max(Contracts$WeeksToEnd, na.rm = TRUE)
  
  for(AvailWeek in FirstDate:LastDate)## loops through every week to ensure Max capacity constraint is not violated
  {
    
  	droppedspace <- 0
  	while((Avail[(Avail$WeekFromDate == (AvailWeek)),"Open_Space"]) < 0)
  	{
  	  ##While the amount of Open_Space is negative(infeasable) run the inner loops 
  	  highestScore <- 0
  		for (ID in Contracts$ContractID)
  		{	
  			Score <- 0 ##Scores start at 0 for each new contracts ID iteration
  			#Parameters specific to that ContractID
  			StartWeek <- Contracts[Contracts$ContractID == ID , "WeeksToStart"]
  			EndWeek <- Contracts[Contracts$ContractID == ID, "WeeksToEnd"]
  			Space <- Contracts[Contracts$ContractID == ID, "Rented_Space"] 
  			if(AvailWeek > StartWeek)
  			{
  			  #This if statement is to reduce the number of week iterations of the inner loop
  			  #We know that Week 0 to AvailWeek will only have feasible(positive) Open_Space
  			  #So we can skip iterations by adjusting it's score accordingly 
  			  #also allows to start the inner for loop at AvailWeek instead of startweek
  			  Score <- (-1 * (Space * (AvailWeek - StartWeek)))
  			}
  			if((AvailWeek >= StartWeek) && (AvailWeek <= EndWeek)) ##Dont score contract if it's start/end dates dont intersect AvailWeek
  			{
  				for (ContractWeek in StartWeek:EndWeek)##iterates through every week the contract is active
  				{
  				  if(Avail[(Avail$WeekFromDate == (ContractWeek)),"Open_Space"] < 0) #If amount of open space for the current week is infeasible(negative), run inside ifs
  				  {
    					if(Space + Avail[(Avail$WeekFromDate == (ContractWeek)),"Open_Space"] > 0) ##if removing this Contract cuases some space to be unutlized
    					{ #Score = past score + (the amount of unutilized space that is created by removing this contract)
    					  #Since Avail[week] is negative, we are rewarding contracts that make the Open_Space feasible by reducing the score
    						Score <- Score + (Space + Avail[(Avail$WeekFromDate == (ContractWeek)),"Open_Space"])
    					}
    					else {
    					  ## if the Availabiliy for the week would still be negative(infeasable) 
    					  ##(even if the particular contract was removed), it recieves a higher(Worse) score
    						Score <- Score + Space 
    					}
  				  }
  				  else{
  				    #The only reason this next line would occur is if Availability for a given week was already underutilized(positive)
  				    ##Therefore getting rid of this contract would only hurt our overall revenue during this week
  				    ##So we lower the score(Lower score = better Contract)
  				   Score <- Score - Space 
  				  }
  				}
  			  ##After Iterating through all of the weeks that the contract is active for a particular contract,
  			  ##if the Score is worse(higher) than all the previously iterated contracts, it is put up on the chopping block
  			  ##(Its not dropped from the table until after all the contracts have been scored)
  				if(Score > highestScore)
  				{
  				dropID <- ID
  				droppedSpace <- Space
  				dropWeekStart <-StartWeek
  				dropWeekEnd<-EndWeek
  				dropContract <- Contracts[(Contracts$ContractID == dropID),1:4]
  				}
  			} ##if the particular contract's start/end date doesnt intersect AvailWeek(From very outer for loop),
  			## Move on to the next ID becuase it cant possibly make the negative(infeasible) Open_Space feasible
  		}
  	  #After every contract that interesects has been scored, start here and drop the highest(worst) score
  		for(Updateweek in dropWeekStart:dropWeekEnd)
  		{
  		  ##updates the Open_Space in Avail by adding back the amount of space the contract took up during its contract period
  			Avail[(Avail$WeekFromDate == (Updateweek)),"Open_Space"] <- (Avail[(Avail$WeekFromDate == (Updateweek)),"Open_Space"] + droppedSpace) 
  		}
  	  #The contract is dropped from the set of potential optimal contracts
  		Contracts<- Contracts[!(Contracts$ContractID == dropID),1:4]
  		##loop through the while loop if the Open_Space is still negative(infeasible)
  	}
  }
  ##End of outer loop, the potenital contracts in the Contract DF optimal for one specific Warehouse
  
  
    OPTCONTRACTS <- paste(c(OPTCONTRACTS,Contracts[,1]), sep = " ")

}##Done optimizing for all warehouses  
#disconnect MySQl
all_cons <- dbListConnections(MySQL())
for (con in all_cons)
{
  dbDisconnect(con)
}

s<-paste0(OPTCONTRACTS,collapse= " ") ##Returns the data to owner_dash.php
s