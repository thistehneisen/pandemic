<?php
require_once './vendor/autoload.php';
use \League\Csv\Reader;

if (!isset($_GET['action']) && empty($_GET['action'])) {
    if (!ini_get("auto_detect_line_endings")) {
        ini_set("auto_detect_line_endings", '1');
    }

    $csv = Reader::createFromPath(dirname(__FILE__) . '/data.csv', 'r');
    $csv->setHeaderOffset(0);

    header('Content-Type: application/json');
    echo json_encode($csv, JSON_PRETTY_PRINT);
} else if ($_GET['action'] == 'stats') {
    $contents = file_get_contents('https://pomber.github.io/covid19/timeseries.json');
    $contents = json_decode($contents, true);
    $contents = $contents['Latvia'];
    var_dump(end($contents));
}