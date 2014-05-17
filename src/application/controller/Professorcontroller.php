<?php
require_once 'application/models/Chapter.php';
require_once 'application/models/QCMQuestion.php';
require_once 'application/models/LQuestion.php';
require_once 'application/models/QRFQuestion.php';
require_once 'application/models/PQuestion.php';
require_once 'application/models/XMLHelper.php';
//require_once 'application/models/QuestionnairePool.php';

class Professorcontroller extends Controller{

    public function index(){ 
        $page = "prof";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $cours_teaching = $this->loadModel('CourseTeaching')->getCourses($prof);
        $currentCourse = null;
        if (isset($_GET["cours"])){
            $currentCourse=CourseFactory::getCourse($_GET["cours"],true);
        }
        require 'application/views/_templates/header.php';
        require 'application/views/enseignant.php';
        require 'application/views/_templates/footer.php';     
    }

    public function CreateCourse(){
        $page = "prof";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerUnCours.php';
        require 'application/views/_templates/footer.php';
    }

    public function CreateExamen(){
        $page = "prof";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $_SESSION["quest_for"] = "examen";
        $_SESSION["ex_course"] = $_GET["cours"];
        header('location: '.URL.'Professor/CreateExercice');
    }

    public function CreateProjet(){
        $page = "prof";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerProjet.php';
        require 'application/views/_templates/footer.php';
    }

    public function CreateChapter(){
        $page = "CreateChapter";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
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
        $_SESSION["quest_for"] = "chapter";

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
        $_SESSION["quest_for"] = "part";
        //print("createpart ok");
    }

    public function DeletePart(){
        try {
            $cours = CourseFactory::getCourse($_GET["cours"], true);
            $cours->part($_GET["part"])->delete();
            print("createpart ok");
        } catch (Exception $e) {
            print("error delete");
        }
    }

    public function CreateExerciceFork(){
        if (array_key_exists ("xmlOrNot" , $_POST)){
            $this->CreateExerciceWithXML();
        } else {
            $exercice = new ExerciceSheet();
            $_SESSION["ex_id"] = $exercice->writeToDatabase();
            header('location: '.URL.'Professor/AddQuestion');
        }
    }

    public function CreateExerciceWithXML(){
        // echo "Nombre de fichiers ".count($_FILES)."<br>";
        if ($_FILES["exerciceXML"]["error"] > 0) {
            // echo "Error: " . $_FILES["exerciceXML"]["error"] . "<br>";
        } else {
            // echo "Upload: " . $_FILES["exerciceXML"]["name"] . "<br>";
            // echo "Type: " . $_FILES["exerciceXML"]["type"] . "<br>";
            // echo "Size: " . ($_FILES["exerciceXML"]["size"] / 1024) . " kB<br>";
            // echo "Stored in: " . $_FILES["exerciceXML"]["tmp_name"]."<br>";
            $temp = $_FILES["exerciceXML"]["tmp_name"];
            $name_file = $_FILES["exerciceXML"]['name'];
            move_uploaded_file($temp, "files/loadedxml/".$name_file);
            $exerciceSheet = XMLHelper::parseXML("files/loadedxml/".$name_file);
            $exerciceSheet->setDeadline($_POST["datelimite"]);
            $exerciceSheet->setAvailableDate($_POST["dateaccess"]);

            $questionnaire_table = null;
            $table_pk = null;
            $session_val = null;

            if($_SESSION["quest_for"] == "chapter"){
                $questionnaire_table = "Chapter";
                $table_pk = "chapterID";
                $session_val = "ex_chpt";
            }else
            if ($_SESSION["quest_for"] == "part") {
                $questionnaire_table = "Part";
                $table_pk = "partID";
                $session_val = "ex_part";
            }else
            if ($_SESSION["quest_for"] == "examen") {
                $questionnaire_table = "Course";
                $table_pk = "courseID";
                $session_val = "ex_course";
            }

            $_SESSION["ex_id"] = $exerciceSheet->writeToDatabase();
            //echo "UPDATE `".$questionnaire_table."` SET `questionnaireID`=".$_SESSION["ex_id"]." WHERE `".$table_pk."`=".$_SESSION[$session_val];
            PDOHelper::getInstance()->query("UPDATE `".$questionnaire_table."` SET `questionnaireID`=".$_SESSION["ex_id"]." WHERE `".$table_pk."`=".$_SESSION[$session_val]);
            header('location: '.URL.'Professor/index');
        }
    }

    public function AddQuestion(){
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $page="AddQuestion";

        if (isset($qt_nb)) {
           $qt_nb++;
        }
        $questionnaire = new ExerciceSheet();
        $questionnaire->loadByID($_SESSION["ex_id"]);

        $qt=null;

        if(isset($_POST["nb_qt"])){ // if it's not the first question
            if($_POST["lareponse"] == "libre"){ //Question libre

                $qt = new LQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);

            } elseif($_POST["lareponse"] == "checkbox"){ //QCM

                $qt = new QCMQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                foreach ($_POST["r"] as $key => $value) {
                    $a = new Answer($value, isset($_POST["c".$key]));
                    $qt->addAnswer($a);
                }

            } elseif ($_POST["lareponse"] == "lines"){ //QRF

                $qt = new QRFQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                foreach ($_POST["r"] as $key => $value) {
                    $qt->addAnswer(new Answer($value, 1));
                }

            } elseif($_POST["lareponse"] == "code"){ //Programme

                $qt = new PQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                $pQuestionID = $qt->writeToDBForQuestionnaireID($_SESSION["ex_id"]);

                $resources = null;
                $tests = null;
                $dir = "files/".$pQuestionID;

                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }

                if ($_FILES["tests"]["error"] > 0) {
                    echo "Error: " . $_FILES["tests"]["error"] . "<br>";
                } else {
                    $temp = $_FILES["tests"]["tmp_name"];
                    $name_file = $_FILES["tests"]['name'];
                    move_uploaded_file($temp, $dir."/".$name_file);

                    $row = 1;
                    if (($handle = fopen($dir."/".$name_file, "r")) !== FALSE) {
                      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        $row++;
                        $tst = new Test($data[0], $data[1]);
                        $tst->writeToDBForQuestionID($pQuestionID);
                      }
                      fclose($handle);
                    }
                }

