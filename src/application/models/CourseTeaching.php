<?php

require_once 'PersonFactory.php';
require_once 'CourseFactory.php';

class CourseTeaching {
    
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
        
        $res=CourseSubstcription::$db->query("SELECT tutorID, `email` FROM tutor JOIN person on person.personID=tutor.personID");
        $fetch = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $entry){
            CourseSubstcription::$persons[$entry['tutorID']]=array($entry['email']);
        }
        
        $res=CourseSubstcription::$db->query("SELECT courseID, `title` FROM course");
        $fetch = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $entry){
            CourseSubstcription::$courses[$entry['courseID']]=array($entry['title']);
        }
    }


    //      Fonctions
    //**********************
    
    
    
    public static function getCourses($tutor){
        $resultat=array();
        $idtutor=$tutor->tutorID();
        if(!isset(CourseSubstcription::$persons[$idtutor][0])){
            $res=array();
            $req = $this->db->query("SELECT courseID FROM teaching where tutorID=".$idtutor);
            $fetch = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $id=$entry['courseID'];
                CourseSubstcription::$persons[$idtutor][]=$id;
                $resultat[]=CourseFactory::getCourse(CourseSubstcription::$courses[$id][0]);
            }
        }
        else{
            foreach(CourseSubstcription::$persons[$idtutor] as $id){
                if(is_int($id)){
                  $resultat[]=CourseFactory::getCourse(CourseSubstcription::$courses[$id][0]);
                }
            }
        }
        return $resultat;
    }   
    
    public static function getProfessors($course){
        $resultat=array();
        $idcourse=$course->courseID();
        if(!isset(CourseSubstcription::$course[$idcourse][0])){
            $res=array();
            $req = $this->db->query("SELECT tutorID FROM teaching where courseID=".$idcourse);
            $fetch = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $id=$entry['tutorID'];
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
    
    public static function add($tutor,$course){        
        CourseSubstcription::$courses[$course->courseID()][]=$tutor->tutorID();
        CourseSubstcription::$persons[$tutor->tutorID()][]=$course->courseID();
        CourseSubstcription::$db->exec('INSERT INTO teaching (tutorID,courseID,date) VALUES ('.$tutor->tutorID().','.$course->courseID().','.CURRENT_TIMESTAMP.');');
    }
    
    public static function remove($tutor,$course){
        array_splice(CourseSubstcription::$courses[$course->courseID()],$tutor->tutorID());
        array_splice(CourseSubstcription::$persons[$tutor->tutorID()],$course->courseID());
        CourseSubstcription::$db->exec('DELETE FROM teaching WHERE courseID='.$course->courseID().' AND tutorID='.$tutor->tutorID().');');
    }
    
    public static function deleteTutor($tutor){
        $entry=CourseSubstcription::$persons[$tutor->tutorID()];
        foreach($entry as $course){
            if(is_int($id)){
                array_splice(CourseSubstcription::$courses[$course],$tutor->tutorID());
            }
        }        
        unset(CourseSubstcription::$persons[$tutor->tutorID()]);
        CourseSubstcription::$db->exec("DELETE FROM teaching WHERE tutorID ='".$tutor->tutorID()."'");  
        
    }
    
    public static function deleteCourse($course){
        $entry=CourseSubstcription::$courses[$course->courseID()];
        foreach($entry as $tutor){
            if(is_int($id)){
                array_splice(CourseSubstcription::$persons[$tutor],$course->courseID());
            }
        }        
        unset(CourseSubstcription::$courses[$courses->courseID()]);
        CourseSubstcription::$db->exec("DELETE FROM teaching WHERE courseID ='".$course->courseID()."'");      
        
    }
    
    
    
    
}

?>
