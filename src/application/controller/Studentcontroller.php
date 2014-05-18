<?php
require_once 'application/models/Chapter.php';
//require_once 'application/models/PersonFactory.php';

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

    public function DoExercice(){
        $_SESSION["chapter"] = intval($_GET["chp"]);
        $_SESSION["chptname"] = $_GET["chptname"];
        $_SESSION["cours"] = $_GET["cours"];
        $_SESSION["part"] = $_GET["part"];
        $_SESSION["currentQuestionNumber"] = 0;
        $_SESSION["started"] = False;
        $_SESSION["finished"] = False;
        header('location: '.URL.'Student/Exercice');
        //echo "<script>alert('')</script>";
    }

    public function Exercice(){
        //var_dump($_SESSION);
        $chpt = new Chapter($_SESSION["chapter"]);
        $questionnaire = $chpt->exercices();
        $questions = $questionnaire->getQuestions();
        $MODELparam= $this->loadModel('PersonFactory');
        $student = $MODELparam->getPerson($_SESSION["email"]);

        $_SESSION["studentID"] = $student->studentID();
        $_SESSION["questionsCount"] = count($questions);


        if (!$_SESSION["finished"]) {
            $currentQuestion = $questions[$_SESSION["currentQuestionNumber"]];
            $currentQuestionNumber = $_SESSION["currentQuestionNumber"];

            /*
                Recuperation d'un nom de fichier pour la question de type P
                pour la montrer comme une indication
            */
            if ($currentQuestion instanceof PQuestion) {
                foreach($currentQuestion->getResources() as $resource){
                    if ($resource->getType() == "filename") {
                        $filename = $resource->getContent();
                    }
                } 
            }
        }

        require 'application/views/_templates/header.php';
        require 'application/views/student_exercice.php';
        require 'application/views/_templates/footer.php';
    }

    private function nextQuestion(){
        //echo "Current question number:".$_SESSION["currentQuestionNumber"].":::".$_SESSION["questionsCount"];
        if ($_SESSION["questionsCount"] == $_SESSION["currentQuestionNumber"]) {
            $_SESSION["finished"] = True;
        } 

        header('location: '.URL.'Student/Exercice');
    }

    private function incCount($key, $value){
            $_SESSION["started"] = True;
            if ($key == "currentQuestionNumber") {
                $_SESSION["currentQuestionNumber"] = $value+1; 
                return True;
            }

            if ($key == "questionsCount") {
                $_SESSION["questionsCount"] = $value;     
                return True; 
            }    

            return False;
    }

    public function startExercice(){
        $_SESSION["started"] = True;
        header('location: '.URL.'Student/Exercice');
    }


    public function QCMExerciceResponse()
    {
        foreach ($_POST as $key => $value) {
            if(!$this->incCount($key, $value))
            {
                $question = Question::getQuestionByID($key);
                $answers = $question->getAnswers();
                $note = 0;
                if ($value == 1) {
                    $note = $question->getPoints();
                }
                PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `note`) VALUES (".$_SESSION["studentID"].",".$_GET["questionID"].", ".$note.")");
            }
        }
        $this->nextQuestion();
    }

    public function QRFExerciceResponse()
    {
        foreach ($_POST as $key => $value) {
            if(!$this->incCount($key, $value))
            {
                $question = Question::getQuestionByID($key);
                $answers = $question->getAnswers();
                $note = 0;
                //var_dump($question);
                foreach($answers as $answer) {
                    if ($answer->isCorrect() ) {
                        //echo "<script type=\"text/javascript\">alert(\"Bonne reponse:".$answer->getContent()." Votre reponse:".$value.");</script>";
                        if ($answer->getContent() == $value) {
                            $note = $question->getPoints();
                        //    echo "<script type=\"text/javascript\">alert(\"Bien joué!\");</script>";
                        } else {
                        //    echo "<script type=\"text/javascript\">alert(\"Faux!\");</script>";
                        }
                    }
                } 


                PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `response`, `note`) VALUES (".$_SESSION["studentID"].",".$_GET["questionID"].", '".$value."', ".$note.")");
            }
        }

        $this->nextQuestion();

    }

    public function PExerciceResponse()
    {
        foreach ($_POST as $key => $value) {
            if(!$this->incCount($key, $value))
            {
                $question = Question::getQuestionByID($value);
                $tests = $question->getTests();
                $resources = $question->getResources();
                $note = 0;
                //echo "Nombre de fichiers ".count($_FILES)."<br>";
                if ($_FILES[$value]["error"] > 0) {
                    echo "Error: " . $_FILES[$value]["error"] . "<br>";
                } else {
                    // echo "Upload: " . $_FILES[$value]["name"] . "<br>";
                    // echo "Type: " . $_FILES[$value]["type"] . "<br>";
                    // echo "Size: " . ($_FILES[$value]["size"] / 1024) . " kB<br>";
                    // echo "Stored in: " . $_FILES[$value]["tmp_name"]."<br>";
                    $temp = $_FILES[$value]["tmp_name"];
                    $name_file = $_FILES[$value]['name'];
                    move_uploaded_file($temp, "files/".$value."/".$name_file);
                }
                // echo "<br/>";
                // echo "Resources:<hr/>";
                foreach($resources as $resource) {
                    if ($resource->getType() == "make") {
                        $make = $resource->getContent();
                        // echo "Make: " .$make."<hr/>";
                    } else 
                    if ($resource->getType() == "filename") {
                        $filename = $resource->getContent();
                        // echo "Filename: " .$filename."<hr/>";
                    } else 
                    if ($resource->getType() == "execname") {
                        $execname = $resource->getContent();
                        // echo "Execname: " .$execname."<hr/>";
                    }
                } 
                // echo "<br/>";

                /* Compilation de programme chargé */
                exec("cd ./files/".$value.";bash ".$make,$output, $retval);

                /* Passage de tests */
                // echo "Tests<hr/>";
                foreach($tests as $test) {
                    // echo "Input: ".$test->getInput()."<br/>";
                    // echo "Output: ".$test->getOutput()."<br/>";
                    exec("cd ./files/".$value.";./".$execname." ".$test->getInput(),$output, $retval);
                    if ($test->getOutput() == array_pop($output)) {
                        // echo "Test passed<hr/>";
                    } else {
                        // echo "Test not passed<hr/>";
                    }
                } 
                // echo "<br/>";

                PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `note`) VALUES (".$_SESSION["studentID"].",".$_GET["questionID"].", '".$value."')");
            }
        }

        /*
        foreach ($_POST as $key => $value) {
            if(!$this->incCount($key, $value))
            {
                echo "Pquestion key: ".$key." value: ".$value;
                //PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `response`, `note`) VALUES (1,".$questionID.", ".$key.", ".$value.")");
            }
        }*/

        $this->nextQuestion();
    }

    public function LExerciceResponse()
    {
        foreach ($_POST as $key => $value) {
            if (!$this->incCount($key, $value))
            {   
                //echo "INSERT INTO `Points`(`studentID`, `questionID`, `response`) VALUES (".$_SESSION["studentID"].",".$_GET["questionID"].", '".$value."')";
                PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `response`) VALUES (".$_SESSION["studentID"].",".$_GET["questionID"].", '".$value."')");
            }
        }

        $this->nextQuestion();

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
