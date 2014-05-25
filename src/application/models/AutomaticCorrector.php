<?php
require_once("Corrector.php");
require_once("PDOHelper.php");

class AutomaticCorrector implements Corrector{
    public function correctQuestion($questionID, $corrected_student_ID,$note=0){
    	PDOHelper::getInstance()->exec("INSERT INTO `Points`(`studentID`, `questionID`, `note`) VALUES (".$corrected_student_ID.",".$questionID.", '".$note."')");
    }

  	public function hasAnswerForQuestion($questionID, $studentID){
  		$row = PDOHelper::getInstance()->query("SELECT * FROM `Points` WHERE `studentID`=".$studentID." AND `questionID`=".$questionID);
  		if($row->fetchColumn() > 0){
  			return True;
  		} else {
  			return False;
  		}
  	}

    public function getQuestionsToCorrect(){

    }
}
	