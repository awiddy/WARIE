
####Warehouse Prices Simulation
n=5
base_price <- sample(4:6,n,replace=TRUE) #starting price from 4 to 6
rating <- sample(c(1:5), size = n, replace = TRUE, prob = c(0.1,0.2,0.3,0.3,0.1)) #size=num_owners, owner ratings from 1 to 5 simulated
storagetype <- sample(c(1:4), size = n, replace = TRUE, prob = c(0.6,0.3,0.05,0.05)) #size=num_warehouses, storage type from 1 to 4 simulated
population <- .1*sample(8:90,n,replace=TRUE) #population from 0.8 to 9 simulated
rating_mult <- (rating * .1) + 0.7 #rating multiplier based on rating(1-5): 1=0.8, 2=0.9, 3=1.0, 4=1.1, 5=1.2
storagetype_mult <- ((storagetype * .2) + 0.8)^2 #storage type multiplier based on storage type(1-4): 1=1, 2=1.44, 3=1.96, 4=2.56
population_mult <- population*.1 + 1 #population multiplier ranges from 1.08 to 1.9 for populations 0.8 to 9
new_price <- base_price*rating_mult*storagetype_mult*population_mult #new warehouse price is base price multiplied by each multiplier
####