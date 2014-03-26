<?php
require_once("application/models/Question.php");
require_once("application/models/QCMAnswer.php");
require_once("application/models/QRFAnswer.php");
require_once("application/models/LAnswer.php");
require_once("application/models/PDOHelper.php");


class XMLHelper {
    public static function parseXML(){
        $questions = simplexml_load_file("application/models/exo.xml");
        $type = $questions->attributes()['type'];
        $typeNumber = 0;
        if($type == "qcm"){
            $typeNumber = QCM;
        } else
            if($type == "qrf"){
                $typeNumber = QRF;
            } else
                if($type == "p"){
                    $typeNumber = P;
                }else
                    if($type == "l"){
                        $typeNumber = L;
                    } else {
                        throw new Exception('Unknown questionnaire type.');
                    }

        echo "Exercise type:".$type."(".$typeNumber.")<br>";
        foreach ($questions->question as $question) {
            echo "INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$question->text."',2,".$typeNumber.")<br>";
            PDOHelper::getInstance()->exec("INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$question->text."',2,".$typeNumber.")");
            $questionID = PDOHelper::getInstance()->lastInsertID();
            echo "QuestionID:".$questionID."<br>";

            if($typeNumber == L)
                return;

            foreach ($question->answers->answer as $ans){
                $correct = $ans['good']=="true"?1:0;
                echo "INSERT INTO `Responses`(`questionID`, `content`, `correct`) (".$questionID.",".$ans->text.",".$correct.")<br>";
                PDOHelper::getInstance()->exec("INSERT INTO `Responses`(`questionID`, `content`, `correct`) VALUES (".$questionID.",'".$ans->text."',".$correct.")");
            }
            return;
        }
    }
} 