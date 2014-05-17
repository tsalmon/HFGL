<?php

class Resource {
    private $questionID;
    private $type;
    private $content;

    public function getQuestionID(){
        return $this->questionID;
    }

    public function getType(){
        return $this->type;
    }

    public function getContent(){
        return $this->content;
    }

    public function __construct($type,$content)
    {
        $this->content = $content;
        $this->type = $type;
    }

    function __destruct() {
        unset($this->content);
    }

    public function writeToDBForQuestionID($questionID){
        if (is_null($this->questionID)) {
            $this->questionID = $questionID;
            // echo "INSERT INTO `Resource`(`questionID`, `content`, `type`) VALUES (".$this->questionID.",'".$this->content."','".($this->type)."')<br>";
            PDOHelper::getInstance()->exec("INSERT INTO `Resource`(`questionID`, `content`, `type`) VALUES (".$this->questionID.",'".$this->content."','".($this->type)."')");
        }

        return $this->questionID;
    }
} 