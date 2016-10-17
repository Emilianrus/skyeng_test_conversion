<?php
require (__DIR__ . DIRECTORY_SEPARATOR . 'dbmodel.php');

class Customer extends DBModel
{
    public $_tableName = 'customer';
    
    const CHARACTERS_DIGIT = '0123456789';
    
    public static function getStatuses()
    {
        return ['new', 'registered', 'refuse', 'not_available'];
    }
    
    public static function ConversionReport($daysInterval = 7)
    {
        $answer = [];
        $daysInterval = (int)$daysInterval;
       
        $firstDate = Customer::getFirstDateStamp();
        $lastDate = Customer::getLastDateStamp();
        
        $intervalBegin = $firstDate;
        $intervalEnd = $intervalBegin + ($daysInterval - 1) * 60*60*24;
        $model = new static();
        $db = $model->getDBH();
        
        do {
            $query = $db->query('SELECT COUNT(id) as client_count FROM ' . $model->_tableName . ' where DATE(creation_date) BETWEEN ' . 'CAST(\'' . date('Y-m-d', $intervalBegin) . '\' AS DATE) AND CAST(\'' . date('Y-m-d', $intervalEnd) . '\' AS DATE)');
            $query->setFetchMode(PDO::FETCH_ASSOC);  
            $row = $query->fetch();
            $clientCount = $row['client_count'];
            
            $query = $db->query('SELECT COUNT(id) as client_count FROM ' . $model->_tableName . ' where DATE(creation_date) BETWEEN ' . 'CAST(\'' . date('Y-m-d', $intervalBegin) . '\' AS DATE) AND CAST(\'' . date('Y-m-d', $intervalEnd) . '\' AS DATE) AND status = \'registered\'');
            $query->setFetchMode(PDO::FETCH_ASSOC);  
            $row = $query->fetch();
            $registredCount = $row['client_count'];
            $value = 0;
            if ($clientCount > 0) {
                $value = round($registredCount / $clientCount * 100);
            }
            $answer[] = ['clientCount' => $clientCount, 
                'registredCount' => $registredCount, 
                'intervalBegin' => $intervalBegin, 
                'intervalEnd' => $intervalEnd,
                'intervalDays' => $daysInterval,
                'value' => $value,
                ];
            
            $intervalBegin = $intervalEnd + 1 * 60*60*24; 
            $intervalEnd += $daysInterval * 60*60*24; 
            
        } while ($intervalBegin <= $lastDate);
        
        return $answer;
    }
    
    public static function generate($count)
    {
        $statuses = self::getStatuses();
        for ($i=0; $i<$count; $i++) {
            $customer = new Customer;
            
            $customer->name = ucfirst(self::generateRandomString(rand(3, 11)));
            $customer->surname = ucfirst(self::generateRandomString(rand(3, 11)));
            $customer->phone = self::generateRandomString(rand(7, 11), self::CHARACTERS_DIGIT);
            $customer->status = $statuses[rand(0, 3)];
            $customer->creation_date = date('Y-m-d H:i:s', rand(1451602800, 1475272800));
            
            if (!$customer->save()){
                return false;
            };
        }
        
        return true;
    }
    
    public static function getLastDateStamp()
    {
        $model = new static();
        $db = $model->getDBH();
        $query = $db->query('SELECT MAX(creation_date) as creation_date FROM ' . $model->_tableName);
        $query->setFetchMode(PDO::FETCH_ASSOC);  
  
        $row = $query->fetch();
        if (empty($row['creation_date'])) {
            return false;
        }
        
        return strtotime(date('Y-m-d',strtotime($row['creation_date'])));
    }
    
    public static function getFirstDateStamp()
    {
        $model = new static();
        $db = $model->getDBH();
        $query = $db->query('SELECT MIN(creation_date) as creation_date FROM ' . $model->_tableName);
        $query->setFetchMode(PDO::FETCH_ASSOC);  
  
        $row = $query->fetch();
        if (empty($row['creation_date'])) {
            return false;
        }
        
        return strtotime(date('Y-m-d',strtotime($row['creation_date'])));
    }
    
    public static function generateRandomString($length = 7, $characters = 'abcdefghijklmnopqrstuvwxyz') {
        
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}