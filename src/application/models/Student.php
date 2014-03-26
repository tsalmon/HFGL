<?php
require_once("Person.php");
require_once("Corrector.php");

class Student extends Person implements Corrector {
	
    //      Attribut
    //**********************
    
        protected $studentID;
        protected $nse;


    //      Constructeur
    //***********************
        
        public function __construct($mail, $exists=true){
            $this->db=  PDOHelper::getInstance();
            if($exists==true){
                $res = $this->db->query("SELECT * FROM (person JOIN student ON person.personID = student.personID) WHERE `email`='".$mail."';");
                $fetch = $res->fetch(PDO::FETCH_ASSOC);
                if($fetch==null){
                    throw new UnexpectedValueException("Utilisateur non existant");
                }
                else{
                    $this->name=$fetch['name'];
                    $this->surname=$fetch['surname'];
                    $this->email=$fetch['email'];
                    $this->password=$fetch['password'];
                    $this->personID=$fetch['personID'];
                    $this->studentID=$fetch['studentID'];
                    $this->nse=$fetch['NSE'];
                }
            }
            else {
                $this->db->exec("INSERT INTO person ( `email`) VALUES ('".$mail."');");            
                $lastid=intval($this->db->lastInsertId());
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
        }
                    
}

?>