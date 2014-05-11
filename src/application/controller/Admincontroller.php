<?php
class Admincontroller extends Controller{
	public function index(){
		$page="index_admin";
        require 'application/views/_templates/header.php';
        require 'application/views/admin.php';
        require 'application/views/_templates/footer.php';
	}

	public function liste_students(){
		$page = "liste_student";
		$MODELperson = $this->loadModel('PersonFactory');
		$students = $MODELperson->getAllStudents();
		require 'application/views/_templates/header.php';
        require 'application/views/admin.php';
        require 'application/views/_templates/footer.php';
	}

	public function liste_professors(){
		$page = "liste_profs";
		$MODELperson = $this->loadModel('PersonFactory');
		$profs = $MODELperson->getAllProfessors();
		require 'application/views/_templates/header.php';
        require 'application/views/admin.php';
        require 'application/views/_templates/footer.php';
	}

	public function liste_courses(){
		$page = "liste_courses";
		$MODELperson = $this->loadModel('CourseFactory');
		$courses = $MODELperson->getCoursesList();
		print_r($courses);
		/*require 'application/views/_templates/header.php';
        require 'application/views/admin.php';
        require 'application/views/_templates/footer.php';*/
	}

	public function delete(){
		echo "toto";		
	}

	public function Deconnexion(){
        if(session_destroy()){
            header('location: '.URL.'Welcome');
        } else {
            header('location: '.URL.'Professor');
        }
    }
}
?>