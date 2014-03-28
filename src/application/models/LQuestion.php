<?php
require_once("application/models/Question.php");

class LQuestion extends Question{
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
        echo "INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".L.")<br>";
        PDOHelper::getInstance()->exec("INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".L.")");
        $this->questionID = PDOHelper::getInstance()->lastInsertID();
        echo "Inserted questionID:".$this->questionID."<br>";
        return $this->questionID;
    }
} 