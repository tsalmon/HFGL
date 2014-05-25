<?php
require_once("application/models/Question.php");
require_once("application/models/QuestionTypeManager.php");

class PRQuestion extends Question{
    public function __construct($assignment, $tip, $points)
    {
        parent::__construct($assignment, $tip, $points);
    }

    public function loadByID($questionID)
    {
        $this->questionID = $questionID;
    }

    /* Store question in DB. Returns questionID. */

    public function writeToDB(){
        if (is_null($this->questionID)) {
            PDOHelper::getInstance()->exec("INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".QuestionTypeManager::getInstance()->getPRID().")");
            $this->questionID = PDOHelper::getInstance()->lastInsertID();
        }

        return $this->questionID;
    }
    
} 