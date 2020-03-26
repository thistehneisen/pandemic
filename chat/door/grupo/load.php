<?php if(!defined('s7V9pz')) {die();}?><?php
fc('guard', 'db', 'user', 'dir', 'grglobals');
function grupofns() {
    $do = get();
    if (file_exists('knob/install.php')) {
        fc('grinstall');
        gr_install($do);
    } else {
        gr_iplook();
    }
    if (isset($do["act"])) {
        if (!$GLOBALS["logged"]) {
            fc('grlogin');
            if ($do["do"] == "login") {
                gr_login($do);
            } else if ($do["do"] == "register") {
                gr_register($do);
            } else if ($do["do"] == "forgot") {
                gr_forgot($do);
            } else if ($do["do"] == "terms") {
                gr_prnt(nl2br($GLOBALS["lang"]['terms']));
            } else if ($do["do"] == "language") {
                gr_lang($do);
            }
        } else {
            if ($do["do"] == "list") {
                fc('grlist');
                gr_list($do);
            } else if ($do["do"] == "form") {
                fc('grform');
                gr_form($do);
            } else if ($do["do"] == "love") {
                fc('grlove');
                gr_love($do);
            } else if ($do["do"] == "profile") {
                gr_profile($do);
            } else if ($do["do"] == "create") {
                fc('grcreate');
                gr_create($do['type'], $do);
            } else if ($do["do"] == "edit") {
                fc('gredit');
                gr_edit($do['type'], $do);
            } else if ($do["do"] == "group") {
                gr_group($do['type'], $do);
            } else if ($do["do"] == "logout") {
                gr_profile('ustatus', 'offline');
                usr('Grupo', 'logout');
                $_SESSION['grcreset'] = 1;
                gr_prnt('window.location.href = "";');
            } else if ($do["do"] == "files") {
                fc('grfiles');
                gr_files($do);
            } else if ($do["do"] == "role") {
                gr_role($do);
            } else if ($do["do"] == "language") {
                gr_lang($do);
            } else if ($do["do"] == "system") {
                fc('grsys');
                gr_sys($do);
            } else if ($do["do"] == "liveupdate") {
                fc('grlive');
                gr_live($do);
            } else if ($do["do"] == "customfield") {
                gr_customfield($do);
            } else if ($do["do"] == "alert") {
                gr_alerts($do);
            }
        }
        exit;
    }
}
function gr_unverified() {
    $uid = $GLOBALS["user"]['id'];
    $role = usr('Grupo', 'select', $uid)['role'];
    if ($role == '1') {
        gr_profile('ustatus', 'offline');
        $_SESSION['grcreset'] = 1;
        usr('Grupo', 'logout', $uid);
        rt('signin/unverified');
    } else if ($role == '4') {
        gr_profile('ustatus', 'offline');
        $_SESSION['grcreset'] = 1;
        usr('Grupo', 'logout', $uid);
        rt('banned');
    }
}
function gr_usrcolor() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));;
}
function gr_reactprof() {
    $uid = $GLOBALS["user"]['id'];
    $dect = db('Grupo', 's', 'options', 'type,v1,v3', 'deaccount', 'yes', $uid);
    if ($dect && count($dect) > 0) {
        db('Grupo', 'd', 'options', 'type,v1,v3', 'deaccount', 'yes', $uid);
        gr_prnt('<script>$(window).load(function() {say("'.$GLOBALS["lang"]['account_reactivated'].'","s");});</script>');
    }
}
function gr_cbg() {
    $uid = $GLOBALS["user"]['id'];
    $bg = gr_img('userbg', $uid);
    if (!empty($bg)) {
        gr_prnt('<style>');
        gr_prnt('body{background: url("'.$bg.'"); background-size: cover; background-position: center;}');
        gr_prnt('</style>');
    }
}
function gr_img() {
    $arg = vc(func_get_args());
    if ($arg[0] == 'userbg') {
        $r = 0;
    } else {
        $r = "gem/ore/grupo/".$arg[0]."/default.png";
    }
    $img = glob("gem/ore/grupo/".$arg[0]."/".$arg[1]."-gr-*.*");
    if (count($img) > 0) {
        $r = $img[0];
    }
    return $r;
}
function gr_tmz() {
    $tzo = "Auto";
    $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    foreach ($tzlist as $tz) {
        if (empty($tzo)) {
            $tzo = $tz;
        } else {
            $tzo = $tzo.','.$tz;
        }
    }
    return $tzo;
}
function gr_role() {
    $uid = $GLOBALS["user"]['id'];
    $arg = func_get_args();
    if ($arg[0] === 'access') {
        $rs = false;
        $type = $arg[1];
        $key = $arg[2];
        if (isset($GLOBALS["roles"][$type][$key])) {
            $rs = true;
        }
        return $rs;
    } else if ($arg[0] === 'var') {
        $r = false;
        if (isset($arg[1])) {
            $uid = $arg[1];
        }
        $role = usr('Grupo', 'select', $uid)['role'];
        $file = 'gem/ore/grupo/cache/roles.cch';
        $rs = array();
        $r = file_get_contents($file);
        $r = json_decode($r);
        $r = $r->$role;
        foreach ($r as $key => $ky) {
            foreach ($ky as $kz => $kw) {
                $rs[$key][$kz] = true;
            }
        }
        return $rs;
    } else if ($arg[0]['type'] === 'delete') {
        if ($arg[0]['id'] == 1 || $arg[0]['id'] == 2 || $arg[0]['id'] == 3 || $arg[0]['id'] == 4 || $arg[0]['id'] == 5) {
            gr_prnt('say("'.$GLOBALS["lang"]['deny_default_role'].'","e");');
        } else {
            if (!gr_role('access', 'roles', '2')) {
                exit;
            }
            db('Grupo', 'u', 'users', 'role', 'role', 3, $arg[0]['id']);
            db('Grupo', 'd', 'permissions', 'id', $arg[0]['id']);
            foreach (glob("gem/ore/grupo/roles/".$arg[0]['id']."-gr-*.*") as $filename) {
                unlink($filename);
            }
            gr_cache('roles');
            gr_prnt('say("'.$GLOBALS["lang"]['deleted'].'","s");menuclick("mmenu","roles");');
            gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
        }
    }
}
function gr_noswear($text) {
    $file = 'gem/ore/grupo/cache/filterwords.cch';
    $bw = file_get_contents($file);
    $bw = json_decode($bw);
    foreach ($bw as $w) {
        $w = trim($w);
        $cw = str_repeat("*", strlen($w));
        if (preg_match('/[^a-zA-Z]+/', $w)) {
            $text = str_replace($w, $cw, $text);
        } else {
            $text = preg_replace("/\b".$w."\b/", $cw, $text);
        }
    }
    return $text;
}

