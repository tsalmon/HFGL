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
    }

    public static function initiate(){
        CourseSubstcription::$db=PDOHelper::getInstance();
        CourseSubstcription::$courses=array();
        CourseSubstcription::$persons=array();   
        
        $res=CourseSubstcription::$db->query("SELECT personID, `email` FROM Person where Person.roleID = 3");
        $fetch = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $entry){
            CourseSubstcription::$persons[$entry['personID']]=array($entry['email']);
        }
        
        $res=CourseSubstcription::$db->query("SELECT courseID, `title` FROM Course");
        $fetch = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch as $entry){
            CourseSubstcription::$courses[$entry['courseID']]=array($entry['title']);
        } 
    }

    //      Fonctions
    //**********************
    
    protected static function createEntryStudent($student){        
        if(!isset(CourseSubstcription::$persons[$student->studentID()])){  
            CourseSubstcription::$persons[$student->studentID()]=array($student->email());
        }
    }
    
    protected static function createEntryCourse($course){
        if(!isset(CourseSubstcription::$courses[$course->courseID()])){            
            CourseSubstcription::$courses[$course->courseID()]=array($course->title());
        }
        
    }
    
    public static function getCourses($student){
        CourseSubstcription::createEntryStudent($student);
        $resultat=array();
        $idstudent=$student->studentID();
        if(!isset(CourseSubstcription::$persons[$idstudent][1])){
            $res=array();
            $req = CourseSubstcription::$db->query("SELECT courseID FROM Inscription where studentID=".$idstudent);
            if($req===false){
                return array();
            }
            $fetch = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $id=$entry['courseID'];
                CourseSubstcription::$persons[$idstudent][]=$id;
                $resultat[]=CourseFactory::getCourse(CourseSubstcription::$courses[$id][0]);
            }
        }
        else{
            foreach(CourseSubstcription::$persons[$idstudent] as $id){                
                if(ctype_digit($id)){
                  $resultat[]=CourseFactory::getCourse(CourseSubstcription::$courses[$id][0]);
                }
            }
        }
        return $resultat;
    }   
    
    public static function getStudents($course){
        CourseSubstcription::createEntryCourse($course);
        $resultat=array();
        $idcourse=$course->courseID();
        if(!isset(CourseSubstcription::$courses[$idcourse][1])){
            $res=array();
            $req = CourseSubstcription::$db->query("SELECT studentID FROM Inscription where courseID=".$idcourse);
            if($req===false){
                return array();
            }
            $fetch = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach($fetch as $entry){
                $id=$entry['studentID'];
                CourseSubstcription::$courses[$idcourse][]=$id;
                $resultat[]=PersonFactory::getPerson(CourseSubstcription::$persons[$id][0]);
            }
        }
        else{
            foreach(CourseSubstcription::$courses[$idcourse] as $id){
                if(ctype_digit($id)){
                  $resultat[]=PersonFactory::getPerson(CourseSubstcription::$persons[$id][0]);
                }
            }
        }
        return $resultat;
        
    }
    
    public static function add($student,$course){  
        CourseSubstcription::createEntryStudent($student);
        CourseSubstcription::createEntryCourse($course);
        $test=array_search($course, $student->getCourses());
        if($test===false){      
            CourseSubstcription::$courses[$course->courseID()][]=$student->studentID();
            CourseSubstcription::$persons[$student->studentID()][]=$course->courseID();
            CourseSubstcription::$db->exec('INSERT INTO Inscription (studentID,courseID,date) VALUES ('.$student->studentID().','.$course->courseID().',CURRENT_TIMESTAMP);');            
        }
    }
    
    public static function remove($studentID,$courseID){ 
        $indice=array_search($studentID, CourseSubstcription::$courses[$courseID]);
        array_splice(CourseSubstcription::$courses[$courseID],$indice,1);
        $indice=array_search($courseID, CourseSubstcription::$persons[$studentID]);
        array_splice(CourseSubstcription::$persons[$studentID],$indice,1);
        CourseSubstcription::$db->exec('DELETE FROM Inscription WHERE courseID='.$courseID.' AND studentID='.$studentID.';');
    }
    
    public static function deleteStudent($student){
        $entry=CourseSubstcription::$persons[$student->studentID()];
        foreach($entry as $course){
            if(ctype_digit($course)){
                $ind=array_search($student->studentID(),CourseSubstcription::$courses[$course] );
                array_splice(CourseSubstcription::$courses[$course],$ind,1);
            }
        }        
        unset(CourseSubstcription::$persons[$student->studentID()]);
        CourseSubstcription::$db->exec("DELETE FROM Inscription WHERE studentID ='".$student->studentID()."'");  
        
    }
    
    public static function deleteCourse($course){
        $entry=CourseSubstcription::$courses[$course->courseID()];
        foreach($entry as $student){
            if(ctype_digit($student)){
                $ind=array_search($course->courseID(),CourseSubstcription::$persons[$student] );
                array_splice(CourseSubstcription::$persons[$student],$ind,1);
            }
        }        
        unset(CourseSubstcription::$courses[$course->courseID()]);
        CourseSubstcription::$db->exec("DELETE FROM Inscription WHERE courseID ='".$course->courseID()."'");      
        
    }
    
    
    
    
}

CourseSubstcription::initiate();
?>
