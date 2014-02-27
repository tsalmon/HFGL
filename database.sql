ALTER TABLE `Course` DROP FOREIGN KEY `fk_Course_Inscription_1`;
ALTER TABLE `Chapters` DROP FOREIGN KEY `fk_Chapter_Chapters_1`;
ALTER TABLE `Questionnaire` DROP FOREIGN KEY `fk_Questionnaire_Chapter_1`;
ALTER TABLE `Questions` DROP FOREIGN KEY `fk_Questions_Questionnaire_1`;
ALTER TABLE `Question` DROP FOREIGN KEY `fk_Question_Questions_1`;
ALTER TABLE `Responses` DROP FOREIGN KEY `fk_Responses_Question_1`;
ALTER TABLE `Result` DROP FOREIGN KEY `fk_Result_Questionnaire_1`;
ALTER TABLE `Points` DROP FOREIGN KEY `fk_Points_Question_1`;
ALTER TABLE `Person` DROP FOREIGN KEY `fk_Person_Tutor_1`;
ALTER TABLE `Student` DROP FOREIGN KEY `fk_student_FinalNote_1`;
ALTER TABLE `Student` DROP FOREIGN KEY `fk_student_Person_1`;
ALTER TABLE `Person` DROP FOREIGN KEY `fk_Person_Admin_1`;
ALTER TABLE `Parts` DROP FOREIGN KEY `fk_Parts_Part_1`;
ALTER TABLE `Parts` DROP FOREIGN KEY `fk_Parts_Course_1`;
ALTER TABLE `Part` DROP FOREIGN KEY `fk_Part_Chapters_1`;
ALTER TABLE `QuestionnaireType` DROP FOREIGN KEY `fk_QuestionnaireType_Questionnaire_1`;
ALTER TABLE `QuestionType` DROP FOREIGN KEY `fk_QuestionType_Question_1`;
ALTER TABLE `Student` DROP FOREIGN KEY `fk_Student_Inscription_1`;
ALTER TABLE `Points` DROP FOREIGN KEY `fk_Points_Student_1`;
ALTER TABLE `Student` DROP FOREIGN KEY `fk_Student_Result_1`;
ALTER TABLE `FinalNote` DROP FOREIGN KEY `fk_FinalNote_Course_1`;
ALTER TABLE `FinalNote` DROP FOREIGN KEY `fk_FinalNote_Tutor_1`;
ALTER TABLE `Tutor` DROP FOREIGN KEY `fk_Tutor_Teaching_1`;
ALTER TABLE `Teaching` DROP FOREIGN KEY `fk_Teaching_Course_1`;

ALTER TABLE `Person`DROP PRIMARY KEY;
ALTER TABLE `Course`DROP PRIMARY KEY;
ALTER TABLE `Tutor`DROP PRIMARY KEY;
ALTER TABLE `Chapter`DROP PRIMARY KEY;
ALTER TABLE `Questionnaire`DROP PRIMARY KEY;
ALTER TABLE `Question`DROP PRIMARY KEY;
ALTER TABLE `Points`DROP PRIMARY KEY;
ALTER TABLE `Student`DROP PRIMARY KEY;
ALTER TABLE `Admin`DROP PRIMARY KEY;
ALTER TABLE `Part`DROP PRIMARY KEY;
ALTER TABLE `QuestionType`DROP PRIMARY KEY;
ALTER TABLE `QuestionnaireType`DROP PRIMARY KEY;

DROP TABLE `Person`;
DROP TABLE `Course`;
DROP TABLE `Tutor`;
DROP TABLE `Inscription`;
DROP TABLE `Chapters`;
DROP TABLE `Chapter`;
DROP TABLE `Questionnaire`;
DROP TABLE `Questions`;
DROP TABLE `Question`;
DROP TABLE `Responses`;
DROP TABLE `Points`;
DROP TABLE `Result`;
DROP TABLE `FinalNote`;
DROP TABLE `Student`;
DROP TABLE `Admin`;
DROP TABLE `Part`;
DROP TABLE `Parts`;
DROP TABLE `QuestionType`;
DROP TABLE `QuestionnaireType`;
DROP TABLE `Teaching`;

CREATE TABLE `Person` (
`personID` int NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`surname` varchar(255) NOT NULL,
`e-mail` varchar(255) NOT NULL,
PRIMARY KEY (`personID`) 
);

CREATE TABLE `Course` (
`courseID` int NOT NULL,
`title` varchar(255) NOT NULL,
`description` varchar(2000) NULL,
`questionnaireID` int NULL,
PRIMARY KEY (`courseID`) 
);

CREATE TABLE `Tutor` (
`tutorID` int NULL AUTO_INCREMENT,
`coursID` int NULL,
PRIMARY KEY (`tutorID`) 
);

CREATE TABLE `Inscription` (
`studentID` decimal(53,30) NOT NULL,
`courseID` decimal(53,30) NOT NULL,
`date` date NOT NULL
);

CREATE TABLE `Chapters` (
`chapterID` int NOT NULL,
`partID` int NOT NULL
);

CREATE TABLE `Chapter` (
`chapterID` int NOT NULL,
`chapterNumber` int NOT NULL,
`title` varchar(255) NULL,
`URL` varchar(1000) NULL,
`questionnaireID` int NULL,
PRIMARY KEY (`chapterID`) 
);

CREATE TABLE `Questionnaire` (
`questionnaireID` int NOT NULL,
`questionnaireType` int NOT NULL,
`deadline` date NOT NULL,
`available` date NOT NULL,
PRIMARY KEY (`questionnaireID`) 
);

CREATE TABLE `Questions` (
`questionnaireID` int NOT NULL,
`questionID` int NOT NULL
);

