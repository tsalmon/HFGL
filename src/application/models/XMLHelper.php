<?php
require_once("application/models/Question.php");
require_once("application/models/QCMAnswer.php");
require_once("application/models/QRFAnswer.php");
require_once("application/models/LAnswer.php");
require_once("application/models/PDOHelper.php");


class XMLHelper {

    //Parses XML file. Returns ExerciseSheet.
    public static function parseXML(){
        $questions = simplexml_load_file("application/models/exo.xml");
        $type = $questions->attributes()['type'];
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
        $oquestions = array();

        echo "Exercise type:".$type."(".$typeNumber.")<br>";
        foreach ($questions->question as $question) {
            $oanswers = array();

            foreach ($question->answers->answer as $ans){
                $correct = $ans['good']=="true"?true:false;
                switch($typeNumber){
                    case QCM:
                    {
                        $answer = new QCMAnswer($correct, $ans->text);
                    }
                    break;

                    case QRF:
                    {
                        $answer = new QRFAnswer($correct, $ans->text);
                    }
                    break;
                }
                $oanswers[] = $answer;
              }

            $oq = new Question($typeNumber, $question->text, $oanswers, 2);
            $oquestions[] = $oq;
        }

        $nExercise = new ExerciseSheet();
        $nExercise->setQuestions($oquestions);
        $nExercise->setAvailableDate(time());
        $nExercise->setDeadline(time());
        $nExercise->setQuestionnaireType(Examen);

        return $nExercise;
    }
} 