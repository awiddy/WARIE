ContractGen <- function(){
#Contract Generate
contracts = data.frame(matrix(ncol=11))
colnames(contracts) = c('Size','LID','OID','WID','CID','Start Date','End Date','Signing Date','Lessee Rating','Owner Rating','Approval')
contracts[,'Size'] <- 0
contracts[,'LID'] <- 0
contracts[,'OID'] <- 0
contracts[,'WID'] <- 0
contracts[,'CID'] <- 0           #These statements here establish the data types of contracts
contracts[,'Start Date'] <- Sys.Date() #so that when we rbind whContracts, the data types matchup
contracts[,'End Date'] <- Sys.Date()
contracts[,'Signing Date'] <- Sys.Date()
contracts[,'Approval'] = 0

mydb<-dbConnect(MySQL(),user="g1090423",password="marioboys",dbname="g1090423",host = "mydb.ics.purdue.edu")
warehouseDF<- fetch(dbSendQuery(mydb,'SELECT * FROM Warehouse'),n=-1)
num_lessees <- as.numeric(fetch(dbSendQuery(mydb,'SELECT Count(*) FROM Lessee'),n=-1))
num_owners <- as.numeric(fetch(dbSendQuery(mydb,'SELECT Count(*) FROM Owner'),n=-1))                

for (i in 1:nrow(warehouseDF)){
  
  nc = sample(c(3:10),1) #chooses a random number between x and y to be the number of contracts in a warehouse
  capac = warehouseDF[i,'StorageCapacity'] #Max capacity of current warehouse
  ctf = 0.5 * capac #'capacity to fill', we're only looking at filling roughly half of the warehouse (Level 1 simulation)
  avgSize = ctf / nc #the average size that a contract should be for based on ctf and nc
  whContracts <- data.frame(matrix(0,nrow = nc, ncol = 11)) #creates empty DF for the new contracts
  colnames(whContracts) = c('Size','LID','OID','WID','CID','Start Date','End Date', 'Signing Date','Lessee Rating','Owner Rating','Approval')
  
  space = rnorm(nc, mean = avgSize, sd = 0.30*avgSize) #Generates the size of each contract
  whContracts[,'Size'] = space
  
  LID = sample(c(1:num_lessees), size = nc) #Randomly picks a lessee
  whContracts[,'LID'] = LID
  
  OID = warehouseDF[i,'Owner_ID'] #Picks just one Owner per warehouse
  whContracts[,'OID'] = OID
  
  WID = rep(i,nc)
  whContracts$'WID' = WID
  
  currentDay = Sys.Date() #gets today
  prevDays = seq(currentDay - 6, currentDay, by = "day") #Last 6 days from today
  lastSunday = prevDays[weekdays(prevDays) == "Monday"] #finds the most recent sunday
  startDate = lastSunday - sample(seq(from =  0, to = 84, by = 7),nc) #Picks a random Monday within last 12 weeks
  whContracts[,'Start Date'] = startDate
  
  weeksToDate = (currentDay - startDate)/7 #number of weeks since the contract began
  weeksLeft = sample(c(3:12),nc) #arbitrarily pick the amount of weeks left from today (3 is so that none of these contracts end before due date)
  endDate = currentDay + weeksLeft*7 #assigns the end day
  whContracts[,'End Date'] = endDate
  whContracts[,'Approval'] = 1
  
  signDate = endDate - sample(c(7:21),nc) #Sign the contract between 7 and 21 days before it starts
  whContracts[,'Signing Date'] = signDate
  contracts = rbind(contracts,whContracts)
  
  ##Generating Unapproved Contracts
  nc_unapp = nc*2 - (nc-6) #number of unapproved contracts
  unapprovedContracts = data.frame(matrix(0,nrow = nc_unapp,ncol = 11))
  colnames(unapprovedContracts) = c('Size','LID','OID','WID','CID','Start Date','End Date', 'Signing Date','Lessee Rating','Owner Rating','Approval')
  
  ctf = 0.8 * capac #capacity to fill
  avgSize = ctf/nc_unapp #average to hit ctf
  size_unapp = rnorm(nc_unapp,mean = avgSize, sd = avgSize * 0.5)
  size_unapp[size_unapp < 500] = 500
  
  LID_unapp = sample(c(1:num_lessees), size = nc_unapp)
  
  OID_unapp = OID
  
  WID_unapp = rep(i,nc_unapp)
  
  startDate_unapp = lastSunday + sample(seq(from =  28, to = 56, by = 7),size = nc_unapp, replace = T)
  
  endDate_unapp = startDate_unapp + sample(seq(from =  14, to = 84, by = 7),size = nc_unapp,replace  = T)
  
  unapprovedContracts$Size = size_unapp
  unapprovedContracts$LID = LID_unapp
  unapprovedContracts$OID = OID_unapp
  unapprovedContracts$WID = WID_unapp
  unapprovedContracts$`Start Date` = startDate_unapp
  unapprovedContracts$`End Date` = endDate_unapp
  unapprovedContracts$Approval = 0
  unapprovedContracts$`Signing Date` = lastSunday
  
  contracts = rbind(contracts,unapprovedContracts)
  
}
contracts <- contracts[-1,] #takes out first row
CID <- c(1:nrow(contracts)) #establishes CIDs
contracts[,'CID'] = CID
contracts$Size <- round(contracts$Size)
contracts[,'Lessee Rating'] = NA
contracts[,'Owner Rating'] = NA

contracts3 <- data.frame(contracts[,6],contracts[,7],contracts[,5],contracts[,9],contracts[,10],contracts[,2],contracts[,3],contracts[,1],contracts[,8],contracts[,4],contracts[,11])
colnames(contracts3) <- c("Start Date", "End Date","ID","Lessee_Rating","Owner_Rating","Lessee_ID","Owner_ID","Rented_Space","Signing_date","Warehouse_ID","Approval")
dbSendQuery(mydb,'DELETE FROM Contract')
dbWriteTable(mydb, "Contract", contracts3,overwrite = TRUE,row.names=FALSE)

all_cons <- dbListConnections(MySQL())
for (con in all_cons)
{
  dbDisconnect(con)
}
}