<?php
require_once("application/libs/controller.php");
require_once("application/models/Question.php");
require_once("application/models/QCMAnswer.php");
require_once("application/models/QRFAnswer.php");
require_once("application/models/LAnswer.php");
require_once("application/models/PDOHelper.php");

define('QCM',1);
define('QRF',2);
define('P',3);
define('L',4);

class ExerciseSheet{

    private $mysqli;
    private $questions;
    private $db;

    public function __construct($questionnaireID)
    {
        $this->db = PDOHelper::getInstance();
        $this->fetchQuestionsForQuestionnaireID($questionnaireID);
    }

    public function show(){
        foreach($this->questions as $question) {
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

    public function getQuestions()
    {
        return $this->questions;
    }

    private function fetchQuestionsForQuestionnaireID($questionnaireID){
        $questions = array();
        //getting questionnaire object from DB
        if ($questionsRequestResult = $this->db->query("SELECT questionID FROM Questions WHERE questionnaireID=".$questionnaireID))
        {
            //enumertaion of questions of current questionnaire
            while($currentQuestionsRow = $questionsRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $currentQuestionID = $currentQuestionsRow['questionID'];
                //getting question objects from DB
                if($questionRequestResult = $this->db->query("SELECT * FROM Question WHERE questionID=".$currentQuestionID))
                {
                    //question processing
                    while($currentQuestionRow = $questionRequestResult->fetch(PDO::FETCH_ASSOC))
                    {
                        $currentQuestionAssignment = $currentQuestionRow['assignment'];
                        $currentQuestionTypeID = $currentQuestionRow['typeID'];
                        $currentQuestionPoints = $currentQuestionRow['points'];

                        //Getting answers for current question
                        $answerObjects = array();
                        if($answersRequestResult = $this->db->query("SELECT * FROM Responses WHERE questionID=".$currentQuestionID))
                        {
                            //enumeration of answers
                            while($currentAnswerRow = $answersRequestResult->fetch(PDO::FETCH_ASSOC))
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

                        $this->questions[] = new Question($currentQuestionAssignment, $answerObjects, $currentQuestionPoints);
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
        return $questions;
    }
}