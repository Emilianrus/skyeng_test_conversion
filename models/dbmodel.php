<?php

class DBModel
{
    public $attributes = [];
    public $DBHandler;
    public $_tableName;

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
    
    public function __get ($name)
    {
        if (empty($this->attributes[$name]))
            return null;
        
        return $this->attributes[$name];
    }
    
    public function getDBH()
    {
        if (empty($this->DBHandler)) {
            $this->DBHandler = new PDO('mysql:host=' . $GLOBALS['params']['db_host'] . ';dbname=' . $GLOBALS['params']['db_name'], $GLOBALS['params']['db_user'], $GLOBALS['params']['db_pass']);
            $this->DBHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        return $this->DBHandler;
    }
    
    public function save()
    {
        try {  
          $db = $this->getDBH();
          $query = $db->prepare(
            'INSERT INTO '
            . $this->_tableName
            . '(' .implode(",", array_keys($this->attributes)) . ')'
            . ' values '
            . '(:' . implode(", :", array_keys($this->attributes)) . ')');
            
          foreach(array_keys($this->attributes) as $key) {
              $paramName = ':' . $key;
              $query->bindParam($paramName, $this->attributes[$key]);
          }
          $query->execute();
          
          $this->id = $db->lastInsertId('id');
        }  
        catch(PDOException $e) {  
            return false;
        }
        
        return true;
    }
    
    public static function clear()
    {
        $model = new static();
        $db = $model->getDBH();
        $query = $db->prepare('DELETE FROM ' . $model->_tableName);
        $query->execute();
    }
    
    public static function selectAll()
    {
        $result = [];
        $model = new static();
        $db = $model->getDBH();
        $query = $db->query('SELECT * FROM ' . $model->_tableName);
        $query->setFetchMode(PDO::FETCH_ASSOC);  
  
        while($row = $query->fetch()) {  
            $result[] = $row;  
        }
        
        return $result;
    }
    
    public static function testConnection()
    {
        try {
            $DBHandler = new PDO('mysql:host=' . $GLOBALS['params']['db_host'] . ';dbname=' . $GLOBALS['params']['db_name'], $GLOBALS['params']['db_user'], $GLOBALS['params']['db_pass'],array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $e) {  
            return false;
        }
        
        return true;
    }
}