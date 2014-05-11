<?php
require_once "application/models/TypeManager.php";

define('Examen', "Examen");
define('Memoire', "Memoire");
define('Projet', "Projet");
define('TP', "TP");


class QuestionnaireTypeManager extends TypeManager{

    private $examen;
    private $memoire;
    private $projet;
    private $tp;

    //      Constructeur private : singleton
    //*********************************************

    private function __construct(){
        $this->typeTable = "QuestionnaireType";
        $this->idField = "typeID";
        $this->nameField = "typeName";
        $this->refresh();
    }

    public static function getInstance(){
        if(QuestionnaireTypeManager::$sharedInstance==null){
            QuestionnaireTypeManager::$sharedInstance=new QuestionnaireTypeManager();
        }

        return QuestionnaireTypeManager::$sharedInstance;
    }

    public function refresh()
    {
        $this->examen = $this->getIdForTypeName(Examen);
        $this->memoire = $this->getIdForTypeName(Memoire);
        $this->projet = $this->getIdForTypeName(Projet);
        $this->tp = $this->getIdForTypeName(TP);

    }

    public function getExamenID()
    {
        if(!$this->examen)
        {
            $this->examen = $this->getIdForTypeName(Examen);
        }
        return $this->examen;
    }

    public function getMemoireID()
    {
        if(!$this->memoire
        {
            $this->memoire = $this->getIdForTypeName(Memoire);
        }
        return $this->memoire;
    }

    public function getProjetID()
    {
        if(!$this->projet)
        {
            $this->projet = $this->getIdForTypeName(Projet);
        }
        return $this->projet;
    }

    public function getTPID()
    {
        if(!$this->tp)
        {
            $this->tp = $this->getIdForTypeName(TP);
        }
        return $this->tp;
    }
} 