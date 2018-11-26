Search<-function(storage_type, start_date1, end_date1, city, storage_needed,sort_val){
  
  #This function pulls down warehouses that are eligible, based on the user input, and
  #scores warehouses based on parameters and search preferences
  
  #sort_val = value selected by user, prioritizes which to sort by. 1 means sort by price, 2 means sort by owner rating
  #storage_needed = the amount of storage the user needs on their contract
  #start_date1 = the day the contract will start (later to be changed into the format of "# of weeks out")
  #end_date1 = the day the contract will end (changed in the same way as above)
  #city = city in which the user wants the warehosue to be
  
  args<-commandArgs(TRUE)
  storage_type<-args[1]
  start_date1<-args[2]
  end_date1<-args[3]
  city<-args[4]
  storage_needed<-args[5]
  sort_val<-args[6]
  #Connect db
  mydb<-dbConnect(MySQL(),user="g1090423",password="marioboys",dbname="g1090423",host = "mydb.ics.purdue.edu")
  currentDay<-Sys.Date()
  
  #Dates will round up per week, so that contracts are all last a certain whole number of weeks
  start_date<-as.numeric(ceiling((start_date1 - currentDay)/7)) #get start date in the format of "number of weeks out from today"
  end_date<-as.numeric(ceiling((end_date1- currentDay)/7)) #get end date in the format of "number of weeks out from today"
  
  #Create query that will return all eligible warehouses
  qry1<-paste("SELECT W.ID,StorageCapacity,BasePrice,Zipcode,City,State,Owner_ID,R.Rating as Owner_Rating FROM (Warehouse W inner JOIN (SELECT MIN(Open_Space),WarehouseID FROM Availability WHERE WeekFromDate BETWEEN",start_date, "AND", end_date, "Group By WarehouseID) A ON W.ID = A.WarehouseID) 
              INNER JOIN (SELECT Rating,Owner.ID FROM Owner) R ON W.Owner_ID=R.ID WHERE StorageType =",storage_type)
  qry<-paste(qry1," AND City = '",city,"'",sep="") 
  #return warehouses from the above query
  filtered_warehouses<-fetch(dbSendQuery(mydb, qry),n=-1)

  #Extract values from filtered warehouse query
  wID <- filtered_warehouses[1]
  user_rating<-filtered_warehouses[8]
  price<-filtered_warehouses[3]
  
  #Assign the weights by which to score the warehouses
  bestweight<- 1
  weight<- 2
  score_vec<-rep(0,nrow(filtered_warehouses))
  
  #Scoring the warehouses - this works like golf: lowest score wins
  if(length(filtered_warehouses)==0){
    results<-0 #returning a value of zero if no results are found
  }else{
  for (i in 1:nrow(filtered_warehouses)){  
    if(sort_val==2){
      #Calculate score based on search preference and assigned weights
      score<-bestweight*(5-as.numeric(user_rating$Owner_Rating[i])) + weight*as.numeric(price$BasePrice[i])  
      score_vec[i]<-score
    }
    else if(sort_val==1){
      #Calculate score based on search preference and assigned weights
      score<-bestweight*as.numeric(price$BasePrice[i]) + weight* (5-as.numeric(user_rating$Owner_Rating[i]))
      score_vec[i]<-score
    }
    
  }
    results<-data.frame(filtered_warehouses,score_vec) #concatenating scores with their respective warehouse's information
    results<-results[order(results$score_vec,decreasing=FALSE),] #ordering returned warehouses by increasing score
  }

  #Disconnect db
  all_cons <- dbListConnections(MySQL())
  for (con in all_cons)
  {
    dbDisconnect(con)
  }
  
  return(results)
}
