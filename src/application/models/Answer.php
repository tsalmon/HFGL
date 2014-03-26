<?php

class Answer {
    private $isCorrect;

    public function isCorrect(){
        return $this->isCorrect();
    }

    public function __construct($isCorrect)
    {
        $this->isCorrect = $isCorrect;
    }
} 