<?php

// Inclua a definição da classe Scrapper, das classes Paper e Person, se necessário.
require 'Scrapper.php';
require 'Entity/Paper.php';
require 'Entity/Person.php';

// Crie uma instância da classe Scrapper
$scrapper = new Scrapper();

// Carregue o conteúdo HTML (substitua 'seu_arquivo.html' pelo caminho do seu arquivo HTML)
$dom = new DOMDocument();
$dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

// Chame a função scrap para obter a array de papers
$papersArray = $scrapper->scrap($dom);

// Agora você pode acessar os objetos Paper e suas informações
foreach ($papersArray as $paper) {
    echo 'Título: ' . $paper->getTitle() . '<br>';
    echo 'Tipo: ' . $paper->getType() . '<br>';
    echo 'ID: ' . $paper->getId() . '<br>';

    $authors = $paper->getAuthors();
    echo 'Autores:<br>';
    foreach ($authors as $author) {
        echo 'Nome: ' . $author->getName() . '<br>';
        echo 'Instituição: ' . $author->getInstitution() . '<br>';
    }

    echo '<br>';
}

?>