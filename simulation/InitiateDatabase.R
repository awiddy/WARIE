InitiateDatabase <- function(){
  
  #################INitiates everything from scratch and deletes old data from database. You need to only call the function to populate database######
  ###Takes  Time####
  setwd('\\\\nas01.itap.purdue.edu\\puhome\\My Documents\\GitHub\\WARIE\\simulation')
  source("simulation_data.R")
  source("getPrices.R")
  source("ContractGen.R")
  source("populating Availability table.R")
  source("UpdateAvail for all the contracts.R")
  WLOGen() ##Creates data for Warehouses,Lessees,and Owners. Deletes old info and Uploads that info to MYSQL database
  ContractGen()##Creates contract data and Deletes Old /Uploads newly created data to MySqL
  PopulateAvailTable() ##initializes Availability table by making all Open_Space equal to max capacity for the corresponding WarehouseID
  UpdateAvailability() ##subtracts All approved contract rented spaces from Open_Space in mysql 
  
}