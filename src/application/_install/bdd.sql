-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 20 Avril 2014 à 19:20
-- Version du serveur: 5.5.33
-- Version de PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `hfgl`
--

-- --------------------------------------------------------

--
-- Structure de la table `Chapter`
--

CREATE TABLE `Chapter` (
  `chapterID` int(11) NOT NULL AUTO_INCREMENT,
  `chapterNumber` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `URL` varchar(1000) DEFAULT NULL,
  `questionnaireID` int(11) DEFAULT NULL,
  PRIMARY KEY (`chapterID`),
  KEY `fk_Chapter_Questionnaire_1` (`questionnaireID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Chapters`
--

CREATE TABLE `Chapters` (
  `chapterID` int(11) NOT NULL,
  `partID` int(11) NOT NULL,
  KEY `fk_Chapter_Chapters_1` (`chapterID`),
  KEY `fk_Chapters_Part_1` (`partID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Course`
--

CREATE TABLE `Course` (
  `courseID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `questionnaireID` int(11) DEFAULT NULL,
  PRIMARY KEY (`courseID`),
  KEY `fk_Course_Questionnaire_1` (`questionnaireID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `Course`
--

INSERT INTO `Course` (`courseID`, `title`, `description`, `questionnaireID`) VALUES
(1, 'Algortihms', 'In this course you will learn several fundamental principles of algorithm design: divide-and-conquer methods, graph algorithms, practical data structures (heaps, hash tables, search trees), randomized algorithms, and more.', NULL),
(2, 'Functional Programming', 'The purpose of this course is to introduce the theory and practice of functional programming (FP). The characteristic feature of FP is the emphasis on computation as evaluation. The traditional distinction between program and data characteristic of imperative programming (IP) is replaced by an emphasis on classifying expressions by types that specify their applicative behavior.', NULL),
(3, 'Logic Programming', 'In addition to a short introduction to the programming language Prolog, the lecture deals with the foundations of logic programming, with programming techniques in these languages, with the implementation of logic programming languages, and with their application in several areas.', NULL),
(4, 'Philosophy', 'This course will introduce you to some of the most important areas of research in contemporary philosophy. Each week a different philosopher will talk you through some of the most important questions and issues in their area of expertise.', NULL),
(5, 'Circuits and Electronics', 'The course introduces the fundamentals of the lumped circuit abstraction. Topics covered include: resistive elements and networks; independent and dependent sources; switches and MOS transistors; digital abstraction; amplifiers; energy storage elements; dynamics of first- and second-order networks; design in the time and frequency domains; and analog and digital circuits and applications.', NULL),
(6, 'Computer graphics', 'Computer graphics course offers an introduction to computer graphics hardware, algorithms, and software. Topics include: line generators, affine transformations, line and polygon clipping, splines, interactive techniques, perspective projection, solid modeling, hidden surface algorithms, lighting models, shading, and animation. Substantial programming experience is required. This course is worth 6 Engineering Design Points.', NULL),
(7, 'Object Oriented Programming', 'Intermediate programming in a high-level language and introduction to computer science. Topics include program structure and organization, object-oriented programming (classes, objects, types, sub-typing), graphical user interfaces, algorithm analysis (asymptotic complexity, big “O” notation), recursion, data structures (lists, trees, stacks, queues, heaps, search trees, hash tables, graphs), simple graph algorithms. C++ is the principal programming language.', 1);

-- --------------------------------------------------------

--
-- Structure de la table `FinalNote`
--

CREATE TABLE `FinalNote` (
  `studentID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `tutorID` int(11) NOT NULL,
  `note` decimal(10,0) NOT NULL,
  KEY `fk_FinalNote_Course_1` (`courseID`),
  KEY `fk_FinalNote_Person_1` (`studentID`),
  KEY `fk_FinalNote_Person_2` (`tutorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Inscription`
--

CREATE TABLE `Inscription` (
  `studentID` int(53) NOT NULL,
  `courseID` int(53) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `fk_Inscription_Course_1` (`courseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Inscription`
--

INSERT INTO `Inscription` (`studentID`, `courseID`, `date`) VALUES
(9, 1, '2014-04-20 14:24:57'),
(9, 4, '2014-04-20 14:24:57'),
(9, 5, '2014-04-20 14:24:57'),
(10, 2, '2014-04-20 14:24:57'),
(10, 1, '2014-04-20 14:24:57'),
(10, 5, '2014-04-20 14:24:57'),
(11, 5, '2014-04-20 14:24:57'),
(11, 7, '2014-04-20 14:24:57'),
(11, 1, '2014-04-20 14:24:57'),
(12, 4, '2014-04-20 14:24:57'),
(12, 1, '2014-04-20 14:24:57'),
(12, 2, '2014-04-20 14:24:57'),
(13, 5, '2014-04-20 14:24:57'),
(13, 2, '2014-04-20 14:24:57'),
(13, 1, '2014-04-20 14:24:57'),
(14, 7, '2014-04-20 14:24:57'),
(14, 1, '2014-04-20 14:24:57'),
(14, 2, '2014-04-20 14:24:57'),
(15, 1, '2014-04-20 14:24:57'),
(15, 2, '2014-04-20 14:24:57'),
(15, 3, '2014-04-20 14:24:57'),
(16, 7, '2014-04-20 14:24:57'),
(16, 5, '2014-04-20 14:24:57'),
(16, 4, '2014-04-20 14:24:57'),
(17, 4, '2014-04-20 14:24:57'),
(17, 2, '2014-04-20 14:24:57'),
(17, 1, '2014-04-20 14:24:57'),
(18, 5, '2014-04-20 14:24:57'),
(18, 6, '2014-04-20 14:24:57'),
(18, 7, '2014-04-20 14:24:57');

-- --------------------------------------------------------

--
-- Structure de la table `Part`
--

CREATE TABLE `Part` (
  `partID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `questionnaireID` int(11) DEFAULT NULL,
  PRIMARY KEY (`partID`),
  KEY `fk_Part_Questionnaire_1` (`questionnaireID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Parts`
--

CREATE TABLE `Parts` (
  `partID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  KEY `fk_Parts_Part_1` (`partID`),
  KEY `fk_Parts_Course_1` (`courseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Person`
--

CREATE TABLE `Person` (
  `personID` int(11) NOT NULL AUTO_INCREMENT,
  `roleID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`personID`),
  KEY `fk_Person_Role_1` (`roleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `Person`
--

INSERT INTO `Person` (`personID`, `roleID`, `name`, `surname`, `email`, `password`) VALUES
(1, 2, 'thomas', 'salmon', 'thtttt', 'toto'),
(2, 2, 'Karine', 'Altisen', 'Karine.Altisen@afk.com', 'lemotdepasse2'),
(3, 2, 'Andrzej', 'Duda', 'Andrzej.Duda@afk.com', 'lemotdepasse3'),
(4, 2, 'Pierre', 'Etore', 'Pierre.Etore@afk.com', 'lemotdepasse4'),
(5, 2, 'Nils', 'Gesbert', 'Nils.Gesbert@afk.com', 'lemotdepasse5'),
(6, 2, 'Joseph', 'Staline', 'Joseph.Staline@kgb.ussr', 'lemotdepasse6'),
(7, 2, 'Guillaume', 'James', 'Guillaume.James@afk.com', 'lemotdepasse7'),
(8, 2, 'Xavier', 'Nicollin', 'Xavier.Nicollin@afk.com', 'lemotdepasse8'),
(9, 1, 'thomas', 'salmon', 'th_s@hotmail.fr', 'toto'),
(10, 3, 'Emil', 'Siriwardane', 'Emil.Siriwardane@afk.com', 'lemotdepasse10'),
(11, 3, 'James', 'Albertus', 'James.Albertus@afk.com', 'lemotdepasse11'),
(12, 3, 'Matteo', 'Crosignani', 'Matteo.Crosignani@afk.com', 'lemotdepasse12'),
(13, 3, 'Mohsan', 'Bilal', 'Mohsan.Bilal@afk.com', 'lemotdepasse13'),
(14, 3, 'Suzanne', 'Chang', 'Suzanne.Chang@afk.com', 'lemotdepasse14'),
(15, 3, 'Markus', 'Sihvonen', 'Markus.Sihvonen@afk.com', 'lemotdepasse15'),
(16, 3, 'Katherine', 'Waldock', 'Katherine.Waldock@afk.com', 'lemotdepasse16'),
(17, 3, 'Vadim', 'Elenev', 'Vadim.Elenev@afk.com', 'lemotdepasse17'),
(18, 3, 'Adriana', 'Alfaro', 'Adriana.Alfaro@afk.com', 'lemotdepasse18'),
(19, 1, 'Admin', '', 'Admin@afk.com', 'lemotdepasse');

-- --------------------------------------------------------

--
-- Structure de la table `Points`
--

CREATE TABLE `Points` (
  `studentID` int(11) NOT NULL,
  `response` varchar(2000) DEFAULT NULL,
  `questionID` int(11) NOT NULL,
  `note` decimal(10,0) NOT NULL,
  PRIMARY KEY (`studentID`,`questionID`),
  KEY `fk_Points_Question_1` (`questionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Question`
--

CREATE TABLE `Question` (
  `questionID` int(11) NOT NULL AUTO_INCREMENT,
  `typeID` int(11) NOT NULL,
  `assignment` varchar(2000) NOT NULL,
  `tip` varchar(2000) DEFAULT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`questionID`),
  KEY `fk_Question_QuestionType_1` (`typeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `Question`
--

INSERT INTO `Question` (`questionID`, `typeID`, `assignment`, `tip`, `points`) VALUES
(1, 1, 'C/C++ program starts executing from', NULL, 2),
(2, 1, 'In CPP Programming ++ is ________ operator', NULL, 2),
(3, 1, 'In C++ Programming a pointer variable stores ________', NULL, 2),
(4, 1, 'In C/CPP Programming array can be _________', NULL, 2),
(5, 1, 'In C/CPP Programming an uninitialized variable may have', NULL, 2),
(6, 1, 'In C/CPP Programming which function is not related to file handling', NULL, 2),
(7, 1, 'In C/CPP Programming binary operator needs _______ operand.', NULL, 2),
(8, 1, 'A function which invokes itself repeatedly until some condition is satisfied is called ___________', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Questionnaire`
--

CREATE TABLE `Questionnaire` (
  `questionnaireID` int(11) NOT NULL AUTO_INCREMENT,
  `questionnaireType` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `available` date NOT NULL,
  PRIMARY KEY (`questionnaireID`),
  KEY `fk_Questionnaire_QuestionnaireType_1` (`questionnaireType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `Questionnaire`
--

INSERT INTO `Questionnaire` (`questionnaireID`, `questionnaireType`, `deadline`, `available`) VALUES
(1, 1, '2015-01-01', '2014-04-20');

-- --------------------------------------------------------

--
-- Structure de la table `QuestionnaireType`
--

CREATE TABLE `QuestionnaireType` (
  `typeID` int(11) NOT NULL AUTO_INCREMENT,
  `typeName` varchar(255) NOT NULL,
  PRIMARY KEY (`typeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `QuestionnaireType`
--

INSERT INTO `QuestionnaireType` (`typeID`, `typeName`) VALUES
(1, 'Examen'),
(2, 'RenduDeMemoire'),
(3, 'Projet'),
(4, 'TP');

-- --------------------------------------------------------

--
-- Structure de la table `Questions`
--

CREATE TABLE `Questions` (
  `questionnaireID` int(11) NOT NULL,
  `questionID` int(11) NOT NULL,
  KEY `fk_Questions_Questionnaire_1` (`questionnaireID`),
  KEY `fk_Questions_Question_1` (`questionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Questions`
--

INSERT INTO `Questions` (`questionnaireID`, `questionID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8);

-- --------------------------------------------------------

--
-- Structure de la table `QuestionType`
--

CREATE TABLE `QuestionType` (
  `typeID` int(11) NOT NULL AUTO_INCREMENT,
  `typeName` varchar(255) NOT NULL,
  PRIMARY KEY (`typeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `QuestionType`
--

INSERT INTO `QuestionType` (`typeID`, `typeName`) VALUES
(1, 'QCM'),
(2, 'QRF'),
(3, 'P'),
(4, 'L');

-- --------------------------------------------------------

--
-- Structure de la table `Resource`
--

CREATE TABLE `Resource` (
  `questionID` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `content` varchar(2000) NOT NULL,
  KEY `fk_Resource_Question_1` (`questionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Response`
--

CREATE TABLE `Response` (
  `questionID` int(11) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `correct` bit(1) DEFAULT NULL,
  KEY `fk_Responses_Question_1` (`questionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Response`
--

INSERT INTO `Response` (`questionID`, `content`, `correct`) VALUES
(1, 'here()', '\0'),
(1, 'main()', ''),
(1, 'start()', '\0'),
(1, 'begin()', '\0'),
(2, 'Increment', ''),
(2, 'Decrement', '\0'),
(2, 'Assigning', '\0'),
(2, 'Overloading', '\0'),
(3, 'Value of anther Value', '\0'),
(3, 'Value of anther variable', '\0'),
(3, 'Address of another value', '\0'),
(3, 'Address of another variable', ''),
(4, 'Single Dimensional', '\0'),
(4, 'Multi Dimensional', '\0'),
(4, 'Non Dimensional', '\0'),
(4, 'A & B', ''),
(5, 'Null value', '\0'),
(5, 'Null String', '\0'),
(5, 'Garbage value', ''),
(5, 'zero value', '\0'),
(6, 'fprintf()', '\0'),
(6, 'printf()', ''),
(6, 'fclose()', '\0'),
(6, 'fopen()', '\0'),
(7, 'No operand', '\0'),
(7, 'One operand', '\0'),
(7, 'Two operand', ''),
(7, 'Three operand', '\0'),
(8, 'Friend Function', '\0'),
(8, 'Virtual Function', '\0'),
(8, 'Recursive Function', ''),
(8, 'Overloading Function', '\0');

-- --------------------------------------------------------

--
-- Structure de la table `Result`
--

CREATE TABLE `Result` (
  `studentID` int(11) NOT NULL,
  `questionnaireID` int(11) NOT NULL,
  `lastPoints` int(11) NOT NULL,
  `attemptsRemain` int(11) NOT NULL DEFAULT '3',
  `lastAttemptDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `fk_Result_Questionnaire_1` (`questionnaireID`),
  KEY `fk_Result_Person_1` (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Role`
--

CREATE TABLE `Role` (
  `roleID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `Role`
--

INSERT INTO `Role` (`roleID`, `name`) VALUES
(1, 'admin'),
(2, 'tutor'),
(3, 'student');

-- --------------------------------------------------------

--
-- Structure de la table `Student`
--

CREATE TABLE `Student` (
  `personID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL AUTO_INCREMENT,
  `NSE` int(11) NOT NULL,
  PRIMARY KEY (`studentID`),
  KEY `fk_Student_Person_1` (`personID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `Student`
--

INSERT INTO `Student` (`personID`, `studentID`, `NSE`) VALUES
(10, 2, 0),
(11, 3, 0),
(12, 4, 0),
(13, 5, 0),
(14, 6, 0),
(15, 7, 0),
(16, 8, 0),
(9, 9, 0),
(18, 10, 0),
(20, 11, 12);

-- --------------------------------------------------------

--
-- Structure de la table `Teaching`
--

CREATE TABLE `Teaching` (
  `tutorID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  KEY `fk_Teaching_Course_1` (`courseID`),
  KEY `fk_Teaching_Person_1` (`tutorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Teaching`
--

INSERT INTO `Teaching` (`tutorID`, `courseID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Structure de la table `Test`
--

CREATE TABLE `Test` (
  `questionID` int(11) NOT NULL,
  `input` varchar(2000) NOT NULL,
  `output` varchar(2000) NOT NULL,
  KEY `fk_Test_Question_1` (`questionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Chapter`
--
ALTER TABLE `Chapter`
  ADD CONSTRAINT `fk_Chapter_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);

--
-- Contraintes pour la table `Chapters`
--
ALTER TABLE `Chapters`
  ADD CONSTRAINT `fk_Chapters_Part_1` FOREIGN KEY (`partID`) REFERENCES `Part` (`partID`),
  ADD CONSTRAINT `fk_Chapter_Chapters_1` FOREIGN KEY (`chapterID`) REFERENCES `Chapter` (`chapterID`);

--
-- Contraintes pour la table `Course`
--
ALTER TABLE `Course`
  ADD CONSTRAINT `fk_Course_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);

--
-- Contraintes pour la table `FinalNote`
--
ALTER TABLE `FinalNote`
  ADD CONSTRAINT `fk_FinalNote_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`),
  ADD CONSTRAINT `fk_FinalNote_Person_1` FOREIGN KEY (`studentID`) REFERENCES `Person` (`personID`),
  ADD CONSTRAINT `fk_FinalNote_Person_2` FOREIGN KEY (`tutorID`) REFERENCES `Person` (`personID`);

--
-- Contraintes pour la table `Inscription`
--
ALTER TABLE `Inscription`
  ADD CONSTRAINT `fk_Inscription_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`);

--
-- Contraintes pour la table `Part`
--
ALTER TABLE `Part`
  ADD CONSTRAINT `fk_Part_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);

--
-- Contraintes pour la table `Parts`
--
ALTER TABLE `Parts`
  ADD CONSTRAINT `fk_Parts_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`),
  ADD CONSTRAINT `fk_Parts_Part_1` FOREIGN KEY (`partID`) REFERENCES `Part` (`partID`);

--
-- Contraintes pour la table `Person`
--
ALTER TABLE `Person`
  ADD CONSTRAINT `fk_Person_Role_1` FOREIGN KEY (`roleID`) REFERENCES `Role` (`roleID`);

--
-- Contraintes pour la table `Points`
--
ALTER TABLE `Points`
  ADD CONSTRAINT `fk_Points_Person_1` FOREIGN KEY (`studentID`) REFERENCES `Person` (`personID`),
  ADD CONSTRAINT `fk_Points_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);

--
-- Contraintes pour la table `Question`
--
ALTER TABLE `Question`
  ADD CONSTRAINT `fk_Question_QuestionType_1` FOREIGN KEY (`typeID`) REFERENCES `QuestionType` (`typeID`);

--
-- Contraintes pour la table `Questionnaire`
--
ALTER TABLE `Questionnaire`
  ADD CONSTRAINT `fk_Questionnaire_QuestionnaireType_1` FOREIGN KEY (`questionnaireType`) REFERENCES `QuestionnaireType` (`typeID`);

--
-- Contraintes pour la table `Questions`
--
ALTER TABLE `Questions`
  ADD CONSTRAINT `fk_Questions_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`),
  ADD CONSTRAINT `fk_Questions_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);

--
-- Contraintes pour la table `Resource`
--
ALTER TABLE `Resource`
  ADD CONSTRAINT `fk_Resource_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);

--
-- Contraintes pour la table `Response`
--
ALTER TABLE `Response`
  ADD CONSTRAINT `fk_Responses_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);

--
-- Contraintes pour la table `Result`
--
ALTER TABLE `Result`
  ADD CONSTRAINT `fk_Result_Person_1` FOREIGN KEY (`studentID`) REFERENCES `Person` (`personID`),
  ADD CONSTRAINT `fk_Result_Questionnaire_1` FOREIGN KEY (`questionnaireID`) REFERENCES `Questionnaire` (`questionnaireID`);

--
-- Contraintes pour la table `Teaching`
--
ALTER TABLE `Teaching`
  ADD CONSTRAINT `fk_Teaching_Course_1` FOREIGN KEY (`courseID`) REFERENCES `Course` (`courseID`),
  ADD CONSTRAINT `fk_Teaching_Person_1` FOREIGN KEY (`tutorID`) REFERENCES `Person` (`personID`);

--
-- Contraintes pour la table `Test`
--
ALTER TABLE `Test`
  ADD CONSTRAINT `fk_Test_Question_1` FOREIGN KEY (`questionID`) REFERENCES `Question` (`questionID`);
