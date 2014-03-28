<?php

require_once 'PersonFactory.php';
require_once 'CourseFactory.php';

class CourseSubstcription {
    
    //      Attributs
    //*********************
    
    protected static $courses;
    protected static $persons;
    protected static $db;
    
    //      Constructeur
    //**********************
    
    private function construct(){
        CourseSubstcription::$db=PDOHelper::getInstance();
        CourseSubstcription::$courses=array();
        CourseSubstcription::$persons=array();   
        
        $res=CourseSubstcription::$db->query("SELECT studentID, `email` FROM student JOIN person on person.personID=student.personID");
        $fetch = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $entry){
            CourseSubstcription::$persons[$entry['studentID']]=array($entry['email']);
        }
        
        $res=CourseSubstcription::$db->query("SELECT courseID, `title` FROM course");
        $fetch = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $entry){
            CourseSubstcription::$courses[$entry['courseID']]=array($entry['title']);
        }
    }


    //      Fonctions
    //**********************
    
    
    
    public static function getCourses($student){
        $resultat=array();
        $idstudent=$student->studentID();
        if(!isset(CourseSubstcription::$persons[$idstudent][0])){
            $res=array();
            $req = $this->db->query("SELECT courseID FROM inscription where studentID=".$idstudent);
            $fetch = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $id=$entry['courseID'];
                CourseSubstcription::$persons[$idstudent][]=$id;
                $resultat[]=CourseFactory::getCourse(CourseSubstcription::$courses[$id][0]);
            }
        }
        else{
            foreach(CourseSubstcription::$persons[$idstudent] as $id){
                if(is_int($id)){
                  $resultat[]=CourseFactory::getCourse(CourseSubstcription::$courses[$id][0]);
                }
            }
        }
        return $resultat;
    }   
    
    public static function getStudents($course){
        $resultat=array();
        $idcourse=$course->courseID();
        if(!isset(CourseSubstcription::$course[$idcourse][0])){
            $res=array();
            $req = $this->db->query("SELECT studentID FROM inscription where courseID=".$idcourse);
            $fetch = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $id=$entry['studentID'];
                CourseSubstcription::$courses[$idcourse][]=$id;
                $resultat[]=CourseFactory::getPerson(CourseSubstcription::$persons[$id][0]);
            }
        }
        else{
            foreach(CourseSubstcription::$courses[$idcourse] as $id){
                if(is_int($id)){
                  $resultat[]=CourseFactory::getPerson(CourseSubstcription::$persons[$id][0]);
                }
            }
        }
        return $resultat;
        
    }
    
    public static function add($student,$course){        
        CourseSubstcription::$courses[$course->courseID()][]=$student->studentID();
        CourseSubstcription::$persons[$student->studentID()][]=$course->courseID();
        CourseSubstcription::$db->exec('INSERT INTO inscription (studentID,courseID,date) VALUES ('.$student->studentID().','.$course->courseID().','.CURRENT_TIMESTAMP.');');
    }
    
    public static function remove($student,$course){
        array_splice(CourseSubstcription::$courses[$course->courseID()],$student->studentID());
        array_splice(CourseSubstcription::$persons[$student->studentID()],$course->courseID());
        CourseSubstcription::$db->exec('DELETE FROM inscription WHERE courseID='.$course->courseID().' AND studentID='.$student->studentID().');');
    }
    
    public static function deleteStudent($student){
        $entry=CourseSubstcription::$persons[$student->studentID()];
        foreach($entry as $course){
            if(is_int($id)){
                array_splice(CourseSubstcription::$courses[$course],$student->studentID());
            }
        }        
        unset(CourseSubstcription::$persons[$student->studentID()]);
        CourseSubstcription::$db->exec("DELETE FROM inscription WHERE studentID ='".$student->studentID()."'");  
        
    }
    
    public static function deleteCourse($course){
        $entry=CourseSubstcription::$courses[$course->courseID()];
        foreach($entry as $student){
            if(is_int($id)){
                array_splice(CourseSubstcription::$persons[$student],$course->courseID());
            }
        }        
        unset(CourseSubstcription::$courses[$courses->courseID()]);
        CourseSubstcription::$db->exec("DELETE FROM inscription WHERE courseID ='".$course->courseID()."'");      
        
    }
    
    
    
    
}

?>
