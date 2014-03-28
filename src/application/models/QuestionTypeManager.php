<?php
require_once "application/models/TypeManager.php";

define('QRF', "qrf");
define('QCM', "qcm");
define('L', "l");
define('P', "p");


class QuestionTypeManager extends TypeManager{
    private $typeTable = "QuestionType";
    private $idField = "typeID";
    private $nameField = "typeName";

    private $qrf;
    private $qcm;
    private $l;
    private $p;

    //      Constructeur private : singleton
    //*********************************************

    private function __construct(){
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
        $this->qrf = $this->getIdForTypeName(QRF);
        $this->qcm = $this->getIdForTypeName(QCM);
        $this->l = $this->getIdForTypeName(L);
        $this->p = $this->getIdForTypeName(P);

    }

    protected  function getIdForTypeName($typeName){
        if($typeRequestResult = PDOHelper::getInstance()->query("SELECT ".$this->idField." FROM ".$this->typeTable." WHERE ".$this->nameField."=".$typeName.")"))
        {
            $currentTypeRow = $typeRequestResult->fetch(PDO::FETCH_ASSOC);
            return $currentTypeRow['typeID'];
        }
        else
        {
            throw new Exception("No ".$typeName." ID in the table".$this->typeTable."");
        }
    }

    public function getQrfID()
    {
        if(!$this->qrf)
        {
            $this->qrf = $this->getIdForTypeName(QRF);
        }
        return $this->qrf;
    }

    public function getQcmID()
    {
        if(!$this->qcm)
        {
            $this->qcm = $this->getIdForTypeName(QCM);
        }
        return $this->qcm;
    }

    public function getLID()
    {
        if(!$this->l)
        {
            $this->l = $this->getIdForTypeName(L);
        }
        return $this->l;
    }

    public function getPID()
    {
        if(!$this->p)
        {
            $this->p = $this->getIdForTypeName(P);
        }
        return $this->p;
    }
} 