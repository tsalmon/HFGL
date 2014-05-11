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
		require 'application/views/_templates/header.php';
        require 'application/views/admin.php';
        require 'application/views/_templates/footer.php';
	}

	public function delete(){
		if($_GET["type"] == "student" || $_GET["type"] == "prof"){
			$MODELperson = $this->loadModel('PersonFactory');
			$person = $MODELperson->getPerson($_GET["id"], true);			
			$person->delete();
			if($_GET["type"] == "student"){
				header('location: '.URL.'Admin/liste_students');
			} else {
				header('location: '.URL.'Admin/liste_profs');
			}
		} elseif($_GET["type"] == "cours"){
			$MODELcours = $this->loadModel('CourseFactory');
			$cours = $MODELcours->getCourse($_GET["id"], false);
			$cours->delete();
		} else {
			die("parametres inconnus");
		}
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