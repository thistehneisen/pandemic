<?php if(!defined('s7V9pz')) {die();}?><?php
fn('db');
$bw = db('Grupo', 's', 'options', 'type', 'filterwords')[0]['v2'];
$bw = preg_split('/\r\n+/', $bw);
?>
function noswear(txt) {
    var filter = <?php echo json_encode($bw)?>;
    filter.sort(function(a, b) {
        return b.length - a.length;
    });
    $.each(filter, function(key, value) {
        value = value.replace('(', '/[(]/g');
        value = value.replace('*', '/[*]/g');
        var rw = '*'.repeat(value.length);
        txt = txt.replace(new RegExp("\\b"+value+"\\b"), rw);
    });
    return txt;
}