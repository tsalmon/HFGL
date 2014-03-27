<?php
require_once("application/libs/controller.php");
require_once("application/models/Question.php");
require_once("application/models/QCMAnswer.php");
require_once("application/models/QRFAnswer.php");
require_once("application/models/LAnswer.php");
require_once("application/models/PDOHelper.php");
require_once("application/models/Document.php");


define('QCM',1);
define('QRF',2);
define('P',3);
define('L',4);

define('Examen', 1);
define('TP', 4);

class ExerciseSheet extends Document{

    private $deadline;
    private $available;
    private $questionnaireID;
    private $questionnaireType;
    private $questions;
    private $db;

    public function __construct()
    {
        $this->db = PDOHelper::getInstance();
    }

    public function show(){
        foreach($this->questions as $question) {
            echo $question->getAssignment().'<br/>';
            echo '<form action="">';
            $curanswers = $question->getAnswers();
            foreach($curanswers as $answer) {
                if($answer instanceof QCMAnswer)
                {
                    echo '<input type="checkbox" name="checkboxanswer" value="val">'.$answer->getContent().'<br>';
                } else
                    if($answer instanceof QCMAnswer || $answer instanceof QRFAnswer)
                    {
                        echo '<input type="text" name="textanswer" placeholder="Your answer...">';
                    }
            }
            echo '</form>';
            echo '<br/>';
        }
    }

    public function getID()
    {
        return $this->questionnaireID;
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function addQuestion($question)
    {
        $this->questions[] = $question;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    public function setAvailableDate($available)
    {
        $this->available = $available;
    }

    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    public function setQuestionnaireType($type)
    {
        $this->questionnaireType = $type;
    }

    //Add current questionnaire to database. Returns questionnaireID.
    public function writeToDatabase()
    {
        PDOHelper::getInstance()->exec("INSERT INTO `Questionnaire`(`questionnaireType`, `deadline`, `available`) VALUES(".Examen.",".$this->deadline.",".$this->available.")");;
        echo "INSERT INTO `Questionnaire`(`questionnaireType`, `deadline`, `available`) VALUES(".Examen.",".$this->deadline.",".$this->available.")";
        $questionnaireID = PDOHelper::getInstance()->lastInsertID();

        foreach ($this->questions as $question) {
           echo "INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$question->getAssignment()."',2,".$this->questionnaireType.")<br>";
           PDOHelper::getInstance()->exec("INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$question->getAssignment()."',2,".$this->questionnaireType.")");
           $questionID = PDOHelper::getInstance()->lastInsertID();
           echo "QuestionID:".$questionID."<br>";
           echo "INSERT INTO `Questions`(`questionnaireID`, `questionID`) VALUES (".$questionnaireID.",".$questionID.")";
           PDOHelper::getInstance()->exec("INSERT INTO `Questions`(`questionnaireID`, `questionID`) VALUES (".$questionnaireID.",".$questionID.")");

           if($this->questionnaireType == L)
               return $questionnaireID;

           foreach ($question->getAnswers() as $answer)
           {
                $correct = $answer->isCorrect()?1:0;
                echo "INSERT INTO `Responses`(`questionID`, `content`, `correct`) (".$questionID.",".$answer->content.",".$correct.")<br>";
                PDOHelper::getInstance()->exec("INSERT INTO `Responses`(`questionID`, `content`, `correct`) VALUES (".$questionID.",'".$answer->content."',".$correct.")");
           }

           return $questionnaireID;
        }
    }

    //Initializes current questionnaire with data from database using questionnaireID
    public function loadByID($questionnaireID){
        $questions = array();
        if($questionnaireRequestResult = $this->db->query("SELECT deadline, available FROM Questionnaire WHERE questionnaireID=".$questionnaireID.""))
        {
            $questionnaireRow = $questionnaireRequestResult->fetch(PDF::FETCH_ASSOC);
            $this->questionnaireID = $questionnaireRow['questionnaireID'];
            $this->available = $questionnaireRow['available'];
            $this->deadline = $questionnaireRow['deadline'];
        }
        else
        {
            throw new Exception('Questionnaire wasnt found.');
        }

        //getting questionnaire object from DB
        if ($questionsRequestResult = $this->db->query("SELECT questionID FROM Questions WHERE questionnaireID=".$questionnaireID))
        {
            //enumertaion of questions of current questionnaire
            while($currentQuestionsRow = $questionsRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $currentQuestionID = $currentQuestionsRow['questionID'];
                //getting question objects from DB
                if($questionRequestResult = $this->db->query("SELECT * FROM Question WHERE questionID=".$currentQuestionID))
                {
                    //question processing
                    while($currentQuestionRow = $questionRequestResult->fetch(PDO::FETCH_ASSOC))
                    {
                        $currentQuestionAssignment = $currentQuestionRow['assignment'];
                        $currentQuestionTypeID = $currentQuestionRow['typeID'];
                        $currentQuestionPoints = $currentQuestionRow['points'];

                        //Getting answers for current question
                        $answerObjects = array();
                        if($answersRequestResult = $this->db->query("SELECT * FROM Responses WHERE questionID=".$currentQuestionID))
                        {
                            //enumeration of answers
                            while($currentAnswerRow = $answersRequestResult->fetch(PDO::FETCH_ASSOC))
                            {
                                switch($currentQuestionTypeID)
                                {
                                    case QCM:
                                    {
                                        $answerObjects[] = new QCMAnswer((bool)$currentAnswerRow['correct'], $currentAnswerRow['content']);
                                    }
                                        break;

                                    case QRF:
                                    {
                                        $answerObjects[] = new QRFAnswer((bool)$currentAnswerRow['correct'], $currentAnswerRow['content']);
                                    }
                                        break;
                                }
                            }
                        }

                        $this->questions[] = new Question($currentQuestionAssignment, $answerObjects, $currentQuestionPoints);
                    }
                }
                else
                {
                    throw new Exception('Questions for current questionnaire werent found.');
                }
            }
        }
        else
        {
            throw new Exception('Questions for current questionnaire werent found.');
        }
        return $questions;
    }
}