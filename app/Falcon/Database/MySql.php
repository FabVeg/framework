<?php
namespace Falcon\Database;
 
use Falcon\GenericSingleton;
use PDO;
 
class MySql extends GenericSingleton implements IDatabase
{
    private $db;
 
    protected function __construct() 
    {
        $config = include dirname(__DIR__, 2).'/config.php';
        $this->db = new PDO(
            $config['mysql']['dsn'], 
            $config['mysql']['username'], 
            $config['mysql']['password']
        );
    }
 
    public function getDatabase() 
    {
        return $this->db;
    }
}
