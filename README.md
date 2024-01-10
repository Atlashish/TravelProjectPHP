# API RESTFUL | TRAVEL ✈️

The project consists of a set of RESTful APIs developed in PHP for the complete management of information regarding countries and travel. Through the use of PHP scripting language and MySQL database, the application adopts the CRUD (Create, Read, Update, Delete) model to ensure effective data manipulation.

# API usage 🖳
The application provides a RESTful API to manage country and travel related information. The following are the main endpoints:

Countries:

GET    /countries: Gets the list of countries.  
POST   /countries: Create new country.  
PATCH  /countries/{id}: Update a country's information by ID.  
DELETE /countries/{id}: Delete a country by ID.  

Travels:

GET    /travels: Gets the list of trips.  
GET    /travels/{id}: Gets a trip by ID.  
GET    /travels?country={country}&seats_available={seats_available}: Gets the list of trips filtered by country and/or seats availables.  
POST   /travels: Create a new trip with countries e seats.  
PATCH  /travels/{id} Update trip information by ID.  
DELETE /travels/{id} Delete a trip by ID.  

# Programming languages and others 🤖

- PHP
- MySQL
- PDO
- Composer Autoload
- Dotenv

# Links 🔗

For my Github Work----> https://github.com/Atlashish/TravelProjectPHP

# Author 🖋

- [@Atlashish](https://github.com/Atlashish/)
