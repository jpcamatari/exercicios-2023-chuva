<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

/*DEBUG
$dom = new \DOMDocument('1.0', 'utf-8');
$dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

#print_r ($dom); ****CHEGOU***
*/

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  /**
   * Loads paper information from the HTML and returns the array with the data.
   */
  public function scrap(\DOMDocument $dom): array {
    $xpath = new \DOMXPath($dom);
    $paperElements = $xpath->query('//a[contains(@class, "paper-card")]');
    $papers = [];
    var_dump($xpath);
    

    foreach ($paperElements as $paperElement) {
        /*GET TITLE
        */
        $titleElement = $xpath->query('.//h4[contains(@class, "my-xs paper-title")]', $paperElement)->item(0);
        $title = $titleElement ? $titleElement->nodeValue : 'Sem Informações de título';

        /*GET TYPE
        */
        $typeElement = $xpath->query('.//div[contains(@class, "tags mr-sm")]', $paperElement)->item(0);
        $type = $typeElement ? $typeElement->nodeValue : 'Tipo não encontrada';

        /*GET ID
        */
        $idElement = $xpath->query('.//div[contains(@class, "volume-info")]', $paperElement)->item(0);
        $id = $idElement ? $idElement->nodeValue : 'ID não encontrada';

        /*GET PERSON
        */
        $person = [];
        $authorsElement = $xpath->query('.//div[contains(@class, "authors")]', $paperElement)->item(0);
        
        if ($authorsElement) {
            $personElements = $authorsElement->getElementsByTagName('span');
            foreach ($personElements as $personElement) {
                $personName = $personElement->nodeValue;
                $personInstitution = $personElement->getAttribute('title');
                $person[] = new Person($personName, $personInstitution);
            }
        }

        /*RETURN OBJECT PAPER
        */
        $papers[] = new Paper($id, $title, $type, $person);
    }
    #print_r ($papers);
    return $papers;
  }
}



