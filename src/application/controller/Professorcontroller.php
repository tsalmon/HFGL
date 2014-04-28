<?php
require_once 'application/models/Chapter.php';

class Professorcontroller extends Controller{

    public function index(){ 
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $cours_teaching = $this->loadModel('CourseTeaching')->getCourses($prof);
        print_r($_SESSION);
        
        require 'application/views/_templates/header.php';
        require 'application/views/enseignant.php';
        require 'application/views/_templates/footer.php';     
    }

    public function CreateCourse(){
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerUnCours.php';
        require 'application/views/_templates/footer.php';
    }

    public function CreateExamen(){
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerExamen.php';
        require 'application/views/_templates/footer.php';
    }

    public function CreateProjet(){
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerProjet.php';
        require 'application/views/_templates/footer.php';
    }

    public function CreateChapter(){
        $page = "CreateChapter";
        $cours = CourseFactory::getCourse($_GET["cours"], true);
        $part = new Part($_GET["part"]);
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerChapitre.php';
        require 'application/views/_templates/footer.php';
    }

    public function CreateChapter_ok(){
        //Controller::print_dbg($_POST);
        //Controller::print_dbg($_FILES);

        /*
        if(pathinfo($_FILES["chp_file_lesson"]["name"], PATHINFO_EXTENSION) != "pdf"){
            $error = "pdf";
            Professorcontroller::CreateChapter();
            return ;
        }
        if($_FILES["chp_file_lesson"]['size']>$_POST['MAX_FILE_SIZE']){
            $error = "size";
            Professorcontroller::CreateChapter();
            return ;
        }

        $dir = getcwd();
        if(!move_uploaded_file($_FILES["chp_file_lesson"]["tmp_name"], $dir."/files/".$_FILES["chp_file_lesson"]["name"])){
            $error = "move";
            Professorcontroller::CreateChapter();
            return ;
        }
        */

        /** Good part **/
        $chp = new Chapter($_POST["chp_name"], false);
        $part= new Part($_GET["part"]);
        $part->addChapter($chp);
        
        $_SESSION["ex_course"] = $_GET["cours"];
        $_SESSION["ex_part"] = $_GET["cours"];
        $_SESSION["ex_chpt"] = $chp->chapterID();
        
        //todo: create new Questionnaire and save his ID in $_SESSION
        $_SESSION["ex_id"] = 2;

        header('location: '.URL.'Professor/CreateExercice');
    }

/*
Array
(
    [nb_qt] => 12
    [question] => yyyy
    [lareponse] => checkbox
    [reponsetype] => 3
    [r] => Array
        (
            [0] => a
            [1] => a
            [2] => a
            [3] => a
            [4] => a
        )

    [c0] => on
    [c2] => on
    [c4] => on
)
*/
    public function CreateExercice(){
        $page="CreateExercice";
        //todo: insert on BDD the last question
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creeFeuilleExercice.php';
        require 'application/views/_templates/footer.php';
    }

    public function ViewNotes(){
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_view_notes.php';
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
