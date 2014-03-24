select name, surname, `e-mail` from Person

select title, description from Course


//étudiants inscrits aux algos
select name, surname from Person
join Student on Student.personID = Person.personID
join Inscription on Inscription.studentID = Student.studentID
join Course on Course.courseID = Inscription.courseID
where Course.title = 'Algortihms'

//les profs d'algo
select name, surname from Person
join Tutor on Tutor.personID = Person.personID
join Teaching on Teaching.tutorID = Tutor.tutorID
join Course on Course.courseID = Teaching.courseID
where Course.title = 'Algortihms'

//Inscrire l'étudiant avec ID 1 au cours d'algo

insert into