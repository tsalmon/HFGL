<?php
require_once 'application/models/Chapter.php';
require_once 'application/models/AutomaticCorrector.php';
require_once 'application/models/Result.php';

//require_once 'application/models/PersonFactory.php';

class Studentcontroller extends Controller{
    private $titre_firstpart;
    private $list_part;
    private $list_coursID;
    private $liste_matiere;

    public function index() //consulter cours
    { 
        $page = "student";
        $MODELcours = $this->loadModel('CourseSubstcription');
        $student = PersonFactory::getPerson($_SESSION["email"]);
        $liste_cours = $MODELcours->getCourses($student);
        $currentCourse = null;
        // $exam = false;

        if (isset($_GET["cours"])){
            $currentCourse = CourseFactory::getCourse($_GET["cours"],true);
            $exam = $currentCourse->finalExam();
            $project = $currentCourse->project();
        }
        // if($currentCourse != null && $this->CoursehaveExamen($currentCourse->CourseID())){
        //     $exam = true;
        // }
        // if (isset($currentCourse->project)) {
        //     $projet = $currentCourse->project;
        // }
        require 'application/views/_templates/header.php';
        require 'application/views/student.php';
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

    private function CoursehaveExamen($cours_id){
        return (!is_null(CourseFactory::getCourse($cours_id,true)->finalExam()));
    }

    public function DoExercice(){
        $_SESSION["type"] = $_GET["type"];
        $_SESSION["coursTitle"] = $_GET["courseTitle"];
        if ($_SESSION["type"] == "chapter") {
            $_SESSION["partTitle"] = $_GET["partTitle"];
            $_SESSION["chapterTitle"] = $_GET["chapterTitle"];
            $_SESSION["chapterID"] = intval($_GET["chapterID"]);
        } else 
        if ($_SESSION["type"] == "examen") {
            $_SESSION["courseID"] = $_GET["courseID"];
        }

        $_SESSION["currentQuestionNumber"] = 0;
        $_SESSION["started"] = False;
        $_SESSION["finished"] = False;


        header('location: '.URL.'Student/Exercice');
    }

    public function StartExercice(){
        $_SESSION["started"] = True;
        header('location: '.URL.'Student/Exercice');
    }

    private function NextQuestion(){
        if ($_SESSION["questionsCount"] == $_SESSION["currentQuestionNumber"]) {
            $_SESSION["finished"] = True;
            AutomaticCorrector::saveAttempt($_SESSION["studentID"], $_SESSION["questionnaireID"]);
        } 

        header('location: '.URL.'Student/Exercice');
    }

    public function Exercice(){
        $questionnaire = NULL;
        if ($_SESSION["type"] == "chapter") {
            $chpt = new Chapter($_SESSION["chapterID"]);
            $questionnaire = $chpt->exercices();
        } elseif ($_SESSION["type"] == "examen") {
            $course = CourseFactory::getCourse($_SESSION["courseID"],true);
            $questionnaire = $course->finalExam();
        }

        if (is_null($questionnaire)) {
            header('location: '.URL.'Student');
        }

        $questions = $questionnaire->getQuestions();
        $MODELparam= $this->loadModel('PersonFactory');
        $student = $MODELparam->getPerson($_SESSION["email"]);

        $_SESSION["studentID"] = $student->studentID();
        $_SESSION["questionsCount"] = count($questions);
        $_SESSION["questionnaireID"] = $questionnaire->getID();

        $attemptsCount = AutomaticCorrector::attemptsRemain($_SESSION["studentID"], $questionnaire->getID());

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
            require 'application/views/_templates/header.php';
            require 'application/views/student_exercice.php';
            require 'application/views/_templates/footer.php';
        } else {
            header('location: '.URL.'/Student');
        }

    }

    public function ExerciceOk(){
        $_SESSION["questionsCount"] = $_SESSION["currentQuestionNumber"];
        $this->NextQuestion();
    }

    public  function ExerciceSave(){
                        
    }

    private function SecondaryParameter($key, $value){
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

    public function QCMExerciceResponse()
    {
        foreach ($_POST as $key => $value) {
            if(!$this->SecondaryParameter($key, $value))
            {
                $question = Question::getQuestionByID($key);
                $answers = $question->getAnswers();
                $note = 0;
                if ($value == 1) {
                    $note = $question->getPoints();
                }
                $corrector = new AutomaticCorrector();
                $corrector->correctQuestion($_GET["questionID"], $_SESSION["studentID"], $note);
                //PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `note`) VALUES (".$_SESSION["studentID"].",".$_GET["questionID"].", ".$note.")");
            }
        }
        $this->NextQuestion();
    }

    public function QRFExerciceResponse()
    {
        foreach ($_POST as $key => $value) {
            if(!$this->SecondaryParameter($key, $value))
            {
                $question = Question::getQuestionByID($key);
                $answers = $question->getAnswers();
                $note = 0;

                foreach($answers as $answer) {
                    if ($answer->getContent() == $value) {
                        $note = $question->getPoints();
                    }
                } 
                $corrector = new AutomaticCorrector();
                $corrector->correctQuestion($_GET["questionID"], $_SESSION["studentID"],$note, $value);
            }
        }
        $this->NextQuestion();
    }

    public function PExerciceResponse()
    {
        foreach ($_POST as $key => $value) {
            if(!$this->SecondaryParameter($key, $value))
            {
                $question = Question::getQuestionByID($value);
                $tests = $question->getTests();
                $resources = $question->getResources();
                $note = 0;
                //echo "Nombre de fichiers ".count($_FILES)."<br>";
                if ($_FILES[$value]["error"] > 0) {
                    echo "Error: " . $_FILES[$value]["error"] . "<br>";
                } else {
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
                $note = $question->getPoints();

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
                        $note = 0;
                        // echo "Test not passed<hr/>";
                    }
                } 
                // echo "<br/>";
                $corrector = new AutomaticCorrector();
                $corrector->correctQuestion($_GET["questionID"], $_SESSION["studentID"], $note);
            }
        }

        $this->NextQuestion();
    }

