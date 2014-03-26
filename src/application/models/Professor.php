<?php
require_once("Person.php");
require_once("Corrector.php");

class Professor extends Person implements Corrector{
	
    //      Attribut
    //**********************
    
        protected $tutorID;


    //      Constructeur
    //***********************
        
        public function __construct($mail, $exists=true){
            $this->db=  PDOHelper::getInstance();
            if($exists==true){
                $res = $this->db->query("SELECT * FROM (person JOIN tutor ON person.personID = tutor.personID) WHERE `email`='".$mail."';");
                $fetch = $res->fetch(PDO::FETCH_ASSOC);
                if($fetch==null){
                    throw new UnexpectedValueException("Utilisateur non existant");
                }
                else {
                    $this->name=$fetch['name'];
                    $this->surname=$fetch['surname'];
                    $this->email=$fetch['email'];
                    $this->password=$fetch['password'];
                    $this->personID=$fetch['personID'];
                    $this->tutorID=$fetch['tutorID'];
                }
            }
            else {
                $this->db->exec("INSERT INTO person ( `email`) VALUES ('".$mail."');");            
                $lastid=intval($this->db->lastInsertId());
                $this->db->exec("INSERT INTO tutor (personID) VALUES (".$lastid.");");        
            }
        }
        
    //         Accesseurs
    //***************************
        
        
        public function tutorID(){  
            return $this->tutorID;          
        }
        
	
}