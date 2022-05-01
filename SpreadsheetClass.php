<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SpreadsheetGenerator
{
    public $title;

    public function __construct($t = 'scrapping')
    {
        $this->title = $t;
    }

    public function generateNewsSheet($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Noticias');
        $sheet->setCellValue('A1', 'Noticia');
        $sheet->setCellValue('B1', 'Titulo');

        $styleArray = [

            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN,
                ],
            ],
        ];

        $sheet->getStyle('A:B')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A1')->applyFromArray($styleArray);
        $sheet->getStyle('B1')->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        for ($i = 0; $i < count($data); ++$i) {
            $sheet->setCellValue('A' . ($i + 2), $i + 1);
            $sheet->setCellValue('B' . ($i + 2), $data[$i]);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($this->title . '.xlsx');
    }
}
