<?php

require_once 'ExerciceSheet.php';
require_once 'CourseNote.php';
require_once 'Part.php';
class Chapter {
    
    
    //      Attributs
    //**********************
    
        protected $chapterID;
        protected $chapterNumber;
        protected $exercices;
        protected $title;
        protected $courseNotes;
        protected $db;
        
    //      Constructeur
    //**************************
        
        public function __construct($id, $exists=true){  
            $this->db=PDOHelper::getInstance();            
            if($exists==true){
                $res = $this->db->query("SELECT * FROM Chapter WHERE `chapterID`=".$id.";");
                $fetch = $res->fetch(PDO::FETCH_ASSOC);     
                if($fetch==null){
                    throw new UnexpectedValueException("Chapitre non existant");
                }   
                else{     
                    $this->chapterID=$id; 
                    if(isset($fetch['questionnaireID'])){
                         $this->exercices=new ExerciceSheet($fetch['questionnaireID']);
                    }
                    $this->title=$fetch['title']; 
                    $this->chapterNumber=$fetch['chapterNumber']; 
                    if(isset($fetch['URL'])){
                        $this->courseNotes=new CourseNote($fetch['URL']);}
                }
            }
            else {
                $this->db->exec("INSERT INTO Chapter (title) VALUES ('".$id."');");     
                $this->title=$id;
                $this->chapterID=$this->db->lastInsertId();
            }
        }  
        
        
        
    //      Accesseurs
    //***********************
                    
        public function chapterID(){
            return $this->chapterID;
        }
        
        public function chapterNumber(){     
            return $this->chapterNumber;       
        }
        
        public function exercices(){   
            return $this->exercices;         
        }
        
        public function title(){  
            return $this->title;          
        }    
        
        public function courseNotes(){  
            return $this->courseNotes;          
        }    
        
         
        public function setChapterNumber($num){
            $this->db->exec("UPDATE Chapter SET chapterNumber = ".$num." WHERE chapterID =".$this->chapterID);
            $this->chapterNumber=$num;
        }
        
        public function setExercices($e){
            $this->db->exec("UPDATE Chapter SET questionnaireID = '".$e->getId()."' WHERE chapterID =".$this->chapterID);
            $this->exercices=$e;
        }
        
        public function setTitle($t){     
            $this->db->exec("UPDATE Chapter SET title = '".$t."' WHERE chapterID =".$this->chapterID);
            $this->title=$t;
        }
        
        public function setCourseNotes($n){
            $this->db->exec("UPDATE Chapter SET URL = '".$n->getId()."' WHERE chapterID =".$this->chapterID);
            $this->courseNotes=$n;
        }

        //Suppression de la part en BDD
        
        public function delete(){
            $res=$this->db->query("SELECT partID FROM Chapters WHERE chapterID ='".$this->chapterID."'");  
            $fetch=$res->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $line){
                $id=$line["partID"];
                $res2=$this->db->query("SELECT title FROM Course JOIN (SELECT courseID FROM Parts WHERE partID ='".$id."') AS thispart ON Course.courseID=thispart.courseID");  
                $fetch2=$res2->fetchAll(PDO::FETCH_ASSOC);
                foreach($fetch2 as $line2){
                    $course=&CourseFactory::getCourse($line2["title"]);
                    $course->part($id)->removeChapter($this);
                }
            }
            $this->db->exec("DELETE FROM Chapter WHERE chapterID ='".$this->chapterID."'"); 
        }
        
        
}

?>
