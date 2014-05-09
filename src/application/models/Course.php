<?php

require_once 'Part.php';

class Course {

    //      Attributs
    //**********************
    
        protected $courseID;
        protected $title;
        protected $description;
        protected $finalExam;
        protected $parts;
        protected $db;
        
        
    //      Constructeur
    //**************************
        
        
     
        // PAS TOUCHE !!! Voir classe PersonFactory.
        //Impossibilité de mettre des classes friends en php, donc appeler le constructeur
        //directement revient à appuyer sur le nuke button.
        public function __construct($title, $isID=false, $exists=true){    
            $this->friendFactory();  //Si ce n'est pas la factory qui a fait l'appel, NUKE.
            $this->db=PDOHelper::getInstance();            
            if($exists==true){
                if($isID){
                  $res = $this->db->query("SELECT * FROM Course WHERE `courseID`='".$title."';");
                }else{
                    $res = $this->db->query("SELECT * FROM Course WHERE `title`='".$title."';");
                }
                $fetch = $res->fetch(PDO::FETCH_ASSOC);     
                if($fetch==null){
                    throw new UnexpectedValueException("Cours non existant");
                }
                else{     
                    $this->title=$fetch["title"];
                    $this->courseID=$fetch['courseID'];
                    if(isset($fetch['questionnaireID'])){
                        $this->finalExam=new ExerciceSheet($fetch['questionnaireID']);}
                    $this->description=$fetch['description'];                  
                    $this->parts=$this->getDBParts();
                }

            }
            else {
                if($this->titleExists($title)){
                    throw new UnexpectedValueException("Cours déjà existant");
                }
                $this->db->exec("INSERT INTO Course (title) VALUES ('".$title."');"); 
                $this->title=$title;
                $this->courseID=$this->db->lastInsertId();
            }
        }
        
        
        
    //       Classes privées
    //****************************
        
        protected function titleExists($t){
            $res=$this->db->query("Select * from Course WHERE title='".$t."';");
            $fetch=$res->fetch(PDO::FETCH_ASSOC);
            return isset($fetch["title"]);
        }
                
        
        //S'assure que c'est bien la factory qui a affectué l'appel (sur le constructeur)
        protected function friendFactory(){
            $trace = debug_backtrace();
            if ($trace[2]['class'] != 'CourseFactory') {
                die("<h1>Non ! On utilise la CourseFactory si on veut un cours !!!</h1>
                    <p>On remplace le système de class friends comme on peux ... Le constructeur de cette classe doit être considéré comme protected</p>
                    <p>Demande a Josian si tu as  un probleme pour utiliser la classe Course</p>");
            } 
        }
        
        protected function getDBParts(){
            $p=[];
            $result = $this->db->query("SELECT partID FROM Parts WHERE `courseID`=".$this->courseID.";");
            $fetch = $result->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $partid=$entry["partID"];
                $p[]=new Part($partid);
            }
            return $p;
            
        }
        
    //      Accesseurs
    //***********************
                    
        public function courseID(){
            return $this->courseID;
        }
        
        public function title(){     
            return $this->title;       
        }
        
        public function description(){   
            return $this->description;         
        }
        
        public function parts(){  
            return $this->parts;          
        }
        
        public function &part($id){    
            if(isset($this->parts)){
                foreach ($this->parts as $part){
                    if($part->partID()==$id){
                        return $part;
                    }
                }
            }
            return false;        
        }
        
        public function finalExam(){   
            return $this->finalExam;         
        }
         
        public function setFinalExam($fe){
            $this->db->exec("UPDATE Course SET questionnaireID = '".$fe->getId()."' WHERE courseID =".$this->courseID);
            $this->finalExam=$fe;
        }
        
        public function setTitle($t){     
            $this->db->exec("UPDATE Course SET title = '".$t."' WHERE courseID =".$this->courseID);
            $this->title=$t;
        }
        
        public function setDescription($d){   
            $this->db->exec("UPDATE Course SET description = '".$d."' WHERE courseID =".$this->courseID);
            $this->description=$d;
        }
        
        public function addPart($part){  
            $this->db->exec("INSERT INTO Parts (partID, courseID) VALUES (".$part->partID().", ".$this->courseID.");");
            $this->parts[]=$part;
        }
        
        public function &createNewPart($title){  
            $part=new Part($title,false);
            $this->addPart($part);
            return $part;
        }
        
        public function removePart($part){  
            $this->db->exec("DELETE FROM Parts WHERE partID=".$part->partID());
            $key=  array_search($part,$this->parts);           
            array_splice($this->parts, $key, 1);
        }
        
        public function getStudents(){
            return CourseSubstcription::getStudents($this);
        }
        
        public function getProfessors(){
            return CourseSubstcription::getProfessors($this);
        }
        
        
        
        //Suppression du cours en BDD
        
        public function delete(){
            CourseSubstcription::deleteCourse($this);
            $this->db->exec("DELETE FROM Course WHERE courseID ='".$this->courseID."'");   
        }
        
        //destructor
        
        public function __destruct() {
            CourseFactory::onDestruct($this->courseID);
        }

}

?>
