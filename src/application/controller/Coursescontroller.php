<?php
class Coursescontroller extends Controller{
	public function index(){
		$MODELcours = $this->loadModel('CourseSubstcription');

		$student=&PersonFactory::getPerson($_SESSION["email"]);
		$cours = $MODELcours->getCourses($student);	
		$cours = $cours[intval($_GET["cours"])-1];
		$part = $cours->parts()[intval($_GET["part"])-1];
		$chp = $part->chapters()[intval($_GET["cours"])-1];		

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