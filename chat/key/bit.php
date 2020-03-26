<?php if(!defined('s7V9pz')) {die();}?>
<?php
function cnf($v = "cnf") {
    $cnf["cnf"] = array(
        "mode" => 1,
        "name" => "Pandemic Chat",
        "tag" => "Chat",
        "poet" => "Pandemic",
        "url" => "https://pandemic.lv/chat/",
        "region" => "Europe/Riga",
        "knob" => "knob",
        "door" => "door",
        "gem" => "gem",
        "bit" => "s7V9pz",
        "chief" => "admin",
        "codeword" => "P@ND3M11C1337$$",
        "ext" => "css,js,xml",
        "global" => "1",
        "appversion" => 1,
    );
$cnf["Grupo"] = array(
                'host' => 'localhost',
                'db' => 'pandemic_chat',
                'user' => 'pandemic_chat',
                'pass' => '1pSsq8_7$1pSsq8_7',
                'prefix' => 'gr_'
                );
if ($v == "all") {
        return $cnf;
    } else if (isset($cnf[$v])) {
        return $cnf[$v];
    }
}
?>

