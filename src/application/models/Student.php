<?php
require_once("Person.php");
require_once("Corrector.php");
require_once("CourseSubstcription.php");

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
        public function __construct($mail, $isID=false, $exists=true){ 
            $this->friendFactory();  //Si ce n'est pas la factory qui a fait l'appel, NUKE.
            $this->db=  PDOHelper::getInstance();   
            if($exists==true){
                $fetch = $this->getDBEntry($mail, "Student", $isID); 
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
                $role=RoleTypeManager::getInstance()->getStudentID();
                $lastid=$this->createEntry($mail,$role);
                $this->db->exec("INSERT INTO Student (personID) VALUES (".$lastid.");"); 
                $this->studentID=$this->db->lastInsertId();       
            }
            var_dump("test");
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
            $this->db->exec("UPDATE Student SET nse = '".$n."' WHERE studentID ='".$this->studentID."'");
            $this->nse=$n;
        }
        
        public function getCourses(){
            return CourseSubstcription::getCourses($this);
        }
        
        //Suppression de l'etudiant en BDD - Detruit la classe
        
        public function getMark($course){ 
            return CourseSubstcription::getMark($this,$course);
        }
        
        public function delete(){  
            CourseSubstcription::deleteStudent($this);
            $this->db->exec("DELETE FROM Student WHERE studentID ='".$this->studentID."'"); 
            parent::delete();            
        }
        
                    
}

?>