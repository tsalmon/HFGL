<?php
class Exercicecontroller extends Controller{
    private $exerciseSheetModel;
    private $currentQuestionNumber = 0;
    private $questionsCount;
    private $started=False;
    private $finished=False;

    //      Constructeur
    //**********************
    
    public function __construct(){      
        $this->exerciseSheetModel = $this->loadModel('ExerciceSheet');
        echo "<script>alert('Hey!')</script>";
        $this->exerciseSheetModel->loadByID(1);  
    }

    public function index()
    {
        $questions = $this->exerciseSheetModel->getQuestions();
        $this->questionsCount = count($questions);
        if ($this->currentQuestionNumber < $this->questionsCount) {
            $currentQuestion = $questions[$this->currentQuestionNumber];
            $resources = $currentQuestion->getResources();
            foreach($resources as $resource) {
                if ($resource->getType() == "filename") {
                    $filename = $resource->getContent();
                    echo "Filename: " .$filename."<hr/>";
                }
            } 

            // $filename = "file.c";
        }
        $questionsCount = $this->exerciseSheetModel->getQuestionsCount();
        require 'application/views/_templates/header.php';
        require 'application/views/student_exercice.php';
        require 'application/views/_templates/footer.php';
    }

	public function Liste(){
		require 'application/views/_templates/header.php';
        require 'application/views/_templates/footer.php';
	}
    public function Rendre($exercice_id){
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/footer.php';
    }

	public function DoExercise($exercice_id){
		require 'application/views/_templates/header.php';
        require 'application/views/_templates/footer.php';
	}

    private function nextQuestion(){
        echo "Current question number:".$this->currentQuestionNumber.":::".$this->questionsCount;
        if ($this->questionsCount == $this->currentQuestionNumber) {
            $this->finished = True;
        } 
        $this->index();      
    }

    private function incCount($key, $value){
            $this->started = True;
            if ($key == "currentQuestionNumber") {
                $this->currentQuestionNumber = $value+1; 
                return True;
            }

            if ($key == "questionsCount") {
                $this->questionsCount = $value;     
                return True; 
            }    

            return False;

    }

    public function startExercice(){
        $this->started = True;
        $this->index();
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
                    echo "<script type=\"text/javascript\">alert(\"Bien joué!\");</script>";
                    $note = $question->getPoints();
                } else {
                    echo "<script type=\"text/javascript\">alert(\"Faux!\");</script>";
                }

                foreach($answers as $answer) {
                    if ($answer->isCorrect() ) {
                        echo "<script type=\"text/javascript\">alert(\"Bonne reponse:".$answer->getContent().");</script>";
                    }
                }

                PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `response`, `note`) VALUES (1,".$question->getID().", ".$key.", ".$note.")");
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
                foreach($answers as $answer) {
                    if ($answer->isCorrect() ) {
                        echo "<script type=\"text/javascript\">alert(\"Bonne reponse:".$answer->getContent()." Votre reponse:".$value.");</script>";
                        if ($answer->getContent() == $value) {
                            $note = $question->getPoints();
                            echo "<script type=\"text/javascript\">alert(\"Bien joué!\");</script>";
                        } else {
                            echo "<script type=\"text/javascript\">alert(\"Faux!\");</script>";
                        }
                    }
                } 

                PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `response`, `note`) VALUES (1,".$question->getID().", ".$key.", ".$value.")");
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
                echo "Nombre de fichiers ".count($_FILES)."<br>";
                if ($_FILES[$value]["error"] > 0) {
                    echo "Error: " . $_FILES[$value]["error"] . "<br>";
                } else {
                    echo "Upload: " . $_FILES[$value]["name"] . "<br>";
                    echo "Type: " . $_FILES[$value]["type"] . "<br>";
                    echo "Size: " . ($_FILES[$value]["size"] / 1024) . " kB<br>";
                    echo "Stored in: " . $_FILES[$value]["tmp_name"]."<br>";
                    $temp = $_FILES[$value]["tmp_name"];
                    $name_file = $_FILES[$value]['name'];
                    move_uploaded_file($temp, "files/".$value."/".$name_file);
                }
                echo "<br/>";
                echo "Resources:<hr/>";
                foreach($resources as $resource) {
                    if ($resource->getType() == "make") {
                        $make = $resource->getContent();
                        echo "Make: " .$make."<hr/>";
                    } else 
                    if ($resource->getType() == "filename") {
                        $filename = $resource->getContent();
                        echo "Filename: " .$filename."<hr/>";
                    } else 
                    if ($resource->getType() == "execname") {
                        $execname = $resource->getContent();
                        echo "Execname: " .$execname."<hr/>";
                    }
                } 
                echo "<br/>";

                /* Compilation de programme chargé */
                exec("cd ./files/".$value.";bash ".$make,$output, $retval);

                /* Passage de tests */
                echo "Tests<hr/>";
                foreach($tests as $test) {
                    echo "Input: ".$test->getInput()."<br/>";
                    echo "Output: ".$test->getOutput()."<br/>";
                    exec("cd ./files/".$value.";./".$execname." ".$test->getInput(),$output, $retval);
                    if ($test->getOutput() == array_pop($output)) {
                        echo "Test passed<hr/>";
                    } else {
                        echo "Test not passed<hr/>";
                    }
                } 
                echo "<br/>";

                PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `response`, `note`) VALUES (1,".$question->getID().", ".$key.", ".$value.")");
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
                PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `response`) VALUES (1,".$questionID.", ".$key.", ".$value.")");
            }
        }

        $this->nextQuestion();

    }
}