<?php

/**
 * HFGL application website
 *
 * @package hfgl
 * @author HAMDANE Yasmine, GUEMOURI Aiman, SALMON Thomas, NGUYEN Thi Quynh Nga, CHEVALIER Josian, VLADISLAV Fitc
 * @link http://moule.informatique.univ-paris-diderot.fr:8080/groups/afk-lol
 * @link http://tsalmon.fr/gl
 * @link https://github.com/tsalmon/HFGL
 * @license http://opensource.org/licenses/MIT MIT License
 */

// load the (optional) Composer auto-loader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// load application config (error reporting etc.)
require 'application/config/config.php';

// load application class
require_once 'application/libs/application.php';
require_once 'application/libs/controller.php';
require_once 'application/models/PersonFactory.php';
require_once 'application/models/CourseFactory.php';
require_once 'application/models/CourseTeaching.php';
require_once 'application/models/CourseSubstcription.php';



//$app = new Application();


//
//$student1=&PersonFactory::createStudent("jeanbob@gmail.com","jean","bob","heu...truite!",12);
//$student2=&PersonFactory::createStudent("jeanmichel@gmail.com","jean","michel","bouh.",13);
//$student3=&PersonFactory::createStudent("jeanfrancois@gmail.com","jean","francois","motdepaaaaaaasse",14);
//$tutor1=&PersonFactory::createProfessor("francoisalexandre@gmail.com","franÃ§ois","alexandre","odif");
//$tutor2=&PersonFactory::createProfessor("andrepierre@gmail.com","andre","pierre","quelquepwd");
//$course1=&CourseFactory::createCourse("get money","fuck bitches.");
//$course2=&CourseFactory::createCourse("cours 1terayssan","c tro bi1");
//
//////
//$student3=&PersonFactory::getPerson("127",true);
////var_dump($student3);
////var_dump($student3->getCourses());
//$course1=&CourseFactory::getCourse("3",true);
//var_dump($course1);
////var_dump(CourseTeaching::getProfessors($course1));
//var_dump(CourseTeaching::getCourses($student3));
//$student2=&PersonFactory::getPerson("jeanmichel@gmail.com");
//$student3=&PersonFactory::getPerson("jeanfrancois@gmail.com");
////$tutor1=&PersonFactory::getPerson("francoisalexandre@gmail.com");
////$tutor2=&PersonFactory::getPerson("andrepierre@gmail.com");
//$course2=&CourseFactory::getCourse("cours 1terayssan");
////
//CourseSubstcription::add($student1,$course1);
//CourseSubstcription::add($student1,$course2);
//CourseSubstcription::add($student2,$course1);
//CourseSubstcription::add($student3,$course2);
////
////CourseTeaching::add($tutor1,$course1);
//CourseTeaching::add($tutor1,$course2);
//CourseTeaching::add($tutor2,$course2);
//


//CourseSubstcription::remove($student2->studentID(),$course1->courseID());
?>