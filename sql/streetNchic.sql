DROP DATABASE IF EXISTS `streetNchic`;
CREATE DATABASE `streetNchic`;
USE `streetNchic`;


DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `nom_categorie` text NOT NULL
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `produits`;
CREATE TABLE `produits` (
  `nom_categorie` text NOT NULL,
  `reference` varchar(10) NOT NULL PRIMARY KEY,
  `description` text NOT NULL,
  `prix` text NOT NULL,
  `stock` int(5) NOT NULL
) DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `username` varchar(50) NOT NULL PRIMARY KEY,
  `password` text NOT NULL,
  `first_name` text,
  `name` text,
  `birth` DATE,
  `adress` text,
  `email` text,
  `phone` varchar(10)
) DEFAULT CHARSET=utf8;