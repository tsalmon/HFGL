ALTER TABLE `Chapters` DROP FOREIGN KEY `fk_Chapter_Chapters_1`;
ALTER TABLE `Questions` DROP FOREIGN KEY `fk_Questions_Questionnaire_1`;
ALTER TABLE `Points` DROP FOREIGN KEY `fk_Points_Question_1`;
ALTER TABLE `Parts` DROP FOREIGN KEY `fk_Parts_Part_1`;
ALTER TABLE `Parts` DROP FOREIGN KEY `fk_Parts_Course_1`;
ALTER TABLE `FinalNote` DROP FOREIGN KEY `fk_FinalNote_Course_1`;
ALTER TABLE `Teaching` DROP FOREIGN KEY `fk_Teaching_Course_1`;
ALTER TABLE `Inscription` DROP FOREIGN KEY `fk_Inscription_Course_1`;
ALTER TABLE `Response` DROP FOREIGN KEY `fk_Responses_Question_1`;
ALTER TABLE `Questions` DROP FOREIGN KEY `fk_Questions_Question_1`;
ALTER TABLE `Question` DROP FOREIGN KEY `fk_Question_QuestionType_1`;
ALTER TABLE `Questionnaire` DROP FOREIGN KEY `fk_Questionnaire_QuestionnaireType_1`;
ALTER TABLE `Chapter` DROP FOREIGN KEY `fk_Chapter_Questionnaire_1`;
ALTER TABLE `Result` DROP FOREIGN KEY `fk_Result_Questionnaire_1`;
ALTER TABLE `Course` DROP FOREIGN KEY `fk_Course_Questionnaire_1`;
ALTER TABLE `Chapters` DROP FOREIGN KEY `fk_Chapters_Part_1`;
ALTER TABLE `Test` DROP FOREIGN KEY `fk_Test_Question_1`;
ALTER TABLE `Resource` DROP FOREIGN KEY `fk_Resource_Question_1`;
ALTER TABLE `Part` DROP FOREIGN KEY `fk_Part_Questionnaire_1`;
ALTER TABLE `Person` DROP FOREIGN KEY `fk_Person_Role_1`;
ALTER TABLE `Points` DROP FOREIGN KEY `fk_Points_Person_1`;
ALTER TABLE `Result` DROP FOREIGN KEY `fk_Result_Person_1`;
ALTER TABLE `Teaching` DROP FOREIGN KEY `fk_Teaching_Person_1`;
ALTER TABLE `FinalNote` DROP FOREIGN KEY `fk_FinalNote_Person_1`;
ALTER TABLE `FinalNote` DROP FOREIGN KEY `fk_FinalNote_Person_2`;

ALTER TABLE `Person`DROP PRIMARY KEY;
ALTER TABLE `Course`DROP PRIMARY KEY;
ALTER TABLE `Chapter`DROP PRIMARY KEY;
ALTER TABLE `Questionnaire`DROP PRIMARY KEY;
ALTER TABLE `Question`DROP PRIMARY KEY;
ALTER TABLE `Points`DROP PRIMARY KEY;
ALTER TABLE `Part`DROP PRIMARY KEY;
ALTER TABLE `QuestionType`DROP PRIMARY KEY;
ALTER TABLE `QuestionnaireType`DROP PRIMARY KEY;
ALTER TABLE `Role`DROP PRIMARY KEY;

DROP TABLE `Person`;
DROP TABLE `Course`;
DROP TABLE `Inscription`;
DROP TABLE `Chapters`;
DROP TABLE `Chapter`;
DROP TABLE `Questionnaire`;
DROP TABLE `Questions`;
DROP TABLE `Question`;
DROP TABLE `Response`;
DROP TABLE `Points`;
DROP TABLE `Result`;
DROP TABLE `FinalNote`;
DROP TABLE `Part`;
DROP TABLE `Parts`;
DROP TABLE `QuestionType`;
DROP TABLE `QuestionnaireType`;
DROP TABLE `Teaching`;
DROP TABLE `Test`;
DROP TABLE `Resource`;
DROP TABLE `Role`;

CREATE TABLE `Person` (
`personID` int NOT NULL AUTO_INCREMENT,
`roleID` int NOT NULL,
`name` varchar(255) NOT NULL,
`surname` varchar(255) NOT NULL,
`email` varchar(255) NOT NULL,
`password` varchar(255) NOT NULL,
PRIMARY KEY (`personID`) 
);

CREATE TABLE `Course` (
`courseID` int NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL,
`description` varchar(2000) NULL,
`questionnaireID` int NULL,
PRIMARY KEY (`courseID`) 
);

CREATE TABLE `Inscription` (
`studentID` int(53) NOT NULL,
`courseID` int(53) NOT NULL,
`date` timestamp NOT NULL
);

CREATE TABLE `Chapters` (
`chapterID` int NOT NULL,
`partID` int NOT NULL
);

CREATE TABLE `Chapter` (
`chapterID` int NOT NULL AUTO_INCREMENT,
`chapterNumber` int NOT NULL,
`title` varchar(255) NULL,
`URL` varchar(1000) NULL,
`questionnaireID` int NULL,
PRIMARY KEY (`chapterID`) 
);

