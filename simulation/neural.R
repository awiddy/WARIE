#This script, so far, only uses synthesized data to train the neural network. The goal is to use this function to create a neural network that will then be used to 
#create our prices for our warehouses.
#This script works, but we need to find a way to create better training data
  
#Train neural network to price based on fake data
#https://www.youtube.com/watch?v=LTg-qP9iGFY
require(neuralnet)
library(neuralnet)
n<-100#number of samples we want to use to train the neural network

#THIS METHOD OF CREATING TRAINING/TESTING DATA ISN'T GOOD, NEED TO FIND A NEW WAY TO CREATE BETTER TRAINING/TESTING DATA
populations<-sample(.5:9,n,replace=TRUE)
prices<-sample(5.00:13.00,n,replace=TRUE) #could be inputted using regression
rating<- sample(1:5,n,replace=TRUE)
storagetype<-sample(1:4,n,replace=TRUE)
populations<-sort(populations,decreasing=TRUE)
prices<-sort(prices,decreasing=TRUE)
rating<-sort(rating,decreasing=TRUE)
storagetype<-sort(storagetype,decreasing=TRUE)

#Create data fame that is split into training/testing data
df<-data.frame(populations,rating,storagetype,prices) #it's important that prices is last
ind<-sample(1:nrow(df),70)
trainDF<-df[ind,]
testDF<-df[-ind,]

#creating formula for neuralnet function
allVars<-colnames(df)
predictorVars<-allVars[!allVars%in%"prices"] #price is target variable
predictorVars<-paste(predictorVars,collapse = "+") 
form<-as.formula(paste("prices~",predictorVars,collapse="+")) #writes formula how its needed for neuralnet

#Train neural net -- 
#Input Hidden1 Output
#3      2       1
neural<-neuralnet(formula=form,hidden=2, linear.output=T, data=trainDF)
#plot(neural)


#This is how you would test/use neural net
#predictions<-compute(neural,testDF[,1:3]) #[,1:3] ensures that we use all variables used for prediction, excluding price (bc price is the target)
#predicted_prices<-round(predictions[[2]],digits=2)

