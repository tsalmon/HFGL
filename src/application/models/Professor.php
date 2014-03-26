<?php
require_once("Person.php");
require_once("Corrector.php");

class Professor extends Person implements Corrector{
	
    //      Attribut
    //**********************
    
        protected $tutorID;


    //      Constructeur
    //***********************
        
        public function __construct($mail, $exists=true){    
            $this->db=  PDOHelper::getInstance();
            if($exists==true){
                $fetch = $this->getDBEntry($mail, "tutor");
                if($fetch==null){
                    throw new UnexpectedValueException("Utilisateur non existant");
                }
                else{
                    $this->initiateMembers($fetch);
                    $this->tutorID=$fetch['tutorID'];
                }
            }
            else {
                $lastid=$this->createEntry($mail);
                $this->db->exec("INSERT INTO tutor (personID) VALUES (".$lastid.");");        
            }
        }
        
    //         Accesseurs
    //***************************
        
        
        public function tutorID(){  
            return $this->tutorID;          
        }
        
	
        //Suppression de l'etudiant en BDD - Detruit la classe
        
        public function delete(){
            $this->db->exec("DELETE FROM tutor WHERE tutorID ='".$this->tutorID."'");   
            parent::delete();            
        }
}