CREATE TABLE `Question` (
`questionID` int NOT NULL,
`assignment` varchar(2000) NOT NULL,
`points` int NOT NULL,
`typeID` int NOT NULL,
PRIMARY KEY (`questionID`) 
);

CREATE TABLE `Responses` (
`questionID` int NOT NULL,
`content` varchar(2000) NOT NULL
);

CREATE TABLE `Points` (
`studentID` int NOT NULL,
`response` varchar(2000) NULL,
`questionID` int NOT NULL,
`note` decimal NOT NULL,
PRIMARY KEY (`studentID`, `questionID`) 
);

CREATE TABLE `Result` (
`studentID` int NOT NULL,
`questionnaireID` int NOT NULL,
`lastPoints` int NOT NULL,
`attemptsRemain` int NOT NULL,
`lastAttemptDate` date NOT NULL
);

CREATE TABLE `FinalNote` (
`studentID` int NOT NULL,
`courseID` int NOT NULL,
`tutorID` int NOT NULL,
`note` decimal NOT NULL
);

CREATE TABLE `Student` (
`student_id` int NOT NULL,
`NSE` int NOT NULL,
PRIMARY KEY (`student_id`) 
);

CREATE TABLE `Admin` (
`adminID` int NOT NULL,
`personID` int NOT NULL,
PRIMARY KEY (`adminID`) 
);

CREATE TABLE `Part` (
`partID` int NOT NULL,
`title` varchar(255) NOT NULL,
`questionnaireID` int NULL,
PRIMARY KEY (`partID`) 
);

CREATE TABLE `Parts` (
`partID` int NOT NULL,
`courseID` int NOT NULL
);

CREATE TABLE `QuestionType` (
`typeID` int NOT NULL,
`typeName` varchar(255) NOT NULL,
PRIMARY KEY (`typeID`) 
);

CREATE TABLE `QuestionnaireType` (
`typeID` int NOT NULL,
`typeName` varchar(255) NOT NULL,
PRIMARY KEY (`typeID`) 
);

CREATE TABLE `Teaching` (
`tutorID` int NOT NULL,
`courseID` int NOT NULL
);


ALTER TABLE `Course` ADD CONSTRAINT `fk_Course_Inscription_1` FOREIGN KEY (`courseID`) REFERENCES `Inscription` (`courseID`);
ALTER TABLE `Chapters` ADD CONSTRAINT `fk_Chapter_Chapters_1` FOREIGN KEY (`chapterID`) REFERENCES `Chapter` (`chapterID`);
ALTER TABLE `Questionnaire` ADD CONSTRAINT `fk_Questionnaire_Chapter_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Chapter` (`questionnaireID`);
ALTER TABLE `Questions` ADD CONSTRAINT `fk_Questions_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Question` ADD CONSTRAINT `fk_Question_Questions_1` FOREIGN KEY (`questionID`) REFERENCES `Questions` (`questionID`);
ALTER TABLE `Responses` ADD CONSTRAINT `fk_Responses_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Result` ADD CONSTRAINT `fk_Result_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Points` ADD CONSTRAINT `fk_Points_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Person` ADD CONSTRAINT `fk_Person_Tutor_1` FOREIGN KEY (`personID`) REFERENCES `Tutor` (`tutorID`);
ALTER TABLE `Student` ADD CONSTRAINT `fk_student_FinalNote_1` FOREIGN KEY (`student_id`) REFERENCES `FinalNote` (`studentID`);
ALTER TABLE `Student` ADD CONSTRAINT `fk_student_Person_1` FOREIGN KEY (`student_id`) REFERENCES `Person` (`personID`);
ALTER TABLE `Person` ADD CONSTRAINT `fk_Person_Admin_1` FOREIGN KEY (`personID`) REFERENCES `Admin` (`personID`);
ALTER TABLE `Parts` ADD CONSTRAINT `fk_Parts_Part_1` FOREIGN KEY (`partID`) REFERENCES `Part` (`partID`);
ALTER TABLE `Parts` ADD CONSTRAINT `fk_Parts_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `Part` ADD CONSTRAINT `fk_Part_Chapters_1` FOREIGN KEY (`partID`) REFERENCES `Chapters` (`chapterID`);
ALTER TABLE `QuestionnaireType` ADD CONSTRAINT `fk_QuestionnaireType_Questionnaire_1` FOREIGN KEY (`typeID`) REFERENCES `Questionnaire` (`questionnaireType`);
ALTER TABLE `QuestionType` ADD CONSTRAINT `fk_QuestionType_Question_1` FOREIGN KEY (`typeID`) REFERENCES `Question` (`typeID`);
ALTER TABLE `Student` ADD CONSTRAINT `fk_Student_Inscription_1` FOREIGN KEY (`student_id`) REFERENCES `Inscription` (`studentID`);
ALTER TABLE `Points` ADD CONSTRAINT `fk_Points_Student_1` FOREIGN KEY (`studentID`) REFERENCES `Student` (`student_id`);
ALTER TABLE `Student` ADD CONSTRAINT `fk_Student_Result_1` FOREIGN KEY (`student_id`) REFERENCES `Result` (`studentID`);
ALTER TABLE `FinalNote` ADD CONSTRAINT `fk_FinalNote_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `FinalNote` ADD CONSTRAINT `fk_FinalNote_Tutor_1` FOREIGN KEY (`tutorID`) REFERENCES `Tutor` (`tutorID`);
ALTER TABLE `Tutor` ADD CONSTRAINT `fk_Tutor_Teaching_1` FOREIGN KEY (`tutorID`) REFERENCES `Teaching` (`tutorID`);
ALTER TABLE `Teaching` ADD CONSTRAINT `fk_Teaching_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);

