<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {
    /**
     * Loads paper information from the HTML and returns the array with the data.
     */
    public function scrap(\DOMDocument $dom): array {
        if ($dom !== null) {
            $htmlContent = $dom->saveHTML();
            $xpath = new \DOMXPath($dom);
            $papers = [];
            $paperElements = $xpath->query('//a[contains(@class, "paper-card")]');

            foreach ($paperElements as $paperElement) {
                $htmlContent = $dom->saveHTML($paperElement);
                $htmlDom = new \DOMDocument();
                $htmlDom->loadHTML($htmlContent);
                $xpathPaper = new \DOMXPath($htmlDom);

                /* GET TITLE */
                $titleElement = $xpathPaper->query('.//h4[contains(@class, "my-xs paper-title")]')->item(0);
                $title = $titleElement ? $titleElement->nodeValue : 'Sem Informações de título';

                /* GET TYPE */
                $typeElement = $xpathPaper->query('.//div[contains(@class, "tags mr-sm")]')->item(0);
                $type = $typeElement ? $typeElement->nodeValue : 'Tipo não encontrada';

                /* GET ID */
                $idElement = $xpathPaper->query('.//div[contains(@class, "volume-info")]')->item(0);
                $id = $idElement ? $idElement->nodeValue : 'ID não encontrada';

                /* GET PERSON */
                $person = [];
                $authorsElement = $xpathPaper->query('.//div[contains(@class, "authors")]')->item(0);

                if ($authorsElement) {
                    $personElements = $authorsElement->getElementsByTagName('span');
                    foreach ($personElements as $personElement) {
                        $personName = $personElement->nodeValue;
                        $personInstitution = $personElement->getAttribute('title');
                        $person[] = new Person($personName, $personInstitution);
                    }
                }

                /* RETURN OBJECT PAPER */
                $papers[] = new Paper($id, $title, $type, $person);
            }
            return $papers;
            
        } else {
            echo "Falha ao carregar DOMDocument.";
            return [];
        }
    }
}
