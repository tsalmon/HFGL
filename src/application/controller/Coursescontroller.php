<?php
class Coursescontroller extends Controller{
	public function index(){
		$page = "ViewCours";
		$MODELcours = $this->loadModel('CourseSubstcription');

		$cours = CourseFactory::getCourse($_GET["cours"], true);
		$part = $cours->part($_GET["part"]);
		$chp = $part->chapter($_GET["chp"]);

		require 'application/views/_templates/header.php';
		if($_SESSION["role"] == "teacher"){
       		require 'application/views/teacher_creerChapitre.php';			
		} else {
        	require 'application/views/student_viewChapter.php';
    	}
        require 'application/views/_templates/footer.php';		
	}

	public function desinscription(){
		$MODELcours = $this->loadModel('CourseSubstcription');
        if($MODELcours->remove($_SESSION["studentid"]	, intval($_GET["cours"]))){
	        header('location: '.URL.'Student');
	    } else {
	    	die("error...");
	    }
	}
 
   	public function newCourse(){
		Controller::print_dbg($_POST);
		Controller::print_dbg($_SESSION);
		try{
			$MODELcours = $this->loadModel('CourseFactory');
			$MODELteaching = $this->loadModel('CourseTeaching');
			$id_course = $MODELcours->createCourse($_POST["course_title"], $_POST["course_description"]);
			$MODELteaching->add(PersonFactory::getPerson($_SESSION["personid"], 1), $id_course);
		} catch(UnexpectedValueException $e){
			echo "error";
			require 'application/views/_templates/header.php';
        	require 'application/views/teacher_creerUnCours.php';
        	require 'application/views/_templates/footer.php';
		}
	}


}
?>