<?php
require_once("application/models/Question.php");

class QRFQuestion extends Question
{
    private $answers;

    public function __construct($assignment, $tip, $points)
    {
        parent::__construct($assignment, $tip, $points);
    }

    function __destruct() {
        unset($this->answers);
    }

    /* Getters & Setters */

    public function getAnswers()
    {
        return $this->answers;
    }

    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    public function addAnswer($answer)
    {
        $this->answers[] = $answer;
    }

    public function loadByID($questionID)
    {
        $this->questionID = $questionID;
        if($answersRequestResult = PDOHelper::getInstance()->query("SELECT * FROM Responses WHERE questionID=".$questionID))
        {
            //enumeration of answers
            while($currentAnswerRow = $answersRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $this->answers[] = new Answer($currentAnswerRow['content'], (bool)$currentAnswerRow['correct']);
            }
        }
    }

    /* Store question in DB. Returns questionID. */

    public function writeToDB(){
        echo "INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".QRF.")<br>";
        PDOHelper::getInstance()->exec("INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".QRF.")");
        $this->questionID = PDOHelper::getInstance()->lastInsertID();
        echo "Inserted questionID:".$this->questionID."<br>";

        foreach ($this->answers as $answer)
        {
            $answer->writeToDBForQuestionID($this->questionID);
        }


        return $this->questionID;
    }
} 