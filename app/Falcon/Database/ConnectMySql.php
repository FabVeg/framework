<?php
 
namespace Falcon\Database;
 
use Falcon\GenericSingleton;
 
class ConnectMySql extends GenericSingleton 
{
    private $pdo;
    // En mettant le constructeur en visibilité protected on s'assure
    // que nous ne pourrons pas instancier cette classe depuis l'extérieur
    protected function __construct() 
    {
        $config = include dirname(__DIR__, 2).'/config.php';
        try {
        $this->pdo = new \PDO($config['mysql']['dsn'], $config['mysql']['username'], $config['mysql']['password']);
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }
 
    public function getPDO() 
    {
        return $this->pdo;
    }
}
