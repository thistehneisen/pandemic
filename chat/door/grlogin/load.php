<?php if(!defined('s7V9pz')) {die();}?><?php
$_SESSION['utrack'] = 'on';
function gr_register($do) {
    if (gr_usip('check')) {
        gr_prnt('say("'.gr_lang('get', 'ip_blocked').'","e");');
        exit;
    }
    $id = $_SESSION['facebook']['id'];
    gr_data('i', 'profile', 'name', $do["fname"], $id, $do["name"], gr_usrcolor());
    $grjoin = $GLOBALS["default"]['autogroupjoin'];
    if (!empty($grjoin)) {
        $cr = gr_group('valid', $grjoin);
        if ($cr[0]) {
            gr_data('i', 'gruser', $grjoin, $id, 0);
            $dt = array();
            $dt['id'] = $grjoin;
            $dt['msg'] = 'joined_group';
            gr_group('sendmsg', $dt, 1, 1, $id);
        }
    }
    usr('Grupo', 'forcelogin', $_SESSION['facebook']['id']);
    $_SESSION['grcreset'] = 1;
    gr_prnt('location.reload();');
}

function gr_login($do) {
    usr('Grupo', 'forcelogin', $_SESSION['facebook']['id']);
    return true;
    if (gr_usip('check')) {
        gr_prnt('say("'.gr_lang('get', 'ip_blocked').'","e");');
        exit;
    }
    if (!empty($_SESSION['facebook']['id'])) {
        $do['sign'] = preg_replace('/@.*/', '', $_SESSION['facebook']['id']);
        $nme = $usrn = $_SESSION['facebook']['id'];
        // if (usr('Grupo', 'exist', $usrn)) {
        //     gr_prnt('say("'.gr_lang('get', 'username_exists').'");');
        //     exit;
        // }
        $sign = rn(4).rn(3).'@'.rn(13).'.com';
        $pasw = rn(12);
        $reg = usr('Grupo', 'register', $usrn, $sign, $pasw, 5);
        if ($reg[0]) {
            $id = $reg[1];
            if ($id === false)
                usr('Grupo', 'forcelogin', $usrn);
            else {
                gr_data('i', 'profile', 'name', $nme, $id, $usrn, gr_usrcolor());
                $grjoin = $GLOBALS["default"]['autogroupjoin'];
                if (!empty($grjoin)) {
                    $cr = gr_group('valid', $grjoin);
                    if ($cr[0]) {
                        gr_data('i', 'gruser', $grjoin, $id, 0);
                        $dt = array();
                        $dt['id'] = $grjoin;
                        $dt['msg'] = 'joined_group';
                        gr_group('sendmsg', $dt, 1, 1, $id);
                    }
                }
                usr('Grupo', 'forcelogin', $usrn);
            }
        } else usr('Grupo', 'forcelogin', $usrn);
        $_SESSION['grcreset'] = 1;
        //gr_prnt('window.location.href = "";');
        //exit;
    }
}
