<?php

class Professorcontroller extends Controller{

    public function index() //consulter cours
    { 
        // $student_model = $this->loadModel('WelcomeModel');
        // $sql = "SELECT courseID FROM Inscription WHERE Inscription.studentID = ".$_SESSION["id"]."";
        // $query = $student_model->db->prepare($sql);
        // $query->execute();
        // $liste_inscription = $query->fetchAll();
        // $liste_matiere = [];
        // //print_r($liste_inscription);
        // foreach ($liste_inscription as &$liste) {
        //     //$liste->courseID;

        //     $sql_matiere = "SELECT title FROM Course WHERE Course.courseID = ".($liste->courseID)."";
        //     $query_matiere = $student_model->db->prepare($sql_matiere);
        //     $query_matiere->execute();
        //     $result = $query_matiere->fetch();
        //     $liste_matiere[$result->title] = "";
        // }
        require 'application/views/_templates/header.php';
        require 'application/views/enseignant.php';
        require 'application/views/_templates/footer.php';
        
    }

    public function Parametres()
    {
    	$page = "professor";
        $MODELparam= $this->loadModel('PersonFactory');
        $infos = $MODELparam->getPerson($_SESSION["email"]);
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_parametres.php';
        require 'application/views/_templates/footer.php';    	
    }

    public function Parametres_result()
    {
        print_r($_POST);
    }

    public function ParametresPWD_result()
    {
        print_r($_POST);
    }

    public function Soumissions()
    {
    	$page = "professor";
        require 'application/views/_templates/header.php';
        require 'application/views/teacher_view_soumissions.php';
        require 'application/views/_templates/footer.php';
    }

    public function DonneNote(){
    	$page = "professor";
        require 'application/views/_templates/header.php';
        echo "DONNER UNE NOTE";
        require 'application/views/_templates/footer.php';    	
    }

    public function DesincrireCours(){
    }

    public function Deconnexion(){
        if(session_destroy()){
            header('location: '.URL.'Welcome');
        } else {
            header('location: '.URL.'Professor');
        }
    }
}