function gr_cronjob() {
    fc('grfiles');
    autodelgrmsgs();
    gr_autoroleopts();
    gr_pendmail();
    $exp['type'] = 'expired';
    gr_files($exp);
}
function autodelgrmsgs() {
    $r = db('Grupo', 's', 'msgs', 'cat,type<>,type<>', 'group', 'system', 'like', 'ORDER BY id DESC');
    $delmsgt = vc($GLOBALS["default"]['autodeletemsg'], 'num');
    foreach ($r as $v) {
        if (!empty($delmsgt)) {
            if (strtotime('now') > strtotime('+'.$delmsgt.' minutes', strtotime($v['tms']))) {
                $dt['id'] = $v['gid'];
                $dt['mid'] = $v['id'];
                $dt["ldt"] = 'group';
                gr_group('deletemsg', $dt, 'force');
            }
        }
    }
}
function gr_autoroleopts() {
    $rs = db('Grupo', 's', 'permissions');
    foreach ($rs as $r) {
        $adel = vc($r['autodel'], "num");
        $unj = vc($r['autounjoin'], "num");
        if (!empty($adel) || !empty($unj)) {
            $ur = db('Grupo', 's', 'users', 'role', $r['id']);
            foreach ($ur as $u) {
                if (!empty($unj)) {
                    $cgrp = db('Grupo', 's', 'options', 'type,v2', 'gruser', $u['id']);
                    foreach ($cgrp as $grp) {
                        if (strtotime('now') > strtotime('+'.$unj.' minutes', strtotime($grp['tms']))) {
                            $lg["id"] = $grp['v1'];
                            gr_group("leave", $lg, $u['id']);
                        }
                    }
                }
                if (!empty($adel)) {
                    if (strtotime('now') > strtotime('+'.$adel.' minutes', strtotime($u['created']))) {
                        $rn['type'] = 'act';
                        $rn['opted'] = 'delete';
                        $rn["id"] = $u['id'];
                        $rn["nomsgz"] = 1;
                        gr_profile($rn);
                    }
                }

            }
        }
    }
}
function gr_customfield() {
    $uid = $GLOBALS["user"]['id'];
    $arg = func_get_args();
    if ($arg[0]['type'] === 'delete') {
        if (gr_role('access', 'fields', '3')) {
            $oldfield = db('Grupo', 's', 'profiles', 'type,id', 'field', $arg[0]['id']);
            if (!empty($arg[0]['id']) && count($oldfield) > 0) {
                $r = db('Grupo', 'd', 'profiles', 'type,id', 'field', $arg[0]['id']);
                $dlng = db('Grupo', 's', 'phrases', 'type', 'lang');
                foreach ($dlng as $dl) {
                    db('Grupo', 'd', 'phrases', 'type,short', 'phrase', $oldfield[0]['name']);
                    gr_cache('languages', $dl['id']);
                }
                gr_prnt('say("'.$GLOBALS["lang"]['deleted'].'","s");menuclick("mmenu","ufields");$(".grupo-pop").fadeOut();');
            } else {
                gr_prnt('say("'.$GLOBALS["lang"]['invalid_value'].'");');
            }
        }
    }

}
function gr_profile() {
    $uid = $GLOBALS["user"]['id'];
    $arg = func_get_args();

    if ($arg[0] === 'get') {
        $r = $GLOBALS["lang"]['unknown'];
        if ($arg[2] === 'tmz') {
            $r = $GLOBALS["default"]['timezone'];
        } else if ($arg[2] === 'language') {
            $r = $GLOBALS["default"]['language'];
        } else if ($arg[2] === 'alert') {
            $r = $GLOBALS["default"]['alert'];
        } else if ($arg[2] === 'status') {
            $r = 'offline';
        }
        if (isset($arg[3])) {
            $r = $arg[3];
        }
        $cr = db('Grupo', 's', 'options', 'type,v1,v3', 'profile', $arg[2], $arg[1]);
        if ($cr && count($cr) > 0) {
            $r = $cr[0]['v2'];
            if ($arg[2] === 'status' && $r === 'invisible') {
                $r = 'offline';
            }
            if ($arg[2] === 'status' && $r === 'online' || $r === 'idle') {
                $idle = strtotime(dt()) - strtotime($cr[0]['tms']);
                $idle = round(abs($idle) / 60);
                $statz = $r;
                if ($idle > 60) {
                    $statz = 'offline';
                    gr_profile('ustatus', 'offline', $arg[1]);
                } else if ($idle > 20 && $r !== 'idle') {
                    $statz = 'idle';
                    gr_profile('ustatus', 'idle', $arg[1]);
                }
                $r = $statz;
            }
        }
        if ($arg[2] == 'tmz' && $r == 'Auto' && !isset($arg[3])) {
            $r = db('Grupo', 's', 'options', 'type,v1,v3', 'profile', 'autotmz', $arg[1])[0]['v2'];
        }
        return $r;
    } else if ($arg[0] === 'blocked') {
        $r[0] = false;
        $r[1] = 'you';
        $chkblocked = db('Grupo', 's,count(*)', 'options', 'type,v1,v2', 'pblock', $uid, $arg[1])[0][0];
        $byu = db('Grupo', 's,count(*)', 'options', 'type,v2,v1', 'pblock', $uid, $arg[1])[0][0];
        if ($byu > 0 && $chkblocked == 0) {
            $r[1] = 'other';
        }
        $chkblocked = $chkblocked+$byu;
        if ($chkblocked > 0) {
            $r[0] = true;
        }
        return $r;
    } else if ($arg[0] === 'mode') {
        if (gr_profile('get', $uid, 'status') === 'offline') {
            pr($GLOBALS["lang"]['go_online']);
        } else {
            pr($GLOBALS["lang"]['go_offline']);
        }

    } else if ($arg[0] === 'ustatus') {
        if (!empty($arg[1]) && !empty($uid)) {
            if (isset($arg[2])) {
                $uid = $arg[2];
            }
            if ($arg[1] == 'offline' || $arg[1] == 'idle') {
                db('Grupo', 'u', 'logs', 'v3', 'type,v1', 0, 'browsing', $uid);
            }
            $ct = db('Grupo', 's', 'options', 'type,v1,v3', 'profile', 'status', $uid);
            if ($ct && count($ct) > 0) {
                if ($ct[0]['v2'] !== 'invisible' || isset($arg[2])) {
                    gr_data('u', 'v2', 'type,v1,v3', $arg[1], 'profile', 'status', $uid);
                }
            } else {
                gr_data('i', 'profile', 'status', $arg[1], $uid);
            }
        }
    } else if ($arg[0]['type'] === 'block') {
        $ct = db('Grupo', 's,count(*)', 'options', 'type,v1,v2', 'pblock', $uid, $arg[0]["id"])[0][0];
        if ($ct > 0) {
            db('Grupo', 'd', 'options', 'type,v1,v2', 'pblock', $uid, $arg[0]["id"]);
            gr_prnt('say("'.$GLOBALS["lang"]['unblocked'].'","s");');
        } else {
            db('Grupo', 'i', 'options', 'type,v1,v2', 'pblock', $uid, $arg[0]["id"]);
            gr_prnt('say("'.$GLOBALS["lang"]['blocked'].'","e");');
        }
        gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
        gr_prnt('window.location.href = "";');
    } else if ($arg[0]['type'] === 'autotimezone') {
        gr_autotms($arg[0]['offset']);
    } else if ($arg[0]['type'] === 'mode') {
        $ct = db('Grupo', 's', 'options', 'type,v1,v3', 'profile', 'status', $uid);
        if ($ct && count($ct) > 0) {
            $s = 'invisible';
            if ($ct[0]['v2'] === 'invisible') {
                $s = 'online';
            }
            gr_data('u', 'v2', 'type,v1,v3', $s, 'profile', 'status', $uid);
            gr_prnt('window.location.href = "";');
        }
    } else if ($arg[0]['type'] === 'act' && $arg[0]['opted'] === 'delete') {
        if (!gr_role('access', 'users', '3') && !isset($arg[0]['nomsgz'])) {
            exit;
        }
        if ($uid !== $arg[0]['id'] || isset($arg[0]['nomsgz'])) {
            $r = db('Grupo', 's,count(*)', 'users', 'id', $arg[0]["id"])[0][0];
            if ($r > 0) {
                usr('Grupo', 'delete', $arg[0]['id']);
                gr_data('d', 'type,v3', 'profile', $arg[0]["id"]);
                gr_data('d', 'type,v2', 'lview', $arg[0]["id"]);
                gr_data('d', 'type,v2', 'gruser', $arg[0]["id"]);
                db('Grupo', 'd', 'msgs', 'uid,type', $arg[0]["id"], 'msg');
                db('Grupo', 'd', 'msgs', 'uid,type', $arg[0]["id"], 'file');
                db('Grupo', 'd', 'msgs', 'uid,type', $arg[0]["id"], 'system');
                db('Grupo', 'd', 'alerts', 'uid', $arg[0]["id"]);
                db('Grupo', 'd', 'options', 'type,v2', 'loves', $arg[0]["id"]);
                db('Grupo', 'd', 'profile', 'type,uid', 'profile', $arg[0]["id"]);
                db('Grupo', 'd', 'alerts', 'v3', $arg[0]["id"]);
                db('Grupo', 'd', 'options', 'type,v3', 'deaccount', $arg[0]["id"]);
                foreach (glob("gem/ore/grupo/users/".$arg[0]['id']."-gr-*.*") as $filename) {
                    unlink($filename);
                }
                foreach (glob("gem/ore/grupo/coverpic/users/".$arg[0]['id']."-gr-*.*") as $filename) {
                    unlink($filename);
                }
                foreach (glob("gem/ore/grupo/audiomsgs/".$arg[0]['id']."-gr-*.*") as $filename) {
                    unlink($filename);
                }
                flr('delete', 'grupo/files/'.$arg[0]['id']);
                $usz = $arg[0]['id'];
                $delvac = db('Grupo', 's', 'users');
                foreach ($delvac as $lvu) {
                    if ($usz != $lvu['id']) {
                        $delvw = $usz.'-'.$lvu['id'];
                        if ($usz > $lvu['id']) {
                            $delvw = $lvu['id'].'-'.$usz;
                        }
                        gr_data('d', 'type,v1', 'lview', $delvw);
                        db('Grupo', 'd', 'msgs', 'cat,gid', 'user', $delvw);
                    }
                }
                if (!isset($arg[0]['nomsgz'])) {
                    gr_prnt('say("'.$GLOBALS["lang"]['deleted'].'","s");menuclick("mmenu","users");');
                    gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
                }
                $_SESSION['grcreset'] = 1;
                db('Grupo', 'u', 'logs', 'v1', 'type', strtotime(dt()), 'cache');
            }
        }
    } else if ($arg[0]['type'] === 'act' && $arg[0]['opted'] === 'banip') {
        if (!gr_role('access', 'sys', '3')) {
            exit;
        }
        if ($uid !== $arg[0]['id']) {
            $bl = db('Grupo', 's', 'defaults', 'type', 'blacklist')[0]['v2'];
            $uip = db('Grupo', 's,ip', 'utrack', 'uid', $arg[0]["id"]);
            foreach ($uip as $ui) {
                $bl = $ui['ip']."\n".$bl;
            }
            db('Grupo', 'u', 'defaults', 'v2', 'type', $bl, 'blacklist');
            gr_cache('blacklist');
            gr_prnt('say("'.$GLOBALS["lang"]['banned'].'","s");menuclick("mmenu","users");');
            gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
        }
    } else if ($arg[0]['type'] === 'act' && $arg[0]['opted'] === 'unbanip') {
        if (!gr_role('access', 'sys', '3')) {
            exit;
        }
        if ($uid !== $arg[0]['id']) {
            $bl = db('Grupo', 's', 'defaults', 'type', 'blacklist')[0]['v2'];
            $uip = db('Grupo', 's,ip', 'utrack', 'uid', $arg[0]["id"]);
            foreach ($uip as $ui) {
                $bl = str_replace($ui['ip'], "", $bl);
            }
            $bl = preg_replace("/[\r\n]+/", "\n", $bl);
            db('Grupo', 'u', 'defaults', 'v2', 'type', $bl, 'blacklist');
            gr_cache('blacklist');
            gr_prnt('say("'.$GLOBALS["lang"]['unblocked'].'","s");menuclick("mmenu","users");');
            gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
        }
    } else if ($arg[0]['type'] === 'act' && $arg[0]['opted'] === 'ban') {
        if (!gr_role('access', 'users', '8')) {
            exit;
        }
        if ($uid !== $arg[0]['id']) {
            $r = db('Grupo', 's,count(*)', 'users', 'id', $arg[0]["id"])[0][0];
            if ($r > 0) {
                gr_profile('ustatus', 'offline', $arg[0]['id']);
                usr('Grupo', 'forcelogout', $arg[0]['id']);
                usr('Grupo', 'alter', 'role', 4, $arg[0]['id']);
                gr_prnt('say("'.$GLOBALS["lang"]['banned'].'","s");menuclick("mmenu","users");');
                gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
            }
        }
    } else if ($arg[0]['type'] === 'login') {
        if (!gr_role('access', 'users', '6')) {
            exit;
        }
        gr_profile('ustatus', 'offline');
        $_SESSION['utrack'] = 'off';
        usr('Grupo', 'forcelogin', $arg[0]['id']);
        $_SESSION['grcreset'] = 1;
        gr_prnt('window.location.href = "";');
    }

}
function gr_autotms($offset) {
    $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    $tmval = timezone_name_from_abbr("", $offset, 0);
    if ($tmval == false) {
        $tmval = gr_detecttmz($offset);
    }
    if (in_array($tmval, $tzlist)) {
        $uid = $GLOBALS["user"]['id'];
        $ct = db('Grupo', 's,count(*)', 'options', 'type,v1,v3', 'profile', 'autotmz', $uid)[0][0];
        if ($ct == 0) {
            gr_data('i', 'profile', 'autotmz', $tmval, $uid);
        } else {
            gr_data('u', 'v2', 'type,v1,v3', $tmval, 'profile', 'autotmz', $uid);
        }
    }
}
function gr_detecttmz($offset) {
    $abbrarray = timezone_abbreviations_list();
    foreach ($abbrarray as $abbr) {
        foreach ($abbr as $city) {
            if ($city['offset'] == $offset) {
                return $city['timezone_id'];
            }
        }
    }
}
function gr_prnt() {
    $arg = func_get_args();
    if (isset($arg[1])) {
        $arg[0] = htmlspecialchars($arg[0]);
    }
    echo $arg[0];
}
function gr_usip() {
    $arg = func_get_args();
    if ($arg[0] === 'add') {
        if (!isset($_SESSION['utrack'])) {
            $_SESSION['utrack'] = 'on';
        }
        if ($_SESSION['utrack'] != 'off') {
            $uid = $GLOBALS["user"]['id'];
            $r = db('Grupo', 's,count(id)', 'utrack', 'ip,dev,uid', ip(), ip('dev'), $uid)[0][0];
            if ($r > 0) {
                db('Grupo', 'u', 'utrack', 'tms', 'ip,dev,uid', dt(), ip(), ip('dev'), $uid);
            } else {
                db('Grupo', 'i', 'utrack', 'ip,dev,uid,tms', ip(), ip('dev'), $uid, dt());
            }
        }
    } else if ($arg[0] === 'ban') {
        $r = db('Grupo', 'u', 'utrack', 'status', 'ip,dev,uid', 1, ip(), ip('dev'), $arg[1], 'ORDER BY id DESC');
    } else if ($arg[0] === 'unban') {
        $r = db('Grupo', 'u', 'utrack', 'status', 'ip,dev,uid', 0, ip(), ip('dev'), $arg[1], 'ORDER BY id DESC');
    } else if ($arg[0] === 'check') {
        if (isset($arg[1])) {
            $r = db('Grupo', 's,count(*)', 'utrack', 'ip,dev,uid,status', ip(), ip('dev'), $arg[1], 1)[0][0];
        } else {
            $r = db('Grupo', 's,count(*)', 'utrack', 'ip,dev,status', ip(), ip('dev'), 1)[0][0];
        }
        if ($r > 0) {
            return true;
        } else {
            return false;
        }
    }
}
function gr_default() {
    $arg = func_get_args();
    if ($arg[0] === 'get') {
        $r = null;
        $file = 'gem/ore/grupo/cache/defaults.cch';
        $r = json_decode(file_get_contents($file));
        $k = $arg[1];
        $r = $r->$k;
        return $r;
    } else if ($arg[0] === 'var') {
        $file = 'gem/ore/grupo/cache/defaults.cch';
        $rs = array();
        $r = file_get_contents($file);
        $r = json_decode($r);
        foreach ($r as $key => $ky) {
            $rs[$key] = $ky;
        }
        return $rs;
    }
}
function gr_core() {
    $arg = func_get_args();
    if ($arg[0] === 'hf') {
        if ($arg[1] === 'header') {
            include("gem/ore/grupo/cache/headers.cch");
        } else if ($arg[1] === 'footer') {
            include("gem/ore/grupo/cache/footers.cch");
        }
    }
}

