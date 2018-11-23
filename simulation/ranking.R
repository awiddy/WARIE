ranking<-function(filtered_warehouses, sort_user_rating, sort_price){
  
  #Scores fed in warehouses based on parameters and search preferences
  
  #filtered_warehouses = list of warehouses that are elligle 
  #sort_user_rating = 1 or 0, checkbox for sorting by owner rating
  #sort_price = 1 or 0, sort by lowest price
  #sort_location = 1 or 0, ort by nearest to lessee
  wID <- filtered_warehouses[1]
  user_rating<-filtered_warehouses[2]
  price<-filtered_warehouses[3]
  
  bestweight<- 1
  weight<- 2
  
  #GOLF RULES, WANT LOW SCORE
  for (i in 1:length(filtered_warehouses)){  
  if(sort_user_rating){
    #calc score
    score<-bestweight*(5-user_rating) + weight*price  
    #score_vec<-c(score_vec,score)
  }
  else if(sort_price){
    #calc score
    score<-bestweight*price  + weight* (5-user_rating)
    #score_vec<-c(score_vec,score)
  }

  }
  #final_scores<-data.frame(wID, user_rating, price, score_vec)
  
  
}
  
