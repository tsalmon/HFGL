
CREATE TABLE `Person` (
`personID` int NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`surname` varchar(255) NOT NULL,
`e-mail` varchar(255) NOT NULL,
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

CREATE TABLE `Tutor` (
`tutorID` int NOT NULL AUTO_INCREMENT,
`personID` int NOT NULL,
PRIMARY KEY (`tutorID`) 
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
`assignment` varchar(2000) NOT NULL,
`points` int NOT NULL,
`typeID` int NOT NULL,
PRIMARY KEY (`questionID`) 
);

CREATE TABLE `Responses` (
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

CREATE TABLE `Student` (
`personID` int NOT NULL,
`studentID` int NOT NULL AUTO_INCREMENT,
`NSE` int NOT NULL,
PRIMARY KEY (`studentID`) 
);

CREATE TABLE `Admin` (
`adminID` int NOT NULL AUTO_INCREMENT,
`personID` int NOT NULL,
PRIMARY KEY (`adminID`) 
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


ALTER TABLE `Chapters` ADD CONSTRAINT `fk_Chapter_Chapters_1` FOREIGN KEY (`chapterID`) REFERENCES `Chapter` (`chapterID`);
ALTER TABLE `Questions` ADD CONSTRAINT `fk_Questions_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Points` ADD CONSTRAINT `fk_Points_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Parts` ADD CONSTRAINT `fk_Parts_Part_1` FOREIGN KEY (`partID`) REFERENCES `Part` (`partID`);
ALTER TABLE `Parts` ADD CONSTRAINT `fk_Parts_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `Points` ADD CONSTRAINT `fk_Points_Student_1` FOREIGN KEY (`studentID`) REFERENCES `Student` (`studentID`);
ALTER TABLE `FinalNote` ADD CONSTRAINT `fk_FinalNote_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `FinalNote` ADD CONSTRAINT `fk_FinalNote_Tutor_1` FOREIGN KEY (`tutorID`) REFERENCES `Tutor` (`tutorID`);
ALTER TABLE `Teaching` ADD CONSTRAINT `fk_Teaching_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `Admin` ADD CONSTRAINT `fk_Admin_Person_1` FOREIGN KEY (`adminID`) REFERENCES `Person` (`personID`);
ALTER TABLE `Tutor` ADD CONSTRAINT `fk_Tutor_Person_1` FOREIGN KEY (`tutorID`) REFERENCES `Person` (`personID`);
ALTER TABLE `Teaching` ADD CONSTRAINT `fk_Teaching_Tutor_1` FOREIGN KEY (`tutorID`) REFERENCES `Tutor` (`tutorID`);
ALTER TABLE `FinalNote` ADD CONSTRAINT `fk_FinalNote_Student_1` FOREIGN KEY (`studentID`) REFERENCES `Student` (`studentID`);
ALTER TABLE `Inscription` ADD CONSTRAINT `fk_Inscription_Student_1` FOREIGN KEY (`studentID`) REFERENCES `Student` (`studentID`);
ALTER TABLE `Inscription` ADD CONSTRAINT `fk_Inscription_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);
ALTER TABLE `Responses` ADD CONSTRAINT `fk_Responses_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Questions` ADD CONSTRAINT `fk_Questions_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
ALTER TABLE `Question` ADD CONSTRAINT `fk_Question_QuestionType_1` FOREIGN KEY (`typeID`) REFERENCES `QuestionType` (`typeID`);
ALTER TABLE `Questionnaire` ADD CONSTRAINT `fk_Questionnaire_QuestionnaireType_1` FOREIGN KEY (`questionnaireType`) REFERENCES `QuestionnaireType` (`typeID`);
ALTER TABLE `Chapter` ADD CONSTRAINT `fk_Chapter_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Result` ADD CONSTRAINT `fk_Result_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Result` ADD CONSTRAINT `fk_Result_Student_1` FOREIGN KEY (`studentID`) REFERENCES `Student` (`studentID`);
ALTER TABLE `Course` ADD CONSTRAINT `fk_Course_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);
ALTER TABLE `Chapters` ADD CONSTRAINT `fk_Chapters_Part_1` FOREIGN KEY (`partID`) REFERENCES `Part` (`partID`);
ALTER TABLE `Student` ADD CONSTRAINT `fk_Student_Person_1` FOREIGN KEY (`personID`) REFERENCES `Person` (`personID`);

