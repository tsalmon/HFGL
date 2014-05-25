<?php
require_once("Corrector.php");
require_once("PDOHelper.php");

class AutomaticCorrector implements Corrector{
    public function correctQuestion($questionID, $corrected_student_ID,$note=0, $response="NULL"){
    	$request = "INSERT INTO `Points`(`studentID`, `questionID`, `note`, `response`) VALUES (".$corrected_student_ID.",".$questionID.", '".$note."', '".$response."')";
      $res = PDOHelper::getInstance()->exec($request);
      if ($res == 0) {
        echo $request;
        throw new Exception("Erreur de correction: resultat n'a pas été écrit dans la base de données");
      }
    }

    public function saveResponseToCorrect($questionID, $studentID, $response, $validated){
        $request = "INSERT INTO `Points`(`studentID`, `questionID`, `response`, `validated`) VALUES (".$studentID.",".$questionID.", '".$response."', '".$validated."')";
        $res = PDOHelper::getInstance()->exec($request);
        if ($res == 0) {
          echo $request;
          throw new Exception("Erreur de correction: response n'a pas été écrit dans la base de données");
        }
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
	