/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `schema_migrations`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schema_migrations` (
  `version` varchar(255) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_brand`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(30) NOT NULL,
  `brand_description` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_courier`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_courier` (
  `courier_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `courier_name` varchar(30) NOT NULL,
  `courier_building_name` varchar(20) NOT NULL,
  `courier_street` varchar(20) NOT NULL,
  `courier_city` varchar(20) NOT NULL,
  `courier_state` varchar(20) NOT NULL,
  `courier_pincode` varchar(7) NOT NULL,
  `courier_phone` varchar(10) NOT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`courier_id`),
  KEY `email` (`email`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `tbl_courier_ibfk_1` FOREIGN KEY (`email`) REFERENCES `tbl_login` (`email`),
  CONSTRAINT `tbl_courier_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `tbl_staff` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_customer`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `customer_fname` varchar(15) NOT NULL,
  `customer_lname` varchar(15) NOT NULL,
  `customer_house_name` varchar(20) NOT NULL,
  `customer_street` varchar(20) NOT NULL,
  `customer_city` varchar(20) NOT NULL,
  `customer_state` varchar(20) NOT NULL,
  `customer_pincode` varchar(7) NOT NULL,
  `customer_phone` varchar(10) NOT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`customer_id`),
  KEY `email` (`email`),
  CONSTRAINT `tbl_customer_ibfk_1` FOREIGN KEY (`email`) REFERENCES `tbl_login` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_login`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_login` (
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_staff`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `staff_fname` varchar(15) NOT NULL,
  `staff_lname` varchar(15) NOT NULL,
  `staff_house_name` varchar(20) NOT NULL,
  `staff_street` varchar(20) NOT NULL,
  `staff_city` varchar(20) NOT NULL,
  `staff_state` varchar(20) NOT NULL,
  `staff_pincode` varchar(7) NOT NULL,
  `staff_phone` varchar(10) NOT NULL,
  `staff_salary` int(11) NOT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`staff_id`),
  KEY `email` (`email`),
  CONSTRAINT `tbl_staff_ibfk_1` FOREIGN KEY (`email`) REFERENCES `tbl_login` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vendor`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_vendor` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `vendor_email` varchar(50) NOT NULL,
  `vendor_name` varchar(30) NOT NULL,
  `vendor_building_name` varchar(20) NOT NULL,
  `vendor_street` varchar(20) NOT NULL,
  `vendor_city` varchar(20) NOT NULL,
  `vendor_state` varchar(20) NOT NULL,
  `vendor_pincode` varchar(7) NOT NULL,
  `vendor_phone` varchar(10) NOT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`vendor_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `tbl_vendor_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `tbl_staff` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'test'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed

--
-- Dbmate schema migrations
--

LOCK TABLES `schema_migrations` WRITE;
INSERT INTO `schema_migrations` (version) VALUES
  ('20220803083631'),
  ('20220803092428'),
  ('20220807051331'),
  ('20220807090553'),
  ('20220822134808'),
  ('20220823113927'),
  ('20220823123430');
UNLOCK TABLES;
