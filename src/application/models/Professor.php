<?php
require_once("Person.php");
require_once("Corrector.php");
require_once("QuestionTypeManager.php");

class Professor extends Person implements Corrector{
	
    //      Attribut
    //**********************
    
        protected $tutorID;


    //      Constructeur
    //***********************
        
        public function __construct($mail, $isID=false, $exists=true){    
            $this->db=  PDOHelper::getInstance();

            if($mail == null){
                return ;
            }

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
                $role=RoleTypeManager::getInstance()->getTutorID();
                $lastid=$this->createEntry($mail,$role);
                $this->db->exec("INSERT INTO Tutor (personID) VALUES (".$lastid.");"); 
                $this->tutorID=$this->db->lastInsertId();              
            }
        }
        
    //         Accesseurs
    //***************************
        
        public function getAll(){
            $res = $this->db->query("SELECT * FROM Person, Tutor WHERE Person.roleid = 2 AND Person.personID = Tutor.personID;");           
            $fetch =  $res->fetchAll(PDO::FETCH_ASSOC);
            return $fetch;       
        }
        
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

        public function addQuestionToCorrect($question) {

        }
    
        public function correctQuestion($questionID, $corrected_student_ID,$note) {
            $query="UPDATE Points SET note=".$note.", validated=1 WHERE questionID=".$questionID."
                AND studentID=".corrected_student_ID;
            $this->db->exec($query);
        }

        public function getQuestionsToCorrect() {
            $questionsheets=array();
            $courses=$this->getCourses();
            foreach ($courses as $course) {                                
                $questionsheets[]=$course->finalExam();
                foreach($course->parts() as $part){
                    $questionsheets[]=$part->exam;
                    foreach($part->chapters() as $chapter){
                        $questionsheets[]=$chapter->exercices();
                    }
                }
            }
            $questions=array();
            foreach ($questionsheets as $questionsheet) {                
                $questions=array_merge($questions,$questionsheet->getQuestions());
            }
            $ids=array();
            foreach ($questions as $question){
                $query="SELECT questionID FROM Points WHERE validated=2 AND questionID=".$question->getID();
                $res=$this->db->query($query);
                if($res!=false){
                    $fetch=$res->fetchAll(PDO::FETCH_ASSOC);
                    $ids=merge_array($ids,$fetch["questionID"]);
                }
               
            }
            return $ids;
            
       }   
       
        public function getQuestionsToValidate() {
            $questionsheets=array();
            $courses=$this->getCourses();
            foreach ($courses as $course) {                                
                $questionsheets[]=$course->finalExam();
                foreach($course->parts() as $part){
                    $questionsheets[]=$part->exam;
                    foreach($part->chapters() as $chapter){
                        $questionsheets[]=$chapter->exercices();
                    }
                }
            }
            $questions=array();
            foreach ($questionsheets as $questionsheet) {                
                $questions=array_merge($questions,$questionsheet->getQuestions());
            }
            $ids=array();
            foreach ($questions as $question){
                $query="SELECT questionID FROM Points WHERE validated=0 AND questionID=".$question->getID();
                $res=$this->db->query($query);
                if($res!=false){
                    $fetch=$res->fetchAll(PDO::FETCH_ASSOC);
                    $ids=merge_array($ids,$fetch["questionID"]);
                }
               
            }
            return $ids;
            
       }   
}