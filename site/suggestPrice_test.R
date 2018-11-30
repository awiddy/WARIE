#suggestPrice<-function(zipcode,capacity,storagetype,lat,long){
  source("DailyNN_test.R")
  options(digits = 5)
  require(RMySQL)
  require(neuralnet)
  args<-commandArgs(TRUE)
  zipcode<-as.numeric(args[1])
  capacity<-as.numeric(args[2])
  storagetype<-as.numeric(args[3])
  lat<-as.numeric(args[4])
  long<-as.numeric(args[5])
  latlong<-lat*long
  suggest_df<-data.frame(zipcode,capacity,storagetype,latlong)
  neural<-DailyNN_test()
  pred<-compute(neural,suggest_df)
  price_pred<-round(as.numeric(pred[2]),3)
#}