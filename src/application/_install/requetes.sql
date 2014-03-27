--tout le monde
select name, surname, `email` from Person

--tous les cours
select title, description from Course

--étudiants inscrits aux algos
select name, surname from Person
join Student on Student.personID = Person.personID
join Inscription on Inscription.studentID = Student.studentID
join Course on Course.courseID = Inscription.courseID
where Course.title = 'Algortihms'

--les profs d'algo
select name, surname from Person
join Tutor on Tutor.personID = Person.personID
join Teaching on Teaching.tutorID = Tutor.tutorID
join Course on Course.courseID = Teaching.courseID
where Course.title = 'Algortihms'

--Inscrire l'étudiant 1 au cours 1

INSERT INTO `Inscription`(`studentID`, `courseID`) VALUES 
(1,1)

--Monter les inscriptions d'étudiant avec studentID=1
select title from Course
join Inscription on Inscription.courseID = Course.courseID
where studentID = 1 

--Montrer tous le ennoncés des questions pour examen de LOA
select assignement from Question 
join Questions on Question.questionID = Questions.questionID
join Questionnaire on Questionnaire.questionnaireID = Questions.questionnaireID
join Course on Course.questionnaireID = Questionnaire.questionnaireID
where Course.title = 'Object Oriented Programming'


--Montrer les reponses pour la question avec ID=1
select content from Responses 
join Question on Question.questionID = Responses.questionID
where Question.questionID=2

--Montrer la bonne reponse pour la question avec ID=2
select content from Responses 
join Question on Question.questionID = Responses.questionID
where Question.questionID=2 and correct=1

--Montrer les parties de LOA
select title from Part 
join Parts on Parts.partID = Part.partID
join Course on Course.courseID = Parts.courseID
where Course.title = 'Object Oriented Programming'

--Montrer les chapters de LOA 
select title from Chapter 
join Chapters on Chapters.chapterID = Chapter.chapterID
join Part on Part.partID = Chapters.partID
join Parts on Parts.partID = Part.partID
join Course on Course.courseID = Parts.courseID
where Course.title = 'Object Oriented Programming
