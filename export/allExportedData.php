<?php
const APP_ROOT_PATH = __DIR__ . '/..';

require_once APP_ROOT_PATH . '/vendor/autoload.php';

// Loadovanie databazy
require_once APP_ROOT_PATH . '/repository/model/Export.php';
require_once APP_ROOT_PATH . '/helper/Csv.php';

$export = new Export();
$id = $_GET['id'] ?? null;


if ($id === null) {
    $referer = $_SERVER['HTTP_REFERER'] ?? '/core/dashboard/dashboard.php';
    header("location: {$referer}");
}



$exportedData = $export->findStudentsByTestId($id);
$maxPoints = $export->getMaxPointsByTestId($id);


$filename = 'file.csv';
// tell the browser it's going to be a csv file
header("Content-Type: application/csv; charset=utf-8");
// tell the browser we want to save it instead of displaying it
header('Content-Disposition: attachment; filename="'.$filename.'";');
echo "\xEF\xBB\xBF";  // BOM header UTF-8


$name = tempnam('/tmp', 'csv');
$fp = fopen($name, 'r+');

$header = array_keys($exportedData[0]);
fputcsv($fp, $header);


foreach ($exportedData as $fields) {
    fputcsv($fp, $fields);
}


rewind($fp);
fpassthru($fp);



fclose($fp);

