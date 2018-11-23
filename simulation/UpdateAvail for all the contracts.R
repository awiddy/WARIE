UpdateAvailability <- function(){
##updates the Availability table to include the rented space from the newly approved contract

#CurrentTime <- Sys.date()

mydb<-dbConnect(MySQL(),user="g1090423",password="marioboys",dbname="g1090423",host = "mydb.ics.purdue.edu")
  

#QRY<- ('UPDATE Availability
#SET Open_Space = Open_Space -  Contract.Rented_Space
#WHERE WarehouseID = Contract.Warehouse_ID 
#AND WeekFromDate BETWEEN ROUND(DATEDIFF(CurDate(),Contract.`Start Date`)/7,2) AND ROUND(DATEDIFF(CurDate(),Contract.`End Date`)/7,2)')

#dbSendQuery(mydb,QRY)

##UPDATE Availability
#SET Open_Space = Open_Space -  Contract.Rented_Space
#WHERE WarehouseID = Contract.Warehouse_ID 
#AND WeekFromDate BETWEEN ROUND(DATEDIFF(CurDate(),Contract.`Start Date`)/7,0) AND ROUND(DATEDIFF(CurDate(),Contract.`End Date`)/7,0)


#UPDATE Availability
#SET Open_Space = Open_Space - (SELECT SUM(C.Rented_Space) FROM Contract C WHERE C.ID = Availability.WarehouseID
                               # AND Availability.WeekFromDate BETWEEN ROUND(DATEDIFF(CurDate(),Contract.`Start Date`)/7,0) AND ROUND(DATEDIFF(CurDate(),Contract.`End Date`)/7,0)

                               # UPDATE Availability
                              #  SET Open_Space = Open_Space - (SELECT SUM(C.Rented_Space) FROM Contract C WHERE C.Approval = 1 AND C.ID = Availability.WarehouseID
                              #                                 AND Availability.WeekFromDate BETWEEN ROUND(DATEDIFF(CurDate(),C.`Start Date`)/7,0) AND ROUND(DATEDIFF(CurDate(),C.`End Date`)/7,0))                                
                                
                                #WHERE WarehouseID = Contract.Warehouse_ID 
#AND WeekFromDate BETWEEN ROUND(DATEDIFF(CurDate(),Contract.`Start Date`)/7,0) AND ROUND(DATEDIFF(CurDate(),Contract.`End Date`)/7,0)



Avail<- fetch(dbSendQuery(mydb,'SELECT WarehouseID AS WarehouseID, WeekFromDate AS WeekFromDate,Open_Space AS Open_Space FROM Availability'),n=-1)
Contracts<-fetch(dbSendQuery(mydb,'SELECT ID,Warehouse_ID,Rented_Space,`Start Date`,`End Date` FROM Contract WHERE Approval = 1'),n=-1)

AvailUpdate<-data.frame()
#AvailUpdate<-data.frame("Warehouse_ID"= integer(),"Rented_Space"= integer(),"WeeksToStart"=integer(),"WeeksToEnd"=integer())


currentDay = Sys.Date()
for(index in 1:nrow(Contracts)){
    AvailUpdate<- rbind(AvailUpdate,c(Contracts[index, "Warehouse_ID"],Contracts[index,"Rented_Space"],ceiling((as.Date(Contracts[index,"Start Date"]) - currentDay)/7),ceiling((as.Date(Contracts[index,"End Date"]) - currentDay)/7)))
}


colnames(AvailUpdate)<-c("Warehouse_ID","Rented_Space","WeeksToStart","WeeksToEnd")
#AvailUpdate[AvailUpdate$"Start Date" < 0,"WeeksToStart"]<-0
AvailUpdate[,3]<- sapply(AvailUpdate[,3], function(x) if(x<=0)x<-0)


for(index in 1:nrow(AvailUpdate)){
  ID <- AvailUpdate[index, "Warehouse_ID"]
  RentedSpace<- AvailUpdate[index,"Rented_Space"]
  weekStart<-AvailUpdate[index,"WeeksToStart"]
  weekEnd<-AvailUpdate[index,"WeeksToEnd"]
  #weeknum <- c(AvailUpdate[index,"WeeksToStart"]:AvailUpdate[index,"WeeksToEnd"])
  
  newdata<-Avail[((Avail$WarehouseID == ID) & (Avail$WeekFromDate %in% c(weekStart:weekEnd))),1:3]
  Avail<-Avail[(!(Avail$WarehouseID == ID) | !(Avail$WeekFromDate %in% c(weekStart:weekEnd))),1:3]
  #newdata <- subset(Avail, ((WarehouseID == ID) && (WeekFromDate %in% weeknum)), select=c("WarehouseID","WeekFromDate","Open_Space")) 
  #Avail<-Avail[-((Avail$WarehouseID == ID) & (Avail$WeekFromDate %in% weeknum)),1:3]
  #Avail<- subset(Avail,((!(WarehouseID == ID) || !(WeekFromDate %in% weeknum))), select=c("WarehouseID","WeekFromDate","Open_Space"))
  #newdata[,"Open_Space"] <- newdata[,"Open_Space"] - Rented_Space
  newdata[,"Open_Space"] <- sapply(newdata[,"Open_Space"],function(x) x<- (x - RentedSpace))
  Avail<- rbind(Avail,newdata) 
}

dbWriteTable(mydb, "Availability", Avail,overwrite=TRUE,row.names=FALSE)
dbSendQuery(mydb,'ALTER TABLE Availability Order by WarehouseID,WeekFromDate')

all_cons <- dbListConnections(MySQL())
for (con in all_cons)
{
  dbDisconnect(con)
}
}
  