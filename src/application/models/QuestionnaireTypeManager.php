<?php
require_once "application/models/TypeManager.php";

define('Examen', "Examen");
define('Memoire', "Memoire");
define('Projet', "Projet");
define('TP', "TP");


class QuestionTypeManager extends TypeManager{

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
        if(QuestionTypeManager::$sharedInstance==null){
            QuestionTypeManager::$sharedInstance=new QuestionTypeManager();
        }

        return QuestionTypeManager::$sharedInstance;
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
        if(!$this->qrf)
        {
            $this->qrf = $this->getIdForTypeName(Examen);
        }
        return $this->qrf;
    }

    public function getMemoireID()
    {
        if(!$this->qcm)
        {
            $this->qcm = $this->getIdForTypeName(Memoire);
        }
        return $this->qcm;
    }

    public function getProjetID()
    {
        if(!$this->l)
        {
            $this->l = $this->getIdForTypeName(Projet);
        }
        return $this->l;
    }

    public function getTPID()
    {
        if(!$this->p)
        {
            $this->p = $this->getIdForTypeName(TP);
        }
        return $this->p;
    }
} 