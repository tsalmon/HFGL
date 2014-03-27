<?php
require_once("Answer.php");

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

    public function getAssignment(){
        return $this->assignment;
    }

    public function getPoints(){
        return $this->points;
    }

    public function getTip(){
        return $this->tip;
    }

    abstract protected  function writeToDB();
    abstract protected  function loadByID($questionID);

    public static function getQuestionByID($questionID){
        if($questionRequestResult = PDOHelper::getInstance()->query("SELECT * FROM Question WHERE questionID=".$questionID))
        {
            if($currentQuestionRow = $questionRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $typeID =  $currentQuestionRow['typeID'];
                $assignment = $currentQuestionRow['assignment'];
                $tip = $currentQuestionRow['tip'];
                $points = $currentQuestionRow['points'];

                if($typeID == QCM){
                    $question = new QCMQuestion($assignment, $tip, $points);
                }

                if($typeID == QRF){
                    $question = new QRFQuestion($assignment, $tip, $points);
                }

                if($typeID == L){
                    $question = new LQuestion($assignment, $tip, $points);
                }

                if($typeID == P){

                }

                $question->loadByID($questionID);

                return $question;
            } else {
                throw new Exception("Question with ID=".$questionID." wasnt found");
            }
        }
    }

    public function writeToDBForQuestionnaireID($questionnaireID){
        $questionID = $this->writeToDB();
        echo "INSERT INTO `Questions`(`questionnaireID`, `questionID`) VALUES (".$questionnaireID.",".$questionID.")<br>";
        PDOHelper::getInstance()->exec("INSERT INTO `Questions`(`questionnaireID`, `questionID`) VALUES (".$questionnaireID.",".$questionID.")");
    }
}
