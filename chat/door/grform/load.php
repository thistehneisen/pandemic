<?php if(!defined('s7V9pz')) {die();}?><?php
function gr_form($do) {
    $uid = $GLOBALS["user"]['id'];
    $lphr = $GLOBALS["lang"];
    $fields = new stdClass();
    if ($do["type"] == "creategroup") {
        if (!gr_role('access', 'groups', '1')) {
            exit;
        }
        $fields->name = array($lphr['group_name'], 'input', 'text');
        $fields->password = array($lphr['password'], 'input', 'text');
        $fields->img = array($lphr['icon'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->visibility = array($lphr['visibility'], 'select', '0', '-----', '0', $lphr['visible'], '1', $lphr['hidden']);
        $postpr[0] = $lphr['group_members'];
        $postpr['adminonly'] = $lphr['admins_moderators'];
        $fields->sendperm = array($lphr['send_messages'], 'select', $postpr);
    } else if ($do["type"] == "createlanguage") {
        if (gr_role('access', 'languages', '1')) {
            $fields->name = array($lphr['language'], 'input', 'text');
            $fields->img = array($lphr['icon'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        }

    } else if ($do["type"] == "createcustomfield") {
        if (gr_role('access', 'fields', '1')) {
            $fields->name = array($lphr['fieldname'], 'input', 'text');
            $fields->required = array($lphr['requiredfield'], 'select', '0', '-----', '1', $lphr['yes'], '0', $lphr['no']);
            $fls = $lphr['shorttext'].','.$lphr['longtext'].','.$lphr['datefield'].','.$lphr['numfield'].','.$lphr['dropdownfield'];
            $fields->ftype = array($lphr['fieldtype'], 'radio:shwopts:shw=opts mtch=dropdownfield', $fls, 'shorttext,longtext,datefield,numfield,dropdownfield');
            $fields->options = array($lphr['fieldoptions'], 'textarea:hidopts opts:', 'text', '', '"'.$lphr['separate_commas'].'"');
        }
    } else if ($do["type"] == "groupdeletemsg") {
        $cu = gr_group('user', $do["id"], $uid, $do["ldt"]);
        if ($cu[0] && $cu['role'] != 3) {
            $fields->fsearch = 'off';
            if (!empty($do["umdt"])) {
                $fields->name = array($lphr['confirm_msgdelete'], 'input:autotimering:', 'text', "'".$do["umdt"]."'");
            } else {
                $fields->name = array($lphr['confirm_delete'], 'input', 'disabled', "'".$lphr["message"]."'");
            }
            if (!empty($do["adt"]) && $do["ldt"] == 'group') {
                $fields->autodel = array($lphr['auto_deleted_after'], 'input:autotimering:', 'text', "'".$do["adt"]."'");
            }
            $fields->id = array('hidden', 'input', 'hidden', $do["id"]);
            $fields->mid = array('hidden', 'input', 'hidden', $do["xtid"]);
            $fields->ldt = array('hidden', 'input', 'hidden', $do["ldt"]);
        }
    } else if ($do["type"] == "filesdownload") {
        $cu = gr_group('user', $do["id"], $uid, $do["ldt"]);
        if ($cu[0] && $cu['role'] != 3) {
            $fields->fsearch = 'off';
            $fields->name = array($lphr['confirm_download'], 'input', 'disabled', "'".$do["file"]."'");
            if (!empty($do["adt"])) {
                $fields->autodel = array($lphr['auto_deleted_after'], 'input:autotimering:', 'text', "'".$do["adt"]."'");
            }
            $fields->gid = array('hidden', 'input', 'hidden', $do["id"]);
            $fields->id = array('hidden', 'input', 'hidden', $do["xtid"]);
            $fields->ldt = array('hidden', 'input', 'hidden', $do["ldt"]);
        }
    } else if ($do["type"] == "groupreportmsg") {
        $cu = gr_group('user', $do["id"], $uid);
        if ($cu[0] && $cu['role'] != 3) {
            if (!isset($do["xtid"]) || empty($do["xtid"])) {
                $do["xtid"] = 0;
            }
            $reasons = $lphr['spam'].','.$lphr['abuse'].','.$lphr['inappropriate'].','.$lphr['other'];
            $fields->reason = array($lphr['reason'], 'radio', $reasons, 'spam,abuse,inappropriate,other');
            $fields->comment = array($lphr['comments'], 'textarea', 'text');
            $fields->id = array('hidden', 'input', 'hidden', $do["id"]);
            $fields->msid = array('hidden', 'input', 'hidden', $do["xtid"]);
        }
    } else if ($do["type"] == "grouptakeaction") {
        $cm = db('Grupo', 's', 'complaints', 'id', $do["no"]);
        if (count($cm) != 0) {
            $cu = gr_group('user', $cm[0]['gid'], $uid);
            if (!$cu[0] || $cu['role'] == 3 || $cm[0]['msid'] == 0 && !gr_role('access', 'groups', '7')) {
                exit;
            }
            $fields->name = array($lphr['full_name'], 'input', 'disabled', '"'.gr_profile('get', $cm[0]['uid'], 'name').'"');
            if ($cm[0]['msid'] == 0) {
                $fields->type = array($lphr['category'], 'input', 'disabled', $lphr['group']);
            } else {
                $fields->type = array($lphr['category'], 'input', 'disabled', $lphr['message']);
            }
            $fields->reason = array($lphr['reason'], 'input', 'disabled', '"'.$lphr[$cm[0]['type']].'"');
            $tms = new DateTime($cm[0]['tms']);
            $tmz = new DateTimeZone(gr_profile('get', $uid, 'tmz'));
            $tms->setTimezone($tmz);
            $tmst = strtotime($tms->format('Y-m-d H:i:s'));
            if ($GLOBALS["default"]['time_format'] == 24) {
                $fields->tms = array($lphr['timestamp'], 'input', 'disabled', '"'.$tms->format('d-M-y H:i').'"');
            } else {
                $fields->tms = array($lphr['timestamp'], 'input', 'disabled', '"'.$tms->format('d-M-y h:i A').'"');
            }
            $fields->comment = array($lphr['comments'], 'span', 'text', $cm[0]['comment']);
            if ($cu['role'] == 2 || $cu['role'] == 1 || gr_role('access', 'groups', '7')) {
                $fields->status = array('Status', 'select', '0', '-----', '2', $lphr['action_taken'], '3', $lphr['rejected'], '1', $lphr['under_investigation']);
            }
            $fields->id = array('hidden', 'input', 'hidden', $do["no"]);
        }
    } else if ($do["type"] == "createrole") {
        if (!gr_role('access', 'roles', '1')) {
            exit;
        }
        $fields->name = array($lphr['role_name'], 'input', 'text');
        $fields->img = array($lphr['icon'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->autodel = array($lphr['autodelusrs'], 'input', 'text', "Off");
        $fields->autounjoin = array($lphr['autounjoin'], 'input', 'text', "Off");
        $rl[1] = $lphr['create'].','.$lphr['edit'].','.$lphr['delete'].','.$lphr['join'];
        $rl[1] = $rl[1].','.$lphr['invite'].','.$lphr['adduser_noinvite'].','.$lphr['view_visible'].','.$lphr['view_hidden'].','.$lphr['export_chat'].','.$lphr['view_likes'].','.$lphr['like_msgs'].','.$lphr['admin_controls'];
        $fields->group = array($lphr['group'], 'checkbox', $rl[1], '1,2,3,4,5,12,6,11,8,9,10,7');

        $rl[2] = $lphr['upload'].','.$lphr['download'].','.$lphr['delete'];
        $rl[2] = $rl[2].','.$lphr['attach'].','.$lphr['view'];
        $fields->files = array($lphr['files'], 'checkbox', $rl[2], '1,2,3,4,5');

        $rl[9] = $lphr['sendtxtmsgs'].','.$lphr['sendaudiomsgs'].','.$lphr['sendgifs'].','.$lphr['createqrcode'];
        $rl[9] = $rl[9].','.$lphr['previewmsgs'].','.$lphr['sharescreenshot'].','.$lphr['sharelinks'];
        $rl[9] = $rl[9].','.$lphr['whoistyping'].','.$lphr['emailnotifications'];
        $fields->features = array($lphr['features'], 'checkbox', $rl[9], '1,2,3,4,5,6,7,8,9');

        $rl[3] = $lphr['create'].','.$lphr['edit'].','.$lphr['delete'].','.$lphr['view'];
        $rl[3] = $rl[3].','.$lphr['deactivate_account'];
        $rl[3] = $rl[3].','.$lphr['online'].','.$lphr['login_as_user'].','.$lphr['ban_user'];
        $fields->users = array($lphr['users'], 'checkbox', $rl[3], '1,2,3,4,7,5,6,8');

        $rl[4] = $lphr['create'].','.$lphr['edit'].','.$lphr['delete'].','.$lphr['view'];
        $fields->languages = array($lphr['languages'], 'checkbox', $rl[4], '1,2,3,4');

        $rl[5] = $lphr['settings'].','.$lphr['appearance'];
        $rl[5] = $rl[5].','.$lphr['banip'].','.$lphr['filterwords'];
        $rl[5] = $rl[5].','.$lphr['header_footer'];
        $fields->sys = array($lphr['system_variables'], 'checkbox', $rl[5], '1,2,3,4,5');

        $rl[6] = $lphr['create'].','.$lphr['edit'].','.$lphr['view'];
        $fields->roles = array($lphr['roles'], 'checkbox', $rl[6], '1,2,3');

        $rl[7] = $lphr['create'].','.$lphr['edit'].','.$lphr['delete'].','.$lphr['view'];
        $fields->fields = array($lphr['fields'], 'checkbox', $rl[7], '1,2,3,4');

        $rl[8] = $lphr['converse'].','.$lphr['view'].','.$lphr['export_chat'];
        $fields->privatemsg = array($lphr['privatemsg'], 'checkbox', $rl[8], '1,2,3');


    } else if ($do["type"] == "editrole") {
        if (!gr_role('access', 'roles', '2')) {
            exit;
        }
        $cr = db('Grupo', 's', 'permissions', 'id', $do["no"], 'ORDER BY id DESC');
        if ($cr && count($cr) > 0) {
            $fields->name = array($lphr['role_name'], 'input', 'text', $do["name"]);
            $fields->img = array($lphr['icon'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
            $fields->rid = array('Role id', 'input', 'hidden', $do["no"]);
            $fields->autodel = array($lphr['autodelusrs'], 'input', 'text', '"'.$cr[0]['autodel'].'"');
            $fields->autounjoin = array($lphr['autounjoin'], 'input', 'text', '"'.$cr[0]['autounjoin'].'"');
            $rl[1] = $lphr['create'].','.$lphr['edit'].','.$lphr['delete'].','.$lphr['join'];
            $rl[1] = $rl[1].','.$lphr['invite'].','.$lphr['adduser_noinvite'].','.$lphr['view_visible'].','.$lphr['view_hidden'].','.$lphr['export_chat'].','.$lphr['view_likes'].','.$lphr['like_msgs'].','.$lphr['admin_controls'];
            $fields->group = array($lphr['group'], 'checkbox', $rl[1], '1,2,3,4,5,12,6,11,8,9,10,7', $cr[0]['groups']);

            $rl[2] = $lphr['upload'].','.$lphr['download'].','.$lphr['delete'];
            $rl[2] = $rl[2].','.$lphr['attach'].','.$lphr['view'];
            $fields->files = array($lphr['files'], 'checkbox', $rl[2], '1,2,3,4,5', $cr[0]['files']);

            $rl[9] = $lphr['sendtxtmsgs'].','.$lphr['sendaudiomsgs'].','.$lphr['sendgifs'].','.$lphr['createqrcode'];
            $rl[9] = $rl[9].','.$lphr['previewmsgs'].','.$lphr['sharescreenshot'].','.$lphr['sharelinks'];
            $rl[9] = $rl[9].','.$lphr['whoistyping'].','.$lphr['emailnotifications'];
            $fields->features = array($lphr['features'], 'checkbox', $rl[9], '1,2,3,4,5,6,7,8,9', $cr[0]['features']);

            $rl[3] = $lphr['create'].','.$lphr['edit'].','.$lphr['delete'].','.$lphr['view'];
            $rl[3] = $rl[3].','.$lphr['deactivate_account'];
            $rl[3] = $rl[3].','.$lphr['online'].','.$lphr['login_as_user'].','.$lphr['ban_user'];
            $fields->users = array($lphr['users'], 'checkbox', $rl[3], '1,2,3,4,7,5,6,8', $cr[0]['users']);

            $rl[4] = $lphr['create'].','.$lphr['edit'].','.$lphr['delete'].','.$lphr['view'];
            $fields->languages = array($lphr['languages'], 'checkbox', $rl[4], '1,2,3,4', $cr[0]['languages']);

            $rl[5] = $lphr['settings'].','.$lphr['appearance'];
            $rl[5] = $rl[5].','.$lphr['banip'].','.$lphr['filterwords'];
            $rl[5] = $rl[5].','.$lphr['header_footer'];
            $fields->sys = array($lphr['system_variables'], 'checkbox', $rl[5], '1,2,3,4,5', $cr[0]['sys']);

            $rl[6] = $lphr['create'].','.$lphr['edit'].','.$lphr['view'];
            $fields->roles = array($lphr['roles'], 'checkbox', $rl[6], '1,2,3', $cr[0]['roles']);

            $rl[7] = $lphr['create'].','.$lphr['edit'].','.$lphr['delete'].','.$lphr['view'];
            $fields->fields = array($lphr['fields'], 'checkbox', $rl[7], '1,2,3,4', $cr[0]['fields']);

            $rl[8] = $lphr['converse'].','.$lphr['view'].','.$lphr['export_chat'];
            $fields->privatemsg = array($lphr['privatemsg'], 'checkbox', $rl[8], '1,2,3', $cr[0]['privatemsg']);
        }

    } else if ($do["type"] == "customfielddelete") {
        if (gr_role('access', 'fields', '3')) {
            $fields->name = array($lphr['confirm_delete'], 'input', 'disabled', '"'.$lphr[$do['name']].'"');
            $fields->id = array('hidden', 'input', 'hidden', $do["no"]);
        }
    } else if ($do["type"] == "roledelete") {
        if (!gr_role('access', 'roles', '3')) {
            exit;
        }
        $fields->name = array($lphr['confirm_delete'], 'input', 'disabled', '"'.$do['name'].'"');
        $fields->id = array('hidden', 'input', 'hidden', $do["no"]);
    } else if ($do["type"] == "languagedelete") {
        if (!gr_role('access', 'languages', '3')) {
            exit;
        }
        $fields->name = array($lphr['confirm_delete'], 'input', 'disabled', '"'.$do['name'].'"');
        $fields->id = array('hidden', 'input', 'hidden', $do["no"]);
    } else if ($do["type"] == "languagehide") {
        if (!gr_role('access', 'languages', '2')) {
            exit;
        }
        $fields->name = array($lphr['confirm_hide'], 'input', 'disabled', '"'.$do['name'].'"');
        $fields->id = array('hidden', 'input', 'hidden', $do["no"]);
    } else if ($do["type"] == "languageshow") {
        if (!gr_role('access', 'languages', '2')) {
            exit;
        }
        $fields->name = array($lphr['confirm_show'], 'input', 'disabled', '"'.$do['name'].'"');
        $fields->id = array('hidden', 'input', 'hidden', $do["no"]);
    } else if ($do["type"] == "createuser") {
        if (!gr_role('access', 'users', '1')) {
            exit;
        }
        $fields->fname = array($lphr['full_name'], 'input', 'text');
        $fields->email = array($lphr['email_address'], 'input', 'text');
        $fields->name = array($lphr['username'], 'input', 'text');
        $fields->pass = array($lphr['password'], 'input', 'text', '"'.rn('7').'"');
        if (gr_role('access', 'users', '2')) {
            $role = db('Grupo', 's', 'permissions');
            $roles = array();
            foreach ($role as $r) {
                $roles[$r['id']] = $r['name'];
            }
            $fields->role = array($lphr['role'], 'select', $roles);
        }
        $fields->sent = array($lphr['mail_login_info'], 'select', '0', '-----', '1', $lphr['yes'], '0', $lphr['no']);

    } else if ($do["type"] == "profileact") {
        if (gr_role('access', 'users', '3')) {
            $optz['delete'] = $lphr['delete'];
        }
        if (gr_role('access', 'users', '8')) {
            $optz['ban'] = $lphr['ban'];
        }
        if (gr_role('access', 'sys', '3')) {
            $optz['banip'] = $lphr['banip'];
            $optz['unbanip'] = $lphr['unbanip'];
        }
        $fields->opted = array($lphr['select_option'], 'select', $optz);
        $fields->id = array('hidden', 'input', 'hidden', '"'.$do["id"].'"');

    } else if ($do["type"] == "editlanguage") {
        if (!gr_role('access', 'languages', '2')) {
            exit;
        }
        $r = db('Grupo', 's', 'phrases', 'type,id', 'lang', $do['no']);
        if (isset($r[0])) {
            $fields->name = array($lphr['language'], 'input', 'text', '"'.$r[0]['short'].'"');
            $fields->img = array($lphr['icon'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
            $fields->defaultlng = array($lphr['set_default_language'], 'select', '0', '-----', '1', $lphr['yes'], '0', $lphr['no']);
            $lalign['ltr'] = $lphr['ltr'];
            $lalign['rtl'] = $lphr['rtl'];
            $fields->direction = array($lphr['txt_direction'], 'select', $lalign, $r[0]['full']);
            $fields->id = array('hidden', 'input', 'hidden', '"'.$do["no"].'"');
            $ph = db('Grupo', 's', 'phrases', 'type,lid', 'phrase', $do['no']);
            foreach ($ph as $p) {
                $key = 'z'.$p['id'];
                if ($p['short'] == 'terms') {
                    $fields->$key = array(ucwords($p['short']), 'textarea', 'text', $p['full']);
                } else {
                    $fields->$key = array(ucwords($p['short']), 'input', 'text', '"'.$p['full'].'"');
                }
            }
        }

    } else if ($do["type"] == "editavatar") {
        $fields->cavatar = array($lphr['custom_avatar'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $avatars = array();
        $directory = cnf()['gem'].'/ore/grupo/avatars';
        $images = glob($directory . "/*.png");

        foreach ($images as $image) {
            $key = basename($image);
            $avatars[$key] = '"'.$image.'"';
        }
        $fields->avatar = array($lphr['choose_avatar'], 'imglist', $avatars);

    } else if ($do["type"] == "editcustomfield") {
        if (gr_role('access', 'fields', '2')) {
            $cr = db('Grupo', 's', 'profiles', 'type,id', 'field', $do["no"]);
            if ($cr && count($cr) > 0) {
                $fields->name = array($lphr['fieldname'], 'input', 'text', '"'.$lphr[$cr['0']['name']].'"');
                $req['1'] = $lphr['yes'];
                $req['0'] = $lphr['no'];
                $fields->required = array($lphr['requiredfield'], 'select', $req, $cr['0']['req']);
                $fls['shorttext'] = $lphr['shorttext'];
                $fls['longtext'] = $lphr['longtext'];
                $fls['datefield'] = $lphr['datefield'];
                $fls['numfield'] = $lphr['numfield'];
                $fls['dropdownfield'] = $lphr['dropdownfield'];
                $fields->ftype = array($lphr['fieldtype'], 'select:shwopts:shw=opts mtch=dropdownfield', $fls, $cr['0']['cat']);

                if ($cr['0']['cat'] == 'dropdownfield') {
                    $fields->options = array($lphr['fieldoptions'], 'textarea:hidopts opts shw:', 'text', $cr['0']['v1'], '"'.$lphr['separate_commas'].'"');
                } else {
                    $fields->options = array($lphr['fieldoptions'], 'textarea:hidopts opts:', 'text', '', '"'.$lphr['separate_commas'].'"');
                }
                $fields->id = array('hidden', 'input', 'hidden', $do["no"]);
            }
        }
    } else if ($do["type"] == "editgroup") {
        $role = gr_group('user', $do["id"], $uid)['role'];
        $adm = 0;
        if ($role == 2 || $role == 1) {
            $adm = 1;
        }
        if (gr_role('access', 'groups', '2') && $adm == 1 || gr_role('access', 'groups', '7')) {
            $cr = db('Grupo', 's', 'options', 'type,id', 'group', $do["id"]);
            if ($cr && count($cr) > 0) {
                $fields->name = array($lphr['group_name'], 'input', 'text', '"'.$cr['0']['v1'].'"');
                $grouplink = url().'act/viewgroup/'.$do['id'].'/';
                $fields->grouplink = array($lphr['group_link'], 'input:selectinp:', 'text', '"'.$grouplink.'"');
                $embedlink = '<iframe width=411 height=650 src='.$grouplink.' frameborder=0 allowfullscreen></iframe>';
                $fields->groupembed = array($lphr['embed_code'], 'input:selectinp:', 'text', '"'.vc($embedlink).'"');
                $fields->password = array($lphr['password'], 'input', 'text');
                $fields->img = array($lphr['icon'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
                $fields->visibility = array($lphr['visibility'], 'select', '0', '-----', '0', $lphr['visible'], '1', $lphr['hidden']);
                $postpr[0] = $lphr['group_members'];
                $postpr['adminonly'] = $lphr['admins_moderators'];
                $fields->sendperm = array($lphr['send_messages'], 'select', $postpr, $cr['0']['v5']);
                $fields->id = array('hidden', 'input', 'hidden', $cr['0']['id']);
                if (!empty($cr['0']['v2'])) {
                    $fields->delpass = array($lphr['remove_password'], 'select', '0', '-----', '1', $lphr['yes'], '0', $lphr['no']);
                }
            }
        }
    } else if ($do["type"] == "groupjoin") {
        if (!gr_role('access', 'groups', '4') && !gr_role('access', 'groups', '7')) {
            exit;
        }
        $cr = db('Grupo', 's', 'options', 'type,id', 'group', $do["id"]);
        if ($cr && count($cr) > 0) {
            $cu = gr_group('user', $do["id"], $uid)[0];
            if (!$cu) {
                $fields->name = array($lphr['confirm_join'], 'input', 'disabled', '"'.$cr['0']['v1'].'"');
                $inv = db('Grupo', 's,count(*)', 'alerts', 'type,uid,v1', 'invitation', $uid, $do["id"])[0][0];
                if (!empty($cr['0']['v2']) && !gr_role('access', 'groups', '7') && $inv == 0) {
                    $fields->password = array($lphr['password'], 'input', 'text');
                }
                $fields->id = array('hidden', 'input', 'hidden', $cr['0']['id']);
            } else {
                pr(0);
            }
        }

    } else if ($do["type"] == "groupleave") {
        $cr = gr_group('valid', $do["id"]);
        if ($cr[0]) {
            $cu = gr_group('user', $do["id"], $uid)[0];
            if ($cu) {
                $fields->name = array($lphr['confirm_leave'], 'input', 'disabled', '"'.$cr['name'].'"');
                $fields->id = array('hidden', 'input', 'hidden', '"'.$do["id"].'"');
            }
        }

    } else if ($do["type"] == "groupmention") {
        $gr = db('Grupo', 's', 'alerts', 'id,uid', $do["id"], $uid);
        if (isset($gr[0])) {
            $gr = $gr[0];
            if ($gr['type'] == 'mentioned' || $gr['type'] == 'replied' || $gr['type'] == 'liked') {
                $cu = gr_group('user', $gr['v1'], $uid)[0];
                if ($cu) {
                    $cr = gr_group('valid', $gr['v1']);
                    $fields->group = array($lphr['group_name'], 'input', 'disabled', '"'.$cr['name'].'"');
                    $fields->user = array($lphr['full_name'], 'input', 'disabled', '"'.gr_profile('get', $gr['v3'], 'name').'"');
                    $msg = db('Grupo', 's', 'msgs', 'id', $gr['v2'])[0];
                    $fields->msg = array($lphr['message'], 'textarea', 'disabled', $msg['msg']);
                    $fields->id = array('hidden', 'input', 'hidden', '"'.$gr['v1'].'"');
                }
            }
        }
    } else if ($do["type"] == "grouprole") {
        $role = gr_group('user', $do["id"], $uid)['role'];
        if (!gr_role('access', 'groups', '7') && $role != 2) {
            exit;
        }
        $cr = gr_group('valid', $do["id"]);
        if ($cr[0]) {
            $fields->group = array($lphr['group_name'], 'input', 'disabled', '"'.$cr['name'].'"');
            $fields->pname = array($lphr['full_name'], 'input', 'disabled', '"'.$do["pname"].'"');
            $fields->usid = array('hidden', 'input', 'hidden', '"'.$do["usr"].'"');
            $fields->id = array('hidden', 'input', 'hidden', '"'.$do["id"].'"');
            $fields->role = array($lphr['role'], 'select', '0', '-----', '2', $lphr['admin'], '1', $lphr['moderator'], '0', $lphr['member']);
            $fields->remuser = array($lphr['remove_user'], 'select', '0', '-----', 'yes', $lphr['yes'], 'no', $lphr['no']);

        }

    } else if ($do["type"] == "filesdelete") {
        if (!gr_role('access', 'files', '3')) {
            exit;
        }
        $fields->name = array($lphr['confirm_delete'], 'input', 'disabled', '"'.explode('-gr-', $do["id"], 2)[1].'"');
        $fields->id = array('hidden', 'input', 'hidden', '"'.$do["id"].'"');

    } else if ($do["type"] == "groupexport") {
        if (gr_role('access', 'groups', '8') || gr_role('access', 'groups', '7') || gr_role('access', 'privatemsg', '3')) {
            $cr = gr_group('valid', $do["id"], $do["ldt"]);
            if ($cr[0]) {
                $cu = gr_group('user', $do["id"], $uid, $do["ldt"])[0];
                if ($cu) {
                    $fields->name = array($lphr['confirm_export'], 'input', 'disabled', '"'.$cr['name'].'"');
                    $fields->id = array('hidden', 'input', 'hidden', '"'.$do["id"].'"');
                    $fields->ldt = array('hidden', 'input', 'hidden', '"'.$do["ldt"].'"');
                }
            }
        }
    } else if ($do["type"] == "groupdelete") {
        $role = gr_group('user', $do["id"], $uid)['role'];
        if (gr_role('access', 'groups', '3') && $role == 2 || gr_role('access', 'groups', '7')) {
            $cr = gr_group('valid', $do["id"]);
            if ($cr[0]) {
                $fields->name = array($lphr['confirm_delete'], 'input', 'disabled', '"'.$cr['name'].'"');
                $fields->id = array('hidden', 'input', 'hidden', $do["id"]);
            }
        }

    } else if ($do["type"] == "groupinvite") {
        if (gr_role('access', 'groups', '5') || gr_role('access', 'groups', '7')) {
            $cr = gr_group('valid', $do["id"]);
            $role = gr_group('user', $do["id"], $uid)['role'];
            if ($cr[0]) {
                if (gr_role('access', 'groups', '7') || empty($cr['pass']) && $cr['visible'] != 'secret' || $role == 1 || $role == 2) {
                    $invitelink = url().'act/join/'.$do['id'].'/'.$cr['access'].'/';
                    $fields->invitelink = array($lphr['invite_link'], 'input:selectinp:', 'text', '"'.$invitelink.'"');
                    $fields->users = array($lphr['email_username'], 'input:inviter:', 'text', '', '"'.$lphr['separate_commas'].'"');
                    $fields->id = array('hidden', 'input', 'hidden', $do["id"]);
                }
            }
        }

    } else if ($do["type"] == "profileblock") {
        $vusr = db('Grupo', 's,count(*)', 'users', 'id', $do["id"])[0][0];
        if ($vusr > 0) {
            if (gr_profile('blocked', $do["id"])) {
                $fields->name = array($lphr['confirm_unblock'], 'input', 'disabled', '"'.gr_profile('get', $do["id"], 'name').'"');
            } else {
                $fields->name = array($lphr['confirm_block'], 'input', 'disabled', '"'.gr_profile('get', $do["id"], 'name').'"');
            }
            $fields->id = array('hidden', 'input', 'hidden', $do["id"]);
        }

    } else if ($do["type"] == "editprofile") {
        if (isset($do['no']) && gr_role('access', 'users', '2')) {
            $uid = $do['no'];
            if (isset($do['xtid']) && !empty($do['xtid'])) {
                $uid = $do['xtid'];
            }
        }
        $usr = usr('Grupo', 'select', $uid);
        $prf = db('Grupo', 's', 'options', 'type,v1,v3', 'profile', 'name', $uid);
        $fields->name = array($lphr['full_name'], 'input', 'text', '"'.$prf[0]['v2'].'"');
        $fields->user = array($lphr['username'], 'input', 'text', '"'.$usr['name'].'"');
        $fields->email = array($lphr['email_address'], 'input', 'text', '"'.$usr['email'].'"');
        $fields->password = array($lphr['password'], 'input', 'password');
        $ncolor = $prf[0]['v5'];
        if (empty($ncolor)) {
            $ncolor = gr_usrcolor();
        }
        $fields->ncolor = array($lphr['name_color'], 'input', 'colorpick', $ncolor);
        if (isset($do['no']) && gr_role('access', 'users', '2')) {
            $role = db('Grupo', 's', 'permissions');
            $roles = array();
            foreach ($role as $r) {
                $roles[$r['id']] = $r['name'];
            }
            $fields->role = array($lphr['role'], 'select', $roles, $usr['role']);
        }
        $fields->tmz = array($lphr['timezone'], 'tmz', gr_tmz(), gr_profile('get', $uid, 'tmz', 1));
        $alerts = array();
        $alrt = glob('gem/ore/grupo/alerts/*');
        foreach ($alrt as $al) {
            $alerts[$al] = ucwords(basename($al, '.mp3'));
        }
        $fields->alert = array($lphr['notification_tone'], 'select:alertonez audselect:', $alerts, gr_profile('get', $uid, 'alert'));
        $fields->cbg = array($lphr['custom_bg'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->cpic = array($lphr['cover_pic'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->id = array('hidden', 'input', 'hidden', '"'.$uid.'"');
        $lists = db('Grupo', 's', 'profiles', 'type', 'field');
        foreach ($lists as $f) {
            $sel = null;
            $pf = $f['name'];
            $vpf = null;
            $ct = db('Grupo', 's', 'profiles', 'type,name,uid', 'profile', $f['id'], $uid);
            if (count($ct) > 0) {
                $vpf = html_entity_decode($ct[0]['v1']);
            }
            if ($vpf == null) {
                $vpf = '';
            }
            if (!empty($f['req'])) {
                $lphr[$pf] = $lphr[$pf].' *';
            }
            if ($f['cat'] == 'shorttext') {
                $fields-> $pf = array($lphr[$pf], 'input', 'text', '"'.$vpf.'"');
            } else if ($f['cat'] == 'longtext') {
                $fields-> $pf = array($lphr[$pf], 'textarea', 'text', $vpf);
            } else if ($f['cat'] == 'datefield') {
                $fields-> $pf = array($lphr[$pf], 'input', 'date', '"'.$vpf.'"');
            } else if ($f['cat'] == 'numfield') {
                $fields-> $pf = array($lphr[$pf], 'input', 'number', '"'.$vpf.'"');
            } else if ($f['cat'] == 'dropdownfield') {
                $selt = explode(",", $f['v1']);
                foreach ($selt as $sl) {
                    $sel[$sl] = $sl;
                }
                $fields-> $pf = array($lphr[$pf], 'select', $sel, $vpf);
            }
        }
        if (!isset($do['side'])) {
            $do['side'] = 'left';
        }
        if (gr_role('access', 'users', '7')) {
            $fields->delacc = array($lphr['deactivate_account'], 'select', '0', '-----', 'yes', $lphr['yes'], 'no', $lphr['no']);
        }
        $fields->aside = array('hidden', 'input', 'hidden', '"'.$do['side'].'"');
    } else if ($do["type"] == "systemhf") {
        if (gr_role('access', 'sys', '5')) {
            $header = vc(file_get_contents('gem/ore/grupo/cache/headers.cch'));
            $footer = vc(file_get_contents('gem/ore/grupo/cache/footers.cch'));
            $fields->headers = array($lphr['header'], 'textarea', 'text', $header);
            $fields->footers = array($lphr['footer'], 'textarea', 'text', $footer);
        }
    } else if ($do["type"] == "systembanip") {
        if (gr_role('access', 'sys', '3')) {
            $blist = db('Grupo', 's', 'defaults', 'type', 'blacklist')[0]['v2'];
            $fields->blist = array($lphr['blacklist'], 'textarea', 'text', $blist);
        }
    } else if ($do["type"] == "systemfilterwords") {
        if (!gr_role('access', 'sys', '4')) {
            exit;
        } $blist = db('Grupo', 's', 'defaults', 'type', 'filterwords')[0]['v2'];
        $fields->blist = array($lphr['filterwords'], 'textarea', 'text', $blist);

    } else if ($do["type"] == "systemeasycustomizer") {
        if (gr_role('access', 'sys', '2')) {
            $fields->startcolor = array($lphr['startcolor'], 'input', 'colorpick', '#E91E63');
            $fields->endcolor = array($lphr['endcolor'], 'input', 'colorpick', '#9C27B0');
        }
    } else if ($do["type"] == "systemappearance") {
        if (gr_role('access', 'sys', '2')) {
            $css = db('Grupo', 's', 'customize', 'device,name<>', 'all', 'custom_css');
            $mobcss = db('Grupo', 's', 'customize', 'device,name<>', 'mobile', 'custom_css');
            $box = $GLOBALS["default"]['boxed'];
            $cus = db('Grupo', 's', 'customize', 'name', 'custom_css')[0]['element'];
            if (empty($cus)) {
                $cus = "";
            }
            $fields->boxed = array('Boxed Layout', 'select', $box, $lphr[$box], 'enable', $lphr['enable'], 'disable', $lphr['disable']);
            $fnt = array();
            $fnt = glob('riches/fonts/*', GLOB_ONLYDIR);
            foreach ($fnt as $al) {
                $al = basename($al);
                if ($al != "grupo") {
                    $fnts[$al] = ucwords($al);
                }
            }
            $fields->defont = array($lphr['default_font'], 'select', $fnts, $GLOBALS["default"]['default_font']);
            $fields->customcss = array('Custom CSS', 'textarea', '', $cus);
            $algn['left'] = $lphr['left'];
            $algn['right'] = $lphr['right'];
            $fields->sentalign = array($lphr['sent_msg_align'], 'select', $algn, $GLOBALS["default"]['sent_msg_align']);
            $fields->recievedalign = array($lphr['received_msg_align'], 'select', $algn, $GLOBALS["default"]['received_msg_align']);
            foreach ($css as $c) {
                $key = 'css'.$c['id'];
                $c['name'] = ucwords(str_replace('_', ' ', $c['name']));
                if ($c['type'] == 'background') {
                    $a = $key.'a';
                    $b = $key.'b';
                    $fields->$a = array($c['name'].' - Start Color', 'input', 'colorpick', '"'.$c['v1'].'"');
                    $fields->$b = array($c['name'].' - End Color', 'input', 'colorpick', '"'.$c['v2'].'"');
                } else if ($c['type'] == 'color' || $c['type'] == 'border-color') {
                    $fields->$key = array($c['name'], 'input', 'colorpick', '"'.$c['v1'].'"');
                } else if ($c['type'] == 'font-size') {
                    $c['name'] = $c['name'].' (px)';
                    $c['v1'] = vc($c['v1'], 'num', 1);
                    $fields->$key = array($c['name'], 'input', 'number', '"'.$c['v1'].'"');
                }
            }
            foreach ($mobcss as $c) {
                $key = 'css'.$c['id'];
                $c['name'] = ucwords(str_replace('_', ' ', $c['name']));
                if ($c['type'] == 'background') {
                    $a = $key.'a';
                    $b = $key.'b';
                    $fields->$a = array($c['name'].' - Start Color', 'input', 'colorpick', '"'.$c['v1'].'"');
                    $fields->$b = array($c['name'].' - End Color', 'input', 'colorpick', '"'.$c['v2'].'"');
                } else if ($c['type'] == 'color' || $c['type'] == 'border-color') {
                    $fields->$key = array($c['name'], 'input', 'colorpick', '"'.$c['v1'].'"');
                } else if ($c['type'] == 'font-size') {
                    $c['name'] = $c['name'].' (px)';
                    $c['v1'] = vc($c['v1'], 'num', 1);
                    $fields->$key = array($c['name'], 'input', 'number', '"'.$c['v1'].'"');
                }
            }
        }
    } else if ($do["type"] == "systemsettings") {
        if (!gr_role('access', 'sys', '1')) {
            exit;
        }
        $sys = db('Grupo', 's', 'defaults', 'type,v1<>,v1<>', 'default', 'sent_msg_align', 'received_msg_align');
        foreach ($sys as $s) {
            if ($s['v1'] != 'alert' && $s['v1'] != 'default_font') {
                $key = $s['id'];
                $inp = 'input';
                $type = 'text';
                $val = '"'.$s['v2'].'"';
                if ($s['v1'] === 'timezone') {
                    $inp = 'tmz';
                    $type = gr_tmz();
                    $val = $s['v2'];
                }
                if ($s['v1'] === 'userreg' || $s['v1'] === 'recaptcha' || $s['v1'] === 'unsplash_enable' || $s['v1'] === 'tenor_enable' || $s['v1'] === 'boxed' || $s['v1'] === 'smtp_authentication' || $s['v1'] === 'guest_login' || $s['v1'] === 'email_verification') {
                    $fields->$key = array($lphr[$s['v1']], 'select', $s['v2'], $lphr[$s['v2']], 'enable', $lphr['enable'], 'disable', $lphr['disable']);
                } else if ($s['v1'] === 'time_format') {
                    $fields->$key = array($lphr[$s['v1']], 'select', $s['v2'], $s['v2'], '12', 12, '24', 24);
                } else if ($s['v1'] === 'autogroupjoin') {
                    $group = db('Grupo', 's', 'options', 'type', 'group');
                    $groups = array();
                    foreach ($group as $r) {
                        $groups[$r['id']] = $r['v1'];
                    }
                    $fields->$key = array($lphr[$s['v1']], 'select', $groups, $s['v2']);
                } else if ($s['v1'] === 'language') {
                    $lang = db('Grupo', 's', 'phrases', 'type', 'lang');
                    $langs = array();
                    foreach ($lang as $r) {
                        $langs[$r['id']] = $r['short'];
                    }
                    $fields->$key = array($lphr[$s['v1']], 'select', $langs, $s['v2']);
                } else {
                    $fields->$key = array($lphr[$s['v1']], $inp, $type, $val);
                }
            } else if ($s['v1'] == 'alert') {
                $alid = $s['id'];
            } else if ($s['v1'] == 'default_font') {
                $fntid = $s['id'];
            }
        }
        $alerts = array();
        $alrt = glob('gem/ore/grupo/alerts/*');
        foreach ($alrt as $al) {
            $alerts[$al] = ucwords(basename($al, '.mp3'));
        }
        $fields->$alid = array($lphr['default_notification_tone'], 'select:audselect:', $alerts, $GLOBALS["default"]['alert']);
        $fnt = array();
        $fnt = glob('riches/fonts/*', GLOB_ONLYDIR);
        foreach ($fnt as $al) {
            $al = basename($al);
            if ($al != "grupo") {
                $fnts[$al] = ucwords($al);
            }
        }

        $cronjob = 'wget -q -O - '.url().'act/cronjob/';
        $fields->cronjob = array($lphr['cronjob'], 'input:selectinp:', 'text', '"'.$cronjob.'"');
        $fields->$fntid = array($lphr['default_font'], 'select', $fnts, $GLOBALS["default"]['default_font']);
        $fields->sitelogo = array($lphr['logo'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->mobilelogo = array($lphr['mobile_logo'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->logo = array($lphr['signin_logo'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->favicon = array($lphr['favicon'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->emaillogo = array($lphr['emaillogo'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->welcome = array($lphr['welcomeimg'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->defaultbg = array($lphr['defaultbg'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');
        $fields->loginbg = array($lphr['loginbg'], 'input', 'file', 'accept="image/x-png,image/gif,image/jpeg"');

    }
    $fields->choosefiletxt = array($lphr['choosefiletxt']);
    $r = json_encode($fields);
    gr_prnt($r);
}
?>