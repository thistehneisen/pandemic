<?php if(!defined('s7V9pz')) {die();}?><?php
fc('grupo');
usr('Grupo', 'remember');
if ($GLOBALS["logged"]) {
    if (isset($_POST["do"])) {
        gec('location.reload();');
    } else {
        rt('');
    }
}
grupofns();
?>
