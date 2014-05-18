<?php

class Answer {
    private $isCorrect;
    private $content;

    public function isCorrect(){
        return $this->isCorrect;
    }

    public function getContent(){
        return $this->content;
    }

    public function __construct($content, $isCorrect)
    {
        $this->content = $content;
        $this->isCorrect = $isCorrect;
    }

    function __destruct() {
        unset($this->content);
    }

    public function writeToDBForQuestionID($questionID){
        //echo "INSERT INTO `Response`(`questionID`, `content`, `correct`) (".$questionID.",'".$this->content."',".($this->isCorrect?1:0).")<br>";
        PDOHelper::getInstance()->exec("INSERT INTO `Response`(`questionID`, `content`, `correct`) VALUES (".$questionID.",'".$this->content."',".($this->isCorrect?1:0).")");
        return PDOHelper::getInstance()->lastInsertID();
    }
} 