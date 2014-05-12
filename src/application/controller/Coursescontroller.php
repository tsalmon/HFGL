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
}
?>