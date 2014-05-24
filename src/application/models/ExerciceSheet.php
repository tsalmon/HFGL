<?php
require_once("application/libs/controller.php");
require_once("application/models/QCMQuestion.php");
require_once("application/models/QuestionnaireTypeManager.php");
require_once("application/models/QRFQuestion.php");
require_once("application/models/LQuestion.php");
require_once("application/models/PQuestion.php");
require_once("application/models/PDOHelper.php");


class ExerciceSheet{

    private $deadline;
    private $available;
    private $questionnaireID;
    private $questionnaireType;
    private $questions;

    public function __construct( $questionnaireID = -1)
    {
        if ($questionnaireID != -1) {
            if($questionnaireRequestResult = PDOHelper::getInstance()->query("SELECT * FROM Questionnaire WHERE questionnaireID=".$questionnaireID.""))
            {
                $questionnaireRow = $questionnaireRequestResult->fetch(PDO::FETCH_ASSOC);
                $this->questionnaireID = $questionnaireID;
                $this->questionnaireType = $questionnaireRow['questionnaireType'];
                $this->available = $questionnaireRow['available'];
                $this->deadline = $questionnaireRow['deadline'];
            }
            else
            {
                throw new Exception('Questionnaire wasnt found.');
            }

            if ($questionsRequestResult = PDOHelper::getInstance()->query("SELECT questionID FROM Questions WHERE questionnaireID=".$questionnaireID))
            {
                while($currentQuestionsRow = $questionsRequestResult->fetch(PDO::FETCH_ASSOC))
                {
                    $questionID = $currentQuestionsRow['questionID'];
                    $this->questions[] = Question::getQuestionByID($questionID);
                }
            }
            else
            {
                throw new Exception("Questions for current questionnaire weren't found.");
            }
        } else {
            $type = QuestionnaireTypeManager::getInstance()->getTPID();
            PDOHelper::getInstance()->exec("INSERT INTO `Questionnaire`(`questionnaireType`, `deadline`, `available`) VALUES(".$type.", STR_TO_DATE('01/01/1970', '%m/%d/%Y'), STR_TO_DATE('01/01/1970', '%m/%d/%Y'))");
            $this->questionnaireID = PDOHelper::getInstance()->lastInsertID();
        }
    }

    /* Getters & Setters */
    public function getID()
    {
        return $this->questionnaireID;
    }

    public function getType(){
        $this->questionnaireType;
    }

    public function setType($type)
    {
        $this->questionnaireType = $type;
        PDOHelper::getInstance()->query("UPDATE `Questions` SET `questionnaireType`=".$type.", WHERE `questionnaireID`=".$this->questionnaireID);
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
        $question->writeToDBForQuestionnaireID($this->questionnaireID);
    }

    public function setQuestions($questions)
    {
        $this->questions = $questions;
        if (!is_null($this->questions)) {
            foreach ($this->questions as $question) {
                $question->writeToDBForQuestionnaireID($this->questionnaireID);
            }    
        }
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
        PDOHelper::getInstance()->query("UPDATE `Questions` SET `deadline`=STR_TO_DATE('".$deadline."', '%m/%d/%Y'), WHERE `questionnaireID`=".$this->questionnaireID);
    }

    public function getAvailableDate()
    {
        return $this->available;
    }

    public function setAvailableDate($available)
    {
        $this->available = $available;
        PDOHelper::getInstance()->query("UPDATE `Questions` SET `available`=STR_TO_DATE('".$available."', '%m/%d/%Y'), WHERE `questionnaireID`=".$this->questionnaireID);
    }

    public function delete(){
        PDOHelper::getInstance()->query("DELETE FROM `Questions` WHERE `questionnaireID`=".$this->questionnaireID);
    }
}