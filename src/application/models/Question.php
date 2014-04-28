<?php
require_once("Answer.php");
require_once("QuestionTypeManager.php");

abstract class Question {
    protected $assignment;
    protected $tip;
    protected $points;
    protected $questionID;

    public function __construct($assignment, $tip, $points)
    {
        $this->assignment = $assignment;
        $this->tip = $tip;
        $this->points = $points;
    }

    function __destruct() {
    }

    /* Getters & Setters */

    public function getAssignment(){
        return $this->assignment;
    }

    public function getPoints(){
        return $this->points;
    }

    public function getTip(){
        return $this->tip;
    }

    public function getID(){
        return $this->questionID;
    }

    /* Abstract methods */
    abstract protected  function writeToDB();
    abstract protected  function loadByID($questionID);

    /* Initialize question by ID. Returns object of one of derived classes. The choice of class depends on question's typeID. */
    public static function getQuestionByID($questionID){
        if($questionRequestResult = PDOHelper::getInstance()->query("SELECT * FROM Question WHERE questionID=".$questionID))
        {
            if($currentQuestionRow = $questionRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $typeID =  $currentQuestionRow['typeID'];
                //echo $typeID;
                $assignment = $currentQuestionRow['assignment'];
                //echo $assignment;
                $tip = $currentQuestionRow['tip'];
                //echo $tip;
                $points = $currentQuestionRow['points'];
                //echo $points;
                //echo "QCM:".QuestionTypeManager::getInstance()->getQcmID();
                //echo "QRF:".QuestionTypeManager::getInstance()->getQrfID();
                //echo "P:".QuestionTypeManager::getInstance()->getPID();
                //echo "L:".QuestionTypeManager::getInstance()->getLID();

                if($typeID == QuestionTypeManager::getInstance()->getQcmID()){
                    $question = new QCMQuestion($assignment, $tip, $points);
                }

                if($typeID == QuestionTypeManager::getInstance()->getQrfID()){
                    $question = new QRFQuestion($assignment, $tip, $points);
                }

                if($typeID == QuestionTypeManager::getInstance()->getLID()){
                    $question = new LQuestion($assignment, $tip, $points);
                }

                if($typeID == QuestionTypeManager::getInstance()->getPID()){

                }

                $question->loadByID($questionID);

                return $question;
            } else {
                throw new Exception("Question with ID=".$questionID." wasnt found");
            }
        }
    }

    /* Store question in DB as a question of questionnaire with $questionnaireID. */
    public function writeToDBForQuestionnaireID($questionnaireID){
        $questionID = $this->writeToDB();
        echo "INSERT INTO `Questions`(`questionnaireID`, `questionID`) VALUES (".$questionnaireID.",".$questionID.")<br>";
        PDOHelper::getInstance()->exec("INSERT INTO `Questions`(`questionnaireID`, `questionID`) VALUES (".$questionnaireID.",".$questionID.")");
    }
}
