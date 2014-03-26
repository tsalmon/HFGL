<?php
require_once("PDOHelper.php");
abstract class Person{
    
    
    //      Attributs
    //***********************
    
	protected $name;
	protected $email;
	protected $password;
        protected $personID;
        protected $surname;
        protected $db;

    //      Accesseurs
    //***********************
                    
        public function name(){
            return $this->name;
        }
        
        public function email(){     
            return $this->email;       
        }
        
        public function password(){   
            return $this->password;         
        }
        
        public function surname(){  
            return $this->surname;          
        }
        
        public function personID(){    
            return $this->personID;        
        }
         
        public function setName($n){
            $this->db->exec("UPDATE person SET name = '".$n."' WHERE personID ='".$this->personID."'");
        }
        
        public function setEmail($m){     
            $this->db->exec("UPDATE person SET `email` = '".$m."' WHERE personID ='".$this->personID."'");
        }
        
        public function setPassword($p){   
            $this->db->exec("UPDATE person SET password = '".$p."' WHERE personID ='".$this->personID."'");
        }
        
        public function setSurname($s){  
            $this->db->exec("UPDATE person SET surname = '".$s."' WHERE personID ='".$this->personID."'");    
        }
        
}