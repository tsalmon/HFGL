<?php
require_once 'application/models/Chapter.php';
require_once 'application/models/QCMQuestion.php';
require_once 'application/models/LQuestion.php';
require_once 'application/models/QRFQuestion.php';
require_once 'application/models/PQuestion.php';
require_once 'application/models/XMLHelper.php';

class Professorcontroller extends Controller{

    public function index(){ 
        $page = "prof";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $cours_teaching = $this->loadModel('CourseTeaching')->getCourses($prof);
        $currentCourse = null;
        if (isset($_GET["cours"])){
            $currentCourse=CourseFactory::getCourse($_GET["cours"],true);
            $exam = $currentCourse->finalExam();
            $project = $currentCourse->project();
        }
        require 'application/views/_templates/header.php';
        require 'application/views/teacher.php';
        require 'application/views/_templates/footer.php';     
    }
    
    public function correct($id){ 
        $page = "prof";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $cours_teaching = $this->loadModel('CourseTeaching')->getCourses($prof);
        $currentCourse = null;
        if (isset($_GET["cours"])){
            $currentCourse=CourseFactory::getCourse($_GET["cours"],true);
        }
        require 'application/views/_templates/header.php';
        require 'application/views/enseignant_correct.php';
        require 'application/views/_templates/footer.php';     
    }
    
    public function validate($id){ 
        $page = "prof";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $cours_teaching = $this->loadModel('CourseTeaching')->getCourses($prof);
        $currentCourse = null;
        if (isset($_GET["cours"])){
            $currentCourse=CourseFactory::getCourse($_GET["cours"],true);
        }
        require 'application/views/_templates/header.php';
        require 'application/views/enseignant_correct.php';
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
        /*$prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);*/
        $_SESSION["quest_for"] = "examen";
        $_SESSION["ex_course"] = $_GET["courseID"];
        header('location: '.URL.'Professor/CreateExercice');
    }

    public function CreateProjet(){
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $course = CourseFactory::getCourse($_GET["courseID"], true);
        $courseTitle = $course->title();
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerProjet.php';
        require 'application/views/_templates/footer.php';
    }

    public function SaveProject(){
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $dateAvailable = $_POST["dateAvailable"];
        $dateDeadline = $_POST["dateDeadline"];
        $assignment = $_POST["assignment"];
        $project = new ExerciceSheet();
        $project->setDeadline($dateDeadline);
        $project->setAvailableDate($dateAvailable);
        $project->setDescription($assignment);
        $project->setType(QuestionnaireTypeManager::getInstance()->getProjetID());
        $course = CourseFactory::getCourse($_POST["courseID"], true);
        $course->setProject($project);

        header('location: '.URL.'Professor/?cours='.$_POST["courseID"]);
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

    public function AddChapterExercice(){
        $_SESSION["ex_course"] = $_GET["cours"];
        $_SESSION["ex_part"] = $_GET["part"];
        $_SESSION["ex_chpt"] = $_GET["chapter"];
        $_SESSION["quest_for"] = "chapter";
        header('location: '.URL.'Professor/CreateExercice');
    }

    public function CreateChapter_ok(){ 

        $chapter = new Chapter($_POST["chp_name"], false);

        if($_FILES["chp_file_lesson"]['size']!= 0){
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
            
            $chapter = $this->NewChapter();


            $dir = getcwd();
            if(!move_uploaded_file($_FILES["chp_file_lesson"]["tmp_name"], $dir."/files/".$_GET["cours"]."_".$_GET["part"]."_".($chapter->chapterID()).".pdf")){
                $error = "move";
                return ;
            }
            $notes = new CourseNote($_GET["cours"]."_".$_GET["part"]."_".($chapter->chapterID()).".pdf");
            $chapter->setCourseNotes($notes);
        } else {
            $this->NewChapter();
        }
        header('location: '.URL.'Professor/?cours='.$_GET["cours"]);
    }


    /*return the id of the new chapter*/
    private function NewChapter(){
        $chapter = new Chapter($_POST["chp_name"], false);
        $chapter->setDescription($_POST["chp_descr"]);
        $part = new Part($_GET["part"]);
        $part->addChapter($chapter);
        return $chapter;
    }

    public function ModifyChapter(){
        $chapter = new Chapter($_GET["chapter"], true);

        $chapter->setTitle($_POST["chp_name"]);
        $chapter->setDescription($_POST["chp_descr"]);

        if($_FILES["chp_file_lesson"]['size']!= 0){
            if(pathinfo($_FILES["chp_file_lesson"]["name"], PATHINFO_EXTENSION) != "pdf"){
                $error = "pdf";
                Professorcontroller::ModifyChapter();
                return ;
            }
            if($_FILES["chp_file_lesson"]['size']>$_POST['MAX_FILE_SIZE']){
                $error = "size";
                Professorcontroller::ModifyChapter();
                return ;
            }
            $dir = "files/Chapters/".$chapter->chapterID();
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            if(!move_uploaded_file($_FILES["chp_file_lesson"]["tmp_name"], $dir."/".$_FILES["chp_file_lesson"]["name"])){
                $error = "move";
                Professorcontroller::ModifyChapter();
                return ;
            }

            $notes = new CourseNote("http://localhost/src/".$dir."/".$_FILES["chp_file_lesson"]["name"]);
            $chapter->setCourseNotes($notes);
        }


        header('location: '.URL.'Professor/?cours='.$_GET["cours"]);
    }

    public function DeleteChapter(){
        $chapter = new Chapter($_GET["chapter"], true);
        $chapter->delete();
        header('location: '.URL.'Professor/?cours='.$_GET["cours"]);
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
            $exercice->setDescription(nl2br($_POST["description"]));
            $exercice->setDeadline($_POST["deadline_day"]."/".$_POST["deadline_month"]."/".$_POST["deadline_year"]);
            $exercice->setAvailableDate($_POST["avalable_day"]."/".$_POST["avalable_month"]."/".$_POST["avalable_year"]);
        }
        header('location: '.URL.'Professor/AddQuestion');
    }

