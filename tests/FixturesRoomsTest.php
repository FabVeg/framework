<?php

namespace Tests;

class FixturesRoomsTest extends TestGenericTDD
{
    /**
     * Vérification des fichiers Datafixtures, entity et Repository pour les rooms
     */
    public function testFilesForFixturesRoomsExist()
    {
        $file = dirname(__DIR__).'/src/DataFixtures/RoomFixtures.php';
        // Fixtures
        $this->fileExistsOrError(
            $file, 
            [ "3.2", "Vous devez créer le fichier :\"$file\" !"]
        );
        // on vérifie que la classe existe
        $this->trueOrError(
            class_exists('\\App\\DataFixtures\\RoomFixtures'), 
            [
                "3.2",
                "Vous n'avez pas correctement créer votre classe dans le fichier \"$file\" !"
            ]
        );
        // 
        $this->trueOrError(
            method_exists('\\App\\DataFixtures\\RoomFixtures', 'load'), 
            [
                "3.2",
                "Vous n'avez pas déclaré la méthode \"load\" dans votre class  \"$file\" !"
            ]
        );

        // Entity
        $file = dirname(__DIR__).'/src/Entity/Room.php';
        $this->fileExistsOrError(
            $file, 
            [ "3.3", "Vous devez créer le fichier :\"$file\" !"]
        );
        // on vérifie que la classe existe
        $this->trueOrError(
            class_exists('\\App\\Entity\\Room'), 
            [
                "3.3",
                "Vous n'avez pas correctement créer votre classe dans le fichier \"$file\" !"
            ]
        );

        // Repository
        $file = dirname(__DIR__).'/src/Repository/RoomRepository.php';
        $this->fileExistsOrError(
            $file, 
            [ "3.3", "Vous devez créer le fichier :\"$file\" !"]
        );

        $this->trueOrError(
            class_exists('\\App\\Repository\\RoomRepository'), 
            [
                "3.3",
                "Vous n'avez pas correctement créer votre classe dans le fichier \"$file\" !"
            ]
        );

        $this->trueOrError(
            method_exists('\\App\\Repository\\RoomRepository', 'add'), 
            [
                "3.3",
                "Vous n'avez pas déclaré la méthode \"add\" dans votre class  \"$file\" !"
            ]
        );
    }
    
    /**
     * Vérifie si des données existent dans la collection rooms
     */
    public function testCollectionRoomsExists()
    {
        $classe = '\\'.NAMESPACE_FRAMEWORK.'\\Database\\MongoDB';
        $clientMongoDB = $classe::getInstance();
        $this->trueOrError( 
            $clientMongoDB->getDatabase()->selectCollection('rooms')->count() >= 50, 
            [
                "3.",
                "Vous n'avez pas générer de rooms (il faut au minimum 50 rooms) !"
            ]
        );
    }
}