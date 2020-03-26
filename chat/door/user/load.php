<?php if(!defined('s7V9pz')) {die();}?><?php
function usr() {
    $arg = vc(func_get_args());
    $d = $arg[0];
    $t = 0;
    if (isset($arg[1])) {
        $t = $arg[1];
    }
    $r = false;
    if ($t === 'register') {
        $rl = 1;
        $r[0] = false;
        $i = strtolower(vc($arg[2], 'alphanum'));
        $e = strtolower(vc($arg[3], 'email'));
        $p = $arg[4];
        if (isset($arg[5])) {
            $rl = vc($arg[5], 'num');
        }
        if (!empty($d) && !empty($i) && !empty($e) && !empty($p)) {
            if (preg_match('/[A-Za-z]/', $i)) {
                if (!usr($d, 'exist', $i)) {
                    if (!usr($d, 'exist', $e)) {
                        $p = en($p);
                        $r[1] = db($d, 'i', 'users', 'name,email,pass,mask,depict,role,created,altered', $i, $e, $p['pass'], $p['mask'], $p['type'], $rl, dt(), dt());
                        $r[0] = true;
                    } else {
                        $r[1] = 'emailexist';
                    }
                } else {
                    $r[1] = 'usernameexist';
                }
            } else {
                $r[1] = 'usernamecondition';
            }
        } else {
            $r[1] = 'invalid';
        }
        return $r;
    } else if ($t === 'suggest') {
        $ch = $rn = null;
        if (isset($arg[3])) {
            $rn = $arg[3];
        }
        $fl = rn($rn);
        if (isset($arg[2])) {
            $ch = strtolower(vc($arg[2], 'alphanum'));
            $s = $ch.$fl;
        } else {
            $s = $fl;
        }
        if (!usr($d, 'exist', $s)) {
            return $s;
        } else {
            usr($d, 'suggest', $ch, $rn);
        }
    } else if ($t === 'logout') {
        $v = usr($d);
        if (isset($v['id'])) {
            ses($d, 'del', $v['id']);
            return true;
        }
    } else if ($t === 'devicelogout') {
        $i = vc($arg[2], 'num');
        $dev = $arg[3];
        $r = db($d, 'd', 'session', 'uid,device,try', $i, $dev, 0);
        return $r;
    } else if ($t === 'forcelogout') {
        if (isset($arg[2])) {
            $i = vc($arg[2], 'num');
            if ($i != 0) {
                $r = db($d, 'd', 'session', 'uid,try', $i, 0);
            } else {
                $r = db($d, 'd', 'session', 'try', 0);
            }
        }
        return $r;
    } else if ($t === 'delete') {
        $i = vc($arg[2], 'num');
        $r = db($d, 'd', 'users', 'id', $i);
        $r = db($d, 'd', 'session', 'uid', $i);
        return $r;
    } else if ($t === 'unblock') {
        $id = vc($arg[2], 'num');
        $dev = 'bs.'.ip().$arg[3];
        $code = vc($arg[4]);
        $r = db($d, 'd', 'session', 'uid,device,code', $id, $dev, $code);
        return $r;
    } else if ($t === 'forgot') {
        $r[0] = false;
        $usr = usr($d, 'select', $arg[2]);
        if (!empty($usr['role'])) {
            $r[1] = rn(14);
            $r[0] = db($d, 'u', 'users', 'altered,extra', 'id', dt(), $r[1], $usr['id']);
        }
        return $r;
    } else if ($t === 'reset') {
        $r[0] = false;
        $code = vc($arg[3]);
        $usr = usr($d, 'select', $arg[2]);
        if (!empty($usr['role']) && $usr['extra'] === $code) {
            $r[1] = rn(7);
            $p = en($r[1]);
            $r[0] = db($d, 'u', 'users', 'pass,mask,depict,altered,extra', 'id', $p['pass'], $p['mask'], $p['type'], dt(), 0, $usr['id']);
        }
        return $r;
    } else if ($t === 'clear') {
        if (isset($arg[2])) {
            if ($arg[2] != 0) {
                $v = vc($arg[2], 'num');
                $r = db($d, 'd', 'session', 'uid', $v);
            } else {
                $r = db($d, 'd', 'session');
            }
        }
        return $r;
    } else if ($t === 'ban') {
        $usr = usr($d, 'select', $arg[2]);
        $o = $usr['role'];
        if (!empty($o)) {
            $r = db($d, 'u', 'users', 'role,altered,extra', 'id', 0, dt(), $o, $usr['id']);
        }
        return $r;
    } else if ($t === 'unban') {
        $usr = usr($d, 'select', $arg[2]);
        $o = $usr['extra'];
        $o = vc($o, 'num');
        if (empty($o)) {
            $o = 1;
        } if (empty($ol['role'])) {
            $r = db($d, 'u', 'users', 'role,altered', 'id', $o, dt(), $usr['id']);
        }
        return $r;
    } else if ($t === 'forcelogin') {
        $usr = usr($d, 'select', $arg[2]);
        if (isset($usr['id'])) {
            $i = $usr['id'];
            if (!empty($i) && !empty($usr['role'])) {
                $r[0] = ses($d, 'add', $i);
                $r['uid'] = $i;
                $r['code'] = $_SESSION[$d.'usrcode'];
                $r['dev'] = $_SESSION[$d.'usrdev'];
                $r['ses'] = $_SESSION[$d.'usrses'];
            }
        }
        return $r;
    } else if ($t === 'login') {
        $p = $arg[3];
        $u = strtolower(vc($arg[2], 'email'));
        $f = 'email';
        $r[0] = false;
        $r[1] = 'invalid';
        if (empty($u)) {
            $f = 'name';
            $u = strtolower(vc($arg[2], 'alphanum'));
        }
        if (isset($arg[4]) && !empty($arg[4]) && usr($d, 'exist', $u)) {
            $block = vc($arg[4], 'num');
            $uid = usr($d, 'select', $u)['id'];
            $bc = db($d, 's,try', 'session', 'uid,device', $uid, 'bs.'.ip().ip('dev'), 'ORDER BY id DESC LIMIT 1');
            if (count($bc) > 0) {
                $bc = $bc[0]['try'];
            } else {
                $bc = 0;
            }

            if ($bc < $block) {
                $bc = $bc+1;
                if ($bc === 1) {
                    db($d, 'i', 'session', 'uid,device,code,tms,try', $uid, 'bs.'.ip().ip('dev'), rn(20), dt(), $bc);
                } else {
                    db($d, 'u', 'session', 'try', 'uid,device', $bc, $uid, 'bs.'.ip().ip('dev'));
                }
            } else {
                $u = null;
                $r[1] = 'blocked';
            }
        }
        if (!empty($u)) {
            $kr = db($d, 's', 'users', $f, $u, 'ORDER BY id DESC LIMIT 1');
            if (count($kr) > 0) {
                $kr = $kr[0];
                $p = en($p, $kr['depict'], $kr['mask'])['pass'];
                if ($kr['pass'] === $p) {
                    db($d, 'd', 'session', 'uid,device', $kr['id'], 'bs.'.ip().ip('dev'));
                    if ($kr['role'] != '0') {
                        ses($d, 'add', $kr['id']);
                        $r['uid'] = $kr['id'];
                        $r['code'] = $_SESSION[$d.'usrcode'];
                        $r['dev'] = $_SESSION[$d.'usrdev'];
                        $r['ses'] = $_SESSION[$d.'usrses'];
                        if (isset($arg[5]) && $arg[5] == 1) {
                            setcookie($d.'usrdev', $_SESSION[$d.'usrdev'], time() + (86400 * 30), "/");
                            setcookie($d.'usrcode', $_SESSION[$d.'usrcode'], time() + (86400 * 30), "/");
                            setcookie($d.'usrses', $_SESSION[$d.'usrses'], time() + (86400 * 30), "/");
                        }
                        $r[0] = true;
                    } else {
                        $r[1] = 'banned';
                    }
                }}
        }
        return $r;

    } else if ($t === 'select') {
        $i = strtolower(vc($arg[2], 'num'));
        $f = 'id';
        if (empty($i)) {
            $f = 'email';
            $i = vc($arg[2], 'email');
        }
        if (empty($i)) {
            $f = 'name';
            $i = vc($arg[2], 'alphanum');
        }
        $r = db($d, 's', 'users', $f, $i, 'ORDER BY id DESC LIMIT 1');
        if (isset($r[0])) {
            $r = $r[0];
        }
        return $r;
    } else if ($t === 'exist') {
        $v = strtolower(vc($arg[2], 'num'));
        $sr = 'id';
        if (empty($v)) {
            $sr = 'email';
            $v = vc($arg[2], 'email');
        }
        if (empty($v)) {
            $sr = 'name';
            $v = vc($arg[2], 'alphanum');
        }
        $r = db($d, 's,count(*)', 'users', $sr, $v)[0][0];
        if ($r > 0) {
            return true;
        } else {
            return false;
        }
    } else if ($t === 'remember') {
        if (isset($_COOKIE[$d.'usrses']) && isset($_COOKIE[$d.'usrcode']) && isset($_COOKIE[$d.'usrdev'])) {
            $_SESSION[$d.'usrdev'] = $_COOKIE[$d.'usrdev'];
            $_SESSION[$d.'usrcode'] = $_COOKIE[$d.'usrcode'];
            $_SESSION[$d.'usrses'] = $_COOKIE[$d.'usrses'];
        }
    } else if ($t === 'alter') {
        $tm = dt();
        $r = false;
        $ch = vc($arg[2], 'alphanum');
        $id = vc($arg[4], 'num');
        if (!empty($id)) {
            if ($ch === 'email') {
                $v = strtolower(vc($arg[3], 'email'));
            } else if ($ch === 'name') {
                $v = strtolower(vc($arg[3], 'alphanum'));
            } else if ($ch === 'role') {
                $v = strtolower(vc($arg[3], 'num'));
            }
            if ($ch === 'pass') {
                $v = $arg[3];
                if (!empty($v)) {
                    $p = en($v);
                    $r = db($d, 'u', 'users', 'pass,mask,depict,altered', 'id', $p['pass'], $p['mask'], $p['type'], $tm, $id);
                }
            } else if ($ch === 'email' || $ch === 'name' || $ch === 'role') {
                if (!empty($v)) {
                    if (!usr($d, 'exist', $v) || $ch === 'role') {
                        $r = db($d, 'u', 'users', $ch.',altered', 'id', $v, $tm, $id);
                    }
                }
            }
        }
        return $r;
    } else {
        return ses($d);
    }

}

