<?php

class Course {

    //      Attributs
    //**********************
    
        protected $courseID;
        protected $title;
        protected $description;
        protected $finalExamID;
        protected $parts;
        protected $db;
        
        
    //      Constructeur
    //**************************
        
        
     
        // PAS TOUCHE !!! Voir classe PersonFactory.
        //Impossibilité de mettre des classes friends en php, donc appeler le constructeur
        //directement revient à appuyer sur le nuke button.
        private function __construct($id, $exists=true){    
            $this->friendFactory();  //Si ce n'est pas la factory qui a fait l'appel, NUKE.
            $this->db=PDOHelper::getInstance();            
            if($exists==true){
                $res = $this->db->query("SELECT * FROM Course WHERE `courseID`='".$id."';");
                $fetch = $res->fetch(PDO::FETCH_ASSOC);     
                if($fetch==null){
                    throw new UnexpectedValueException("Cours non existant");
                }
                else{     
                    $this->title=$fetch['name'];
                    $this->finalExamID=$fetch['surname'];
                    $this->description=$fetch['email'];                    
                    $this->parts=$this->getDBParts();
                }
            }
            else {
                $this->db->exec("INSERT INTO Course (courseID) VALUES (".$id.");");        
            }
        }
        
        
        
    //       Classes privées
    //****************************
        //S'assure que c'est bien la factory qui a affectué l'appel (sur le constructeur)
        protected function friendFactory(){
            $trace = debug_backtrace();
            if ($trace[1]['class'] != 'CourseFactory') {
                die("<h1>Non ! On utilise la CourseFactory si on veut un cours !!!</h1>
                    <p>On remplace le système de class friends comme on peux ... Le constructeur de cette classe doit être considéré comme protected</p>
                    <p>Demande a Josian si tu as  un probleme pour utiliser la classe Course</p>");
            } 
        }
        
        protected function getDBParts(){
            $parts=[];
            $result = $this->db->query("SELECT partID FROM parts WHERE `courseID`='".$this->courseID."';");
            $fetch = $result->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $partid=$entry["partID"];
                $parts[]=new Part($partid);
            }
            return $parts;
            
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
        
        public function finalExamID(){   
            return $this->finalExamID;         
        }
         
        public function setFinalExamID($fe){
            $this->db->exec("UPDATE course SET questionnaireID: = '".$fe."' WHERE courseID ='".$this->courseID."'");
            $this->finalExamID=$fe;
        }
        
        public function setTitle($t){     
            $this->db->exec("UPDATE course SET title: = '".$t."' WHERE courseID ='".$this->courseID."'");
            $this->title=$t;
        }
        
        public function setDescription($d){   
            $this->db->exec("UPDATE course SET description: = '".$d."' WHERE courseID ='".$this->courseID."'");
            $this->description=$d;
        }
        
        public function addPart($part){  
            $this->db->exec("INSERT INTO parts VALUES (".$part->partID.", ".$this->courseID.");");
            $this->parts[]=$part;
        }
        public function removePart($part){  
            $this->db->exec("DELETE FROM parts WHERE partID=".$part->partID."'");
            $key=  array_search($this->parts, $part);           
            array_splice($this->parts, $key, 1);
        }

}

?>
