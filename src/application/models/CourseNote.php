<?php
require_once("application/models/Document.php");

class CourseNote extends Document{
    private $URL;


    public function getURL()
    {
        return $this->URL;
    }
} 