<?php
require_once("application/libs/controller.php");
require_once("application/models/Question.php");
require_once("application/models/QCMAnswer.php");
require_once("application/models/QRFAnswer.php");
require_once("application/models/LAnswer.php");

define('QCM',1);
define('QRF',2);
define('P',3);
define('L',4);

class ExerciseSheet extends Controller{

    private $mysqli;

    public function connectdDB(){
        $this->mysqli = new mysqli("localhost", "root", "root", "hfgl");
        if ($this->mysqli->connect_errno) {
            printf("Couldn't connect to DB: %s\n", $this->mysqli->connect_error);
            exit();
        }
    }

    public function parseXML(){
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
            echo "INSERT INTO `Question`(`assignment`, `points`, `typeID`) (".$question->text.",2,".$typeNumber.")<br>";
            //$this->mysqli->query("INSERT INTO `Question`(`assignment`, `points`, `typeID`) (".$question->text.",2,".$typeNumber.")");
            if($typeNumber == L)
                return;

            $questionIDS = $this->mysqli->query("SELECT questionID FROM Question WHERE assignment='".$question->text."'");
            $questionID = 0;
            while($qid = $questionIDS->fetch_array()){
                echo "QuestionID:".$qid['questionID']."<br>";
                $questionID = $qid['questionID'];
            }
            echo '<br>';

            foreach ($question->answers->answer as $ans){
                $correct = $ans['good']=="true"?1:0;
                echo "INSERT INTO `Responses`(`questionID`, `content`, `correct`) (".$questionID.",".$ans->text.",".$correct.")<br>";
                //$this->mysqli->query("INSERT INTO `Responses`(`questionID`, `content`, `correct`) (".$questionID.",".$ans->text.",".$correct.")");
            }
        }
    }


    public function showExerciseWithQuestionnaireID($questionnaireID){
        $questions = array();
        //getting questionnaire object from DB
        if ($questionsRequestResult = $this->mysqli->query("SELECT questionID FROM Questions WHERE questionnaireID=".$questionnaireID))
        {
            //enumertaion of questions of current questionnaire
            while($currentQuestionsRow = $questionsRequestResult->fetch_array())
            {
                $currentQuestionID = $currentQuestionsRow['questionID'];
                //getting question objects from DB
                if($questionRequestResult = $this->mysqli->query("SELECT * FROM Question WHERE questionID=".$currentQuestionID))
                {
                    //question processing
                    while($currentQuestionRow = $questionRequestResult->fetch_array())
                    {
                        $currentQuestionAssignment = $currentQuestionRow['assignment'];
                        $currentQuestionTypeID = $currentQuestionRow['typeID'];
                        $currentQuestionPoints = $currentQuestionRow['points'];

                        //Getting answers for current question
                        $answerObjects = array();
                        if($answersRequestResult = $this->mysqli->query("SELECT * FROM Responses WHERE questionID=".$currentQuestionID))
                        {
                            //enumeration of answers
                            while($currentAnswerRow = $answersRequestResult->fetch_array())
                            {
                                switch($currentQuestionTypeID)
                                {
                                    case QCM:
                                    {
                                        $answerObjects[] = new QCMAnswer((bool)$currentAnswerRow['correct'], $currentAnswerRow['content']);
                                    }
                                        break;

                                    case QRF:
                                    {
                                        $answerObjects[] = new QRFAnswer((bool)$currentAnswerRow['correct'], $currentAnswerRow['content']);
                                    }
                                        break;
                                }
                            }
                        }

                        $questions[] = new Question($currentQuestionAssignment, $answerObjects, $currentQuestionPoints);
                    }
                }
                else
                {
                    throw new Exception('Questions for current questionnaire werent found.');
                }
            }
        }
        else
        {
            throw new Exception('Questionnaire wasnt found.');
        }

        foreach($questions as $question) {
            echo $question->getAssignment().'<br/>';
                echo '<form action="">';
                $curanswers = $question->getAnswers();
                foreach($curanswers as $answer) {
                    if($answer instanceof QCMAnswer)
                    {
                        echo '<input type="checkbox" name="checkboxanswer" value="val">'.$answer->getContent().'<br>';
                    } else
                    if($answer instanceof QCMAnswer || $answer instanceof QRFAnswer)
                    {
                        echo '<input type="text" name="textanswer" placeholder="Your answer...">';
                    }
                }
                echo '</form>';
                echo '<br/>';
         }

    }



}