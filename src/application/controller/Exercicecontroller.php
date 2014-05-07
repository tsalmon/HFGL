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
        $this->exerciseSheetModel->loadByID(1);  
    }

    public function index()
    {
        $questions = $this->exerciseSheetModel->getQuestions();
        $this->questionsCount = count($questions);
        $currentQuestion = $questions[$this->currentQuestionNumber];
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

                PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `response`, `note`) VALUES (1,".$questionID.", ".$key.", ".$value.")");
            }
        }

        $this->nextQuestion();

    }

    public function PExerciceResponse()
    {

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