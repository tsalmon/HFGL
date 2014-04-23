<?php
require_once("Person.php");

class Admin extends Person{
	
    //      Attribut
    //**********************
    
        protected $adminID;
        public $iam_admin; //use to recognize person as admin

    //      Constructeur
    //***********************
        
        public function __construct($mail, $exists=true){  
            $this->db=  PDOHelper::getInstance();
            if($exists==true){
                $fetch = $this->getDBEntry($mail, "Admin");
                if($fetch==null){
                    throw new UnexpectedValueException("Utilisateur non existant");
                }
                else{
                    $this->initiateMembers($fetch);
                    $this->adminID=$fetch['adminID'];
                }
            }
            else {
                if($this->mailExists($mail)){
                    throw new UnexpectedValueException("Utilisateur existant");
                }
                $lastid=$this->createEntry($mail);
                $this->db->exec("INSERT INTO Admin (personID) VALUES (".$lastid.");");     
                $this->adminID=$this->db->lastInsertId();            
            }
        }
        
    //         Accesseurs
    //***************************
        
        
        public function adminID(){  
            return $this->adminID;          
        }
        
        
        //Suppression de l'etudiant en BDD - Detruit la classe
        
        public function delete(){
            $this->db->exec("DELETE FROM Admin WHERE adminID ='".$this->adminID."'");   
            parent::delete();            
        }
        
	
}