<?php

class Test {
    private $input;
    private $output;

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
        echo "INSERT INTO `Test`(`questionID`, `input`, `output`) (".$questionID.",'".$this->output."',".$this->input.")<br>";
        PDOHelper::getInstance()->exec("INSERT INTO `Test`(`questionID`, `input`, `output`) (".$questionID.",'".$this->input."',".$this->output.")");
        return PDOHelper::getInstance()->lastInsertID();
    }
} 