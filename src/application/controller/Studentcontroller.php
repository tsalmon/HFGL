<?php

class Studentcontroller extends Controller{
    public function index() //consulter cours
    {
        //$sql = "SELECT * FROM Person WHERE Person.email = '". $email."'";
        //$query = $student_model->db->prepare($sql);
        //$query->execute();
        //$result = $query->fetch();

        require 'application/views/_templates/header.php';
        require 'application/views/etudiant.php';
        require 'application/views/_templates/footer.php';
    }

    public function Parametres()
    {
    	$page = "student";
        require 'application/views/_templates/header.php';
        echo "voir les parametres";
        require 'application/views/_templates/footer.php';    	
    }

    public function Notes()
    {
    	$page = "student";
        require 'application/views/_templates/header.php';
        require 'application/views/student_view_notes.php';
        require 'application/views/_templates/footer.php';
    }

    public function InscrireCours(){
    	$page = "student";
        require 'application/views/_templates/header.php';
        echo "INSCRIRE A un cours";
        require 'application/views/_templates/footer.php';    	
    }

    public function DesincrireCours(){
    }

}