    public function FinalizeExerciceCreation(){

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

        $exercice = new ExerciceSheet();
        PDOHelper::getInstance()->query("UPDATE `".$questionnaire_table."` SET `questionnaireID`=".$_SESSION["ex_id"]." WHERE `".$table_pk."`=".$_SESSION[$session_val]);
        header('location: '.URL.'Professor/index');
    }

    public function CreateExerciceWithXML(){
        if ($_FILES["exerciceXML"]["error"] > 0) {
            echo "Error: " . $_FILES["exerciceXML"]["error"] . "<br>";
        } else {
            $temp = $_FILES["exerciceXML"]["tmp_name"];
            $name_file = $_FILES["exerciceXML"]['name'];
            move_uploaded_file($temp, "files/loadedxml/".$name_file);
            $exerciceSheet = XMLHelper::parseXML("files/loadedxml/".$name_file);
            $exerciceSheet->setDeadline($_POST["datelimite"]);
            $exerciceSheet->setAvailableDate($_POST["dateaccess"]);

            $questionnaire_table = null;
            $table_pk = null;
            $session_val = null;

            $_SESSION["ex_id"] = $exerciceSheet->writeToDatabase();
            $this->FinalizeExerciceCreation();
        }
    }

    public function AddQuestion(){
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);
        $page="AddQuestion";
        if (isset($qt_nb)) {
           $qt_nb++;
        }

        $questionnaire = new ExerciceSheet($_SESSION["ex_id"]);

        $qt=null;

