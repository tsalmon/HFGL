<?php

class Studentcontroller extends Controller{
    private $titre_firstpart;
    private $list_part;
    private $list_coursID;
    private $liste_matiere;

    public function index() //consulter cours
    { 
        $MODELcours = $this->loadModel('CourseSubstcription');
        $student = PersonFactory::getPerson($_SESSION["email"]);
        $liste_cours = $MODELcours->getCourses($student);
        $currentCourse = null;
        if (isset($_GET["cours"])){
            $currentCourse=CourseFactory::getCourse($_GET["cours"],true);
        }
        require 'application/views/_templates/header.php';
        require 'application/views/etudiant.php';
        require 'application/views/_templates/footer.php';
        
    }

    public function Parametres()
    {
    	$page = "student";
        $MODELparam= $this->loadModel('PersonFactory');
        $infos = $MODELparam->getPerson($_SESSION["email"]);
        $student = $infos;
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
        $student = PersonFactory::getPerson($_SESSION["email"]);
        $liste_cours = $MODELcours->getCourses($student);

        require 'application/views/_templates/header.php';
        require 'application/views/student_view_notes.php';
        require 'application/views/_templates/footer.php';
    }

    public function desinscription(){
         $MODELcours = $this->loadModel('CourseSubstcription');
        if($MODELcours->remove($_SESSION["studentid"] , intval($_GET["cours"]))){
            header('location: '.URL.'Student');
        } else {
            die("error...");
        }
    }

    public function suggestion_ok(){
        $MODELcours = $this->loadModel('CourseSubstcription');
        $student = PersonFactory::getPerson($_SESSION["email"]);
        if ($MODELcours->add(PersonFactory::getPerson($_SESSION["personid"], true), CourseFactory::getCourse($_GET["cours"],true))) {
            header('location: '.URL.'Student');
        } else {
            die("error...");
        }
        
    }

    public function InscrireCours(){
        $MODELcours = $this->loadModel('CourseSubstcription');
        $MODELall_cours = new CourseFactory();
    
        $student = PersonFactory::getPerson($_SESSION["email"]);
        $liste_cours = $MODELcours->getCourses($student);
        
        $liste_all_cours = $MODELall_cours->getCoursesList();

        foreach ($liste_cours as $key => $value) {
            $liste_cours[$key] = $value->title();
        }

        $suggestions = array_diff($liste_all_cours, $liste_cours);

        foreach ($suggestions as $key => $value) {
            $suggestions[$key] = $MODELall_cours->getCourse($value);
        }

        require 'application/views/_templates/header.php';
        require 'application/views/student_inscrireCours.php';
        require 'application/views/_templates/footer.php';    	
    }

    public function AfficherCours(){
        $page = "ViewCours";
        $student = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);

        $cours = CourseFactory::getCourse($_GET["cours"], true);
        $part = $cours->part($_GET["part"]);
        $chp = $part->chapter($_GET["chp"]);
        
        require 'application/views/_templates/header.php';
        require 'application/views/student_viewChapter.php';
        require 'application/views/_templates/footer.php';  
    }

    public function NotesDeCours()
    {
        $page = "student";
        $MODELcours = $this->loadModel('CourseSubstcription');
        $student = PersonFactory::getPerson($_SESSION["email"]);

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