function ses($d, $t = 0, $v = 0) {
    $v = vc($v, 'num');
    if ($t === 'del') {
        if (!isset($_SESSION[$d.'usrdev'])) {
            $_SESSION[$d.'usrdev'] = $_SESSION[$d.'usrcode'] = null;
        }
        $id = db($d, 's,id', 'session', 'uid,device,code', $v, $_SESSION[$d.'usrdev'], $_SESSION[$d.'usrcode']);
        if (isset($id[0]['id'])) {
            $id = $id[0]['id'];
        } else {
            $id = null;
        }
        db($d, 'd', 'session', 'uid,device,code', $v, $_SESSION[$d.'usrdev'], $_SESSION[$d.'usrcode']);
        $_SESSION[$d.'usrdev'] = $_SESSION[$d.'usrcode'] = $_SESSION[$d.'usrses'] = null;
        if (isset($_COOKIE[$d.'usrses'])) {
            unset($_COOKIE[$d.'usrcode']);
            unset($_COOKIE[$d.'usrses']);
            unset($_COOKIE[$d.'usrdev']);
            setcookie($d.'usrses', '', time() - 3600, '/');
            setcookie($d.'usrcode', '', time() - 3600, '/');
            setcookie($d.'usrdev', '', time() - 3600, '/');
        }
        return $id;
    } else if ($t === 'add') {
        $_SESSION[$d.'usrdev'] = ip().ip('dev');
        $_SESSION[$d.'usrcode'] = rn("5").rn("9");
        $_SESSION[$d.'usrses'] = db($d, 'i', 'session', 'uid,device,code,tms', $v, $_SESSION[$d.'usrdev'], $_SESSION[$d.'usrcode'], dt());
        return true;
    } else {
        $r['active'] = false;
        $r['id'] = 0;
        if (isset($_SESSION[$d.'usrses']) && isset($_SESSION[$d.'usrcode'])) {
            $c = db($d, 's', 'session', 'id,device,code', $_SESSION[$d.'usrses'], $_SESSION[$d.'usrdev'], $_SESSION[$d.'usrcode'], 'ORDER BY id DESC');
            if (count($c) > 0) {
                $r['active'] = true;
                $r['id'] = $c[0]['uid'];
            } else {
                $_SESSION[$d.'usrdev'] = $_SESSION[$d.'usrcode'] = $_SESSION[$d.'usrses'] = null;
                if (isset($_COOKIE[$d.'usrses'])) {
                    unset($_COOKIE[$d.'usrses']);
                    setcookie($d.'usrses', '', time() - 3600, '/');
                }
            }
        }
        return $r;

    }
}

?>