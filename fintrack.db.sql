# Host: localhost  (Version 5.5.5-10.1.34-MariaDB)
# Date: 2023-12-15 15:27:12
# Generator: MySQL-Front 6.1  (Build 1.26)


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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

#
# Data for table "category"
#

INSERT INTO `category` VALUES (1,0,'Fare','Expense'),(2,0,'Food','Expense'),(3,0,'Salary','Income'),(4,0,'Business','Income'),(28,1,'Allowance','Income'),(29,1,'Breakfast','Expense'),(30,1,'Lunch','Expense'),(31,1,'Dinner','Expense'),(32,1,'Fare','Expense'),(33,1,'Casino','Income'),(34,0,'Cash','Account'),(35,0,'Card','Account'),(36,0,'Savings','Account'),(37,1,'Gcash','Account'),(38,1,'dtinks','Expense'),(39,1,'BPI','Account'),(40,1,'vices','Expense'),(41,0,'Utilities','Expense'),(42,4,'clothing','Expense'),(43,0,'Allowance','Income'),(44,6,'Siquijor trip','Account'),(45,6,'Lunch','Expense'),(46,6,'Mama','Income'),(47,6,'Papa','Income'),(48,6,'Load','Expense');

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
  `notes` text,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

#
# Data for table "record"
#

INSERT INTO `record` VALUES (1,1000,'Income',34,28,'2023-11-25',1,NULL),(2,1000,'Income',35,3,'2023-11-25',1,NULL),(3,150,'Expense',34,32,'2023-11-25',1,NULL),(4,200,'Expense',35,31,'2023-11-26',1,NULL),(5,100,'Expense',34,1,'2023-11-27',1,NULL),(6,100,'Expense',35,1,'2023-11-27',1,NULL),(8,300,'Expense',35,29,'2023-11-27',1,NULL),(9,400,'Expense',34,2,'2023-11-28',1,NULL),(10,100,'Income',37,28,'2023-11-28',1,NULL),(11,1000,'Income',34,46,'2023-11-28',6,NULL),(15,99,'Expense',34,48,'2023-11-28',6,NULL),(16,10000,'Income',35,3,'2023-11-28',6,NULL),(17,100,'Income',34,3,'2023-11-28',7,NULL),(18,500,'Income',35,4,'2023-11-28',7,NULL),(19,300,'Expense',35,41,'2023-11-28',7,NULL),(20,100,'Income',34,3,'2023-12-05',1,'Sample notes'),(21,200,'Income',37,4,'2023-12-05',1,'Sample notes'),(22,200.5,'Expense',39,31,'2023-12-15',1,NULL);

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
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'user','e10adc3949ba59abbe56e057f20f883e','John','Doe',NULL,NULL,NULL,NULL),(2,'newuser','12','fred','garcia','2023-11-21',NULL,NULL,NULL),(3,'user2','1234','aa','bb','2023-11-28',NULL,NULL,'1234'),(4,'che','123','cherryl','torbiso','2023-11-28',NULL,NULL,'9382943421'),(5,'noruel','123','Noruel','Basa','2023-11-28',NULL,NULL,'099124843544'),(6,'koreano','parkpark72','young','park','2023-11-28',NULL,NULL,'09153205192'),(7,'noruel69','noruel','hahaha','hahaha','2023-11-28',NULL,NULL,'646464'),(8,'hash','e10adc3949ba59abbe56e057f20f883e','jkhkjh','jkhkj','2023-12-15',NULL,NULL,NULL),(9,'cher','202cb962ac59075b964b07152d234b70','cherryl','torbiso','2023-12-15',NULL,NULL,'9382943421');
