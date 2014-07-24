<?php
require_once("Corrector.php");
require_once("PDOHelper.php");

class AutomaticCorrector implements Corrector{

    public function correctQuestion($questionID, $studentID,$note=0, $response="NULL"){
      $answered = "SELECT * FROM `Points` WHERE studentID=".$studentID." AND questionID=".$questionID;
      $check = PDOHelper::getInstance()->query($answered);

      if ($check->rowCount() == 0) {
          $request = "INSERT INTO `Points`(`studentID`, `questionID`, `note`, `response`, validated) VALUES (".$studentID.",".$questionID.", '".$note."', '".$response."', 1)";
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

    public function saveResponseToCorrect($questionID, $studentID, $response){
        
        $db=PDOHelper::getInstance();
        $answered = "SELECT * FROM `Points` WHERE studentID=".$studentID." AND questionID=".$questionID;
        $check = $db->query($answered);
        
        $query="SELECT Question.typeID FROM Question WHERE Question.questionID =".$_GET["questionID"];
        $res=$db->query($query);

        $fetch=$res->fetch(PDO::FETCH_ASSOC);
        $roleID=$fetch["typeID"];
        if ($roleID==QuestionTypeManager::getInstance()->getLSID()){
                $query="SELECT studentID FROM (SELECT * FROM Student JOIN StudentEstimation AS se ON Student.studentID=se.estimatingStudentID) as test WHERE questionID=".$questionID;
                $res=$db->query($query);
                if ($res->rowCount()!=0){
                    $fetch=$res->fetchAll(PDO::FETCH_COLUMN, "studentID");
                    $students=$fetch;
                }
                else{
                    $students=[];
                }
                $query_course="SELECT DISTINCT Course.courseID FROM (
                    SELECT t5.questionnaireID, courseID FROM (
                    SELECT Part.partID, t4.questionnaireID FROM (
                    SELECT Chapters.partID, t3.questionnaireID FROM (
                    SELECT chapterID, t2.questionnaireID From (
                    SELECT table1.questionnaireID FROM (
                    SELECT questionnaireID FROM Questions WHERE questionID =".$questionID.") as table1 
                    JOIN Questionnaire ON table1.questionnaireID=Questionnaire.questionnaireID) as t2 
                    JOIN Chapter ON Chapter.questionnaireID=t2.questionnaireID) as t3 
                    JOIN Chapters on Chapters.chapterID=t3.chapterID) as t4 
                    JOIN Part ON Part.partID=t4.partID or Part.questionnaireID=t4.questionnaireID) as t5 
                    JOIN Parts on Parts.partID= t5.partID)as t6 JOIN 
                    Course on Course.questionnaireID=t6.questionnaireID or Course.courseID=t6.courseID";
                $resCourse=$db->query($query_course);
                $fetch=$resCourse->fetch(PDO::FETCH_ASSOC);
                $course=  CourseFactory::getCourse($fetch["courseID"], true);
                $courseStudentsID=[];
                foreach($course->getStudents() as $student){
                    $courseStudentsID[]=$student->studentID();
                }
                $freeStudents=array_diff($courseStudentsID,$students);
                if(count($courseStudentsID)!=1){
                    if($freeStudents==[] or (count($freeStudents)==1 and $freeStudents[0]==$studentID)){
                        do {
                            $num=rand(0,count($students));
                        }
                        while ($students[$num]==$studentID);
                        $corrector_ID=$students[$num];
                    }
                    else{
                        do {
                            $num=rand(0,count($freeStudents));
                        }
                        while ($freeStudents[$num]==$studentID);
                        $corrector_ID=$freeStudents[$num];
                    }                
                    $db->exec("INSERT INTO StudentEstimation (estimatingStudentID, estimatedStudentID, questionID) VALUES(".$corrector_ID.",".$studentID.",".$questionID.")");
    //                throw new Exception("INSERT INTO StudentEstimation (estimatingStudentID, estimatedStudentID, questionID) VALUES(".$corrector_ID.",".$studentID.",".$questionID.")");
                    $validated=3;
                }
                else {
                    $validated=2;
                }
        }    
        else{
           $validated=2;
        }
        
        
        if ($check->rowCount() == 0) {
          $request = "INSERT INTO `Points`(`studentID`, `questionID`, `response`, `validated`) VALUES (".$studentID.",".$questionID.", '".$response."', ".$validated.")";
          $res = $db->exec($request);
          if ($res == 0) {
            echo $request;
            throw new Exception("Correction error: The result wasn't saved to database");
          }
        } else {
          $request = "UPDATE `Points` SET `validated`=".$validated.", `response`='".$response."' WHERE studentID=".$studentID." AND questionID=".$questionID;
          $res = $db->exec($request);
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
	