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

    $xpath = new DOMXPath($this->dom);

    /*GET TITLE
    */ 
    $titleElement = $xpath->query('//h4[contains(@class, "my-xs paper-title")]')->item(0);
    if ($titleElement) {
        $title = $titleElement->nodeValue;
    } else {
        $title = 'Sem Informações de titulo';
    }

    /*GET TYPE
    */ 
    $typeElement = $xpath->query('//div[contains(@class, "tags mr-sm")]')->item(0);
    if ($typeElement) {
      $type = $typeElement->nodeValue;
    } else {
      $type = 'Tipo não encontradas';
    }

    /*GET ID
    */ 
    $idElement = $xpath->query('//div[contains(@class, "volume-info")]')->item(0);
    if ($idElement) {
      $id = $idElement->nodeValue;
    } else {
      $id = 'ID não encontradas';
    }

    /*GET PERSON
    */
    $person = [];

    $authorsElement = $xpath->query('//div[contains(@class, "authors")]')->item(0);
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
    return [
      new Paper(
        $id,
        $title,
        $type,
        $person,
      ),
    ];
  }

}
