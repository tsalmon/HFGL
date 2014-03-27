<?php
require_once("Person.php");

class Logger{
	private $currentUser;

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }



}

