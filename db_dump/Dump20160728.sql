-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: homeless_kc
-- ------------------------------------------------------
-- Server version	5.5.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(63) NOT NULL,
  `firstName` varchar(63) DEFAULT NULL,
  `lastName` varchar(63) DEFAULT NULL,
  `email` varchar(63) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) DEFAULT NULL,
  `createdAt` int(11) DEFAULT NULL,
  `updatedAt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'test_user',NULL,NULL,'test@example.com','00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc','f9aab579fc1b41ed0c44fe4ecdbfcdb4cb99b9023abb241a6db833288f4eea3c02f76e0d35204a8695077dcf81932aa59006423976224be0390395bae152d4ef',NULL,NULL),(3,'56phil',NULL,NULL,'56phil@gmail.com','Hu88ikju7700','708d8659b15a86fd70d71e004d02378547b063e76f6898a93341e25427cf588',NULL,NULL);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agency`
--

DROP TABLE IF EXISTS `agency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` mediumtext,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(63) DEFAULT NULL,
  `state` varchar(63) DEFAULT NULL,
  `zip` varchar(63) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `lastVerifiedDate` datetime DEFAULT NULL,
  `free` int(11) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agency`
--

LOCK TABLES `agency` WRITE;
/*!40000 ALTER TABLE `agency` DISABLE KEYS */;
INSERT INTO `agency` VALUES (1,'Cabot West Side Dental Clinic','Emergency walk-in available must be present 30 minutes prior, first come first served. Full dental services for all ages 4 months and up. Fees are on a sliding scale, or insurance is accepted. Full evaluation with x-rays included.','1810 Summit St','','Kansas City','MO','64108','http://rodgershealth.org/?page=locations-cabot-westside','ecb@example.com',NULL,0,39.0907024,-94.5938491,NULL,NULL),(2,'Kansas City Care Clinic (Dental)','Will not be accepting new patients until Jan 2015. Appointment only no emergency services provided. Will see TB and HIV patients. Dental patients must also be Kansas City CARE Clinic patients.','6400 Prospect Ave','Suite 200','Kansas City','MO','64132','https://www.kccareclinic.org/','ecb@example.com',NULL,1,39.0102595,-94.5575926,NULL,NULL),(3,'Truman Medical Center','TMC Discount (discounted medical services) eligibility is based on residency, income and family size. Applicants must be Kansas City and/or Jackson County, MO. residents and their income must be below 200 percent of federal poverty level guidelines. In or','2301 Holmes',NULL,' Kansas City','MO','64108','http://trumed.org/hospital-hill','ecb@example.com',NULL,0,39.0844507,-94.5752503,NULL,NULL),(4,'UMKC School of Dentistry','Call for appointment times. Emergency clinic is first come first served at designated times. Accept Medicaid; also have a set fee that must be paid in full at time of service. Emergency fee is $45.','650 E. 25th St.',NULL,'Kansas City','MO','64108','http://dentistry.umkc.edu/Patient_Information/index.shtml','ecb@example.com',NULL,0,39.0820446,-94.5770394,NULL,NULL),(5,'Samuel U. Rodgers Dental Clinic','Accept major insurance, Medicare, Medicaid, and all MO Health Net plans, cash, checks, or major credit cards. Offer a fee discount based on household income to those who qualify.','825 Euclid Ave.','','Kansas City','MO','64124','http://rodgershealth.org/?page=locations-downtown','ecb@example.com',NULL,0,39.104104,-94.5572347,NULL,NULL),(6,'Seton Center Health Services Dental Clinic','Must complete a financial assessment before scheduling an appointment. Financial Assessments are completed at the time specified. Accept various insurances, also fee based on income. Serve children to adult for both emergencies and appointments.','8216 E. 23rd St.','','Kansas City','MO','64127','http://www.setonkc.org','ecb@example.com',NULL,0,39.0816094,-94.4871186,NULL,NULL),(7,'Hope House','A shelter for women and children who have fled their abusers. Outreach counseling, family support groups,  individual therapy, case management, and a court and legal program.','P.O Box 577','','Lee&#039;s Summit','MO','64063','','ecb@example.com',NULL,0,38.9108408,-94.3821724,NULL,NULL),(8,'Kansas City Anti Violence Project','LGBTQ specific domestic violence or sexual assault services. Provides support to victims of domestic violence, sexual assault, and hate violence in the region including Kansas, Missouri, Nebraska, and Iowa.','n/a','','kc','MO','64133','http://www.kcavp.org','ecb@example.com',NULL,0,0,0,NULL,NULL),(9,'Swope Health Central Dental Clinic','Appointments only. Insured are welcome. For uninsured, sliding fee scale based upon income.','3801 Blue Pkwy','','Kansas City','MO','64130','http://www.swopehealth.org','ecb@example.com',NULL,0,39.0348634,-94.5396828,NULL,NULL),(10,'Kansas Crisis Hotline','Toll Free 24 hour statewide hotline linking victims of domestic violence and sexual assault to local services. National domestic violence hotline.','n/a','','na','KS','66000','http://www.kcsdv.org','ecb@example.com',NULL,1,0,0,NULL,NULL),(11,'Adult Education and Literacy; KC Public Schools','Offers apprenticeship programs as well as a variety of construction based education, workforce and professional development','Manuel Career Technical Center, 1215 E. Truman Rd','','Kansas City','MO','64108','http://www.kcpublicschools.org/ael','ecb@example.com',NULL,0,39.0945105,-94.567847,NULL,NULL),(12,'Financial Opportunity Centers; LISC Greater Kansas City','Administers the HiSET exam at all MCC campus testing locations. Exam is computer based only. To schedule and pay for a test must go to www.hiset.ets.org. Total price for the battery (all 5 subtests) is $95.00. Same day results for all except writing porti','600 Broadway, Ste. 280','','Kansas City','MO','64105','http://www.lisc.org/kansas_city/','ecb@example.com',NULL,0,39.1059979,-94.5884346,NULL,NULL),(13,'Salvation Army','Food Pantry interviews are held at specified times. Must schedule for an interview. Will receive food at time of interview. Service area includes East 18th St to East 44th St. 1800-4400 N & S','3013-19 E. 9th Street','','Kansas City','MO','64124',NULL,'ecb@example.com',NULL,0,39.1035433,-94.5827923,NULL,NULL),(14,'Salvation Army','Food pantry interviews are held at specified times. Must schedule for an interview. Will receive food at time of interview. Service area includes East 18th St to East 44th St. 1800-4400 N & S.','6618 E. Truman Rd.',NULL,'Kansas City','MO','64126',NULL,'ecb@example.com',NULL,0,39.0941159,-94.5046017,NULL,NULL),(15,'KC Metro Domestic Violence Hotline','24/7 hotline that provides referrals for domestic violence resources.','n/a',NULL,NULL,NULL,NULL,NULL,'ecb@example.com',NULL,0,0,0,NULL,NULL),(16,'Mattie Rhodes Center','Serves children, individuals, couples, and families many of whom speak only Spanish. Provide Mental Health Counseling, Domestic Violence Intervention, Substance Abuse prevention and treatment, case management, education and support groups, and youth devel','1740 Jefferson St.','','Kansas City','MO','64108','http://www.mattierhodes.org','ecb@example.com',NULL,1,39.0915781,-94.5925674,NULL,NULL),(17,'MOCSA (Metropolitan Org to Counter Sexual Assault)','Advocacy, counseling, education, and supportive services for rape victims, adult survivors of child sexual abuse, free of cost.','3100 Broadway','Ste 400','Kansas City','MO','64111','http://www.mocsa.org','ecb@example.com',NULL,1,39.0665644,-94.590212,NULL,NULL),(18,'Synergy Services','Shelter for battered women and their children. Other services provided include: Counseling &amp;amp;amp; Support Groups, Training Empowerment, and a Batterer\'s Intervention Program','400 E. 6th St.','','Parkville','MO','64152','http://www.synergyservices.org','ecb@example.com',NULL,0,39.191983,-94.6779011,NULL,NULL),(19,'Builders Association, Training Center Education &amp; Training Center','Educational classes offered in the following areas: Financial Literacy and Economic Security, Parenting, and Job Readiness. Supportive Services for persons who are homeless or at-risk of becoming homeless','12th St, North','','Kansas City','MO','64116','http://www.buildersassociation.org','lflaherty@ccharities.com',NULL,0,39.0989073,-94.5525421,NULL,NULL),(20,'Connecting for Good','Provides free computer classes to individuals, offered weekly and designed for learning basic computer skills','3101 Troost Ave','','Kansas City','MO','64109','http://www.connectingforgood.org','michael@connectingforgood.org',NULL,0,39.0703387,-94.5710329,NULL,NULL),(21,'Della Lamb Community Service','Provides services to adults 21 years or older, teaching basic skills for independent living as well as more advanced skills needed to find employment and maintain finances to become self-reliant.','500 Woodland Ave','','Kansas City','MO','64106','http://www.dellalamb.org/','ecb@example.com',NULL,0,39.1085772,-94.5603052,NULL,NULL),(22,'Della Lamb Community Services','Provides services to adults 21 years or older, teaching basic skills for independent living as well as more advanced skills needed to find employment and maintain finances to become self-reliant.','3100 E. 12th St.','','Kansas City','MO','64127','http://www.dellalamb.org','ecb@example.com',NULL,0,39.0988521,-94.5458132,NULL,NULL),(23,'New House','Programs offered include: Residential Shelter and Therapy for women and children, children\'s services, community education, legal advocacy, and 24 hour hotline.','P.O. Box 240019','','Kansas City','MO','64124','http://www.newhouseshelter.org','ecb@example.com',NULL,0,39.0997265,-94.5785667,NULL,NULL),(24,'Rose Brooks Center','Emergency shelter for women and children. Offers domestic violence programs and support such as: prevention, crisis intervention, life skills, therapeutic services, and transitional housing.','P.O. Box 320599','','Kansas City','MO','64132','http://www.rosebrooks.org','ecb@example.com',NULL,1,39.0997265,-94.5785667,NULL,NULL),(26,'Sample Agency','Petierunt uti sibi concilium totius Galliae in diem certam indicere. Donec sed odio operae, eu vulputate felis rhoncus. Ambitioni dedisse scripsisse iudicaretur.\r\nNon equidem invideo, miror magis posuere velit aliquet. Qui ipsorum lingua Celtae, nostra Galli appellantur. Me non paenitet nullum festiviorem excogitasse ad hoc.\r\nInteger legentibus erat a ante historiarum dapibus. Quisque placerat facilisis egestas cillum dolore. Plura mihi bona sunt, inclinet, amari petere vellent. A communi observantia non est recedendum. Idque Caesaris facere voluntate liceret: sese habere. Cras mattis iudicium purus sit amet fermentum.\r\nPhasellus laoreet lorem vel dolor tempus vehicula. Etiam habebis sem dicantur magna mollis euismod. Nihilne te nocturnum praesidium Palati, nihil urbis vigiliae.\r\nTu quoque, Brute, fili mi, nihil timor populi, nihil! Quo usque tandem abutere, Catilina, patientia nostra? Ut enim ad minim veniam, quis nostrud exercitation. Quae vero auctorem tractata ab fiducia dicuntur. Prima luce, cum quibus mons aliud consensu ab eo. Magna pars studiorum, prodita quaerimus.\r\nMercedem aut nummos unde unde extricat, amaras. Nihil hic munitissimus habendi senatus locus, nihil horum? Nec dubitamus multa iter quae et nos invenerat.\r\nQuam temere in vitiis, legem sancimus haerentia. Quisque ut dolor gravida, placerat libero vel, euismod. Curabitur blandit tempus ardua ridiculus sed magna.\r\nPraeterea iter est quasdam res quas ex communi. Hi omnes lingua, institutis, legibus inter se differunt. Fabio vel iudice vincam, sunt in culpa qui officia. Gallia est omnis divisa in partes tres, quarum. Paullum deliquit, ponderibus modulisque suis ratio utitur. Fictum, deserunt mollit anim laborum astutumque!\r\nCurabitur est gravida et libero vitae dictum. Morbi fringilla convallis sapien, id pulvinar odio volutpat. Cum sociis natoque penatibus et magnis dis parturient.\r\nCum ceteris in veneratione tui montes, nascetur mus. Quis aute iure reprehenderit in voluptate velit esse. Contra legem facit qui id facit quod lex prohibet. Ullamco laboris nisi ut aliquid ex ea commodi consequat. Vivamus sagittis lacus vel augue laoreet rutrum faucibus. Sed haec quis possit intrepidus aestimare tellus.\r\nMorbi odio eros, volutpat ut pharetra vitae, lobortis sed nibh. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ab illo tempore, ab est sed immemorabili. Pellentesque habitant morbi tristique senectus et netus.\r\nExcepteur sint obcaecat cupiditat non proident culpa. Tityre, tu patulae recubans sub tegmine fagi dolor. Inmensae subtilitatis, obscuris et malesuada fames. Quid securi etiam tamquam eu fugiat nulla pariatur. Unam incolunt Belgae, aliam Aquitani, tertiam.\r\nQuam diu etiam furor iste tuus nos eludet? At nos hinc posthac, sitientis piros Afros. Salutantibus vitae elit libero, a pharetra augue. Hi omnes lingua, institutis, legibus inter se differunt.\r\nNihil hic munitissimus habendi senatus locus, nihil horum? Tityre, tu patulae recubans sub tegmine fagi dolor. Non equidem invideo, miror magis posuere velit aliquet.\r\nNon equidem invideo, miror magis posuere velit aliquet. Gallia est omnis divisa in partes tres, quarum. Plura mihi bona sunt, inclinet, amari petere vellent. Cum sociis natoque penatibus et magnis dis parturient. Etiam habebis sem dicantur magna mollis euismod. Praeterea iter est quasdam res quas ex communi.','Address 1','Address 2','Kansas City','MO','64444','http://x4k.com','t4k@gmail.org',NULL,1,0,0,NULL,NULL),(27,'Street Medicine KC','Street Medicine Kansas City (SMKC) seeks to expand access to quality health care and social services to Greater Kansas City community to our unreached, underinsured, uninsured, and service resistant homeless and at-risk populations through systematic &quot;street outreach&quot; medical and behavioral health programs and services.','111 W 10th Street','','Kansas City','MO','64105','http://streetmedicinekc.org','streetmedicinekc@gmail.com',NULL,1,0,0,NULL,NULL),(29,'An Agency','Quam temere in vitiis, legem sancimus haerentia. At nos hinc posthac, sitientis piros Afros. Etiam habebis sem dicantur magna mollis euismod. A communi observantia non est recedendum. Ut enim ad minim veniam, quis nostrud exercitation.\r\nFabio vel iudice vincam, sunt in culpa qui officia. Unam incolunt Belgae, aliam Aquitani, tertiam. Praeterea iter est quasdam res quas ex communi. Curabitur blandit tempus ardua ridiculus sed magna.\r\nPellentesque habitant morbi tristique senectus et netus. Magna pars studiorum, prodita quaerimus. Quam diu etiam furor iste tuus nos eludet?\r\nCum sociis natoque penatibus et magnis dis parturient. Quo usque tandem abutere, Catilina, patientia nostra? Cum ceteris in veneratione tui montes, nascetur mus. Nec dubitamus multa iter quae et nos invenerat.\r\nSed haec quis possit intrepidus aestimare tellus. Hi omnes lingua, institutis, legibus inter se differunt. Petierunt uti sibi concilium totius Galliae in diem certam indicere. Contra legem facit qui id facit quod lex prohibet. Integer legentibus erat a ante historiarum dapibus.\r\nTu quoque, Brute, fili mi, nihil timor populi, nihil! Phasellus laoreet lorem vel dolor tempus vehicula. Fictum, deserunt mollit anim laborum astutumque! Curabitur est gravida et libero vitae dictum.\r\nNihilne te nocturnum praesidium Palati, nihil urbis vigiliae. Morbi fringilla convallis sapien, id pulvinar odio volutpat. Idque Caesaris facere voluntate liceret: sese habere. Quid securi etiam tamquam eu fugiat nulla pariatur.\r\nMorbi odio eros, volutpat ut pharetra vitae, lobortis sed nibh. Ambitioni dedisse scripsisse iudicaretur. Ab illo tempore, ab est sed immemorabili.\r\nInmensae subtilitatis, obscuris et malesuada fames. Qui ipsorum lingua Celtae, nostra Galli appellantur. Quisque placerat facilisis egestas cillum dolore. Nihil hic munitissimus habendi senatus locus, nihil horum? Ullamco laboris nisi ut aliquid ex ea commodi consequat. Gallia est omnis divisa in partes tres, quarum.\r\nMercedem aut nummos unde unde extricat, amaras. Plura mihi bona sunt, inclinet, amari petere vellent. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Cras mattis iudicium purus sit amet fermentum. Quis aute iure reprehenderit in voluptate velit esse. Tityre, tu patulae recubans sub tegmine fagi dolor.\r\nNon equidem invideo, miror magis posuere velit aliquet. Quisque ut dolor gravida, placerat libero vel, euismod. Paullum deliquit, ponderibus modulisque suis ratio utitur. Me non paenitet nullum festiviorem excogitasse ad hoc.\r\nExcepteur sint obcaecat cupiditat non proident culpa. Quae vero auctorem tractata ab fiducia dicuntur. Prima luce, cum quibus mons aliud consensu ab eo.\r\nVivamus sagittis lacus vel augue laoreet rutrum faucibus. Salutantibus vitae elit libero, a pharetra augue. Donec sed odio operae, eu vulputate felis rhoncus.\r\nPaullum deliquit, ponderibus modulisque suis ratio utitur. Unam incolunt Belgae, aliam Aquitani, tertiam. Etiam habebis sem dicantur magna mollis euismod. Praeterea iter est quasdam res quas ex communi.','AL1','','KC','MO','64444','http://www.example.org','a@example.com',NULL,0,0,0,NULL,NULL),(30,'An Agency','','AL1','','KC','MO','64444','','a@example.com',NULL,0,0,0,NULL,NULL),(31,'An Agency','','AL1','','KC','MO','64444','','a@example.com',NULL,0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `agency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agencyHours`
--

DROP TABLE IF EXISTS `agencyHours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agencyHours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openTime` time DEFAULT NULL,
  `closeTime` time DEFAULT NULL,
  `dayOfWeek_id` int(11) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `agency_id_idx` (`agency_id`),
  KEY `dayOfWeek_id_idx` (`dayOfWeek_id`),
  CONSTRAINT `agency_id` FOREIGN KEY (`agency_id`) REFERENCES `agency` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `dayOfWeek_id` FOREIGN KEY (`dayOfWeek_id`) REFERENCES `dayOfWeek` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=482 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agencyHours`
