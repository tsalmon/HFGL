<?php

class Student extends Controller{
    public function index()
    {
    	$page = "student";
        require 'application/views/_templates/header.php';
        require 'application/views/etudiant.php';
        require 'application/views/_templates/footer.php';
    }

    public function Parameters()
    {
    	
    }
    public function ViewNotes()
    {
    	
    }
}
