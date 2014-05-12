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
        echo "INSERT INTO `Resource`(`questionID`, `content`, `type`) (".$questionID.",'".$this->content."',".($this->type).")<br>";
        PDOHelper::getInstance()->exec("INSERT INTO `Responses`(`questionID`, `content`, `type`) VALUES (".$questionID.",'".$this->content."',".($this->type).")");
        return PDOHelper::getInstance()->lastInsertID();
    }

    //public static function fileNameForQuestionID($)
} 