--

LOCK TABLES `agencyHours` WRITE;
/*!40000 ALTER TABLE `agencyHours` DISABLE KEYS */;
INSERT INTO `agencyHours` VALUES (1,'00:00:00','23:59:59',1,3,0),(2,'00:00:00','23:59:59',2,3,0),(3,'00:00:00','23:59:59',3,3,0),(4,'00:00:00','23:59:59',4,3,0),(5,'00:00:00','23:59:59',5,3,0),(6,'00:00:00','23:59:59',6,3,0),(7,'00:00:00','23:59:59',7,3,0),(431,'09:00:00','11:00:00',1,26,0),(432,'09:00:00','11:00:00',2,26,0),(433,'09:00:00','11:00:00',3,26,0),(434,'08:00:00','12:00:00',4,26,0),(435,'09:00:00','09:55:00',5,26,0),(436,'14:00:00','18:00:00',4,26,0),(464,'08:00:00','09:00:00',1,29,0),(465,'08:00:00','09:00:00',2,29,0),(466,'08:00:00','09:00:00',3,29,0),(467,'08:00:00','09:00:00',4,29,0),(468,'08:00:00','09:00:00',5,29,0),(469,'10:00:00','11:00:00',3,29,0),(470,'08:00:00','09:00:00',1,30,0),(471,'08:00:00','09:00:00',2,30,0),(472,'08:00:00','09:00:00',3,30,0),(473,'08:00:00','09:00:00',4,30,0),(474,'08:00:00','09:00:00',5,30,0),(475,'10:00:00','11:00:00',3,30,0),(476,'08:00:00','09:00:00',1,31,0),(477,'08:00:00','09:00:00',2,31,0),(478,'08:00:00','09:00:00',3,31,0),(479,'08:00:00','09:00:00',4,31,0),(480,'08:00:00','09:00:00',5,31,0),(481,'10:00:00','11:00:00',3,31,0);
/*!40000 ALTER TABLE `agencyHours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agency_has_subcategories`
--

DROP TABLE IF EXISTS `agency_has_subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agency_has_subcategories` (
  `agency_id` int(11) NOT NULL,
  `subcategories_id` int(11) NOT NULL,
  PRIMARY KEY (`agency_id`,`subcategories_id`),
  KEY `fk_Agency_has_subcategories_subcategories1_idx` (`subcategories_id`),
  KEY `fk_Agency_has_subcategories_Agency1_idx` (`agency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agency_has_subcategories`
--

LOCK TABLES `agency_has_subcategories` WRITE;
/*!40000 ALTER TABLE `agency_has_subcategories` DISABLE KEYS */;
INSERT INTO `agency_has_subcategories` VALUES (1,1),(2,1),(5,1),(6,1),(9,1),(26,1),(7,2),(8,2),(10,2),(16,2),(17,2),(23,2),(27,2),(26,3),(7,4),(23,4),(27,4),(27,5),(27,6),(27,11),(11,12),(19,12),(7,13),(8,13),(16,13),(19,13),(23,13),(24,13),(12,18),(16,18),(17,18),(20,18),(22,18),(27,18),(10,20),(16,20),(17,20),(23,20),(24,20),(27,20),(2,21),(5,21),(6,21),(8,21),(9,21),(10,21),(12,21),(16,21),(17,21),(21,21),(22,21),(27,21),(2,22),(5,22),(6,22),(7,22),(8,22),(9,22),(10,22),(12,22),(16,22),(17,22),(18,22),(21,22),(23,22),(24,22),(27,22),(8,23),(27,23),(7,24),(8,24),(10,24),(16,24),(18,24),(23,24),(24,24),(27,24),(8,25),(10,25),(16,25),(24,25),(27,25),(27,26),(1,27),(8,27),(27,27),(1,28),(2,28),(6,28),(8,28),(9,28),(16,28),(17,28),(27,28),(1,29),(2,29),(6,29),(7,29),(8,29),(9,29),(11,29),(16,29),(17,29),(19,29),(20,29),(24,29),(27,29),(1,30),(2,30),(6,30),(7,30),(9,30),(11,30),(16,30),(17,30),(19,30),(20,30),(21,30),(23,30),(24,30),(27,30),(1,31),(2,31),(6,31),(7,31),(8,31),(16,31),(19,31),(20,31),(21,31),(22,31),(23,31),(27,31),(27,32),(7,33),(16,33),(23,33),(24,33),(27,33),(9,34),(16,34),(27,34),(2,35),(19,35),(21,35),(27,35),(1,36),(2,36),(6,36),(7,36),(8,36),(11,36),(12,36),(16,36),(17,36),(18,36),(19,36),(20,36),(21,36),(22,36),(24,36),(27,36),(1,37),(2,37),(7,37),(11,37),(16,37),(17,37),(18,37),(19,37),(21,37),(22,37),(23,37),(18,43),(6,44),(18,44),(27,45),(27,46),(27,47),(27,48);
/*!40000 ALTER TABLE `agency_has_subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(63) DEFAULT NULL,
  `pinfile` varchar(63) NOT NULL,
  `buttonclass` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Medical','redpin.png','btn-medical'),(2,'Housing','bluepin.png','btn-housing'),(3,'Food','greenpin.png','btn-food'),(4,'Jobs','yellowpin.png','btn-jobs'),(5,'Other Services','graypin.png','btn-other'),(6,'Target Demographics','',''),(7,'Languages Served','',''),(8,'Social Services','pinkpin.png','btn-social');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `givenName` varchar(45) DEFAULT NULL,
  `familyName` varchar(45) DEFAULT NULL,
  `suffix` varchar(45) DEFAULT NULL,
  `credentials` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contactType_id` int(11) NOT NULL DEFAULT '1',
  `agency_id` int(11) NOT NULL,
  `phoneType_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (66,'Executive Director','Jae Edgar','Bennett','','','8164340581','streetmedicinekc@gmail.com',1,27,1),(71,'','Front','Desk','','','8165551221','',1,26,1),(72,'','Darth','Vader','','','8165551212','',3,26,2),(73,'Ms.','Jane','Doe','','','2175551212','b@e.com',5,26,2),(74,'Dr.','Harrold','Henderson','IV','M.D.','9135551212','a@e.com',6,26,3);
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactType`
--

DROP TABLE IF EXISTS `contactType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactType`
--

LOCK TABLES `contactType` WRITE;
/*!40000 ALTER TABLE `contactType` DISABLE KEYS */;
INSERT INTO `contactType` VALUES (1,'Primary'),(2,'Emergency'),(3,'Director'),(5,'Staff'),(6,'Board Member'),(7,'Other');
/*!40000 ALTER TABLE `contactType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dayOfWeek`
--

DROP TABLE IF EXISTS `dayOfWeek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dayOfWeek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `longName` varchar(31) NOT NULL,
  `shortName` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dayOfWeek`
--

LOCK TABLES `dayOfWeek` WRITE;
/*!40000 ALTER TABLE `dayOfWeek` DISABLE KEYS */;
INSERT INTO `dayOfWeek` VALUES (1,'Monday','MON'),(2,'Tuesday','TUE'),(3,'Wednesday','WED'),(4,'Thursday','THU'),(5,'Friday','FRI'),(6,'Saturday','SAT'),(7,'Sunday','SUN');
/*!40000 ALTER TABLE `dayOfWeek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loginAttempts`
--

DROP TABLE IF EXISTS `loginAttempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginAttempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loginAttempts`
--

LOCK TABLES `loginAttempts` WRITE;
/*!40000 ALTER TABLE `loginAttempts` DISABLE KEYS */;
INSERT INTO `loginAttempts` VALUES (19,3,1469653418),(20,1,1385995353),(21,1,1386011064),(27,3,1469661295);
/*!40000 ALTER TABLE `loginAttempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phoneType`
--

DROP TABLE IF EXISTS `phoneType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phoneType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phoneType`
--

LOCK TABLES `phoneType` WRITE;
/*!40000 ALTER TABLE `phoneType` DISABLE KEYS */;
INSERT INTO `phoneType` VALUES (1,'Office'),(2,'Cell'),(3,'Home'),(4,'FAX'),(5,'Other');
/*!40000 ALTER TABLE `phoneType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subCategory`
--

DROP TABLE IF EXISTS `subCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subcategory` varchar(63) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `sequence` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subCategory`
--

LOCK TABLES `subCategory` WRITE;
/*!40000 ALTER TABLE `subCategory` DISABLE KEYS */;
INSERT INTO `subCategory` VALUES (1,'Dentist',1,0),(2,'Mental Health',1,0),(3,'Vision',1,0),(4,'Emergency Shelter',2,0),(5,'Transitional Housing',2,0),(6,'Permanent',2,0),(7,'Pantry',3,0),(8,'Breakfast',3,0),(9,'Lunch',3,0),(10,'Dinner',3,0),(11,'Employment Referral',4,0),(12,'Job Training',4,0),(13,'Legal Assistance',5,0),(14,'Utility Assistance',5,0),(15,'Transportation',5,0),(16,'Showers',5,0),(17,'Laundry',5,0),(18,'Education Services',5,0),(19,'Primary Health Physician',1,10),(20,'Domestic Violence',5,0),(21,'Male',6,10),(22,'Female',6,15),(23,'LGBTQ',6,20),(24,'Single',6,25),(25,'Married',6,30),(26,'Widowed',6,35),(27,'Children (2-12)',6,50),(28,'Teens (13-17)',6,55),(29,'Young Adults (18-20)',6,60),(30,'Adults (21-64)',6,65),(31,'Seniors (65 or Older)',6,70),(32,'Infants (Under 2)',6,45),(33,'Single With Chidren',6,75),(34,'Family With Children',6,80),(35,'Veteran',6,0),(36,'English',7,0),(37,'Spanish',7,0),(38,'Burmese',7,0),(39,'Somali',7,0),(40,'Arabic',7,0),(41,'Vietnamese',7,0),(42,'Bhutanese',7,0),(43,'Hatian',7,0),(44,'ASL',7,0),(45,'Divoriced',6,40),(46,'IDD',6,0),(47,'Job Placement',4,0),(48,'Other',1,0),(49,'Social Security',8,0),(50,'Medicare',8,0),(51,'Medicaid',8,0),(52,'TANF',8,0);
/*!40000 ALTER TABLE `subCategory` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-28 11:56:05
