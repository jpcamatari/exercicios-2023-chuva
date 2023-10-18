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

    $titleElement = $xpath->query('//h4[contains(@class, "my-xs paper-title")]')->item(0);
    if ($titleElement) {
        $title = $titleElement->nodeValue;
    } else {
        $title = 'Sem Informações de titulo';
    }

    return [
      new Paper(
        123,
        'The Nobel Prize in Physiology or Medicine 2023',
        'Nobel Prize',
        [
          new Person('Katalin Karikó', 'Szeged University'),
          new Person('Drew Weissman', 'University of Pennsylvania'),
        ]
      ),
    ];
  }

}