        if(isset($_POST["nb_qt"])){ // if it's not the first question
            if($_POST["lareponse"] == "libre"){ 
                //Question libre
                if(array_key_exists ("student_corrector" , $_POST)){
                    $qt = new LQuestion($_POST["question"], $_POST["tip"], $_POST["points"], true);
                }else{
                    $qt = new LQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                }
            } elseif($_POST["lareponse"] == "checkbox"){ 
                //QCM

                $qt = new QCMQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                foreach ($_POST["r"] as $key => $value) {
                    $a = new Answer($value, isset($_POST["c".$key]));
                    $qt->addAnswer($a);
                }

            } elseif ($_POST["lareponse"] == "lines"){ 
                //QRF

                $qt = new QRFQuestion($_POST["question"], $_POST["tip"], $_POST["points"]);
                foreach ($_POST["r"] as $key => $value) {
                    $qt->addAnswer(new Answer($value, 1));
                }

            } elseif($_POST["lareponse"] == "code"){ 
                //Programme

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

            $vc = $_POST["addQuestionAction"] == "Valider et continuer";
            $vf = $_POST["addQuestionAction"] == "Valider et finir";
            $f  = $_POST["addQuestionAction"] == "Finir sans valider";


            if (($vf || $vc) && isset($qt)) {
                $questionnaire->addQuestion($qt);
            }

            if ($vf || $f) {
                $this->FinalizeExerciceCreation();
            }
            
        }
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_ajouteQuestion.php';
        require 'application/views/_templates/footer.php';
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
    
    public function printQuestionsToCorrect($prof){
        $questions=$prof->getQuestionsToCorrect();
        echo "<h3> Questions à corriger</h3>";
        echo "<ul>";
        foreach($questions as $questionID){
            $db=  PDOHelper::getInstance();
            $res=$db->query("SELECT assignment FROM Question WHERE questionID=".$questionID);
            $fetch=$res->fetch(PDO::FETCH_ASSOC);
            $description=$fetch["assignment"];
            echo "<li><a href=".URL.'Professor/correct/'.$questionID.">".$description."</a></li>";
        }
        echo "<ul>";
        
    }

    
    public function printQuestionsToValidate($prof){
        $questions=$prof->getQuestionsToValidate();
        echo "<h3> Questions à valider</h3>";
        echo "<ul>";
        foreach($questions as $key => $questionID){
            $db=  PDOHelper::getInstance();
            $res=$db->query("SELECT assignment FROM Question WHERE questionID=".$questionID);
            $fetch=$res->fetch(PDO::FETCH_ASSOC);
            $description=$fetch["assignment"];
            echo "<li><a href=".URL.'Professor/validate/'.$questionID."/>".$description."</a></li>";
        }
        echo "<ul>";
    }
    public function printQuestionCorrect($id){
        $db=  PDOHelper::getInstance();
        $res=$db->query("SELECT assignment FROM Question WHERE questionID=".$id);
        $fetch=$res->fetch(PDO::FETCH_ASSOC);
        $description=$fetch["assignment"];
        echo "<h3> Question : ".$description."</h3>";
        echo' <form action="ValidateNote" method="post" enctype="multipart/form-data">';
        echo "<table style='width:95%;'><tr><th>Reponse</th><th>Points</th></tr>";
        $query="SELECT points FROM Question WHERE questionID=".$id;
        $res1=$db->query($query);
        $fetch=$res1->fetch(PDO::FETCH_ASSOC);
        $points=$fetch["points"];
        $query="SELECT response, studentID FROM Points WHERE validated=2 AND questionID=".$id;
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
    
    public function printQuestionValidate($id){
        $db=  PDOHelper::getInstance();
        $res=$db->query("SELECT assignment FROM Question WHERE questionID=".$id);
        $fetch=$res->fetch(PDO::FETCH_ASSOC);
        $description=$fetch["assignment"];
        echo "<h3> Question : ".$description."</h3>";
        echo' <form action="ValidateNote" method="post" enctype="multipart/form-data">';
        echo "<table style='width:95%;'><tr><th>Reponse</th><th>Points</th></tr>";
        $query="SELECT response, studentID FROM Points WHERE validated=1 AND questionID=".$id;
        $res=$db->query($query);
        $fetch=$res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $reponse){            
            $query="SELECT note FROM Points WHERE questionID=".$id." AND studentID=".$reponse["studentID"];
            $res1=$db->query($query);
            $fetch=$res1->fetch(PDO::FETCH_ASSOC);
            $points=$fetch["note"];
            echo "<tr><td>".$reponse["response"]."</td>
                <td><input type='text' name='note' value='' />/".$points."</td></tr>";
        }
        echo "</table>";
        echo '<input class="bouton" type="submit" name="enregistrer" value="Enregistrer" />';
        echo "</form>";
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

    public function AfficherCours(){
        $page = "ViewCours";
        $prof = $this->loadModel('PersonFactory')->getPerson($_SESSION["email"]);

        $cours = CourseFactory::getCourse($_GET["cours"], true);
        $part = $cours->part($_GET["part"]);
        $chp = $part->chapter($_GET["chp"]);
        
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_creerChapitre.php';
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
