<?php
require_once("QuestionnaireTypeManager.php");

abstract class Questionnaire {
    protected $questionnaireID;
    protected $type;
    protected $deadline;
    protected $available;
    protected $description;

    public function __construct($type, $deadline, $available, $description)
    {
        $this->type = $type;
        $this->deadline = $deadline;
        $this->available = $available;
        $this->description = $description;
    }

    function __destruct() {
    }

    /* Getters & Setters */

    public function type(){
        return $this->type;
    }

    public function deadline(){
        return $this->deadline;
    }

    public function available(){
        return $this->available;
    }

    public function questionnaireID(){
        return $this->questionnaireID;
    }

    public function description(){
        return $this->description;
    }

    /* Abstract methods */

    /* Initialize question by ID. Returns object of one of derived classes. The choice of class depends on question's typeID. */
    
}
