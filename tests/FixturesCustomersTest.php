<?php

namespace Tests;

class FixturesCustomersTest extends TestGenericTDD
{
    /**
     * Vérification que Faker est correctement installé
     */
    public function testFakerIsInstalled()
    {
        $this->trueOrError(
            class_exists('\\Faker\\Factory'), 
            [
                "2.1",
                "Le module Faker n'est pas correctement installé !"
            ]
        );
    }

    /**
     * Vérification des fichiers Datafixtures, entity et Repository pour les customers
     */
    public function testFilesForFixturesCustomersExist()
    {
        $file = dirname(__DIR__).'/src/DataFixtures/CustomerFixtures.php';
        // Fixtures
        $this->fileExistsOrError(
            $file, 
            [ "2.2", "Vous devez créer le fichier :\"$file\" !"]
        );
        // on vérifie que la classe existe
        $this->trueOrError(
            class_exists('\\App\\DataFixtures\\CustomerFixtures'), 
            [
                "2.2",
                "Vous n'avez pas correctement créer votre classe dans le fichier \"$file\" !"
            ]
        );
        // 
        $this->trueOrError(
            method_exists('\\App\\DataFixtures\\CustomerFixtures', 'load'), 
            [
                "2.2",
                "Vous n'avez pas déclaré la méthode \"load\" dans votre class  \"$file\" !"
            ]
        );

        // Entity
        $file = dirname(__DIR__).'/src/Entity/Customer.php';
        $this->fileExistsOrError(
            $file, 
            [ "2.3", "Vous devez créer le fichier :\"$file\" !"]
        );
        // on vérifie que la classe existe
        $this->trueOrError(
            class_exists('\\App\\Entity\\Customer'), 
            [
                "2.3",
                "Vous n'avez pas correctement créer votre classe dans le fichier \"$file\" !"
            ]
        );

        // Repository
        $file = dirname(__DIR__).'/src/Repository/CustomerRepository.php';
        $this->fileExistsOrError(
            $file, 
            [ "2.3", "Vous devez créer le fichier :\"$file\" !"]
        );

        $this->trueOrError(
            class_exists('\\App\\Repository\\CustomerRepository'), 
            [
                "2.3",
                "Vous n'avez pas correctement créer votre classe dans le fichier \"$file\" !"
            ]
        );

        $this->trueOrError(
            method_exists('\\App\\Repository\\CustomerRepository', 'add'), 
            [
                "2.3",
                "Vous n'avez pas déclaré la méthode \"add\" dans votre class  \"$file\" !"
            ]
        );
    }
    
    /**
     * Vérifie si des données existent dans la collection customers
     */
    public function testCollectionCustomersExists()
    {
        $classe = '\\'.NAMESPACE_FRAMEWORK.'\\Database\\MongoDB';
        $clientMongoDB = $classe::getInstance();
        $this->trueOrError( 
            $clientMongoDB->getDatabase()->selectCollection('customers')->count() >= 50, 
            [
                "2.",
                "Vous n'avez pas générer de customers (il faut au minimum 50 customers) !"
            ]
        );
    }
}