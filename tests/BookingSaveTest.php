<?php

namespace Tests;

use Falcon\GenericSingleton\MongoDB;

class BookingSaveTest extends TestGenericTDD
{

    public function testServerExists() 
    {
        
        try {
            $classe = '\\'.NAMESPACE_FRAMEWORK.'\\Database\\Redis';
            $clientRedis = $classe::getInstance();
            $keys = $clientRedis->getDatabase()->keys('*');
            $this->trueOrError(true);
        } 
        catch(\Predis\Connection\ConnectionException $e){
            $this->trueOrError(
                false, 
                [
                    "4.1",
                    "Vous n'avez pas correctement créé votre server Redis ou la connexion n'est pas correcte !"
                ]
            );  
        }
    }

    public function testPredisInstalled()
    {
        $this->trueOrError(
            class_exists('\Predis\Client'), 
            [
                "4.2",
                "Le client Predis n'est pas correctement installé !"
            ]
        );
    }

    public function testClassRedisExists()
    {
        try {
            $classe = '\\'.NAMESPACE_FRAMEWORK.'\\Database\\Redis';
            $interface = '\\'.NAMESPACE_FRAMEWORK.'\\Database\\IDatabase';

            $this->trueOrError(
                class_exists($classe), 
                [
                    "4.3",
                    "Vous n'avez pas créé la classe ".$classe
                ]
            );

            $this->trueOrError(
                method_exists($classe, "getInstance"), 
                [
                    "4.3",
                    "Vous n'avez pas créé un singleton pour votre classe ".$classe
                ]
            );

            $clientRedis = $classe::getInstance();
            $this->trueOrError(
                ($clientRedis instanceof $interface), 
                [
                    "4.3",
                    "votre classe ".$classe." n'implemente pas l'interface ".$interface." !"
                ]
            );
        }
        catch(Execpetion $e) {}
    }

     /**
     * Vérification des fichiers Datafixtures, entity et Repository pour les rooms
     */
    public function testFilesBookingExist()
    {
        // Entity
        $file = dirname(__DIR__).'/src/Entity/Booking.php';
        $this->fileExistsOrError(
            $file, 
            [ "4.4", "Vous devez créer le fichier :\"$file\" !"]
        );
        // on vérifie que la classe existe
        $this->trueOrError(
            class_exists('\\App\\Entity\\Booking'), 
            [
                "4.4",
                "Vous n'avez pas correctement créé votre classe dans le fichier \"$file\" !"
            ]
        );

        // Repository
        $file = dirname(__DIR__).'/src/Repository/BookingRepository.php';
        $this->fileExistsOrError(
            $file, 
            [ "4.4", "Vous devez créer le fichier :\"$file\" !"]
        );

        $this->trueOrError(
            class_exists('\\App\\Repository\\BookingRepository'), 
            [
                "4.4",
                "Vous n'avez pas correctement créé votre classe dans le fichier \"$file\" !"
            ]
        );
    }



    // Je vérifie uniquement si il y a au moins une clef
    public function testDataInRedis()
    {
        $classe = '\\'.NAMESPACE_FRAMEWORK.'\\Database\\Redis';
        $clientRedis = ($classe::getInstance())->getDatabase();
        
        $keys = $clientRedis->keys('*');
        $this->trueOrError(
            count($keys) >= 1, 
            [
                "4.6",
                "Il n'y a actuellement aucune donnée dans redis, donc aucune réservation..."
            ]
        );


        // On ne vérifie pas plus pour cette premiere version,
        // laissant ainsi libre aux étudiants de développer 
        // comme bon leur semble
        $exists = false;
        foreach($keys as $key) {
            // si au moins une clef contient hash avec plus de 4 valeurs il est possible que ce soit une réservation
            if (count($clientRedis->hgetall($key)) >= 5) {
                $exists = true;
                break;
            } 
        }
        $this->trueOrError(
            $exists, 
            [
                "4.6",
                "Il n'y a actuellement aucune donnée pouvant correspondre à une réservation."
            ]
        );
    }
}