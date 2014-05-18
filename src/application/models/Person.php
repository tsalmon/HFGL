<?php
require_once("PDOHelper.php");
require_once("RoleTypeManager.php");
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
        
        protected function mailExists($m){
            $query="Select * FROM Person WHERE email='".$m."';";
            $res=$this->db->query($query);
            $fetch=$res->fetch(PDO::FETCH_ASSOC);
            return isset($fetch["email"]);
        }
        
        protected function friendFactory(){
            $trace = debug_backtrace();
            if ($trace[2]['class'] != 'PersonFactory') {
                die("<h1>Non ! On utilise la PersonFactory si on veut une personne !!!</h1>
                    <p>On remplace le système de class friends comme on peux ... Le constructeur de cette classe doit être considéré comme protected</p>
                    <p>Demande a Josian si tu as  un probleme pour utiliser la classe Person</p>");
            } 
        }
        
        //$table est le nom de la table associée à la classe fille
        protected function getDBEntry($mail,$table,$isID){    
            if($isID==false){
                $res = $this->db->query("SELECT * FROM (Person JOIN ".$table." ON Person.personID = ".$table.".personID) WHERE Person.`email`='".$mail."';");
            }
            else{
                $res = $this->db->query("SELECT * FROM (Person JOIN ".$table." ON Person.personID = ".$table.".personID) WHERE Person.`personID`='".$mail."';");                
            }
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
        
        protected function createEntry($mail,$role){     
                $this->db->exec("INSERT INTO Person ( `email`,roleID) VALUES ('".$mail."',$role);");
                $this->email=$mail;
                $this->personID=$this->db->lastInsertId();
                return intval($this->personID);
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
            $this->db->exec("UPDATE Person SET name = '".$n."' WHERE personID ='".$this->personID."'");
            $this->name=$n;
        }
        
        public function setEmail($m){     
            $this->db->exec("UPDATE Person SET `email` = '".$m."' WHERE personID ='".$this->personID."'");
            $this->email=$m;
        }
        
        public function setPassword($p){   
            $this->db->exec("UPDATE Person SET password = '".$p."' WHERE personID ='".$this->personID."'");
            $this->password=$p;
        }
        
        public function setSurname($s){  
            $this->db->exec("UPDATE Person SET surname = '".$s."' WHERE personID ='".$this->personID."'");    
            $this->surname=$s;
        }
        
        
        //Suppression de la personne en BDD - Detruit la classe
        
        public function delete(){
            $this->db->exec("DELETE FROM Person WHERE personID ='".$this->personID."'");   
        }
        
        //destructor
        
        public function __destruct() {
            PersonFactory::onDestruct($this->personID);
        }
        
}