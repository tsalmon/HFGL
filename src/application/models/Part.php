<?php

require_once "Chapter.php";
require_once "CourseFactory.php";
class Part {
    
    
    //      Attributs
    //**********************
    
        protected $partID;
        protected $exam;
        protected $title;
        protected $chapters;
        protected $db;
        
    //      Constructeur
    //**************************
        
        private function __construct($id, $exists=true){  
            $this->db=PDOHelper::getInstance();            
            if($exists==true){
                $res = $this->db->query("SELECT * FROM part WHERE `partID`=".$id.";");
                $fetch = $res->fetch(PDO::FETCH_ASSOC);     
                if($fetch==null){
                    throw new UnexpectedValueException("Partie non existante");
                }
                else{     
                    $this->partID=$id; 
                    if(isset($fetch['questionnaireID'])){
                        $this->exam=new ExerciseSheet($fetch['questionnaireID']);}
                    $this->title=$fetch['title'];
                    $this->chapters=$this->getDBChapters();    
                }
            }
            else {
                $this->db->exec("INSERT INTO part ('title') VALUES ('".$id."');");        
            }
        }  
        
    //      Protected Functions
    //*********************************
        
        protected function getDBChapters(){
            $chap=[];
            $result = $this->db->query("SELECT chapterID FROM chapters WHERE `partID`=".$this->partID.";");
            $fetch = $result->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $chapid=$entry["chapterID"];
                $chap[]=new Chapter($chapid);
            }
            return $chap;
            
        }
        
    //      Accesseurs
    //***********************
                    
        public function partID(){
            return $this->partID;
        }
        
        public function exam(){     
            return $this->exam;       
        }
        
        public function title(){   
            return $this->title;         
        }
        
        public function chapters(){  
            return $this->chapters;          
        }
        
        public function &chapter($id){    
            if(isset($this->chapters)){
                foreach ($this->chapters as $chapter){
                    if($chapter->chapterID()==$id){
                        return $chapter;
                    }
                }
            }
            return false;        
        }
        
         
        public function setExam($e){
            $this->db->exec("UPDATE part SET questionnaireID = '".$e->getId()."' WHERE partID =".$this->partID);
            $this->exam=$e;
        }
        
        public function setTitle($t){     
            $this->db->exec("UPDATE part SET title = '".$t."' WHERE partID =".$this->partID);
            $this->title=$t;
        }
        
        public function addChapter($chapter){  
            $this->db->exec("INSERT INTO chapters VALUES (".$chapter->chapterID().", ".$this->partID.");");
            $this->chapters[]=$chapter;
        }
        
        public function &createNewChapter($title){  
            $chap=new Chapter($title,false);
            $this->addChapter($chap);
            return $chap;
        }
        
        public function removeChapter($chapter){  
            $this->db->exec("DELETE FROM chapters WHERE chapterID=".$chapter->chapterID());
            $key= array_search($this->chapters, $chapter);           
            array_splice($this->chapter, $key, 1);
        }

        //Suppression de la part en BDD
        
        public function delete(){
            $res=$this->db->query("SELECT courseID FROM parts WHERE partID ='".$this->partID."'");  
            $fetch=$res->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $line){
                $course=&CourseFactory::getCourse($line["courseID"]);
                $course->removePart($this);
            }
            $this->db->exec("DELETE FROM part WHERE partID ='".$this->partID."'"); 
        }
        
}

?>
