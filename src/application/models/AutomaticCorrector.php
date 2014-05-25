<?php
require_once("Corrector.php");
require_once("PDOHelper.php");

class AutomaticCorrector implements Corrector{

    public function correctQuestion($questionID, $studentID,$note=0, $response="NULL"){
      $answered = "SELECT * FROM `Points` WHERE studentID=".$studentID." AND questionID=".$questionID;
      $check = PDOHelper::getInstance()->query($answered);

      if ($check->rowCount() == 0) {
          $request = "INSERT INTO `Points`(`studentID`, `questionID`, `note`, `response`) VALUES (".$studentID.",".$questionID.", '".$note."', '".$response."')";
          $res = PDOHelper::getInstance()->exec($request);
          if ($res == 0) {
            echo $request;
            throw new Exception("Correction error: The result wasn't saved to database");
          }
      } else {
        $request = "UPDATE `Points` SET `note`=".$note.", `response`='".$response."' WHERE studentID=".$studentID." AND questionID=".$questionID;
        $res = PDOHelper::getInstance()->exec($request);
        if ($res == 0) {
          //echo $request;
        }
      }

    }

    public function saveResponseToCorrect($questionID, $studentID, $response, $validated){
        $answered = "SELECT * FROM `Points` WHERE studentID=".$studentID." AND questionID=".$questionID;
        $check = PDOHelper::getInstance()->query($answered);

        if ($check->rowCount() == 0) {
          $request = "INSERT INTO `Points`(`studentID`, `questionID`, `response`, `validated`) VALUES (".$studentID.",".$questionID.", '".$response."', ".$validated.")";
          $res = PDOHelper::getInstance()->exec($request);
          if ($res == 0) {
            echo $request;
            throw new Exception("Correction error: The result wasn't saved to database");
          }
        } else {
          $request = "UPDATE `Points` SET `validated`=".$validated.", `response`='".$response."' WHERE studentID=".$studentID." AND questionID=".$questionID;
          $res = PDOHelper::getInstance()->exec($request);
          if ($res == 0) {
            //echo $request;
          }
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


    public static function saveAttempt($studentID, $questionnaireID){
        $attemptsRemain = self::attemptsRemain($studentID, $questionnaireID);
        //echo $attemptsRemain;

        $questionsRequest = "SELECT * FROM Questions WHERE questionnaireID=".$questionnaireID;

        if ($questionsRequestResult = PDOHelper::getInstance()->query($questionsRequest))
        {
            while($currentQuestionsRow = $questionsRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $questions[] = $currentQuestionsRow['questionID'];
            }
        }

        $points = 0;
        $pointsRequest = "SELECT * FROM Points WHERE studentID=".$studentID;

        if ($pointsRequestResult = PDOHelper::getInstance()->query($pointsRequest))
        {
            while($currentPointsRow = $pointsRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                if (in_array($currentPointsRow['questionID'], $questions)) {
                    $points += $currentPointsRow['note'];
                }
            }
        }

        if ($attemptsRemain == 0) {
            return;
        } else
        if ($attemptsRemain == -1) {
            $request = "INSERT INTO `Result`(`studentID`, `questionnaireID`, `lastPoints`, `attemptsRemain`, `lastAttemptDate`) VALUES (".$studentID.", ".$questionnaireID.", ".$points.",2, NOW() )";
        } else {
            $request = "UPDATE `Result` SET `lastPoints` = ".$points.", `attemptsRemain` = ".($attemptsRemain-1).", `lastAttemptDate` = NOW() WHERE questionnaireID=".$questionnaireID." AND studentID=".$studentID;
        }

        $ret = PDOHelper::getInstance()->exec($request);
        if ($ret == 0) {
            throw new Exception("Error : Questionnaire result wasn't written to the database");
        }
    }

    public static function attemptsRemain($studentID, $questionnaireID){
        $request = "SELECT * FROM Result WHERE questionnaireID=".$questionnaireID." AND studentID=".$studentID;
        $questionRequestResult = PDOHelper::getInstance()->query($request);

        if($questionRequestResult){
            $currentQuestionRow = $questionRequestResult->fetch(PDO::FETCH_ASSOC);
            if (is_null($currentQuestionRow['attemptsRemain'])) {
              return -1;
            } else {
              return $currentQuestionRow['attemptsRemain'];
            }
        } else {
            return -1;
        }
    }
}
	