function gr_group() {
    $uid = $GLOBALS["user"]['id'];
    $arg = func_get_args();
    if ($arg[0] === 'valid') {
        $arg[1] = vc($arg[1]);
        $r[0] = false;
        if (!empty($arg[1])) {
            if (isset($arg[2]) && $arg[2] === 'user') {
                if ($arg[1] !== $uid) {
                    $vusr = db('Grupo', 's', 'users', 'id', $arg[1]);
                    if (count($vusr) > 0) {
                        $r[0] = true;
                        $r['name'] = $GLOBALS["lang"]['conversation_with'].' '.gr_profile('get', $arg[1], 'name');
                    }
                }
            } else {
                $cr = db('Grupo', 's', 'options', 'type,id', 'group', $arg[1]);
                if ($cr && count($cr) > 0) {
                    $r[0] = true;
                    $r['name'] = $cr[0]['v1'];
                    $r['pass'] = $cr[0]['v2'];
                    $r['code'] = $cr[0]['v3'];
                    $r['visible'] = $cr[0]['v3'];
                    $r['access'] = $cr[0]['v4'];
                    $r['messaging'] = $cr[0]['v5'];
                }
            }
        }
        return $r;
    } else if ($arg[0] === 'validmsg') {
        $arg[1] = vc($arg[1], 'num');
        $arg[2] = vc($arg[2], 'num');
        $r[0] = false;
        if (!empty($arg[1]) && !empty($arg[2])) {
            if (isset($arg[3]) && $arg[3] == 'user') {
                $tmpido = $arg[1].'-'.$uid;
                if ($arg[1] > $uid) {
                    $tmpido = $uid.'-'.$arg[1];
                }
                $cr = db('Grupo', 's', 'msgs', 'gid,id,cat', $tmpido, $arg[2], 'user');
            } else {
                $cr = db('Grupo', 's', 'msgs', 'gid,id', $arg[1], $arg[2]);
            }
            if ($cr && count($cr) > 0) {
                $r[0] = true;
                $r['msg'] = $cr[0]['msg'];
                $r['uid'] = $cr[0]['uid'];
                $r['type'] = $cr[0]['type'];
            }
        }
        return $r;
    } else if ($arg[0] === 'invite') {
        if (gr_role('access', 'groups', '5') || gr_role('access', 'groups', '7')) {
            $cu = gr_group('user', $arg[1]["id"], $uid);
            if ($cu[0] && $cu['role'] != 3) {
                $grpn = gr_group('valid', $arg[1]["id"]);
                if (gr_role('access', 'groups', '7') || empty($grpn['pass']) && $grpn['visible'] != 'secret' || $grpn['role'] == 1 || $grpn['role'] == 2) {
                    $users = explode(',', $arg[1]["users"]);
                    foreach ($users as $u) {
                        $emv = $us = vc($u, 'email');
                        if (empty($us)) {
                            $us = str_replace('@', '', $u);
                        }
                        $in = usr('Grupo', 'select', $us);
                        if (isset($in['id'])) {
                            $uc = gr_group('user', $arg[1]["id"], $in['id']); {
                                if (!$uc[0]) {
                                    gr_alerts('new', 'invitation', $in['id'], $arg[1]["id"], 0, $uid);
                                    gr_mail('invitation', $in['id'], $arg[1]["id"], rn(5));
                                }
                            }
                        } else if (!empty($emv)) {
                            gr_mail('invitenonmember', $emv, $arg[1]["id"], rn(5));
                        }
                    }
                    gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");say("'.$GLOBALS["lang"]['invited'].'","s");');
                }
            }
        }

    } else if ($arg[0] === 'unseen') {
        $cnt = 0;
        if (isset($arg[1])) {
            $src = '"'.$uid.'-%"';
            $srck = '"%-'.$uid.'"';
            $r = db('Grupo', 'q', 'SELECT max(id) as id,gid FROM gr_msgs WHERE gid LIKE '.$src.' OR gid LIKE '.$srck.' AND cat="user" GROUP by gid ORDER by id DESC');
            foreach ($r as $v) {
                $lview = db('Grupo', 's,v3', 'options', 'type,v1,v2', 'lview', $v['gid'], $uid, 'ORDER BY id DESC LIMIT 1');
                if (isset($lview[0])) {
                    $cnt = $cnt+db('Grupo', 's,count(id)', 'msgs', 'gid,id>', $v['gid'], $lview[0]['v3'])[0][0];
                } else {
                    $cnt = $cnt+ db('Grupo', 's,count(id)', 'msgs', 'gid,cat', $v['gid'], 'user')[0][0];
                }
            }
        } else {
            $gr = db('Grupo', 's', 'options', 'type,v2,v3<>', 'gruser', $uid, 3);
            foreach ($gr as $r) {
                $lview = db('Grupo', 's,v3', 'options', 'type,v1,v2', 'lview', $r['v1'], $uid, 'ORDER BY id DESC LIMIT 1');
                if (isset($lview[0])) {
                    $cnt = $cnt+db('Grupo', 's,count(id)', 'msgs', 'gid,type<>,id>', $r['v1'], 'like', $lview[0]['v3'])[0][0];
                } else {
                    $cnt = $cnt+ db('Grupo', 's,count(id)', 'msgs', 'gid,type<>,cat', $r['v1'], 'like', 'group')[0][0];
                }
            }
        }
        return $cnt;
    } else if ($arg[0] === 'complaints') {
        $cu = gr_group('user', $arg[1], $uid);
        if (!$cu[0] || $cu['role'] == 3 && !gr_role('access', 'groups', '7')) {
            exit;
        }
        if (gr_role('access', 'groups', '7')) {
            $r = db('Grupo', 's,count(id)', 'complaints', 'gid,status', $arg[1], 1, 'ORDER BY status ASC')[0][0];
        } else if ($cu['role'] == 2 || $cu['role'] == 1) {
            $r = db('Grupo', 's,count(id)', 'complaints', 'gid,msid<>,status', $arg[1], 0, 1, 'ORDER BY status ASC')[0][0];
        } else {
            $r = db('Grupo', 's,count(id)', 'complaints', 'uid,gid,status', $uid, $arg[1], 1, 'ORDER BY id DESC')[0][0];
        }
        return $r;
    } else if ($arg[0] === 'reportmsg') {
        $r = db('Grupo', 's', 'msgs', 'id,gid', $arg[1]["msid"], $arg[1]["id"]);
        if (count($r) > 0 || empty($arg[1]["msid"])) {
            $cu = gr_group('user', $arg[1]["id"], $uid);
            if ($cu[0] && $cu['role'] != 3) {
                if (isset($arg[1]["reason"]) && isset($arg[1]["comment"]) && !empty($arg[1]["comment"])) {
                    db('Grupo', 'i', 'complaints', 'gid,uid,msid,type,comment,tms', $arg[1]["id"], $uid, $arg[1]["msid"], $arg[1]["reason"], $arg[1]["comment"], dt());
                    gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");say("'.$GLOBALS["lang"]['reported'].'","s");');
                } else {
                    gr_prnt('say("'.$GLOBALS["lang"]['invalid_value'].'");');
                }
            }
        }
    } else if ($arg[0] === 'takeaction') {
        $cm = db('Grupo', 's', 'complaints', 'id', $arg[1]["id"]);
        if (count($cm) != 0) {
            if (empty($cm[0]["msid"]) && !gr_role('access', 'groups', '7')) {
                exit;
            }
            $cu = gr_group('user', $cm[0]['gid'], $uid);
            if ($cu['role'] == 2 || $cu['role'] == 1 || gr_role('access', 'groups', '7')) {
                if (!empty($arg[1]["status"])) {
                    db('Grupo', 'u', 'complaints', 'status', 'id', $arg[1]["status"], $arg[1]["id"]);
                }
                gr_prnt('$(".grtab.active").trigger("click");say("'.$GLOBALS["lang"]['updated'].'","s");');
            }
        }
        gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
    } else if ($arg[0] === 'user') {
        $arg[1] = vc($arg[1]);
        $arg[2] = vc($arg[2], 'num');
        $r[0] = false;
        $r['role'] = 0;
        if (!empty($arg[1]) && !empty($arg[2])) {
            if (isset($arg[3]) && $arg[3] == 'user') {
                $vusra = db('Grupo', 's,count(id)', 'users', 'id', $arg[1])[0][0];
                $vusrb = db('Grupo', 's,count(id)', 'users', 'id', $arg[2])[0][0];
                if ($vusra > 0 && $vusrb > 0) {
                    $r[0] = true;
                    $r['role'] = 0;
                }
            } else {
                $cr = db('Grupo', 's', 'options', 'type,v1,v2', 'gruser', $arg[1], $arg[2]);
                if (count($cr) > 0) {
                    $r[0] = true;
                    $r['role'] = $cr[0]['v3'];
                }
            }
        }
        return $r;
    } else if ($arg[0] === 'sendmsg') {
        if (!isset($arg[1]["ldt"]) || empty($arg[1]["ldt"])) {
            $arg[1]["ldt"] = 'group';
        }
        if ($arg[1]["ldt"] == 'user') {
            $deac = db('Grupo', 's', 'options', 'type,v1,v3', 'deaccount', 'yes', $arg[1]["id"]);
            if ($deac && count($deac) > 0) {
                exit;
            }
            if (gr_profile('blocked', $arg[1]["id"])[0]) {
                exit;
            }
            if (!gr_role('access', 'privatemsg', '1')) {
                exit;
            }
        }

        $cr = gr_group('valid', $arg[1]["id"], $arg[1]["ldt"]);

        if ($cr[0] && !empty(trim($arg[1]["msg"])) || $cr[0] && $arg[1]["msg"] == 0) {
            if (isset($arg[4])) {
                $uid = $arg[4];
            }

            $cu = gr_group('user', $arg[1]["id"], $uid, $arg[1]["ldt"]);

            if ($cu[0] && $cu['role'] != 3) {
                if ($arg[1]["ldt"] == 'group') {
                    if ($cu['role'] != 1 && $cu['role'] != 2 && !gr_role('access', 'groups', '7') && $cr['messaging'] == 'adminonly') {
                        exit;
                    }
                }
                $typ = 'msg';
                $rmid = $rtxt = $rid = 0;
                if (isset($arg[2])) {
                    if ($arg[2] === 1) {
                        $typ = 'system';
                    } else if ($arg[2] === 2) {
                        $typ = 'file';
                    } else if ($arg[2] === 3) {
                        $typ = 'audio';
                    }
                }
                $gif = 0;
                if (isset($arg[1]["gif"]) && isset($arg[1]["gfm"]) && gr_role('access', 'features', '3')) {
                    if (!empty($arg[1]["gif"]) && !empty($arg[1]["gfm"])) {
                        $tchk = '/http(s)?:\/\/(media\.)*tenor\.com\/.*/';
                        if (preg_match($tchk, $arg[1]["gif"]) && preg_match($tchk, $arg[1]["gfm"])) {
                            $typ = 'gifs';
                            $gif = 1;
                        }
                    }
                }
                $sendminmsglimit = vc($GLOBALS["default"]['min_msg_length'], 'num');
                $sendmaxmsglimit = vc($GLOBALS["default"]['max_msg_length'], 'num');
                if ($typ == 'msg') {
                    if (!empty($sendminmsglimit) && strlen($arg[1]["msg"]) < $sendminmsglimit) {
                        return false;
                    }
                    if (!empty($sendmaxmsglimit)) {
                        $arg[1]["msg"] = substr($arg[1]["msg"], 0, $sendmaxmsglimit);
                    }
                }
                $rv['type'] = 'msg';
                if (!empty($arg[1]["rid"]) && $gif == 0) {
                    $rv = gr_group('validmsg', $arg[1]["id"], $arg[1]["rid"], $arg[1]["ldt"]);
                    if ($rv[0]) {
                        $rid = $rv['uid'];
                        $rmid = $arg[1]["rid"];
                        if ($rv['type'] === 'file') {
                            $rtxt = 'shared_file';
                        } else {
                            $rtxt = html_entity_decode(substr($rv['msg'], 0, 30), ENT_QUOTES);
                        }
                    }
                }
                $dt = dt();
                $extchkm = 2;
                $tmpido = $arg[1]["id"];
                if ($arg[1]["ldt"] == 'user') {
                    $tmpido = $arg[1]["id"].'-'.$uid;
                    if ($arg[1]["id"] > $uid) {
                        $tmpido = $uid.'-'.$arg[1]["id"];
                    }
                    $extchkm = db('Grupo', 's,count(id)', 'msgs', 'gid', $tmpido)[0][0];
                    if ($extchkm == 0) {
                        gr_lview($tmpido, 0, $arg[1]["id"]);
                    }
                }
                $xtraz = 0;
                if (isset($arg[1]["xtra"]) && $gif == 0) {
                    $xtraz = $arg[1]["xtra"];
                }
                if (isset($arg[1]["qrcode"]) && $arg[1]["qrcode"] == 1 && $gif == 0 && $typ == 'msg') {
                    if (gr_role('access', 'features', '4')) {
                        $typ = 'qrcode';
                    }
                }
                if ($gif == 0) {
                    $arg[1]["msg"] = preg_replace("/[\r\n]+/", "\n", $arg[1]["msg"]);
                } else {
                    $arg[1]["msg"] = $arg[1]["gif"];
                    $xtraz = $arg[1]["gfm"];
                }
                if (!gr_role('access', 'features', '7') && $typ == 'msg') {
                    $arg[1]["msg"] = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '##', $arg[1]["msg"]);
                }
                if (!gr_role('access', 'features', '1') && $typ == 'msg') {
                    exit;
                }
                $mid = db('Grupo', 'i', 'msgs', 'gid,uid,msg,type,tms,rtxt,rid,rmid,rtype,cat,xtra', $tmpido, $uid, $arg[1]["msg"], $typ, $dt, $rtxt, $rid, $rmid, $rv['type'], $arg[1]["ldt"], $xtraz);
                gr_lview($tmpido, $mid);
                db('Grupo', 'd', 'logs', 'type,v2', 'typing', $uid);
                if ($arg[1]["ldt"] == 'user') {
                    if ($extchkm == 0 || $extchkm != 0 && !isset($rv['uid'])) {
                        $brw = db('Grupo', 's,count(id)', 'logs', 'type,v1,v3', 'browsing', $arg[1]["id"], $tmpido)[0][0];
                        if ($brw == 0) {
                            gr_alerts('new', 'newmsg', $arg[1]["id"], $uid, $mid, $uid);
                        }
                        if (gr_profile('get', $arg[1]["id"], 'status') != 'online') {
                            gr_mail('newmsg', $arg[1]["id"], $uid, rn(5));
                        }
                    }
                }
                if (isset($rv['uid']) && $rv['uid'] != $uid) {
                    $cru = gr_group('user', $arg[1]["id"], $rv['uid']);
                    if ($cru[0] && $cru['role'] != 3) {
                        gr_alerts('new', 'replied', $rv['uid'], $arg[1]["id"], $mid, $uid);
                        gr_mail('replied', $rv['uid'], $uid, rn(5));
                    }
                }
                $dmup = 0;
                $mmsgz = $arg[1]["msg"];
                if ($arg[1]["ldt"] == 'group' && $gif == 0 && $typ == 'msg') {
                    preg_match_all('/(^|\s)(@\w+)/', $mmsgz, $matches);
                    foreach ($matches[2] as $men) {
                        $men = str_replace('@', '', $men);
                        $mu = usr('Grupo', 'select', $men);
                        if (isset($mu['id'])) {
                            $dect = db('Grupo', 's', 'options', 'type,v1,v3', 'deaccount', 'yes', $mu['id']);
                            if (count($dect) == 0) {
                                $cu = gr_group('user', $arg[1]["id"], $mu['id']);
                                if ($cu[0] && $cu['role'] != 3) {
                                    $dmup = 1;
                                    $mmsgz = str_replace('@'.$men, '@'.$mu['id'], $mmsgz);
                                    if ($mu['id'] != $uid) {
                                        gr_alerts('new', 'mentioned', $mu['id'], $arg[1]["id"], $mid, $uid);
                                        gr_mail('mentioned', $mu['id'], $uid, rn(5));
                                    }
                                }
                            }
                        }
                    }
                    if ($dmup == 1) {
                        db('Grupo', 'u', 'msgs', 'msg', 'id', $mmsgz, $mid);
                    }
                    db('Grupo', 'u', 'options', 'tms', 'id,type', dt(), $arg[1]["id"], 'group');
                }
                if (isset($arg[3]) && $arg[3] == 'mid') {
                    $arg[1]["msid"] = $mid;
                }
                if (!isset($arg[3]) || $arg[3] == 'mid') {
                    gr_group('msgs', $arg[1]);
                }

            }
        }

    } else if ($arg[0] === 'mention') {
        gr_prnt('$(".swr-grupo .rside > .top > .left > .goback:visible,.swr-grupo .panel > .head > .goback:visible").trigger("click");');
        gr_prnt('setTimeout(function() {$(".swr-grupo .lside > .tabs > ul > li").eq(0).attr("openid","'.$arg[1]["id"].'").trigger("click");}, 600);');
        gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
    } else if ($arg[0] === 'deletemsg') {
        $forcedel = 0;
        if (isset($arg[2]) && $arg[2] == 'force') {
            $forcedel = 1;
        }
        if ($forcedel == 0) {
            $role = gr_group('user', $arg[1]["id"], $uid, $arg[1]["ldt"])['role'];
        } else {
            $role = 2;
        }
        if ($role == 3) {
            exit;
        }
        if ($role == 2 || gr_role('access', 'groups', '7') || $role == 1) {
            if ($arg[1]["ldt"] == 'user') {
                $tmpido = $arg[1]["id"].'-'.$uid;
                if ($arg[1]["id"] > $uid) {
                    $tmpido = $uid.'-'.$arg[1]["id"];
                }
                $arg[1]["id"] = $tmpido;
            }
            $r = db('Grupo', 's', 'msgs', 'gid,id', $arg[1]["id"], $arg[1]["mid"]);
        } else {
            if ($arg[1]["ldt"] == 'user') {
                $tmpido = $arg[1]["id"].'-'.$uid;
                if ($arg[1]["id"] > $uid) {
                    $tmpido = $uid.'-'.$arg[1]["id"];
                }
                $arg[1]["id"] = $tmpido;
            }
            $r = db('Grupo', 's', 'msgs', 'gid,id,uid', $arg[1]["id"], $arg[1]["mid"], $uid);
        }
        if (count($r) > 0) {
            if ($r[0]['type'] === 'system') {
                gr_prnt('say("'.$GLOBALS["lang"]['deny_system_msg'].'","e")');
                exit;
            }
            $delexpr = vc($GLOBALS["default"]['delmsgexpiry'], 'num');
            if (!empty($delexpr)) {
                if (strtotime('now') > strtotime('+'.$delexpr.' minutes', strtotime($r[0]['tms'])) && !gr_role('access', 'groups', '7') && $role != 2 && $role != 1) {
                    gr_prnt('say("'.$GLOBALS["lang"]['deny_file_deletion'].'","e")');
                    exit;
                }
            } else if (!gr_role('access', 'groups', '7') && $role != 2 && $role != 1) {
                gr_prnt('say("'.$GLOBALS["lang"]['deny_file_deletion'].'","e")');
                exit;
            }
            if ($r[0]['type'] === 'file') {
                if (file_exists('gem/ore/grupo/files/dumb/zip-'.$r[0]['msg'].'.zip')) {
                    unlink('gem/ore/grupo/files/dumb/zip-'.$r[0]['msg'].'.zip');
                }
            } else if ($r[0]['type'] === 'audio') {
                if (file_exists('gem/ore/grupo/audiomsgs/'.$r[0]['msg'])) {
                    unlink('gem/ore/grupo/audiomsgs/'.$r[0]['msg']);
                }
            }
            db('Grupo', 'd', 'msgs', 'gid,id', $arg[1]["id"], $arg[1]["mid"]);
            db('Grupo', 'd', 'msgs', 'gid,msg,type', $arg[1]["id"], $arg[1]["mid"], 'like');
            db('Grupo', 'd', 'options', 'type,v1', 'loves', $arg[1]["mid"]);
            if ($forcedel == 0) {
                gr_prnt('$(".swr-grupo .panel > .room > .msgs > li[no='.$arg[1]["mid"].']").remove();');
            }
        }
        if ($forcedel == 0) {
            gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
        }
    } else if ($arg[0] === 'attachmsg') {
        if (!gr_role('access', 'files', '4')) {
            exit;
        }
        if (!isset($arg[1]["ldt"]) || empty($arg[1]["ldt"])) {
            $arg[1]["ldt"] = 'group';
        }
        $cr = gr_group('valid', $arg[1]["id"], $arg[1]["ldt"]);
        if ($cr[0]) {
            $cu = gr_group('user', $arg[1]["id"], $uid, $arg[1]["ldt"]);
            if ($cu[0] && $cu['role'] != 3) {
                if ($arg[1]["ldt"] == 'group') {
                    if ($cu['role'] != 1 && $cu['role'] != 2 && !gr_role('access', 'groups', '7') && $cr['messaging'] == 'adminonly') {
                        exit;
                    }
                }
                $dir = 'grupo/files/'.$uid.'/';
                flr('new', $dir);
                $fn = rn(6).rn(3).'-gr-';
                if (flr('upload', 'attachfile', $dir, $fn)) {
                    $do['id'] = $fn.$_FILES['attachfile']['name'];
                    $do['type'] = 'zip';
                    $do['r'] = 1;
                    fc('grfiles');
                    $fn = gr_files($do);
                    $data["id"] = $arg[1]["id"];
                    $data["msg"] = $fn;
                    $data["ldt"] = $arg[1]["ldt"];
                    $data['xtra'] = $_FILES['attachfile']['name'];
                    gr_group('sendmsg', $data, 2, 'mid');
                }
            }
        }

    } else if ($arg[0] === 'sendaudio') {
        if (gr_role('access', 'features', '2')) {
            if (!isset($arg[1]["ldt"]) || empty($arg[1]["ldt"])) {
                $arg[1]["ldt"] = 'group';
            }
            $cr = gr_group('valid', $arg[1]["id"], $arg[1]["ldt"]);
            if ($cr[0]) {
                $cu = gr_group('user', $arg[1]["id"], $uid, $arg[1]["ldt"]);
                if ($cu[0] && $cu['role'] != 3) {
                    $dir = 'grupo/audiomsgs';
                    flr('new', $dir);
                    $fn = $uid.'-gr-'.rn(6).'-'.dt(0, "dmyhis").'-';
                    if (flr('upload', 'audio_data', $dir, $fn)) {
                        $fn = $fn.$_FILES['audio_data']['name'];
                        $data["id"] = $arg[1]["id"];
                        $data["msg"] = $fn;
                        $data["ldt"] = $arg[1]["ldt"];
                        $data['xtra'] = $_FILES['audio_data']['name'];
                        gr_group('sendmsg', $data, 3, 'mid');
                    }
                }
            }
        }
    } else if ($arg[0] === 'msgs') {
        $orgid = $arg[1]["id"];
        $lphr = gr_lang('var');
        $rchk = gr_role('var');
        if (!isset($arg[1]["ldt"]) || empty($arg[1]["ldt"])) {
            $arg[1]["ldt"] = 'group';
        }
        if ($arg[1]["ldt"] == 'user') {
            $tmpido = $arg[1]["id"].'-'.$uid;
            if ($arg[1]["id"] > $uid) {
                $tmpido = $uid.'-'.$arg[1]["id"];
            }
            $arg[1]["id"] = $tmpido;
        }
        $list = null;
        $perload = $GLOBALS["default"]['maxmsgsperload'];
        $cu = gr_group('user', $arg[1]["id"], $uid, $arg[1]["ldt"]);
        if (!$cu[0] || $cu['role'] == 3 && !isset($rchk['groups']['7'])) {
            $list[0] = new stdClass();
            $list[0]->nomem = 1;
        }
        if ($cu[0] && $cu['role'] != 3 || isset($rchk['groups']['7'])) {
            if (isset($arg[1]["from"]) && !empty($arg[1]["from"])) {
                $r = db('Grupo', 's', 'msgs', 'cat,gid,id>', $arg[1]["ldt"], $arg[1]["id"], $arg[1]["from"], 'ORDER BY id DESC LIMIT 10');
            } else if (isset($arg[1]["to"]) && !empty($arg[1]["to"])) {
                $r = db('Grupo', 's', 'msgs', 'cat,gid,type<>,id<', $arg[1]["ldt"], $arg[1]["id"], 'like', $arg[1]["to"], 'ORDER BY id DESC LIMIT 10');
            } else if (isset($arg[1]["uid"]) && !empty($arg[1]["uid"])) {
                $r = db('Grupo', 's', 'msgs', 'cat,gid,uid,type<>', $arg[1]["ldt"], $arg[1]["id"], $arg[1]["uid"], 'like', 'ORDER BY id DESC');
            } else if (isset($arg[1]["msid"]) && !empty($arg[1]["msid"])) {
                $r = db('Grupo', 's', 'msgs', 'cat,gid,id,type<>', $arg[1]["ldt"], $arg[1]["id"], $arg[1]["msid"], 'like', 'ORDER BY id DESC');
            } else if (isset($arg[1]["search"]) && !empty($arg[1]["search"])) {
                $arg[1]["search"] = '%'.$arg[1]["search"].'%';
                $r = db('Grupo', 's', 'msgs', 'cat,gid,type<>,msg LIKE', $arg[1]["ldt"], $arg[1]["id"], 'like', $arg[1]["search"], 'ORDER BY id DESC LIMIT '.$perload);
            } else {
                $r = db('Grupo', 's', 'msgs', 'cat,gid,type<>', $arg[1]["ldt"], $arg[1]["id"], 'like', 'ORDER BY id DESC LIMIT '.$perload);
                $brw = db('Grupo', 's,count(id)', 'logs', 'type,v1', 'browsing', $uid)[0][0];
                if ($brw > 0) {
                    db('Grupo', 'u', 'logs', 'v3,xtra', 'type,v1', $arg[1]["id"], $arg[1]["ldt"], 'browsing', $uid);
                } else {
                    db('Grupo', 'i', 'logs', 'type,v1,v3,xtra', 'browsing', $uid, $arg[1]["id"], $arg[1]["ldt"]);
                }
            }
            $r = array_reverse($r);
            $txt['reply'] = $lphr['reply'];
            $txt['delete'] = $lphr['delete'];
            $txt['confirm_delete'] = $lphr['confirm_delete'];
            $txt['download'] = $lphr['download'];
            $list[0] = new stdClass();
            $list[0]->blocked = 0;
            $list[0]->nomem = 0;
            if ($arg[1]["ldt"] == 'user') {
                $blocked = gr_profile('blocked', $orgid);
                $list[0]->pntitle = gr_profile('get', $orgid, 'name');
                if ($blocked[0]) {
                    $list[0]->pnsub = $lphr['blocked'];
                } else {
                    $stat = gr_profile('get', $orgid, 'status');
                    $list[0]->pnsub = $lphr[$stat];
                }
                $list[0]->pnimg = gr_img('users', $orgid);
                $list[0]->deactiv = 0;
                $lastvw = db('Grupo', 's', 'options', 'type,v1,v2', 'lview', $arg[1]["id"], $orgid, 'ORDER BY id DESC LIMIT 1');
                if (isset($lastvw[0])) {
                    $lastvw = $lastvw[0]['v3'];
                } else {
                    $lastvw = 0;
                }
                $deac = db('Grupo', 's', 'options', 'type,v1,v3', 'deaccount', 'yes', $orgid);
                if ($deac && count($deac) > 0) {
                    $list[0]->deactiv = 1;
                    $list[0]->pnimg = gr_img('users', 0);
                }
                if (!isset($rchk['privatemsg']['1'])) {
                    $list[0]->deactiv = 1;
                }
                $list[0]->gid = $orgid;
                $list[1] = new stdClass();
                $list[1]->mb = array($lphr['block_user'], 'class="formpop" pn="1" title="'.$lphr['block_user'].'" do="profile" btn="'.$lphr['block_user'].'" act="block"');

                if ($blocked[0]) {
                    $list[0]->blocked = 1;
                    if ($blocked[1] == 'you') {
                        $list[1]->mb = array($lphr['unblock_user'], 'class="formpop" pn="1" title="'.$lphr['unblock_user'].'" do="profile" btn="'.$lphr['unblock'].'" act="block"');
                    }
                }
                if (count($deac) == 0 && $list[0]->blocked != 1) {
                    $list[1]->ma = array($lphr['view_profile'], 'class="vwp" no="'.$orgid.'"');
                }
                if (isset($rchk['privatemsg']['3'])) {
                    $list[1]->mc = array($lphr['export_chat'], 'class="formpop" pn="1" title="'.$lphr['export_chat'].'" do="group" btn="'.$lphr['export_chat'].'" act="export"');
                }
            } else {
                $grpn = gr_group('valid', $arg[1]["id"]);
                $lastvw = db('Grupo', 's', 'options', 'type,v1', 'lview', $arg[1]["id"]);
                $list[0]->pntitle = $grpn['name'];
                $list[0]->pnsub = gr_data('c', 'type,v1', 'gruser', $arg[1]['id'])." ".$lphr['members'];
                $list[0]->pnimg = gr_img('groups', $arg[1]["id"]);
                $list[0]->gid = $orgid;
                $list[0]->likesys = 0;
                if (isset($rchk['groups'][9]) || isset($rchk['groups'][7])) {
                    $list[0]->viewlike = 1;
                }
                $list[0]->likemsgs = $lphr['denied'];
                if (isset($rchk['groups'][10]) || isset($rchk['groups'][7])) {
                    $list[0]->likemsgs = 'enabled';
                }
                $list[1] = new stdClass();
                $role = gr_group('user', $arg[1]["id"], $uid)['role'];
                $adm = 0;
                if ($role == 2 || $role == 1) {
                    $adm = 1;
                }
                if ($adm != 1 && !isset($rchk['groups'][7]) && $grpn['messaging'] == 'adminonly') {
                    $list[0]->deactiv = 1;
                }
                if (isset($rchk['groups'][2]) && $adm == 1 || isset($rchk['groups'][7])) {
                    $list[1]->ma = array($lphr['edit_group'], 'class="formpop" pn="1" title="'.$lphr['edit_group'].'" do="edit" btn="'.$lphr['update'].'" act="group"');
                }
                if (isset($rchk['groups'][8]) || isset($rchk['groups'][7])) {
                    $list[1]->mb = array($lphr['export_chat'], 'class="formpop" pn="1" title="'.$lphr['export_chat'].'" do="group" btn="'.$lphr['export_chat'].'" act="export"');
                }
                $list[1]->mc = array($lphr['leave_group'], 'class="formpop" pn="1" title="'.$lphr['leave_group'].'" do="group" btn="'.$lphr['leave_group'].'" act="leave"');
                if (isset($rchk['groups'][12]) || isset($rchk['groups'][7])) {
                    if (isset($rchk['groups'][7]) || empty($grpn['pass']) && $grpn['visible'] != 'secret' || $adm == 1) {
                        $list[1]->mg = array($lphr['addgroupuser'], 'class="goback loadside" act="addgroupuser" zero="0" zval="'.$lphr['users'].'" side="lside"');
                    }
                }
                if (isset($rchk['groups'][5]) || isset($rchk['groups'][7])) {
                    if (isset($rchk['groups'][7]) || empty($grpn['pass']) && $grpn['visible'] != 'secret' || $adm == 1) {
                        $list[1]->md = array($lphr['invite'], 'class="formpop" pn="1" title="'.$lphr['invite'].'" do="group" btn="'.$lphr['invite'].'" act="invite"');
                    }
                }
                $list[1]->me = array($lphr['report_group'], 'class="formpop" pn="1" title="'.$lphr['report_group'].'" do="group" btn="'.$lphr['report'].'" act="reportmsg"');

                if (isset($rchk['groups'][3]) && $role == 2 || isset($rchk['groups'][7])) {
                    $list[1]->mf = array($lphr['delete'], 'class="formpop" pn="1" title="'.$lphr['delete'].'" do="group" btn="'.$lphr['delete'].'" act="delete"');
                }

            }
            $i = 2;
            $urtimzone = gr_profile('get', $uid, 'tmz');
            $delmsgt = vc($GLOBALS["default"]['autodeletemsg'], 'num');
            $usdelmsgt = vc($GLOBALS["default"]['delmsgexpiry'], 'num');
            $filxptme = vc($GLOBALS["default"]['fileexpiry'], 'num');
            $tdy = new DateTime(date('Y-m-d H:i:s'));
            $tmz = new DateTimeZone($urtimzone);
            $tdy->setTimezone($tmz);
            $lastseen = db('Grupo', 's,v3', 'options', 'type,v1', 'lview', $arg[1]["id"], 'ORDER BY v3 ASC LIMIT 1');
            foreach ($r as $v) {
                if ($v['type'] == 'like') {
                    $list[$i] = new stdClass();
                    $list[$i]->liked = $v['msg'];
                    $list[$i]->id = $v['id'];
                    $list[$i]->total = db('Grupo', 's,count(id)', 'msgs', 'gid,msg,type', $v['gid'], $v['msg'], 'like')[0][0];
                    $list[$i]->total = str_pad($list[$i]->total, 2, "0", STR_PAD_LEFT);
                    $list[$i]->type = $v['type'];
                    $i = $i+1;
                } else {
                    $tmrdel = $utmrdel = 0;
                    $tms = new DateTime($v['tms']);
                    $tmz = new DateTimeZone($urtimzone);
                    $tms->setTimezone($tmz);
                    $tmst = strtotime($tms->format('Y-m-d H:i:s'));
                    $list[$i] = new stdClass();
                    $usrn = usr('Grupo', 'select', $v['uid']);
                    $list[$i]->user = '';
                    if (isset($usrn['name'])) {
                        $list[$i]->user = $usrn['name'];
                    }
                    $list[$i]->userid = $v['uid'];
                    $list[$i]->opta = $list[$i]->optb = $list[$i]->optc = $list[$i]->optd = $list[$i]->opte = $list[$i]->tmrdel = 0;
                    if (!empty($delmsgt)) {
                        if ($arg[1]["ldt"] != 'user' && $v['type'] != 'system') {
                            $tmrdel = date("M d, Y H:i:s", strtotime('+'.$delmsgt.' minutes', $tmst));
                            $list[$i]->tmrdel = $tmrdel;
                        }
                    }
                    if (!empty($usdelmsgt)) {
                        if ($v['type'] != 'system') {
                            $utmrdel = date("M d, Y H:i:s", strtotime('+'.$usdelmsgt.' minutes', $tmst));
                            $list[$i]->utmrdel = $utmrdel;
                        }
                    }
                    if ($arg[1]["ldt"] != 'user') {
                        $list[$i]->opta = 'class="gr-report formpop" title="'.$lphr['report_message'].'" xtid="'.$v['id'].'" pn=1 do="group" btn="'.$lphr['report'].'" act="reportmsg"';
                        if ($v['uid'] != $uid) {
                            if (isset($rchk['privatemsg'][1])) {
                                $list[$i]->optd = 'class="loadgroup" ldt="user" no="'.$v['uid'].'"';
                            }
                        }

                    }
                    $delbtn = 0;
                    if (!empty($usdelmsgt)) {
                        if (strtotime($utmrdel) > strtotime('now')) {
                            $delbtn = 1;
                        }
                    }
                    if ($cu['role'] == 2 || isset($rchk['groups'][7]) || $v['uid'] === $uid && $delbtn == 1) {
                        $list[$i]->optb = 'class="gr-remove formpop" pn="1" xtid="'.$v['id'].'" data-ldt="'.$arg[1]["ldt"].'" data-umdt="'.$utmrdel.'" data-adt="'.$tmrdel.'" title="'.$lphr['delete'].'" do="group" btn="'.$lphr['delete'].'" act="deletemsg"';
                    }
                    $list[$i]->optc = 'class="gr-reply"';
                    if ($v['type'] === 'system') {
                        $list[$i]->opta = $list[$i]->optb = $list[$i]->optc = $list[$i]->optd = 0;
                        $list[$i]->msg = $lphr[$v['msg']];
                        $list[$i]->domsg = $v['msg'];
                    } else if ($v['type'] === 'msg') {
                        $list[$i]->msg = nl2br($v['msg']);
                    } else {
                        $list[$i]->msg = $v['msg'];
                    }
                    $list[$i]->gid = $orgid;

                    if ($arg[1]["ldt"] == 'group') {
                        $list[$i]->lvc = db('Grupo', 's,count(id)', 'msgs', 'gid,msg,type,uid', $v['gid'], $v['id'], 'like', $uid)[0][0];
                        if ($list[$i]->lvc > 0) {
                            $list[$i]->lvc = 'liked';
                        }
                    }
                    $list[$i]->lvn = 0;
                    if ($arg[1]["ldt"] == 'group') {
                        if (isset($rchk['groups'][9]) || isset($rchk['groups'][7])) {
                            $list[$i]->lvn = db('Grupo', 's,count(id)', 'msgs', 'gid,msg,type', $v['gid'], $v['id'], 'like')[0][0];
                            $list[$i]->lvn = str_pad($list[$i]->lvn, 2, "0", STR_PAD_LEFT);
                        }
                    }
                    if ($v['type'] === 'qrcode' || $v['type'] === 'msg') {
                        $list[$i]->msg = html_entity_decode(gr_noswear($list[$i]->msg), ENT_QUOTES);
                    }
                    if ($v['type'] === 'msg') {
                        if ($arg[1]["ldt"] == 'group') {
                            preg_match_all('/(^|\s)(@\w+)/', $list[$i]->msg, $matches);
                            foreach ($matches[2] as $men) {
                                $men = str_replace('@', '', $men);
                                $name = db('Grupo', 's,v2', 'options', 'type,v1,v3', 'profile', 'name', $men);
                                if (count($name) > 0) {
                                    $name = $name[0]['v2'];
                                    $list[$i]->msg = str_replace('@'.$men, '<i class="vwp mentnd" no="'.$men.'">'.$name.'</i> ', $list[$i]->msg);
                                }
                            }
                        }
                    }
                    $list[$i]->send = "usr";
                    $list[$i]->id = $v['id'];
                    $deac = db('Grupo', 's', 'options', 'type,v1,v3', 'deaccount', 'yes', $v['uid']);
                    if ($deac && count($deac) > 0) {
                        $list[$i]->status = 'deactivated';
                        $list[$i]->user = 0;
                    }
                    $list[$i]->reply = '';
                    $list[$i]->rid = 0;
                    if (!empty($v['rtxt'])) {
                        $list[$i]->rid = $v['rmid'];
                        $list[$i]->rusr = gr_profile('get', $v['rid'], 'name');
                        if ($v['rtype'] == 'gifs') {
                            $list[$i]->reply = $lphr['shared_gif'];
                        } else if ($v['rtype'] == 'qrcode') {
                            $list[$i]->reply = $lphr['shared_qrcode'];
                        } else if ($v['rtype'] == 'audio') {
                            $list[$i]->reply = $lphr['send_audiomsg'];
                        } else if ($v['rtype'] != 'msg') {
                            $list[$i]->reply = $lphr[$v['rtxt']];
                        } else {
                            $list[$i]->reply = html_entity_decode(gr_noswear($v['rtxt']), ENT_QUOTES);
                        }
                    }
                    if ($v['uid'] === $uid) {
                        $list[$i]->send = "you";
                        $list[$i]->mseen = 'read';
                        if (isset($lastseen[0]) && $lastseen[0]['v3'] < $v['id']) {
                            $list[$i]->mseen = 'unread';
                        }
                    }
                    if ($v['uid'] != $uid || $v['type'] === 'system') {
                        $list[$i]->name = $lphr['unknown'];
                        $list[$i]->ncolor = '#444';
                        $senname = db('Grupo', 's', 'options', 'type,v1,v3', 'profile', 'name', $v['uid'], 'LIMIT 1');
                        if (isset($senname[0])) {
                            $list[$i]->name = $senname[0]['v2'];
                            if (!empty($senname[0]['v5'])) {
                                $list[$i]->ncolor = $senname[0]['v5'];
                            }
                        }
                    }
                    if ($v['type'] === 'system') {
                        $list[$i]->send = "system";
                    }
                    $list[$i]->date = $tms->format('d-M-Y');
                    $dtcn = $tms->format('d-M');
                    if ($list[$i]->date == $tdy->format('d-M-Y')) {
                        $dtcn = $lphr['today'];
                    } else if ($list[$i]->date == date('d-M-Y', strtotime($tdy->format('Y-m-d H:i:s')) - (24 * 60 * 60))) {
                        $dtcn = $lphr['yesterday'];
                    }
                    if ($GLOBALS["default"]['time_format'] == 24) {
                        $list[$i]->time = $dtcn.' '.$tms->format('H:i');
                        $list[$i]->date = $tms->format('d-M-Y H:i');
                    } else {
                        $list[$i]->time = $dtcn.' '.$tms->format('h:i A');
                        $list[$i]->date = $tms->format('d-M-Y h:i A');
                    }
                    $list[$i]->type = $v['type'];

                    if ($v['type'] === 'gifs') {
                        $list[$i]->xtra = $v['xtra'];
                        $gfex = explode('|', $list[$i]->msg);
                        $list[$i]->msg = $gfex[0];
                        $list[$i]->fwidth = 0;
                        $list[$i]->fheight = 0;
                        if (isset($gfex[1]) && isset($gfex[2])) {
                            $list[$i]->fwidth = $gfex[1];
                            $list[$i]->fheight = $gfex[2];
                        }
                    }
                    if ($v['type'] === 'audio') {
                        $list[$i]->sfile = $v['xtra'];
                        $list[$i]->fetxt = '';
                        $list[$i]->filext = mime_content_type('gem/ore/grupo/audiomsgs/'.$v['msg']);
                    } else if ($v['type'] === 'file') {
                        $list[$i]->sfile = $v['xtra'];
                        if (strlen($v['xtra']) > 16) {
                            $list[$i]->sfile = trim(substr($v['xtra'], 0, 8)).'...'.substr($v['xtra'], -8);
                        }
                        $list[$i]->filext = 'expired';
                        $list[$i]->fetxt = '';
                        $list[$i]->fetxtb = $lphr['file_expired'];
                        if (file_exists('gem/ore/grupo/files/dumb/'.$v['msg']) && !empty($v['msg'])) {
                            if (!gr_role('access', 'features', '5')) {
                                $ext = $list[$i]->filext = 'nopreview';
                            } else {
                                $ext = $list[$i]->filext = mime_content_type('gem/ore/grupo/files/dumb/'.$v['msg']);
                            }
                            if ($ext === 'image/jpeg' || $ext === 'image/png' || $ext === 'image/gif' || $ext === 'image/bmp') {
                                list($list[$i]->fwidth, $list[$i]->fheight) = getimagesize('gem/ore/grupo/files/dumb/'.$v['msg']);
                            }
                            if (!empty($filxptme)) {
                                $list[$i]->expiry = date("M d, Y H:i:s", strtotime('+'.$filxptme.' minutes', $tmst));
                            } else {
                                $list[$i]->expiry = 0;
                            }
                            $list[$i]->opte = 'class="gr-download formpop" data-file="'.$list[$i]->sfile.'" title="'.$lphr['download_file'].'" data-adt="'.$list[$i]->expiry.'" xtid="'.$v['msg'].'" pn=1 do="files" btn="'.$lphr['download'].'" act="download"';
                        } else {
                            $list[$i]->expiry = 0;
                            $list[$i]->fetxt = $list[$i]->fetxtb;
                        }
                    }
                    $i = $i+1;
                }
            }
            if (!isset($arg[1]["to"]) && !isset($arg[1]["uid"]) && !isset($arg[1]["msid"]) && !isset($arg[1]["search"]) && isset($v['id'])) {

                $i = $i-1;
                gr_lview($arg[1]["id"], $v['id']);
            }
        }
        if (isset($arg[2]) && $arg[2] == 'array') {
            $r = $list;
        } else {
            $r = json_encode($list);
        }
        if (isset($arg[2])) {
            return $r;
        } else {
            gr_prnt($r);
        }
    } else if ($arg[0] === 'typing') {
        $cu = gr_group('user', $arg[1]["id"], $uid);
        if ($cu[0] && $cu['role'] != 3) {
            $r = db('Grupo', 's,count(id)', 'logs', 'type,v1,v2', 'typing', $arg[1]["id"], $uid)[0][0];
            if ($r > 0) {
                db('Grupo', 'u', 'logs', 'xtra', 'type,v1,v2', rn(4), 'typing', $arg[1]["id"], $uid);
            } else {
                db('Grupo', 'i', 'logs', 'type,v1,v2,v3', 'typing', $arg[1]["id"], $uid, gr_profile('get', $uid, 'name'));
            }
        }
    } else if ($arg[0] === 'leave') {
        if (isset($arg[2])) {
            $uid = $arg[2];
        }
        $cu = gr_group('user', $arg[1]["id"], $uid);
        if ($cu[0] && $cu['role'] != 3) {
            $dt = array();
            $dt['id'] = $arg[1]["id"];
            $dt['msg'] = 'left_group';
            gr_group('sendmsg', $dt, 1, 1, $uid);
            gr_data('d', 'type,v1,v2', 'gruser', $arg[1]["id"], $uid);
            if (!isset($arg[2])) {
                gr_prnt('window.location.href = "";');
            }
        }
    } else if ($arg[0] === 'role') {
        $role = gr_group('user', $arg[1]["id"], $uid)['role'];
        if (gr_role('access', 'groups', '7') || $role == 2) {
            if (isset($arg[1]["remuser"]) && $arg[1]["remuser"] == 'yes') {
                $dt = array();
                $dt['id'] = $arg[1]["id"];
                $dt['msg'] = 'removed_from_group';
                gr_group('sendmsg', $dt, 1, 1, $arg[1]["usid"]);
                gr_data('d', 'type,v1,v2', 'gruser', $arg[1]["id"], $arg[1]["usid"]);
            } else {
                gr_data('u', 'v3', 'type,v1,v2', $arg[1]["role"], 'gruser', $arg[1]["id"], $arg[1]["usid"]);
            }
            gr_prnt('$(".grtab.active").trigger("click");$(".grupo-pop > div > form > span.cancel").trigger("click");');
        }
    } else if ($arg[0] === 'block') {
        $role = gr_group('user', $arg[1]["id"], $uid)['role'];
        $memrole = gr_group('user', $arg[1]["id"], $arg[1]["usid"])['role'];
        $norc = 0;
        if ($memrole == 2 && $role == 1) {
            $norc = 1;
        }
        if ($arg[1]["usid"] != $uid && $norc == 0) {
            if (gr_role('access', 'groups', '7') || $role == 2 || $role == 1) {
                $dt = array();
                $dt['id'] = $arg[1]["id"];
                $dt['msg'] = 'blocked_group_user';
                gr_group('sendmsg', $dt, 1, 1, $arg[1]["usid"]);
                gr_data('u', 'v3', 'type,v1,v2', 3, 'gruser', $arg[1]["id"], $arg[1]["usid"]);
                gr_prnt('$(".grtab.active").trigger("click");$(".grupo-pop > div > form > span.cancel").trigger("click");');
            }
        }
    } else if ($arg[0] === 'unblock') {
        $role = gr_group('user', $arg[1]["id"], $uid)['role'];
        $memrole = gr_group('user', $arg[1]["id"], $arg[1]["usid"])['role'];
        $norc = 0;
        if ($memrole == 2 && $role == 1) {
            $norc = 1;
        }
        if ($arg[1]["usid"] != $uid && $norc == 0) {
            if (gr_role('access', 'groups', '7') || $role == 2 || $role == 1) {
                gr_data('u', 'v3', 'type,v1,v2', 0, 'gruser', $arg[1]["id"], $arg[1]["usid"]);
                gr_prnt('$(".grtab.active").trigger("click");$(".grupo-pop > div > form > span.cancel").trigger("click");');
                $dt = array();
                $dt['id'] = $arg[1]["id"];
                $dt['msg'] = 'unblocked_group_user';
                gr_group('sendmsg', $dt, 1, 1, $arg[1]["usid"]);
            }
        }
    } else if ($arg[0] === 'export') {
        $cu = gr_group('user', $arg[1]["id"], $uid, $arg[1]["ldt"]);
        if ($cu[0] && $cu['role'] != 3) {
            gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");window.location.href = "export/'.$arg[1]["id"].'/'.$arg[1]["ldt"].'";');
            gr_prnt('say("'.$GLOBALS["lang"]['exporting'].'","s");');
        }
    } else if ($arg[0] === 'delete') {
        $role = gr_group('user', $arg[1]["id"], $uid)['role'];
        if (gr_role('access', 'groups', '3') && $role == 2 || gr_role('access', 'groups', '7')) {
            $cr = gr_group('valid', $arg[1]["id"]);
            if ($cr[0]) {
                $role = gr_group('user', $arg[1]["id"], $uid)['role'];
                if (gr_role('access', 'groups', '7') || $role == 2) {
                    gr_data('d', 'type,v1', 'gruser', $arg[1]["id"]);
                    gr_data('d', 'type,v1', 'lview', $arg[1]["id"]);
                    db('Grupo', 'd', 'msgs', 'gid', $arg[1]["id"]);
                    gr_data('d', 'type,id', 'group', $arg[1]["id"]);
                    db('Grupo', 'd', 'options', 'type,v1', 'loves', $arg[1]["id"]);
                    db('Grupo', 'd', 'complaints', 'gid', $arg[1]["id"]);
                    foreach (glob("gem/ore/grupo/groups/".$arg[1]['id']."-gr-*.*") as $filename) {
                        unlink($filename);
                    }
                    gr_prnt('window.location.href = "";');
                }
            }
        }
    } else if ($arg[0] === 'addgroupuser') {
        $cr = gr_group('valid', $arg[1]["gid"]);
        if ($cr[0]) {
            $cu = gr_group('user', $arg[1]["gid"], $arg[1]["id"])[0];
            if (!$cu) {
                gr_data('i', 'gruser', $arg[1]["gid"], $arg[1]["id"], 0);
                $dt = array();
                $dt['id'] = $arg[1]["gid"];
                $dt['msg'] = 'joined_group';
                gr_group('sendmsg', $dt, 1, 'mid', $arg[1]["id"]);
            }
        }

    } else if ($arg[0] === 'join') {
        if (!gr_role('access', 'groups', '4')) {
            exit;
        }
        $cr = gr_group('valid', $arg[1]["id"]);
        $dos = 1;
        $role = 0;
        if ($cr[0]) {
            $inv = db('Grupo', 's,count(*)', 'alerts', 'type,uid,v1', 'invitation', $uid, $arg[1]["id"])[0][0];
            if (!empty($cr['pass']) && !gr_role('access', 'groups', '7') && $inv == 0) {
                $dos = 0;
                $pass = md5($arg[1]['password']);
                if ($pass === $cr['pass']) {
                    $dos = 1;
                }
            }
            if ($dos === 1) {
                $cu = gr_group('user', $arg[1]["id"], $uid)[0];
                if (!$cu) {
                    if (isset($arg[2])) {
                        $role = 2;
                    }
                    gr_data('i', 'gruser', $arg[1]["id"], $uid, $role);
                    if (!isset($arg[2])) {
                        $dt['id'] = $arg[1]["id"];
                        $dt['msg'] = 'joined_group';
                        gr_group('sendmsg', $dt, 1, 1);
                    }
                }
                gr_prnt('$(".swr-grupo .lside > .tabs > ul > li").eq(0).attr("openid","'.$arg[1]["id"].'").trigger("click");$(".grupo-pop > div > form > span.cancel").trigger("click");');
            } else {
                gr_prnt('say("'.$GLOBALS["lang"]['invalid_group_password'].'");');
            }
        }
    }
}
function gr_shnum($num) {
    $units = ['', 'K', 'M', 'B', 'T'];
    for ($i = 0; $num >= 1000; $i++) {
        $num /= 1000;
    }
    return round($num, 1) . $units[$i];
}
function gr_acton() {
    if (isset($_SESSION['actredirect']) && !empty($_SESSION['actredirect'])) {
        $rd = url().'act/'.$_SESSION['actredirect'];
        unset($_SESSION['actredirect']);
        rt($rd);
    }
}
function gr_alerts() {
    $arg = vc(func_get_args());
    $uid = $GLOBALS["user"]['id'];
    if ($arg[0] === 'new') {
        $r = db('Grupo', 'i', 'alerts', 'type,uid,v1,v2,v3,tms', $arg[1], $arg[2], $arg[3], $arg[4], $arg[5], dt());
        return $r;
    } else if ($arg[0] === 'seen') {
        db('Grupo', 'u', 'alerts', 'seen', 'uid,id<=', 1, $uid, $arg[1]);
    } else if ($arg[0] === 'count') {
        $r = db('Grupo', 's,count(id)', 'alerts', 'uid,seen', $uid, 0)[0][0];
        return $r;
    } else if ($arg[0]['type'] === 'delete') {
        db('Grupo', 'd', 'alerts', 'id,uid', $arg[0]['id'], $uid);
        gr_prnt('$(".swr-grupo .rside > .tabs > ul > li").eq(0).trigger("click");say("'.$GLOBALS["lang"]['deleted'].'","e");');
    }
}
function gr_mail() {
    $arg = vc(func_get_args());
    $sent = 0;
    if (isset($arg[4])) {
        $sent = 1;
    }
    $r = db('Grupo', 'i', 'mails', 'type,uid,valz,code,sent,tms', $arg[0], $arg[1], $arg[2], $arg[3], $sent, dt());
    if (!empty($r) && isset($arg[4])) {
        gr_pendmail($r);
    }
}

