CREATE DATABASE IF NOT EXISTS bugmedatabase;
GRANT ALL PRIVILEGES ON bugmedatabase.* TO 'infostudent'@localhost IDENTIFIED BY 'p@$$w0rd';
USE bugmedatabase;

CREATE TABLE IF NOT EXISTS Users (
	id INT NOT NULL AUTO_INCREMENT,
	firstname VARCHAR(25) NOT NULL,
	lastname VARCHAR(25) NOT NULL,
	password VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	date_joined DATE NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Issues (
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255) NOT NULL,
	description VARCHAR(255) NOT NULL,
	type VARCHAR(255) NOT NULL,
	priority VARCHAR(255) NOT NULL,
	status VARCHAR(255) NOT NULL,
	assigned_to INT NOT NULL,
	created_by INT NOT NULL,
	created DATE NOT NULL,
	updated DATE NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO Users (firstname,lastname,password,email,date_joined) VALUES ('admin','admin',MD5('password123'),'admin@bugme.com',CURRENT_DATE());