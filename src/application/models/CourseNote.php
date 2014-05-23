<?php
require_once("application/models/Document.php");

class CourseNote extends Document{
    private $URL;
    private $title;
    private $description;

    //      Constructeur
    //**************************
    
    public function __construct($url){  
        $this->URL = $url;
    } 

    public function setURL($url){
    	$this->URL = $url;
    }

    public function getURL()
    {
        return $this->URL;
    }

    public function setTitle($title){
    	$this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description){
    	$this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }



} 