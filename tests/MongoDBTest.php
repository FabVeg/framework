<?php

namespace Tests;

use Falcon\GenericSingleton\MongoDB;

class MongoDBTest extends TestGenericTDD
{
    public function testExtensionMongoDBInstall()
    {
        $this->trueOrError(
            class_exists('\MongoDB\Client'), 
            [
                "1.2",
                "Votre extension PHP mongoDB et/ou le client MongoDB ne sont pas correctement installés !"
            ]
        );
    }
  
    public function testClassMongoExists()
    {
        try {
            $classe = '\\'.NAMESPACE_FRAMEWORK.'\\Database\\MongoDB';
            $interface = '\\'.NAMESPACE_FRAMEWORK.'\\Database\\IDatabase';

            $this->trueOrError(
                class_exists($classe), 
                [
                    "1.3",
                    "Vous n'avez pas créé la classe ".$classe
                ]
            );

            $this->trueOrError(
                method_exists($classe, "getInstance"), 
                [
                    "1.3",
                    "Vous n'avez pas créé un singleton pour votre classe ".$classe
                ]
            );

            $clientMongoDB = $classe::getInstance();
            $this->trueOrError(
                ($clientMongoDB instanceof $interface), 
                [
                    "1.3",
                    "votre classe ".$classe." n'implemente pas l'interface ".$interface." !"
                ]
            );
        }
        catch(Execpetion $e) {}
    }


    public function testConnexionMongo()
    {
        try {
            $classe = '\\'.NAMESPACE_FRAMEWORK.'\\Database\\MongoDB';

            $clientMongoDB = ($classe::getInstance())->getDatabase();
            $this->trueOrError(
                (!empty($clientMongoDB->getDatabaseName())) ? true : false,
                [
                    "1.3",
                    "La connexion à votre database MongoDB a échouée !"
                ]
            );
        }
        catch(\MongoDB\Driver\Exception\AuthenticationException $e) {
            $this->trueOrError(
                false,
                [
                    "1.3",
                    "Vos identifiants sont incorrects, la connexion à votre database MongoDB a échouée !"
                ]
            );
        }
        catch(\MongoDB\Driver\Exception\InvalidArgumentException $e) {
            $this->trueOrError(
                false,
                [
                    "1.3",
                    "Votre adresse mongoDB est incorrect, la connexion à votre database MongoDB a échouée !"
                ]
            );
        }
    }

}