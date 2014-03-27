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
        /*$sql = "SELECT * FROM Person WHERE Person.email = '". $email."'";
        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->fetch();
        
        if(($result == null) || ($result->password != $pwd)){ //incorrect password, or unregisted user
            return null;
        } 

        $sql = "SELECT * FROM Student WHERE Student.PersonID = '". $result->personID."'";
        $query = $this->db->prepare($sql);
        $query->execute();
        $result2 = $query->fetch();
        if($result2 == null){ // not a student
            $sql = "SELECT * FROM Tutor WHERE Tutor.PersonID = '". $result->personID."'";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetch();
            return $result;
        }
        return $result2;*/

        try{
            $person=&PersonFactory::getPerson($email);
        }catch(UnexpectedValueException $e){
            return null;
        }
        
        if($person->password()!=$pwd){
            return null;
        }
        
        $_SESSION['current']=$person;
        
        return $person;
    }
        
    /**
    * @param user_email: the mail give by user
    */
    public function user_exist($user_email){
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
