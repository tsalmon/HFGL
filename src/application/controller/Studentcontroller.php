<?php
require_once 'application/models/Chapter.php';
require_once 'application/models/Result.php';
require_once 'application/models/AutomaticCorrector.php';

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
        }

        require 'application/views/_templates/header.php';
        require 'application/views/student_exercice.php';
        require 'application/views/_templates/footer.php';
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
                $validated = 0;
                /*
                $db=PDOHelper::getInstance();
                $query="SELECT Question.typeID FROM Question WHERE Question.questionID =".$_GET["questionID"];
                $res=$db->query($query);
                $fetch=$res->fetch(PDO::FETCH_ASSOC);
                $roleID=$fetch["typeID"];
                if ($roleID==QuestionTypeManager::getInstance()->getLSID()){
                    
                    $query="SELECT studentID FROM (SELECT * FROM Student JOIN StudentEstimation AS se ON Student.studentID=se.estimatingStudentID) as test WHERE questionID=".$_GET["questionID"];
                    $res=$db->query($query);
                    if ($res!=false){
                        $fetch=$res->fetchAll(PDO::FETCH_ASSOC);
                        $students=$fetch["studentID"];
                    }
                    else{
                        $students=[];
                    }
                    $query_course="SELECT DISTINCT Course.courseID FROM (
                        SELECT t5.questionnaireID, courseID FROM (
                        SELECT Part.partID, t4.questionnaireID FROM (
                        SELECT Chapters.partID, t3.questionnaireID FROM (
                        SELECT chapterID, t2.questionnaireID From (
                        SELECT table1.questionnaireID FROM (
                        SELECT questionnaireID FROM Questions WHERE questionID =1) as table1 
                        JOIN Questionnaire ON table1.questionnaireID=Questionnaire.questionnaireID) as t2 
                        JOIN Chapter ON Chapter.questionnaireID=t2.questionnaireID) as t3 
                        JOIN Chapters on Chapters.chapterID=t3.chapterID) as t4 
                        JOIN Part ON Part.partID=t4.partID or Part.questionnaireID=t4.questionnaireID) as t5 
                        JOIN Parts on Parts.partID= t5.partID)as t6 JOIN 
                        Course on Course.questionnaireID=t6.questionnaireID or Course.courseID=t6.courseID";
                    $resCourse=$db->query($query_course);
                    $fetch=$resCourse->fetch(PDO::FETCH_ASSOC);
                    $course=  CourseFactory::getCourse($fetch["courseID"], true);
                    $courseStudentsID=[];
                    foreach($course->getStudents() as $student){
                        $courseStudentsID=$student->studentID();
                    }
                    $freeStudents=array_diff($courseStudentsID,$students);
                    if($freeStudents==[]){
                        $studentID=$students[0];
                    }
                    else{
                        $studentID=$freeStudents[0];
                    }
                    $db->exec("INSERT INTO StudentEstimation (estimatingStudentID, estimatedStudentID, questionID) VALUES(".$studentID.",".$_SESSION["studentID"].",".$_GET["questionID"]);
                    $validated=3;
                }    
                else{
                   $validated=2;
                }*/
                $corrector = new AutomaticCorrector();
                $corrector->saveResponseToCorrect($_GET["questionID"], $_SESSION["studentID"], $value, $validated);
                //$db->exec("INSERT INTO `Points`(`studentID`, `questionID`, `response`/*, validated*/) VALUES (".$_SESSION["studentID"].",".$_GET["questionID"].", '".$value/*."', ".$validated*/.")");
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

    public function Deconnexion(){
        if(session_destroy()){
            header('location: '.URL.'Welcome');
        } else {
            header('location: '.URL.'Student');
        }
    }
}
