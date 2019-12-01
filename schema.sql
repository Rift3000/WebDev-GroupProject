CREATE TABLE USERS ( id INT PRIMARY KEY,
    -> firstname varchar(30),
    -> lastname varchar(30),
    -> password varchar(30),
    -> email varchar(30),
    -> date_joined DATE);
    
CREATE TABLE Issues( id INT PRIMARY KEY,
    -> title varchar(40),
    -> description varchar(40),
    -> type varchar(30),
    -> priority varchar(30),
    -> status varchar(30),
    -> assigned_to varchar(30),
    -> created_by varchar(30),
    -> created varchar (30),
    -> updated varchar(30));
    
INSERT INTO USERS (password, email) VALUES ("password123","admin@bugme.com");

