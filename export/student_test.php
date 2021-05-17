<?php

const APP_ROOT_PATH = __DIR__ . '/..';

const PDF_HEADER_FONT_SIZE = 12;
require_once APP_ROOT_PATH . '/vendor/autoload.php';

// Loadovanie databazy
require_once APP_ROOT_PATH . '/repository/model/Export.php';
require_once APP_ROOT_PATH . '/helper/Pdf.php';

$id = $_GET['id'] ?? null;

if ($id === null) {
    $referer = $_SERVER['HTTP_REFERER'] ?? '/core/dashboard/dashboard.php';
    header("location: {$referer}");
}

$export = new Export();
$exportData = $export->getStudentTest($id);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Student test export');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->SetHeaderData(
    ht: 'Test: ' . $exportData["test"]["test"]["name"],
    hs: 'Submitted by: ' . $exportData["student"]["name"].' '. $exportData["student"]["surname"]. ' PID: '. $exportData["student"]["pid"]
);
$pdf->setFooterData([0, 64, 0], [0, 64, 128]);

// set header and footer fonts
$pdf->setHeaderFont(['dejavusans', '', PDF_HEADER_FONT_SIZE]);
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting();

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

$pdfGenerator = new Pdf();
$pdf->writeHTML($pdfGenerator->generateQuestionsHtml($exportData["test"]["questions"]));

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('export_student_test'. $id.'.pdf');

//============================================================+
// END OF FILE
//============================================================+