<?php if(!defined('s7V9pz')) {die();}?><?php
$_SESSION['utrack'] = 'on';
function gr_register($do) {
    if ($GLOBALS["default"]['userreg'] == 'enable') {
        if (!empty($do["g-recaptcha-response"]) && gr_captcha($do["g-recaptcha-response"]) || $GLOBALS["default"]['recaptcha'] != 'enable') {
            if (gr_usip('check')) {
                gr_prnt('say("'.gr_lang('get', 'ip_blocked').'","e");');
                exit;
            }
            $do["email"] = vc($do["email"], 'email');
            $do["name"] = vc($do["name"], 'alphanum');
            $do["fname"] = vc($do["fname"], 'strip');
            if (empty($do["fname"]) || empty($do["name"]) || empty($do["email"]) || empty($do["pass"])) {
                gr_prnt('say("'.gr_lang('get', 'invalid_value').'");');
            } else {
                if ($GLOBALS["default"]['email_verification'] == 'enable') {
                    $reg = usr('Grupo', 'register', $do["name"], $do["email"], $do["pass"]);
                } else {
                    $reg = usr('Grupo', 'register', $do["name"], $do["email"], $do["pass"], 3);
                }
                if ($reg[0]) {
                    $id = $reg[1];
                    gr_data('i', 'profile', 'name', $do["fname"], $id, $do["name"], gr_usrcolor());
                    if ($GLOBALS["default"]['email_verification'] == 'enable') {
                        gr_mail('verify', $id, 0, rn(5), 1);
                        gr_prnt('alert("'.gr_lang('get', 'check_inbox').'");');
                        gr_prnt('window.location.href = "";');
                    } else {
                        $grjoin = $GLOBALS["default"]['autogroupjoin'];
                        if (!empty($grjoin)) {
                            $cr = gr_group('valid', $grjoin);
                            if ($cr[0]) {
                                gr_data('i', 'gruser', $grjoin, $id, 0);
                                $dt = array();
                                $dt['id'] = $grjoin;
                                $dt['msg'] = 'joined_group';
                                gr_group('sendmsg', $dt, 1, 1, $id);
                            }
                        }
                        usr('Grupo', 'forcelogin', $id);
                        $_SESSION['grcreset'] = 1;
                        gr_prnt('location.reload();');
                    }
                } else {
                    if ($reg[1] == 'usernamecondition') {
                        gr_prnt('say("'.gr_lang('get', 'username_condition').'");');
                    } else if ($reg[1] == 'usernameexist') {
                        gr_prnt('say("'.gr_lang('get', 'username_exists').'");');
                    } else if ($reg[1] == 'emailexist') {
                        gr_prnt('say("'.gr_lang('get', 'email_exists').'");');
                    }
                }
            }
        } else {
            gr_prnt('say("'.gr_lang('get', 'invalid_captcha').'");');
        }
    }
}

function gr_login($do) {
    if ($GLOBALS["default"]['recaptcha'] != 'enable' || !empty($do["g-recaptcha-response"]) && gr_captcha($do["g-recaptcha-response"])) {
        if (gr_usip('check')) {
            gr_prnt('say("'.gr_lang('get', 'ip_blocked').'","e");');
            exit;
        }
        if (!empty($do["nickname"]) && $GLOBALS["default"]['guest_login'] == 'enable') {
            $do['sign'] = preg_replace('/@.*/', '', $do['nickname']);
            $nme = $usrn = $do['nickname'];
            if (usr('Grupo', 'exist', $usrn)) {
                gr_prnt('say("'.gr_lang('get', 'username_exists').'");');
                exit;
            }
            $sign = rn(4).rn(3).'@'.rn(13).'.com';
            $pasw = rn(12);
            $reg = usr('Grupo', 'register', $usrn, $sign, $pasw, 5);
            if ($reg[0]) {
                $id = $reg[1];
                gr_data('i', 'profile', 'name', $nme, $id, $usrn, gr_usrcolor());
                $grjoin = $GLOBALS["default"]['autogroupjoin'];
                if (!empty($grjoin)) {
                    $cr = gr_group('valid', $grjoin);
                    if ($cr[0]) {
                        gr_data('i', 'gruser', $grjoin, $id, 0);
                        $dt = array();
                        $dt['id'] = $grjoin;
                        $dt['msg'] = 'joined_group';
                        gr_group('sendmsg', $dt, 1, 1, $id);
                    }
                }
                usr('Grupo', 'forcelogin', $usrn);
                $_SESSION['grcreset'] = 1;
            }
            gr_prnt('window.location.href = "";');
            exit;
        } else {
            $login = usr('Grupo', 'login', $do["sign"], $do["pass"], $GLOBALS["default"]['max_login_attempts'], $do["rmbr"]);
            if ($login[0]) {
                $_SESSION['grcreset'] = 1;
                gr_prnt('window.location.href = "";');
            } else {
                if ($login[1] === 'blocked') {
                    gr_prnt('say("'.gr_lang('get', 'device_blocked').'");');
                } else {
                    gr_prnt('say("'.gr_lang('get', 'invalid_login').'");');
                }
            }
        }
    } else {
        gr_prnt('say("'.gr_lang('get', 'invalid_captcha').'");');
    }
}

function gr_forgot($do) {
    if (!empty($do["g-recaptcha-response"]) && gr_captcha($do["g-recaptcha-response"]) || $GLOBALS["default"]['recaptcha'] != 'enable') {
        if (empty($do["sign"])) {
            gr_prnt('say("'.gr_lang('get', 'invalid_value').'");');
        } else {
            $usr = usr('Grupo', 'select', $do["sign"]);
            if (isset($usr['id'])) {
                gr_mail('reset', $usr['id'], 0, rn(5), 1);
                gr_prnt('alert("'.gr_lang('get', 'check_inbox').'");');
                gr_prnt('window.location.href = "";');
            } else {
                gr_prnt('say("'.gr_lang('get', 'user_does_not_exist').'","e");');
            }
        }
    } else {
        gr_prnt('say("'.gr_lang('get', 'invalid_captcha').'");');
    }
}

function gr_captcha($response) {
    $response;
    $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
    $post_data = http_build_query(
        array(
            'secret' => $GLOBALS["default"]['rsecretkey'],
            'response' => $response,
            'remoteip' => (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'])
        )
    );
    if (function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec')) {
        $ch = curl_init($verifyURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-type: application/x-www-form-urlencoded'));
        $response = curl_exec($ch);
        curl_close($ch);
    } else {
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context = stream_context_create($opts);
        $response = file_get_contents($verifyURL, false, $context);
    }
    if ($response) {
        $result = json_decode($response);
        if ($result->success === true) {
            return true;
        } else {
            return $result;
        }
    }
    return false;
}
?>