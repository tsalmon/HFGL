<?php
class Coursescontroller extends Controller{
	public function index(){
		$MODELcours = $this->loadModel('CourseSubstcription');

		$student=&PersonFactory::getPerson($_SESSION["email"]);
		$cours = $MODELcours->getCourses($student);	
		$cours = $cours[intval($_GET["cours"])-1]->parts()[intval($_GET["part"])-1]->chapters()[intval($_GET["cours"])-1];

		require 'application/views/_templates/header.php';
        require 'application/views/student_viewChapter.php';
        require 'application/views/_templates/footer.php';		
	}

	public function desinscription(){
		$MODELcours = $this->loadModel('CourseSubstcription');

		$student=&PersonFactory::getPerson($_SESSION["email"]);
		$cours = $MODELcours->getCourses($student);

        $MODELcours->remove($student, $cours[intval($_GET["cours"])-1]);
        header('location: '.URL.'Student');
	}
}
?>