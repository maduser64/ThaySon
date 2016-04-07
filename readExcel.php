<?php
//error_reporting(E_ALL);
set_time_limit(0);
date_default_timezone_set('Europe/London');

//session_start();
require_once __DIR__ . '/host.php';
require_once $ROOT . '/Classes/PHPExcel/IOFactory.php';

//$inputFileType = 'Excel5';
$inputFileType = 'Excel2007';
//	$inputFileType = 'Excel2003XML';
//	$inputFileType = 'OOCalc';
//	$inputFileType = 'Gnumeric';
$inputFileName = "Book1.xlsx";
$sheetname = 'Sheet1';

class MyReadFilter implements PHPExcel_Reader_IReadFilter {

    private $_startRow = 0;
    private $_endRow = 0;
    private $_columns = array();

    public function __construct($startRow, $endRow, $columns) {
        $this->_startRow = $startRow;
        $this->_endRow = $endRow;
        $this->_columns = $columns;
    }

    public function readCell($column, $row, $worksheetName = '') {
        if ($row >= $this->_startRow && $row <= $this->_endRow) {
            if (in_array($column, $this->_columns)) {
                return true;
            }
        }
        return false;
    }

}

function getListMemberFromExel($inputFileName) {
    $inputFileType = 'Excel2007';
//$inputFileName = "Book1.xlsx";
    $sheetname = 'Sheet1';

    $filterSubset = new MyReadFilter(2, 2, range('A', 'M'));
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objReader->setLoadSheetsOnly($sheetname);
    $objReader->setReadFilter($filterSubset);
    $objPHPExcel = $objReader->load($inputFileName);
//    echo '<hr />';
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    $count = sizeof($sheetData);
//var_dump($sheetData);
//    echo '<br>';
//    echo 'count: ' . $count . '<br>';
//    for ($i = 1; $i <= $count; $i++) {
//        for ($j = 'A'; $j <= 'M'; $j++) {
//            echo $sheetData[$i][$j] . ' ';
//        }
//        echo '<br>';
//    }
    return $sheetData;
}
?>