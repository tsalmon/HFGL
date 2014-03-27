<?php
require_once("Answer.php");

class Question {
    private $assignment;
    private $answers;
    private $points;
    private $type;

    public function __construct($type, $assignment, $answers, $points)
    {
        $this->type = $type;
        $this->assignment = $assignment;
        $this->answers = $answers;
        $this->points = $points;
    }

    function __destruct() {
        unset($this->assignment);
        unset($this->answers);
    }

    public function getAssignment(){
        return $this->assignment;
    }

    public function getPoints(){
        return $this->points;
    }

    public function getAnswers(){
        return $this->answers;
    }

    public function getType(){
        return $this->type;
    }
}
