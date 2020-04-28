<?php

namespace Tests;

use Falcon\GenericSingleton\MongoDB;

class BookingTest extends TestGenericTDD
{
    public function testServerInstall()
    {
        $adresseHttp = 'http://127.0.0.1:'.HTTP_PORT.'/reservation';
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $adresseHttp);
            $this->trueOrError(
                $res->getStatusCode() == 200, 
                [
                    "Réservation",
                    "Vous n'avez pas créée la route correctement \"/reservation\""
                ]
            );
        }
        catch(\Throwable $e) {
            $this->trueOrError(
                false, 
                [
                    "Réservation",
                    "L'adresse ".$adresseHttp.", n'a pas répondu comme attendu."
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
                    "Réservation",
                    "Le moteur de template Twig n'a pas été correctement installé !"
                ]
            );
        }
    }

    // la page doit contenir une structure suffisament correcte
    public function testPage()
    {
        $minChars = 500;
        $adresseHttp = 'http://127.0.0.1:'.HTTP_PORT.'/reservation';
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $adresseHttp);
        $content = $res->getBody();

        $this->trueOrError(
            (strpos($content,'not found') !== false ? false : true), 
            [
                "Réservation",
                "Pensez à créer les classes nécessaires à l'affichage de votre page." 
            ]
        );

        
        $this->trueOrError(
            (strlen($content) >= $minChars ? true : false), 
            [
                "Réservation",
                "Votre page ne semble pas contenir une structure HTML compléte, un code d'au moins $minChars caractéres est attendu, vous en avez uniquement ".strlen($content) 
            ]
        );

        foreach(['<!DOCTYPE html>','<html', '<head', '<title', '</title>', 'link', '</head>', '<body', '<header', '</header>', '<main', '</main>', '<nav', 
                    '<form', '</form', '<input', '</nav>','<footer','</footer>','</body>', '</html>'] as $tag) {
            $this->trueOrError(
                preg_match('#'.preg_quote($tag).'#', $content) == 1,
                [
                    "Réservation",
                    "Votre code HTML ne semble pas respecter la structure imposée.".
                    "\n". "Pensez à créer le formulaire".
                    "\n"."Le tag : <".trim($tag, "<>")."> ne semble pas présent dans votre code !" 
                ]
            );
        }
        // permet de vérifier qu'il y a au moins 4 name dans le formulaire
        preg_match_all('#name\=#U', $content, $matches);
        $this->trueOrError(
            count($matches[0]) >= 5,
                [
                    "Réservation",
                    "Votre formulaire ne semble pas complet.".
                    "\n". "Il est indispensable d'avoir l'attribut name sur tout vos champs !"
                ]
        );
        
    }
}