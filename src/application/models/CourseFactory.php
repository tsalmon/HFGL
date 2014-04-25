<?php

require_once 'Course.php';
class CourseFactory {

    //      Attributs
    //*********************
    
    protected static $titles;
    protected static $courses;   
    
    //      Constructeur
    //**********************
    
    private function construct(){
    }


    //      Fonctions
    //**********************
    
    protected static function initiateArrays(){
        if(!isset(CourseFactory::$titles)){
            CourseFactory::$courses=[];
            CourseFactory::$titles=[];            
        }
    }


    //Récupérer un objet correspondant à un cours dans la base de donnée
    public static function &getCourse($t,$isID=false){
        CourseFactory::initiateArrays();
        $key=array_search($t,CourseFactory::$titles);
        if($isID){
            if(isset(CourseFactory::$courses[$isID])){
                $key=$isID;
            }
            else{
                $key=false;
            }
        }
        else{
            $key=array_search($t,CourseFactory::$titles);
        }
        //if ($key==FALSE){
            try{
                $res=new Course($t,1);
               }
            catch(UnexpectedValueException $e){                
                    throw new UnexpectedValueException("Cours non existant");                
             }
            $key=$res->courseID();
            CourseFactory::$courses[$key]=&$res;
            CourseFactory::$titles[$key]=$t;
        //}
        return CourseFactory::$courses[$key];
    }
    
    public static function &createCourse($title,$description){
        CourseFactory::initiateArrays();
        $course=new Course($title, false, false);
        $course->setDescription($description);
        $key=$course->courseID();
        CourseFactory::$courses[$key]=&$course;
        CourseFactory::$titles[$key]=$title;
        return $course;
        
    }
    
    //utilisée pour supprimer du tableau les instances de Course qui ne sont plus utilisées.
    public static function onDestruct($id){       
        
        //On interdit l'utilisation de cette fonction dans tout autre contexte que la destuction de Course.      
        $trace = debug_backtrace();
        if ($trace[1]['class'] != 'Course') {
            die("<h1>Pas touche !</h1>
                <p>Cette fonction devrait être considérée protected, mais est publique en raison de l'absence de friend functions en php.</p>
                <p>Son utilisation est réservée aux instances de Course qui sont supprimées.</p>");
        }
        
            unset(CourseFactory::$courses[$id]);
            unset(CourseFactory::$titles[$id]);
        
    }
    
}

?>
