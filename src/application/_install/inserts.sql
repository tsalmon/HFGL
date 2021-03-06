INSERT INTO `QuestionnaireType`(`typeName`) VALUES
('Examen'),
('Memoire'),
('Projet'),
('TP');

INSERT INTO `QuestionType`(`typeName`) VALUES
('QCM'),
('QRF'),
('P'),
('L'),
('LS'),
('PR');

INSERT INTO `Questionnaire`(`questionnaireType`,`description`, `deadline`, `available`) VALUES
(1,'',MAKEDATE(2015,1),NOW()),
(3,'Projet en C++', MAKEDATE(2015,1), NOW());

INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES
('C/C++ program starts executing from',2,1),
('In CPP Programming ++ is ________ operator',2,1),
('In C++ Programming a pointer variable stores ________',2,1),
('In C/CPP Programming array can be _________',2,1),
('In C/CPP Programming an uninitialized variable may have',2,1),
('In C/CPP Programming which function is not related to file handling',2,1),
('In C/CPP Programming binary operator needs _______ operand.',2,1),
('A function which invokes itself repeatedly until some condition is satisfied is called ___________',2,1),
('Give a detailed description of three basical principles of object-oriented programming.',2,4),
('Operator ______ is a specific case of polymorphism, where different operators have different implementations depending on their arguments.',2,2),
('Write a C program which takes two int values as parameters and returns the result of their addition. Input example: "1 2" Output: "3".',5,3);

INSERT INTO `Resource`(`questionID`, `type`, `content`) VALUES
(11, "make", "makeadd"),
(11, "filename", "add.c"),
(11, "execname", "add");

INSERT INTO `Test`(`questionID`,`input`,`output`) VALUES
(11, "1 2", "3"),
(11, "5 5", "10");

INSERT INTO `Response`(`questionID`, `content`,`correct`) VALUES
(1,'here()',0),
(1,'main()',1),
(1,'start()',0),
(1,'begin()',0),
(2,'Increment',1),
(2,'Decrement',0),
(2,'Assigning',0),
(2,'Overloading',0),
(3,'Value of anther Value',0),
(3,'Value of anther variable',0),
(3,'Address of another value',0),
(3,'Address of another variable',1),
(4,'Single Dimensional',0),
(4,'Multi Dimensional',0),
(4,'Non Dimensional',0),
(4,'A & B',1),
(5,'Null value',0),
(5,'Null String',0),
(5,'Garbage value',1),
(5,'zero value',0),
(6,'fprintf()',0),
(6,'printf()',1),
(6,'fclose()',0),
(6,'fopen()',0),
(7,'No operand',0),
(7,'One operand',0),
(7,'Two operand',1),
(7,'Three operand',0),
(8,'Friend Function',0),
(8,'Virtual Function',0),
(8,'Recursive Function',1),
(8,'Overloading Function',0),
(10, 'overloading', 1);

INSERT INTO `Questions`(`questionnaireID`, `questionID`) VALUES
(1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8);

INSERT INTO `Course`(`title`, `description`) VALUES
('Object Oriented Programming','Intermediate programming in a high-level language and introduction to computer science. Topics include program structure and organization, object-oriented programming (classes, objects, types, sub-typing), graphical user interfaces, algorithm analysis (asymptotic complexity, big “O” notation), recursion, data structures (lists, trees, stacks, queues, heaps, search trees, hash tables, graphs), simple graph algorithms. C++ is the principal programming language.'),
('Algorithms','In this course you will learn several fundamental principles of algorithm design: divide-and-conquer methods, graph algorithms, practical data structures (heaps, hash tables, search trees), randomized algorithms, and more.'),
('Functional Programming','The purpose of this course is to introduce the theory and practice of functional programming (FP). The characteristic feature of FP is the emphasis on computation as evaluation. The traditional distinction between program and data characteristic of imperative programming (IP) is replaced by an emphasis on classifying expressions by types that specify their applicative behavior.'),
('Logic Programming','In addition to a short introduction to the programming language Prolog, the lecture deals with the foundations of logic programming, with programming techniques in these languages, with the implementation of logic programming languages, and with their application in several areas.'),
('Philosophy','This course will introduce you to some of the most important areas of research in contemporary philosophy. Each week a different philosopher will talk you through some of the most important questions and issues in their area of expertise.'),
('Circuits and Electronics','The course introduces the fundamentals of the lumped circuit abstraction. Topics covered include: resistive elements and networks; independent and dependent sources; switches and MOS transistors; digital abstraction; amplifiers; energy storage elements; dynamics of first- and second-order networks; design in the time and frequency domains; and analog and digital circuits and applications.'),
('Computer graphics','Computer graphics course offers an introduction to computer graphics hardware, algorithms, and software. Topics include: line generators, affine transformations, line and polygon clipping, splines, interactive techniques, perspective projection, solid modeling, hidden surface algorithms, lighting models, shading, and animation. Substantial programming experience is required. This course is worth 6 Engineering Design Points.');

INSERT INTO `Part` (`title`,`questionnaireID`) VALUES
('Introduction', 2), ('Main part', 2), ('Advanced chapters', 2);

INSERT INTO `Parts` (`partID`, `courseID`) VALUES
(1, 1),(2,1),(3,1);

INSERT INTO `Chapter` (`chapterNumber`, `title`, `URL`, `questionnaireID`) VALUES
(1, 'Introduction to C++', 'http:://www.google.com', 1),
(2, 'Classes', 'http:://www.google.com', 1),
(3, 'Templates', 'http:://www.google.com', 1),
(4, 'Shared pointers', 'http:://www.google.com', 1);

INSERT INTO `Chapters` (`chapterID`, `partID`) VALUES
(1,1),
(2,2),
(3,2),
(4,2);

INSERT INTO `Role` (`name`) VALUES
('admin'),('tutor'),('student');

INSERT INTO `Person`(`name`, `surname`, `email`, `password`, `roleID`) VALUES
('Olivier','Alphand','Olivier.Alphand@afk.com','lemotdepasse1', 1),
('Karine','Altisen','Karine.Altisen@afk.com','lemotdepasse2', 2),
('Andrzej','Duda','Andrzej.Duda@afk.com','lemotdepasse3', 3);

INSERT INTO `Student`(`personID`) VALUES
(3);

INSERT INTO `Tutor`(`personID`) VALUES
(2);

INSERT INTO `Admin`(`personID`) VALUES
(1);

INSERT INTO `Result`(`studentID`, `questionnaireID`, `lastPoints`, `attemptsRemain`) VALUES
(1, 1, 40, 3);

INSERT INTO `FinalNote`(`studentID`, `courseID`, `tutorID`, `note`) VALUES
(1,1,1,20),
(1,2,1,14),
(1,3,1,13),
(1,4,1,18),
(1,5,1,14),
(1,6,1,12);

INSERT INTO `Teaching`(`tutorID`, `courseID`) VALUES
(1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7);

INSERT INTO `Inscription`(`studentID`, `courseID`) VALUES
(1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7);
