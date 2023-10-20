<?php

namespace Chuva\Php\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;


/**
 * Runner for the Webscrapping exercice.
 */
class Main {

  /**
   * Main runner, instantiates a Scrapper and runs.
   */
  public static function run(): void {
    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

    $data = (new Scrapper())->scrap($dom);

    // Write your logic to save the output file bellow.
    $writer = WriterEntityFactory::createXLSXWriter();
    $filePatch = (__DIR__ . '/../../assets/output.xlsx');
    $writer->openToFile($filePath); 

    /*CREATE A INDEX
    */
    $cells = [
    WriterEntityFactory::createCell('ID'),
    WriterEntityFactory::createCell('Title'),
    WriterEntityFactory::createCell('Type'),
    WriterEntityFactory::createCell('Author 1'),
    WriterEntityFactory::createCell('Author 1 Institution'),
    WriterEntityFactory::createCell('Author 2'),
    WriterEntityFactory::createCell('Author 2 Institution'),
    WriterEntityFactory::createCell('Author 3'),
    WriterEntityFactory::createCell('Author 3 Institution'),
    WriterEntityFactory::createCell('Author 4'),
    WriterEntityFactory::createCell('Author 4 Institution'),
    WriterEntityFactory::createCell('Author 5'),
    WriterEntityFactory::createCell('Author 5 Institution'),
    WriterEntityFactory::createCell('Author 6'),
    WriterEntityFactory::createCell('Author 6 Institution'),
    WriterEntityFactory::createCell('Author 7'),
    WriterEntityFactory::createCell('Author 7 Institution'),
    WriterEntityFactory::createCell('Author 8'),
    WriterEntityFactory::createCell('Author 8 Institution'),
    WriterEntityFactory::createCell('Author 9'),
    WriterEntityFactory::createCell('Author 9 Institution'),
    ];

    $styleIndex = (new StyleBuilder())
           ->setFontBold()
           ->setFontColor(Color::BLUE)
           ->build();

    $rowIndex = WriterEntityFactory::createRowFromArray($cells, $style);
    
    /*CREATE ROWS PAPERS
    */
    $table = [];
    $table[] = $rowIndex;

    foreach ($data as $paper) {
      $rowsPapers = WriterEntityFactory::createRowFromArray($data); 
    }
    $table[] = $rowsPapers;
    $writer->addRow($rowFromValues);
    $writer->close();
    
    
    

    print_r($data);
  }

}
