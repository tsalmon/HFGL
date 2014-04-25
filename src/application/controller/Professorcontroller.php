<?php

class Professorcontroller extends Controller{

    public function index() //consulter cours
    { 
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $cours_teaching = $this->loadModel('CourseTeaching')->getCourses($prof);

        require 'application/views/_templates/header.php';
        require 'application/views/enseignant.php';
        require 'application/views/_templates/footer.php';        
    }

    public function CreateCour()
    {
        $page = "professor";
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerUnCours.php';
        require 'application/views/_templates/footer.php';      
    }

    public function CreateExamen()
    {
        $page = "professor";
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerExamen.php';
        require 'application/views/_templates/footer.php';      
    }

    public function CreateChapter()
    {
        $page = "professor";
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerChapitre.php';
        require 'application/views/_templates/footer.php';      
    }

    public function CreateProjet()
    {
        $page = "professor";
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerProjet.php';
        require 'application/views/_templates/footer.php';      
    }

    public function Parametres()
    {
    	$page = "professor";
        $MODELparam= $this->loadModel('PersonFactory');
        $infos = $MODELparam->getPerson($_SESSION["email"]);
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_parametres.php';
        require 'application/views/_templates/footer.php';    	
    }

    public function Parametres_result()
    {
        print_r($_POST);
    }

    public function ParametresPWD_result()
    {
        print_r($_POST);
    }

    public function SupprimerCours(){
        echo "supprimer un cours";
    }

    public function Soumissions()
    {
    	$page = "professor";
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_view_soumissions.php';
        require 'application/views/_templates/footer.php';
    }

    public function DonneNote(){
    	$page = "professor";
        require 'application/views/_templates/header.php';
        echo "DONNER UNE NOTE";
        require 'application/views/_templates/footer.php';    	
    }

    public function Deconnexion(){
        if(session_destroy()){
            header('location: '.URL.'Welcome');
        } else {
            header('location: '.URL.'Professor');
        }
    }
}
