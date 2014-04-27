<?php
class Coursescontroller extends Controller{
	public function index(){
		$MODELcours = $this->loadModel('CourseSubstcription');

		$user=&PersonFactory::getPerson($_SESSION["email"]);

		$cours = CourseFactory::getCourse($_GET["cours"], true);
		$part = $cours->part($_GET["part"]);
		$chp = $part->chapter($_GET["chp"]);

	
		require 'application/views/_templates/header.php';
        require 'application/views/student_viewChapter.php';
        require 'application/views/_templates/footer.php';		
	}

	public function desinscription(){
		$MODELcours = $this->loadModel('CourseSubstcription');
        if($MODELcours->remove($_SESSION["studentid"]	, intval($_GET["cours"]))){
	        header('location: '.URL.'Student');
	    } else {
	    	echo "error...";
	    }
	}
}
?>