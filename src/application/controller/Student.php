<?php

class Student extends Controller{
    public function index() //consulter cours
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

    public function Notes()
    {
        require 'application/views/_templates/header.php';
        echo "voir les notes";
        require 'application/views/_templates/footer.php';
    }

    public function InscrireCours(){
        require 'application/views/_templates/header.php';
        echo "INSCRIRE A un cours";
        require 'application/views/_templates/footer.php';    	
    }

    public function DesincrireCours(){
    }

}