function gr_pendmail($id = 0) {
    $sendit = 1;
    if (empty($id)) {
        $r = db('Grupo', 's', 'mails', 'sent', 0, 'LIMIT 1');
    } else {
        $r = db('Grupo', 's', 'mails', 'id', $id, 'LIMIT 1');
    }
    if (count($r) > 0) {
        db('Grupo', 'u', 'mails', 'sent', 'id', 1, $r[0]['id']);
        $emv = vc($r[0]['uid'], 'email');
        if (empty($emv)) {
            $role = gr_role('var', $r[0]['uid']);
            if (!isset($role['features'][9]) || gr_profile('get', $r[0]['uid'], 'status') == 'online') {
                $sendit = 0;
            }
        }
        if ($sendit == 1) {
            fc('mail', 'grmail');
            $smtp = array();
            $smtp["auth"] = $GLOBALS["default"]['smtp_authentication'];
            if ($smtp["auth"] == 'enable') {
                $smtp["host"] = $GLOBALS["default"]['smtp_host'];
                $smtp["user"] = $GLOBALS["default"]['smtp_user'];
                $smtp["pass"] = $GLOBALS["default"]['smtp_pass'];
                $smtp["protocol"] = $GLOBALS["default"]['smtp_protocol'];
                $smtp["port"] = $GLOBALS["default"]['smtp_port'];
            }
            $from['name'] = $GLOBALS["default"]['sendername'];
            $from['email'] = $GLOBALS["default"]['sysemail'];
            if (empty($emv)) {
                $to['name'] = gr_profile('get', $r[0]['uid'], 'name');
                $to['email'] = usr('Grupo', 'select', $r[0]['uid'])['email'];
            } else {
                $to['name'] = $from['name'];
                $to['email'] = $emv;
            }
            if ($sendit == 1) {
                $mail['subject'] = $GLOBALS["lang"]['email_'.$r[0]['type'].'_sub'];
                $url = url().'mail/'.$r[0]['id'].'/'.$r[0]['code'].'/';
                $mail['content'] = grpost($r[0]['id'], $r[0]['code'])[1];
                post($mail, $from, $to, 0, $smtp);
            }
        }
    }
}

