<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Noticias');
$sheet->setCellValue('A1', 'Noticia');
$sheet->setCellValue('B1', 'Titulo');

$bold = [
    'font' => [
        'bold' => true
    ]
];

$sheet->getStyle('A1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);

$sheet->getStyle('B1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);

$sheet->getStyle('A:B')->getAlignment()->setHorizontal('center');

$sheet->getStyle('A1')->applyFromArray($bold);
$sheet->getStyle('B1')->applyFromArray($bold);

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);

for($i = 0; $i < count($news); ++$i) {
    $sheet->setCellValue('A' . ($i + 2), $i + 1);    
    $sheet->setCellValue('B' . ($i + 2), $news[$i]);    
}

$writer = new Xlsx($spreadsheet);
$writer->save('scrapping.xlsx');

echo "Planilha gerada com sucesso!";


