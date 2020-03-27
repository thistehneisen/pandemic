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
fc('gr_register');
gr_register(['id' => $_SESSION['facebook']['id']]);
fc('gr_login');
gr_login(['id' => $_SESSION['facebook']['id']]);

header('Location: #');
?>
<script>window.location.reload();</script>