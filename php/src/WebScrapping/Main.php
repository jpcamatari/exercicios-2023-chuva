<?php

namespace Chuva\Php\WebScrapping;
require_once __DIR__ . '/../../vendor/box/spout/src/Spout/Autoloader/autoload.php';

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
    $htmlFile = file_get_contents(__DIR__ . '/../../assets/origin.html');
    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTML($htmlFile);

    $data = (new Scrapper())->scrap($dom);
    print_r($data);
    
    // Write your logic to save the output file bellow.
    $writer = WriterEntityFactory::createXLSXWriter();
    $fileOutput = (__DIR__ . '/../../assets/output.xlsx');
    $writer->openToFile($fileOutput); 

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
           ->setFontColor(Color::BLACK)
           ->build();

    $rowIndex = WriterEntityFactory::createRow($cells, $styleIndex);
    $rows = array();
    $rows[] = $rowIndex;

    $writer->addRow($rowIndex);
    

    /*CREATE ROWS PAPERS
    */
    if ($data !== null && is_array($data)) {
      foreach ($data as $paper) {
        $rowData = [
          $paper->id,
          $paper->title,
          $paper->type,
        ];
        
        foreach ($paper->authors as $author) {
          $rowData[] = $author->name;
          $rowData[] = $author->institution;
        }
        $row = WriterEntityFactory::createRowFromArray($rowData);
        $rows[] = $row;

        $writer->addRow($row);
      }
    }
    else {
      echo ("valores nulos");
    }
    $writer->close();
  }
}


