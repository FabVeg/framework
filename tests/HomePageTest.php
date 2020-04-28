<?php

namespace Tests;

use Falcon\GenericSingleton\MongoDB;

class HomePageTest extends TestGenericTDD
{
    public function testServerInstall()
    {
        $adresseHttp = 'http://127.0.0.1:'.HTTP_PORT;
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $adresseHttp);
            $this->trueOrError(
                $res->getStatusCode() == 200, 
                [
                    "HOMEPAGE",
                    "Votre serveur ne répond pas correctement à l'adresse ".$adresseHttp." avez vous mis le bon port et le bon répertoire (-t public)"
                ]
            );
        } 
        catch(\GuzzleHttp\Exception\ClientException $e) {
            $this->trueOrError(
                false, 
                [
                    "HOMEPAGE",
                    "Votre serveur ne répond pas correctement à l'adresse ".$adresseHttp.", assurez vous d'avoir correctement créée la route \"/\" dans votre fichier app/routes.php"
                ]
            );
        }
        catch(\GuzzleHttp\Exception\ConnectException $e) {
            $this->trueOrError(
                false, 
                [
                    "HOMEPAGE",
                    "Le serveur n'existe pas à l'adresse ".$adresseHttp.", pensez à le démarrer et à modifier le fichier phpunit.xml ci nécessaire."
                ]
            );
        }
    }

    public function testTwig()
    {
        try {
            $loader = new \Twig\Loader\FilesystemLoader();
            $this->trueOrError(true);
        } catch(\Throwable $e) {
            $this->trueOrError(
                false, 
                [
                    "HOMEPAGE",
                    "Le moteur de template Twig n'a pas été correctement installé !"
                ]
            );
        }
    }

    // la page doit contenir une structure suffisament correcte
    public function testPage()
    {
        $minChars = 500;
        $adresseHttp = 'http://127.0.0.1:'.HTTP_PORT;
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $adresseHttp);
        $content = $res->getBody();

        $this->trueOrError(
            (strlen($content) >= $minChars ? true : false), 
            [
                "HOMEPAGE",
                "Votre page ne semble pas contenir une structure HTML compléte, un code d'au moins $minChars caractéres est attendu, vous en avez uniquement ".strlen($content) 
            ]
        );

        foreach(['<!DOCTYPE html>','<html', '<head', '<title', '</title>', 'link', '</head>', '<body', '<header', '</header>', '<main', '</main>', '<nav', '</nav>','<footer','</footer>','</body>', '</html>'] as $tag) {
            $this->trueOrError(
                preg_match('#'.preg_quote($tag).'#', $content) == 1,
                [
                    "HOMEPAGE",
                    "Votre code HTML ne semble pas respecter la structure imposée.".
                    "\n". "Chargez au moins un fichier css, ainsi que les balises : header, main, nav, footer".
                    "\n"."Le tag : <".trim($tag, "<>")."> ne semble pas présent dans votre code !" 
                ]
            );
        }
    }
}