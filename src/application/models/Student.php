<?php
require_once("Person.php");
require_once("Corrector.php");

class Student extends Person implements Corrector {
	
    //      Attributs
    //**********************
    
        protected $studentID;
        protected $nse;


    //      Constructeur
    //***********************
     
        // PAS TOUCHE !!! Voir classe PersonFactory.
        //Impossibilité de mettre des classes friends en php, donc appeler le constructeur
        //directement revient à appuyer sur le nuke button.
        public function __construct($mail, $exists=true){ 
            $this->friendFactory();  //Si ce n'est pas la factory qui a fait l'appel, NUKE.
            $this->db=  PDOHelper::getInstance();   
            if($exists==true){
                $fetch = $this->getDBEntry($mail, "student"); 
                if($fetch==null){
                    throw new UnexpectedValueException("Utilisateur non existant");
                }
                else{ 
                    $this->initiateMembers($fetch);
                    $this->studentID=$fetch['studentID'];
                    $this->nse=$fetch['NSE'];
                }
            }
            else {
                if($this->mailExists($mail)){
                    throw new UnexpectedValueException("Utilisateur existant");
                }
                $lastid=$this->createEntry($mail);
                $this->db->exec("INSERT INTO student (personID) VALUES (".$lastid.");");        
            }
        }
        
    //         Accesseurs
    //***************************
        
        
        public function studentID(){  
            return $this->studentID;          
        }
        
        public function nse(){    
            return $this->nse;        
        }
         
        public function setNse($n){     
            $this->db->exec("UPDATE student SET nse = '".$n."' WHERE studentID ='".$this->studentID."'");
            $this->nse=$n;
        }
        
        //Suppression de l'etudiant en BDD - Detruit la classe
        
        public function delete(){
            $this->db->exec("DELETE FROM inscription WHERE studentID ='".$this->studentID."'");  
            $this->db->exec("DELETE FROM student WHERE studentID ='".$this->studentID."'"); 
            parent::delete();            
        }
        
                    
}

?>