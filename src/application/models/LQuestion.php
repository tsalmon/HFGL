<?php
require_once("application/models/Question.php");
require_once("application/models/QuestionTypeManager.php");

class LQuestion extends Question{
    protected $corrige_par_etudiants;
    public function __construct($assignment, $tip, $points,$corrige_par_etudiants=false)
    {
        parent::__construct($assignment, $tip, $points);
        $this->corrige_par_etudiants=$corrige_par_etudiants;
    }

    public function loadByID($questionID)
    {
        $this->questionID = $questionID;
    }

    /* Store question in DB. Returns questionID. */

    public function writeToDB(){
        if (is_null($this->questionID)) {
            //echo "INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".QuestionTypeManager::getInstance()->getLID().")<br>";
            if(!$this->corrige_par_etudiants){
                $type_question=QuestionTypeManager::getInstance()->getLID();
            }else{
                $type_question=QuestionTypeManager::getInstance()->getLSID();
            }
            PDOHelper::getInstance()->exec("INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".$type_question.")");
            $this->questionID = PDOHelper::getInstance()->lastInsertID();
            //echo "Inserted questionID:".$this->questionID."<br>";
        }

        return $this->questionID;
    }
    
} 