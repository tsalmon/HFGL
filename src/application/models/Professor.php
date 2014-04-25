<?php
require_once("Person.php");
require_once("Corrector.php");

class Professor extends Person implements Corrector{
	
    //      Attribut
    //**********************
    
        protected $tutorID;


    //      Constructeur
    //***********************
        
        public function __construct($mail, $isID, $exists=true){    
            $this->db=  PDOHelper::getInstance();
            if($exists==true){
                $fetch = $this->getDBEntry($mail, "Tutor",$isID);
                if($fetch==null){
                    throw new UnexpectedValueException("Utilisateur non existant");
                }
                else{
                    $this->initiateMembers($fetch);
                    $this->tutorID=$fetch['tutorID'];
                }
            }
            else {
                if($this->mailExists($mail)){
                    throw new UnexpectedValueException("Utilisateur existant");
                }
                $lastid=$this->createEntry($mail);
                $this->db->exec("INSERT INTO Tutor (personID) VALUES (".$lastid.");");   
                $this->tutorID=$this->db->lastInsertId();              
            }
        }
        
    //         Accesseurs
    //***************************
        
        
        public function tutorID(){  
            return $this->tutorID;          
        }
        
        public function getCourses(){
            return CourseTeaching::getCourses($this);
        }
        
	
        //Suppression de l'etudiant en BDD - Detruit la classe
        
        public function delete(){
            CourseTeaching::deleteTutor($this);
            $this->db->exec("DELETE FROM Tutor WHERE tutorID ='".$this->tutorID."'");    
            parent::delete();            
        }
}