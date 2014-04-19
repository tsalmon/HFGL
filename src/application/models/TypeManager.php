<?php

abstract class TypeManager {
    protected  $typeTable;
    protected  $idField;
    protected  $nameField;
    protected abstract function refresh();
    protected function getIdForTypeName($typeName){
        if($typeRequestResult = PDOHelper::getInstance()->query("SELECT ".$this->idField." FROM ".$this->typeTable." WHERE ".$this->nameField."=".$typeName.")"))
        {
            $currentTypeRow = $typeRequestResult->fetch(PDO::FETCH_ASSOC);
            return $currentTypeRow[$this->idField];
        }
        else
        {
            throw new Exception("No ".$typeName." ID in the table".$this->typeTable."");
        }
    }
    protected static $sharedInstance = null;

    //         Renvoie un TypeManager
    //********************************
    public abstract static function getInstance();
} 