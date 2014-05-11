<?php
require_once 'Student.php';
require_once 'Admin.php';
require_once 'Professor.php';
require_once 'RoleTypeManager.php';

//

class PersonFactory {

    //      Attributs
    //*********************
    
    protected static $mails;
    protected static $persons;   
    
    //      Constructeur
    //**********************
    
    private function construct(){
    }


    //      Fonctions
    //**********************
    
    protected static function initiateArrays(){
        if(!isset(PersonFactory::$mails)){
            PersonFactory::$persons=array();
            PersonFactory::$mails=array();            
        }
    }

    //Récupérer un objet correspondant à une personne dans la base de donnée
    public static function &getPerson($m,$isID=false){  
        PersonFactory::initiateArrays();
        if($isID){            
            if(isset(PersonFactory::$persons[$m])){
                $key=$m;
            }
            else{
                $key=false;
               $searchCol="`personID`";
            }
        }
        else{
            $key=array_search($m,PersonFactory::$mails);
            $searchCol="`email`";
        }
         if ($key==FALSE){      
            $db=  PDOHelper::getInstance();
            $resRequete = $db->query("SELECT roleID FROM Person WHERE ".$searchCol."='".$m."';");
            $fetch = $resRequete->fetch(PDO::FETCH_ASSOC); 
            if ($fetch==false){
                throw new UnexpectedValueException("Utilisateur non existant");
            }
            $roleM=  RoleTypeManager::getInstance();
            $roleID=$fetch['roleID'];
            $res=null;
            if($roleID==$roleM->getStudentID()){                
                try{
                    $res=new Student($m,$isID);
                   }
                catch(UnexpectedValueException $e){
                    throw new UnexpectedValueException("Utilisateur non existant");}                
            }
            elseif($roleID==$roleM->getTutorID()){                
                try{
                    $res=new Professor($m,$isID);
                   }
                catch(UnexpectedValueException $e){
                    throw new UnexpectedValueException("Utilisateur non existant");}                
             
            }
            elseif($roleID==$roleM->getAdminID()){                
                try{
                    $res=new Admin($m,$isID);
                   }
                catch(UnexpectedValueException $e){
                    throw new UnexpectedValueException("Utilisateur non existant");}                
            }
            $key=$res->personID();
            PersonFactory::$persons[$key]=&$res;
            PersonFactory::$mails[$key]=$m;
        }
        return PersonFactory::$persons[$key];
    } 
    
    public static function &createStudent($mail,$name,$surname,$password,$nse){
        PersonFactory::initiateArrays();
        try{
            $student=new Student($mail, false, false);
        }catch(UnexpectedValueException $e){
            throw new UnexpectedValueException("Utilisateur déjà existant");                
         }
        $student->setName($name);
        $student->setSurname($surname);
        $student->setPassword($password);
        $student->setNse($nse);
        $key=$student->personID();
        PersonFactory::$persons[$key]=&$student;
        PersonFactory::$mails[$key]=$mail;
        return $student;
        
    }
    public static function &createProfessor($mail,$name,$surname,$password){
        PersonFactory::initiateArrays();
        try{
          $professor=new Professor($mail, false, false);
        }catch(UnexpectedValueException $e){
            throw new UnexpectedValueException("Utilisateur déjà existant");                
         }
        $professor->setName($name);
        $professor->setSurname($surname);
        $professor->setPassword($password);
        $key=$professor->personID();
        PersonFactory::$persons[$key]=&$professor;
        PersonFactory::$mails[$key]=$mail;
        return $professor;
        
    }
    public static function &createAdmin($mail,$name,$surname,$password){
        PersonFactory::initiateArrays();
        try{
            $admin=new Admin($mail, false, false);
        }catch(UnexpectedValueException $e){
            throw new UnexpectedValueException("Utilisateur déjà existant");                
        }
        $admin->setName($name);
        $admin->setSurname($surname);
        $admin->setPassword($password);
        $key=$admin->personID();
        PersonFactory::$persons[$key]=&$admin;
        PersonFactory::$mails[$key]=$mail;
        return $admin;
        
    }

    public static function getAllStudents(){
        PersonFactory::initiateArrays();
        $all_student = new Student(null);
        return $all_student->getAll();
    }

    public static function getAllProfessors(){
        PersonFactory::initiateArrays();
        $all_student = new Professor(null);
        return $all_student->getAll();
    }

    //utilisée pour supprimer du tableau les instances de Persons qui ne sont plus utilisées.
    public static function onDestruct($id){       
        
        //On interdit l'utilisation de cette fonction dans tout autre contexte que la destuction de Persons.      
        $trace = debug_backtrace();
        if ($trace[1]['class'] != 'Person') {
            die("<h1>Pas touche !</h1>
                <p>Cette fonction devrait être considérée protected, mais est publique en raison de l'absence de friend functions en php.</p>
                <p>Son utilisation est réservée aux instances de Persons qui sont supprimées.</p>");
        }
        
            unset(PersonFactory::$persons[$id]);
            unset(PersonFactory::$mails[$id]);
        
    }
    
}
    
        

?>
