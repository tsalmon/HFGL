<?php
require_once("application/models/QCMQuestion.php");
require_once("application/models/QRFQuestion.php");
require_once("application/models/LQuestion.php");
require_once("application/models/PQuestion.php");

require_once("application/models/PDOHelper.php");


class XMLHelper {

    //Parses XML file. Returns ExerciseSheet.
    public static function parseXML(){
        $questions = simplexml_load_file("application/models/exo.xml");
        $type = $questions->attributes()['type'];

        $oquestions = array();

        echo "Exercise type:".$type."<br>";
        foreach ($questions->question as $question) {
            $oanswers = array();

            foreach ($question->answers->answer as $ans)
            {
                $correct = $ans['good']=="true"?true:false;
                $answer = new Answer($ans->text, $correct);
                $oanswers[] = $answer;
            }

            if($type == "qcm"){
                $oq = new QCMQuestion($question->text, $question->tip, 2);
                $oq->setAnswers($oanswers);
            }
            else if($type == "qrf")
            {
                $oq = new QRFQuestion($question->text, $question->tip, 2);
                $oq->setAnswers($oanswers);
            }
            else if($type == "p"){

            }
            else if($type == "l")
            {
                $oq = new LQuestion($question->text, $question->tip, 2);
            }
            else
            {
                throw new Exception('Unknown questionnaire type.');
            }

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