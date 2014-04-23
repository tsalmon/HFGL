<?php
require_once("Person.php");
require_once("Corrector.php");
require_once("CourseSubstcription.php");

class Student extends Person implements Corrector {
	
    //      Attributs
    //**********************
    
        protected $studentID;
        protected $roleID;
        public $iam_student; //use to recognize person as student

    //      Constructeur
    //***********************
     
        // PAS TOUCHE !!! Voir classe PersonFactory.
        //Impossibilité de mettre des classes friends en php, donc appeler le constructeur
        //directement revient à appuyer sur le nuke button.
        public function __construct($mail, $exists=true){ 
            $this->friendFactory();  //Si ce n'est pas la factory qui a fait l'appel, NUKE.
            $this->db=  PDOHelper::getInstance();   
            if($exists==true){
                $fetch = $this->getDBEntry($mail, 3); 
                if($fetch==null){
                    throw new UnexpectedValueException("Utilisateur non existant");
                }
                else{ 
                    $this->initiateMembers($fetch);
                    $this->studentID=$fetch['personID'];
                    $this->roleID=$fetch['roleID'];
                    // $this->nse=$fetch['NSE'];
                }
            }
            else {
                if($this->mailExists($mail)){
                    throw new UnexpectedValueException("Utilisateur existant");
                }
                $lastid=$this->createEntry($mail,3);
                // $this->db->exec("INSERT INTO Person (personID) VALUES (".$lastid.");");   
                $this->studentID=$this->db->lastInsertId();       
            }
        }
        
    //         Accesseurs
    //***************************
        
        
        public function studentID(){  
            return $this->studentID;          
        }
        
        public function roleID(){    
            return $this->roleID;        
        }
         
        public function setNse($n){     
            $this->db->exec("UPDATE Student SET nse = '".$n."' WHERE studentID ='".$this->studentID."'");
            $this->nse=$n;
        }
        
        public function getCourses(){
            return CourseSubstcription::getCourses($this);
        }
        
        //Suppression de l'etudiant en BDD - Detruit la classe
        
        public function delete(){  
            CourseSubstcription::deleteStudent($this);
            $this->db->exec("DELETE FROM Student WHERE studentID ='".$this->studentID."'"); 
            parent::delete();            
        }
        
                    
}

?>