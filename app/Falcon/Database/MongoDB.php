<?php

namespace Falcon\Database;
 
use Falcon\GenericSingleton;
use PDO;

use \MongoDB\Client;
    	$client = new Client('mongodb://localhost:27017/?readPreference=primary&appname=MongoDB%20Compass%20Community&ssl=false');

class MongoDB extends GenericSingleton implements IDatabase
{
    private $db;
    
    protected function __construct() 
    {
        $config = include dirname(__DIR__, 2).'/config.php';
        $this->db = new PDO(
            $config['mongodb']['host'], 
            $config['mongodb']['dbname']
        );
    }
    
    public function getDatabase() 
    {
        return $this->db;
    }
}
        