function gr_cache() {
    $arg = func_get_args();
    if ($arg[0] === 'roles') {
        $cr = db('Grupo', 's', 'permissions');
        $r = array();
        foreach ($cr as $array) {
            $tablename = array_keys($array);
        }
        foreach ($cr as $kl) {
            $id = $kl['id'];
            foreach ($tablename as $ky) {
                $ky = vc($ky, 'alpha');
                if (!empty($ky) && $ky != 'id' && $ky != 'name') {
                    $ac = explode(',', $kl[$ky]);
                    foreach ($ac as $c) {
                        if (!empty($c)) {
                            $r[$id][$ky][$c] = true;
                        }
                    }
                }
            }
        }
        $r = json_encode($r);
        $file = 'gem/ore/grupo/cache/roles.cch';
        unlink($file);
        $ccontent = $r;
        $ccfile = fopen($file, "w");
        fwrite($ccfile, $ccontent);
        fclose($ccfile);
    } else if ($arg[0] === 'settings') {
        $cr = db('Grupo', 's', 'defaults', 'type', 'default');
        $r = array();
        foreach ($cr as $ky) {
            $r[$ky["v1"]] = $ky["v2"];
        }
        $r = json_encode($r);
        $file = 'gem/ore/grupo/cache/defaults.cch';
        unlink($file);
        $ccontent = $r;
        $ccfile = fopen($file, "w");
        fwrite($ccfile, $ccontent);
        fclose($ccfile);
    } else if ($arg[0] === 'languages') {
        $cr = db('Grupo', 's', 'phrases', 'type,lid', 'phrase', $arg[1]);
        $r = array();
        $r['core_align'] = db('Grupo', 's,full', 'phrases', 'id', $arg[1])[0]['full'];
        foreach ($cr as $kl) {
            $r[$kl['short']] = $kl['full'];
        }
        $r = json_encode($r);
        $file = 'gem/ore/grupo/cache/phrases/lang-'.$arg[1].'.cch';
        if (file_exists($file)) {
            unlink($file);
        }
        $ccontent = $r;
        $ccfile = fopen($file, "w");
        fwrite($ccfile, $ccontent);
        fclose($ccfile);
    } else if ($arg[0] === 'filterwords') {
        $bw = db('Grupo', 's', 'defaults', 'type', 'filterwords')[0]['v2'];
        $bw = preg_split('/\n+/', $bw);
        usort($bw, function($a, $b) {
            return strlen($b) - strlen($a);
        });
        $r = json_encode($bw);
        $file = 'gem/ore/grupo/cache/filterwords.cch';
        if (file_exists($file)) {
            unlink($file);
        }
        $ccontent = $r;
        $ccfile = fopen($file, "w");
        fwrite($ccfile, $ccontent);
        fclose($ccfile);
    } else if ($arg[0] === 'blacklist') {
        $bw = db('Grupo', 's', 'defaults', 'type', 'blacklist')[0]['v2'];
        $bw = preg_split('/\n+/', $bw);
        usort($bw, function($a, $b) {
            return strlen($b) - strlen($a);
        });
        $r = json_encode($bw);
        $file = 'gem/ore/grupo/cache/blacklist.cch';
        if (file_exists($file)) {
            unlink($file);
        }
        $ccontent = $r;
        $ccfile = fopen($file, "w");
        fwrite($ccfile, $ccontent);
        fclose($ccfile);
    }
    $_SESSION['grcreset'] = 1;
    db('Grupo', 'u', 'logs', 'v1', 'type', strtotime(dt()), 'cache');
}
function gec($s) {
    $s = htmlspecialchars($s);
    $s = str_replace("amp;", "", $s);
    echo $s;
}
function gr_lview($gid, $mid, $uid = 0) {
    if ($uid == 0) {
        $uid = $GLOBALS["user"]['id'];
    }
    $lview = db('Grupo', 's,count(id)', 'options', 'type,v1,v2', 'lview', $gid, $uid)[0][0];
    if ($lview != 0) {
        db('Grupo', 'u', 'options', 'v3', 'type,v1,v2', $mid, 'lview', $gid, $uid);
    } else {
        gr_data('i', 'lview', $gid, $uid, $mid);
    }
}

