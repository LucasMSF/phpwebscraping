<?php
require('SpreadsheetClass.php');

$content = file_get_contents('https://www.band.uol.com.br/noticias');

$domDocument = new DOMDocument();
@$domDocument->loadHTML($content);

$titleList = $domDocument->getElementsByTagName('h2');

$news = [];

foreach ($titleList as $title) {
    if(strpos(@$title->getAttribute('class'), 'title') === 0) {
        array_push($news, $title->nodeValue);
    }
}

$sheet = new SpreadsheetGenerator('Web-Scrapping');
$sheet->generateNewsSheet($news);

echo "Planilha gerada com sucesso!";


