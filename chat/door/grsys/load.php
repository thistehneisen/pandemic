<?php if(!defined('s7V9pz')) {die();}?><?php
function gr_sys() {
    $arg = func_get_args();
    $uid = $GLOBALS["user"]['id'];
    if ($arg[0]['type'] === 'appearance' && gr_role('access', 'sys', '2')) {
        $css = db('Grupo', 's', 'customize');
        if (!empty($arg[0]['boxed'])) {
            db('Grupo', 'u', 'defaults', 'v2', 'type,v1', $arg[0]['boxed'], 'default', 'boxed');
        }
        if (!empty($arg[0]['sentalign'])) {
            db('Grupo', 'u', 'defaults', 'v2', 'type,v1', $arg[0]['sentalign'], 'default', 'sent_msg_align');
        }
        if (!empty($arg[0]['recievedalign'])) {
            db('Grupo', 'u', 'defaults', 'v2', 'type,v1', $arg[0]['recievedalign'], 'default', 'received_msg_align');
        }
        if (!empty($arg[0]['defont'])) {
            db('Grupo', 'u', 'defaults', 'v2', 'type,v1', $arg[0]['defont'], 'default', 'default_font');
        }
        foreach ($css as $c) {
            $key = 'css'.$c['id'];
            if ($c['type'] == 'background') {
                $a = $key.'a';
                $b = $key.'b';
                if (!empty($arg[0][$a]) && !empty($arg[0][$b])) {
                    db('Grupo', 'u', 'customize', 'v1,v2', 'id', $arg[0][$a], $arg[0][$b], $c['id']);
                }
            } else if ($c['name'] == 'custom_css') {
                db('Grupo', 'u', 'customize', 'element', 'id', $_POST['customcss'], $c['id']);
            } else {
                if (!empty($arg[0][$key]) && $arg[0][$key] != $c['v1']) {
                    db('Grupo', 'u', 'customize', 'v1', 'id', $arg[0][$key], $c['id']);
                }
            }

        }
        gr_cache('settings');
        unlink('gem/tone/custom.php');
        $ccontent = gr_customcss();
        $ccfile = fopen("gem/tone/custom.php", "w");
        fwrite($ccfile, $ccontent);
        fclose($ccfile);
        gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");');
        gr_prnt('window.location.href = "";');
    } else if ($arg[0]['type'] === 'easycustomizer' && gr_role('access', 'sys', '2')) {
        $css = db('Grupo', 's', 'customize', 'xtra', 'easyedit');
        if (!empty($arg[0]['startcolor']) && !empty($arg[0]['endcolor'])) {
            foreach ($css as $c) {
                if ($c['type'] == 'background') {
                    db('Grupo', 'u', 'customize', 'v1,v2', 'id', $arg[0]['startcolor'], $arg[0]['endcolor'], $c['id']);
                } else {
                    db('Grupo', 'u', 'customize', 'v1', 'id', $arg[0]['startcolor'], $c['id']);
                }
            }
        }
        unlink('gem/tone/custom.php');
        $ccontent = gr_customcss();
        $ccfile = fopen("gem/tone/custom.php", "w");
        fwrite($ccfile, $ccontent);
        fclose($ccfile);
        gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");');
        gr_prnt('window.location.href = "";');
    } else if ($arg[0]['type'] === 'hf' && gr_role('access', 'sys', '5')) {
        $hfile = fopen("gem/ore/grupo/cache/headers.cch", "w");
        fwrite($hfile, $_POST['headers']);
        fclose($hfile);
        $ffile = fopen("gem/ore/grupo/cache/footers.cch", "w");
        fwrite($ffile, $_POST['footers']);
        fclose($ffile);
        gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");');
        gr_prnt('window.location.href = "";');
    } else if ($arg[0]['type'] === 'banip') {
        if (gr_role('access', 'sys', '3')) {
            if (!empty($arg[0]['blist'])) {
                db('Grupo', 'u', 'defaults', 'v2', 'type', $arg[0]['blist'], 'blacklist');
                gr_cache('blacklist');
                gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");$(".grupo-pop").fadeOut();');
            }
        }
        exit;
    } else if ($arg[0]['type'] === 'filterwords') {
        if (gr_role('access', 'sys', '4')) {
            if (!empty($arg[0]['blist'])) {
                db('Grupo', 'u', 'defaults', 'v2', 'type', $arg[0]['blist'], 'filterwords');
                gr_cache('filterwords');
                gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");$(".grupo-pop").fadeOut();');
            }
        }
        exit;
    } else if ($arg[0]['type'] === 'settings') {
        if (gr_role('access', 'sys', '1')) {
            $sys = db('Grupo', 's', 'defaults', 'type,v1<>,v1<>', 'default', 'sent_msg_align', 'received_msg_align');
            foreach ($sys as $s) {
                $key = $s['id'];
                if (!empty($arg[0][$key]) && $arg[0][$key] != $s['v2'] || $s['v1'] == 'autogroupjoin') {
                    if ($s['v1'] == 'fileexpiry' || $s['v1'] == 'delmsgexpiry' || $s['v1'] == 'autodeletemsg' || $s['v1'] == 'max_msg_length') {
                        $arg[0][$key] = vc($arg[0][$key], 'num');
                        if (empty($arg[0][$key])) {
                            $arg[0][$key] = 'Off';
                        }
                    }
                    db('Grupo', 'u', 'defaults', 'v2', 'id', $arg[0][$key], $key);
                }
            }
            if (isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])) {
                if (flr('upload', 'logo', 'grupo/global/', 'logo', 'jpg,jpeg,png,gif', 1, 1, 'png', 1)) {
                    if (!is_array(getimagesize('gem/ore/grupo/global/logo.png'))) {
                        flr('delete', 'grupo/global/logo.png');
                    }
                }
            }
            if (isset($_FILES['sitelogo']['name']) && !empty($_FILES['sitelogo']['name'])) {
                if (flr('upload', 'sitelogo', 'grupo/global/', 'sitelogo', 'jpg,jpeg,png,gif', 1, 1, 'png', 1)) {
                    if (!is_array(getimagesize('gem/ore/grupo/global/sitelogo.png'))) {
                        flr('delete', 'grupo/global/sitelogo.png');
                    }
                }
            }
            if (isset($_FILES['mobilelogo']['name']) && !empty($_FILES['mobilelogo']['name'])) {
                if (flr('upload', 'mobilelogo', 'grupo/global/', 'mobilelogo', 'jpg,jpeg,png,gif', 1, 1, 'png', 1)) {
                    if (!is_array(getimagesize('gem/ore/grupo/global/mobilelogo.png'))) {
                        flr('delete', 'grupo/global/mobilelogo.png');
                    }
                }
            }
            if (isset($_FILES['welcome']['name']) && !empty($_FILES['welcome']['name'])) {
                if (flr('upload', 'welcome', 'grupo/global/', 'welcome', 'jpg,jpeg,png,gif', 1, 1, 'png', 1)) {
                    if (!is_array(getimagesize('gem/ore/grupo/global/welcome.png'))) {
                        flr('delete', 'grupo/global/welcome.png');
                    }
                }
            }
            if (isset($_FILES['emaillogo']['name']) && !empty($_FILES['emaillogo']['name'])) {
                if (flr('upload', 'emaillogo', 'grupo/global/', 'emaillogo', 'jpg,jpeg,png,gif', 1, 1, 'png', 1)) {
                    if (!is_array(getimagesize('gem/ore/grupo/global/emaillogo.png'))) {
                        flr('delete', 'grupo/global/emaillogo.png');
                    }
                }
            }
            if (isset($_FILES['defaultbg']['name']) && !empty($_FILES['defaultbg']['name'])) {
                if (flr('upload', 'defaultbg', 'grupo/global/', 'bg', 'jpg,jpeg,png,gif', 1, 1, 'jpg', 1)) {
                    if (@is_array(getimagesize('gem/ore/grupo/global/bg.jpg'))) {
                        flr('compress', 'grupo/global/bg.jpg', 50);
                    } else {
                        flr('delete', 'grupo/global/bg.jpg');
                    }
                }
            }
            if (isset($_FILES['loginbg']['name']) && !empty($_FILES['loginbg']['name'])) {
                if (flr('upload', 'loginbg', 'grupo/global/', 'login', 'jpg,jpeg,png,gif', 1, 1, 'jpg', 1)) {
                    if (@is_array(getimagesize('gem/ore/grupo/global/login.jpg'))) {
                        flr('compress', 'grupo/global/login.jpg', 50);
                    } else {
                        flr('delete', 'grupo/global/login.jpg');
                    }
                }
            }
            if (isset($_FILES['favicon']['name']) && !empty($_FILES['favicon']['name'])) {
                if (flr('upload', 'favicon', 'grupo/global/', 'favicon', 'jpg,jpeg,png,gif', 1, 1, 'png', 1)) {
                    if (!is_array(getimagesize('gem/ore/grupo/global/favicon.png'))) {
                        flr('delete', 'grupo/global/favicon.png');
                    }
                }
            }
            gr_cache('settings');
            unlink('gem/tone/customcss.php');
            $ccontent = file_get_contents(url().'custom.css');
            $ccfile = fopen("gem/tone/customcss.php", "w");
            fwrite($ccfile, $ccontent);
            fclose($ccfile);
            gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");');
            gr_prnt('window.location.href = "";');
        }
    }
}
function gr_customcss() {
    $css = db('Grupo', 's', 'customize', 'device,name<>', 'all', 'custom_css');
    $mobcss = db('Grupo', 's', 'customize', 'device,name<>', 'mobile', 'custom_css');
    $custm = db('Grupo', 's', 'customize', 'name', 'custom_css')[0]['element'];
    $sty = '';
    if ($GLOBALS["default"]["boxed"] == 'disable') {
        $sty .= '.swr-grupo > .window{ padding:0px;}.swr-grupo .aside{border-radius:0px;}body{background:none;}';
    }
    foreach ($css as $c) {
        $sty .= html_entity_decode($c['element'], ENT_QUOTES) . '{';
        if ($c['type'] == 'background') {
            $sty .= 'background: linear-gradient(to right,' . $c['v1'] . ',' . $c['v2'] . ');';
        } else if ($c['type'] == 'color' || $c['type'] == 'border-color' || $c['type'] == 'font-size') {
            if ($c['type'] == 'font-size') {
                $c['v1'] = $c['v1'].'px';
            }
            $sty .= $c['type'] . ':' . $c['v1'] . ';';
        }
        $sty .= '}';
    }

    $sty .= '@media (max-width: 767.98px){';
    foreach ($mobcss as $c) {
        $sty .= html_entity_decode($c['element'], ENT_QUOTES) . '{';
        if ($c['type'] == 'background') {
            $sty .= 'background: linear-gradient(to right,' . $c['v1'] . ',' . $c['v2'] . ');';
        } else if ($c['type'] == 'color' || $c['type'] == 'border-color' || $c['type'] == 'font-size') {
            if ($c['type'] == 'font-size') {
                $c['v1'] = $c['v1'].'px';
            }
            $sty .= $c['type'] . ':' . $c['v1'] . ';';
        }

        $sty .= '}';
    }
    $sty .= '}';
    $custm = html_entity_decode($custm, ENT_QUOTES);
    $custm = preg_replace('/<\\?.*(\\?>|$)/Us', '', $custm);
    $sty .= str_replace(">", ">", $custm);
    return $sty;
}
?>