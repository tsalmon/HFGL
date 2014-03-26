<?php
require_once("Person.php");

class Admin extends Person{
	
    //      Attribut
    //**********************
    
        protected $adminID;


    //      Constructeur
    //***********************
        
        public function __construct($mail, $exists=true){  
            $this->db=  PDOHelper::getInstance();
            if($exists==true){
                $fetch = $this->getDBEntry($mail, "admin");
                if($fetch==null){
                    throw new UnexpectedValueException("Utilisateur non existant");
                }
                else{
                    $this->initiateMembers($fetch);
                    $this->adminID=$fetch['adminID'];
                }
            }
            else {
                $lastid=$this->createEntry($mail);
                $this->db->exec("INSERT INTO admin (personID) VALUES (".$lastid.");");        
            }
        }
        
    //         Accesseurs
    //***************************
        
        
        public function adminID(){  
            return $this->adminID;          
        }
        
        
        //Suppression de l'etudiant en BDD - Detruit la classe
        
        public function delete(){
            $this->db->exec("DELETE FROM admin WHERE adminID ='".$this->adminID."'");   
            parent::delete();            
        }
        
	
}