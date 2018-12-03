#suggestPrice<-function(zipcode,capacity,storagetype,lat,long){
  source("DailyNN_test.R")
  options(digits = 5) #setting amount of digits to display in the as.numeric() command
  #requiring necessary packages
  require(RMySQL)
  require(neuralnet)
  
  #command args for phhp shell_exec command
  args<-commandArgs(TRUE)
  zipcode<-as.numeric(args[1])
  capacity<-as.numeric(args[2])
  storagetype<-as.numeric(args[3])
  lat<-as.numeric(args[4])
  long<-as.numeric(args[5])

  latlong<-lat*long #treating the latitude and longitude as one entity ensures that the NN learns the significance
                    #of the pair of numbers, instead of the individial latitudes and longitudes
  #running NN
  suggest_df<-data.frame(zipcode,capacity,storagetype,latlong)
  neural<-DailyNN_test()
  
  #computing and returing prediction 
  pred<-compute(neural,suggest_df)
  price_pred<-round(as.numeric(pred[2])/12,2) #Price in DB $/sq ft/year, but display will be in $/sq ft/month
  price_pred
#}
