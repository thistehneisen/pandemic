<?php if(!defined('s7V9pz')) {die();}?><?php
function gr_install($do) {
    if (pg() == 'install/') {
        error_reporting(0);
        ob_get_clean();
        if (!extension_loaded('fileinfo') OR !function_exists('mime_content_type')) {
            pr('Requires php fileinfo extension'); exit;
        } else if (isset($do["act"])) {
            if ($do["do"] == "install") {
                $bit = "key/bit.php";
                $do['email'] = vc($do['email'], 'email');
                $do['username'] = vc($do['username'], 'alphanum');
                $install[0] = new stdClass();
                $install[0]->install = 'invalid';
                if (!empty($do['email']) && !empty($do['encde'])) {
                    if (empty($do['site']) && empty($do['username'])) {
                        if (!empty($do['db']) && !empty($do['host']) && !empty($do['user'])) {
                            if (dbc($do, 1)) {
                                $o = file_get_contents($bit);
                                $o = preg_replace("/'host' => '([^']+(?='))'/", "'host' => '".$do['host']."'", $o);
                                $o = preg_replace("/'db' => '([^']+(?='))'/", "'db' => '".$do['db']."'", $o);
                                $o = preg_replace("/'user' => '([^']+(?='))'/", "'user' => '".$do['user']."'", $o);
                                $o = preg_replace("/'pass' => '([^']+(?='))'/", "'pass' => '".$do['pass']."'", $o);
                                file_put_contents($bit, $o);
                                $sql = file_get_contents('key/install.sql');
                                $db = new PDO("mysql:host=".$do['host']."; dbname=".$do['db'], $do['user'], $do['pass']);
                                $qr = $db->exec($sql);
                                $install[0]->install = 'next';
                            } else {
                                $install[0]->install = 'wrongcredentials';
                            }
                        }
                        gdbcnt($do);
                    } else if (!empty($do['username']) && !empty($do['password']) && !empty($do['url'])) {
                        $o = file_get_contents($bit);
                        if (substr($do['url'], -1) != '/') {
                            $do['url'] = $do['url'].'/';
                        }
                        $o = preg_replace('/"url" => "([^"]+(?="))"/', '"url" => "'.$do['url'].'"', $o);
                        file_put_contents($bit, $o);
                        $db['host'] = $do['host'];
                        $db['db'] = $do['db'];
                        $db['user'] = $do['user'];
                        $db['pass'] = $do['pass'];
                        $db['prefix'] = 'gr_';
                        db($db, 'u', 'defaults', 'v2', 'type,v1|,v1', $do['site'], 'default', 'sitename', 'sendername');
                        db($db, 'u', 'defaults', 'v2', 'type,v1', $do['email'], 'default', 'sysemail');
                        usr($db, 'alter', 'name', $do['username'], 1);
                        usr($db, 'alter', 'email', $do['email'], 1);
                        usr($db, 'alter', 'pass', $do['password'], 1);
                        gr_cache('settings');
                        rename('knob/install.php', 'knob/install'.rn(7).'.php');
                        $install[0]->install = 'completed';
                    }
                }
            }
            $r = json_encode($install);
            gr_prnt($r);
            exit;
        }
    } else {
        rt('install');
    }
}
?>