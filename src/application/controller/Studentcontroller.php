<?php

class Studentcontroller extends Controller{
    private $titre_firstpart;
    private $list_part;
    private $list_coursID;
    private $liste_matiere;

    public function index() //consulter cours
    { 
        $list_partID = array();
        $list_coursID = array();
        $liste_matiere = array();
        $student_model = $this->loadModel('Welcomemodel');

        // on recupere les id des cours de l'utilisateur
        $sql = "SELECT courseID FROM Inscription WHERE Inscription.studentID = ".$_SESSION["id"]."";
        $query = $student_model->db->prepare($sql);
        $query->execute();
        $liste_inscription = $query->fetchAll();

        //pour chaque id de cours suivis, recuperer le nom, description
        foreach ($liste_inscription as &$liste) {
            $sql = "SELECT title, description  FROM Course WHERE Course.courseID = ".($liste->courseID)."";
            $query = $student_model->db->prepare($sql);
            $query->execute();
            $result = $query->fetch();

            array_push($liste_matiere, $result->title);
            
        }
        //pour la plus premiere matiere de la liste, get id
        $list_part = $this->CoursParts($liste_inscription[0]->courseID, $student_model);
        
        require 'application/views/_templates/header.php';
        require 'application/views/etudiant.php';
        require 'application/views/_templates/footer.php';
    }

    //get id and title of all part for one cours
    public function CoursParts($courseID, $student_model){
        //on recupere les parties d'un cours
        $sql = "SELECT partID FROM Parts WHERE Parts.courseID = ".$courseID."";
        $query = $student_model->db->prepare($sql);
        $query->execute();
        $part = $query->fetchAll();

        //$part =  Array ( [0] => stdClass Object ( [partID] => 1 ) [1] => stdClass Object ( [partID] => 2 ) ... ) 
        foreach ($part as &$liste) {
            $sql = "SELECT title FROM Part WHERE Part.partID = ".$liste->partID."";
            $query = $student_model->db->prepare($sql);
            $query->execute();
            $titre_part = $query->fetch();
            /*echo "<p>";
            print_r($titre_part);
            echo "<br>";
            print_r($liste);
            echo "<br>";
            print_r($part);
            echo "</p><br>";
            */
            $this->list_part[$liste->partID] = $titre_part->title;
        }
        return $this->list_part;
    }

    public function Parametres()
    {
    	$page = "student";
        require 'application/views/_templates/header.php';
        require 'application/views/student_parametres.php';
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

    public function NotesDeCours()
    {
        $page = "student";
        require 'application/views/_templates/header.php';
        require 'application/views/student_view_notesDeCours.php';
        require 'application/views/_templates/footer.php';
    }

}
