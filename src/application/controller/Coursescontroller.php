<?php
class Coursescontroller extends Controller{
	public function index(){
		print_r($_GET);
	}

	public function desinscription(){
		echo "<p>".print_r($_GET)."</p>";
		$MODELcours = $this->loadModel('CourseSubstcription');
		//$MODELstudent = $this->loadModel('PersonFactory');
        
		$student=&PersonFactory::getPerson($_SESSION["email"]);
		$cours = $MODELcours->getCourses($student);
                
        $MODELcours->remove($student, $cours[intval($_GET["cours"])-1]);
	}
}
?>