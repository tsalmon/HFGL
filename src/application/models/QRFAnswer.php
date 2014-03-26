<?php
require_once("Answer.php");

class QRFAnswer extends Answer{
    private $content;

    public function getContent(){
        return $this->content;
    }

    public function __construct($isCorrect, $content)
    {
        parent::__construct($isCorrect);
        $this->content = $content;
    }

    function __destruct() {
        unset($this->content);
    }
} 