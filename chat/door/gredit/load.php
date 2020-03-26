<?php if(!defined('s7V9pz')) {die();}?><?php
function gr_edit() {
    $arg = func_get_args();
    $uid = $GLOBALS["user"]['id'];
    if ($arg[0] === 'group') {
        $role = gr_group('user', $arg[1]["id"], $uid)['role'];
        $adm = 0;
        if ($role == 2 || $role == 1) {
            $adm = 1;
        }
        if (gr_role('access', 'groups', '2') && $adm == 1 || gr_role('access', 'groups', '7')) {
            $arg[1]['name'] = vc($arg[1]['name'], 'strip');
            if (!empty($arg[1]['name'])) {
                $cr = db('Grupo', 's,count(*)', 'options', 'type,v1,id<>', 'group', strtolower($arg[1]['name']), $arg[1]['id'])[0][0];
                if ($cr == 0) {
                    $ncode = $code = rn(6).rn(4);;
                    if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
                        $ext = pathinfo($_FILES['img']['name'])['extension'];
                        $ncode = $code.'.'.$ext;
                    }
                    $nmchk = db('Grupo', 's', 'options', 'id', $arg[1]['id']);
                    if ($nmchk[0]['v1'] != $arg[1]['name']) {
                        gr_data('u', 'v1', 'type,id', $arg[1]['name'], 'group', $arg[1]['id']);
                        $dt = array();
                        $dt['id'] = $arg[1]["id"];
                        $dt['msg'] = 'renamed_group';
                        gr_group('sendmsg', $dt, 1, 1);
                    }
                    $pch = 1;
                    if (isset($arg[1]['delpass'])) {
                        if ($arg[1]['delpass'] == 1) {
                            $pch = 0;
                        }
                    }
                    if (!empty($arg[1]['password']) && $pch == 1) {
                        $arg[1]['password'] = md5($arg[1]['password']);
                        gr_data('u', 'v2', 'type,id', $arg[1]['password'], 'group', $arg[1]['id']);
                        $dt = array();
                        $dt['id'] = $arg[1]["id"];
                        $dt['msg'] = 'changed_group_pass';
                        gr_group('sendmsg', $dt, 1, 1);
                    }
                    if (isset($arg[1]['visibility']) && $nmchk[0]['v3'] != $arg[1]['visibility']) {
                        if (!empty($arg[1]['visibility'])) {
                            $arg[1]['visibility'] = 'secret';
                        }
                        gr_data('u', 'v3', 'type,id', $arg[1]['visibility'], 'group', $arg[1]['id']);
                        $dt = array();
                        $dt['id'] = $arg[1]["id"];
                        $dt['msg'] = 'changed_group_visibility';
                        gr_group('sendmsg', $dt, 1, 1);
                    }
                    if (isset($arg[1]['sendperm']) && $nmchk[0]['v5'] != $arg[1]['sendperm']) {
                        if (!empty($arg[1]['sendperm'])) {
                            $arg[1]['sendperm'] = 'adminonly';
                        }
                        gr_data('u', 'v5', 'type,id', $arg[1]['sendperm'], 'group', $arg[1]['id']);
                        $dt = array();
                        $dt['id'] = $arg[1]["id"];
                        $dt['msg'] = 'changed_message_settings';
                        gr_group('sendmsg', $dt, 1, 1);
                    }
                    if (isset($arg[1]['delpass']) && $arg[1]['delpass'] == 1) {
                        gr_data('u', 'v2', 'type,id', '', 'group', $arg[1]['id']);
                        $dt = array();
                        $dt['id'] = $arg[1]["id"];
                        $dt['msg'] = 'removed_group_pass';
                        gr_group('sendmsg', $dt, 1, 1);
                    }
                    if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
                        $icon = $arg[1]['id'].'-gr-'.$code;
                        foreach (glob("gem/ore/grupo/groups/".$arg[1]['id']."-gr-*.*") as $filename) {
                            unlink($filename);
                        }
                        if (flr('upload', 'img', 'grupo/groups/', $icon, 'jpg,jpeg,png,gif', 0, 1)) {
                            flr('resize', 'grupo/groups/'.$icon.'.'.$ext, 0, 150, 150, 1);
                        }
                        $dt = array();
                        $dt['id'] = $arg[1]["id"];
                        $dt['msg'] = 'changed_group_icon';
                        gr_group('sendmsg', $dt, 1, 1);
                    }
                    gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");$(".grupo-pop").fadeOut();');
                } else {
                    gr_prnt('say("'.$GLOBALS["lang"]['already_exists'].'");');
                }
            } else {
                gr_prnt('say("'.$GLOBALS["lang"]['invalid_value'].'");');
            }
        }
    } else if ($arg[0] === 'customfield') {
        if (gr_role('access', 'fields', '2')) {
            $oldfield = db('Grupo', 's', 'profiles', 'type,id', 'field', $arg[1]['id']);
            if (!empty($arg[1]['name']) && !empty($arg[1]['ftype']) && count($oldfield) > 0) {
                $arg[1]['name'] = vc($arg[1]['name'], 'strip');
                $arg[1]['ftype'] = vc($arg[1]['ftype'], 'alpha');
                $shrt = trim(preg_replace('/\s+/', ' ', $arg[1]['name']));
                $opts = $req = 0;
                $shrt = "cf_".strtolower(str_replace(" ", "_", $shrt));
                $chkcf = db('Grupo', 's', 'phrases', 'short', $shrt);
                if (count($chkcf) > 0 && $shrt != $oldfield[0]['name']) {
                    gr_prnt('say("'.$GLOBALS["lang"]['already_exists'].'");');
                } else if ($arg[1]['ftype'] == 'dropdownfield' && empty($arg[1]['options'])) {
                    gr_prnt('say("'.$GLOBALS["lang"]['invalid_value'].'");');
                } else {
                    if (!empty($arg[1]['required'])) {
                        $req = 1;
                    }
                    if ($arg[1]['ftype'] == 'dropdownfield' && !empty($arg[1]['options'])) {
                        $opts = $arg[1]['options'];
                    }
                    $r = db('Grupo', 'u', 'profiles', 'name,cat,v1,req', 'type,id', $shrt, $arg[1]['ftype'], $opts, $req, 'field', $arg[1]['id']);
                    $dlng = db('Grupo', 's', 'phrases', 'type', 'lang');
                    foreach ($dlng as $dl) {
                        db('Grupo', 'u', 'phrases', 'full,short', 'type,short', $arg[1]['name'], $shrt, 'phrase', $oldfield[0]['name']);
                        gr_cache('languages', $dl['id']);
                    }
                    gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");menuclick("mmenu","ufields");$(".grupo-pop").fadeOut();');
                }
            } else {
                gr_prnt('say("'.$GLOBALS["lang"]['invalid_value'].'");');
            }
        }
    } else if ($arg[0] === 'language') {
        if (!gr_role('access', 'languages', '2')) {
            exit;
        }
        if ($arg[1]['id'] == '0') {
            gr_prnt('say("'.$GLOBALS["lang"]['denied'].'","e");');
            gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");');
            exit;
        }
        $r = db('Grupo', 's', 'phrases', 'type,id', 'lang', $arg[1]['id']);
        $arg[1]['name'] = vc($arg[1]['name'], 'strip');
        if (isset($r[0]) && !empty($arg[1]['name'])) {
            $ldir = 'ltr';
            if (isset($arg[1]["direction"]) && $arg[1]["direction"] == 'rtl') {
                $ldir = 'rtl';
            }
            db('Grupo', 'u', 'phrases', 'short,full', 'id', $arg[1]['name'], $ldir, $arg[1]['id']);
            $ph = db('Grupo', 's', 'phrases', 'type,lid', 'phrase', $arg[1]['id']);

            if ($arg[1]["defaultlng"] == 1) {
                db('Grupo', 'u', 'defaults', 'v2', 'type,v1', $arg[1]['id'], 'default', 'language');
            }
            foreach ($ph as $p) {
                $key = 'z'.$p['id'];
                if (!empty($arg[1][$key]) && $arg[1][$key] != $p['full']) {
                    $p['full'] = htmlspecialchars_decode($p['full']);
                    db('Grupo', 'u', 'phrases', 'full', 'lid,type,id', $arg[1][$key], $arg[1]['id'], 'phrase', $p['id']);
                }
            }
        }
        if (isset($_FILES['img']['name']) && !empty($_FILES['img']['name'])) {
            $code = rn(6).rn(4);;
            $ext = pathinfo($_FILES['img']['name'])['extension'];
            $icon = $arg[1]['id'].'-gr-'.$code;
            foreach (glob("gem/ore/grupo/languages/".$arg[1]['id']."-gr-*.*") as $filename) {
                unlink($filename);
            }
            if (flr('upload', 'img', 'grupo/languages/', $icon, 'jpg,jpeg,png,gif', 1, 1)) {
                flr('resize', 'grupo/languages/'.$icon.'.'.$ext, 0, 150, 150, 1);
            }
        }
        gr_cache('languages', $arg[1]['id']);
        gr_cache('settings');
        gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");menuclick("mmenu","languages");');
        gr_prnt('$(".grupo-pop > div > form > span.cancel").trigger("click");window.location.href = "";;');
    } else if ($arg[0] === 'role') {
        if (!gr_role('access', 'roles', '2')) {
            exit;
        }
        $arg[1]['name'] = vc($arg[1]['name'], 'strip');
        if (empty($arg[1]['name'])) {
            gr_prnt('say("'.$GLOBALS["lang"]['invalid_value'].'");');
            exit;
        }
        if (!isset($arg[1]['group'])) {
            $arg[1]['group'] = null;
        } else {
            $arg[1]['group'] = implode(',', $arg[1]['group']);
        }
        if (!isset($arg[1]['files'])) {
            $arg[1]['files'] = null;
        } else {
            $arg[1]['files'] = implode(',', $arg[1]['files']);
        }
        if (!isset($arg[1]['users'])) {
            $arg[1]['users'] = null;
        } else {
            $arg[1]['users'] = implode(',', $arg[1]['users']);
        }
        if (!isset($arg[1]['languages'])) {
            $arg[1]['languages'] = null;
        } else {
            $arg[1]['languages'] = implode(',', $arg[1]['languages']);
        }
        if (!isset($arg[1]['sys'])) {
            $arg[1]['sys'] = null;
        } else {
            $arg[1]['sys'] = implode(',', $arg[1]['sys']);
        }
        if (!isset($arg[1]['roles'])) {
            $arg[1]['roles'] = null;
        } else {
            $arg[1]['roles'] = implode(',', $arg[1]['roles']);
        }
        if (!isset($arg[1]['fields'])) {
            $arg[1]['fields'] = null;
        } else {
            $arg[1]['fields'] = implode(',', $arg[1]['fields']);
        }
        if (!isset($arg[1]['features'])) {
            $arg[1]['features'] = null;
        } else {
            $arg[1]['features'] = implode(',', $arg[1]['features']);
        }
        if (!isset($arg[1]['privatemsg'])) {
            $arg[1]['privatemsg'] = null;
        } else {
            $arg[1]['privatemsg'] = implode(',', $arg[1]['privatemsg']);
        }
        if (!isset($arg[1]['autodel']) || empty(vc($arg[1]['autodel'], 'num'))) {
            $arg[1]['autodel'] = "Off";
        }
        if (!isset($arg[1]['autounjoin']) || empty(vc($arg[1]['autounjoin'], 'num'))) {
            $arg[1]['autounjoin'] = "Off";
        }
        if (isset($_FILES['img']['name']) && !empty($_FILES['img']['name'])) {
            $code = rn(6).rn(4);;
            $ext = pathinfo($_FILES['img']['name'])['extension'];
            $icon = $arg[1]['rid'].'-gr-'.$code;
            foreach (glob("gem/ore/grupo/roles/".$arg[1]['rid']."-gr-*.*") as $filename) {
                unlink($filename);
            }
            if (flr('upload', 'img', 'grupo/roles/', $icon, 'jpg,jpeg,png,gif', 1, 1)) {
                flr('resize', 'grupo/roles/'.$icon.'.'.$ext, 0, 150, 150, 1);
            }
        }
        db('Grupo', 'u', 'permissions', 'name,groups,files,users,features,languages,sys,roles,fields,privatemsg,autodel,autounjoin', 'id', $arg[1]['name'], $arg[1]['group'], $arg[1]['files'], $arg[1]['users'], $arg[1]['features'], $arg[1]['languages'], $arg[1]['sys'], $arg[1]['roles'], $arg[1]['fields'], $arg[1]['privatemsg'], $arg[1]['autodel'], $arg[1]['autounjoin'], $arg[1]['rid']);
        gr_cache('roles');
        gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");menuclick("mmenu","roles");$(".grupo-pop").fadeOut();');
    } else if ($arg[0] === 'avatar') {
        if (!empty($_FILES['cavatar']['name'])) {
            $icon = $uid.'-gr-'.rn(10);
            $ext = pathinfo($_FILES['cavatar']['name'])['extension'];
            foreach (glob("gem/ore/grupo/users/".$uid."-gr-*.*") as $filename) {
                unlink($filename);
            }
            if (flr('upload', 'cavatar', 'grupo/users/', $icon, 'jpg,jpeg,png,gif', 0, 1)) {
                flr('resize', 'grupo/users/'.$icon.'.'.$ext, 0, 150, 150, 1);
            }
        } else if (isset($arg[1]['avatar'])) {
            if (file_exists('gem/ore/grupo/avatars/'.$arg[1]['avatar'])) {
                $icon = $uid.'-gr-'.rn(10);
                foreach (glob("gem/ore/grupo/users/".$uid."-gr-*.*") as $filename) {
                    unlink($filename);
                }
                flr('copy', 'grupo/avatars/'.$arg[1]['avatar'], 'grupo/users/'.$icon.'.png');
            }
        }
        gr_prnt('window.location.href = "";');
    } else if ($arg[0] === 'profile') {
        if (!gr_role('access', 'users', '2')) {
            $arg[1]['id'] = $uid;
        }
        if (usr('Grupo', 'alter', 'email', $arg[1]['email'], $arg[1]['id']) || usr('Grupo', 'select', $arg[1]['id'])['email'] == $arg[1]['email']) {
            if (usr('Grupo', 'alter', 'name', $arg[1]['user'], $arg[1]['id']) || usr('Grupo', 'select', $arg[1]['id'])['name'] == $arg[1]['user']) {
                if (!empty($arg[1]['password'])) {
                    usr('Grupo', 'alter', 'pass', $arg[1]['password'], $arg[1]['id']);
                }
                $arg[1]['name'] = vc($arg[1]['name'], 'strip');
                if (!empty($arg[1]['name'])) {
                    db('Grupo', 'u', 'options', 'v2,v4,v5', 'type,v1,v3', $arg[1]['name'], $arg[1]['user'], $arg[1]['ncolor'], 'profile', 'name', $arg[1]['id']);
                }
                if (gr_role('access', 'roles', '2')) {
                    if (!empty($arg[1]['role'])) {
                        usr('Grupo', 'alter', 'role', $arg[1]['role'], $arg[1]['id']);
                    }
                }
                $lists = db('Grupo', 's', 'profiles', 'type', 'field');
                foreach ($lists as $f) {
                    $pf = $f['name'];
                    if ($f['cat'] == 'datefield') {
                        $arg[1][$pf] = vc($arg[1][$pf], 'date', 'Y-m-d');
                    } else if ($f['cat'] == 'numfield') {
                        $arg[1][$pf] = vc($arg[1][$pf], 'num');
                    } else if ($f['cat'] == 'dropdownfield') {
                        $selc = explode(",", $f['v1']);
                        if (!in_array($arg[1][$pf], $selc)) {
                            $arg[1][$pf] = null;
                        }
                    } else {
                        $arg[1][$pf] = vc($arg[1][$pf]);
                    }
                    if (empty($arg[1][$pf]) && $f['req'] == 1) {
                        gr_prnt('say("'.$GLOBALS["lang"]['invalid_value'].'");'); exit;
                    } else if (empty($arg[1][$pf])) {
                        db('Grupo', 'd', 'profiles', 'type,name,uid', 'profile', $f['id'], $arg[1]['id']);
                    } else {
                        $ct = db('Grupo', 's,count(*)', 'profiles', 'type,name,uid', 'profile', $f['id'], $arg[1]['id'])[0][0];
                        if ($ct == 0) {
                            db('Grupo', 'i', 'profiles', 'type,name,uid,v1', 'profile', $f['id'], $arg[1]['id'], $arg[1][$pf]);
                        } else {
                            db('Grupo', 'u', 'profiles', 'v1', 'type,name,uid', $arg[1][$pf], 'profile', $f['id'], $arg[1]['id']);
                        }
                    }
                }
                if (!empty($arg[1]['tmz'])) {
                    $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                    if (in_array($arg[1]['tmz'], $tzlist) || $arg[1]['tmz'] == 'Auto') {
                        $ct = db('Grupo', 's,count(*)', 'options', 'type,v1,v3', 'profile', 'tmz', $arg[1]['id'])[0][0];
                        if ($ct == 0) {
                            gr_data('i', 'profile', 'tmz', $arg[1]['tmz'], $arg[1]['id']);
                        } else {
                            gr_data('u', 'v2', 'type,v1,v3', $arg[1]['tmz'], 'profile', 'tmz', $arg[1]['id']);
                        }
                    }
                }
                if (!empty($arg[1]['delacc']) && $arg[1]['delacc'] == 'yes') {
                    if (gr_role('access', 'users', '7')) {
                        $ct = db('Grupo', 's', 'options', 'type,v1,v3', 'deaccount', 'yes', $arg[1]['id']);
                        if ($ct && count($ct) > 0) {
                            gr_prnt('say("'.$GLOBALS["lang"]['already_deactivated'].'","e");');
                        } else {
                            $ct = db('Grupo', 'i', 'options', 'type,v1,v3', 'deaccount', 'yes', $arg[1]['id']);
                            gr_prnt('say("'.$GLOBALS["lang"]['deactivated'].'","s");');
                            gr_profile('ustatus', 'offline', $arg[1]['id']);
                            usr('Grupo', 'forcelogout', $arg[1]['id']);
                        }
                    }
                }

                if (!empty($arg[1]['alert'])) {
                    $ct = db('Grupo', 's,count(*)', 'options', 'type,v1,v3', 'profile', 'alert', $arg[1]['id'])[0][0];
                    if ($ct == 0) {
                        gr_data('i', 'profile', 'alert', $arg[1]['alert'], $arg[1]['id']);
                    } else {
                        gr_data('u', 'v2', 'type,v1,v3', $arg[1]['alert'], 'profile', 'alert', $arg[1]['id']);
                    }
                }
                if (!empty($_FILES['cbg']['name'])) {
                    $bg = $arg[1]['id'].'-gr-'.rn(10);
                    $ext = pathinfo($_FILES['cbg']['name'])['extension'];
                    foreach (glob("gem/ore/grupo/userbg/".$arg[1]['id']."-gr-*.*") as $filename) {
                        unlink($filename);
                    }
                    if (flr('upload', 'cbg', 'grupo/userbg/', $bg, 'jpg,jpeg,png,gif', 0, 1)) {
                        if (@is_array(getimagesize('gem/ore/grupo/userbg/'.$bg.'.'.$ext))) {
                            flr('compress', 'grupo/userbg/'.$bg.'.'.$ext, 50);
                        } else {
                            flr('delete', 'grupo/userbg/'.$bg.'.'.$ext);
                        }
                    }

                }
                if (!empty($_FILES['cpic']['name'])) {
                    $bg = $arg[1]['id'].'-gr-'.rn(10);
                    $ext = pathinfo($_FILES['cpic']['name'])['extension'];
                    foreach (glob("gem/ore/grupo/coverpic/users/".$arg[1]['id']."-gr-*.*") as $filename) {
                        unlink($filename);
                    }
                    if (flr('upload', 'cpic', 'grupo/coverpic/users/', $bg, 'jpg,jpeg,png,gif', 0, 1)) {
                        flr('resize', 'grupo/coverpic/users/'.$bg.'.'.$ext, 0, 400, 216, 1);
                    }

                }
                if ($arg[1]['id'] != $uid) {
                    if ($arg[1]['aside'] == 'profile') {
                        gr_prnt('$(".swr-grupo .aside > .content .profile > .top > span.refresh").trigger("click");');
                    } else if ($arg[1]['aside'] != 'right') {
                        gr_prnt('menuclick("mmenu","users");');
                    } else {
                        gr_prnt('$(".rside .xtra").trigger("click");');
                    }
                } else {
                    if (!empty($arg[1]['password'])) {
                        usr('Grupo', 'clear', $arg[1]['id']);
                    }
                    gr_prnt('window.location.href = "";');
                }
                if (empty($arg[1]['delacc']) || $arg[1]['delacc'] != 'yes') {
                    gr_prnt('say("'.$GLOBALS["lang"]['updated'].'","s");');
                }
                $_SESSION['grcreset'] = 1;
                db('Grupo', 'u', 'logs', 'v1', 'type', strtotime(dt()), 'cache');
                gr_prnt('$(".grupo-pop").fadeOut();');
            } else {
                gr_prnt('say("'.$GLOBALS["lang"]['username_exists'].'");');
            }
        } else {
            gr_prnt('say("'.$GLOBALS["lang"]['email_exists'].'");');
        }
    }
}
?>