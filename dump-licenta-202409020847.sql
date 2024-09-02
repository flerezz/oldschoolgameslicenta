-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: licenta
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `games` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_name` varchar(255) NOT NULL,
  `game_color` varchar(7) NOT NULL,
  `game_link` varchar(255) NOT NULL,
  `game_logo` varchar(255) NOT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'2048','brown','2048/2048.php','../assets/games_logo/2048_logo.png'),(2,'brickbreaker','dblue','brickbreaker/brickbreaker.php','../assets/games_logo/brickbreaker_logo.png'),(3,'connect4','blue','connect4/connect4.php','../assets/games_logo/connect4_logo.png'),(4,'doodlejump','purple','doodlejump/doodlejump.php','../assets/games_logo/doodlejump_logo.png'),(5,'flappybird','green','flappybird/flappybird.php','../assets/games_logo/flappybird_logo.png'),(6,'minesweeper','grey','minesweeper/minesweeper.php','../assets/games_logo/minesweeper_logo.png'),(7,'rockpaperscissors','red','rockpaperscissors/rockpaperscissors.php','../assets/games_logo/rockpaperscissors_logo.png'),(8,'sudoku','lblue','sudoku/sudoku.php','../assets/games_logo/sudoku_logo.png'),(9,'tictactoe','black','tictactoe/tictactoe.php','../assets/games_logo/tictactoe_logo.png');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `user_role` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (5,'flerezz','123@yahoo.com','12345','account-avatar-profile-user-11-svgrepo-com.png',1),(6,'utilizator','user@yahoo.com','12345','default.jpg',0),(7,'biancamaria','biam@yahoo.com','0000','default.jpg',0),(8,'bilu98','bilu98@yahoo.com','1111','default.jpg',1),(9,'buzu','alexb@yahoo.com','1234','default.jpg',1),(10,'Danuta','danaradu@yahoo.com','2222','default.jpg',0),(11,'andreeamc','andreeamc19@yahoo.com','9876','default.jpg',0),(12,'andrei','andreic@gmail.com','1357','default.jpg',0),(13,'mili84','nicum84@gmail.com','1212','default.jpg',0),(14,'bossu','boss00@gmail.com','7653','default.jpg',0),(15,'blondu','florinp@yahoo.com','0099','default.jpg',0),(16,'tuca','tuca@gmail.com','2510','default.jpg',1),(17,'liviu','liviu@yahoo.com','2002','default.jpg',1),(18,'razvan','razvan@gmail.com','2510','default.jpg',1),(19,'stefanut','stefanut@yahoo.com','2002','default.jpg',1),(20,'user','user@gmail.com','user','default.jpg',0),(21,'admin','admin@gmail.com','admin','default.jpg',0),(22,'bianca','bianca@yahoo.com','1304','default.jpg',1),(23,'vixenia','vixenia@gmail.com','2005','default.jpg',1),(24,'VaMultumesc','mersi@yahoo.com','0000','default.jpg',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'licenta'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-02  8:47:50
