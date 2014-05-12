<?php

require_once 'CourseSubstcription.php';

class Result {

    //      Attributs
    //**********************
    
        protected $studentID;
        protected $course;
        protected $questionnaireID;
        protected $lastPoints;
        protected $attemptsRemain;
        protected $lastAttemptDate;
        protected $db;
        
        
    //      Constructeur
    //**************************
        
        
     
        // PAS TOUCHE !!! Voir classe PersonFactory.
        //Impossibilité de mettre des classes friends en php, donc appeler le constructeur
        //directement revient à appuyer sur le nuke button.
        public function __construct($student, $questionnaire, $courseID){    
            $this->db=PDOHelper::getInstance(); 
            $res = $this->db->query("SELECT * FROM Result WHERE `questionnaireID`='".$questionnaire."'&& studentID='".$student."';");

            $fetch = $res->fetchAll(PDO::FETCH_ASSOC);

            if($fetch==null){
                    throw new UnexpectedValueException("Result non existante");
                }
                else{     
                    $this->studentID = $student;
                    $this->courseID = $courseID;
                    $this->questionnaireID = $questionnaireID; 
                    $this->lastPoints=$fetch['lastPoints'];
                    $this->attemptsRemain=$fetch['attemptsRemain'];
                    $this->lastAttemptDate=$fetch['lastAttemptDate'];    
                }
        }
        
        
        
    //       Classes privées
    //****************************
        
        protected function type(){
            $res=$this->db->query("Select questionnaireType from Questionnaire WHERE questionnaireID=".$questionnaireID.";");
            $type= $this->db->query("Select typeName from QuestionnaireType WHERE typeID=".$res.";");
            return $type;
        }
                
        
    //      Accesseurs
    //***********************
                    
        public function course(){
            return $this->course;
        }
        public function studentID(){
            return $this->studentID;
        }
        
        public function questionnaireID(){     
            return $this->title;       
        }
        
        public function lastPoints(){   
            return $this->lastPoints;         
        }
        
        public function lastAttemptDate(){  
            return $this->lastAttemptDate;          
        }
        
}

?>
