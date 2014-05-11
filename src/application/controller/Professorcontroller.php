<?php
require_once 'application/models/Chapter.php';
require_once 'application/models/QCMQuestion.php';
require_once 'application/models/LQuestion.php';
require_once 'application/models/QRFQuestion.php';
require_once 'application/models/PQuestion.php';

class Professorcontroller extends Controller{

    public function index(){ 
        $page = "prof";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $cours_teaching = $this->loadModel('CourseTeaching')->getCourses($prof);
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

    public function CreatePart(){
        $cours = CourseFactory::getCourse($_GET["cours"], true);
        foreach ($cours->parts() as $part) {
            if($part->title() == $_GET["part"]){
                print("error part_exist");
                return ;
            }
        }
        $p = new Part($_GET["part"], false);
        $cours->addPart($p);
        print("createpart ok");
    }

    public function CreateExercice(){
        $page="CreateExercice";

        if(isset($_POST["nb_qt"])){ // if it's not the first question
            if($_POST["lareponse"] == "free"){
                $qt = new LQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                $qt->writeToDB();
            } elseif($_POST["lareponse"] == "checkbox"){ //QCM
                $qt = new QCMQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                $qt_id = $qt->writeToDB();
                foreach ($_POST["r"] as $key => $value) {
                    $a = new Answer($value, isset($_POST["c".$key]));
                    $a->writeToDBForQuestionID($qt_id);
                }
            } elseif ($_POST["lareponse"] == "lines"){
                $qt = new QRFQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                foreach ($_POST["r"] as $key => $value) {
                    $qt->addAnswer(new Answer($value, 1));
                }
                $qt->writeToDB();         
            } elseif($_POST["lareponse"] == "code"){
                $qt = new LQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                $qt->writeToDB();
                $qt->writeToDBForQuestionnaireID($_SESSION["ex_id"]);
            }
        }

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
