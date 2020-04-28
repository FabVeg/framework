<?php

namespace Tests;

class ErrorsHttpTest extends TestGenericTDD
{
    /**
     * Test erreur 404
     */
    public function testError404()
    {
        $minChars = 250;
        $adresseHttp = 'http://127.0.0.1:'.HTTP_PORT.'/'.uniqid('random_page');
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $adresseHttp);

            $this->trueOrError(
                $res->getStatusCode() != 404, 
                [
                    "ERREUR HTTP 404",
                    "Votre page 404 ne retourne pas un statut 404 (header) !"
                ]
            );
        }
        catch(\GuzzleHttp\Exception\ClientException $e) {
            $content = $e->getResponse()->getBody(true);
            $this->trueOrError(
                (strlen($content) >= $minChars ? true : false), 
                [
                    "ERREUR HTTP 404",
                    "Votre page ne semble pas contenir une structure HTML compléte, un code d'au moins $minChars caractéres est attendu, vous en avez uniquement ".strlen($content) 
                ]
            );

            foreach(['<!DOCTYPE html>','<html', '<head', '<title', '</title>', '</head>', '<body', '</body>', '</html>'] as $tag) {
                $this->trueOrError(
                    preg_match('#'.preg_quote($tag).'#', $content) == 1,
                    [
                        "ERREUR HTTP 404",
                        "Votre code HTML ne semble pas respecter la structure imposée.".
                        "\n"."Le tag : <".trim($tag, "<>")."> ne semble pas présent dans votre code !" 
                    ]
                );
            }
        }
    }


    /**
     * Test erreur 405
     */
    public function testError405()
    {
        $minChars = 250;
        $adresseHttp = 'http://127.0.0.1:'.HTTP_PORT;
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('POST', $adresseHttp);

            $this->trueOrError(
                $res->getStatusCode() != 405, 
                [
                    "ERREUR HTTP 405",
                    "Soit la route '/' existe en POST (et ne devrait pas) ou votre page 405 ne retourne pas un statut 405 (header) !"
                ]
            );
        }
        catch(\GuzzleHttp\Exception\ClientException $e) {
            $content = $e->getResponse()->getBody(true);
            $this->trueOrError(
                (strlen($content) >= $minChars ? true : false), 
                [
                    "ERREUR HTTP 405",
                    "Votre page ne semble pas contenir une structure HTML compléte, un code d'au moins $minChars caractéres est attendu, vous en avez uniquement ".strlen($content) 
                ]
            );

            foreach(['<!DOCTYPE html>','<html', '<head', '<title', '</title>', '</head>', '<body', '</body>', '</html>'] as $tag) {
                $this->trueOrError(
                    preg_match('#'.preg_quote($tag).'#', $content) == 1,
                    [
                        "ERREUR HTTP 405",
                        "Votre code HTML ne semble pas respecter la structure imposée.".
                        "\n"."Le tag : <".trim($tag, "<>")."> ne semble pas présent dans votre code !" 
                    ]
                );
            }
        }
    }

}