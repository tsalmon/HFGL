<?php

require_once 'Student.php';
require_once 'Course.php';

class CourseSubstcription {
    
    //      Attributs
    //*********************
    
    protected static $courses;
    protected static $persons;
    protected static $db;
    
    //      Constructeur
    //**********************
    
    private function construct(){
        PersonFactory::$db=PDOHelper::getInstance();        
        PersonFactory::$persons=array();
        PersonFactory::$mails=array();        
    }


    //      Fonctions
    //**********************
    
    
    
    public static function getCourses($student){
        if(!isset($persons[$student])){
            $res = $this->db->query("SELECT courseID FROM Course WHERE `title`=".$title.";");
        }
    }
    
    public static function getStudents($course){
        
    }
    
    public static function add($student,$course){
        
    }
    
    public static function remove($student,$course){
        
    }
    
    public static function deleteStudent($student){
        
    }
    
    public static function deleteCourse($student){
        
    }
    
    
    
    
}

?>
