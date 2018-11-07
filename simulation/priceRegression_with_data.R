priceRegression<-function(city_populations){
  #take in the population of the city where the warehouse is located, then create a price ($/sq ft) for that warehouse based on its location
  #test data needs to be taken from real place (loopnet.com?)
  
  #test data:
  prices<- c(8.50,18,18,5,34,17,15,12,22,10,30,8,12,10,9,6,27,7,11,11,14,9,18,5,7,9,10,7,7,
             10,10,18,12,13,8,10,1,10,11,6,11,16,13,16,9,15,18,15,7,7) #in dollars/SF/year all around 1,000-2,00sq feet
  test_populations<- c(0.211, 0.294,1.626,.199,.884,.705,.147,.075,.463,.146,.352,.227,2.716,.076,.066,.391,.322,.192,.067,.068,.685,.015,.422,.072,.027,.109,
                       .467,.020,.111,.021,.084,.041,.077,.120,.008,.644,.170,.060,.180,.133,.074,.078,.018,.063,.011,.024,.010,.004,.016,.064) #in millions
  city<- c('Birmingham', 'Anchorage', 'Phoenix', 'Little Rock', 'San Francisco','Denver','Bridgeport','Camden','Miami','Savannah','Honolulu',
           'Boise','Chicago','Gary','West Des Moines','Wichita','Lexington','Shreveport','Portland','Gaithersburg','Bostson','Traverse City','Minneapolis','Gulfport',
           'Maryland Heights','Billings','Omaha','Elko','Manchester','Pleasantville','Santa Fe','Hicksville','Gastonia','Fargo','Rootstown','Oklahoma City',
           'Salem','Lancaster','Providence','Columbia','Rapid City','Franklin','White Settlement','Lehi','Essex Junction','Fairfax','Sumner',
           'Westover','Beaver Dam','Cheyenne')
  
  #do the regression 
  df<-data.frame(test_populations,prices)
  model<-lm(formula=price~test_populations,data=df)
  
  #extract the constants from the regression model
  list<-model[[1]]
  intercept<-list[1]
  slope<-list[2]
  
  #return rental prices 
  rental_price<-data.frame((slope*city_populations)+intercept)
  price_deviated = rnorm(mean = price, sd = 0.15*price) #where price is your city-specific price and 0.15 says 15% of the price as stdev
   
   #BASE MEAN OFF THIS REGRESSION, ADD SOME FORM OF STANDARD DEVIATION 
}