WLOGen <- function(){
#########################################################################################################
###    Data Simulation  ###

#Packages to be installed: "random", "randomNames", "zipcodes"

#Library Statements  ## Change to require
 #install.packages("zipcode")
 #install.packages("randomNames")
 #install.packages("stringr")
 #install.packages("password")
 #install.packages("openintro")  #for function state2abbr
#install.packages("RMySQL")
  
require(RMySQL)
require(openintro)
require(zipcode)
#library(random)
require(randomNames)
require(stringr)
require(password)


##If you are creating new Data to work with, the old data in MySQL should be updated
mydb<-dbConnect(MySQL(),user='g1090423',password='marioboys',dbname='g1090423',host='mydb.ics.purdue.edu')
dbSendQuery(mydb,'DELETE FROM Warehouse')
dbSendQuery(mydb,'DELETE FROM Owner')
dbSendQuery(mydb,'DELETE FROM Lessee')
#########################################################################################################

##Number of users## Only change the number of lessees
num_lessees = 2000 #total number of lessees generated
num_warehouses = num_lessees *0.5 #total number of warehouses generated
num_owners = num_warehouses*0.75 #total number of owners generated


#Lessee Sim
lessee_id <- sprintf('%0.5d', 1:num_lessees)
lessee_pw <- replicate(num_lessees,password(n = 10, numbers = TRUE, case = TRUE, special = c("?", "!", "&", "%", "$")))
lessee_first<- randomNames(num_lessees,which.names="first")
lessee_last <- randomNames(num_lessees,which.names="last")
lessee_f_init <- str_sub(lessee_first,1,1)
lessee_username <- lessee_username <- paste(lessee_f_init,lessee_last, sep="")
lessee_username <- str_to_lower(lessee_username)
lessee_email_end <- sample(c("@gmail.com","@yahoo.com", "@hotmail.com", "@aol.com", "@msn.com"), size = num_lessees, replace = T, prob = c(0.3,0.3, 0.25, 0.1, 0.05))
lessee_email <- paste(lessee_username,lessee_email_end,sep="")
lesseeDF = data.frame(ID = lessee_id, firstName = lessee_first, lastName = lessee_last, Email = lessee_email, Password = lessee_pw)
colnames(lesseeDF) <- c("ID","FirstName","LastName","Email", "Password") ##May need to add average rating


#Owner Siml
owner_id <- sprintf('%0.5d',1:num_owners)
owner_pw <- replicate(num_owners,password(n = 10, numbers = TRUE, case = TRUE, special = c("?", "!", "&", "%", "$")))
owner_first <- randomNames(num_owners,which.names="first")
owner_last <- randomNames(num_owners,which.names="last")
owner_f_init <- str_sub(owner_first,1,1)
owner_username <- paste(owner_f_init,owner_last, sep="")
owner_username <- str_to_lower(owner_username)
owner_email_end <- sample(c("@gmail.com","@yahoo.com", "@hotmail.com", "@aol.com", "@msn.com"), size = num_owners, replace = T, prob = c(0.3,0.3, 0.25, 0.1, 0.05))
owner_email <- paste(owner_username,owner_email_end,sep="")

ownerDF = data.frame(ID = owner_id, firstName = owner_first, lastName = owner_last, Email = owner_email, Password = owner_pw)
colnames(ownerDF) <- c("OwnerID","FirstName", "LastName","Email","Password")  ##May need to add average rating

##Warehouse Sim
n_Cities_sample <- 15 #The top 'n' cities population wise (up to 311)
big_cities <- read.csv(file= 'pop_data.csv', header = FALSE) #csv: Population is 2017 US Census, Pulled from Wikepedia, where the data is linked to factfinder.census.gov
big_cities <- big_cities[,-c(5:10)]  #removes extra census information (i.e. other years, lat. long., etc.)
big_cities <- big_cities[-c(n_Cities_sample+1:311),] # removes additional rows of cities after the top n cities
colnames(big_cities) <- c("Rank", "City", "State", "Population")  #applies column names
big_cities[,3] <- state2abbr(big_cities[,3])
big_cities[,4] <- as.numeric(big_cities[,4])
prices <- getPrices(big_cities[,4]/1000000)
big_cities <- data.frame(big_cities, prices[,2])
colnames(big_cities) <- c("Rank", "City", "State", "Population", "Base Price")

warehouse_id <- sprintf('%0.5d', 1:num_warehouses)   ##changed num_lessees to num_warehouses
storage_capactity <- rnorm(n = num_warehouses,mean = 55000, sd =15000)  # the range of our storage capacity
storage_type <- sample(c(1:4), size = num_warehouses, replace = T, prob = c(0.6,0.3,0.05,0.05))#1=no temp control, 2=climate controlled, 3=refrigerated, 4=frozen
data("zipcode")
warehouse_loc <- data.frame(zipcode) #loads zip codes into a list
warehouse_loc <- warehouse_loc[-c(1, 2, 3, 4, 5, 6), ] #deletes rows from zipslists that have zipcodes that no longer exist
warehouse_loc <- warehouse_loc[(warehouse_loc$city %in% big_cities$City & warehouse_loc$state %in% big_cities$State),]
warehouse_loc <- warehouse_loc[sample(nrow(warehouse_loc),size = num_warehouses, replace = T), ] #randomly selects locations for num_warehouses amount of warehouses
whPrices <- c()
for (i in 1:nrow(warehouse_loc)){
  whPrices <- c(whPrices,big_cities[which(warehouse_loc[i,'city'] == big_cities$City),'Base Price'])
}

warehouse_owner <- c(sample(owner_id,size = num_owners, replace= F)) #randomly assigns one warehouse to every owner
warehouse_owner <- c(warehouse_owner, sample(owner_id, size = num_warehouses-num_owners, replace= T)) #randomly assigns *with replacement* owners to the remaining warehouses
warehouseDF = data.frame(warehouse_id, storage_capactity, storage_type,whPrices, warehouse_loc, warehouse_owner) #combines warehouse information into a dataframe
colnames(warehouseDF) <- c("ID","StorageCapacity", "StorageType", "BasePrice", "Zipcode", "City", "State", "Latitude", "Longitude", "Owner_ID")


#Contract Generate 
lessee_rating <- sample(c(1:5), size = num_lessees, replace = T, prob = c(0.1,0.2,0.3,0.3,0.1)) 
owner_rating <- sample(c(1:5),size = num_owners, replace = T, prob = c(0.1,0.2,0.3,0.3,0.1))


##########################################################################################################
##Add Generated Data to Database## ##Comment out when not running on a ITap Machine
#mydb = dbConnect(MySQL(), user='g1090423', password='marioboys', dbname='g1090423', host='mydb.ics.purdue.edu')
#dbListTables(mydb)

dbWriteTable(mydb, "Lessee", lesseeDF, append = TRUE, row.names=FALSE)
colnames(ownerDF) <- c("ID","FirstName", "LastName","Email","Password")
dbWriteTable(mydb, "Owner", ownerDF, append = TRUE, row.names=FALSE)
dbWriteTable(mydb, "Warehouse", warehouseDF, append = TRUE, row.names=FALSE)

 all_cons <- dbListConnections(MySQL())
 for (con in all_cons)
 {
   dbDisconnect(con)
 }
##########################################################################################################
}


