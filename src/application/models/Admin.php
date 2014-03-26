<?php
require_once("Person.php");

class Admin extends Person{
	
    //      Attribut
    //**********************
    
        protected $adminID;


    //      Constructeur
    //***********************
        
        public function __construct($mail, $exists=true){
            $this->db=  PDOHelper::getInstance();
            if($exists==true){
                $res = $this->db->query("SELECT * FROM (person JOIN admin ON person.personID = admin.personID) WHERE `email`='".$mail."';");
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
                    $this->adminID=$fetch['adminID'];
                }
            }
            else {
                $this->db->exec("INSERT INTO person ( `email`) VALUES ('".$mail."');");            
                $lastid=intval($this->db->lastInsertId());
                $this->db->exec("INSERT INTO admin (personID) VALUES (".$lastid.");");        
            }
        }
        
    //         Accesseurs
    //***************************
        
        
        public function adminID(){  
            return $this->adminID;          
        }
        
	
}