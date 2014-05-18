<?php
require_once("application/libs/controller.php");
require_once("application/models/QCMQuestion.php");
require_once("application/models/QRFQuestion.php");
require_once("application/models/LQuestion.php");
require_once("application/models/PQuestion.php");
require_once("application/models/PDOHelper.php");

/*
define('QCM',1);
define('QRF',2);
define('P',3);
define('L',4);
*/
define('Examen', 1);    
define('TP', 4);

class ExerciceSheet{

    private $deadline;
    private $available;
    private $questionnaireID;
    private $questionnaireType;
    private $questions;

    public function __construct()
    {
        
    }

    /* Getters & Setters */
    public function getID()
    {
        return $this->questionnaireID;
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function getQuestionsCount()
    {
        return count($this->questions);
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
        //echo "INSERT INTO `Questionnaire`(`questionnaireType`, `deadline`, `available`) VALUES(".Examen.",".$this->deadline.",".$this->available.")<br>";
        if (is_null($this->questionnaireID)) {
            //PDOHelper::getInstance()->exec("INSERT INTO `Questionnaire`(`questionnaireType`, `deadline`, `available`) VALUES(".Examen.",".$this->deadline.",".$this->available.")");;
            PDOHelper::getInstance()->exec("INSERT INTO `Questionnaire`(`questionnaireType`, `deadline`, `available`) VALUES(".Examen.", STR_TO_DATE('02/02/2015', '%m/%d/%Y'), STR_TO_DATE('01/02/2015', '%m/%d/%Y'))");;
            $this->questionnaireID = PDOHelper::getInstance()->lastInsertID();
        }

        //echo "Inserted questionnaireID:".$questionnaireID."<br>";
        if (!is_null($this->questions)) {
            foreach ($this->questions as $question) {
                //echo "Try to write question!";
                $question->writeToDBForQuestionnaireID($this->questionnaireID);
            }    
        }
    

        return $this->questionnaireID;
    }

    //Initializes current questionnaire with data from database using questionnaireID
    public function loadByID($questionnaireID){

        if($questionnaireRequestResult = PDOHelper::getInstance()->query("SELECT * FROM Questionnaire WHERE questionnaireID=".$questionnaireID.""))
        {
            //echo "Questionnaire for id ".$questionnaireID." loaded";
            $questionnaireRow = $questionnaireRequestResult->fetch(PDO::FETCH_ASSOC);
            $this->questionnaireID = $questionnaireID;
            $this->available = $questionnaireRow['available'];
            $this->deadline = $questionnaireRow['deadline'];
        }
        else
        {
            throw new Exception('Questionnaire wasnt found.');
        }

        if ($questionsRequestResult = PDOHelper::getInstance()->query("SELECT questionID FROM Questions WHERE questionnaireID=".$questionnaireID))
        {
            //enumertaion of questions of current questionnaire
            while($currentQuestionsRow = $questionsRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $questionID = $currentQuestionsRow['questionID'];
                $this->questions[] = Question::getQuestionByID($questionID);
            }
        }
        else
        {
            throw new Exception('Questions for current questionnaire werent found.');
        }
    }
}