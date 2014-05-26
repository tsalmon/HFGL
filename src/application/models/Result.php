<?php

require_once 'QuestionnaireTypeManager.php';

class Result {

    //      Attributs
    //**********************
    
        protected $studentID;
        protected $course;
        protected $notes_projet;
        protected $notes_tps;
        protected $notes_examen;
        protected $notes_memoire;
        protected $db;
        
        
    //      Constructeur
    //**************************
        
        
     
        // PAS TOUCHE !!! 
        //Impossibilité de mettre des classes friends en php, donc appeler le constructeur
        //directement revient à appuyer sur le nuke button.
        public function __construct($student, $course){    
            $this->db=PDOHelper::getInstance(); 
            $this->notes_tps = [];
            $this->course = $course;
            $this->studentID = $student;
            //access notes de l'examen
            $examen = $this->db->query("SELECT lastPoints 
                                                    FROM Result JOIN  Course 
                                                    ON Result.questionnaireID=Course.questionnaireID
                                                    WHERE courseID='".$course->courseID()."'&& studentID='".$student."';");
            
            $fetch1 = $examen->fetchAll(PDO::FETCH_ASSOC);
            if(!($fetch1==null || !isset($fetch1["lastPoints"]))){
                $this->notes_examen = $fetch1['lastPoints'];
            }

            //access notes du mémoire et notes du projet
            $parts = $this->db->query("SELECT * FROM Parts 
                                        INNER JOIN  Part ON Parts.partID=Part.partID 
                                        INNER JOIN Result ON Part.questionnaireID = Result.questionnaireID 
                                        WHERE studentID='".$student."' && courseID='".$course->courseID()."';");

            
            $fetch2 = $parts->fetchAll(PDO::FETCH_ASSOC);


             if($fetch1==null){
                    // throw new UnexpectedValueException("Result du projet non existante");
                }
                else{
            
                    foreach($fetch1 as $part){
                        if(!isset($fetch1['questionnaireID'])){
                            continue;
                        }
                        $type_questionnaire = $this->db->query("SELECT questionnaireType FROM  Questionnaire
                                                WHERE questionnaireID='".$fetch1['questionnaireID']."';");
                        $typeMemoire = QuestionnaireTypeManager::getInstance()->getMemoireID();
                        $typeProjet = QuestionnaireTypeManager::getInstance()->getProjetID();

                        if ($type_questionnaire==$typeMemoire){
                            $this->notes_memoire = $fetch2['lastPoints'];
                        }
                        
                        elseif ($type_questionnaire == $typeProjet){
                            $this->notes_projet = $fetch2['lastPoints'];
                        }
                        // else
                            // throw new UnexpectedValueException("Questionnaire non existante");
                }
            }

            //access notes des tps
            $tps = $this->db->query("SELECT * FROM Parts 
                                        INNER JOIN  Chapters ON Parts.partID=Chapters.partID 
                                        INNER JOIN  Chapter ON Chapters.chapterID=Chapter.chapterID 
                                        INNER JOIN Result ON Chapter.questionnaireID = Result.questionnaireID 
                                        WHERE studentID='".$student."' && courseID='".$course->courseID()."';");
            $fetch3 = $tps->fetchAll(PDO::FETCH_ASSOC);
            if($fetch3==null){
                    // throw new UnexpectedValueException("Result non existante");
                }
                else{     
                     foreach($fetch3 as $tp){
                        $this->notes_tps[]= $tp['lastPoints'];
                     }
                }
        }
        
        
        
    //       Classes privées
    //****************************
 
        
    //      Accesseurs
    //***********************
                    
        public function course(){
            return $this->course;
        }
        public function studentID(){
            return $this->studentID;
        }
        
        public function notes_projet(){     
            return $this->notes_projet;       
        }

        public function notes_examen(){     
            return $this->notes_examen;       
        }

        public function notes_tps(){     
            return $this->notes_tps;       
        }
        
        public function notes_memoire(){   
            return $this->notes_memoire;         
        }
}

?>
