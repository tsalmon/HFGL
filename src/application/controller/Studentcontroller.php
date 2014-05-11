<?php

class Studentcontroller extends Controller{
    private $titre_firstpart;
    private $list_part;
    private $list_coursID;
    private $liste_matiere;

    public function index() //consulter cours
    { 
        $MODELcours = $this->loadModel('CourseSubstcription');
        $liste_cours = $MODELcours->getCourses(PersonFactory::getPerson($_SESSION["email"]));

        require 'application/views/_templates/header.php';
        require 'application/views/etudiant.php';
        require 'application/views/_templates/footer.php';
        
    }

    public function Parametres()
    {
    	$page = "student";
        $MODELparam= $this->loadModel('PersonFactory');
        $infos = $MODELparam->getPerson($_SESSION["email"]);
        require 'application/views/_templates/header.php';
        require 'application/views/student_parametres.php';
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

    public function Notes()
    {   
        
        $page = "student";
        $MODELcours = $this->loadModel('CourseSubstcription');
        $liste_cours = $MODELcours->getCourses(PersonFactory::getPerson($_SESSION["email"]));

        require 'application/views/_templates/header.php';
        require 'application/views/student_view_notes.php';
        require 'application/views/_templates/footer.php';
    }

    public function InscrireCours(){
        $MODELcours = $this->loadModel('CourseSubstcription');
        $liste_cours = $MODELcours->getCourses(PersonFactory::getPerson($_SESSION["email"]));

        require 'application/views/_templates/header.php';
        require 'application/views/student_inscrireCours.php';
        require 'application/views/_templates/footer.php';    	
    }

    public function NotesDeCours()
    {
        $page = "student";
        require 'application/views/_templates/header.php';
        require 'application/views/student_view_notesDeCours.php';
        require 'application/views/_templates/footer.php';
    }
    public function Deconnexion(){
        if(session_destroy()){
            header('location: '.URL.'Welcome');
        } else {
            header('location: '.URL.'Student');
        }
    }
}
