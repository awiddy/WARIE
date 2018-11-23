#get all availability for all weeks from the owners warehouse
#add all the space requests into the schedule for every week regardless of max space requirments
#Score each of the requests that are in the first week, for each week that a Contracts belongs to,Total Score = SUM for all weeks(Score for week i = (current space - MaxCapacity) - requestedspace)
#Pick the Contracts with the highest score and remove it
#Move onto the next week if max capacity constraints are met

ContractOPT <- function(WAREHOUSEID){

mydb<-dbConnect(MySQL(),user="g1090423",password="marioboys",dbname="g1090423",host = "mydb.ics.purdue.edu")

currentDay <- Sys.Date()
tmpQRY<- paste0('SELECT StorageCapacity From Warehouse W WHERE W.ID =' ,WAREHOUSEID,'')
MaxCapacity<- fetch(dbSendQuery(mydb,tmpQRY),n=0)
tmpQRY<-paste0('SELECT WeekFromDate, Open_Space FROM Availability A WHERE A.WarehouseID = ',WAREHOUSEID,'')
Avail<- fetch(dbSendQuery(mydb,tmpQRY),n=-1)
tmpQRY<-paste0('SELECT ID,Rented_Space,`Start Date`,`End Date` FROM Contract WHERE Approval = 0 AND Warehouse_ID =',WAREHOUSEID,'')
Contracts<-fetch(dbSendQuery(mydb,tmpQRY),n=-1)
tmpDF<-data.frame()
for(index in 1:nrow(Contracts)){
  tmpDF<- rbind(tmpDF,c(Contracts[index, "ID"],Contracts[index,"Rented_Space"],ceiling((as.Date(Contracts[index,"Start Date"]) - currentDay)/7),ceiling((as.Date(Contracts[index,"End Date"]) - currentDay)/7)))
}
Contracts<-tmpDF
colnames(Contracts)<-c("ContractID","Rented_Space","WeeksToStart","WeeksToEnd")
colnames(Avail)<- c("WeekFromDate", "Open_Space")

##Works fine up to here

#RequestQRY<- paste0('SELECT ID,Rented_Space,Datediff(wk,',CurrentTime,',Start Date) AS StartWeek, Datediff(wk,',CurrentTime,',End Date) AS EndWeek
 #                    FROM Contract C 
#                   WHERE Warehouse_ID =',WAREHOUSEID,' AND Approval = 0 AND Start Date >=',CurrentTime,' 
 #                    ORDER by StartWeek')






##subtracts the space from availability for every Contracts for every week between the start and end date of that Contracts(there will be negative int in availability)
for (row in 1:nrow(Contracts))
{
	weekStart <- Contracts[row , "WeeksToStart"]
	weekEnd <- Contracts[row, "WeeksToEnd"]
	RequestSpace <- Contracts[row, "Rented_Space"]
	
	newdata<-Avail[((Avail$WeekFromDate %in% c(weekStart:weekEnd))),1:2]
	Avail<-Avail[(!(Avail$WeekFromDate %in% c(weekStart:weekEnd))),1:2]
	#newdata <- subset(Avail, ((WarehouseID == ID) && (WeekFromDate %in% weeknum)), select=c("WarehouseID","WeekFromDate","Open_Space")) 
	#Avail<-Avail[-((Avail$WarehouseID == ID) & (Avail$WeekFromDate %in% weeknum)),1:3]
	#Avail<- subset(Avail,((!(WarehouseID == ID) || !(WeekFromDate %in% weeknum))), select=c("WarehouseID","WeekFromDate","Open_Space"))
	#newdata[,"Open_Space"] <- newdata[,"Open_Space"] - Rented_Space
	newdata[,"Open_Space"] <- sapply(newdata[,"Open_Space"],function(x) x<- (x - RequestSpace))
	Avail<- rbind(Avail,newdata) 
}

Avail<-Avail[with(Avail, order(WeekFromDate)),] ##Sorts it by increasing date

##Scoring all of the requests and removing the non-optimal requests#####################################

FirstDate <- min(Contracts$WeeksToStart, na.rm = TRUE)
LastDate <- max(Contracts$WeeksToEnd, na.rm = TRUE) ##I dont know what na.rm is

for(AvailWeek in FirstDate:LastDate)
{
	droppedspace <- 0
	while((Avail[(AvailWeek + 1),"Open_Space"]) < 0)
	{
	  highestScore <- 0
		for (ID in Contracts$ContractID)
		{	
			Score <- 0
			StartWeek <- Contracts[Contracts$ContractID == ID , "WeeksToStart"]
			EndWeek <- Contracts[Contracts$ContractID == ID, "WeeksToEnd"]
			Space <- Contracts[Contracts$ContractID == ID, "Rented_Space"] 
			if((AvailWeek >= StartWeek) && (AvailWeek <= EndWeek))
			{
				for (ContractWeek in StartWeek:EndWeek)
				{
					if(Space + Avail[(ContractWeek + 1),"Open_Space"] > 0)
					{
						Score <- Score + (Space + Avail[(ContractWeek + 1),"Open_Space"])
					}
					else {
						Score <- Score + Space
						}
				}
				if(Score > highestScore)
				{
				dropID <- ID
				droppedSpace <- Space
				dropWeekStart <-StartWeek
				dropWeekEnd<-EndWeek
				dropContract <- Contracts[(Contracts$ContractID == dropID),1:4]
				}
			}
		}
		for(Updateweek in dropWeekStart:dropWeekEnd)
		{
			Avail[(Updateweek+1),"Open_Space"] <- (Avail[(Updateweek+1),"Open_Space"] + droppedSpace) 
		}
		Contracts<- Contracts[!(Contracts$ContractID == dropID),1:4]
	}
}
all_cons <- dbListConnections(MySQL())
for (con in all_cons)
{
  dbDisconnect(con)
}
##returns all the best requests
return(Contracts)
}
