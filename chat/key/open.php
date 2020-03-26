<?php define('s7V9pz', TRUE); ?>
<?php
session_start();
include "bit.php";
date_default_timezone_set(cnf()["region"]);
include cnf()["door"]."/core/load.php";
load_knob();
?>