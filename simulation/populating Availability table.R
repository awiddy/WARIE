PopulateAvailTable <- function(){ 
  
  library(RMySQL)
  mydb<-dbConnect(MySQL(),user='g1090423',password='marioboys',dbname='g1090423',host='mydb.ics.purdue.edu')
  dbSendQuery(mydb,'DELETE FROM Availability')
  Warehouse <- fetch(dbSendQuery(mydb,'SELECT StorageCapacity AS StorageCapacity, ID AS ID FROM Warehouse'),n=-1)
  
  
  Avail <- data.frame()
  
  for(Index in 1:nrow(Warehouse))
  {
    Open_Space <- Warehouse[Index,"StorageCapacity"]
    ID <- Warehouse[Index, "ID"]
    for(week in 0:52)
    {
      Avail <- rbind(Avail,c(ID,week,Open_Space))
    }
  }
  
  
  colnames(Avail)<- c("WarehouseID","WeekFromDate","Open_Space")
  dbWriteTable(mydb, "Availability", Avail,overwrite=TRUE,row.names=FALSE)
  
  all_cons <- dbListConnections(MySQL())
  for (con in all_cons){
  dbDisconnect(con)
  }
  
}

  
