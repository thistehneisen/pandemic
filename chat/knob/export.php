<?php if(!defined('s7V9pz')) {die();}?><?php
fc('grupo');
$exp = pg('export');
$exp = explode('/', $exp);
$gid = $tusid = $exp[0];
$ldt = $exp[1];
$uid = usr('Grupo')['id'];
$cu = gr_group('user', $gid, $uid, $ldt);
if (!$cu[0] || $cu['role'] == '3') {
    rt('404');
}
if ($ldt == 'user') {
    if (!gr_role('access', 'privatemsg', '3', $uid)) {
        rt('404');
        exit;
    }
    $tmpido = $gid.'-'.$uid;
    if ($gid > $uid) {
        $tmpido = $uid.'-'.$gid;
    }
    $gid = $tmpido;
} else {
    if (!gr_role('access', 'groups', '8', $uid) & !gr_role('access', 'groups', '7', $uid)) {
        rt('404');
        exit;
    }
}
$r = db('Grupo', 's', 'msgs', 'gid', $gid);
if ($ldt == 'user') {
    $n = $GLOBALS["lang"]['conversation_with'].' '.gr_profile('get', $tusid, 'name');
} else {
    $n = db('Grupo', 's', 'options', 'type,id', 'group', $gid)[0]['v1'];
}
?>
<?php
$cont = '';
$cont .= '<html lang="en">';
$cont .= '<head>';
$cont .= '<meta charset="utf-8">';
$cont .= '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
$cont .= '<meta name="description" content="'.$GLOBALS["default"]['sitedesc'].'">';
$cont .= '<meta name="author" content="Silwr">';
$cont .= '<meta name="generator" content="Grupo">';
$cont .= '<title>'.$GLOBALS["default"]['sitename'].'</title>';
$cont .= '<link href="https://fonts.googleapis.com/css?family=Montserrat:500,600,700,700i,800" rel="stylesheet">';
$cont .= '<link href="'.url().'gr-backup.css" rel="stylesheet">';
$cont .= '<link href="'.url().'customcss.css" rel="stylesheet">';
$cont .= '</head>';
$cont .= '<body>';
$cont .= '<div class="limiter">';
$cont .= '<div class="container-table100">';
$cont .= '<div class="wrap-table100">';
$cont .= '<div class="table100">';
$cont .= '<table>';
$cont .= '<thead>';
$cont .= '<tr class="table100-head">';
$cont .= '<th class="column1">'.$GLOBALS["lang"]['date-time'];
$cont .= '</th>';
$cont .= '<th class="column2">'.$GLOBALS["lang"]['sender'];
$cont .= '</th>';
$cont .= '<th class="column3">'.$GLOBALS["lang"]['message'];
$cont .= '</th>';
$cont .= '</tr>';
$cont .= '</thead>';
$cont .= '<tbody>';
foreach ($r as $v) {
    if ($v['type'] === 'system') {
        $v['msg'] = $GLOBALS["lang"][$v['msg']];
    } else if ($v['type'] === 'file') {
        $v['msg'] = $GLOBALS["lang"]['shared_file'];
    }
    if ($v['uid'] == $uid) {
        $name = $GLOBALS["lang"]['you'];
    } else {

        $name = gr_profile('get', $v['uid'], 'name');
    }
    $tms = new DateTime($v['tms']);
    $tmz = new DateTimeZone(gr_profile('get', $uid, 'tmz'));
    $tms->setTimezone($tmz);
    $tmst = strtotime($tms->format('Y-m-d H:i:s'));
    $cont .= '<tr><td class="column1" data-title="'.$GLOBALS["lang"]['date-time'].'">';
    $cont .= $tms->format('d-M-y').' '.$tms->format('h:i A').'</td>';
    $cont .= '<td class="column2" data-title="'.$GLOBALS["lang"]['sender'].'">'.$name.'</td>';
    $cont .= '<td class="column3" data-title='.$GLOBALS["lang"]['message'].'">'.htmlspecialchars_decode(gr_noswear($v['msg']));
    $cont .= '</td></tr>';
}
$cont .= '</tbody></table></div></div></div></div></body></html>';
$fname = 'grupo/files/dumb/backup-'.$gid.'.html';
file_put_contents('gem/ore/'.$fname, $cont);
flr('download', $fname);
?>