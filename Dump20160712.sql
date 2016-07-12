-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jul 12, 2016 at 09:35 AM
-- Server version: 5.1.73-cll
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `homeless_kc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(63) DEFAULT NULL,
  `lastName` varchar(63) DEFAULT NULL,
  `email` varchar(63) DEFAULT NULL,
  `password` varchar(63) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE IF NOT EXISTS `agency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` mediumtext,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(63) DEFAULT NULL,
  `state` varchar(63) DEFAULT NULL,
  `zip` varchar(63) DEFAULT NULL,
  `phone` varchar(63) DEFAULT NULL,
  `emergencyPhone` varchar(63) DEFAULT NULL,
  `fax` varchar(63) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contactFirst` varchar(255) DEFAULT NULL,
  `contactLast` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `lastVerifiedDate` datetime DEFAULT NULL,
  `free` int(11) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`id`, `name`, `description`, `address1`, `address2`, `city`, `state`, `zip`, `phone`, `emergencyPhone`, `fax`, `website`, `contactFirst`, `contactLast`, `email`, `lastVerifiedDate`, `free`, `latitude`, `longitude`, `createdAt`, `updatedAt`) VALUES
(1, 'Cabot West Side Dental Clinic', 'Emergency walk-in available must be present 30 minutes prior, first come first served. Full dental services for all ages 4 months and up. Fees are on a sliding scale, or insurance is accepted. Full evaluation with x-rays included.', '1810 Summit St', '', 'Kansas City', 'MO', '64108', '8164710900', '', '', 'http://rodgershealth.org/?page=locations-cabot-westside', '', '', 'ecb@example.com', NULL, 0, 39.0907024, -94.5938491, NULL, NULL),
(2, 'Kansas City Care Clinic (Dental)', 'Will not be accepting new patients until Jan 2015. Appointment only no emergency services provided. Will see TB and HIV patients. Dental patients must also be Kansas City CARE Clinic patients.', '6400 Prospect Ave', 'Suite 200', 'Kansas City', 'MO', '64132', '8167772790', '', '', 'https://www.kccareclinic.org/', '', '', 'ecb@example.com', NULL, 1, 39.0102595, -94.5575926, NULL, NULL),
(3, 'Truman Medical Center', 'TMC Discount (discounted medical services) eligibility is based on residency, income and family size. Applicants must be Kansas City and/or Jackson County, MO. residents and their income must be below 200 percent of federal poverty level guidelines. In or', '2301 Holmes', NULL, ' Kansas City', 'MO', '64108', '8164041000', NULL, NULL, 'http://trumed.org/hospital-hill', NULL, NULL, 'ecb@example.com', NULL, 0, 39.0844507, -94.5752503, NULL, NULL),
(4, 'UMKC School of Dentistry', 'Call for appointment times. Emergency clinic is first come first served at designated times. Accept Medicaid; also have a set fee that must be paid in full at time of service. Emergency fee is $45.', '650 E. 25th St.', NULL, 'Kansas City', 'MO', '64108', '8162352100', NULL, NULL, 'http://dentistry.umkc.edu/Patient_Information/index.shtml', NULL, NULL, 'ecb@example.com', NULL, 0, 39.0820446, -94.5770394, NULL, NULL),
(5, 'Samuel U. Rodgers Dental Clinic', 'Accept major insurance, Medicare, Medicaid, and all MO Health Net plans, cash, checks, or major credit cards. Offer a fee discount based on household income to those who qualify.', '825 Euclid Ave.', '', 'Kansas City', 'MO', '64124', '8168894613', '', '', 'http://rodgershealth.org/?page=locations-downtown', '', '', 'ecb@example.com', NULL, 0, 39.104104, -94.5572347, NULL, NULL),
(6, 'Seton Center Health Services Dental Clinic', 'Must complete a financial assessment before scheduling an appointment. Financial Assessments are completed at the time specified. Accept various insurances, also fee based on income. Serve children to adult for both emergencies and appointments.', '8216 E. 23rd St.', '', 'Kansas City', 'MO', '64127', '8162313955', '', '', 'http://www.setonkc.org', '', '', 'ecb@example.com', NULL, 0, 39.0816094, -94.4871186, NULL, NULL),
(7, 'Hope House', 'A shelter for women and children who have fled their abusers. Outreach counseling, family support groups,  individual therapy, case management, and a court and legal program.', 'P.O Box 577', '', 'Lee&#039;s Summit', 'MO', '64063', '8164614673', '', '', '', '', '', 'ecb@example.com', NULL, 0, 38.9108408, -94.3821724, NULL, NULL),
(8, 'Kansas City Anti Violence Project', 'LGBTQ specific domestic violence or sexual assault services. Provides support to victims of domestic violence, sexual assault, and hate violence in the region including Kansas, Missouri, Nebraska, and Iowa.', 'n/a', '', 'kc', 'MO', '64133', '8165612755', '8165610550', '', 'http://www.kcavp.org', '', '', 'ecb@example.com', NULL, 0, 0, 0, NULL, NULL),
(9, 'Swope Health Central Dental Clinic', 'Appointments only. Insured are welcome. For uninsured, sliding fee scale based upon income.', '3801 Blue Pkwy', '', 'Kansas City', 'MO', '64130', '8169235800', '', '', 'http://www.swopehealth.org', '', '', 'ecb@example.com', NULL, 0, 39.0348634, -94.5396828, NULL, NULL),
(10, 'Kansas Crisis Hotline', 'Toll Free 24 hour statewide hotline linking victims of domestic violence and sexual assault to local services. National domestic violence hotline.', 'n/a', '', 'na', 'KS', '66000', '8883632287', '', '', 'http://www.kcsdv.org', '', '', 'ecb@example.com', NULL, 1, 0, 0, NULL, NULL),
(11, 'Adult Education and Literacy; KC Public Schools', 'Offers apprenticeship programs as well as a variety of construction based education, workforce and professional development', 'Manuel Career Technical Center, 1215 E. Truman Rd', '', 'Kansas City', 'MO', '64108', '8164187150', '', '', 'http://www.kcpublicschools.org/ael', '', '', 'ecb@example.com', NULL, 0, 39.0945105, -94.567847, NULL, NULL),
(12, 'Financial Opportunity Centers; LISC Greater Kansas City', 'Administers the HiSET exam at all MCC campus testing locations. Exam is computer based only. To schedule and pay for a test must go to www.hiset.ets.org. Total price for the battery (all 5 subtests) is $95.00. Same day results for all except writing porti', '600 Broadway, Ste. 280', '', 'Kansas City', 'MO', '64105', '8167530559', '', '', 'http://www.lisc.org/kansas_city/', '', '', 'ecb@example.com', NULL, 0, 39.1059979, -94.5884346, NULL, NULL),
(13, 'Salvation Army', 'Food Pantry interviews are held at specified times. Must schedule for an interview. Will receive food at time of interview. Service area includes East 18th St to East 44th St. 1800-4400 N & S', '3013-19 E. 9th Street', '', 'Kansas City', 'MO', '64124', '8164838484', '', NULL, NULL, NULL, NULL, 'ecb@example.com', NULL, 0, 39.1035433, -94.5827923, NULL, NULL),
(14, 'Salvation Army', 'Food pantry interviews are held at specified times. Must schedule for an interview. Will receive food at time of interview. Service area includes East 18th St to East 44th St. 1800-4400 N & S.', '6618 E. Truman Rd.', NULL, 'Kansas City', 'MO', '64126', '8162416485', '', NULL, NULL, NULL, NULL, 'ecb@example.com', NULL, 0, 39.0941159, -94.5046017, NULL, NULL),
(15, 'KC Metro Domestic Violence Hotline', '24/7 hotline that provides referrals for domestic violence resources.', 'n/a', NULL, NULL, NULL, NULL, '8164685463', NULL, NULL, NULL, NULL, NULL, 'ecb@example.com', NULL, 0, 0, 0, NULL, NULL),
(16, 'Mattie Rhodes Center', 'Serves children, individuals, couples, and families many of whom speak only Spanish. Provide Mental Health Counseling, Domestic Violence Intervention, Substance Abuse prevention and treatment, case management, education and support groups, and youth devel', '1740 Jefferson St.', '', 'Kansas City', 'MO', '64108', '8164712536', '', '', 'http://www.mattierhodes.org', '', '', 'ecb@example.com', NULL, 1, 39.0915781, -94.5925674, NULL, NULL),
(17, 'MOCSA (Metropolitan Org to Counter Sexual Assault)', 'Advocacy, counseling, education, and supportive services for rape victims, adult survivors of child sexual abuse, free of cost.', '3100 Broadway', 'Ste 400', 'Kansas City', 'MO', '64111', '8169314527', '8165310233', '', 'http://www.mocsa.org', '', '', 'ecb@example.com', NULL, 1, 39.0665644, -94.590212, NULL, NULL),
(18, 'Synergy Services', 'Shelter for battered women and their children. Other services provided include: Counseling &amp;amp;amp; Support Groups, Training Empowerment, and a Batterer''s Intervention Program', '400 E. 6th St.', '', 'Parkville', 'MO', '64152', '8004911114', '816HOTLINE', '', 'http://www.synergyservices.org', '', '', 'ecb@example.com', NULL, 0, 39.191983, -94.6779011, NULL, NULL),
(19, 'Builders Association, Training Center Education &amp; Training Center', 'Educational classes offered in the following areas: Financial Literacy and Economic Security, Parenting, and Job Readiness. Supportive Services for persons who are homeless or at-risk of becoming homeless', '12th St, North', '', 'Kansas City', 'MO', '64116', '8164710880', '8167517700', '', 'http://www.buildersassociation.org', '', '', 'lflaherty@ccharities.com', NULL, 0, 39.0989073, -94.5525421, NULL, NULL),
(20, 'Connecting for Good', 'Provides free computer classes to individuals, offered weekly and designed for learning basic computer skills', '3101 Troost Ave', '', 'Kansas City', 'MO', '64109', '8165597077', '', '', 'http://www.connectingforgood.org', '', '', 'michael@connectingforgood.org', NULL, 0, 39.0703387, -94.5710329, NULL, NULL),
(21, 'Della Lamb Community Service', 'Provides services to adults 21 years or older, teaching basic skills for independent living as well as more advanced skills needed to find employment and maintain finances to become self-reliant.', '500 Woodland Ave', '', 'Kansas City', 'MO', '64106', '8165551212', '', '', 'http://www.dellalamb.org/', '', '', 'ecb@example.com', NULL, 0, 39.1085772, -94.5603052, NULL, NULL),
(22, 'Della Lamb Community Services', 'Provides services to adults 21 years or older, teaching basic skills for independent living as well as more advanced skills needed to find employment and maintain finances to become self-reliant.', '3100 E. 12th St.', '', 'Kansas City', 'MO', '64127', '8169213002', '', '', 'http://www.dellalamb.org', '', '', 'ecb@example.com', NULL, 0, 39.0988521, -94.5458132, NULL, NULL),
(23, 'New House', 'Programs offered include: Residential Shelter and Therapy for women and children, children''s services, community education, legal advocacy, and 24 hour hotline.', 'P.O. Box 240019', '', 'Kansas City', 'MO', '64124', '8164746446', '8164715800', '', 'http://www.newhouseshelter.org', '', '', 'ecb@example.com', NULL, 0, 39.0997265, -94.5785667, NULL, NULL),
(24, 'Rose Brooks Center', 'Emergency shelter for women and children. Offers domestic violence programs and support such as: prevention, crisis intervention, life skills, therapeutic services, and transitional housing.', 'P.O. Box 320599', '', 'Kansas City', 'MO', '64132', '8165235550', '8168616100', '', 'http://www.rosebrooks.org', '', '', 'ecb@example.com', NULL, 1, 39.0997265, -94.5785667, NULL, NULL),
(25, 'old agency', 'Ambitioni dedisse scripsisse iudicaretur. Curabitur blandit tempus ardua ridiculus sed magna. Cum ceteris in veneratione tui montes, nascetur mus. Paullum deliquit, ponderibus modulisque suis ratio utitur. Cum sociis natoque penatibus et magnis dis parturient. Quo usque tandem abutere, Catilina, patientia nostra?\r\nContra legem facit qui id facit quod lex prohibet. Etiam habebis sem dicantur magna mollis euismod. Morbi odio eros, volutpat ut pharetra vitae, lobortis sed nibh. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua.\r\nUllamco laboris nisi ut aliquid ex ea commodi consequat. Excepteur sint obcaecat cupiditat non proident culpa. Quisque ut dolor gravida, placerat libero vel, euismod. Sed haec quis possit intrepidus aestimare tellus. Fabio vel iudice vincam, sunt in culpa qui officia.\r\nIdque Caesaris facere voluntate liceret: sese habere. Donec sed odio operae, eu vulputate felis rhoncus. Non equidem invideo, miror magis posuere velit aliquet.\r\nQuisque placerat facilisis egestas cillum dolore. Magna pars studiorum, prodita quaerimus. Ab illo tempore, ab est sed immemorabili. Phasellus laoreet lorem vel dolor tempus vehicula.\r\nGallia est omnis divisa in partes tres, quarum. Quam diu etiam furor iste tuus nos eludet? Tityre, tu patulae recubans sub tegmine fagi dolor. Nec dubitamus multa iter quae et nos invenerat.\r\nMercedem aut nummos unde unde extricat, amaras. Morbi fringilla convallis sapien, id pulvinar odio volutpat. Inmensae subtilitatis, obscuris et malesuada fames. Quid securi etiam tamquam eu fugiat nulla pariatur. Prima luce, cum quibus mons aliud consensu ab eo.\r\nUnam incolunt Belgae, aliam Aquitani, tertiam. Integer legentibus erat a ante historiarum dapibus. Plura mihi bona sunt, inclinet, amari petere vellent. Quam temere in vitiis, legem sancimus haerentia.\r\nCras mattis iudicium purus sit amet fermentum. Nihilne te nocturnum praesidium Palati, nihil urbis vigiliae. A communi observantia non est recedendum. Qui ipsorum lingua Celtae, nostra Galli appellantur.\r\nCurabitur est gravida et libero vitae dictum. Hi omnes lingua, institutis, legibus inter se differunt. Tu quoque, Brute, fili mi, nihil timor populi, nihil! Fictum, deserunt mollit anim laborum astutumque! Pellentesque habitant morbi tristique senectus et netus.\r\nUt enim ad minim veniam, quis nostrud exercitation. Praeterea iter est quasdam res quas ex communi. Me non paenitet nullum festiviorem excogitasse ad hoc. Salutantibus vitae elit libero, a pharetra augue. Petierunt uti sibi concilium totius Galliae in diem certam indicere. Vivamus sagittis lacus vel augue laoreet rutrum faucibus.\r\nQuae vero auctorem tractata ab fiducia dicuntur. Nihil hic munitissimus habendi senatus locus, nihil horum? Quis aute iure reprehenderit in voluptate velit esse. At nos hinc posthac, sitientis piros Afros.\r\nQui ipsorum lingua Celtae, nostra Galli appellantur. A communi observantia non est recedendum. Quam temere in vitiis, legem sancimus haerentia. Donec sed odio operae, eu vulputate felis rhoncus. Ambitioni dedisse scripsisse iudicaretur. Mercedem aut nummos unde unde extricat, amaras.', 'addr1', '', 'Kansas City', 'MO', '64444', '8165551221', '', '', 'http://t4k.com', '', '', 'ecb@example.com', NULL, 1, 0, 0, NULL, NULL),
(26, 'new agency', 'Petierunt uti sibi concilium totius Galliae in diem certam indicere. Donec sed odio operae, eu vulputate felis rhoncus. Ambitioni dedisse scripsisse iudicaretur.\r\nNon equidem invideo, miror magis posuere velit aliquet. Qui ipsorum lingua Celtae, nostra Galli appellantur. Me non paenitet nullum festiviorem excogitasse ad hoc.\r\nInteger legentibus erat a ante historiarum dapibus. Quisque placerat facilisis egestas cillum dolore. Plura mihi bona sunt, inclinet, amari petere vellent. A communi observantia non est recedendum. Idque Caesaris facere voluntate liceret: sese habere. Cras mattis iudicium purus sit amet fermentum.\r\nPhasellus laoreet lorem vel dolor tempus vehicula. Etiam habebis sem dicantur magna mollis euismod. Nihilne te nocturnum praesidium Palati, nihil urbis vigiliae.\r\nTu quoque, Brute, fili mi, nihil timor populi, nihil! Quo usque tandem abutere, Catilina, patientia nostra? Ut enim ad minim veniam, quis nostrud exercitation. Quae vero auctorem tractata ab fiducia dicuntur. Prima luce, cum quibus mons aliud consensu ab eo. Magna pars studiorum, prodita quaerimus.\r\nMercedem aut nummos unde unde extricat, amaras. Nihil hic munitissimus habendi senatus locus, nihil horum? Nec dubitamus multa iter quae et nos invenerat.\r\nQuam temere in vitiis, legem sancimus haerentia. Quisque ut dolor gravida, placerat libero vel, euismod. Curabitur blandit tempus ardua ridiculus sed magna.\r\nPraeterea iter est quasdam res quas ex communi. Hi omnes lingua, institutis, legibus inter se differunt. Fabio vel iudice vincam, sunt in culpa qui officia. Gallia est omnis divisa in partes tres, quarum. Paullum deliquit, ponderibus modulisque suis ratio utitur. Fictum, deserunt mollit anim laborum astutumque!\r\nCurabitur est gravida et libero vitae dictum. Morbi fringilla convallis sapien, id pulvinar odio volutpat. Cum sociis natoque penatibus et magnis dis parturient.\r\nCum ceteris in veneratione tui montes, nascetur mus. Quis aute iure reprehenderit in voluptate velit esse. Contra legem facit qui id facit quod lex prohibet. Ullamco laboris nisi ut aliquid ex ea commodi consequat. Vivamus sagittis lacus vel augue laoreet rutrum faucibus. Sed haec quis possit intrepidus aestimare tellus.\r\nMorbi odio eros, volutpat ut pharetra vitae, lobortis sed nibh. Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ab illo tempore, ab est sed immemorabili. Pellentesque habitant morbi tristique senectus et netus.\r\nExcepteur sint obcaecat cupiditat non proident culpa. Tityre, tu patulae recubans sub tegmine fagi dolor. Inmensae subtilitatis, obscuris et malesuada fames. Quid securi etiam tamquam eu fugiat nulla pariatur. Unam incolunt Belgae, aliam Aquitani, tertiam.\r\nQuam diu etiam furor iste tuus nos eludet? At nos hinc posthac, sitientis piros Afros. Salutantibus vitae elit libero, a pharetra augue. Hi omnes lingua, institutis, legibus inter se differunt.\r\nNihil hic munitissimus habendi senatus locus, nihil horum? Tityre, tu patulae recubans sub tegmine fagi dolor. Non equidem invideo, miror magis posuere velit aliquet.\r\nNon equidem invideo, miror magis posuere velit aliquet. Gallia est omnis divisa in partes tres, quarum. Plura mihi bona sunt, inclinet, amari petere vellent. Cum sociis natoque penatibus et magnis dis parturient. Etiam habebis sem dicantur magna mollis euismod. Praeterea iter est quasdam res quas ex communi.', 'addr1', '', 'Kansas City', 'MO', '64444', '8165551221', '', '', 'http://t4k.com', '', '', 'ecb@example.com', NULL, 1, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `agencyHours`
--

CREATE TABLE IF NOT EXISTS `agencyHours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openTime` time DEFAULT NULL,
  `closeTime` time DEFAULT NULL,
  `dayOfWeek_id` int(11) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agency_id_idx` (`agency_id`),
  KEY `dayOfWeek_id_idx` (`dayOfWeek_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `agencyHours`
--

INSERT INTO `agencyHours` (`id`, `openTime`, `closeTime`, `dayOfWeek_id`, `agency_id`) VALUES
(1, '00:00:00', '23:59:59', 1, 3),
(2, '00:00:00', '23:59:59', 2, 3),
(3, '00:00:00', '23:59:59', 3, 3),
(4, '00:00:00', '23:59:59', 4, 3),
(5, '00:00:00', '23:59:59', 5, 3),
(6, '00:00:00', '23:59:59', 6, 3),
(7, '00:00:00', '23:59:59', 7, 3),
(36, '11:00:00', '16:00:00', 1, 25),
(37, '11:00:00', '15:00:00', 2, 25),
(38, '11:00:00', '17:00:00', 3, 25),
(39, '13:00:00', '19:30:00', 4, 25),
(40, '13:00:00', '15:00:00', 5, 25),
(41, '12:00:00', '12:00:00', 6, 25),
(42, '12:00:00', '12:00:00', 7, 25),
(43, '11:00:00', '16:00:00', 1, 26),
(44, '11:00:00', '15:00:00', 2, 26),
(45, '11:00:00', '17:00:00', 3, 26),
(46, '13:00:00', '19:30:00', 4, 26),
(47, '13:00:00', '15:00:00', 5, 26),
(48, '12:00:00', '12:00:00', 6, 26),
(49, '12:00:00', '12:00:00', 7, 26);

-- --------------------------------------------------------

--
-- Table structure for table `agency_has_subcategories`
--

CREATE TABLE IF NOT EXISTS `agency_has_subcategories` (
  `agency_id` int(11) NOT NULL,
  `subcategories_id` int(11) NOT NULL,
  PRIMARY KEY (`agency_id`,`subcategories_id`),
  KEY `fk_Agency_has_subcategories_subcategories1_idx` (`subcategories_id`),
  KEY `fk_Agency_has_subcategories_Agency1_idx` (`agency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agency_has_subcategories`
--

INSERT INTO `agency_has_subcategories` (`agency_id`, `subcategories_id`) VALUES
(1, 1),
(2, 1),
(5, 1),
(6, 1),
(9, 1),
(7, 2),
(8, 2),
(10, 2),
(16, 2),
(17, 2),
(23, 2),
(7, 4),
(23, 4),
(25, 11),
(26, 11),
(11, 12),
(19, 12),
(25, 12),
(26, 12),
(7, 13),
(8, 13),
(16, 13),
(19, 13),
(23, 13),
(24, 13),
(12, 18),
(16, 18),
(17, 18),
(20, 18),
(22, 18),
(10, 20),
(16, 20),
(17, 20),
(23, 20),
(24, 20),
(2, 21),
(5, 21),
(6, 21),
(8, 21),
(9, 21),
(10, 21),
(12, 21),
(16, 21),
(17, 21),
(21, 21),
(22, 21),
(2, 22),
(5, 22),
(6, 22),
(7, 22),
(8, 22),
(9, 22),
(10, 22),
(12, 22),
(16, 22),
(17, 22),
(18, 22),
(21, 22),
(23, 22),
(24, 22),
(8, 23),
(7, 24),
(8, 24),
(10, 24),
(16, 24),
(18, 24),
(23, 24),
(24, 24),
(8, 25),
(10, 25),
(16, 25),
(24, 25),
(1, 27),
(8, 27),
(1, 28),
(2, 28),
(6, 28),
(8, 28),
(9, 28),
(16, 28),
(17, 28),
(1, 29),
(2, 29),
(6, 29),
(7, 29),
(8, 29),
(9, 29),
(11, 29),
(16, 29),
(17, 29),
(19, 29),
(20, 29),
(24, 29),
(1, 30),
(2, 30),
(6, 30),
(7, 30),
(9, 30),
(11, 30),
(16, 30),
(17, 30),
(19, 30),
(20, 30),
(21, 30),
(23, 30),
(24, 30),
(1, 31),
(2, 31),
(6, 31),
(7, 31),
(8, 31),
(16, 31),
(19, 31),
(20, 31),
(21, 31),
(22, 31),
(23, 31),
(7, 33),
(16, 33),
(23, 33),
(24, 33),
(9, 34),
(16, 34),
(2, 35),
(19, 35),
(21, 35),
(1, 36),
(2, 36),
(6, 36),
(7, 36),
(8, 36),
(11, 36),
(12, 36),
(16, 36),
(17, 36),
(18, 36),
(19, 36),
(20, 36),
(21, 36),
(22, 36),
(24, 36),
(25, 36),
(1, 37),
(2, 37),
(7, 37),
(11, 37),
(16, 37),
(17, 37),
(18, 37),
(19, 37),
(21, 37),
(22, 37),
(23, 37),
(25, 37),
(18, 43),
(6, 44),
(18, 44),
(25, 47),
(26, 47);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(63) DEFAULT NULL,
  `pinfile` varchar(63) NOT NULL,
  `buttonclass` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`, `pinfile`, `buttonclass`) VALUES
(1, 'Healthcare', 'redpin.png', 'btn-medical'),
(2, 'Housing', 'bluepin.png', 'btn-housing'),
(3, 'Food', 'greenpin.png', 'btn-food'),
(4, 'Jobs', 'yellowpin.png', 'btn-jobs'),
(5, 'Other Services', 'graypin.png', 'btn-other'),
(6, 'Target Demographics', '', ''),
(7, 'Languages Served', '', ''),
(8, 'Social Services', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `dayOfWeek`
--

CREATE TABLE IF NOT EXISTS `dayOfWeek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `longName` varchar(31) NOT NULL,
  `shortName` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `dayOfWeek`
--

INSERT INTO `dayOfWeek` (`id`, `longName`, `shortName`) VALUES
(1, 'Monday', 'MON'),
(2, 'Tuesday', 'TUE'),
(3, 'Wednesday', 'WED'),
(4, 'Thursday', 'THU'),
(5, 'Friday', 'FRI'),
(6, 'Saturday', 'SAT'),
(7, 'Sunday', 'SUN');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subcategory` varchar(63) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `sequence` float NOT NULL DEFAULT '99999',
  PRIMARY KEY (`id`),
  KEY `fk_subcategory_category1_idx` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `subcategory`, `category_id`, `sequence`) VALUES
(1, 'Dentist', 1, 99999),
(2, 'Mental Health', 1, 99999),
(3, 'Vision', 1, 99999),
(4, 'Emergency Shelter', 2, 99999),
(5, 'Transitional Housing', 2, 99999),
(6, 'Permanent', 2, 99999),
(7, 'Pantry', 3, 99999),
(8, 'Breakfast', 3, 99999),
(9, 'Lunch', 3, 99999),
(10, 'Dinner', 3, 99999),
(11, 'Employment Referral', 4, 99999),
(12, 'Job Training', 4, 99999),
(13, 'Legal Assistance', 5, 99999),
(14, 'Utility Assistance', 5, 99999),
(15, 'Transportation', 5, 99999),
(16, 'Showers', 5, 99999),
(17, 'Laundry', 5, 99999),
(18, 'Education Services', 5, 99999),
(19, 'Primary Health Physician', 1, 10),
(20, 'Domestic Violence', 5, 99999),
(21, 'Male', 6, 10),
(22, 'Female', 6, 15),
(23, 'LGBT', 6, 20),
(24, 'Single', 6, 25),
(25, 'Married', 6, 30),
(26, 'Widowed', 6, 35),
(27, 'Children (2-12)', 6, 50),
(28, 'Teens (13-17)', 6, 55),
(29, 'Young Adults (18-20)', 6, 60),
(30, 'Adults (21-64)', 6, 65),
(31, 'Seniors (65 or Older)', 6, 70),
(32, 'Infants (Under 2)', 6, 45),
(33, 'Single With Chidren', 6, 75),
(34, 'Family With Children', 6, 80),
(35, 'Veteran', 6, 99999),
(36, 'English', 7, 99999),
(37, 'Spanish', 7, 99999),
(38, 'Burmese', 7, 99999),
(39, 'Somali', 7, 99999),
(40, 'Arabic', 7, 99999),
(41, 'Vietnamese', 7, 99999),
(42, 'Bhutanese', 7, 99999),
(43, 'Hatian', 7, 99999),
(44, 'ASL', 7, 99999),
(45, 'Divoriced', 6, 40),
(46, 'IDD', 6, 99999),
(47, 'Job Placement', 4, 99999),
(48, 'Other', 1, 99999),
(49, 'Social Security', 8, 99999),
(50, 'Medicare', 8, 99999),
(51, 'Medicaid', 8, 99999),
(52, 'TANF', 8, 99999);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agencyHours`
--
ALTER TABLE `agencyHours`
  ADD CONSTRAINT `agency_id` FOREIGN KEY (`agency_id`) REFERENCES `agency` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `dayOfWeek_id` FOREIGN KEY (`dayOfWeek_id`) REFERENCES `dayOfWeek` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `agency_has_subcategories`
--
ALTER TABLE `agency_has_subcategories`
  ADD CONSTRAINT `fk_agency_has_subcategories_agency1` FOREIGN KEY (`agency_id`) REFERENCES `agency` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_agency_has_subcategories_subcategories1` FOREIGN KEY (`subcategories_id`) REFERENCES `subcategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `fk_subcategory_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
