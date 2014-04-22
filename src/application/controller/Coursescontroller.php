<?php
class Coursescontroller extends Controller{
	public function index(){
		$MODELcours = $this->loadModel('CourseSubstcription');
		
		$student=&PersonFactory::getPerson($_SESSION["email"]);
		$cours = $MODELcours->getCourses($student);	

		//print_r($_GET);
		require 'application/views/_templates/header.php';
        require 'application/views/student_exercice.php';
        require 'application/views/_templates/footer.php';
	}

	public function suggestions(){
		echo "suggestions";
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