                if ($_FILES["makefile"]["error"] > 0) {
                    echo "Error: " . $_FILES["makefile"]["error"] . "<br>";
                } else {
                    $temp = $_FILES["makefile"]["tmp_name"];
                    $name_file = $_FILES["makefile"]['name'];
                    move_uploaded_file($temp, $dir."/".$name_file);
                    $mk = new Resource("make", $_FILES["makefile"]['name']);
                    $mk -> writeToDBForQuestionID($pQuestionID);
                }
                $fn = new Resource("filename", $_POST["source"]);
                $fn -> writeToDBForQuestionID($pQuestionID);
                $exec = new Resource("execname", $_POST["executable"]);
                $exec -> writeToDBForQuestionID($pQuestionID);

            }
        }


        if (!is_null($qt)) {
            $questionnaire->addQuestion($qt);
        }

        if (isset($_POST["nb_qt"])) {
            if ($_POST["addQuestionAction"] == "Valider et continuer") {
                $questionnaire->writeToDatabase();
                require 'application/views/_templates/header.php';
                require 'application/views/teacher_ajouteQuestion.php';
                require 'application/views/_templates/footer.php';
            } else
            if ($_POST["addQuestionAction"] == "Valider et finir") {

                $questionnaire_table = null;
                $table_pk = null;
                $session_val = null;

                if($_SESSION["quest_for"] == "chapter"){
                    $questionnaire_table = "Chapter";
                    $table_pk = "chapterID";
                    $session_val = "ex_chpt";
                }else
                if ($_SESSION["quest_for"] == "part") {
                    $questionnaire_table = "Part";
                    $table_pk = "partID";
                    $session_val = "ex_part";
                }else
                if ($_SESSION["quest_for"] == "examen") {
                    $questionnaire_table = "Course";
                    $table_pk = "courseID";
                    $session_val = "ex_course";
                }

                $questionnaire->writeToDatabase();
                //echo "UPDATE `".$questionnaire_table."` SET `questionnaireID`=".$_SESSION["ex_id"]." WHERE `".$table_pk."`=".$_SESSION[$session_val];
                PDOHelper::getInstance()->query("UPDATE `".$questionnaire_table."` SET `questionnaireID`=".$_SESSION["ex_id"]." WHERE `".$table_pk."`=".$_SESSION[$session_val]);
                header('location: '.URL.'Professor/index');
            } else {
                //echo "UPDATE `".$questionnaire_table."` SET `questionnaireID`=".$_SESSION["ex_id"]." WHERE `".$table_pk."`=".$_SESSION[$session_val];
                PDOHelper::getInstance()->query("UPDATE `".$questionnaire_table."` SET `questionnaireID`=".$_SESSION["ex_id"]." WHERE `".$table_pk."`=".$_SESSION[$session_val]);
                header('location: '.URL.'Professor/index');
            }        
        } else {
            require 'application/views/_templates/header.php';
            require 'application/views/teacher_ajouteQuestion.php';
            require 'application/views/_templates/footer.php';
        }

    }


    public function CreateExercice(){
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);

        $page="CreateExercice";

        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creeFeuilleExercice.php';
        require 'application/views/_templates/footer.php';
    }

    public function ViewNotes(){
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);

        require 'application/views/_templates/header.php';
        require 'application/views/teacher_view_notes.php';
        require 'application/views/_templates/footer.php';
    }
    public function Parametres()
    {
    	$page = "professor";

        $MODELparam= $this->loadModel('PersonFactory');
        $infos = $MODELparam->getPerson($_SESSION["email"]);
        $prof = $infos;
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

    public function newCourse(){
        try{
            $MODELcours = new CourseFactory();
            $MODELteaching = $this->loadModel('CourseTeaching');
            $id_course = $MODELcours->createCourse($_POST["course_title"], nl2br($_POST["course_description"]));
            $MODELteaching->add(PersonFactory::getPerson($_SESSION["personid"], 1), $id_course);
            header('location: '.URL.'Professor');
        } catch(UnexpectedValueException $e){
            $page = "error";
            require 'application/views/_templates/header.php';
            require 'application/views/teacher_creerUnCours.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function SupprimerCours(){
        echo "supprimer un cours";
    }

    public function Soumissions()
    {
    	$page = "professor";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);

        require 'application/views/_templates/header.php';
        require 'application/views/teacher_view_soumissions.php';
        require 'application/views/_templates/footer.php';
    }

    public function DonneNote(){
    	$page = "professor";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        
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
