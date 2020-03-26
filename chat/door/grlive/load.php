<?php if(!defined('s7V9pz')) {die();}?><?php
function gr_live() {
    $uid = $GLOBALS["user"]['id'];
    $arg = vc(func_get_args());
    $out = array();
    $list = 0;
    $lastseen = 0;
    if (isset($arg[0]['gid']) && !empty($arg[0]['gid']) && isset($arg[0]['lastid']) && $arg[0]['chat'] == 'on') {
        $gid = $arg[0]['gid'];
        if ($arg[0]['ldt'] == 'user') {
            $tmpido = $arg[0]['gid'].'-'.$uid;
            if ($arg[0]['gid'] > $uid) {
                $tmpido = $uid.'-'.$arg[0]['gid'];
            }
            $gid = $tmpido;
        }
        $cnt = db('Grupo', 's,count(id)', 'msgs', 'cat,gid,id>', $arg[0]["ldt"], $gid, $arg[0]["lastid"])[0][0];
        if ($cnt > 0) {
            $gr = array();
            $gr['id'] = $arg[0]['gid'];
            $gr['from'] = $arg[0]['lastid'];
            $gr['ldt'] = $arg[0]['ldt'];
            $data = gr_group('msgs', $gr, 'array');
            if (!empty($data)) {
                if (isset($data[0]->nomem) && $data[0]->nomem == 1) {
                    $list = 1;
                    $data[0]->liveup = 'refresh';
                    $out = $data;
                } else if (count($data) > 2) {
                    $list = 1;
                    $data[0]->liveup = 'msgs';
                    $out = $data;
                }
            }
        } else {
            $lastseen = db('Grupo', 's,v3', 'options', 'type,v1', 'lview', $gid, 'ORDER BY v3 ASC LIMIT 1');
        }
    }
    if ($list == null) {
        $tms = vc($arg[0]['tms'], 'num');
        $typ = vc($arg[0]['typ'], 'num');
        $tls = vc($arg[0]['tls'], 'num');
        if (empty($tms) || empty($typ) || strtotime('now') > strtotime('+10 seconds', $typ) || strtotime('now') > strtotime('+40 seconds', $tms)) {
            if (!empty($arg[0]['gid']) && isset($arg[0]['lastid']) && $arg[0]['chat'] == 'on') {
                if (gr_role('access', 'features', '8')) {
                    if (empty($typ) || strtotime('now') > strtotime('+10 seconds', $typ)) {
                        db('Grupo', 'q', 'DELETE FROM gr_logs WHERE type = "typing" AND tms < (NOW() - INTERVAL 10 SECOND)');
                        $typz = db('Grupo', 's,v3', 'logs', 'type,v1,v2<>', 'typing', $arg[0]['gid'], $uid, 'ORDER BY id DESC LIMIT 3');
                        $list = array();
                        $list[0] = new stdClass();
                        $list[0]->liveup = 'unseen';
                        $list[0]->actunseen = $list[0]->typing = 0;
                        if (count($typz) > 0) {
                            $list[0]->typing = 1;
                            $list[0]->typers = $typz;
                        }
                        $list[0]->livetyptms = strtotime('now');
                        $out = $list;
                    }
                }
            }
        }
        if (isset($lastseen[0]) && empty($tls) || isset($lastseen[0]) && strtotime('now') > strtotime('+10 seconds', $tls)) {
            if ($list == null) {
                $list = array();
                $list[0] = new stdClass();
                $list[0]->liveup = 'unseen';
            }
            $list[0]->lastseen = $lastseen[0]['v3'];
            $list[0]->livelstms = strtotime('now');
            $out = $list;
        }
        if (empty($tms) || strtotime('now') > strtotime('+20 seconds', $tms)) {
            if (empty($list)) {
                $list = array();
                $list[0] = new stdClass();
                $list[0]->liveup = 'unseen';
            }
            $list[0]->actunseen = 1;
            $list[0]->liveuptms = strtotime('now');
            $list[0]->complaints = $list[0]->pm = 0;
            $list[0]->group = gr_group('unseen');
            $list[0]->alerts = gr_alerts('count');
            if (!empty($arg[0]['gid']) && isset($arg[0]['lastid']) && $arg[0]['chat'] == 'on' && $arg[0]['ldt'] != 'user') {
                $list[0]->complaints = gr_group('complaints', $arg[0]['gid']);
            }
            if ($arg[0]['pm'] == 'on') {
                $list[0]->pm = gr_group('unseen', 'pm');
            }
            $out = $list;
        }
    }
    gr_prnt(json_encode($out));
}
?>