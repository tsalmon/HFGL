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
            if($mail == null){
                return ;
            }          
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
        }
        
    //         Accesseurs
    //***************************
        
        public function getAll(){
            $res = $this->db->query("SELECT * FROM Person, Student WHERE Person.roleid = 3 AND Person.personID = Student.personID;");           
            $fetch =  $res->fetchAll(PDO::FETCH_ASSOC);
            return $fetch;
        }

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

        public function correctQuestion($questionID, $corrected_student_ID,$note) {
            $query="UPDATE Points SET note=".$note.", validated=0 WHERE questionID=".$questionID."
                AND studentID=".$corrected_student_ID;
            $this->db->exec($query);
            $query2="DELETE FROM studentestimation WHERE questionID=".$questionID." AND estimatedStudentID=".$corrected_student_ID;
            $this->db->exec($query2);
        }

        public function getQuestionsToCorrect() {
            $query="SELECT questionID FROM StudentEstimation WHERE estimatingStudentID=".$this->studentID();
            $res=$this->db->query($query);            
            if (!$res){
                return array();
            }else {
                $fetch=$res->fetchAll(PDO::FETCH_COLUMN, "questionID");
                return $fetch;
            }
            
       }   
        public function getExerciceSheetsToDo() {
            
            $questionsheets=array();
            $courses=$this->getCourses();
            foreach ($courses as $course) {                                
                if($course->finalExam()!=null){
                    $questionsheets[]=$course->finalExam();}
                foreach($course->parts() as $part){                           
                    if($part->exam()!=null){
                        $questionsheets[]=$part->exam();}
                    foreach($part->chapters() as $chapter){  
                        if($chapter->exercices()!=null){
                            $questionsheets[]=$chapter->exercices();}
                    }
                }
            }
            
            $questions=array();
            foreach ($questionsheets as $questionsheet) {     
                if($questionsheet->getQuestions()!=null){
                
                    $questions=array_merge($questions,$questionsheet->getQuestions());
                }
            }
            $ids=array();
            foreach ($questions as $question){
                $query="SELECT DISTINCT questionID FROM Points WHERE questionID=".$question->getID()." and studentID=".$this->studentID();
                $res=$this->db->query($query);
                $fetch=$res->fetch(PDO::FETCH_ASSOC);
                if($fetch==false){
                    $ids[]=$question->getID();
                }
               
            }
            array_unique($ids);
            $questionnaires_ids=array();
            foreach ($ids as $id){
                $query="SELECT DISTINCT questionnaireID FROM Questions WHERE questionID=".$id;
                $res=$this->db->query($query);
                $fetch=$res->fetch(PDO::FETCH_ASSOC);
                if($fetch!=false){
                    $questionnaires_ids[]=$fetch["questionnaireID"];
                }
            }
            return array_unique($questionnaires_ids);
        }
        
}

?>