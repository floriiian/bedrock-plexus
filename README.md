# Bedrock Plexus
A very simple Minecraft Bedrock Server Website written in PHP

## How to use
### Run this SQL Query to create a pre-defined database:

CREATE DATABASE bedrock_plexus;
USE bedrock_plexus;
CREATE TABLE servers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  address VARCHAR(50) NOT NULL,
  description VARCHAR(50) NOT NULL
);
CREATE TABLE users (
  UserId INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) NULL UNIQUE,
  email VARCHAR(255) NULL UNIQUE,
  password VARCHAR(72) NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

### Inside the db folder/connect.php configure the following variables:

$host = "localhost:3306"; <- Your database host
$username = "root"; <- Your database username
$password = ""; <- Your database user password
$db = "bedrock_plexus"; <- The database you want to use


### Thats it you're all set.
### This is in no way an actual functioning website, just a side project.

