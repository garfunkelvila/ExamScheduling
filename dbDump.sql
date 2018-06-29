/*
SQLyog Community v12.5.1 (64 bit)
MySQL - 10.1.30-MariaDB : Database - db_thesis
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_thesis` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_thesis`;

/*Table structure for table `class_students` */

DROP TABLE IF EXISTS `class_students`;

CREATE TABLE `class_students` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Class Id` int(10) unsigned NOT NULL,
  `Student Id` varchar(32) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Class Id` (`Class Id`),
  KEY `Student Id` (`Student Id`),
  CONSTRAINT `class_students_ibfk_1` FOREIGN KEY (`Class Id`) REFERENCES `classes` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_students_ibfk_2` FOREIGN KEY (`Student Id`) REFERENCES `users` (`Id Number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `class_students` */

/*Table structure for table `classes` */

DROP TABLE IF EXISTS `classes`;

CREATE TABLE `classes` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Section Code` char(1) NOT NULL,
  `Subject Id` int(10) unsigned NOT NULL,
  `Section Code Full` varchar(3) NOT NULL,
  `Prof_Id` varchar(32) NOT NULL,
  `Student Count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Subject Id` (`Subject Id`),
  CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`Subject Id`) REFERENCES `subjects` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `classes` */

/*Table structure for table `courses` */

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `Course Code` char(1) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Acronym` varchar(16) NOT NULL,
  `Dean_Id` varchar(32) NOT NULL,
  PRIMARY KEY (`Course Code`),
  KEY `Dean_Id` (`Dean_Id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`Dean_Id`) REFERENCES `users` (`Id Number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `courses` */

/*Table structure for table `dbconfig` */

DROP TABLE IF EXISTS `dbconfig`;

CREATE TABLE `dbconfig` (
  `Name` varchar(32) NOT NULL,
  `Int Val` int(11) DEFAULT NULL,
  `Bool Val` tinyint(1) DEFAULT NULL,
  `Str Val` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dbconfig` */

insert  into `dbconfig`(`Name`,`Int Val`,`Bool Val`,`Str Val`) values 
('Exam Period',3,NULL,'err'),
('Exam Visible',NULL,0,NULL),
('Stage',2,NULL,NULL);

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `Dean_Id` varchar(32) NOT NULL,
  `isEndorsed` tinyint(1) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Acronym` varchar(16) NOT NULL,
  PRIMARY KEY (`Dean_Id`),
  CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`Dean_Id`) REFERENCES `users` (`Id Number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `departments` */

/*Table structure for table `endorsed_exams` */

DROP TABLE IF EXISTS `endorsed_exams`;

CREATE TABLE `endorsed_exams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(11) unsigned NOT NULL,
  `Span` int(1) unsigned NOT NULL,
  `DayRank` int(1) unsigned NOT NULL,
  `ProctorId` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `ProctorId` (`ProctorId`),
  CONSTRAINT `endorsed_exams_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `endorsed_exams_ibfk_2` FOREIGN KEY (`ProctorId`) REFERENCES `users` (`Id Number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `endorsed_exams` */

/*Table structure for table `exam_dates` */

DROP TABLE IF EXISTS `exam_dates`;

CREATE TABLE `exam_dates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

/*Data for the table `exam_dates` */

insert  into `exam_dates`(`id`,`Date`) values 
(32,'2018-04-02'),
(33,'2018-04-03'),
(34,'2018-04-04');

/*Table structure for table `exam_schedules` */

DROP TABLE IF EXISTS `exam_schedules`;

CREATE TABLE `exam_schedules` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Endorsed Id` int(10) unsigned NOT NULL,
  `Day Id` int(11) unsigned NOT NULL,
  `Start` time NOT NULL,
  `End` time NOT NULL,
  `Room` varchar(32) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Endorsed Id` (`Endorsed Id`),
  KEY `Day Id` (`Day Id`),
  CONSTRAINT `exam_schedules_ibfk_1` FOREIGN KEY (`Endorsed Id`) REFERENCES `endorsed_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `exam_schedules_ibfk_2` FOREIGN KEY (`Day Id`) REFERENCES `exam_dates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `exam_schedules` */

/*Table structure for table `greetings` */

DROP TABLE IF EXISTS `greetings`;

CREATE TABLE `greetings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `greetings` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `greetings` */

insert  into `greetings`(`id`,`greetings`) values 
(1,'Hi'),
(2,'Hello'),
(3,'Welcome');

/*Table structure for table `guardian_monitor` */

DROP TABLE IF EXISTS `guardian_monitor`;

CREATE TABLE `guardian_monitor` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Guardian Id` varchar(32) NOT NULL,
  `Student Id` varchar(32) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Guardian Id` (`Guardian Id`),
  KEY `Student Id` (`Student Id`),
  CONSTRAINT `guardian_monitor_ibfk_1` FOREIGN KEY (`Guardian Id`) REFERENCES `users` (`Id Number`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `guardian_monitor_ibfk_2` FOREIGN KEY (`Student Id`) REFERENCES `users` (`Id Number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `guardian_monitor` */

/*Table structure for table `guardian_monitor_pre_reg` */

DROP TABLE IF EXISTS `guardian_monitor_pre_reg`;

CREATE TABLE `guardian_monitor_pre_reg` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Pre Reg Id` int(11) unsigned NOT NULL,
  `Student Id` varchar(32) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `guardian_monitor_pre_reg` */

/*Table structure for table `guardian_pre_reg` */

DROP TABLE IF EXISTS `guardian_pre_reg`;

CREATE TABLE `guardian_pre_reg` (
  `Pre Reg Id` int(10) unsigned NOT NULL,
  `Date Created` date NOT NULL,
  PRIMARY KEY (`Pre Reg Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `guardian_pre_reg` */

/*Table structure for table `login_attemp_counter` */

DROP TABLE IF EXISTS `login_attemp_counter`;

CREATE TABLE `login_attemp_counter` (
  `Ip` varchar(16) NOT NULL,
  `User Agent` varchar(256) NOT NULL,
  `Attemps` int(10) unsigned NOT NULL,
  `Last Try` datetime NOT NULL,
  PRIMARY KEY (`Ip`,`User Agent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `login_attemp_counter` */

/*Table structure for table `logs_page_visit` */

DROP TABLE IF EXISTS `logs_page_visit`;

CREATE TABLE `logs_page_visit` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Date Time` datetime NOT NULL,
  `HTTP_CLIENT_IP` varchar(32) DEFAULT NULL,
  `HTTP_X_FORWARDED_FOR` varchar(32) DEFAULT NULL,
  `HTTP_X_FORWARDED` varchar(32) DEFAULT NULL,
  `HTTP_FORWARDED_FOR` varchar(32) DEFAULT NULL,
  `HTTP_FORWARDED` varchar(32) DEFAULT NULL,
  `REMOTE_ADDR` varchar(32) DEFAULT NULL,
  `Url` varchar(255) NOT NULL,
  `User Agent` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=71672 DEFAULT CHARSET=latin1;

/*Data for the table `logs_page_visit` */

/*Table structure for table `logs_user_actions` */

DROP TABLE IF EXISTS `logs_user_actions`;

CREATE TABLE `logs_user_actions` (
  `Id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `User Id` varchar(32) NOT NULL,
  `Action Id` int(16) NOT NULL,
  `Message` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1011640 DEFAULT CHARSET=latin1;

/*Data for the table `logs_user_actions` */

/*Table structure for table `mergable_subjects` */

DROP TABLE IF EXISTS `mergable_subjects`;

CREATE TABLE `mergable_subjects` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Merge Id` int(10) unsigned NOT NULL COMMENT 'Match id of first',
  `Subject Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mergable_subjects` */

/*Table structure for table `mergable_subjects_pre_add` */

DROP TABLE IF EXISTS `mergable_subjects_pre_add`;

CREATE TABLE `mergable_subjects_pre_add` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Merge Id` int(10) unsigned NOT NULL,
  `Subject Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mergable_subjects_pre_add` */

/*Table structure for table `proctor_department` */

DROP TABLE IF EXISTS `proctor_department`;

CREATE TABLE `proctor_department` (
  `ProctorId` varchar(32) NOT NULL,
  `DeanId` varchar(32) NOT NULL,
  PRIMARY KEY (`ProctorId`,`DeanId`),
  KEY `DeanId` (`DeanId`),
  CONSTRAINT `proctor_department_ibfk_1` FOREIGN KEY (`ProctorId`) REFERENCES `users` (`Id Number`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proctor_department_ibfk_2` FOREIGN KEY (`DeanId`) REFERENCES `users` (`Id Number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `proctor_department` */

/*Table structure for table `room_list` */

DROP TABLE IF EXISTS `room_list`;

CREATE TABLE `room_list` (
  `Room Name` varchar(32) NOT NULL,
  PRIMARY KEY (`Room Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `room_list` */

insert  into `room_list`(`Room Name`) values 
('203'),
('204'),
('205'),
('206'),
('301'),
('303'),
('304'),
('401'),
('403'),
('406'),
('407'),
('CHEMLAB'),
('NAL 2'),
('NB 5'),
('NB 6'),
('PSYCHLAB');

/*Table structure for table `student_class_pre_reg` */

DROP TABLE IF EXISTS `student_class_pre_reg`;

CREATE TABLE `student_class_pre_reg` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Pre Reg Id` int(11) unsigned NOT NULL,
  `Class Id` int(11) unsigned NOT NULL COMMENT 'Literally the class ID',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `student_class_pre_reg` */

/*Table structure for table `student_pre_reg` */

DROP TABLE IF EXISTS `student_pre_reg`;

CREATE TABLE `student_pre_reg` (
  `Pre Reg Id` int(10) unsigned NOT NULL,
  `Date Created` date NOT NULL,
  PRIMARY KEY (`Pre Reg Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `student_pre_reg` */

/*Table structure for table `subjects` */

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) NOT NULL,
  `Code` varchar(16) NOT NULL,
  `Course Code` char(1) NOT NULL,
  `Year Level` int(1) unsigned NOT NULL,
  `Exam Length` int(10) unsigned DEFAULT NULL COMMENT 'Exam lengh in minutes',
  `Is Major` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Course Code` (`Course Code`),
  CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`Course Code`) REFERENCES `courses` (`Course Code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `subjects` */

/*Table structure for table `user_class` */

DROP TABLE IF EXISTS `user_class`;

CREATE TABLE `user_class` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User Id` varchar(32) NOT NULL,
  `Class Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `user_class` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `Id Number` varchar(32) NOT NULL,
  `User Name` varchar(32) NOT NULL,
  `First Name` varchar(32) NOT NULL,
  `Middle Name` varchar(32) DEFAULT NULL,
  `Family Name` varchar(32) NOT NULL,
  `Access Id` int(1) NOT NULL,
  `User Password` varchar(255) NOT NULL,
  `Date Added` date NOT NULL,
  `Time Added` time NOT NULL,
  `changePassDialog` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users` */

/*Table structure for table `users_access_types` */

DROP TABLE IF EXISTS `users_access_types`;

CREATE TABLE `users_access_types` (
  `Id` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Level` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users_access_types` */

insert  into `users_access_types`(`Id`,`Name`,`Level`) values 
(1,'SDO',1),
(2,'Professor',4),
(3,'Student',6),
(4,'Parent',5),
(5,'Dean',3),
(6,'ITS',2);

/*Table structure for table `users_actions` */

DROP TABLE IF EXISTS `users_actions`;

CREATE TABLE `users_actions` (
  `Id` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users_actions` */

insert  into `users_actions`(`Id`,`Name`) values 
(1,'Add'),
(2,'Edit'),
(3,'Delete');

/* Function  structure for function  `calc_SY` */

/*!50003 DROP FUNCTION IF EXISTS `calc_SY` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `calc_SY`() RETURNS varchar(16) CHARSET latin1
BEGIN
	set @month = (SELECT EXTRACT(MONTH FROM (SELECT `Date` FROM `exam_dates` ORDER BY `Date` ASC limit 1)));
	SET @year = (SELECT EXTRACT(YEAR FROM (SELECT `Date` FROM `exam_dates` ORDER BY `Date` ASC LIMIT 1)));
	
	if (@month > 4) then
		SET @year = (SELECT EXTRACT(YEAR FROM (SELECT `Date` FROM `exam_dates` ORDER BY `Date` ASC LIMIT 1)));
	else
		SET @year = (SELECT EXTRACT(YEAR FROM (SELECT `Date` FROM `exam_dates` ORDER BY `Date` ASC LIMIT 1)) - 1);
	end if;
	
	return @year;
    END */$$
DELIMITER ;

/* Function  structure for function  `checkSkedProfOk` */

/*!50003 DROP FUNCTION IF EXISTS `checkSkedProfOk` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `checkSkedProfOk`(`iDayId` INT(10) UNSIGNED, `iStart` TIME, `iEnd` TIME, `iProctorId` VARCHAR(32)) RETURNS tinyint(1)
BEGIN
	#CHECK IF PROF IS AVAILABLE AT GIVEN TIME ON THE DAY

	DECLARE time_a, time_b TIME DEFAULT NULL;
	DECLARE done INT DEFAULT FALSE;
	DECLARE prof_cursor CURSOR FOR (
		SELECT `Start`, `End`
		FROM `exam_schedules`
		join `endorsed_exams` on `exam_schedules`.`Endorsed Id` = `endorsed_exams`.`id`
		WHERE `endorsed_exams`.`ProctorId` = `iProctorId` AND `Day Id` = `iDayId`);
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
   
	SET @profHit = false;
    
	OPEN prof_cursor;
	prof_looper: LOOP
		FETCH prof_cursor INTO time_a, time_b;
		IF done THEN 
			LEAVE prof_looper;
		END IF;
		
		IF (time_a < `iEnd` AND time_b > `iStart`) THEN
			SET @profHit = TRUE;
			LEAVE prof_looper;
		END IF;
	END LOOP;
	CLOSE prof_cursor;
	
	RETURN (1 ^ @profHit);
    END */$$
DELIMITER ;

/* Function  structure for function  `checkSkedProfOk2` */

/*!50003 DROP FUNCTION IF EXISTS `checkSkedProfOk2` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `checkSkedProfOk2`(`iDayId` INT(10) UNSIGNED, `iStart` TIME, `iEnd` TIME, `iProctorId` VARCHAR(32), `skedId` int(10) unsigned) RETURNS tinyint(1)
BEGIN
	#CHECK IF PROF IS AVAILABLE AT GIVEN TIME ON THE DAY
	#USED UN UPDATE
	#MODIFIED SO IT CANT SEE ITSELF

	DECLARE time_a, time_b TIME DEFAULT NULL;
	DECLARE done INT DEFAULT FALSE;
	DECLARE prof_cursor CURSOR FOR (
		SELECT `Start`, `End`
		FROM `exam_schedules`
		JOIN `endorsed_exams` ON `exam_schedules`.`Endorsed Id` = `endorsed_exams`.`id` #To get proctor
		WHERE `endorsed_exams`.`ProctorId` = `iProctorId` AND `Day Id` = `iDayId` and `exam_schedules`.`Id` != `skedId`);
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
   
	SET @profHit = FALSE;
    
	OPEN prof_cursor;
	prof_looper: LOOP
		FETCH prof_cursor INTO time_a, time_b;
		IF done THEN 
			LEAVE prof_looper;
		END IF;
		
		IF (time_a < `iEnd` AND time_b > `iStart`) THEN
			SET @profHit = TRUE;
			LEAVE prof_looper;
		END IF;
	END LOOP;
	CLOSE prof_cursor;
	
	RETURN (1 ^ @profHit);
END */$$
DELIMITER ;

/* Function  structure for function  `checkSkedRoomOk` */

/*!50003 DROP FUNCTION IF EXISTS `checkSkedRoomOk` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `checkSkedRoomOk`(
							`iDayId` INT(10) UNSIGNED,
							`iStart` TIME,
							`iEnd` TIME,
							`iRoom` VARCHAR(32)) RETURNS tinyint(1)
BEGIN
	#Returns true if there is no hit

	DECLARE time_a, time_b TIME DEFAULT NULL;
	DECLARE done INT DEFAULT FALSE;
	DECLARE room_cursor CURSOR FOR (SELECT `Start`, `End` FROM `exam_schedules` WHERE `Room` = `iRoom` AND `Day Id` = `iDayId`);
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	SET @roomHit = false;
    
	OPEN room_cursor;
	room_looper: LOOP
		FETCH room_cursor INTO time_a, time_b;
		IF done THEN 
			LEAVE room_looper;
		END IF;
		
		IF (time_a < `iEnd` AND time_b > `iStart`) THEN
			SET @roomHit = TRUE; #It means it hit a schedule
			LEAVE room_looper;
		END IF;
	END LOOP;
	CLOSE room_cursor;
	
	return (1 ^ @roomHit); #Invert the return value xD
    END */$$
DELIMITER ;

/* Function  structure for function  `checkSkedRoomOk2` */

/*!50003 DROP FUNCTION IF EXISTS `checkSkedRoomOk2` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `checkSkedRoomOk2`(`iDayId` INT(10) UNSIGNED,
						`iStart` TIME,
						`iEnd` TIME,
						`iRoom` VARCHAR(32),
						`skedId` INT(10) UNSIGNED) RETURNS tinyint(1)
BEGIN
	#Returns true if there is no hit
	#USED UN UPDATE
	#MODIFIED SO IT CANT SEE ITSELF

	DECLARE time_a, time_b TIME DEFAULT NULL;
	DECLARE done INT DEFAULT FALSE;
	DECLARE room_cursor CURSOR FOR (SELECT `Start`, `End` FROM `exam_schedules` WHERE `Room` = `iRoom` AND `Day Id` = `iDayId` AND `Id` != `skedId`);
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	SET @roomHit = FALSE;
    
	OPEN room_cursor;
	room_looper: LOOP
		FETCH room_cursor INTO time_a, time_b;
		IF done THEN 
			LEAVE room_looper;
		END IF;
		
		IF (time_a < `iEnd` AND time_b > `iStart`) THEN
			SET @roomHit = TRUE; #It means it hit a schedule
			LEAVE room_looper;
		END IF;
	END LOOP;
	CLOSE room_cursor;
	
	RETURN (1 ^ @roomHit); #Invert the return value xD
END */$$
DELIMITER ;

/* Function  structure for function  `gen_random` */

/*!50003 DROP FUNCTION IF EXISTS `gen_random` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `gen_random`( `min` bigint, `max` BIGINT) RETURNS bigint(20)
BEGIN
	return (SELECT FLOOR(RAND()* (`max` - `min` + 1)) + `min`);
    END */$$
DELIMITER ;

/* Procedure structure for procedure `autofill_sections` */

/*!50003 DROP PROCEDURE IF EXISTS  `autofill_sections` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `autofill_sections`()
BEGIN

	END */$$
DELIMITER ;

/* Procedure structure for procedure `auto_fill_endorsment` */

/*!50003 DROP PROCEDURE IF EXISTS  `auto_fill_endorsment` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `auto_fill_endorsment`()
BEGIN
		#THIS IS NOT YET WORKING WELL
		
		# 1. Buffer days
		# 2. Buffer rooms
		# 3. Buffer Endorsed on the same day
		#    a. Order by span short to long, then by ID
		#    b. Insert them all
		
		
		DECLARE days_cursor	CURSOR FOR (SELECT @rank:=@rank+1 AS `rank`, `Id`, `Date` FROM `exam_dates` ORDER BY `Date` ASC); #FROM `select_exam_dates_ranked`
		declare rooms_cursor	cursor for (select `Room Name` from `room_list`);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `check_department` */

/*!50003 DROP PROCEDURE IF EXISTS  `check_department` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `check_department`(`uId` VARCHAR(32), `newDept` VARCHAR(255), `newAccr` VARCHAR(16))
BEGIN
		SET @isNameOk = FALSE;
		SET @isAcronymOk = FALSE;
		
		IF ((SELECT COUNT(`Name`) FROM `departments` WHERE `Name` = `newDept`) = 0) THEN
			SET @isNameOk = TRUE;
		END IF;
		IF ((SELECT COUNT(`Acronym`) FROM `departments` WHERE `Acronym` = `newAccr`) = 0) THEN
			SET @isAcronymOk = TRUE;
		END IF;
		SELECT @isNameOk, @isAcronymOk;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `count_subjects_dean` */

/*!50003 DROP PROCEDURE IF EXISTS  `count_subjects_dean` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `count_subjects_dean`(`uId` varchar(32))
BEGIN
		SELECT count(`subjects`.`Id`)
		FROM `subjects`
		JOIN `courses` ON `subjects`.`Course Code` = `courses`.`Course Code`
		WHERE `courses`.`Dean_Id` = `uId`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_all_exam_schedules` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_all_exam_schedules` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_all_exam_schedules`(`uId` varchar(32))
BEGIN
		UPDATE `db_thesis`.`dbconfig`
		SET
		`Bool Val` = 0
		WHERE
		`Name` = "Exam Visible" ;
		
		delete from `exam_dates`;
		delete from `exam_schedules`;
		
		IF (ROW_COUNT() != 0) THEN
			CALL `insert_logs`(`uId`,'3', 'Deleted all exam schedules.');
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_course` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_course` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_course`(`uId` VARCHAR(32),`iCode` CHAR(1))
BEGIN
		SET @courseName = (SELECT `Acronym` FROM `courses` WHERE `Course Code` = `iCode`);
		SET @assignedSubjects = (SELECT COUNT(`Id`) FROM `subjects` WHERE `Course Code` = `iCode`);
		
		DELETE FROM `classes` WHERE `Subject Id` in (select `Id` from `subjects` where `Course Code` = `iCode`);
		DELETE FROM `subjects` WHERE `Course Code` = `iCode`;
		#------------------------
		DELETE FROM `courses` WHERE `Course Code` = `iCode`;
		IF (ROW_COUNT() != 0) THEN
			CALL `insert_logs`(`uId`,'3', CONCAT('Deleted a course named ',@courseName,' including ',@assignedSubjects,' subjects within it'));
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `check_exam_schedule_mergable` */

/*!50003 DROP PROCEDURE IF EXISTS  `check_exam_schedule_mergable` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `check_exam_schedule_mergable`(
					   `iSubjectCode` VARCHAR(16),
					   `iSectionCodeFull` VARCHAR(3),
					   `iDayId` INT(10) UNSIGNED,
					   `iStart` TIME,
					   #`iEnd` TIME,
					   `length` INT(10),
					   `iRoom` VARCHAR(32),
					   `iProctorId` VARCHAR(32))
BEGIN
	SET @classId = (
		SELECT `classes`.`Id` FROM `classes`
		JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
		WHERE `Section Code Full` = `iSectionCodeFull` AND `subjects`.`Code` = `iSubjectCode`);
		
	#SET @`iEnd` = (SELECT ADDTIME(`iStart`,(SEC_TO_TIME((SELECT `Exam Length` FROM `subjects` WHERE `Id` = @classId) * 60))));
	SET @`iEnd` = (SELECT ADDTIME(`iStart`,(SEC_TO_TIME(`length` * 60)))); #From insert_exam_schedule
	
	#Check if match hit
	SET @subjectCodesCount = (SELECT count(`subjects`.`Code`) FROM `exam_schedules`
		JOIN `classes` ON `exam_schedules`.`Class Id` = `classes`.`Id`
		JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
		WHERE
		`subjects`.`Code` = `iSubjectCode` AND
		`exam_schedules`.`Day Id` = `iDayId` AND
		`exam_schedules`.`Start` = `iStart` AND
		`exam_schedules`.`End` = @`iEnd` AND
		`exam_schedules`.`Room` = `iRoom` AND
		`exam_schedules`.`Proctor Id` = `iProctorId`);
	#-----------
	SET @classSectionsCount = (SELECT COUNT(`classes`.`Section Code Full`) FROM `exam_schedules`
	JOIN `classes` ON `exam_schedules`.`Class Id` = `classes`.`Id`
	JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
	WHERE
	`subjects`.`Code` = `iSubjectCode` AND
	`exam_schedules`.`Day Id` = `iDayId` AND
	`exam_schedules`.`Start` = `iStart` AND
	`exam_schedules`.`End` = @`iEnd` AND
	`exam_schedules`.`Room` = `iRoom` AND
	`exam_schedules`.`Proctor Id` = `iProctorId`);
	#-----------
	set @subjectCodes = (SELECT GROUP_CONCAT(DISTINCT `subjects`.`Code` SEPARATOR ', ') FROM `exam_schedules`
	JOIN `classes` ON `exam_schedules`.`Class Id` = `classes`.`Id`
	JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
	where
	`subjects`.`Code` = `iSubjectCode` and
	`exam_schedules`.`Day Id` = `iDayId` and
	`exam_schedules`.`Start` = `iStart` and
	`exam_schedules`.`End` = @`iEnd` and
	`exam_schedules`.`Room` = `iRoom` and
	`exam_schedules`.`Proctor Id` = `iProctorId`);
	#-----------
	SET @classSections = (SELECT GROUP_CONCAT(DISTINCT `classes`.`Section Code Full` SEPARATOR ', ') FROM `exam_schedules`
	JOIN `classes` ON `exam_schedules`.`Class Id` = `classes`.`Id`
	JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
	WHERE
	`subjects`.`Code` = `iSubjectCode` AND
	`exam_schedules`.`Day Id` = `iDayId` AND
	`exam_schedules`.`Start` = `iStart` AND
	`exam_schedules`.`End` = @`iEnd` AND
	`exam_schedules`.`Room` = `iRoom` AND
	`exam_schedules`.`Proctor Id` = `iProctorId`);
	#-----------
	SELECT
	@subjectCodesCount as `SubjectsHitCount`,
	@classSectionsCount as `SectionsHitCount`,
	@subjectCodes as `SubjectsHit`,
	@classSections as `SectionsHit`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `check_login_attemps` */

/*!50003 DROP PROCEDURE IF EXISTS  `check_login_attemps` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `check_login_attemps`(`uIp` VARCHAR(16),`uUa` VARCHAR(256))
BEGIN
	set @ok = "False";
	set @attemps = (SELECT `Attemps` FROM `login_attemp_counter` WHERE `Ip` = `uIp` AND `User Agent` = `uUa`);
	set @lastTry = (SELECT `Last Try` FROM `login_attemp_counter` WHERE `Ip` = `uIp` AND `User Agent` = `uUa`);
	
	set @timeDiff = (SELECT TIME_TO_SEC(TIMEDIFF(NOW(), @lastTry)) / 60);
	
	if (@attemps < 10 or @timeDiff >= 15) then
		#CALL `reset_login_attemp_counter`(`uIp`,`uUa`);
		set @ok = "True";
	end if;
	
	if (select count(`Ip`) from `login_attemp_counter` WHERE `Ip` = `uIp` AND `User Agent` = `uUa`) = 0 then
		SET @ok = "True";
	end if;
	
	select @ok;
END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_class` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_class` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_class`(`uId` VARCHAR(32),`qId` int(10))
BEGIN
	set @isOk = false;
		set @subjectCode = (
			select `subjects`.`Code` from `classes`
			join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
			where `classes`.`Id` = `qId`
			);
		set @a = (
			select `subjects`.`Course Code` from `classes`
			join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
			where `classes`.`Id` = `qId`
			);
		set @b = (
			SELECT `subjects`.`Year Level` FROM `classes`
			JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
			WHERE `classes`.`Id` = `qId`
			);
		set @c = (
			select `classes`.`Section Code` from `classes` wHERE `classes`.`Id` = `qId`
			);
		SET @fullSectionCode = CONCAT(@a,@b,@c);
		
		#delete from `exam_schedules`
		#where `exam_schedules`.`Class Id` = `qId`;
		#*****************************
		DELETE FROM `classes`
		WHERE `classes`.`Id` = `qId`;
		#*****************************
		IF (ROW_COUNT() != 0) THEN
			CALL `insert_logs`(`uId`,'3', CONCAT('Deleted class ', @fullSectionCode , " ", @fullSectionCode));
			SET @isOk = True;
		END IF;
		select @isOk;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_endorsed_exams` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_endorsed_exams` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_endorsed_exams`(`uId` varchar(32), `ee` int(11) unsigned)
BEGIN
		
		DELETE FROM `db_thesis`.`endorsed_exams` 
			WHERE
			`id` = `ee` ;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_exam_date` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_exam_date` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_exam_date`(`uId` VARCHAR(32),`qId` INT(10) unsigned)
BEGIN
	#DELETE exam schedules related to exam date
	#DELETE exam date
	Set @ok = false;
	set @deletedDate = (select `Date` from `exam_dates` where `Id` = `qId`);
	
	delete from `exam_schedules`
	where `Day Id` = `qId`;
	
	DELETE FROM `exam_dates`
	WHERE `exam_dates`.`Id` = `qId`;
	
	IF (ROW_COUNT() != 0) THEN
		SET @ok = true;
		CALL `insert_logs`(`uId`,'3', CONCAT('Deleted exam schedule ', @deletedDate , "."));
	END IF;
	select @ok;
END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_init_course` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_init_course` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_init_course`(`uId` VARCHAR(32),`iCode` CHAR(1))
BEGIN
		set @isOk = false;
		DELETE FROM `init_courses` WHERE `Course Code` = `iCode`;
		IF (ROW_COUNT() != 0) THEN
			set @isOk = true;
		END IF;
		select @isOk;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_professor` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_professor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_professor`(`uId` VARCHAR(32),`qId` varchar(32))
BEGIN
		DELETE FROM `users` WHERE `Id Number` = `qId`;
		#delete from `proctor_department` where `ProctorId` = `qId`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_student_from_class` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_student_from_class` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_student_from_class`(`qId` int(10) unsigned)
BEGIN
		DELETE FROM `class_students` WHERE `Id` = `qId`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_user` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_user` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_user`(`uId` VARCHAR(32),`iIdNumber` VARCHAR(32))
BEGIN
	delete from `class_students` where `Student Id` not in (select `Id Number` from `users`);

	SET @uName = (SELECT `users`.`User Name` FROM `users` WHERE `Id Number` = `iIdNumber`);
	CALL `insert_logs`(`uId`,'3', CONCAT('Deleted a user named ',@uName,'.'));
	DELETE FROM `db_thesis`.`users` 
	WHERE
	`Id Number` = `iIdNumber` ;
END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_department` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_department` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_department`(`uId` VARCHAR(32),`iIdNumber` int(11))
BEGIN
		SET @uName = (SELECT `Name` FROM `departments` WHERE `Id` = `iIdNumber`);
		set @assignedSubjects = (select count(`Id`) from `subjects` where `Course Code` in (SELECT `Course Code` FROM `courses` WHERE `Department Id` = `iIdNumber`));
		
		
		#set @CourseCodes = (SELECT `Course Code` FROM `courses` WHERE `Department Id` = `iIdNumber`);
		#SET @CourseCodeCount = (SELECT COUNT(`Course Code`) FROM `courses` WHERE `Department Id` = `iIdNumber`);
		
		#delete classes assigned to subjects
		delete from `classes`
		where `Subject Id` in (
			select `Id` from `subjects` where `Course Code` in (
				SELECT `Course Code` FROM `courses` WHERE `Department Id` = `iIdNumber`
			)
		);
		
		#Delete subjects assigned
		delete from `subjects`
		where `Course Code` in (SELECT `Course Code` FROM `courses` WHERE `Department Id` = `iIdNumber`);
		
		#Delete course assigned
		delete from `courses`
		where `Department Id` = `iIdNumber`;
		
		#delete the department itself
		DELETE FROM `db_thesis`.`departments`
		WHERE `Id` = `iIdNumber`;
		
		IF (ROW_COUNT() != 0) THEN
			CALL `insert_logs`(`uId`,'3', CONCAT('Deleted a department named ',@uName,' including ',@assignedSubjects,' subjects assigned in it'));
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_exam_schedule` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_exam_schedule` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_exam_schedule`(`uId` VARCHAR(32),`qId` INT(10) unsigned)
BEGIN
	#set @classId = (select `exam_schedules`.`Class Id` from `exam_schedules` where `Id` = `qId`);
	#set @subject = (select `subjects`.`Code` from `classes` JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id` where `classes`.`Id` = @classId);
	#set @section = (SELECT `classes`.`Section Code Full` FROM `classes` WHERE `Id` = @classId);
	#DELETE FROM `db_thesis`.`exam_schedules` 
	#WHERE
	#`Id` = `qId` ;
	#
	#IF (ROW_COUNT() != 0) THEN
	#	CALL `insert_logs`(`uId`,'3', CONCAT('Deleted exam schedule for ', @subject , " ", @section, "."));
	#END IF;
	DELETE FROM `db_thesis`.`exam_schedules` WHERE `Id` = `qId` ;
END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_subject` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_subject` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_subject`(`uId` VARCHAR(32), `iIdNumber` INT(11))
BEGIN
	set @isOk = false;
	SET @uName = (SELECT `Name` FROM `subjects` WHERE `Id` = `iIdNumber`);
	
	#DELETE FROM `exam_schedules` WHERE `exam_schedules`.`Class Id` in (select `Id` from `classes` where `Subject Id` = `iIdNumber`);#test this
	#delete from `classes` where `Subject Id` = `iIdNumber`;
	#------- Delete from 
	#-------------------
	DELETE FROM `db_thesis`.`subjects` WHERE `Id` = `iIdNumber`;
	IF (ROW_COUNT() != 0) THEN
		CALL `insert_logs`(`uId`,'3', CONCAT('Deleted a subject named ',@uName,' including ','<classes not yet ready>',' classes assigned in it'));
		SET @isOk = true;
	END IF;
	select @isOk;
END */$$
DELIMITER ;

/* Procedure structure for procedure `enroll_pre_reg` */

/*!50003 DROP PROCEDURE IF EXISTS  `enroll_pre_reg` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `enroll_pre_reg`(`uId` VARCHAR(32),
							     `preRegId` int(10) unsigned,
							     `input_idNumber` VARCHAR(32),
							     `input_password` VARCHAR(255),
							     `fName` varchar(32),
							     `mName` varchar(32),
							     `lName` varchar(32))
BEGIN
		
		
		#Adding of pre reg is doing the cleanup
		#Register the user
		#Add the user to class

		set @match = (SELECT COUNT(`Id Number`) FROM `users` WHERE `Id Number` = `input_idNumber`);
		
		if (@match = 0) then
			#Register the user
			CALL `insert_user`(`uId`,`input_idNumber`, `fName`,`mName`,`lName`,3 ,`input_password`);
			#update `users` set `First Name` = `fName`,`Middle Name` = `mName`,`Family Name` = `lName` where `Id Number` = `input_idNumber`;
		
			#Register the user
			INSERT INTO `class_students` (`Class Id`,`Student Id`)
			SELECT `Class Id`, `input_idNumber`
			FROM `student_class_pre_reg`
			WHERE `Pre Reg Id` = `preRegId`;
		end if;
		
		SELECT @match, CONCAT(`First Name`,' ',`Family Name`) FROM `users` WHERE `Id Number` = `input_idNumber`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `finishExam` */

/*!50003 DROP PROCEDURE IF EXISTS  `finishExam` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `finishExam`()
BEGIN
	#   Finish Exam checklist
	#1. Reset dean isEndorsed
	#2. Reset dbConfig is status
	#3. Delete dates
	#4. Clear endorsed

	UPDATE `departments` SET `isEndorsed` = '0';
	update `dbconfig` set `Int Val` = '1' where `Name` = 'Stage';
	UPDATE `dbconfig` SET `Bool Val` = '0' WHERE `Name` = 'Exam Visible';
	DELETE FROM `exam_dates`;
	delete from `exam_schedules`;
	delete from `endorsed_exams`; #This one dont use day id, it uses the day rank
	END */$$
DELIMITER ;

/* Procedure structure for procedure `flip_exam_visibility` */

/*!50003 DROP PROCEDURE IF EXISTS  `flip_exam_visibility` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `flip_exam_visibility`(`uId` VARCHAR(32))
BEGIN
		set @current = (select `Bool Val` from `dbconfig` WHERE `Name` = 'Exam Visible' );
		
		
		IF (@current = 1) THEN
			UPDATE `db_thesis`.`dbconfig` SET `Bool Val` = '0' WHERE `Name` = 'Exam Visible' ;
		else
			UPDATE `db_thesis`.`dbconfig` SET `Bool Val` = '1' WHERE `Name` = 'Exam Visible' ;
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_course` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_course` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_course`(`uId` VARCHAR(32), `iName` VARCHAR(255), `iAcronym` VARCHAR(16), `iCode` char(1))
BEGIN
	set @isOk = false;
	set @isCodeOk = false;
	
	if ((select count(`Course Code`) from `courses` where `Course Code` = `iCode`) = 0) then SET @isCodeOk = true; end if;
	
	if (@isCodeOk = true) then
		INSERT INTO `db_thesis`.`courses`(
			`Name`, 
			`Acronym`,
			`Course Code`,
			`Dean_Id`
			)
			VALUES(
			`iName`, 
			`iAcronym`, 
			`iCode`,
			`uId`
			);
		SET @isOk = true;
	end if;		
	select @isOk, @isCodeOk;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_endorsed_exams` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_endorsed_exams` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_endorsed_exams`(`deanId` varchar(32), `iClass` int(11) unsigned, `iSpan` int(1) unsigned, `iProctorId` varchar(32),`iDay` int(1) unsigned)
BEGIN		
		set @isOk = false;
		set @profOk = false;
		if ((select count(`Id Number`) from `users` where `Id Number` = `iProctorId` and `Access Id` = '2') = 1) then SET @profOk = true; end if;
		
		if (@profOk = true) then
			INSERT INTO `db_thesis`.`endorsed_exams` (
				`class_id`, 
				`Span`, 
				`ProctorId`,
				`DayRank`)
				VALUES(
				`iClass`, 
				`iSpan`, 
				`iProctorId`,
				`iDay`
				);
			set @isOk = true;
		end if;
	select @isOk, @profOk;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_exam_date` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_exam_date` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_exam_date`(`uId` VARCHAR(32), `iDate` date)
BEGIN
	set @dateCount = (SELECT COUNT(`Id`) FROM `exam_dates` WHERE `Date` = `iDate`);
	set @ok = false;
	if ((`iDate` > CURDATE()) and (`iDate` <= DATE_ADD(CURDATE(),INTERVAL 30 DAY)) and @dateCount = 0) then
		#make date unique also here
		insert into `db_thesis`.`exam_dates`
			(`Date`)
		value
			(`iDate`);
		
		IF (ROW_COUNT() != 0) THEN
			CALL `insert_logs`(`uId`,'1', CONCAT('Added exam date ', `iDate`, '.'));
			SET @ok = true;
		END IF;
	end if;
	select @ok, `iDate`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_class` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_class` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_class`(`uId` VARCHAR(32),`iSectCode` VARCHAR(1), `iSubjId` VARCHAR(10),`pId` varchar(32))
BEGIN
	#MIMIC F3A pattern <Course,Year,Section>
	Set @a = (select `Course Code` from `subjects`
		where `Id` = `iSubjId`
		);
	set @b = (SELECT `Year Level` FROM `subjects`
		WHERE `Id` = `iSubjId`
		);
	set @subjCode = (SELECT `Code` FROM `subjects`
		WHERE `Id` = `iSubjId`
		);
	if (select count(`Id`) from `classes` where `Section Code` = `iSectCode` and `Subject Id` = `iSubjId`) = 0 then
		INSERT INTO `db_thesis`.`classes` (
		`Section Code`, 
		`Subject Id`,
		`Section Code Full`,
		`Prof_Id`
		)
		VALUES(
			upper(`iSectCode`), 
			`iSubjId`,
			UPPER(concat(@a, @b, `iSectCode`)),
			`pId`
		);
		
		IF (ROW_COUNT() != 0) THEN
			CALL `insert_logs`(`uId`,'1', CONCAT('Added class ', @a, @b, `iSectCode`, " - ", @subjCode, '.'));
		END IF;
	end if;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_department` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_department` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_department`(`uId` VARCHAR(32),`departmentName` VARCHAR(255), `departmentAcronym` varchar(16))
BEGIN
	SET @isOk = FALSE;
	SET @isNameOk = FALSE;
	SET @isAcronymOk = FALSE;
	set @isNotExist = false;
	
	IF ((SELECT COUNT(`Name`) FROM `departments` WHERE `Name` = `departmentName` AND `Dean_Id` != `uId`) = 0) THEN
		SET @isNameOk = TRUE;
	END IF;
	IF ((SELECT COUNT(`Acronym`) FROM `departments` WHERE `Acronym` = `departmentAcronym` AND `Dean_Id` != `uId`) = 0) THEN
		SET @isAcronymOk = TRUE;
	END IF;
	IF ((SELECT COUNT(`Dean_Id`) FROM `departments` WHERE `Dean_Id` = `uId`) = 0) THEN
		SET @isNotExist = TRUE;
	END IF;
	#------------------------------------------------------------------------------------------------------------
	IF ((@isNameOk = TRUE) AND (@isAcronymOk = TRUE) AND (@isNotExist = TRUE)) THEN
		#CALL `insert_logs`(`uId`,'1', CONCAT('Added a department named ', `departmentName`, '.'));
	
		INSERT INTO `db_thesis`.`departments` (
			`Dean_Id`,
			`Name`,
			`Acronym`)
		VALUES(
			`uId`,
			`departmentName`, 
			`departmentAcronym`);
		SET @isOk = true;
	end if;
	SELECT @isOk, @isNameOk, @isAcronymOk, @isNotExist;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_endorsed_exams_v2` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_endorsed_exams_v2` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_endorsed_exams_v2`(`deanId` VARCHAR(32), `section` varchar(3), `subjId` int(10) unsigned, `iSpan` INT(1) UNSIGNED, `iProctorId` VARCHAR(32),`iDay` INT(1) UNSIGNED)
BEGIN
		SET @isOk = FALSE;
		SET @profOk = FALSE;
		set @classOk = false; #NOT USED
		#THIS CAN RESULT AN ERROR IF RETURNED MULTIPLE ROW
		set @classId = (SELECT `Id`
				FROM `classes`
				WHERE
				`Section Code Full` = `section` AND
				`Subject Id` = `subjId`);
				
		IF ((SELECT COUNT(`Id Number`) FROM `users` WHERE `Id Number` = `iProctorId` AND `Access Id` = '2') = 1) THEN SET @profOk = TRUE; END IF;
		
		IF (@profOk = TRUE) THEN
			INSERT INTO `db_thesis`.`endorsed_exams` (
				`class_id`, 
				`Span`, 
				`ProctorId`,
				`DayRank`)
				VALUES(
				@classId, 
				`iSpan`, 
				`iProctorId`,
				`iDay`
				);
			SET @isOk = TRUE;
		END IF;
		SELECT @isOk, @profOk, @classId;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_exam_schedule_merge` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_exam_schedule_merge` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_exam_schedule_merge`(`endorseId` INT(10) UNSIGNED,
							   `iDayId` INT(10) UNSIGNED,
							   `iRoom` VARCHAR(32),
							   `iStart` TIME)
BEGIN
	#Check if time has start match
	#Check if room match
	#Check prof conflict
	
	set @`isOk`			= False;
	set @`HasTimeMatch`		= false;
	SET @`NotProctorConflict` 	= FALSE;
	
	#Some initializations----------------------------------
	SET @`iSpan` = (SELECT `Span` FROM `endorsed_exams` WHERE `id` = `endorseId`);
	SET @`iEnd` = (SELECT ADDTIME(`iStart`,(SEC_TO_TIME(@`iSpan` * 60))));
	SET @`iProctorId` = (SELECT `ProctorId` FROM `endorsed_exams` WHERE `id` = `endorseId`);
	
	
	IF ((select count(`Start`) from `exam_schedules` where `Room` = `iRoom` and `Start` = `iStart` and `Day Id` = `iDayId`) > 0) THEN SET @`HasTimeMatch` = true; END IF;
	SET @NotProctorConflict = `checkSkedProfOk`(`iDayId`,`iStart`,@`iEnd`,@`iProctorId`);
	
	IF (@`HasTimeMatch` = TRUE AND @`NotProctorConflict` = TRUE) THEN
		INSERT INTO `db_thesis`.`exam_schedules` 
			(`Endorsed Id`, 
			`Day Id`, 
			`Start`, 
			`End`, 
			`Room`
			)
			VALUES
			(`endorseId`, 
			`iDayId`, 
			`iStart`, 
			@`iEnd`, 
			`iRoom`
			);
		SET @`isOk` = TRUE;
	END IF;
	
	
	select @`isOk`,@`HasTimeMatch`,@`NotProctorConflict`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_exam_schedule_stack` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_exam_schedule_stack` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_exam_schedule_stack`(endorseId Integer(10), iDayId Integer(10), iRoom VarChar(32))
    NO SQL
BEGIN
	set @`NotLate` = false;
	SET @`NotExist` = FALSE;
	SET @`NotProctorConflict` = FALSE;
	set @`Ok` = false;
	
	#Get the last time, and set as start
	if ((SELECT count(`End`) FROM `exam_schedules` WHERE `Room` = `iRoom` and `Day Id` = `iDayId` ORDER BY `End` DESC LIMIT 1) > 0 ) then
		SET @`lastT` = (SELECT `End` FROM `exam_schedules` WHERE `Room` = `iRoom` AND `Day Id` = `iDayId` ORDER BY `End` DESC LIMIT 1);
	else
		SET @`lastT` = "14:00:00";
	end if;
	#Get proctor ID
	set @`proctorId` = (select `ProctorId` from `endorsed_exams` where `id` = `endorseId`);
	
	
	#Set end
	SET @`iSpan` = (SELECT `Span` FROM `endorsed_exams` WHERE `id` = `endorseId`);
	SET @`iEnd` = (SELECT ADDTIME(@`lastT`,(SEC_TO_TIME(@`iSpan` * 60))));
	
	#Check if too night 2:00 to 7:30
	if ((SELECT TIME_TO_SEC(TIMEDIFF(@`iEnd`,"20:00:00")) / 60) < 0) then set @`NotLate` = true; end if;
	#check if currently on the list
	IF ((SELECT count(`Endorsed Id`) from `exam_schedules` where `Endorsed Id` = `endorseId`) = 0) THEN SET @`NotExist` = TRUE; END IF;
	#Check if prof conflict
	if (select `checkSkedProfOk`(`iDayId`, @`lastT`, @`iEnd` , @`proctorId`) = true) then SET @`NotProctorConflict` = true; end if;
	
	if ((@`NotLate` = TRUE) and (@`NotExist` = TRUE) AND (@`NotProctorConflict` = TRUE)) then
		INSERT INTO `db_thesis`.`exam_schedules` 
			(`Endorsed Id`, 
			`Day Id`, 
			`Start`, 
			`End`, 
			`Room`
			)
			VALUES
			(`endorseId`, 
			`iDayId`, 
			@`lastT`, 
			@`iEnd`, 
			`iRoom`
			);
		SET @`Ok` = true;
	end if;
	select @`Ok`, @`NotLate`, @`NotExist`, @`NotProctorConflict`, @`lastT`, @`iEnd`, @`proctorId`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_guardian_monitor` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_guardian_monitor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_guardian_monitor`(`iParentId` INT(11) UNSIGNED, `iStudentId` VARCHAR(32))
BEGIN
		SET @match = (SELECT COUNT(`Id`) FROM `guardian_monitor` WHERE `Guardian Id` = `iParentId` AND `Student Id` = `iStudentId`);

		IF (@match = 0) THEN
			INSERT INTO `db_thesis`.`guardian_monitor` (`Guardian Id`, `Student Id`) VALUES (`iParentId`, `iStudentId`);
		END IF;
		
		SELECT @match,"match";
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_guardian_monitor_pre_reg` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_guardian_monitor_pre_reg` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_guardian_monitor_pre_reg`(`iPreRegId` int(11) unsigned, `iStudentId` varchar(32))
BEGIN
	#insert pre reg do the cleanup
	
	set @match = (select count(`Id`) from `guardian_monitor_pre_reg` where `Pre Reg Id` = `iPreRegId` and `Student Id` = `iStudentId`);

	if (@match = 0) then
		INSERT INTO `db_thesis`.`guardian_monitor_pre_reg` (`Pre Reg Id`, `Student Id`) VALUES (`iPreRegId`, `iStudentId`);
	end if;
	
	select @match,"match";
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_exam_schedule_old` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_exam_schedule_old` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_exam_schedule_old`(`uId` VARCHAR(32),
								   `iSubjectCode` varchar(16),
								   `iSectionCodeFull` varchar(3),
								   `iDayId` int(10) unsigned,
								   `iStart` time,
								   #`iEnd` time,
								   `length` int(10),
								   `iRoom` varchar(32),
								   `iProctorId` varchar(32),
								   `bypass` bool)
BEGIN
	
	
	
	#VALIDATE SECTION SUBJECT COMBINATION
	#check if start is less than end
	#CHECK IF ROOM IS AVAILABLE AT TIME
	#CHECK IF PROCTOR IS AVAILABLE AT TIME
	#CHECK IF CLASS IS ALREADY SCHEDULED
	#CHECK IF USER ENTERED IS A PROCTOR FOR REDUNDANCY
		
	
	set @classId = (
		SELECT `classes`.`Id` FROM `classes`
		join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
		WHERE `Section Code Full` = `iSectionCodeFull` and `subjects`.`Code` = `iSubjectCode`);
		
	SET @`iEnd` = (SELECT ADDTIME(`iStart`,(SEC_TO_TIME(`length` * 60))));
	#--------------------
	#VALIDATE SECTION SUBJECT COMBINATION
	#must be 1
	SET @classValid = (
		SELECT COUNT(`classes`.`Id`)
		FROM `classes`
		join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
		WHERE
		`subjects`.`Code` = `iSubjectCode` AND
		`classes`.`Section Code Full` = `iSectionCodeFull`);
	
	#--------------------
	#check if start is less than end
	#must be >= 60
	set @timeDiff = (SELECT TIME_TO_SEC(TIMEDIFF(@`iEnd`, `iStart`)) / 60);
		
	#check if time start is too early
	set @startDiff = (SELECT TIME_TO_SEC(TIMEDIFF(`iStart`,"14:00:00")) / 60);
	
	#Check if time ends beyond 8:00 pm
	SET @endDiff = (SELECT TIME_TO_SEC(TIMEDIFF(@`iEnd`,"20:00:00")) / 60);
	
	#--------------------
	#CHECK IF ROOM IS AVAILABLE AT TIME
	#must be false
	set @roomHit = `checkSkedRoomHit`(`iDayId`,`iStart`,@`iEnd`,`iRoom`);
	
	#--------------------
	#CHECK IF PROCTOR IS AVAILABLE AT TIME
	#must be 0
	set @procHit = `checkSkedProfHit`(`iDayId`,`iStart`,@`iEnd`,`iProctorId`);
	
	#--------------------
	#CHECK IF CLASS IS ALREADY SCHEDULED
	#must be 0	
	set @classHit = (SELECT COUNT(`Class Id`) FROM `exam_schedules` WHERE `Class Id` = @classId);
	
	#CHECK IF USER ENTERED IS A PROCTOR (x)
	#must be 1
	set @validProf = (select count(`Id Number`) from `users` where `Id Number` = `iProctorId` and `Access Id` = 2);
	
	
	
	#SELECT @classValid, @timeDiff, @roomHit, @procHit, @classHit, @validProf;
	#SELECT @classValid, @timeDiff, @roomHit, @procHit, @classHit, @validProf;
	#-----------
	set @Sucess = false;
	#-----------
	
	if `bypass` = true then
		INSERT INTO `db_thesis`.`exam_schedules`(
			`Class Id`,
			`Day Id`,
			`Start`,
			`End`,
			`Room`,
			`Proctor Id`
		)
		VALUES(
		@classId,
		`iDayId`,
		`iStart`,
		@`iEnd`,
		`iRoom`,
		`iProctorId`
		);
		
		IF (ROW_COUNT() != 0) THEN
			SET @rank = 0;
			SET @subject = (SELECT `subjects`.`Code` FROM `classes` JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id` WHERE `Section Code Full` = `iSectionCodeFull`);
			SET @examDay = (SELECT `rank` FROM (SELECT @rank:=@rank+1 AS `rank`, `Id`, `Date` FROM `exam_dates` ORDER BY `Date` ASC) AS `datesRanked`
				WHERE `Id` LIKE `iDayId`);
			CALL `insert_logs`(`uId`,'1', CONCAT('Added schedule for ', @subject, ' ', `iSectionCodeFull`, ' on day ', @examDay, ' of examination.'));
			
			SET @Sucess = TRUE;
		END IF;
	else
		IF (@classValid = 1 AND
		    @timeDiff >= 60 AND
		    @timeDiff <= 120 AND
		    @startDiff >= 0 AND
		    #@startDiff <= 360 AND
		    @endDiff <= 0 and
		    @roomHit = FALSE AND
		    @procHit = FALSE AND
		    @classHit = 0 AND
		    @validProf = 1) THEN
			INSERT INTO `db_thesis`.`exam_schedules`(
				`Class Id`,
				`Day Id`,
				`Start`,
				`End`,
				`Room`,
				`Proctor Id`
			)
			VALUES(
			@classId,
			`iDayId`,
			`iStart`,
			@`iEnd`,
			`iRoom`,
			`iProctorId`
			);
			
			IF (ROW_COUNT() != 0) THEN
				SET @rank = 0;
				SET @subject = (SELECT `subjects`.`Code` FROM `classes` JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id` WHERE `Section Code Full` = `iSectionCodeFull`);
				SET @examDay = (SELECT `rank` FROM (SELECT @rank:=@rank+1 AS `rank`, `Id`, `Date` FROM `exam_dates` ORDER BY `Date` ASC) AS `datesRanked`
					WHERE `Id` LIKE `iDayId`);
				CALL `insert_logs`(`uId`,'1', CONCAT('Added schedule for ', @subject, ' ', `iSectionCodeFull`, ' on day ', @examDay, ' of examination.'));
				
				SET @Sucess = TRUE;
			END IF;
		END IF;
	end if;
	
	
	
	SELECT
	@Sucess as `Sucess`,
	@classValid as `classValid`,
	@timeDiff as `timeDiff`,
	@startDiff as `startDiff`,
	@roomHit as `roomHit`,
	@procHit as `procHit`,
	@classHit as `classHit`,
	@validProf as `validProf`,
	@`iEnd`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_exam_schedule_time` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_exam_schedule_time` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_exam_schedule_time`(`endorseId` int(10) unsigned,
								   `iDayId` INT(10) UNSIGNED,
								   `iRoom` VARCHAR(32),
								   `iStart` TIME
								   )
BEGIN
	SET @`NotLate`			= FALSE; #1
	SET @`NotExist` 		= FALSE; #2
	SET @`NotProctorConflict` 	= FALSE; #4
	SET @`NotRoomConflict` 		= FALSE; #5
	SET @`HasTimeMatch`		= FALSE; #Merge, check if time-room relation has match must have exact start/end and same room.
	SET @`Ok` = FALSE;			 #Prof is available unless same room.
	set @`MergeOk` = false;
	

	#Some initializations----------------------------------
	set @`iSpan` = (select `Span` from `endorsed_exams` where `id` = `endorseId`);
	SET @`iEnd` = (SELECT ADDTIME(`iStart`,(SEC_TO_TIME(@`iSpan` * 60))));
	set @`iProctorId` = (select `ProctorId` from `endorsed_exams` where `id` = `endorseId`);
	
	#1)----------------------------------------------------
	IF ((SELECT TIME_TO_SEC(TIMEDIFF(@`iEnd`,"20:00:00")) / 60) < 0) THEN SET @`NotLate` = TRUE; END IF;
	#2)----------------------------------------------------
	IF ((SELECT COUNT(`Endorsed Id`) FROM `exam_schedules` WHERE `Endorsed Id` = `endorseId`) = 0) THEN SET @`NotExist` = TRUE; END IF;
	#3)----------------------------------------------------
	SET @NotProctorConflict = `checkSkedProfOk`(`iDayId`,`iStart`,@`iEnd`,@`iProctorId`);
	#4)----------------------------------------------------
	SET @NotRoomConflict = `checkSkedRoomOk`(`iDayId`,`iStart`,@`iEnd`,`iRoom`);
	#MERGE CANDIDATE	
	IF ((SELECT COUNT(`Start`) FROM `exam_schedules` WHERE `Room` = `iRoom` AND `Start` = `iStart` AND `Day Id` = `iDayId`) > 0) THEN SET @`HasTimeMatch` = TRUE; END IF;
	#------------------------------------------------------
	
	
	if (@`NotLate` = true and @`NotExist` = true and @`NotProctorConflict` = true and @`NotRoomConflict` = true) then
		INSERT INTO `db_thesis`.`exam_schedules` 
			(`Endorsed Id`, 
			`Day Id`, 
			`Start`, 
			`End`, 
			`Room`
			)
			VALUES
			(`endorseId`, 
			`iDayId`, 
			`iStart`, 
			@`iEnd`, 
			`iRoom`
			);
		SET @`Ok` = TRUE;
	end if;
	
	if (@`HasTimeMatch` = true and @`NotProctorConflict` = true) then
		SET @`MergeOk` = true;
	end if;
	
	
	#---------------------------
	select  @`Ok`, @`NotLate`, @`NotExist`, @`NotProctorConflict`, @`NotRoomConflict`,@`MergeOk`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_init_course` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_init_course` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_init_course`(`uId` VARCHAR(32), `iName` VARCHAR(255), `iAcronym` VARCHAR(16), `iCode` CHAR(1))
BEGIN
		SET @isOk = FALSE;
		SET @isAcronymOk = FALSE;
		
		IF (((SELECT COUNT(`Course Code`) FROM `courses` WHERE `Course Code` = `iCode`) = 0)and
		    ((SELECT COUNT(`Course Code`) FROM `init_courses` WHERE `Course Code` = `iCode`))) THEN SET @isAcronymOk = TRUE; END IF;
		
		IF (@isAcronymOk = TRUE) THEN
			INSERT INTO `init_courses`(
				`Name`, 
				`Acronym`,
				`Course Code`,
				`Dean_Id`
				)
				VALUES(
				`iName`, 
				`iAcronym`, 
				`iCode`,
				`uId`
				);
			SET @isOk = TRUE;
		END IF;		
		SELECT @isOk, @isAcronymOk;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_guardian_pre_reg_id` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_guardian_pre_reg_id` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_guardian_pre_reg_id`()
BEGIN
		#Clean unused Ids
		DELETE FROM `db_thesis`.`guardian_pre_reg` WHERE `Date Created` < (SELECT DATE_SUB(NOW(), INTERVAL 1 DAY));
		DELETE FROM `guardian_monitor_pre_reg` WHERE `Pre Reg Id` NOT IN (SELECT `Pre Reg Id` FROM `guardian_pre_reg`);

		#used upon creating and transfered to respective table upon registration
		reGenerateLooper: LOOP
			SET @tmpID = (SELECT (`gen_random`(10000,0)));
			SET @tmpIDExist = (SELECT COUNT(`Pre Reg Id`) FROM `guardian_pre_reg` WHERE `Pre Reg Id` = @tmpID);
			
			IF (@tmpIDExist = 0) THEN
				LEAVE reGenerateLooper;
			END IF;
		END LOOP reGenerateLooper;
		
		INSERT INTO `db_thesis`.`guardian_pre_reg` (`Pre Reg Id`,`Date Created`) VALUES (@tmpID,NOW());

		SELECT @tmpID;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_init_department` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_init_department` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_init_department`(`uId` VARCHAR(32),`departmentName` VARCHAR(255), `departmentAcronym` VARCHAR(16))
BEGIN
		SET @isOk = FALSE;
		SET @isNameOk = FALSE;
		SET @isAcronymOk = FALSE;
		
		IF (((SELECT COUNT(`Name`) FROM `departments` WHERE `Name` = `departmentName` AND `Dean_Id` != `uId`) = 0) and
		    ((select count(`Name`) from `init_departments` where `Name` = `departmentName` and `Dean_Id` != `uId`) = 0)) THEN
			SET @isNameOk = TRUE;
		END IF;
		
		
		
		IF (((SELECT COUNT(`Acronym`) FROM `departments` WHERE `Acronym` = `departmentAcronym` AND `Dean_Id` != `uId`) = 0) and
		    ((SELECT COUNT(`Acronym`) FROM `init_departments` WHERE `Acronym` = `departmentAcronym` AND `Dean_Id` != `uId`) = 0)) THEN
			SET @isAcronymOk = TRUE;
		END IF;
		#------------------------------------------------------------------------------------------------------------
		IF ((@isNameOk = TRUE) AND (@isAcronymOk = TRUE)) THEN
			INSERT INTO `init_departments` (
				`Dean_Id`,
				`Name`,
				`Acronym`)
			VALUES(
				`uId`,
				`departmentName`, 
				`departmentAcronym`);
			SET @isOk = TRUE;
		END IF;
		SELECT @isOk, @isNameOk, @isAcronymOk;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_logs` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_logs` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_logs`(`uId` VARCHAR(32),`type` int(16),`msg` varchar(255))
BEGIN
		INSERT INTO `db_thesis`.`logs_user_actions`(
			`User Id`,
			`Action Id`, 
			`Message`, 
			`Date`, 
			`Time`)
		VALUES(
			`uId`, 
			`type`, 
			`msg`, 
			CURDATE(), 
			CURTIME());
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_logs_page_visit` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_logs_page_visit` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_logs_page_visit`(`iHTTP_CLIENT_IP` varchar(32),
								     `iHTTP_X_FORWARDED_FOR` VARCHAR(32),
								     `iHTTP_X_FORWARDED` VARCHAR(32),
								     `iHTTP_FORWARDED_FOR` VARCHAR(32),
								     `iHTTP_FORWARDED` VARCHAR(32),
								     `iREMOTE_ADDR` VARCHAR(32),
								     `iUrl` varchar(255) ,`ua` varchar(255))
BEGIN
	if (`iREMOTE_ADDR` != "::1") then
		INSERT INTO `db_thesis`.`logs_page_visit`(
		`HTTP_CLIENT_IP`,
		`HTTP_X_FORWARDED_FOR`,
		`HTTP_X_FORWARDED`,
		`HTTP_FORWARDED_FOR`,
		`HTTP_FORWARDED`,
		`REMOTE_ADDR`, 
		`Url`, 
		`User Agent`,
		`Date Time`)
		VALUES(
		`iHTTP_CLIENT_IP`,
		`iHTTP_X_FORWARDED_FOR`,
		`iHTTP_X_FORWARDED`,
		`iHTTP_FORWARDED_FOR`,
		`iHTTP_FORWARDED`,
		`iREMOTE_ADDR`, 
		`iUrl`,
		`ua`,
		NOW());
	end if;



	
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_professor` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_professor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_professor`(`uId` VARCHAR(32), #DEAN, Tracks who did the task
					     `input_idNumber` VARCHAR(32),
					     `fName` VARCHAR(32),
					     `mName` VARCHAR(32),
					     `lName` VARCHAR(32),
					     `input_access` INT(1),
					     `input_password` VARCHAR(255)
					     )
BEGIN
		set @idCount = (select count(`Id Number`) from `users` where `Id Number` = `input_idNumber`);
		
		
		if (@idCount = 0) then
			INSERT INTO `users` (
				`Id Number`,
				`First Name`,
				`Middle Name`,
				`Family Name`,
				`User Password`,
				`Access Id`,
				`Date Added`,
				`Time Added`
			)
			VALUES(
				`input_idNumber`, 
				`fName`,
				`mName`,
				`lName`,
				`input_password`, 
				`input_access`, 
				CURDATE(), 
				NOW()
			);
			#---------------------------------
			insert into `proctor_department` (
				`ProctorId`,
				`DeanId`
			)
			values(
				`input_idNumber`,
				`uId`
			);
		end if;
		
		
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_prof_department` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_prof_department` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_prof_department`(`uId` VARCHAR(32),`input_idNumber` VARCHAR(32))
BEGIN
		INSERT INTO `proctor_department` (
			`ProctorId`,
			`DeanId`
		)
		VALUES(
			`input_idNumber`,
			`uId`
		);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_student_pre_reg_id` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_student_pre_reg_id` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_student_pre_reg_id`()
BEGIN
	#Clean unused Ids
	DELETE FROM `db_thesis`.`student_pre_reg` WHERE `Date Created` < (select date_sub(now(), interval 1 day));
	delete from `student_class_pre_reg` where `Pre Reg Id` not in (select `Pre Reg Id` from `student_pre_reg`);


	#used upon creating and transfered to respective table upon registration
	reGenerateLooper: loop
		SET @tmpID = (SELECT (`gen_random`(10000,0)));
		SET @tmpIDExist = (SELECT COUNT(`Pre Reg Id`) FROM `student_pre_reg` WHERE `Pre Reg Id` = @tmpID);
		
		IF (@tmpIDExist = 0) THEN
			leave reGenerateLooper;
		END IF;
	end loop reGenerateLooper;
	
	INSERT INTO `db_thesis`.`student_pre_reg` (`Pre Reg Id`,`Date Created`) VALUES (@tmpID,now());

	select @tmpID;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_subject` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_subject` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_subject`(`uId` VARCHAR(32),
							     `iName` VARCHAR(64),
							     `iCode` varchar(16),
							     `iLevel` INT(1),
							     `iCourse` char(1),
							     `iM` bool)
BEGIN
	set @codeCount = (SELECT COUNT(`Code`) FROM `subjects` WHERE `Code` = `iCode` and `Course Code` = `iCourse`);
	if  @codeCount = 0 then
		set @courseName = (select `Name` from `courses` where `Course Code` = `iCourse`);
		CALL `insert_logs`(`uId`,'1', CONCAT('Added a subject named ', `iName`, ' to ', @courseName ));
		INSERT INTO `db_thesis`.`subjects`(
			`Name`, 
			`Code`,
			`Year Level`,
			`Course Code`,
			`Is Major`
			)
			VALUES(
			`iName`,
			`iCode`,
			`iLevel`,
			`iCourse`,
			`iM`
			);
	end if;
END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_user` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_user` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user`(`uId` VARCHAR(32),
							  `input_idNumber` varchar(32),
							  `fName` VARCHAR(32),
							  `mName` VARCHAR(32),
							  `lName` VARCHAR(32),
							  `input_access` int(1),
							  `input_password` varchar(255))
BEGIN
	
	
	INSERT INTO `db_thesis`.`users` (
		`Id Number`, 
		`First Name`,
		`Middle Name`,
		`Family Name`,
		`User Password`, 
		`Access Id`, 
		`Date Added`, 
		`Time Added`
		)
		VALUES
		(`input_idNumber`, 
		`fName`,
		`mName`,
		`lName`,
		`input_password`, 
		`input_access`, 
		CURDATE(), 
		now()
		);
	#CALL `insert_logs`(`uId`,'1', CONCAT('Registered a user named ', `input_name`, '.'));
END */$$
DELIMITER ;

/* Procedure structure for procedure `reset_login_attemp_counter` */

/*!50003 DROP PROCEDURE IF EXISTS  `reset_login_attemp_counter` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `reset_login_attemp_counter`(`uIp` VARCHAR(16),`uUa` VARCHAR(256))
BEGIN
		SET @count = (SELECT COUNT(`Ip`) FROM `login_attemp_counter` WHERE `Ip` = `uIp` AND `User Agent` = `uUa`);
		
		IF @count = 0 THEN
			INSERT INTO `db_thesis`.`login_attemp_counter` 
			(`Ip`, 
			`Attemps`, 
			`User Agent`
			)
			VALUES
			(`uIp`, 
			'1', 
			`uUa`
			);
		ELSE
			UPDATE `db_thesis`.`login_attemp_counter` 
			SET
			`Attemps` = 0
			WHERE
			`Ip` = `uIp` AND `User Agent` = `uUa`;
		END IF;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_student_to_class` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_student_to_class` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_student_to_class`(`iClassId` int(10) unsigned, `iStudentId` varchar(32))
BEGIN
	#used when registered
	#pre reg also do simmilar to this to add the student into the sections
	set @exist = (select count(`Id`) from `class_students` where `Class Id` = `iClassId` and `Student Id` = `iStudentId`);
	set @validStudent = (select count(`Id Number`) from `users` where `Id Number` = `iStudentId` and `Access Id` = 3);
	set @validClass = (select count(`Id`) from `classes` where `Id` = `iClassId`);
	if (@exist = 0 and @validStudent = 1 and @validClass = 1) then
		insert into `db_thesis`.`class_students`(`Class Id`,`Student Id`)
		values (`iClassId`, `iStudentId`);
	end if;
END */$$
DELIMITER ;

/* Procedure structure for procedure `reg_guardian_pre_reg` */

/*!50003 DROP PROCEDURE IF EXISTS  `reg_guardian_pre_reg` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `reg_guardian_pre_reg`(`uId` VARCHAR(32),
					       `preRegId` INT(10) UNSIGNED,
					       `input_idNumber` VARCHAR(32),
					       `input_password` VARCHAR(255),
					       `fName` VARCHAR(32),
					       `mName` VARCHAR(32),
					       `lName` VARCHAR(32))
BEGIN
	#Adding of pre reg is doing the cleanup
	#Register the user
	#Add the user to class

	SET @match = (SELECT COUNT(`Id Number`) FROM `users` WHERE `Id Number` = `input_idNumber`);
	
	IF (@match = 0) THEN
		#Register the user
		CALL `insert_user`(`uId`,`input_idNumber`, `fName`,`mName`,`lName`,4,`input_password`);
		#UPDATE `users` SET `First Name` = `fName`,`Middle Name` = `mName`,`Family Name` = `lName` WHERE `Id Number` = `input_idNumber`;
	
		#Register the user
		INSERT INTO `guardian_monitor` (`Guardian Id`, `Student Id`)
		SELECT `input_idNumber`, `Student Id`
		FROM `guardian_monitor_pre_reg`
		WHERE `Pre Reg Id` = `preRegId`;
	END IF;
	
	SELECT @match, CONCAT(`First Name`,' ',`Family Name`) FROM `users` WHERE `Id Number` = `input_idNumber`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_classes` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_classes` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_classes`(`qCourseCode` CHAR(1), `qLevel` int(1) UNSIGNED)
BEGIN
		select
			`classes`.`Id`,
			`courses`.`Name` as `courseName`,
			`subjects`.`Name` as `subjectName`,
			`subjects`.`Code` as `subjectCode`,
			`subjects`.`Year Level` as `yearLevel`,
			`subjects`.`Course Code` as `courseCode`,
			`classes`.`Section Code Full` as `sectionCode`,
			concat(`users`.`First Name`, ' ', `users`.`Family Name`) as `FullName`,
			`classes`.`Prof_Id` as `ProfId`,
			(SELECT COUNT(`Id`) FROM `class_students` WHERE `Class Id` = `classes`.`Id`) AS `count`
		from `classes`
		join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
		join `courses` on `subjects`.`Course Code` = `courses`.`Course Code`
		join `users` on `classes`.`Prof_Id` = `users`.`Id Number`
		#join `users` on `classes`.`Prof_Id` = `users`.`Id Number`
		where
		`subjects`.`Course Code` = `qCourseCode` and
		`subjects`.`Year Level` = `qLevel`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_count_dean_day_endorsed` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_count_dean_day_endorsed` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_count_dean_day_endorsed`(`uId` varchar(32), `dayRank` INT(1) UNSIGNED)
BEGIN
		SELECT COUNT(`endorsed_exams`.`DayRank`)
FROM `endorsed_exams`
JOIN `classes` ON `endorsed_exams`.`class_id` = `classes`.`Id`
JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
JOIN `courses` ON `subjects`.`Course Code` = `courses`.`Course Code`
WHERE `endorsed_exams`.`DayRank` = `dayRank` AND `courses`.`Dean_Id` = `uId`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_courses` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_courses` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_courses`(`q` varchar(255))
BEGIN
		select `courses`.`Name`,`courses`.`Acronym`,`departments`.`Name` as `Department Name`, `courses`.`Department Id`, `courses`.`Course Code` from `courses`
		join `departments` on `courses`.`Department Id` = `departments`.`Id`
		where
		`courses`.`Name` LIKE(CONCAT("%",`q`,"%")) OR
		`courses`.`Acronym` LIKE(CONCAT("%",`q`,"%"))
		order by `departments`.`Name` asc,`courses`.`Name` asc;
		
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_courses_with_total` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_courses_with_total` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_courses_with_total`(`DeanId` varchar(32))
BEGIN
		SELECT 
		`courses`.`Course Code` as `CourseCode`,
		`courses`.`Name`,
		`courses`.`Acronym`,
		(SELECT COUNT(`subjects`.`Id`)
			 FROM `courses`
			 JOIN `subjects` ON `courses`.`Course Code` = `subjects`.`Course Code`
			 WHERE `courses`.`Dean_Id` = `DeanId` and `courses`.`Course Code` = `CourseCode`) AS `TotalSubjects`,#----------
		(SELECT COUNT(`classes`.`Id`)
			FROM `classes`
			join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
			JOIN `courses` on `subjects`.`Course Code` = `courses`.`Course Code`
			WHERE `courses`.`Dean_Id` = `DeanId` AND `courses`.`Course Code` = `CourseCode`) AS `TotalSections`#------------
		FROM `courses`
		where `courses`.`Dean_Id` = `deanId`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_dean_endorsed_total` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_dean_endorsed_total` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_dean_endorsed_total`(`deanId` VARCHAR(32))
BEGIN
	SELECT COUNT(`endorsed_exams`.`id`)
	FROM `endorsed_exams`
	JOIN `classes` ON `endorsed_exams`.`class_id` = `classes`.`Id`
	JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
	JOIN `courses` ON `subjects`.`Course Code` = `courses`.`Course Code`
	WHERE `courses`.`Dean_Id` = `deanId`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_dean_not_endorsed_total` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_dean_not_endorsed_total` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_dean_not_endorsed_total`(`deanId` VARCHAR(32))
BEGIN
		SELECT COUNT(`classes`.`Id`)
		FROM `classes`
		JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
		JOIN `courses` ON `subjects`.`Course Code` = `courses`.`Course Code`
		WHERE
		`courses`.`Dean_Id` = `deanId` AND
		`classes`.`Id` NOT IN (SELECT `class_id` FROM `endorsed_exams`);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_dean_total_sections` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_dean_total_sections` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_dean_total_sections`(`deanId` VARCHAR(32))
BEGIN
		SELECT COUNT(`classes`.`Id`)
		FROM `classes`
		JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
		JOIN `courses` ON `subjects`.`Course Code` = `courses`.`Course Code`
		WHERE
		`courses`.`Dean_Id` = `deanId`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_departments` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_departments` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_departments`(`q` varchar(255))
BEGIN
		SELECT `departments`.`Name`, `departments`.`Acronym`, `departments`.`isEndorsed`, `departments`.`Dean_Id`, concat(`First Name`, ' ', `Family Name`) as `FullName` FROM `departments`
		join `users` on `departments`.`Dean_Id` = `Id Number`
		where
		`departments`.`Name` like(concat("%",`q`,"%")) or
		`departments`.`Acronym` LIKE(CONCAT("%",`q`,"%"))
		ORDER BY `Name` ASC;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_employee_login` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_employee_login` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_employee_login`(`uId` VARCHAR(32), `uPass` VARCHAR(255))
BEGIN
	SELECT `Id Number`,`Access Id`
	FROM `users`
	WHERE `users`.`Id Number` = `uId` AND `users`.`User Password` = `uPass`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_dean_unscheduled_subjects` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_dean_unscheduled_subjects` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_dean_unscheduled_subjects`(`deanId` varchar(32), `fSubjCode` varchar(16), `fSectCode` varchar(3))
BEGIN
		SELECT
		`classes`.`Id` as `Id`,
		`classes`.`Section Code Full` as `SectFull`,
		concat(`users`.`First Name`, ' ', `users`.`Family Name`) as `profFullName`,
		`subjects`.`Name` as `SubjName`,
		`subjects`.`Code` as `SubjCode`,
		`subjects`.`Is Major` as `IsMajor`,
		`courses`.`Name` as `CourseName`
		FROM `classes`
		JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
		JOIN `courses` ON `subjects`.`Course Code` = `courses`.`Course Code`
		join `users` on `classes`.`Prof_Id` = `users`.`Id Number`
		WHERE
		`courses`.`Dean_Id` = `deanId` and
		(`subjects`.`Code` like concat("%",`fSubjCode`,"%") and `classes`.`Section Code Full` like CONCAT("%",`fSectCode`,"%")) and
		`classes`.`Id` not in (select `class_id` from `endorsed_exams`)
		order by `classes`.`Section Code Full` asc, `IsMajor` asc;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_endorsed_exams_dean` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_endorsed_exams_dean` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_endorsed_exams_dean`(`deanId` VARCHAR(32), `fSubjCode` VARCHAR(16), `fSectCode` VARCHAR(3), `dayRank` int(1) unsigned)
BEGIN
	select
		`endorsed_exams`.`id`,
		`endorsed_exams`.`class_id` as `clsId`, #for inner select
		`endorsed_exams`.`DayRank`,
		`subjects`.`Code`,
		`subjects`.`Name`,
		`classes`.`Section Code Full`,
		`endorsed_exams`.`Span` as `span`,
		(SELECT CONCAT(`users`.`First Name`, " ", `users`.`Family Name`)
			FROM `classes`
			JOIN `users` ON `classes`.`Prof_Id` = `users`.`Id Number`
			WHERE `classes`.`Id` = `clsId`) as `teacher`,
		concat(`users`.`First Name`, " ", `users`.`Family Name`) as `proctor`,
		`proctor_department`.`DeanId`
	from `endorsed_exams`
	join `classes` on `endorsed_exams`.`class_id` = `classes`.`Id`
	join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
	join `users` on `endorsed_exams`.`ProctorId` = `users`.`Id Number`
	JOIN `proctor_department` ON `endorsed_exams`.`ProctorId` = `proctor_department`.`ProctorId`
	where `proctor_department`.`DeanId` = `deanId` and
	`endorsed_exams`.`DayRank` = `dayRank` and
	(`subjects`.`Code` LIKE CONCAT("%",`fSubjCode`,"%") and `classes`.`Section Code Full` LIKE CONCAT("%",`fSectCode`,"%"));
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_endorsed_subjects` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_endorsed_subjects` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_endorsed_subjects`( `SubjName` varchar (32),  `SubjCode` varchar(32))
BEGIN
	SELECT 
		`exam_schedules_endorsed`.`id`, 
		`subjects`.`Name`,
		`subjects`.`Code`,
		`exam_schedules_endorsed`.`Span`, 
		`exam_schedules_endorsed`.`Priority`
	FROM 
		`exam_schedules_endorsed`
	JOIN
		`subjects` ON `exam_schedules_endorsed`.`subject_id` = `subjects`.`Id`
	where
		`subjects`.`Name` like concat("%",`SubjName`,"%") and
		`subjects`.`Code` LIKE CONCAT("%",`SubjCode`,"%");
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_exam_dates_ranked` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_exam_dates_ranked` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_exam_dates_ranked`(`qRankId` int(5) unsigned)
BEGIN
	SET @rank = 0;
	set @qRank = `qRankId`;
	
	if (`qRankId` = "") then
		set @qRank = "%";
	end if;
	#qRankId Replaced where to ID for print previews
	
	select * from (SELECT @rank:=@rank+1 AS `rank`, `Id`, `Date` FROM `exam_dates` ORDER BY `Date` ASC) as `datesRanked`
	where `Id` like @qrank;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_exam_schedules` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_exam_schedules` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_exam_schedules`(`qDayId` CHAR(2))
BEGIN
	SET @rank = 0;
	SELECT
		`exam_schedules`.`Id`,
		`endorsed_exams`.`ProctorId`,
		`endorsed_exams`.`class_id`,
		`classes`.`Section Code Full` as `SectFull`,
		`subjects`.`Code` AS `subjectCode`,
		`exam_schedules`.`Start`,
		`exam_schedules`.`End`,
		`exam_schedules`.`Room`,
		(select concat(`users`.`First Name`, " ", `users`.`Family Name`) from `users` where `Id Number` = `endorsed_exams`.`ProctorId`) as `User Name`,
		"0" as `Student Count`
	FROM `exam_schedules`
	join `endorsed_exams` on `exam_schedules`.`Endorsed Id` = `endorsed_exams`.`id`
	JOIN `classes` ON `endorsed_exams`.`class_id` = `classes`.`Id`
	JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
	WHERE `exam_schedules`.`Day Id` LIKE `qDayId`
	ORDER BY `exam_schedules`.`Start` asc, `subjects`.`Code` ASC;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_exam_schedules_search` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_exam_schedules_search` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_exam_schedules_search`(`qDayId` CHAR(2),`query` varchar(32))
BEGIN
	set @q = concat('%',`query`, '%');

	SET @rank = 0;
	SELECT
		`exam_schedules`.`Id`,
		`endorsed_exams`.`ProctorId`,
		`endorsed_exams`.`class_id`,
		`classes`.`Section Code Full` AS `SectFull`,
		`classes`.`Id` as `ClassId`,
		`subjects`.`Code` AS `subjectCode`,
		`exam_schedules`.`Start`,
		`exam_schedules`.`End`,
		`exam_schedules`.`Room`,
		(SELECT CONCAT(`users`.`First Name`, " ", `users`.`Family Name`) FROM `users` WHERE `Id Number` = `endorsed_exams`.`ProctorId`) AS `User Name`,
		"0" AS `Student Count`
	FROM `exam_schedules`
	JOIN `endorsed_exams` ON `exam_schedules`.`Endorsed Id` = `endorsed_exams`.`id`
	JOIN `classes` ON `endorsed_exams`.`class_id` = `classes`.`Id`
	JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
	WHERE
		`exam_schedules`.`Day Id` LIKE `qDayId` and
		(`subjects`.`Code` like @q or `classes`.`Section Code Full` like @q)
	ORDER BY `exam_schedules`.`Start` ASC, `subjects`.`Code` ASC;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_filtered_professors_dean` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_filtered_professors_dean` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_filtered_professors_dean`(`qDean` varchar(32), `q` varchar(32))
BEGIN
		select
			`Id Number`,
			concat(`First Name` , " ", `Family Name`) as `fName`
		from `users`
		where
		(`users`.`Id Number` in (select `ProctorId` from `proctor_department` where `DeanId` = `qDean`)) and
		(`First Name` like (concat('%', `q`,'%')) or
		`Family Name` like (concat('%', `q`,'%')) or
		`Id Number`   like (CONCAT('%', `q`,'%')));
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_guardian_monitor` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_guardian_monitor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_guardian_monitor`(`q` VARCHAR(32))
BEGIN
	SELECT
	`guardian_monitor`.`Id` as `Id`,
	concat(`users`.`First Name`, " ", `users`.`Middle Name`, " ", `users`.`Family Name`) as `Full Name`
	FROM `guardian_monitor`
	JOIN `users` ON `guardian_monitor`.`Student Id` = `users`.`Id Number`
	WHERE `guardian_monitor`.`Guardian Id` = `q`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_guardian_sked_count` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_guardian_sked_count` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_guardian_sked_count`(`qId` VARCHAR(32))
BEGIN
		SELECT COUNT(`exam_schedules`.`Id`)
		FROM `exam_schedules`
		JOIN `endorsed_exams` ON `exam_schedules`.`Endorsed Id` = `endorsed_exams`.`id`
		JOIN `class_students` ON `endorsed_exams`.`class_id` = `class_students`.`Class Id`
		WHERE `Student Id` IN (SELECT `Student Id` FROM `guardian_monitor` WHERE `Guardian Id` = `qId`);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_guardian_exam_schedule` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_guardian_exam_schedule` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_guardian_exam_schedule`(`userId` VARCHAR(32),`dateId` INT(10)UNSIGNED)
BEGIN
		select	
		`users`.`First Name`,	#STUDENT
		`users`.`Middle Name`,
		`users`.`Family Name`,
		`subjects`.`Name`,
		`subjects`.`Code`,
		`classes`.`Section Code Full`,
		`exam_schedules`.`Start`,
		`exam_schedules`.`End`,
		`exam_schedules`.`Room`
		#`exam_schedules`.`Proctor Id`,
		#(SELECT CONCAT(`users`.`First Name`, " ", `users`.`Family Name`)
		#	FROM `users`
		#	WHERE `Id Number` = `Proctor Id`) as `ProcName`
		from `users` 
		join `guardian_monitor` on `users`.`Id Number` = `guardian_monitor`.`Student Id`
		join `class_students` on `users`.`Id Number` = `class_students`.`Student Id`
		join `classes` on `class_students`.`Class Id` = `classes`.`Id`
		join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
		join `endorsed_exams` on `classes`.`Id` = `endorsed_exams`.`class_id`
		join `exam_schedules` on `endorsed_exams`.`id` = `exam_schedules`.`Endorsed Id`
		where `guardian_monitor`.`Guardian Id` = `userId` and `exam_schedules`.`Day Id` = `dateId`
		order by `exam_schedules`.`Start` asc;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_logs_user_actions` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_logs_user_actions` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_logs_user_actions`(`from` INT, `count` INT)
BEGIN
		SELECT
			`logs_user_actions`.`Id`,
			`users`.`User Name`,
			`logs_user_actions`.`Action Id`,
			`users_actions`.`Name` as `Action`,
			`logs_user_actions`.`Message`,
			`logs_user_actions`.`Date`,
			`logs_user_actions`.`Time`
		FROM `logs_user_actions`
		join `users` on `logs_user_actions`.`User Id` = `users`.`Id Number`
		join `users_actions` on `logs_user_actions`.`Action Id` = `users_actions`.`Id`
		order by `Date` desc,`Time`desc
		LIMIT `from`, `count` ;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_pre_reg_classes` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_pre_reg_classes` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_pre_reg_classes`(`StudentId` int(10) unsigned)
BEGIN
	#select where student is pre enrolled

	SELECT
		`student_class_pre_reg`.`Id` as `cId`,
		`subjects`.`Id` as `SubjId`,
		`subjects`.`Name` as `SubjName`,
		`subjects`.`Code` as `SubjCode`,
		`classes`.`Section Code Full` as `SectCode`
	FROM `student_class_pre_reg`
	join `student_pre_reg` on `student_class_pre_reg`.`Pre Reg Id` = `student_pre_reg`.`Pre Reg Id`
	JOIN `classes` ON `student_class_pre_reg`.`Class Id` = `classes`.`Id`
	JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
	WHERE `student_pre_reg`.`Pre Reg Id` = `StudentId`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_pre_reg_guardian_monitor` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_pre_reg_guardian_monitor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_pre_reg_guardian_monitor`(`GuardianId` INT(10) UNSIGNED)
BEGIN
		SELECT `guardian_monitor_pre_reg`.`Id` as `Id`, CONCAT(`users`.`First Name`, " ", `users`.`Middle Name`, " ", `users`.`Family Name`) AS `Name`, `users`.`Id Number` as `Id Number`
		FROM `guardian_monitor_pre_reg`
		JOIN `users` ON `guardian_monitor_pre_reg`.`Student Id` = `users`.`Id Number`
		WHERE `Pre Reg Id` = `GuardianId`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_proctor_exam_schedule` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_proctor_exam_schedule` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_proctor_exam_schedule`(`userId` VARCHAR(32),`dateId` INT(10)UNSIGNED)
BEGIN
		SELECT
		`exam_schedules`.`Start`,
		`exam_schedules`.`End`,
		`exam_schedules`.`Room`,
		`classes`.`Section Code Full` as `SectFull`,
		`subjects`.`Code` as `subjectCode`,
		'0' AS `Student Count`
		FROM `exam_schedules`
		join `endorsed_exams` on `exam_schedules`.`Endorsed Id` = `endorsed_exams`.`id`
		JOIN `classes` ON `endorsed_exams`.`class_id` = `classes`.`Id`
		JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
		#JOIN `users` ON `endorsed_exams`.`ProctorId` = `users`.`Id Number`
		WHERE `endorsed_exams`.`ProctorId` = `userId` AND `exam_schedules`.`Day Id` = `dateId`
		ORDER BY `exam_schedules`.`Start`, `subjects`.`Code` asc;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_professor_exam_schedule` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_professor_exam_schedule` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_professor_exam_schedule`(`qId` VARCHAR(32))
BEGIN
		SELECT COUNT(`ProctorId`)
		FROM `exam_schedules`
		join `endorsed_exams` on `exam_schedules`.`Endorsed Id` = `endorsed_exams`.`id`
		WHERE `ProctorId` = `qId`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_prof_department` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_prof_department` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_prof_department`(`qDeanID` varchar(32))
BEGIN
		SELECT
			CONCAT(`users`.`First Name`, ' ', `users`.`Family Name`) AS `fullName`,
			`users`.`First Name` as `fName`,
			`users`.`Middle Name` AS `mName`,
			`users`.`Family Name` AS `lName`,
			`users`.`Id Number`
		FROM `proctor_department`
		JOIN `users` ON `proctor_department`.`ProctorId` = `users`.`Id Number`
		where `proctor_department`.`DeanId` = `qDeanID`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_prof_department_no_dean` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_prof_department_no_dean` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_prof_department_no_dean`()
BEGIN
		select CONCAT(`users`.`First Name`, ' ', `users`.`Family Name`) AS `fullName`, `users`.`Id Number`
		from `users`
		where `Id Number` not in (select `ProctorId` from `proctor_department`) and `users`.`Access Id` = 2;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_random_greetings` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_random_greetings` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_random_greetings`(`uId` varchar(32))
BEGIN
		#https://stackoverflow.com/questions/4329396/mysql-select-10-random-rows-from-600k-rows-fast
		set @greet = (select `greetings` from `greetings` order by rand() limit 1);
		set @user = (select concat(`First Name`, ' ', `Family Name`) from `users` where `Id Number` = `uId`);
		select concat(@greet, ' ', @user, ' what do you want to do?');
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_sections_not_endorsed` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_sections_not_endorsed` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_sections_not_endorsed`(uId VarChar(32), q VarChar(3))
    NO SQL
BEGIN
		SELECT DISTINCT(`classes`.`Section Code Full`) as `sect`
		FROM `classes`
		join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
		join `courses` on `subjects`.`Course Code` = `courses`.`Course Code`
		WHERE
		`classes`.`Id` NOT IN (
			 SELECT `class_id`
			 FROM `endorsed_exams`) and 
		`classes`.`Section Code Full` like concat('%',`q`,'%') and 
		`courses`.`Dean_Id` = `uId`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_section_no_skeds` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_section_no_skeds` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_section_no_skeds`()
BEGIN
	SELECT `Section Code Full` FROM `classes` WHERE `Id` NOT IN (SELECT `Class Id` FROM `exam_schedules`);
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_student_sked_count` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_student_sked_count` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_student_sked_count`(`qId` varchar(32))
BEGIN
	SELECT COUNT(`exam_schedules`.`Id`)
	FROM `exam_schedules`
	join `endorsed_exams` on `exam_schedules`.`Endorsed Id` = `endorsed_exams`.`id`
	JOIN `class_students` ON `endorsed_exams`.`class_id` = `class_students`.`Class Id`
	WHERE `class_students`.`Student Id` = `qId`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_sdo_unscheduled_subjects` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_sdo_unscheduled_subjects` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_sdo_unscheduled_subjects`()
BEGIN
	#ENDORSED EXAMS
	select
		`endorsed_exams`.`id` as `eId`,
		(SELECT `departments`.`Acronym`
			FROM `endorsed_exams`
			JOIN `classes` ON `endorsed_exams`.`class_id` = `classes`.`Id`
			JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
			JOIN `courses` ON `subjects`.`Course Code` = `courses`.`Course Code`
			JOIN `users` ON `courses`.`Dean_Id` = `users`.`Id Number`
			JOIN `departments` ON `courses`.`Dean_Id` = `departments`.`Dean_Id`
			WHERE `endorsed_exams`.`id` = `eId`) as `dean`,
		`subjects`.`Code` as `subjCode`,
		`classes`.`Section Code Full` as `sectFull`,
		(select concat(`First Name`, ' ', `Family Name`) from `users` where `Id Number` = `endorsed_exams`.`ProctorId`) as `proctor`,
		`endorsed_exams`.`DayRank` as `day`,
		`endorsed_exams`.`Span` as `span`,
		(SELECT `departments`.`isEndorsed`
			FROM `endorsed_exams`
			JOIN `classes` ON `endorsed_exams`.`class_id` = `classes`.`Id`
			JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
			JOIN `courses` ON `subjects`.`Course Code` = `courses`.`Course Code`
			JOIN `users` ON `courses`.`Dean_Id` = `users`.`Id Number`
			JOIN `departments` ON `courses`.`Dean_Id` = `departments`.`Dean_Id`
			WHERE `endorsed_exams`.`id` = `eId`) as `Endorsed`
	from `endorsed_exams`
	join `classes` on `endorsed_exams`.`class_id` = `classes`.`Id`
	join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
	where `endorsed_exams`.`id` not in (select `Endorsed Id` from `exam_schedules`)
	order by `day` asc, `sectFull` asc;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_students_guardian` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_students_guardian` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_students_guardian`(`q` VARCHAR(32), `gId` INT(11) UNSIGNED)
BEGIN
		SELECT
			`users`.`Id Number`,
			`users`.`User Name`,
			`users`.`First Name`,
			`users`.`Middle Name`,
			`users`.`Family Name`,
			`users_access_types`.`Name` AS `Access`,
			`Access Id`,
			`Date Added`
		FROM `users`
		JOIN `users_access_types` ON `users`.`Access Id` = `users_access_types`.`Id`
		WHERE (
			`First Name` LIKE CONCAT("%", `q`, "%") OR
			`Middle Name` LIKE CONCAT("%", `q`, "%") OR
			`Family Name` LIKE CONCAT("%", `q`, "%") OR
			`Id Number` LIKE CONCAT("%", `q`, "%")
		) AND `Access Id` = "3" AND
		`Id Number` NOT IN (SELECT `Student Id`
			FROM `guardian_monitor`
			WHERE `Guardian Id` = `gId`)
		ORDER BY `Date Added` DESC,`Time Added` DESC
		LIMIT 10;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_students_guardian_pre_reg` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_students_guardian_pre_reg` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_students_guardian_pre_reg`(`q` VARCHAR(32), `gId` int(11) unsigned)
BEGIN
		SELECT
			`users`.`Id Number`,
			`users`.`User Name`,
			`users`.`First Name`,
			`users`.`Middle Name`,
			`users`.`Family Name`,
			`users_access_types`.`Name` AS `Access`,
			`Access Id`,
			`Date Added`
		FROM `users`
		JOIN `users_access_types` ON `users`.`Access Id` = `users_access_types`.`Id`
		WHERE (
			`First Name` LIKE CONCAT("%", `q`, "%") OR
			`Middle Name` LIKE CONCAT("%", `q`, "%") OR
			`Family Name` LIKE CONCAT("%", `q`, "%") OR
			`Id Number` LIKE CONCAT("%", `q`, "%")
		) AND `Access Id` = "3" and
		`Id Number` not in (select `Student Id`
			from `guardian_monitor_pre_reg`
			where `Pre Reg Id` = `gId`)
		ORDER BY `Date Added` DESC,`Time Added` DESC
		LIMIT 10;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_students_not_in_class` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_students_not_in_class` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_students_not_in_class`(`q` varchar(32), `classId` int(10) unsigned)
BEGIN
		set @classSubjectId = (select `classes`.`Subject Id` from `classes` where `classes`.`Id` = `classId`);
			
		
		SELECT
			`users`.`Id Number`,
			concat(`First Name`, " ", `Middle Name`, " ", `Family Name`) as 'Full Name'
			#`class_students`.`Class Id`
		FROM `users`
		#right JOIN `class_students` ON `users`.`Id Number` = `class_students`.`Student Id`
		WHERE
		`Access Id` = 3 AND
		(`users`.`First Name` like concat("%", `q` , "%") or 
		`users`.`Middle Name` LIKE CONCAT("%", `q` , "%") OR
		`users`.`Family Name` LIKE CONCAT("%", `q` , "%") OR
		`users`.`Id Number` like CONCAT("%", `q` , "%")) and
		(`users`.`Id Number` NOT IN (
			#--Remove user that is already in same class
			SELECT `class_students`.`Student Id`
			FROM `class_students`
			where `Class Id` = `classId`
			) and
		`users`.`Id Number` not in (
			#--Remove user that is already with same subject
			SELECT `class_students`.`Student Id`
			FROM `class_students`
			JOIN `classes` ON `class_students`.`Class Id` = `classes`.`Id`
			WHERE `classes`.`Subject Id` = @classSubjectId
			));
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_student_subjects` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_student_subjects` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_student_subjects`(`q` varchar(32))
BEGIN
		SELECT
		`class_students`.`Id` as `id`,	# to be able to remove from class
		`subjects`.`Name` as `Name`,
		`subjects`.`Code` as `Code`,
		`classes`.`Section Code Full` as `sectCode`
		FROM `users`
		JOIN `class_students` ON `users`.`Id Number` = `class_students`.`Student Id`
		JOIN `classes` ON `class_students`.`Class Id` = `classes`.`Id`
		JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
		where `users`.`Id Number` = `q`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_subjects_pre_register` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_subjects_pre_register` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_subjects_pre_register`(`iCode` char(1),`iLevel` int(1) unsigned, `iPreReg` int(11) unsigned)
BEGIN
		SELECT *
		FROM `subjects`
		WHERE
		`Course Code` = `iCode` AND
		`Year Level` = `iLevel` AND
		`Id` NOT IN (
			#dont show already added
			SELECT `subjects`.`Id`
			FROM `student_class_pre_reg`
			JOIN `classes` ON `student_class_pre_reg`.`Class Id` = `classes`.`Id`
			JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
			WHERE `student_class_pre_reg`.`Pre Reg Id` = `iPreReg`
			);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_subject_2` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_subject_2` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_subject_2`(`q` varchar(16))
BEGIN
		SELECT `subjects`.`Id`, `subjects`.`Name`, `courses`.`Acronym`, `subjects`.`Year Level`
		FROM `subjects`
		JOIN `courses` ON `subjects`.`Course Code` = `courses`.`Course Code`
		WHERE
		`subjects`.`Name` LIKE (CONCAT("%",`q`,"%")) OR
		`subjects`.`Code` LIKE (CONCAT("%",`q`,"%"));
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_subject_by_section` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_subject_by_section` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_subject_by_section`(`qSection` varchar(3))
BEGIN
		SELECT `subjects`.`Code`
		FROM `classes`
		join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
		WHERE `classes`.`Section Code Full` = `qSection`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_subject_code_from_section` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_subject_code_from_section` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_subject_code_from_section`(`uId` VARCHAR(32),`sect` varchar(3))
BEGIN
		SELECT `subjects`.`Code` as `subjC`, `subjects`.`Id` as `subjId` FROM `subjects`
		JOIN `classes` ON `subjects`.`Id` = `classes`.`Subject Id`
		WHERE `classes`.`Section Code Full` = `sect` AND `classes`.`Id` NOT IN (SELECT `class_id` FROM `endorsed_exams`);
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_student_exam_schedule` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_student_exam_schedule` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_student_exam_schedule`(`userId` varchar(32),`dateId` int(10)unsigned)
BEGIN
		SELECT
		#`exam_dates`.`Date`,
		`exam_schedules`.`Start`,
		`exam_schedules`.`End`,
		`exam_schedules`.`Room`,
		`classes`.`Section Code Full`,
		`subjects`.`Code`
		FROM `class_students`
		JOIN `classes` ON `class_students`.`Class Id` = `classes`.`Id`
		join `endorsed_exams` on `classes`.`Id` = `endorsed_exams`.`class_id`
		JOIN `exam_schedules` ON `endorsed_exams`.`id` = `exam_schedules`.`id`
		JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id`
		JOIN `users` ON `class_students`.`Student Id` = `users`.`Id Number`
		join `exam_dates` on `exam_schedules`.`Day Id` = `exam_dates`.`Id`
		WHERE `users`.`Id Number` = `userId` and `exam_dates`.`Id` = `dateId`
		order by `Start` asc;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_subjects` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_subjects` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_subjects`(`qDeptId` int(11), `qCourseId` char(1), `qLevel` int(1), `qSubj` varchar(32))
BEGIN	
	set @qDeptId = `qDeptId`;
	set @qCourseId = `qCourseId`;
	SET @qLevel = `qLevel`;
	
	if (`qDeptId` = '' or `qDeptId` = null) then
		set @qDeptId = '%';
	end if;
	
	IF (`qCourseId` = '' or `qCourseId` = null) THEN
		SET @qCourseId = '%';
	end if;
	
	IF (`qLevel` = '' OR `qLevel` = NULL) THEN
		SET @qLevel = '%';
	END IF;
	SELECT
		`subjects`.`Id`,
		`subjects`.`Name` AS `subjectName`,
		`subjects`.`Code` AS `subjectCode`,
		`subjects`.`Year Level` AS `subjectYear`,
		`departments`.`Name` AS `departmentName`,
		`courses`.`Course Code` AS `courseCode`,
		`courses`.`Name` AS `courseName`
	FROM `subjects`
	join `courses` on `subjects`.`Course Code` = `courses`.`Course Code`
	JOIN `departments` ON `courses`.`Department Id` = `departments`.`Id`
	#left join `classes` on `subjects`.`Id` = `classes`.`Subject Id`
	WHERE
		`departments`.`Id` like @qDeptId and
		`courses`.`Course Code` like @qCourseId and
		`subjects`.`Year Level` like @qLevel and
		#`classes`.`Section Code Full` like @qFullSect and
		(`subjects`.`Name` LIKE CONCAT('%', `qSubj`, '%') OR `subjects`.`Code` like CONCAT('%', `qSubj`, '%'))
	ORDER BY `departments`.`Name` asc, `courses`.`Name` asc, `Year Level` ASC, `subjects`.`Name` ASC;
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_subject_not_enrolled` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_subject_not_enrolled` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_subject_not_enrolled`(`q` VARCHAR(32), `uId` varchar(32))
BEGIN
	select
		`classes`.`Id`,
		`classes`.`Section Code Full` as `sectFull`,
		`subjects`.`Name` as `subjName`,
		`subjects`.`Code` as `subjCode`
	from `classes`
	join `subjects` on `classes`.`Subject Id` = `subjects`.`Id`
	where
	(`subjects`.`Name` like concat('%',`q`,'%') or
	`classes`.`Section Code Full` = `q`) and
	`classes`.`Id` not in (select `Class Id` from `class_students` where `Student Id` = `uId`) and
	`subjects`.`Id` not in (select `classes`.`Subject Id` from `class_students` join `classes` on `class_students`.`Class Id` = `classes`.`Id` where `class_students`.`Student Id` = `uId`);
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_teacher_from_class` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_teacher_from_class` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_teacher_from_class`(`sFull` varchar(3), `subjId` int(10) unsigned)
BEGIN
		set @`fullName` = (SELECT CONCAT(`users`.`First Name`, " ", `users`.`Family Name`)
			FROM `classes`
			JOIN `users` ON `classes`.`Prof_Id` = `users`.`Id Number`
			WHERE `Subject Id` = `subjId` AND `Section Code Full` = `sFull`);
		set @`uId` = (SELECT `Prof_Id`
			FROM `classes`
			WHERE `Subject Id` = `subjId` AND `Section Code Full` = `sFull`);
		set @`isMajor` = (select `Is Major` from `subjects` where `Id` = `subjId`);
		
		select @`uId`,@`fullName`, @`isMajor`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `select_users` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_users` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_users`(`q` varchar(32),`qAccType` int(1))
BEGIN
	if (`qAccType` = 0) then
		SELECT
			`users`.`Id Number`,
			`users`.`User Name`,
			`users`.`First Name`,
			`users`.`Middle Name`,
			`users`.`Family Name`,
			`users_access_types`.`Name` AS `Access`,
			`Access Id`,
			`Date Added`
		FROM `users`
		JOIN `users_access_types` ON `users`.`Access Id` = `users_access_types`.`Id`
		WHERE
			`First Name` LIKE CONCAT("%", `q`, "%") or
			`Middle Name` LIKE CONCAT("%", `q`, "%") OR
			`Family Name` LIKE CONCAT("%", `q`, "%") OR
			`Id Number` LIKE CONCAT("%", `q`, "%")
		ORDER BY `Date Added` DESC,`Time Added` DESC
		LIMIT 50;
	else
		SELECT
			`users`.`Id Number`,
			`users`.`User Name`,
			`users`.`First Name`,
			`users`.`Middle Name`,
			`users`.`Family Name`,
			`users_access_types`.`Name` AS `Access`,
			`Access Id`,
			`Date Added`
		FROM `users`
		JOIN `users_access_types` ON `users`.`Access Id` = `users_access_types`.`Id`
		WHERE (
			`First Name` LIKE CONCAT("%", `q`, "%") OR
			`Middle Name` LIKE CONCAT("%", `q`, "%") OR
			`Family Name` LIKE CONCAT("%", `q`, "%") OR
			`Id Number` LIKE CONCAT("%", `q`, "%")
		) and `Access Id` = `qAccType`
		ORDER BY `Date Added` DESC,`Time Added` DESC
		LIMIT 50;
	end if;
	
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `select_user_login` */

/*!50003 DROP PROCEDURE IF EXISTS  `select_user_login` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `select_user_login`(`uId` varchar(32))
BEGIN
		#SERIOUSLY!? equal sign accepts spaces after query!?
		SELECT `User Name`,`Id Number`,`users_access_types`.`Name` as `Access Name`, `Access Id` FROM `users`
		join `users_access_types` on `users`.`Access Id` = `users_access_types`.`Id`
		WHERE `Id Number` like (select replace(`uId`, '%', '$'));
	END */$$
DELIMITER ;

/* Procedure structure for procedure `test cursor` */

/*!50003 DROP PROCEDURE IF EXISTS  `test cursor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `test cursor`()
BEGIN
		set @aaaa = "Test aaaa";
		set @bbbb = "Test bbbb";
		
		select @aaaa, @bbbb;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `update_class_professor` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_class_professor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_class_professor`(`uId` varchar(32), `pId` varchar(32), `cId` int(10) unsigned)
BEGIN
		UPDATE `db_thesis`.`classes` SET `Prof_Id` = `pId` WHERE `Id` = `cId` ;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `update_exam_date` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_exam_date` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_exam_date`(`uId` VARCHAR(32), `qId` INT(10) UNSIGNED, `uNewDate` date)
BEGIN
	SET @ok = FALSE;
	set @oldDate = (select `Date` from `exam_dates` where `Id` = `qId`);
	SET @dateCount = (SELECT COUNT(`Id`) FROM `exam_dates` WHERE `Date` = `uNewDate`);
	
	IF ((`uNewDate` > CURDATE()) AND (`uNewDate` <= DATE_ADD(CURDATE(),INTERVAL 30 DAY)) AND @dateCount = 0) THEN
		UPDATE `exam_dates`
		SET
		`Date` = `uNewDate`
		WHERE
		`Id` = `qId` ;
		
		IF (ROW_COUNT() != 0) THEN
			CALL `insert_logs`(`uId`,'2', CONCAT('Moved exam day from ',@oldDate,' to ', `uNewDate`, "."));
			SET @ok = true;
		END IF;
	end if;
	SELECT @ok, `uNewDate`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_user` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_user` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user`(`uId` VARCHAR(32),
							  `sIdNumber` VARCHAR(32),
							  `fName` varchar(32),
							  `mName` VARCHAR(32),
							  `lName` VARCHAR(32))
BEGIN
	#--------------------------------------------------
	UPDATE `db_thesis`.`users`
	SET
	`First Name` = `fName`,
	`Middle Name` = `mName`,
	`Family Name` = `lName`
	#--------------------------------------------------
	WHERE `Id Number` = `sIdNumber`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_course` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_course` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_course`(`uId` VARCHAR(32), `iName` VARCHAR(255), `iAcronym` VARCHAR(16), `iCode` CHAR(1))
BEGIN
	set @nameMatch = (SELECT COUNT(`Name`) FROM `courses` WHERE `Name` = `iName` AND `Course Code` != `iCode`);
	set @AcronymMatch = (SELECT COUNT(`Acronym`) FROM `courses` WHERE `Acronym` = `iAcronym` AND `Course Code` != `iCode`);

	SET @oldName = (SELECT `courses`.`Name` FROM `courses` WHERE `Course Code` = `iCode`);
	
	IF (@nameMatch > 0) THEN
		select 'Existing course name.';
	ELSEIF (@AcronymMatch > 0 ) THEN
		select 'Existing acronym.';
	ELSE
		UPDATE `db_thesis`.`courses`
		SET
		`Name` = `iName`, 
		`Acronym` = `iAcronym`
		WHERE
		`Course Code` = `iCode` ;
		
		IF (ROW_COUNT() != 0) THEN
			CALL `insert_logs`(`uId`,'2', CONCAT('Edited ',@oldName,'.'));
		END IF;
	end if;
	
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_department` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_department` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_department`(`uId` VARCHAR(32), `newDept` varchar(255), `newAccr` varchar(16))
BEGIN
	set @isOk = false;
	set @isNameOk = false;
	set @isAcronymOk = false;
	
	IF ((SELECT COUNT(`Name`) FROM `departments` WHERE `Name` = `newDept` and `Dean_Id` != `uId`) = 0) then
		SET @isNameOk = true;
	end if;
	IF ((SELECT COUNT(`Acronym`) FROM `departments` WHERE `Acronym` = `newAccr` AND `Dean_Id` != `uId`) = 0) THEN
		SET @isAcronymOk = TRUE;
	END IF;
	
	SET @uName = (SELECT `departments`.`Name` FROM `departments` WHERE `Dean_Id` = `uId`);

	IF ((@isNameOk = true) and (@isAcronymOk = TRUE)) THEN
		UPDATE `db_thesis`.`departments` 
		SET
		`Name` = `newDept`, 
		`Acronym` = `newAccr`
		WHERE
		`Dean_Id` = `uId` ;
		
		CALL `insert_logs`(`uId`,'2', CONCAT('Edited ',@uName,'.'));
		SET @isOk = true;
	end if;
	select @isOk, @isNameOk, @isAcronymOk;
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_exam_schedule_merge` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_exam_schedule_merge` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_exam_schedule_merge`(`skedId` INT(10) UNSIGNED,
							   `iDayId` INT(10) UNSIGNED,
							   `iRoom` VARCHAR(32),
							   `iStart` TIME)
BEGIN
	#Check if time has start match
	#Check if room match
	#Check prof conflict
	
	SET @`isOk`			= FALSE;
	SET @`HasTimeMatch`		= FALSE;
	SET @`NotProctorConflict` 	= FALSE;
	
	#Some initializations----------------------------------
	set @`endorseId` = (select `Endorsed Id` from `exam_schedules` where `Id` = `skedId`);
	SET @`iSpan` = (SELECT `Span` FROM `endorsed_exams` WHERE `id` = @`endorseId`);
	SET @`iEnd` = (SELECT ADDTIME(`iStart`,(SEC_TO_TIME(@`iSpan` * 60))));
	SET @`iProctorId` = (SELECT `ProctorId` FROM `endorsed_exams` WHERE `id` = @`endorseId`);
	
	
	IF ((SELECT COUNT(`Start`) FROM `exam_schedules` WHERE `Room` = `iRoom` AND `Start` = `iStart` AND `Day Id` = `iDayId`) > 0) THEN SET @`HasTimeMatch` = TRUE; END IF;
	SET @NotProctorConflict = `checkSkedProfOk2`(`iDayId`,`iStart`,@`iEnd`,@`iProctorId`,`skedId`);
	
	IF (@`HasTimeMatch` = TRUE AND @`NotProctorConflict` = TRUE) THEN
		UPDATE `db_thesis`.`exam_schedules` 
			SET
			`Day Id` = `iDayId`, 
			`Start` = `iStart`, 
			`End` = @`iEnd`, 
			`Room` = `iRoom`
			
			WHERE
			`Id` = `skedId`;

		SET @`isOk` = TRUE;
	END IF;

	SELECT @`isOk`,@`HasTimeMatch`,@`NotProctorConflict`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_exam_schedule_stack` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_exam_schedule_stack` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_exam_schedule_stack`(`skedId` INT(10) UNSIGNED, iDayId INTEGER(10), iRoom VARCHAR(32))
BEGIN
	SET @`NotLate` = FALSE;
	SET @`Exist` = FALSE;
	SET @`NotProctorConflict` = FALSE;
	SET @`Ok` = FALSE;
	
	set @`endorseId` = (select `Endorsed Id` from `exam_schedules` where `Id` = `skedId`);
	
	#Get the last time, and set as start
	IF ((SELECT COUNT(`End`) FROM `exam_schedules` WHERE `Room` = `iRoom` AND `Day Id` = `iDayId` ORDER BY `End` DESC LIMIT 1) > 0 ) THEN
		SET @`lastT` = (SELECT `End` FROM `exam_schedules` WHERE `Room` = `iRoom` AND `Day Id` = `iDayId` and `Id` != `skedId` ORDER BY `End` DESC LIMIT 1);
	ELSE
		SET @`lastT` = "14:00:00";
	END IF;
	#Get proctor ID
	SET @`proctorId` = (SELECT `ProctorId` FROM `endorsed_exams` WHERE `id` = @`endorseId`);
	
	
	#Set end
	SET @`iSpan` = (SELECT `Span` FROM `endorsed_exams` WHERE `id` = @`endorseId`);
	SET @`iEnd` = (SELECT ADDTIME(@`lastT`,(SEC_TO_TIME(@`iSpan` * 60))));
	
	#Check if too night 2:00 to 7:30
	IF ((SELECT TIME_TO_SEC(TIMEDIFF(@`iEnd`,"20:00:00")) / 60) < 0) THEN SET @`NotLate` = TRUE; END IF;
	#check if currently on the list
	IF ((SELECT COUNT(`Id`) FROM `exam_schedules` WHERE `Id` = `skedId`) = 1) THEN SET @`Exist` = TRUE; END IF;
	#Check if prof conflict
	IF (SELECT `checkSkedProfOk2`(`iDayId`, @`lastT`, @`iEnd` , @`proctorId`,`skedId`) = TRUE) THEN SET @`NotProctorConflict` = TRUE; END IF;
	
	IF ((@`NotLate` = TRUE) AND (@`Exist` = TRUE) AND (@`NotProctorConflict` = TRUE)) THEN
		UPDATE `db_thesis`.`exam_schedules` 
			SET
			`Day Id` = `iDayId`, 
			`Start` = @`lastT`, 
			`End` = @`iEnd`, 
			`Room` = `iRoom`
			
			WHERE
			`Id` = `skedId` ;

		SET @`Ok` = TRUE;
	END IF;
	SELECT @`Ok`, @`NotLate`, @`Exist`, @`NotProctorConflict`, @`lastT`, @`iEnd`, @`proctorId`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_exam_schedule_time` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_exam_schedule_time` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_exam_schedule_time`(`skedId` INT(10) UNSIGNED,
									`iDayId` INT(10) UNSIGNED,
									`iRoom` VARCHAR(32),
									`iStart` TIME)
BEGIN
	SET @`NotLate`			= FALSE; #1
	SET @`Exist` 			= FALSE; #2
	SET @`NotProctorConflict` 	= FALSE; #4
	SET @`NotRoomConflict` 		= FALSE; #5
	SET @`HasTimeMatch`		= FALSE; #Merge, check if time-room relation has match must have exact start/end and same room.
	SET @`Ok` = FALSE;			 #Prof is available unless same room.
	SET @`MergeOk` = FALSE;
	

	#Initializations----------------------------------
	SET @`endorseId` = (SELECT `Endorsed Id` FROM `exam_schedules` WHERE `Id` = `skedId`);
	SET @`iSpan` = (SELECT `Span` FROM `endorsed_exams` WHERE `id` = @`endorseId`);
	SET @`iEnd` = (SELECT ADDTIME(`iStart`,(SEC_TO_TIME(@`iSpan` * 60))));
	SET @`iProctorId` = (SELECT `ProctorId` FROM `endorsed_exams` WHERE `id` = @`endorseId`);
	
	
	#1)----------------------------------------------------
	IF ((SELECT TIME_TO_SEC(TIMEDIFF(@`iEnd`,"20:00:00")) / 60) < 0) THEN SET @`NotLate` = TRUE; END IF;
	#2)----------------------------------------------------
	IF ((SELECT COUNT(`Id`) FROM `exam_schedules` WHERE `Id` = `skedId`) = 1) THEN SET @`Exist` = TRUE; END IF;
	#3)----------------------------------------------------
	SET @NotProctorConflict = `checkSkedProfOk2`(`iDayId`,`iStart`,@`iEnd`,@`iProctorId`,`skedId`);
	#4)----------------------------------------------------
	SET @NotRoomConflict = `checkSkedRoomOk2`(`iDayId`,`iStart`,@`iEnd`,`iRoom`,`skedId`);
	#MERGE CANDIDATE	
	IF ((SELECT COUNT(`Start`) FROM `exam_schedules` WHERE `Room` = `iRoom` AND `Start` = `iStart` AND `Day Id` = `iDayId`) > 0) THEN SET @`HasTimeMatch` = TRUE; END IF;
	#------------------------------------------------------
	
	IF (@`NotLate` = TRUE AND @`Exist` = TRUE AND @`NotProctorConflict` = TRUE AND @`NotRoomConflict` = TRUE) THEN
		UPDATE `db_thesis`.`exam_schedules` 
			SET
			`Day Id` = `iDayId`, 
			`Start` = `iStart`, 
			`End` = @`iEnd`, 
			`Room` = `iRoom`
			WHERE
			`Id` = `skedId` ;	
			
		SET @`Ok` = TRUE;#
	END IF;
	
	IF (@`HasTimeMatch` = TRUE AND @`NotProctorConflict` = TRUE) THEN
		SET @`MergeOk` = TRUE;
	END IF;
	
	
	#---------------------------
	SELECT  @`Ok`, @`NotLate`, @`Exist`, @`NotProctorConflict`, @`NotRoomConflict`,@`MergeOk`;
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_init_course` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_init_course` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_init_course`(`uId` VARCHAR(32), `iName` VARCHAR(255), `iAcronym` VARCHAR(16), `iCode` CHAR(1))
BEGIN
		set @isOk = false;
		set @msg = '';
		SET @nameMatch = (SELECT COUNT(`Name`) FROM `init_courses` WHERE `Name` = `iName` AND `Course Code` != `iCode`);
		SET @AcronymMatch = (SELECT COUNT(`Acronym`) FROM `init_courses` WHERE `Acronym` = `iAcronym` AND `Course Code` != `iCode`);

		SET @oldName = (SELECT `courses`.`Name` FROM `init_courses` WHERE `Course Code` = `iCode`);
		
		IF (@nameMatch > 0) THEN
			SET @msg = 'Existing course name.';
		ELSEIF (@AcronymMatch > 0 ) THEN
			SET @msg =  'Existing acronym.';
		ELSE
			UPDATE `init_courses`
			SET
			`Name` = `iName`, 
			`Acronym` = `iAcronym`
			WHERE
			`Course Code` = `iCode` ;
			
			IF (ROW_COUNT() != 0) THEN
				#CALL `insert_logs`(`uId`,'2', CONCAT('Edited ',@oldName,'.'));
				SET @isOk = true;
			END IF;
		END IF;
		select @isOk, @msg;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `update_init_department` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_init_department` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_init_department`(`uId` VARCHAR(32), `newDept` VARCHAR(255), `newAccr` VARCHAR(16))
BEGIN
	#DONT USE
	SET @isOk = FALSE;
	SET @isNameOk = FALSE;
	SET @isAcronymOk = FALSE;
	
	IF (((SELECT COUNT(`Name`) FROM `departments` WHERE `Name` = `departmentName` AND `Dean_Id` != `uId`) = 0) AND
	    ((SELECT COUNT(`Name`) FROM `init_departments` WHERE `Name` = `departmentName` AND `Dean_Id` != `uId`) = 0)) THEN
		SET @isNameOk = TRUE;
	END IF;
			
	IF (((SELECT COUNT(`Acronym`) FROM `departments` WHERE `Acronym` = `departmentAcronym` AND `Dean_Id` != `uId`) = 0) AND
	    ((SELECT COUNT(`Acronym`) FROM `init_departments` WHERE `Acronym` = `departmentAcronym` AND `Dean_Id` != `uId`) = 0)) THEN
		SET @isAcronymOk = TRUE;
	END IF;
	
	IF ((@isNameOk = TRUE) AND (@isAcronymOk = TRUE)) THEN
		UPDATE `init_departments`
		SET
		`Name` = `newDept`, 
		`Acronym` = `newAccr`
		WHERE
		`Dean_Id` = `uId` ;
		
		SET @isOk = TRUE;
	END IF;
	SELECT @isOk, @isNameOk, @isAcronymOk;
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_login_attemp_counter` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_login_attemp_counter` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_login_attemp_counter`(`uIp` varchar(16),`uUa` varchar(256))
BEGIN
		set @count = (select count(`Ip`) from `login_attemp_counter` where `Ip` = `uIp` and `User Agent` = `uUa`);
		
		if @count = 0 then
			INSERT INTO `db_thesis`.`login_attemp_counter`(`Ip`, 
				`Attemps`, 
				`User Agent`,
				`Last Try`
			)
			VALUES(
				`uIp`, 
				'1', 
				`uUa`,
				now()
			);
		else
			set @attemps = (select `Attemps` from `login_attemp_counter` where `Ip` = `uIp` and `User Agent` = `uUa`);
			#clamps the value to prevent trunkating
			if @attemps < 100 then
				UPDATE `db_thesis`.`login_attemp_counter` 
				SET
				`Attemps` = (`Attemps` + 1),
				`Last Try` = now()
				WHERE
				`Ip` = `uIp` AND `User Agent` = `uUa`;
			end if;
		end if;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `update_subject` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_subject` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `update_subject`(`uId` VARCHAR(32),`ItemId` int(10) UNSIGNED,`newSubjName` varchar(64),`newSubjCode` VARCHAR(16),`iMajor` tinyint(1))
BEGIN
	
	set @isSucess = false;
	SET @codeCount = (#To check if subject code already exists
		SELECT COUNT(`Code`)
		FROM `subjects`
		WHERE `Code` = `newSubjCode` AND 
		`Course Code` = (SELECT `Course Code` FROM `subjects` WHERE `Id` = `ItemId`) and
		`Id` != `ItemId`
		);

	IF  @codeCount = 0 THEN
		SET @uName = (SELECT `subjects`.`Name` FROM `subjects` WHERE `Id` = `ItemId`);
		#CALL `insert_logs`(`uId`,'2', CONCAT('Edited ', @oldName, '.');
		UPDATE `db_thesis`.`subjects`
		SET
		`Name` = `newSubjName`, 
		`Code` = `newSubjCode`,
		`Is Major` = `iMajor`
		WHERE
		`Id` = `ItemId` ;
		
		IF (ROW_COUNT() != 0) THEN
			CALL `insert_logs`(`uId`,'2', CONCAT('Edited a subject named ',@uName,'.'));
			set @isSucess = true;
		END IF;
	end if;
	
	select @codeCount,@isSucess;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