    public function LExerciceResponse()
    {
        foreach ($_POST as $key => $value) {
            if (!$this->SecondaryParameter($key, $value))
            {   
                $corrector = new AutomaticCorrector();
                $corrector->saveResponseToCorrect($_GET["questionID"], $_SESSION["studentID"], $value);
            }
        }

        $this->NextQuestion();
    }

    public function Notes()
    {   
        
        $page = "student";
        $MODELcours = $this->loadModel('CourseSubstcription');
        $student = PersonFactory::getPerson($_SESSION["email"]);
        $liste_cours = $MODELcours->getCourses($student);
        
        $results=[];

        foreach ($liste_cours as $course) {
            $results[]= new Result($student->studentID(),$course);
        }

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

    public function Project(){
        $page = "projet";        
        $student = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);

        $course = CourseFactory::getCourse($_GET["cours"],true);
        $project = $course->project();
        $corrector = new AutomaticCorrector();
        $soumis = $corrector->hasAnswerForQuestion($project->getQuestions()[0]->getID(), $student->studentID());
        
        require 'application/views/_templates/header.php';
        require 'application/views/student_view_projet.php';
        require 'application/views/_templates/footer.php';  
    }

    public function LoadProject(){
        $page = "projet";
        $student = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);

        $course = CourseFactory::getCourse($_POST["courseID"],true);
        $project = $course->project();
        $projectQuestionID = $project->getQuestions()[0]->getID();
        $corrector = new AutomaticCorrector();
        $corrector->correctQuestion($projectQuestionID, $student->studentID(), 0);
        header('location: '.URL.'Student/Project?cours='.$_POST["courseID"]);
    }

    public function NotesDeCours()
    {
        $page = "student";
        $MODELcours = $this->loadModel('CourseSubstcription');
        $student = PersonFactory::getPerson($_SESSION["email"]);
        $course = CourseFactory::getCourse($_GET["courseID"], true);
        $part = new Part($_GET["partID"]);
        $chapter = new Chapter($_GET["chapterID"]);
        $coursenotes = $chapter->courseNotes();
        $chapterTitle = $chapter->title();
        $courseTitle = $course->title();
        $partTitle = $part->title();
        $url=null;
        if (isset($coursenotes)) {
            $url = URL."files/".$coursenotes->getURL();
        }

        require 'application/views/_templates/header.php';
        require 'application/views/student_view_notesDeCours.php';
        require 'application/views/_templates/footer.php';
    }

    public function correct($id){ 
        $page = "student";
        $student = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $cours_teaching = $this->loadModel('CourseSubstcription')->getCourses($student);
        $currentCourse = null;
        if (isset($_GET["cours"])){
            $currentCourse=CourseFactory::getCourse($_GET["cours"],true);
        }
        require 'application/views/_templates/header.php';
        require 'application/views/student_correct.php';
        require 'application/views/_templates/footer.php';     
    }
    
    public function printQuestionsToCorrect($student){
        $questions=$student->getQuestionsToCorrect();
        echo "<h3> Questions à corriger</h3>";
        echo "<ul>";
        foreach($questions as $questionID){
            $db=  PDOHelper::getInstance();
            $res=$db->query("SELECT assignment FROM Question WHERE questionID=".$questionID);
            $fetch=$res->fetch(PDO::FETCH_ASSOC);
            $description=$fetch["assignment"];
            echo "<li><a href=".URL.'Student/correct/'.$questionID.">".$description."</a></li>";
        }
        echo "</ul>";
        
    }

    public function printQuestionCorrect($id){
        $db=  PDOHelper::getInstance();
        $res=$db->query("SELECT assignment FROM Question WHERE questionID=".$id);
        $fetch=$res->fetch(PDO::FETCH_ASSOC);
        $description=$fetch["assignment"];
        echo "<h3> Question : ".$description."</h3>";
        echo' <form action="../CorrectNote" method="post" enctype="multipart/form-data">';
        echo "<table style='width:95%;'><tr><th>Reponse</th><th>Points</th></tr>";
        $query="SELECT points FROM Question WHERE questionID=".$id;
        $res1=$db->query($query);
        $fetch=$res1->fetch(PDO::FETCH_ASSOC);
        $points=$fetch["points"];
        $query="SELECT response, studentID FROM Points WHERE validated=3 AND questionID=".$id;
        $res=$db->query($query);
        $fetch=$res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $reponse){            
            echo "<tr><td>".$reponse["response"]."</td>
                <td><input type='text' name='".$reponse["studentID"]."' value='' />/".$points."</td></tr>";
        }
        echo "</table>";
        echo '<input class="bouton" type="submit" name="'.$id.'" value="Enregistrer" />';
        echo "</form>";
        
    }
    public function CorrectNote(){
        $student = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        foreach($_POST as $key => $value){
            if($value=="Enregistrer"){
                $questionID=$key;
            }
        }
        foreach($_POST as $key => $value){
            if($value!="Enregistrer"){
                $student->correctQuestion($questionID,$key,$value);
            }
        }
        header('location: '.URL.'Student');
        
    }
    
    public function Deconnexion(){
        if(session_destroy()){
            header('location: '.URL.'Welcome');
        } else {
            header('location: '.URL.'Student');
        }
    }
}
