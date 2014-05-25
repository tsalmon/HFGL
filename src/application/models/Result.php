<?php
require_once("PDOHelper.php");

class Result {
    public function saveAttempt($studentID, $questionnaireID){
        $attemptsRemain = attemptsRemain($studentID, $questionnaireID);

        $points = 0;
        $pointsRequest = "SELECT * FROM Points WHERE studentID=".$studentID." AND questionnaireID=".$questionnaireID;

        if ($pointsRequestResult = PDOHelper::getInstance()->query($pointsRequest))
        {
            while($currentPointsRow = $questionsRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $points += $currentPointsRow['note'];
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

    public function attemptsRemain($studentID, $questionnaireID){
        $request = "SELECT * FROM Result WHERE questionnaireID=".$questionnaireIDstionID."AND studentID=".$studentID;

        if($questionRequestResult = PDOHelper::getInstance()->query($request)){
            $currentQuestionRow = $questionRequestResult->fetch(PDO::FETCH_ASSOC);
            return $currentQuestionRow['attemptsRemain'];
        } else {
            return -1;
        }
    }
} 