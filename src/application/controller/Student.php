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
        require 'application/views/_templates/header.php';
        echo "voir les parametres";
        require 'application/views/_templates/footer.php';    	
    }

    public function ViewNotes()
    {
        require 'application/views/_templates/header.php';
        echo "voir les notes";
        require 'application/views/_templates/footer.php';
    }
}
