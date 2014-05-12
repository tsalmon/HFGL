<?php

require_once 'Questionnaire.php';

class QuestionnaireFactory {

    //      Attributs
    //*********************
    
    protected static $courses;
    protected static $questionnaires;   
    
    //      Constructeur
    //**********************
    
    private function construct(){
    }


    //      Fonctions
    //**********************
    
    protected static function initiateArrays(){
        if(!isset(QuestionnaireFactory::$courses)){
            QuestionnaireFactory::$questionnaires=[];
            QuestionnaireFactory::$courses=[];            
        }
    }


    //Récupérer un objet correspondant à un cours dans la base de donnée
    public static function &getQuestionnaire($t,$isID=false){ 
        QuestionnaireFactory::initiateArrays();
        $key=array_search($t,QuestionnaireFactory::$courses);
        if($isID){            
            if(isset(QuestionnaireFactory::$questionnaires[$t])){
                $key=$t;
            }
            else{
                $key=false;
            }
        }
        else{
            $key=array_search($t,QuestionnaireFactory::$titles);
        }
        if ($key==FALSE){      
            try{
                $res=new Questionnaire($t,$isID);
               }
            catch(UnexpectedValueException $e){                
                    throw new UnexpectedValueException("Cours non existant");                
             }
            $key=$res->QuestionnaireID();
            QuestionnaireFactory::$Questionnaires[$key]=&$res;
            QuestionnaireFactory::$titles[$key]=$t;
        }
        return QuestionnaireFactory::$Questionnaires[$key];
    }
    
    public static function &createQuestionnaire($title,$description){
        QuestionnaireFactory::initiateArrays();
        $Questionnaire=new Questionnaire($title, false, false);
        $Questionnaire->setDescription($description);
        $key=$Questionnaire->QuestionnaireID();
        QuestionnaireFactory::$Questionnaires[$key]=&$Questionnaire;
        QuestionnaireFactory::$titles[$key]=$title;
        return $Questionnaire;
        
    }
    
    public static function getQuestionnairesList(){
        $db=  PDOHelper::getInstance();
        $query="Select title From Questionnaire;";
        $res=$db->query($query);
        $fetch=$res->fetchall(PDO::FETCH_COLUMN,"title");
        return $fetch;
    }
    
    //utilisée pour supprimer du tableau les instances de Questionnaire qui ne sont plus utilisées.
    public static function onDestruct($id){       
        
        //On interdit l'utilisation de cette fonction dans tout autre contexte que la destuction de Questionnaire.      
        $trace = debug_backtrace();
        if ($trace[1]['class'] != 'Questionnaire') {
            die("<h1>Pas touche !</h1>
                <p>Cette fonction devrait être considérée protected, mais est publique en raison de l'absence de friend functions en php.</p>
                <p>Son utilisation est réservée aux instances de Questionnaire qui sont supprimées.</p>");
        }
        
            unset(QuestionnaireFactory::$Questionnaires[$id]);
            unset(QuestionnaireFactory::$titles[$id]);
        
    }
    
}

?>
