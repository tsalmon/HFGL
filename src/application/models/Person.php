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

    //       Classes privées
    //****************************
        
        protected function friendFactory(){
            $trace = debug_backtrace();
            if ($trace[2]['class'] != 'PersonFactory') {
                die("<h1>Non ! On utilise la PersonFactory si on veut une personne !!!</h1>
                    <p>On remplace le système de class friends comme on peux ... Le constructeur de cette classe doit être considéré comme protected</p>
                    <p>Demande a Josian si tu as  un probleme pour utiliser la classe Person</p>");
            } 
        }
        
        //$table est le nom de la table associée à la classe fille
        protected function getDBEntry($mail,$table){    
            $res = $this->db->query("SELECT * FROM (person JOIN ".$table." ON person.personID = ".$table.".personID) WHERE `email`='".$mail."';");
            $fetch = $res->fetch(PDO::FETCH_ASSOC);            
            return $fetch;
        }
        
        //initialise les members à partir d'un FETCH_ASSOC
        
        protected function initiateMembers($fetch){            
                    $this->name=$fetch['name'];
                    $this->surname=$fetch['surname'];
                    $this->email=$fetch['email'];
                    $this->password=$fetch['password'];
                    $this->personID=$fetch['personID'];            
        }
        
        
        //Créé une nouvelle personne en BDD à partir de son mail
        
        protected function createEntry($mail){     
                $this->db->exec("INSERT INTO person ( `email`) VALUES ('".$mail."');");            
                return intval($this->db->lastInsertId());
        }
        
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
            $this->name=$n;
        }
        
        public function setEmail($m){     
            $this->db->exec("UPDATE person SET `email` = '".$m."' WHERE personID ='".$this->personID."'");
            $this->email=$m;
        }
        
        public function setPassword($p){   
            $this->db->exec("UPDATE person SET password = '".$p."' WHERE personID ='".$this->personID."'");
            $this->password=$p;
        }
        
        public function setSurname($s){  
            $this->db->exec("UPDATE person SET surname = '".$s."' WHERE personID ='".$this->personID."'");    
            $this->surname=$s;
        }
        
        
        //Suppression de la personne en BDD - Detruit la classe
        
        public function delete(){
            $this->db->exec("DELETE FROM person WHERE personID ='".$this->personID."'");   
        }
        
        //destructor
        
        public function __destruct() {
            PersonFactory::onDestruct($this->personID);
        }
        
}