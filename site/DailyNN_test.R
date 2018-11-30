DailyNN_test<-function(){
  require(RMySQL)
  require(neuralnet)
  library(neuralnet)
  options(digits = 5)
  
  n<-2000 #number of samples to train the NN on
  
  dbcon<-dbConnect(MySQL(),user='g1090423',password='marioboys',dbname='g1090423',host='mydb.ics.purdue.edu')
  qry<- paste("SELECT Zipcode, StorageCapacity, StorageType,Latitude,Longitude, BasePrice FROM Warehouse ORDER BY ID DESC LIMIT",n) #selecting last n warehouse entries
  recent_entries<-fetch(dbSendQuery(dbcon,qry))
  
  #forcing df values to numerics
  recent_entries$Zipcode<-as.numeric(recent_entries$Zipcode) 
  recent_entries$BasePrice<-as.numeric(recent_entries$BasePrice)
  recent_entries$StorageCapacity<-as.numeric(recent_entries$StorageCapacity)
  recent_entries$StorageType<-as.numeric(recent_entries$StorageType)
  recent_entries$Latitude<-as.numeric(recent_entries$Latitude)
  recent_entries$Longitude<-as.numeric(recent_entries$Longitude)
  
  #separating lats and longs to put together into one column
  lats<-as.numeric(recent_entries$Latitude)
  longs<-as.numeric(recent_entries$Longitude)
  LatLong<-rep(0,nrow(recent_entries))
  
  #removing separate lat and long columns from original df
  recent_entries<-recent_entries[,-4]
  recent_entries<-recent_entries[,-4]
  
  #creating a value lat*long that represents a unique region --
  #This will, over time, create the pattern that certain regions are more expensive
  for(i in 1:nrow(recent_entries)){
    lat<-as.numeric(lats[i])
    long<-as.numeric(longs[i])
    LatLong[i]<-lat*long
  }
  LatLong<-as.data.frame(LatLong)
  recent_entries<-data.frame(recent_entries,LatLong)
  
  
  #creating the formula for the neural net
  allVars<-colnames(recent_entries)
  predictorVars<-allVars[!allVars%in%"BasePrice"] #BasePrice is target variable
  predictorVars<-paste(predictorVars,collapse = "+") 
  form<-as.formula(paste("BasePrice~",predictorVars,collapse="+")) #writes formula how its needed for neuralnet
  
  #Compute the neural network
  neural<-neuralnet(formula=form,hidden=c(3,2), linear.output=T, data=recent_entries)
  
  
  all_cons <- dbListConnections(MySQL())
  for (con in all_cons){
    dbDisconnect(con)
  }
  return(neural)
}