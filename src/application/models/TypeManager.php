<?php

abstract class TypeManager {
    protected abstract function refresh();
    protected abstract function getIdForTypeName($typeName);
    protected static $sharedInstance = null;

    //         Renvoie un TypeManager
    //********************************
    public abstract static function getInstance();
} 