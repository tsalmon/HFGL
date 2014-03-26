<?php
require_once 'Student.php';
require_once 'Admin.php';
require_once 'Professor.php';

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
    
    
    //Récupérer un objet correspondant à une personne dans la base de donnée
    public static function &getPerson($m){  
        if(!isset(PersonFactory::$mails)){
            PersonFactory::$persons=[];
            PersonFactory::$mails=[];            
        }
        $key=array_search($m,PersonFactory::$mails);
        if ($key==FALSE){      
            try{
                $res=new Student($m);
               }
            catch(UnexpectedValueException $e){
                try{
                    $res=new Professor($m);
                   }
                catch(UnexpectedValueException $e){
                    try{
                        $res=new Admin($m);
                       }
                    catch(UnexpectedValueException $e){
                        throw new UnexpectedValueException("Utilisateur non existant");}                
                 }
             }
            $key=$res->personID();
            PersonFactory::$persons[$key]=$res;
            PersonFactory::$mails[$key]=$m;
        }
        return PersonFactory::$persons[$key];
    }
    
    public static function deletePerson($m){  
                
    }
    
}
    
        

?>
