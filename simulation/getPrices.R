priceRegression<-function(){
  #This function performs the actual regression with sampled data in order to get a regression model
  #Function returns the slope and y-intercept of the regression line
  #test data:
  prices<- sort(sample(10:25,500,replace=TRUE),decreasing=TRUE)
  test_populations<-sort(sample(.800000:9.000000,500,replace=TRUE),decreasing=TRUE) #populations in millions
  
  #do the regression 
  df<-data.frame(test_populations,prices)
  model<-lm(formula=prices~test_populations,data=df)
  
  #extract the constants from the regression model
  list<-model[[1]]
  intercept<-list[1]
  slope<-list[2]
  
  ans_vec<-c(slope,intercept)
  
  return(ans_vec)  
  
}

getPrices<-function(city_populations) {

#This function takes the populations of cities in which warehouses are located, in order to calculate a price ($/sq ft/wk) for that warehouse
#city_populations can be one number or a vector of numbers 
#city_populations must be in percent millions (ex: 800,000 would be 0.8)

#Initialize variables to be used  
n<-length(city_populations)
#city_populations<-sort(city_populations,decreasing=TRUE)
prices_vec<-rep(0,n)
dev_percent<-0.15 #deviation for prices, can be changed later

#Call the regression and extract the results
regression<-priceRegression()
slope<-regression[1]
intercept<-regression[2]

#For loop calculates a price based on the population given then deviates it by a given deviation percent
for (i in c(1:n)){
  deviation<-runif(1,min=(1-dev_percent),max=(1+dev_percent)) #deviates the prices either way. Ranges between a 13% decrease or a 13% increase
  #slope<-slope*deviation
  #intercept<-intercept*deviation
  base_price<- (slope*city_populations[i]) + intercept
  price<-deviation*base_price #this price deviation is so that warehouses in the same city will not always have the same price per sq ft
  prices_vec[i]<-price
  }
base_price_df<-data.frame(Populations=city_populations,Prices=prices_vec)
}