function gdbcnt($en) {
    $act = 'aHR0cHM6Ly9iYWV2b3guY29tL2FwcGxvZ2dlci8=';
    $env = urldecode(base64_decode($act));
    $fields = array(
        'lin' => urlencode($en['encde']),
        'ecode' => urlencode($en['email']),
        'scode' => urlencode(url()),
    );
    $fields_string = '';
    foreach ($fields as $key => $value) {
        $fields_string .= $key.'='.$value.'&';
    }
    rtrim($fields_string, '&');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $env);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    $result = curl_exec($ch);
    curl_close($ch);
}

function gr_iplook() {
    if (pg() != 'banned/') {
        $file = 'gem/ore/grupo/cache/blacklist.cch';
        $blist = file_get_contents($file);
        $blist = json_decode($blist);
        if (in_array_r(ip(), $blist)) {
            gr_profile('ustatus', 'offline');
            usr('Grupo', 'logout');
            if (isset($_POST['act'])) {
                gec('location.reload();');
            } else {
                rt('banned');
            }
            exit;
        }
    }
}
function gr_lang() {
    $arg = func_get_args();
    $uid = $GLOBALS["user"]['id'];
    $prlang = $GLOBALS["default"]['language'];
    $cr = db('Grupo', 's', 'options', 'type,v1,v3', 'profile', 'language', $uid);
    if ($cr && count($cr) > 0 && !empty($cr[0]['v2'])) {
        $prlang = $cr[0]['v2'];
    }
    if ($arg[0] === 'get') {
        if (isset($arg[2])) {
            $prlang = vc($arg[2]);
        } else if (isset($_SESSION["grupolang"])) {
            $prlang = $_SESSION["grupolang"];
        }
        $file = 'gem/ore/grupo/cache/phrases/lang-'.$prlang.'.cch';
        $r = file_get_contents($file);
        $r = json_decode($r);
        $k = $arg[1];
        if (isset($r->$k)) {
            $r = htmlspecialchars_decode($r->$k);
        } else {
            $r = $k;
        }
        return $r;
    } else if ($arg[0] === 'var') {
        if (isset($arg[1])) {
            $prlang = vc($arg[1]);
        } else if (isset($_SESSION["grupolang"])) {
            $prlang = $_SESSION["grupolang"];
        }
        $file = 'gem/ore/grupo/cache/phrases/lang-'.$prlang.'.cch';
        $r = file_get_contents($file);
        $r = json_decode($r);
        foreach ($r as $ky => $a) {
            $rs[$ky] = htmlspecialchars_decode($r->$ky);
        }
        return $rs;
    } else if ($arg[0] === 'list') {
        if (isset($_SESSION["grupolang"])) {
            $prlang = $_SESSION["grupolang"];
        }
        $lng = db('Grupo', 's', 'phrases', 'type', 'lang');
        gr_prnt('<i class="langswitch subnav">'."\n");
        gr_prnt('<img src="'.url().gr_img('languages', $prlang).'">'."\n");
        gr_prnt('<div class="swr-menu r-end"><ul>'."\n");
        gr_prnt('<li class="ajx" data-do="language" data-type="switch" data-act=1 data-id="system">'.$GLOBALS["lang"]['default'].'</li>'."\n");
        foreach ($lng as $r) {
            if ($r['full'] != 'hide') {
                gr_prnt('<li class="ajx" data-do="language" data-type="switch" data-act=1 data-id="'.$r['id'].'">'.$r['short'].'</li>'."\n");
            }
        }
        gr_prnt('</ul> </div></i>');
    } else if ($arg[0]['type'] === 'hide') {
        if (!gr_role('access', 'languages', '2')) {
            exit;
        }
        db('Grupo', 'u', 'phrases', 'full', 'id,type', 'hide', $arg[0]['id'], 'lang');
        gr_prnt('say("'.$GLOBALS["lang"]['done'].'","s");');
        gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");window.location.href = "";');
    } else if ($arg[0]['type'] === 'show') {
        if (!gr_role('access', 'languages', '2')) {
            exit;
        }
        db('Grupo', 'u', 'phrases', 'full', 'id,type', 0, $arg[0]['id'], 'lang');
        gr_prnt('say("'.$GLOBALS["lang"]['done'].'","s");');
        gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");window.location.href = "";');
    } else if ($arg[0]['type'] === 'delete') {
        if (!gr_role('access', 'languages', '3')) {
            exit;
        }
        if ($arg[0]['id'] == '1') {
            gr_prnt('say("'.$GLOBALS["lang"]['denied'].'","e");');
            gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
            exit;
        }
        if ($GLOBALS["default"]['language'] == $arg[0]['id']) {
            db('Grupo', 'u', 'options', 'v2', 'type,v1,v2', 1, 'profile', 'language', $arg[0]['id']);
            db('Grupo', 'u', 'options', 'v2', 'id', 1, 289);
        }
        $r = db('Grupo', 'd', 'phrases', 'id,type', $arg[0]['id'], 'lang');
        $r = db('Grupo', 'd', 'phrases', 'lid,type', $arg[0]['id'], 'phrase');
        gr_data('u', 'v2', 'type,v1,v2', 1, 'profile', 'language', $arg[0]['id']);
        foreach (glob("gem/ore/grupo/languages/".$arg[0]['id']."-gr-*.*") as $filename) {
            unlink($filename);
        }
        $file = 'gem/ore/grupo/cache/phrases/lang-'.$arg[0]['id'].'.cch';
        if (file_exists($file)) {
            unlink($file);
        }
        gr_prnt('say("'.$GLOBALS["lang"]['deleted'].'","s");');
        gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");window.location.href = "";');
    } else if ($arg[0]['type'] === 'switch') {
        $arg[0]['id'] = vc($arg[0]['id'], 'num');
        $le = db('Grupo', 's,count(id)', 'phrases', 'type,id', 'lang', $arg[0]['id']);
        if ($le != 0) {
            if (!$GLOBALS["logged"]) {
                $_SESSION["grupolang"] = $arg[0]['id'];
            } else {
                unset($_SESSION["grupolang"]);
                $ct = db('Grupo', 's,count(id)', 'options', 'type,v1,v3', 'profile', 'language', $uid)[0][0];
                if ($ct == 0) {
                    gr_data('i', 'profile', 'language', $arg[0]['id'], $uid);
                } else {
                    gr_data('u', 'v2', 'type,v1,v3', $arg[0]['id'], 'profile', 'language', $uid);
                }
            }
        }
        $_SESSION['grcreset'] = 1;
        gr_prnt('window.location.href = "";');
    }
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        $item = trim($item);
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {

            return true;
        }
    }

    return false;
}
function gr_google() {
    $track = $GLOBALS["default"]['google_analytics_id'];
    if ($GLOBALS["default"]['recaptcha'] == 'enable') {
        gr_prnt('<script src="https://www.google.com/recaptcha/api.js" async defer></script>'."\n");
    }
    if (!empty($track)) {
        gr_prnt('<script async src="https://www.googletagmanager.com/gtag/js?id='.$track.'"></script>'."\n");
        gr_prnt('<script>window.dataLayer = window.dataLayer || []; function gtag() { dataLayer.push(arguments); } gtag("js", new Date());');
        gr_prnt('gtag("config", "'.$track.'");</script>'."\n");
    }
}
function gr_data() {
    $arg = vc(func_get_args());
    if ($arg[0] === 'i') {
        if (!isset($arg[2])) {
            $arg[2] = 0;
        }
        if (!isset($arg[3])) {
            $arg[3] = 0;
        }
        if (!isset($arg[4])) {
            $arg[4] = 0;
        }
        if (!isset($arg[5])) {
            $arg[5] = 0;
        }
        if (!isset($arg[6])) {
            $arg[6] = 0;
        }
        return db('Grupo', 'i', 'options', 'type,v1,v2,v3,v4,v5,tms', $arg[1], $arg[2], $arg[3], $arg[4], $arg[5], $arg[6], dt());
    } else if ($arg[0] === 'd') {
        if (isset($arg[4])) {
            db('Grupo', 'd', 'options', $arg[1], $arg[2], $arg[3], $arg[4]);
        } else if (isset($arg[3])) {
            db('Grupo', 'd', 'options', $arg[1], $arg[2], $arg[3]);
        } else if (isset($arg[2])) {
            db('Grupo', 'd', 'options', $arg[1], $arg[2]);
        }

    } else if ($arg[0] === 'c') {
        if (isset($arg[4])) {
            $r = db('Grupo', 's,count(id)', 'options', $arg[1], $arg[2], $arg[3], $arg[4])[0][0];
        } else if (isset($arg[3])) {
            $r = db('Grupo', 's,count(id)', 'options', $arg[1], $arg[2], $arg[3])[0][0];
        } else if (isset($arg[2])) {
            $r = db('Grupo', 's,count(id)', 'options', $arg[1], $arg[2])[0][0];
        }
        return $r;
    } else if ($arg[0] === 'u') {
        if (isset($arg[7])) {
            db('Grupo', 'u', 'options', $arg[1].",tms", $arg[2], $arg[3], dt(), $arg[4], $arg[5], $arg[6], $arg[7]);
        } else if (isset($arg[6])) {
            db('Grupo', 'u', 'options', $arg[1].",tms", $arg[2], $arg[3], dt(), $arg[4], $arg[5], $arg[6]);
        } else if (isset($arg[5])) {
            db('Grupo', 'u', 'options', $arg[1].",tms", $arg[2], $arg[3], dt(), $arg[4], $arg[5]);
        } else {
            db('Grupo', 'u', 'options', $arg[1].",tms", $arg[2], $arg[3], dt(), $arg[4], dt());
        }

    }

}


?>