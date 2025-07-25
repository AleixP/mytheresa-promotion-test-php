CREATE DATABASE IF NOT EXISTS `mytheresa_db`;

USE `mytheresa_db`;

CREATE USER 'app'@'%' IDENTIFIED BY 'p4ssw0rd';
GRANT ALL PRIVILEGES ON mytheresa_db.* TO 'app'@'%' WITH GRANT OPTION;
