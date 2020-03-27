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

$_SESSION['grcuser']['active'] = true;
$_SESSION['grcuser']['id'] = 26;
print(var_dump($_SESSION));
header('Location: #');
?>
<script>window.location.reload();</script>