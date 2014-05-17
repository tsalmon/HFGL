<?php

class Test {
    private $input;
    private $output;
    private $questionID;

    public function getQuestionID(){
        return $this->questionID;
    }

    public function getOutput(){
        return $this->output;
    }

    public function getInput(){
        return $this->input;
    }

    public function __construct($input,$output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    function __destruct() {
    }

    public function writeToDBForQuestionID($questionID){
        if (is_null($this->questionID)) {
            $this->questionID = $questionID;
            // echo "INSERT INTO `Test`(`questionID`, `input`, `output`) VALUES (".$this->questionID.",'".$this->output."','".$this->input."')<br>";
            PDOHelper::getInstance()->exec("INSERT INTO `Test`(`questionID`, `input`, `output`) VALUES (".$this->questionID.",'".$this->input."','".$this->output."')");
        }

        return $this->questionID;
    }
} 