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
    }

    public static function initiate(){
        CourseTeaching::$db=PDOHelper::getInstance();
        CourseTeaching::$courses=array();
        CourseTeaching::$persons=array();   
        
        $res=CourseTeaching::$db->query("SELECT tutorID, `email` FROM Tutor JOIN person on person.personID=tutor.personID");
        $fetch = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $entry){
            CourseTeaching::$persons[$entry['tutorID']]=array($entry['email']);
        }
        
        $res=CourseTeaching::$db->query("SELECT courseID, `title` FROM course");
        $fetch = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $entry){
            CourseTeaching::$courses[$entry['courseID']]=array($entry['title']);
        }
    }
    
    protected static function createEntryProfessor($tutor){        
        if(!isset(CourseTeaching::$persons[$tutor->tutorID()])){            
            CourseTeaching::$persons[$tutor->tutorID()]=array($tutor->email());
        }
    }
    
    protected static function createEntryCourse($course){
        if(!isset(CourseTeaching::$courses[$course->courseID()])){            
            CourseTeaching::$courses[$course->courseID()]=array($course->title());
        }
        
    }

    //      Fonctions
    //**********************
    
    
    public static function getCourses($tutor){
        CourseTeaching::createEntryProfessor($tutor);
        $resultat=array();
        $idtutor=$tutor->tutorID();
        if(!isset(CourseTeaching::$persons[$idtutor][1])){
            $res=array();
            $req = CourseTeaching::$db->query("SELECT courseID FROM Teaching where tutorID=".$idtutor);
            if($req===false){
                return array();
            }
            $fetch = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $id=$entry['courseID'];
                CourseTeaching::$persons[$idtutor][]=$id;
                $resultat[]=CourseFactory::getCourse(CourseTeaching::$courses[$id][0]);
            }
        }
        else{
            foreach(CourseTeaching::$persons[$idtutor] as $id){
                if(ctype_digit($id)){
                  $resultat[]=CourseFactory::getCourse(CourseTeaching::$courses[$id][0]);
                }
            }
        }
        return $resultat;
    }   
    
    public static function getProfessors($course){
         CourseTeaching::createEntryCourse($course);
        $resultat=array();
        $idcourse=$course->courseID();
        if(!isset(CourseTeaching::$courses[$idcourse][1])){
            $res=array();
            $req = CourseTeaching::$db->query("SELECT tutorID FROM Teaching where courseID=".$idcourse);
            if($req===false){
                return array();
            }
            $fetch = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $id=$entry['tutorID'];
                CourseTeaching::$courses[$idcourse][]=$id;
                $resultat[]=PersonFactory::getPerson(CourseTeaching::$persons[$id][0]);
            }
        }
        else{
            foreach(CourseTeaching::$courses[$idcourse] as $id){
                if(ctype_digit($id)){
                  $resultat[]=PersonFactory::getPerson(CourseTeaching::$persons[$id][0]);
                }
            }
        }
        return $resultat;
        
    }
    
    public static function add($tutor,$course){
        CourseTeaching::createEntryProfessor($tutor);
        CourseTeaching::createEntryCourse($course);
        $test=array_search($course, $tutor->getCourses());
        if($test===false){
            CourseTeaching::$courses[$course->courseID()][]=$tutor->tutorID();
            CourseTeaching::$persons[$tutor->tutorID()][]=$course->courseID();
            CourseTeaching::$db->exec('INSERT INTO Teaching (tutorID,courseID) VALUES ('.$tutor->tutorID().','.$course->courseID().');');            
        }
    }
    
    public static function remove($tutorID,$courseID){
        $indice=array_search($tutorID, CourseTeaching::$courses[$courseID]);
        array_splice(CourseTeaching::$courses[$courseID],$indice);
        $indice=array_search($courseID, CourseTeaching::$persons[$tutorID]);
        array_splice(CourseTeaching::$persons[$tutorID],$indice);
        CourseTeaching::$db->exec('DELETE FROM Teaching WHERE courseID="'.$courseID.'" AND tutorID="'.$tutorID.'";');
    }
    
    public static function deleteTutor($tutor){
        $entry=CourseTeaching::$persons[$tutor->tutorID()];
        foreach($entry as $course){
            if(ctype_digit($id)){
                array_splice(CourseTeaching::$courses[$course],$tutor->tutorID());
            }
        }        
        unset(CourseTeaching::$persons[$tutor->tutorID()]);
        CourseTeaching::$db->exec("DELETE FROM Teaching WHERE tutorID ='".$tutor->tutorID()."'");  
        
    }
    
    public static function deleteCourse($course){
        $entry=CourseTeaching::$courses[$course->courseID()];
        foreach($entry as $tutor){
            if(ctype_digit($id)){
                array_splice(CourseTeaching::$persons[$tutor],$course->courseID());
            }
        }        
        unset(CourseTeaching::$courses[$courses->courseID()]);
        CourseTeaching::$db->exec("DELETE FROM Teaching WHERE courseID ='".$course->courseID()."'");      
        
    }   
}
CourseTeaching::initiate();
?>
