<?php
 
namespace Falcon;
 
use Falcon\Database\ConnectMySql;
 
abstract class AbstractRepository
{
    protected $db;
 
    public function __construct($typeDB)
    {
        switch($typeDB) {
            case 'sql' :
            case 'mysql' :
                $connect = ConnectMySql::getInstance();
            break;
            case 'mongo' :
            case 'mongodb' :
                    $connect = MongoDB::getInstance();
                break;
        }
        $this->db = $connect->getDatabase();
    }
 
    protected function getEntity(EntityInterface $entity) 
    {
        $result = [];
        if (is_object($entity))
        {            
            foreach ($entity as $key => $value)
            {
                $getter = 'get'.ucfirst($key); 
                if(method_exists($entity, $getter) && $value !== null) {
                    $result[$key] = call_user_func([$entity,$getter]);
                }
            }
        }
        return $result; 
    }
}
