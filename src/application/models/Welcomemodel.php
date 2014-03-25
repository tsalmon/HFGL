<?php

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
