<?php if(!defined('s7V9pz')) {die();}?><?php
if (!file_exists('knob/install.php')) {
    if (!isset($_SESSION["grctime"])) {
        $_SESSION["grctime"] = 00;
    }
    $crest = db('Grupo', 's,count(id)', 'logs', 'type,v1>', 'cache', $_SESSION["grctime"])[0][0];
    if ($crest > 0) {
        $_SESSION['grcreset'] = 1;
    }
    if (isset($_SESSION['grcreset']) && $_SESSION['grcreset'] == 1) {
        unset($_SESSION["grcreset"]);
        unset($_SESSION["grctime"]);
        unset($_SESSION["grclang"]);
        unset($_SESSION['grcdefaults']);
        unset($_SESSION['grcuser']);
        unset($_SESSION["grcroles"]);
        unset($_SESSION["grclang"]);
    }
    if (!isset($_SESSION['grctime'])) {
        $_SESSION['grctime'] = strtotime(dt());
    }
    if (isset($_SESSION['grcdefaults'])) {
        $GLOBALS["default"] = $_SESSION['grcdefaults'];
    } else {
        $GLOBALS["default"] = $_SESSION['grcdefaults'] = gr_default('var');
    }
    $GLOBALS["roles"] = $GLOBALS["logged"] = false;
    if (isset($_SESSION['grcuser'])) {
        $GLOBALS["user"] = $_SESSION['grcuser'];
        if ($GLOBALS["user"]['active']) {
            $GLOBALS["logged"] = true;
            $GLOBALS["roles"] = $_SESSION['grcroles'];
        }
    } else {
        $GLOBALS["user"] = $_SESSION['grcuser'] = usr('Grupo');
        if ($GLOBALS["user"]['active']) {
            $GLOBALS["logged"] = true;
            $GLOBALS["roles"] = $_SESSION['grcroles'] = gr_role('var');
        }
    }
    if (isset($_SESSION['grclang'])) {
        $GLOBALS["lang"] = $_SESSION['grclang'];
    } else {
        $GLOBALS["lang"] = $_SESSION['grclang'] = gr_lang('var');
    }
}
?>