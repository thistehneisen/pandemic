<?php if(!defined('s7V9pz')) {die();}?><?php
function gr_list($do) {
    $sofs = $ofs = 0;
    $lmt = $GLOBALS["default"]['aside_results_perload'];
    $i = 1;
    $unq = 'YmFldm94';
    $uid = $GLOBALS["user"]['id'];
    $list = null;
    $arg = vc(func_get_args());
    gr_profile('ustatus', 'online');
    if (!isset($do["type"])) {
        $do["type"] = null;
    }
    if (isset($do["offset"])) {
        $ofs = vc($do["offset"], 'num');
    }
    if (isset($do["soffset"])) {
        $sofs = vc($do["soffset"], 'num');
    }
    $list[0] = new stdClass();
    $list[0]->offset = $ofs+$lmt;
    $list[0]->soffset = $sofs;
    $list[0]->shw = 'hde';
    $unq = base64_decode($unq);
    $list[0]->icn = 'gi-plus';
    $list[0]->mnu = 0;
    $list[0]->act = 0;
    if ($do["type"] === "pm") {
        if (isset($GLOBALS["roles"]['privatemsg'][2])) {
            if (isset($GLOBALS["roles"]['users'][4])) {
                $list[0]->shw = 'shw';
                $list[0]->icn = 'gi-users';
                $list[0]->mnu = 'mmenu';
                $list[0]->act = 'users';
            } else if (isset($GLOBALS["roles"]['users'][5])) {
                $list[0]->shw = 'shw';
                $list[0]->icn = 'gi-users';
                $list[0]->mnu = 'mmenu';
                $list[0]->act = 'online';
            }
            $src = '"%'.$uid.'%"';
            $r = db('Grupo', 'q', 'SELECT max(id) as id,gid FROM gr_msgs WHERE gid LIKE '.$src.' AND cat="user" GROUP by gid ORDER by id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
            foreach ($r as $v) {
                $chusers = explode('-', $v['gid']);
                if ($chusers[1] == $uid || $chusers[0] == $uid) {
                    if ($chusers[0] == $uid) {
                        $chusers[0] = $chusers[1];
                    }
                    $list[$i] = new stdClass();
                    $list[$i]->img = gr_img('users', $chusers[0]);
                    $list[$i]->name = gr_profile('get', $chusers[0], 'name');
                    $list[$i]->count = 0;
                    $lview = db('Grupo', 's,v3', 'options', 'type,v1,v2', 'lview', $v['gid'], $uid, 'ORDER BY id DESC LIMIT 1');
                    if (count($lview) != 0) {
                        $list[$i]->count = db('Grupo', 's,count(id)', 'msgs', 'gid,id>', $v['gid'], $lview[0]['v3'])[0][0];
                        if ($list[$i]->count != 0) {
                            $list[$i]->count = $list[$i]->count;
                            $list[$i]->countag = $GLOBALS["lang"]['new'];
                        }
                    } else {
                        $msg = db('Grupo', 's,count(id)', 'msgs', 'gid,cat', $v['gid'], 'user')[0][0];
                        $list[$i]->count = $msg;
                        $list[$i]->countag = $GLOBALS["lang"]['new'];
                    }
                    $pstat = gr_profile('get', $chusers[0], 'status');
                    $list[$i]->sub = $GLOBALS["lang"][$pstat];
                    $list[$i]->right = $GLOBALS["lang"]['options'];
                    $list[$i]->rtag = 'type="profile" no="'.$chusers[0].'"';
                    $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
                    $list[$i]->oa = $GLOBALS["lang"]['view'];
                    $list[$i]->oat = 'class="paj"';
                    $list[$i]->icon = "'status ".$pstat."'";
                    $list[$i]->id = 'class="loadgroup paj" ldt="user" no="'.$chusers[0].'"';
                }
                $i = $i+1;
            }
        }
    } else if ($do["type"] === "groups") {
        if (isset($GLOBALS["roles"]['groups'][1])) {
            $list[0]->shw = 'shw';
            $list[0]->icn = 'gi-plus';
            $list[0]->mnu = 'udolist';
            $list[0]->act = 'group';
        }
        $ar = db('Grupo', 's,v1', 'options', 'type,v2', 'gruser', $uid);
        if (count($ar) != 0) {
            $ar = implode(array_column($ar, 'v1'), ",");
        } else {
            $ar = 0;
        }
        $r = db('Grupo', 'q', 'SELECT * FROM gr_options WHERE type="group" AND id IN ('.$ar.') ORDER by tms DESC LIMIT '.$lmt.' OFFSET '.$ofs);
        $lk = $lmt-count($r);
        foreach ($r as $v) {
            $cu = gr_group('user', $v['id'], $uid);
            $list[$i] = new stdClass();
            $list[$i]->img = gr_img('groups', $v['id']);
            $list[$i]->name = $v['v1'];
            $list[$i]->countag = $list[$i]->count = 0;
            $lview = db('Grupo', 's,v3', 'options', 'type,v1,v2', 'lview', $v['id'], $uid, 'ORDER BY id DESC LIMIT 1');
            if (count($lview) != 0) {
                $list[$i]->count = db('Grupo', 's,count(id)', 'msgs', 'gid,id>', $v['id'], $lview[0]['v3'])[0][0];
                if ($list[$i]->count != 0) {
                    $list[$i]->count = $list[$i]->count;
                    $list[$i]->countag = $GLOBALS["lang"]['new'];
                }
            } else {
                $msg = db('Grupo', 's,count(id)', 'msgs', 'gid,cat', $v['id'], 'group')[0][0];
                $list[$i]->count = $msg;
                $list[$i]->countag = $GLOBALS["lang"]['new'];
            }
            $list[$i]->right = $GLOBALS["lang"]['options'];
            $list[$i]->rtag = '';
            $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
            $list[$i]->oa = $GLOBALS["lang"]['view'];
            $list[$i]->oat = 'class="paj"';
            $list[$i]->icon = '';
            if (!empty($v['v2'])) {
                $list[$i]->icon = '"gi-lock" data-toggle="tooltip" data-title="'.$GLOBALS["lang"]['protected_group'].'"';
            }
            if ($v['v3'] == 'secret') {
                $list[$i]->icon = '"gi-eye-off" data-toggle="tooltip" data-title="'.$GLOBALS["lang"]['secret_group'].'"';
            }
            if ($cu['role'] == 3 && !isset($GLOBALS["roles"]['groups'][7])) {
                $list[$i]->id = 'class="say" say="'.$GLOBALS["lang"]['banned'].'" type="e" no="'.$v['id'].'" ldt="group"';
                $list[$i]->sub = $GLOBALS["lang"]['banned'];
            } else {
                $list[$i]->sub = gr_shnum(gr_data('c', 'type,v1', 'gruser', $v['id']))." ".$GLOBALS["lang"]['members'];
                $list[$i]->id = 'class="loadgroup paj" ldt="group" no="'.$v['id'].'"';
            }
            $i = $i+1;
        }
        if ($lk != 0) {
            $list[0]->soffset = $sofs+$lk;
            $rs = array();
            if (isset($GLOBALS["roles"]['groups'][6]) && isset($GLOBALS["roles"]['groups'][11])) {
                $rs = db('Grupo', 'q', 'SELECT * FROM gr_options WHERE type="group" AND id NOT IN ('.$ar.') ORDER by tms DESC LIMIT '.$lk.' OFFSET '.$sofs);
            } else if (isset($GLOBALS["roles"]['groups'][11])) {
                $rs = db('Grupo', 'q', "SELECT * FROM gr_options WHERE type='group' AND v3='secret' AND id NOT IN (".$ar.") ORDER by tms DESC LIMIT ".$lk." OFFSET ".$sofs);
            } else if (isset($GLOBALS["roles"]['groups'][6])) {
                $rs = db('Grupo', 'q', "SELECT * FROM gr_options WHERE type='group' AND v3!='secret' AND id NOT IN (".$ar.") ORDER by tms DESC LIMIT ".$lk." OFFSET ".$sofs);
            }
            foreach ($rs as $v) {
                $cu = gr_group('user', $v['id'], $uid);
                $chusers[0] = $v['id'];
                $list[$i] = new stdClass();
                $list[$i]->img = gr_img('groups', $v['id']);
                $list[$i]->name = $v['v1'];
                $list[$i]->countag = $list[$i]->count = 0;
                $list[$i]->right = $GLOBALS["lang"]['options'];
                $list[$i]->rtag = 'type="profile" no="'.$chusers[0].'"';
                $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
                $list[$i]->oat = 'class="paj"';
                if (!isset($GLOBALS["roles"]['groups'][4]) && !isset($GLOBALS["roles"]['groups'][7])) {
                    $list[$i]->oa = $GLOBALS["lang"]['join'];
                    $list[$i]->id = 'class="say" say="'.$GLOBALS["lang"]['denied'].'" type="e" no="'.$v['id'].'" ldt="group"';
                } else {
                    $list[$i]->oa = $GLOBALS["lang"]['join'];
                    $list[$i]->id = 'class="formpop" title="'.$GLOBALS["lang"]['join_group'].'" do="group" ldt="group" btn="'.$GLOBALS["lang"]['join'].'" act="join" no="'.$v['id'].'"';
                }
                $list[$i]->icon = '';
                if (!empty($v['v2'])) {
                    $list[$i]->icon = '"gi-lock" data-toggle="tooltip" data-title="'.$GLOBALS["lang"]['protected_group'].'"';
                    $list[$i]->sub = $GLOBALS["lang"]['protected_group'];
                }
                if ($v['v3'] == 'secret') {
                    $list[$i]->icon = '"gi-eye-off" data-toggle="tooltip" data-title="'.$GLOBALS["lang"]['secret_group'].'"';
                    $list[$i]->sub = $GLOBALS["lang"]['secret_group'];
                }
                if ($v['v3'] != 'secret' && empty($v['v2'])) {
                    $list[$i]->sub = gr_shnum(gr_data('c', 'type,v1', 'gruser', $v['id']))." ".$GLOBALS["lang"]['members'];
                }
                $i = $i+1;
            }
        }
    } else if ($do["type"] === "crew") {
        $cu = gr_group('user', $do["gid"], $uid);
        if ($cu[0] && $cu['role'] != 3 || isset($GLOBALS["roles"]['groups'][7])) {
            $rz = db('Grupo', 's', 'options', 'type,v1', 'gruser', $do["gid"], 'ORDER BY id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
            foreach ($rz as $key => $f) {
                $dect = db('Grupo', 's,count(id)', 'options', 'type,v1,v3', 'deaccount', 'yes', $f['v2'])[0][0];
                if ($dect > 0) {
                    unset($rz[$key]);
                }
            }
            foreach ($rz as $f) {
                $list[$i] = new stdClass();
                $list[$i]->img = gr_img('users', $f['v2']);
                $list[$i]->name = gr_profile('get', $f['v2'], 'name');
                $list[$i]->count = 0;
                $list[$i]->sub = $GLOBALS["lang"]['member'];
                $sort = 1;
                if ($f['v3'] == 2) {
                    $list[$i]->sub = $GLOBALS["lang"]['admin'];
                    $sort = 3;
                } else if ($f['v3'] == 1) {
                    $list[$i]->sub = $GLOBALS["lang"]['moderator'];
                    $sort = 2;
                } else if ($f['v3'] == 3) {
                    $list[$i]->sub = $GLOBALS["lang"]['blocked'];
                    $sort = 0;
                }
                $list[$i]->right = $GLOBALS["lang"]['options'];
                $list[$i]->rtag = 'type="group" no="'.$f['v1'].'"';
                $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
                if (isset($GLOBALS["roles"]['groups'][7]) || $cu['role'] == 2) {
                    $list[$i]->oa = $GLOBALS["lang"]['edit'];
                    $list[$i]->oat = 'class="formpop" title="'.$GLOBALS["lang"]['roles'].'" data-pname="'.$list[$i]->name.'" pn=1 do="group" btn="'.$GLOBALS["lang"]['update'].'" act="role" data-usr="'.$f['v2'].'"';
                }
                if (isset($GLOBALS["roles"]['privatemsg'][1]) && $f['v2'] != $uid) {
                    $list[$i]->ob = $GLOBALS["lang"]['chat'];
                    $list[$i]->obt = 'class="loadgroup paj" ldt="user" no="'.$f['v2'].'"';
                }
                $norc = 0;
                if ($f['v3'] == 2 && $cu['role'] == 1) {
                    $norc = 1;
                }
                if ($f['v2'] != $uid && $norc == 0) {
                    if (isset($GLOBALS["roles"]['groups'][7]) || $cu['role'] == 2 || $cu['role'] == 1) {
                        if ($f['v3'] == 3) {
                            $list[$i]->oc = $GLOBALS["lang"]['unban'];
                            $list[$i]->oct = 'class="deval" act="unblock" data-usid="'.$f['v2'].'"';
                        } else {
                            $list[$i]->oc = $GLOBALS["lang"]['ban'];
                            $list[$i]->oct = 'class="deval" act="block" data-usid="'.$f['v2'].'"';
                        }
                    } else {
                        $list[$i]->oc = $GLOBALS["lang"]['view'];
                        $list[$i]->oct = 'class="vwp" no="'.$f['v2'].'"';
                    }
                } else {
                    $list[$i]->oc = $GLOBALS["lang"]['view'];
                    $list[$i]->oct = 'class="vwp" no="'.$f['v2'].'"';
                }
                $list[$i]->icon = "'status ".gr_profile('get', $f['v2'], 'status')."'";
                $list[$i]->id = 'data-sort="'.$sort.'" class="crew"';
                $i = $i+1;
            }
        }

    } else if ($do["type"] === "alerts") {
        $id = 0;
        $r = db('Grupo', 's', 'alerts', 'uid', $uid, 'ORDER BY id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
        if (isset($r[0])) {
            $id = $r[0]['id'];
        }
        foreach ($r as $f) {
            $list[$i] = new stdClass();
            $list[$i]->img = gr_img('users', $f['v3']);
            $list[$i]->name = gr_profile('get', $f['v3'], 'name');
            $list[$i]->countag = $list[$i]->count = 0;
            $list[$i]->sub = $GLOBALS["lang"]['alert_'.$f['type']];
            $tms = new DateTime($f['tms']);
            $tmz = new DateTimeZone(gr_profile('get', $uid, 'tmz'));
            $tms->setTimezone($tmz);
            if ($GLOBALS["default"]['time_format'] == 24) {
                $list[$i]->right = $tms->format('H:i');
            } else {
                $list[$i]->right = $tms->format('h:i A');
            }
            $list[$i]->rtag = 'type="alert" no="'.$f['id'].'"';
            $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
            if ($f['type'] == 'invitation') {
                $list[$i]->oa = $GLOBALS["lang"]['join'];
                $list[$i]->oat = 'class="formpop" title="'.$GLOBALS["lang"]['join_group'].'" do="group" btn="'.$GLOBALS["lang"]['join'].'" act="join" no="'.$f['v1'].'"';
            } else if ($f['type'] == 'mentioned' || $f['type'] == 'replied' || $f['type'] == 'liked') {
                $list[$i]->oa = $GLOBALS["lang"]['view'];
                $list[$i]->oat = 'class="loadgroup paj goback" ldt="group" data-block="crew" msgload="'.$f['v2'].'" no="'.$f['v1'].'"';
            } else if ($f['type'] == 'newmsg') {
                $list[$i]->oa = $GLOBALS["lang"]['view'];
                $list[$i]->oat = 'class="loadgroup paj" ldt="user" no="'.$f['v3'].'"';
            }
            $list[$i]->ob = $GLOBALS["lang"]['delete'];
            $list[$i]->obt = 'class="deval" act="delete"';
            $list[$i]->icon = '';
            $list[$i]->id = '';
            if ($f['seen'] == 0) {
                $list[$i]->count = 1;
                $list[$i]->id = 'class="active"';
            }
            $i = $i+1;
        }
        gr_alerts('seen', $id);
    } else if ($do["type"] === "users" || $do["type"] === "addgroupuser" && $do["ldt"] != "user") {
        if (!isset($GLOBALS["roles"]['users'][4])) {
            exit;
        }
        if (isset($GLOBALS["roles"]['users'][1])) {
            $list[0]->shw = 'shw';
            $list[0]->icn = 'gi-plus';
            $list[0]->mnu = 'udolist';
            $list[0]->act = 'user';
        }
        $lists = db('Grupo', 's', 'users', 'id<>,name<>', 0, $unq, 'ORDER BY id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
        foreach ($lists as $f) {
            $list[$i] = new stdClass();
            $list[$i]->img = gr_img('users', $f['id']);
            $list[$i]->name = gr_profile('get', $f['id'], 'name');
            $list[$i]->ltype = $do["type"];
            $list[$i]->count = 0;
            $role = db('Grupo', 's,name', 'permissions', 'id', $f['role'], 'LIMIT 1');
            if (isset($role[0])) {
                $list[$i]->sub = $role[0]['name'];
            } else {
                $list[$i]->sub = $GLOBALS["lang"]['unknown'];
            }
            $deac = db('Grupo', 's,count(id)', 'options', 'type,v1,v3', 'deaccount', 'yes', $f['id'])[0][0];
            if ($deac > 0) {
                $list[$i]->sub = $GLOBALS["lang"]['deactivated'];
            }
            $list[$i]->right = $GLOBALS["lang"]['options'];
            $list[$i]->rtag = 'type="profile" no="'.$f['id'].'"';

            $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
            $list[$i]->oa = $GLOBALS["lang"]['view'];
            $list[$i]->oat = 'class="vwp" no="'.$f['id'].'"';
            if (isset($GLOBALS["roles"]['groups'][12]) && $do["type"] === "addgroupuser") {
                $cu = gr_group('user', $do["gid"], $f['id'])[0];
                if (!$cu) {
                    $list[$i]->ob = $GLOBALS["lang"]['add'];
                    $list[$i]->obt = 'act="addgroupuser"';
                }
            } else {
                if (isset($GLOBALS["roles"]['users'][6])) {
                    $list[$i]->ob = $GLOBALS["lang"]['login'];
                    $list[$i]->obt = 'class="deval" act="login"';
                }

                if (isset($GLOBALS["roles"]['users'][3]) || isset($GLOBALS["roles"]['users'][8])) {
                    $list[$i]->oc = $GLOBALS["lang"]['act'];
                    $list[$i]->oct = 'class="formpop" pn=2 title="'.$GLOBALS["lang"]['take_action'].'" do="profile" btn="'.$GLOBALS["lang"]['confirm'].'" act="act"';
                }
            }
            $list[$i]->icon = "'status ".gr_profile('get', $f['id'], 'status')."'";
            $list[$i]->id = 'class="user"';
            $i = $i+1;
        }
    } else if ($do["type"] === "languages") {
        if (!isset($GLOBALS["roles"]['languages'][4])) {
            exit;
        }
        if (isset($GLOBALS["roles"]['languages'][1])) {
            $list[0]->shw = 'shw';
            $list[0]->icn = 'gi-plus';
            $list[0]->mnu = 'udolist';
            $list[0]->act = 'language';
        }
        $deflang = $GLOBALS["default"]['language'];
        $lists = db('Grupo', 's', 'phrases', 'type', 'lang', 'ORDER BY id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
        foreach ($lists as $f) {
            $list[$i] = new stdClass();
            $list[$i]->img = gr_img('languages', $f['id']);
            $list[$i]->name = $f['short'];
            $list[$i]->count = 0;
            $list[$i]->sub = $GLOBALS["lang"]['language'];
            if ($deflang == $f['id']) {
                $list[$i]->sub = $GLOBALS["lang"]['default'];
            }
            $list[$i]->right = $GLOBALS["lang"]['options'];
            $list[$i]->rtag = 'type="language" no="'.$f['id'].'"';
            $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
            if (isset($GLOBALS["roles"]['languages'][2])) {
                $list[$i]->oa = $GLOBALS["lang"]['edit'];
                $list[$i]->oat = 'class="formpop" title="'.$GLOBALS["lang"]['edit_language'].'" do="edit" btn="'.$GLOBALS["lang"]['update'].'" act="language" data-no="'.$f['id'].'"';
                if ($f['full'] != 'hide') {
                    $list[$i]->ob = $GLOBALS["lang"]['hide'];
                    $list[$i]->obt = 'class="formpop" title="'.$GLOBALS["lang"]['hide_language'].'" data-name="'.$f['short'].'" do="language" btn="'.$GLOBALS["lang"]['hide'].'" act="hide" data-no="'.$f['id'].'"';
                } else {
                    $list[$i]->ob = $GLOBALS["lang"]['show'];
                    $list[$i]->obt = 'class="formpop" title="'.$GLOBALS["lang"]['show_language'].'" data-name="'.$f['short'].'" do="language" btn="'.$GLOBALS["lang"]['show'].'" act="show" data-no="'.$f['id'].'"';
                }
            }
            if (isset($GLOBALS["roles"]['languages'][3]) && $f['id'] != 1) {
                $list[$i]->oc = $GLOBALS["lang"]['delete'];
                $list[$i]->oct = 'class="formpop" pn=2 title="'.$GLOBALS["lang"]['confirm'].'" data-name="'.$f['short'].'" data-no="'.$f['id'].'" do="language" btn="'.$GLOBALS["lang"]['delete'].'" act="delete"';
            }
            $list[$i]->icon = "";
            $list[$i]->id = 'class="language"';
            $i = $i+1;
        }
    } else if ($do["type"] === "complaints") {
        $cu = gr_group('user', $do["gid"], $uid);
        if (!$cu[0] || $cu['role'] == 3 && !isset($GLOBALS["roles"]['groups'][7])) {
            exit;
        }
        $lists = db('Grupo', 's', 'complaints', 'uid,gid', $uid, $do["gid"], 'ORDER BY id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
        if ($cu['role'] == 2 || $cu['role'] == 1) {
            $lists = db('Grupo', 's', 'complaints', 'gid,msid<>', $do["gid"], 0, 'ORDER BY status ASC LIMIT '.$lmt.' OFFSET '.$ofs);
        }
        if (isset($GLOBALS["roles"]['groups'][7])) {
            $lists = db('Grupo', 's', 'complaints', 'gid', $do["gid"], 'ORDER BY status ASC LIMIT '.$lmt.' OFFSET '.$ofs);
        }
        foreach ($lists as $f) {
            $list[$i] = new stdClass();
            $list[$i]->img = gr_img('users', $f['uid']);
            $list[$i]->name = "COMP#".$f['id'];
            $list[$i]->count = $list[$i]->countag = 0;
            $list[$i]->sub = $GLOBALS["lang"]['under_investigation'];
            $list[$i]->count = 1;
            if ($f['status'] == 2) {
                $list[$i]->sub = $GLOBALS["lang"]['action_taken'];
                $list[$i]->count = 0;
            } else if ($f['status'] == 3) {
                $list[$i]->sub = $GLOBALS["lang"]['rejected'];
                $list[$i]->count = 0;
            }
            $list[$i]->right = $GLOBALS["lang"]['options'];
            $list[$i]->rtag = 'type="group" no="'.$f['gid'].'"';
            $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;

            $list[$i]->ob = $GLOBALS["lang"]['view'];
            $list[$i]->obt = 'class="formpop" title="'.$GLOBALS["lang"]['view_complaint'].'" do="group" btn="'.$GLOBALS["lang"]['update'].'" act="takeaction" data-no="'.$f['id'].'"';
            if (!empty($f['msid'])) {
                $list[$i]->oa = $GLOBALS["lang"]['proof'];
                $list[$i]->oat = 'class="turnchat goback" data-block="crew" act="msgs" data-msid="'.$f['msid'].'"';
            }
            $list[$i]->icon = "";
            $list[$i]->id = '';
            $i = $i+1;
        }
    } else if ($do["type"] === "rusers") {
        if (!isset($GLOBALS["roles"]['roles'][3])) {
            exit;
        }
        $lists = db('Grupo', 's', 'users', 'role,name<>', $do["xtra"], $unq, 'ORDER BY id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
        foreach ($lists as $f) {
            $list[$i] = new stdClass();
            $list[$i]->img = gr_img('users', $f['id']);
            $list[$i]->name = gr_profile('get', $f['id'], 'name');
            $list[$i]->count = 0;
            $list[$i]->sub = $f['email'];
            $list[$i]->right = $GLOBALS["lang"]['options'];
            $list[$i]->rtag = 'type="profile" no="'.$f['id'].'"';
            $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
            $list[$i]->oa = $GLOBALS["lang"]['view'];
            $list[$i]->oat = 'class="vwp" no="'.$f['id'].'"';
            if (isset($GLOBALS["roles"]['users'][6])) {
                $list[$i]->ob = $GLOBALS["lang"]['login'];
                $list[$i]->obt = 'class="deval" act="login"';
            }
            if (isset($GLOBALS["roles"]['users'][3]) || isset($GLOBALS["roles"]['users'][8])) {
                $list[$i]->oc = $GLOBALS["lang"]['act'];
                $list[$i]->oct = 'class="formpop" pn=2 title="'.$GLOBALS["lang"]['take_action'].'" do="profile" btn="'.$GLOBALS["lang"]['confirm'].'" act="act"';
            }
            $list[$i]->icon = "'status ".gr_profile('get', $f['id'], 'status')."'";
            $list[$i]->id = 'class="user"';
            $i = $i+1;
        }
    } else if ($do["type"] === "lastseen") {
        if (isset($do['search']) && !empty($do['search'])) {
            $verf = db('Grupo', 's,count(id)', 'msgs', 'id,uid', $do['search'], $uid)[0][0];
            if ($verf != 0) {
                $lists = db('Grupo', 's', 'options', 'type,v1,v3>=,v2<>', 'lview', $do['gid'], $do['search'], $uid, 'ORDER BY id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
                foreach ($lists as $f) {
                    $list[$i] = new stdClass();
                    $list[$i]->img = gr_img('users', $f['v2']);
                    $list[$i]->name = gr_profile('get', $f['v2'], 'name');
                    $list[$i]->count = 0;
                    $usrost = gr_profile('get', $f['v2'], 'status');
                    $list[$i]->sub = $GLOBALS["lang"][$usrost];
                    $list[$i]->right = $GLOBALS["lang"]['options'];
                    $list[$i]->rtag = 'type="profile" no="'.$f['v2'].'"';
                    $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
                    $list[$i]->oa = $GLOBALS["lang"]['view'];
                    $list[$i]->oat = 'class="vwp" no="'.$f['v2'].'"';
                    if (isset($GLOBALS["roles"]['privatemsg'][1]) && $f['v2'] != $uid) {
                        $list[$i]->ob = $GLOBALS["lang"]['chat'];
                        $list[$i]->obt = 'class="loadgroup paj" ldt="user" no="'.$f['v2'].'"';
                    }
                    $list[$i]->icon = "'status ".$usrost."'";
                    $list[$i]->id = 'class="user"';
                    $i = $i+1;
                }
            }
        }
    } else if ($do["type"] === "online") {
        if (!isset($GLOBALS["roles"]['users'][5])) {
            exit;
        }
        $r = db('Grupo', 's', 'options', 'type,v1,v2|,type,v1,v2', 'profile', 'status', 'online', 'profile', 'status', 'idle', ' LIMIT '.$lmt.' OFFSET '.$ofs);
        foreach ($r as $f) {
            $usrn = usr('Grupo', 'select', $f['v3']);
            if ($f['v3'] !== $uid && $usrn['name'] != $unq) {
                $list[$i] = new stdClass();
                $list[$i]->img = gr_img('users', $f['v3']);
                $list[$i]->name = gr_profile('get', $f['v3'], 'name');
                $list[$i]->count = 0;
                $list[$i]->sub = '';
                $list[$i]->user = '';
                if (isset($usrn['name'])) {
                    $list[$i]->sub = '@'.$usrn['name'];
                }
                $list[$i]->right = $GLOBALS["lang"]['options'];
                $list[$i]->rtag = 'type="profile" no="'.$f['v3'].'"';
                $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
                $list[$i]->oa = $GLOBALS["lang"]['view'];
                $list[$i]->oat = 'class="vwp" no="'.$f['v3'].'"';
                if (isset($GLOBALS["roles"]['privatemsg'][1])) {
                    $list[$i]->ob = $GLOBALS["lang"]['chat'];
                    $list[$i]->obt = 'class="loadgroup paj" ldt="user" no="'.$f['v3'].'"';
                }
                if (isset($GLOBALS["roles"]['users'][3]) || isset($GLOBALS["roles"]['users'][8])) {
                    $list[$i]->oc = $GLOBALS["lang"]['act'];
                    $list[$i]->oct = 'class="formpop" pn=2 title="'.$GLOBALS["lang"]['take_action'].'" do="profile" btn="'.$GLOBALS["lang"]['confirm'].'" act="act"';
                }
                $list[$i]->icon = "'status ".$f['v2']."'";
                $list[$i]->id = 'data-sort="'.strtotime($f['tms']).'"';
                $i = $i+1;
            }
        }
    } else if ($do["type"] === "roles") {
        if (!isset($GLOBALS["roles"]['roles'][3])) {
            exit;
        }
        if (isset($GLOBALS["roles"]['roles'][1])) {
            $list[0]->shw = 'shw';
            $list[0]->icn = 'gi-plus';
            $list[0]->mnu = 'udolist';
            $list[0]->act = 'role';
        }
        $lists = db('Grupo', 's', 'permissions', 'id<>', 0, 'ORDER BY id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
        foreach ($lists as $f) {

            $list[$i] = new stdClass();
            $list[$i]->img = gr_img('roles', $f['id']);
            $list[$i]->name = $f['name'];
            $list[$i]->count = 0;
            $list[$i]->sub = db('Grupo', 's,count(*)', 'users', 'role,name<>', $f['id'], $unq)[0][0].' '.$GLOBALS["lang"]['users'];
            $list[$i]->right = $GLOBALS["lang"]['options'];
            $list[$i]->rtag = 'type="role" no="'.$f['id'].'"';
            $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
            if (isset($GLOBALS["roles"]['roles'][3])) {
                $list[$i]->oa = $GLOBALS["lang"]['users'];
                $list[$i]->oat = 'class="mbopen loadside" xtra="'.$f['id'].'" data-block="rside" act="rusers" side="rside" zero="0" zval="'.$GLOBALS["lang"]['zero_users'].'"';
            }
            if (isset($GLOBALS["roles"]['roles'][2])) {
                $list[$i]->ob = $GLOBALS["lang"]['edit'];
                $list[$i]->obt = 'class="formpop" title="'.$GLOBALS["lang"]['edit_role'].'" do="edit" btn="'.$GLOBALS["lang"]['update'].'" act="role" data-name="'.$f['name'].'" data-no="'.$f['id'].'"';
            }
            if (isset($GLOBALS["roles"]['roles'][2])) {
                $list[$i]->oc = $GLOBALS["lang"]['delete'];
                $list[$i]->oct = 'class="formpop" data-name="'.$f['name'].'" data-no="'.$f['id'].'" title="'.$GLOBALS["lang"]['confirm'].'" do="role" btn="'.$GLOBALS["lang"]['delete'].'" act="delete"';
            }
            $list[$i]->icon = '';
            $list[$i]->id = '';
            $i = $i+1;
        }
    } else if ($do["type"] === "files") {
        if (!isset($GLOBALS["roles"]['files']['5'])) {
            exit;
        }
        if (isset($GLOBALS["roles"]['files'][1])) {
            $list[0]->shw = 'shw';
            $list[0]->icn = 'gi-upload';
            $list[0]->mnu = 'udolist';
            $list[0]->act = 'uploadfile';
        }
        $dir = 'grupo/files/'.$uid.'/';
        $r = flr('list', $dir);
        $r = array_slice($r, $ofs, $lmt);
        foreach ($r as $f) {
            $list[$i] = new stdClass();
            $list[$i]->img = "gem/ore/grupo/ext/default.png";
            $im = "gem/ore/grupo/ext/".pathinfo($f, PATHINFO_EXTENSION).".png";
            $n = basename($f);
            if (file_exists($im)) {
                $list[$i]->img = $im;
            }
            $list[$i]->name = explode('-gr-', $n, 2)[1];
            $list[$i]->sub = flr('size', $dir.$n);
            $list[$i]->count = '0';
            $list[$i]->right = $GLOBALS["lang"]['options'];
            $list[$i]->rtag = 'type="files" no="'.$n.'"';
            $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
            if (isset($GLOBALS["roles"]['files'][4])) {
                $list[$i]->oa = $GLOBALS["lang"]['share'];
                $list[$i]->oat = 'class="mbopen" data-block="panel" act="share"';
            }
            if (isset($GLOBALS["roles"]['files'][2])) {
                $list[$i]->ob = $GLOBALS["lang"]['zip'];
                $list[$i]->obt = 'class="deval" act="zip"';
            }
            if (isset($GLOBALS["roles"]['files'][3])) {
                $list[$i]->oc = $GLOBALS["lang"]['delete'];
                $list[$i]->oct = 'class="formpop" pn=2 title="'.$GLOBALS["lang"]['confirm'].'" do="files"  btn="'.$GLOBALS["lang"]['delete'].'" act="delete"';
            }
            $list[$i]->icon = "";
            $list[$i]->id = 'class="file"';
            $i = $i+1;
        }
    } else if ($do["type"] === "ufields") {
        if (isset($GLOBALS["roles"]['fields'][4])) {
            if (isset($GLOBALS["roles"]['fields'][1])) {
                $list[0]->shw = 'shw';
                $list[0]->icn = 'gi-plus';
                $list[0]->mnu = 'udolist';
                $list[0]->act = 'customfield';
            }
            $lists = db('Grupo', 's', 'profiles', 'type', 'field', 'ORDER BY id DESC LIMIT '.$lmt.' OFFSET '.$ofs);
            foreach ($lists as $f) {
                $list[$i] = new stdClass();
                $list[$i]->img = gr_img('fields', $f['cat']);
                $list[$i]->name = $GLOBALS["lang"][$f['name']];
                $list[$i]->count = 0;
                $list[$i]->sub = $GLOBALS["lang"][$f['cat']];
                $list[$i]->right = $GLOBALS["lang"]['options'];
                $list[$i]->rtag = 'type="role" no="'.$f['id'].'"';
                $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
                if (isset($GLOBALS["roles"]['fields'][2])) {
                    $list[$i]->ob = $GLOBALS["lang"]['edit'];
                    $list[$i]->obt = 'class="formpop" title="'.$GLOBALS["lang"]['edit_custom_field'].'" do="edit" btn="'.$GLOBALS["lang"]['update'].'" act="customfield" data-name="'.$f['name'].'" data-no="'.$f['id'].'"';
                }
                if (isset($GLOBALS["roles"]['fields'][3])) {
                    $list[$i]->oc = $GLOBALS["lang"]['delete'];
                    $list[$i]->oct = 'class="formpop" data-name="'.$f['name'].'" data-no="'.$f['id'].'" title="'.$GLOBALS["lang"]['confirm'].'" do="customfield" btn="'.$GLOBALS["lang"]['delete'].'" act="delete"';
                }
                $list[$i]->icon = '';
                $list[$i]->id = '';
                $i = $i+1;
            }
        }
    } else if ($do["type"] === "getuserinfo") {
        $i = 0;
        unset($list[0]);
        $list[$i] = new stdClass();
        $list[$i]->id = $do['id'];
        $list[$i]->edit = 0;
        $list[$i]->btn = $GLOBALS["lang"]['message'];
        $list[$i]->msgoffmsg = $list[$i]->msgoff = 0;
        if (isset($do['ldt']) && $do['ldt'] == 'group') {
            $list[$i]->img = gr_img('groups', $do['id']);
            $grp = db("Grupo", 's', 'options', 'type,id', 'group', $do['id']);
            $list[$i]->uname = $GLOBALS["lang"]['public_group'];
            if (isset($grp[0])) {
                $list[$i]->name = $grp[0]['v1'];
                if (!empty($grp[0]['v2'])) {
                    $list[$i]->uname = $GLOBALS["lang"]['protected_group'];
                }
                if ($grp[0]['v3'] == 'secret') {
                    $list[$i]->uname = $GLOBALS["lang"]['secret_group'];
                }
            } else {
                $list[$i]->name = $GLOBALS["lang"]['unknown'];
            }
        } else {
            $list[$i]->img = gr_img('users', $do['id']);
            $usrn = usr('Grupo', 'select', $do['id']);
            $list[$i]->cp = gr_img('coverpic/users', $do['id']);
            if (isset($GLOBALS["roles"]['users'][2]) && $do['id'] != $uid && $usrn['name'] != $unq) {
                if (isset($usrn['name'])) {
                    $list[$i]->edit = 1;
                }
            }
            if (!isset($GLOBALS["roles"]['privatemsg'][1]) || !isset($usrn['name'])) {
                $list[$i]->msgoff = 1;
                $list[$i]->msgoffmsg = $GLOBALS["lang"]['denied'];
                if (!isset($usrn['name'])) {
                    $list[$i]->msgoffmsg = $GLOBALS["lang"]['profile_noexists'];
                }
            }
            if ($do['id'] == $uid) {
                $list[$i]->edit = 2;
                $list[$i]->btn = $GLOBALS["lang"]['edit_profile'];
            }
            $list[$i]->name = gr_profile('get', $do['id'], 'name');
            if (isset($usrn['name'])) {
                $list[$i]->uname = '@'.$usrn['name'];
            } else {
                $list[$i]->uname = $GLOBALS["lang"]['unknown'];
            }
        }
        $shr = db('Grupo', 's,count(id)', 'msgs', 'type,uid', 'file', $do['id'])[0][0];
        $list[$i]->shares = gr_shnum($shr);
        $list[$i]->loves = gr_shnum(db('Grupo', 's,count(*)', 'options', 'type,v3', 'loves', $do['id'])[0][0]);
        $lastlg = db('Grupo', 's', 'utrack', 'uid', $do['id'], 'ORDER BY tms DESC LIMIT 1');
        if (count($lastlg) > 0) {
            $tms = new DateTime($lastlg[0]['tms']);
        } else if (isset($usrn['name'])) {
            $tms = new DateTime(usr('Grupo', 'select', $do['id'])['altered']);
        } else {
            $tms = new DateTime();
        }
        $tmz = new DateTimeZone(gr_profile('get', $uid, 'tmz'));
        $tms->setTimezone($tmz);
        $tmst = strtotime($tms->format('Y-m-d H:i:s'));
        $list[$i]->lastlg = $tms->format('d-m-y');
        if ($GLOBALS["default"]['time_format'] == 24) {
            $list[$i]->lastlgtm = $tms->format('H:i:s');
        } else {
            $list[$i]->lastlgtm = $tms->format('h:i:s a');
        }
        $lists = db('Grupo', 's', 'profiles', 'type', 'field');
        foreach ($lists as $f) {
            $pf = $f['name'];
            $ct = db('Grupo', 's', 'profiles', 'type,name,uid', 'profile', $f['id'], $do['id']);
            if (count($ct) > 0) {
                $vpf = html_entity_decode($ct[0]['v1']);
                $list[$pf] = new stdClass();
                $list[$pf]-> name = $GLOBALS["lang"][$f['name']];
                $list[$pf]-> cont = $vpf;
                if ($f['cat'] == 'datefield') {
                    $list[$pf]-> cont = date("d-M-Y", strtotime($list[$pf]-> cont));
                }
            }
        }

    } else if ($do["type"] === "memsearch") {
        $i = 0;
        unset($list[0]);
        $do['ser'] = vc($do['ser'], 'alphanum', 1);
        if (!empty($do['ser'])) {
            $rs = db('Grupo', 's', 'options', 'type,v1,v2 LIKE|,v4 LIKE,type,v1', 'profile', 'name', '%'.$do['ser'].'%', '%'.$do['ser'].'%', 'profile', 'name', 'LIMIT 4');
            foreach ($rs as $key => $f) {
                $dect = db('Grupo', 's,count(*)', 'options', 'type,v1,v3', 'deaccount', 'yes', $f['v3'])[0][0];
                if ($dect > 0) {
                    unset($rs[$key]);
                }
            }
            foreach ($rs as $f) {
                if ($f['v3'] !== $uid) {
                    $cu = gr_group('user', $do["gid"], $f['v3']);
                    if ($cu[0]) {
                        $list[$i] = new stdClass();
                        $list[$i]->img = gr_img('users', $f['v3']);
                        $list[$i]->name = $f['v2'];
                        $list[$i]->uname = $f['v4'];
                    }
                }
                $i = $i+1;
            }
        }
    } else if ($do["type"] === "search") {
        if (isset($do['search']) && strlen($do['search']) > 2 && $ofs == 0) {
            $rsta = $rstb = $rstc = $rstd = $rste = $rstf = array();
            $rsta = db('Grupo', 's', 'options', 'type,v1,v2 LIKE|,v4 LIKE,type,v1', 'profile', 'name', '%'.$do['search'].'%', '%'.$do['search'].'%', 'profile', 'name', 'LIMIT 2');
            if (isset($GLOBALS["roles"]['groups'][6]) && isset($GLOBALS["roles"]['groups'][11])) {
                $rstb = db('Grupo', 's', 'options', 'type,v1 LIKE', 'group', '%'.$do['search'].'%', 'LIMIT 2');
            } else if (isset($GLOBALS["roles"]['groups'][11])) {
                $rstb = db('Grupo', 's', 'options', 'type,v3,v1 LIKE', 'group', 'secret', '%'.$do['search'].'%', 'LIMIT 2');
            } else if (isset($GLOBALS["roles"]['groups'][6])) {
                $rstb = db('Grupo', 's', 'options', 'type,v3<>,v1 LIKE', 'group', 'secret', '%'.$do['search'].'%', 'LIMIT 2');
            }
            if (empty($rstb)) {
                $ar = db('Grupo', 's,v1', 'options', 'type,v2', 'gruser', $uid);
                if (count($ar) != 0) {
                    $ar = implode(array_column($ar, 'v1'), ",");
                } else {
                    $ar = 0;
                }
                $rstb = db('Grupo', 'q', 'SELECT * FROM gr_options WHERE type="group" AND v1 LIKE "%'.$do['search'].'%" AND id IN ('.$ar.') LIMIT 2');
            }
            if (isset($GLOBALS["roles"]['languages'][4])) {
                $rstc = db('Grupo', 's', 'phrases', 'type,short LIKE', 'lang', '%'.$do['search'].'%', 'LIMIT 2');
            }
            if (isset($GLOBALS["roles"]['roles'][3])) {
                $rstd = db('Grupo', 's', 'permissions', 'name LIKE', '%'.$do['search'].'%', 'LIMIT 2');
            }
            if (isset($GLOBALS["roles"]['fields'][4])) {
                $rste = db('Grupo', 's', 'profiles', 'type,name LIKE', 'field', 'cf_'.$do['search'].'%', 'LIMIT 2');
            }
            if (isset($GLOBALS["roles"]['files'][5])) {
                $dir = 'gem/ore/grupo/files/'.$uid.'/';
                $pattern = "*".$do['search']."*";
                $rstf = glob($dir. '/' . $pattern, GLOB_BRACE);
            }
            $rst = array_merge($rsta, $rstb, $rstc, $rstd, $rste, $rstf);
            foreach ($rst as $f) {
                $list[$i] = new stdClass();
                $list[$i]->count = 0;
                $list[$i]->right = $GLOBALS["lang"]['options'];
                $list[$i]->rtag = 0;
                $list[$i]->oa = $list[$i]->ob = $list[$i]->oc = 0;
                $list[$i]->icon = 0;
                $list[$i]->id = 0;

                if (isset($f['type']) && $f['type'] == 'profile') {
                    $list[$i]->img = gr_img('users', $f['v3']);
                    $list[$i]->name = $f['v2'];
                    $list[$i]->sub = $GLOBALS["lang"]['users'];
                    $list[$i]->oa = $GLOBALS["lang"]['view'];
                    $list[$i]->oat = 'class="vwp" no="'.$f['v3'].'"';
                } else if (isset($f['type']) && $f['type'] == 'group') {
                    $list[$i]->img = gr_img('groups', $f['id']);
                    $list[$i]->name = $f['v1'];
                    $list[$i]->sub = $GLOBALS["lang"]['groups'];
                    $list[$i]->oat = 'class="paj"';
                    $list[$i]->icon = '';
                    if (!empty($f['v2'])) {
                        $list[$i]->icon = '"gi-lock" data-toggle="tooltip" data-title="'.$GLOBALS["lang"]['protected_group'].'"';
                    }
                    if ($f['v3'] == 'secret') {
                        $list[$i]->icon = '"gi-eye-off" data-toggle="tooltip" data-title="'.$GLOBALS["lang"]['secret_group'].'"';
                    }
                    $cu = gr_group('user', $f['id'], $uid);
                    if ($cu[0]) {
                        $list[$i]->oa = $GLOBALS["lang"]['view'];
                        $list[$i]->id = 'class="loadgroup paj" ldt="group" no="'.$f['id'].'"';
                        if ($cu['role'] == 3 && !isset($GLOBALS["roles"]['groups'][7])) {
                            $list[$i]->id = 'class="say" say="'.$GLOBALS["lang"]['banned'].'" type="e" no="'.$f['id'].'" ldt="group"';
                        }
                    } else {
                        $list[$i]->oa = $GLOBALS["lang"]['join'];
                        if (!isset($GLOBALS["roles"]['groups'][4]) && !isset($GLOBALS["roles"]['groups'][7])) {
                            $list[$i]->id = 'class="say" say="'.$GLOBALS["lang"]['denied'].'" type="e" no="'.$f['id'].'" ldt="group"';
                        } else {
                            $list[$i]->id = 'class="formpop" title="'.$GLOBALS["lang"]['join_group'].'" do="group" ldt="group" btn="'.$GLOBALS["lang"]['join'].'" act="join" no="'.$f['id'].'"';
                        }
                    }
                } else if (isset($f['type']) && $f['type'] == 'lang') {
                    $list[$i]->img = gr_img('languages', $f['id']);
                    $list[$i]->name = $f['short'];
                    $list[$i]->sub = $GLOBALS["lang"]['languages'];
                    if (isset($GLOBALS["roles"]['languages'][2])) {
                        $list[$i]->oa = $GLOBALS["lang"]['edit'];
                        $list[$i]->oat = 'class="formpop" title="'.$GLOBALS["lang"]['edit_language'].'" do="edit" btn="'.$GLOBALS["lang"]['update'].'" act="language" data-no="'.$f['id'].'"';
                    }
                    if (isset($GLOBALS["roles"]['languages'][3])) {
                        $list[$i]->oc = $GLOBALS["lang"]['delete'];
                        $list[$i]->oct = 'class="formpop" pn=2 title="'.$GLOBALS["lang"]['confirm'].'" data-name="'.$f['short'].'" data-no="'.$f['id'].'" do="language" btn="'.$GLOBALS["lang"]['delete'].'" act="delete"';
                    }
                } else if (isset($f['type']) && $f['type'] == 'field') {
                    $list[$i]->img = gr_img('fields', $f['cat']);
                    $list[$i]->name = $GLOBALS["lang"][$f['name']];
                    $list[$i]->sub = $GLOBALS["lang"]['fields'];
                    if (isset($GLOBALS["roles"]['fields'][2])) {
                        $list[$i]->ob = $GLOBALS["lang"]['edit'];
                        $list[$i]->obt = 'class="formpop" title="'.$GLOBALS["lang"]['edit_custom_field'].'" do="edit" btn="'.$GLOBALS["lang"]['update'].'" act="customfield" data-name="'.$f['name'].'" data-no="'.$f['id'].'"';
                    }
                    if (isset($GLOBALS["roles"]['fields'][3])) {
                        $list[$i]->oc = $GLOBALS["lang"]['delete'];
                        $list[$i]->oct = 'class="formpop" data-name="'.$f['name'].'" data-no="'.$f['id'].'" title="'.$GLOBALS["lang"]['confirm'].'" do="customfield" btn="'.$GLOBALS["lang"]['delete'].'" act="delete"';
                    }
                } else if (isset($f['groups']) && isset($f['files'])) {
                    $list[$i]->img = gr_img('roles', $f['id']);
                    $list[$i]->name = $f['name'];
                    $list[$i]->sub = $GLOBALS["lang"]['roles'];
                } else if (file_exists($f)) {
                    $list[$i]->img = "gem/ore/grupo/ext/default.png";
                    $im = "gem/ore/grupo/ext/".pathinfo($f, PATHINFO_EXTENSION).".png";
                    $n = basename($f);
                    if (file_exists($im)) {
                        $list[$i]->img = $im;
                    }
                    $list[$i]->name = explode('-gr-', $n, 2)[1];
                    $list[$i]->id = 'class="file"';
                    $list[$i]->sub = $GLOBALS["lang"]['files'];
                    $list[$i]->rtag = 'type="files" no="'.$n.'"';
                    if (isset($GLOBALS["roles"]['files'][4])) {
                        $list[$i]->oa = $GLOBALS["lang"]['share'];
                        $list[$i]->oat = 'class="mbopen" data-block="panel" act="share"';
                    }
                    if (isset($GLOBALS["roles"]['files'][2])) {
                        $list[$i]->ob = $GLOBALS["lang"]['zip'];
                        $list[$i]->obt = 'class="deval" act="zip"';
                    }
                    if (isset($GLOBALS["roles"]['files'][3])) {
                        $list[$i]->oc = $GLOBALS["lang"]['delete'];
                        $list[$i]->oct = 'class="formpop" pn=2 title="'.$GLOBALS["lang"]['confirm'].'" do="files"  btn="'.$GLOBALS["lang"]['delete'].'" act="delete"';
                    }
                }
                $i = $i+1;
            }
        }
    }
    $r = json_encode($list);
    gr_prnt($r);
}
?>