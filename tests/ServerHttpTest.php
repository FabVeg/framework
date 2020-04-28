<?php

namespace Tests;

use Falcon\GenericSingleton\MongoDB;

class ServerHttpTest extends TestGenericTDD
{
    public function testExtensionMongoDBInstall()
    {
        $adresseHttp = 'http://127.0.0.1:'.HTTP_PORT;
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $adresseHttp);
            $this->trueOrError(
                $res->getStatusCode() == 200, 
                [
                    "SERVER HTTP",
                    "Votre serveur ne répond pas correctement à l'adresse ".$adresseHttp." avez vous mis le bon port et le bon répertoire (-t public)"
                ]
            );
        } 
        catch(\GuzzleHttp\Exception\ClientException $e) {
            $this->trueOrError(
                false, 
                [
                    "SERVER HTTP",
                    "Votre serveur ne répond pas correctement à l'adresse ".$adresseHttp.", assurez vous d'avoir correctement créée la route \"/\" dans votre fichier app/routes.php"
                ]
            );
        }
        catch(\GuzzleHttp\Exception\ConnectException $e) {
            $this->trueOrError(
                false, 
                [
                    "SERVER HTTP",
                    "Le serveur n'existe pas à l'adresse ".$adresseHttp.", pensez à le démarrer et à modifier le fichier phpunit.xml ci nécessaire."
                ]
            );
        }
    }
}