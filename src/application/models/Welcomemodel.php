<?php

require_once 'PersonFactory.php';

class WelcomeModel
{
    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }


    /**
    * @param email (string)
    * @param pwd (string)
    */
    public function connect($email, $pwd){
        $person = null;
        try{
            $person=&PersonFactory::getPerson($email);
        }catch(UnexpectedValueException $e){
            return null;
        }
        
        if($person->password()!=$pwd){
            return null;
        }
                
        return $person;
    }
        
    /**
    * @param user_email: the mail give by user
    */
    public function user_exist($user_email){
        /* A METTRE EN PLACE QUAND LA BDD AURA ETE OPTIMISEE
         try {
            $person=&PersonFactory::getPerson($user_email);
            unset($person);
            return true;
        }catch(Exception $e){
            return false;
        }*/
        
        $sql = "SELECT email FROM Person WHERE Person.email = '".$user_email."'";
        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return isset($result[0]);
    }

    /**
    * @param user_name 
    * @param user_surname 
    * @param user_pwd 
    * @param user_mail  
    */
    public function addPerson($user_name, $user_surname, $user_pwd, $user_mail){
        $sql = "INSERT INTO Person (name, surname, email, password) VALUES('".$user_name."', '".$user_surname."', '".$user_mail."', '".$user_pwd."')";    
        echo $sql;
        $query = $this->db->prepare($sql);
        return ($query->execute());
    }
}
