# Host: localhost  (Version 5.5.5-10.1.34-MariaDB)
# Date: 2023-11-23 12:17:35
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "account"
#

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `createdById` int(11) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

#
# Data for table "account"
#

INSERT INTO `account` VALUES (1,0,'Cash'),(2,0,'Card'),(3,0,'Saving'),(6,1,'Gcash'),(7,2,'Metrobank');

#
# Structure for table "category"
#

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `createdById` int(11) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

#
# Data for table "category"
#

INSERT INTO `category` VALUES (1,0,'Clothing','Expense'),(2,0,'Bus','Expense'),(3,0,'Salary','Income'),(4,0,'Business','Income'),(28,1,'Allowance','Income'),(29,1,'Breakfast','Expense'),(30,1,'Lunch','Expense'),(31,1,'Dinner','Expense'),(32,1,'Fare','Expense'),(33,1,'Casino','Income');

#
# Structure for table "record"
#

DROP TABLE IF EXISTS `record`;
CREATE TABLE `record` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` double DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `accountId` int(11) DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `dateAdded` date DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

#
# Data for table "record"
#

INSERT INTO `record` VALUES (1,500,'Income',1,28,'2023-11-12',1),(2,100,'Expense',1,29,'2023-11-12',1),(3,200,'Income',6,33,'2023-11-12',1),(4,300,'Income',1,3,'2023-11-13',1),(5,100,'Income',1,4,'2023-11-13',1),(6,200,'Expense',1,1,'2023-11-13',1),(7,100,'Expense',1,2,'2023-11-13',1),(12,100,'Expense',1,1,'2023-11-14',1),(13,100,'Expense',1,1,'2023-11-14',1),(14,200,'Income',2,3,'2023-11-21',2);

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `Id` tinyint(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateAdded` date DEFAULT NULL,
  `cash` double DEFAULT NULL,
  `savings` double DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'user','1234','John','Doe',NULL,NULL,NULL),(2,'newuser','12','fred','garcia','2023-11-21',NULL,NULL);
