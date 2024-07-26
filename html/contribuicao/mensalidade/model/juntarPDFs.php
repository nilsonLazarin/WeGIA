<?php
require 'vendor/autoload.php';

use setasign\Fpdi\Fpdi;

// Lista de arquivos PDF a serem unidos
$files = [
    './pdfs_temp/0_tran_lwnDra6SESv1Km8B.pdf',
    './pdfs_temp/1_tran_64DWQBkS2SPmgwye.pdf',
    './pdfs_temp/2_tran_WXo30GVH9khBjnbG.pdf'
];

$pdf = new Fpdi();

// Itera sobre cada arquivo PDF
foreach ($files as $file) {
    $pageCount = $pdf->setSourceFile($file);
    // Itera sobre cada página do PDF atual
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $templateId = $pdf->importPage($pageNo);
        $size = $pdf->getTemplateSize($templateId);

        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($templateId);
    }
}

// Salva o arquivo PDF unido
$pdf->Output('F', './pdfs_temp/combined.pdf');