CREATE TABLE `Questionnaire` (
`questionnaireID` int NOT NULL AUTO_INCREMENT,
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
`questionID` int NOT NULL AUTO_INCREMENT,
`typeID` int NOT NULL,
`assignment` varchar(2000) NOT NULL,
`tip` varchar(2000) NULL,
`points` int NOT NULL,
PRIMARY KEY (`questionID`) 
);

CREATE TABLE `Response` (
`questionID` int NOT NULL,
`content` varchar(2000) NOT NULL,
`correct` bit(1) NULL
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
`attemptsRemain` int NOT NULL DEFAULT 3,
`lastAttemptDate` timestamp NOT NULL
);

CREATE TABLE `FinalNote` (
`studentID` int NOT NULL,
`courseID` int NOT NULL,
`tutorID` int NOT NULL,
`note` decimal NOT NULL
);

CREATE TABLE `Part` (
`partID` int NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL,
`questionnaireID` int NULL,
PRIMARY KEY (`partID`) 
);

CREATE TABLE `Parts` (
`partID` int NOT NULL,
`courseID` int NOT NULL
);

CREATE TABLE `QuestionType` (
`typeID` int NOT NULL AUTO_INCREMENT,
`typeName` varchar(255) NOT NULL,
PRIMARY KEY (`typeID`) 
);

CREATE TABLE `QuestionnaireType` (
`typeID` int NOT NULL AUTO_INCREMENT,
`typeName` varchar(255) NOT NULL,
PRIMARY KEY (`typeID`) 
);

CREATE TABLE `Teaching` (
`tutorID` int NOT NULL,
`courseID` int NOT NULL
);

CREATE TABLE `Test` (
`questionID` int NOT NULL,
`input` varchar(2000) NOT NULL,
`output` varchar(2000) NOT NULL
);

CREATE TABLE `Resource` (
`questionID` int NOT NULL,
`type` varchar(100) NOT NULL,
`content` varchar(2000) NOT NULL
);

CREATE TABLE `Role` (
`roleID` int NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
PRIMARY KEY (`roleID`) 
);


ALTER TABLE `Chapters` ADD CONSTRAINT `fk_Chapter_Chapters_1` FOREIGN KEY (`chapterID`) REFERENCES `Chapter` (`chapterID`);
ALTER TABLE `Questions` ADD CONSTRAINT `fk_Questions_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Points` ADD CONSTRAINT `fk_Points_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Parts` ADD CONSTRAINT `fk_Parts_Part_1` FOREIGN KEY (`partID`) REFERENCES `Part` (`partID`);
ALTER TABLE `Parts` ADD CONSTRAINT `fk_Parts_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `FinalNote` ADD CONSTRAINT `fk_FinalNote_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `Teaching` ADD CONSTRAINT `fk_Teaching_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `Inscription` ADD CONSTRAINT `fk_Inscription_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `Response` ADD CONSTRAINT `fk_Responses_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Questions` ADD CONSTRAINT `fk_Questions_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Question` ADD CONSTRAINT `fk_Question_QuestionType_1` FOREIGN KEY (`typeID`) REFERENCES `QuestionType` (`typeID`);
ALTER TABLE `Questionnaire` ADD CONSTRAINT `fk_Questionnaire_QuestionnaireType_1` FOREIGN KEY (`questionnaireType`) REFERENCES `QuestionnaireType` (`typeID`);
ALTER TABLE `Chapter` ADD CONSTRAINT `fk_Chapter_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Result` ADD CONSTRAINT `fk_Result_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Course` ADD CONSTRAINT `fk_Course_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Chapters` ADD CONSTRAINT `fk_Chapters_Part_1` FOREIGN KEY (`partID`) REFERENCES `Part` (`partID`);
ALTER TABLE `Test` ADD CONSTRAINT `fk_Test_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Resource` ADD CONSTRAINT `fk_Resource_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Part` ADD CONSTRAINT `fk_Part_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Person` ADD CONSTRAINT `fk_Person_Role_1` FOREIGN KEY (`roleID`) REFERENCES `Role` (`roleID`);
ALTER TABLE `Points` ADD CONSTRAINT `fk_Points_Person_1` FOREIGN KEY (`studentID`) REFERENCES `Person` (`personID`);
ALTER TABLE `Result` ADD CONSTRAINT `fk_Result_Person_1` FOREIGN KEY (`studentID`) REFERENCES `Person` (`personID`);
ALTER TABLE `Teaching` ADD CONSTRAINT `fk_Teaching_Person_1` FOREIGN KEY (`tutorID`) REFERENCES `Person` (`personID`);
ALTER TABLE `FinalNote` ADD CONSTRAINT `fk_FinalNote_Person_1` FOREIGN KEY (`studentID`) REFERENCES `Person` (`personID`);
ALTER TABLE `FinalNote` ADD CONSTRAINT `fk_FinalNote_Person_2` FOREIGN KEY (`tutorID`) REFERENCES `Person` (`personID`);

