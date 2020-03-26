<?php if(!defined('s7V9pz')) {die();}?><?php
fc('grupo');
$usr = $GLOBALS["user"];
$loadgroup = '';
if (!$GLOBALS["logged"]) {
    if (isset($_POST['act'])) {
        $data[0] = new stdClass();
        $data[0]->liveup = 'refresh';
        gr_prnt(json_encode($data));
        exit;
    } else {
        rt('signin');
    }
}
grupofns();
gr_unverified();
gr_profile('ustatus', 'online');
gr_usip('add');
gr_acton();
if (isset($_SESSION['grviewgroup']) && !empty($_SESSION['grviewgroup'])) {
    $loadgroup = vc($_SESSION['grviewgroup'], "num");
    unset($_SESSION['grviewgroup']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no shrink-to-fit=no">
    <title><?php gec($GLOBALS["default"]['sitename'].' - '.$GLOBALS["default"]['siteslogan']); ?></title>
    <meta name="description" content="<?php gec($GLOBALS["default"]['sitedesc']); ?>">
    <meta name="author" content="BaeVox">
    <meta name="generator" content="Grupo - Powered by BaeVox">
    <link rel="shortcut icon" type="image/png" href="<?php gec(mf("grupo/global/favicon.png")); ?>" />
    <?php
    css("riches/kit/bootstrap/bootstrap.min");
    css("riches/fonts/".$GLOBALS["default"]['default_font']."/font");
    css("riches/kit/emojionearea/dist/emojionearea.min");
    css("riches/kit/animate/animate.min");
    css("riches/kit/colorpicker/dist/css/bootstrap-colorpicker.min");
    css("riches/fonts/grupo/css/icons");
    css("ajx");
    css("grupo");
    ?>
</head>
<body>
    <?php gr_core('hf', 'header'); ?>
    <div class='gr-preloader'>
        <div>
            <span class="animated infinite fadeIn"></span>
        </div>
    </div>
    <section class="swr-grupo baevox-powered<?php gec(' '.$GLOBALS["lang"]['core_align']) ?>">
        <div class='window fh'>
            <div class="container-fluid fh">
                <div class="row fh">
                    <div class="col-md-3 aside lside">
                        <div class='head'>
                            <span class='menu'>
                                <i class="gi-menu mmenu subnav">
                                    <div class='swr-menu'>
                                        <ul>
                                            <li class='formpop' title='<?php gec($GLOBALS["lang"]['edit_profile']) ?>' do='edit' btn='<?php gec($GLOBALS["lang"]['update']) ?>' act='profile'><?php gec($GLOBALS["lang"]['edit_profile']) ?></li>
                                            <li class='formpop' title='<?php gec($GLOBALS["lang"]['change_avatar']) ?>' do='edit' btn='<?php gec($GLOBALS["lang"]['update']) ?>' act='avatar'><?php gec($GLOBALS["lang"]['change_avatar']) ?></li>
                                            <?php
                                            if (gr_role('access', 'fields', '4')) {
                                                ?>
                                                <li class='loadside' act='ufields' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_fields']) ?>' side='lside'><?php gec($GLOBALS["lang"]['fields']) ?></li>
                                                <?php
                                            }
                                            if (gr_role('access', 'users', '4')) {
                                                ?>
                                                <li class='loadside' act='users' side='lside' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_users']) ?>'><?php gec($GLOBALS["lang"]['users']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'roles', '3')) {
                                                ?>
                                                <li class='loadside' act='roles' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_roles']) ?>' side='lside'><?php gec($GLOBALS["lang"]['roles']) ?></li>
                                                <?php
                                            }
                                            if (gr_role('access', 'users', '5')) {
                                                ?>
                                                <li class='loadside' act='online' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_online']) ?>' side='lside'><?php gec($GLOBALS["lang"]['online']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'languages', '4')) {
                                                ?>
                                                <li class='loadside' act='languages' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_languages']) ?>' side='lside'><?php gec($GLOBALS["lang"]['languages']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'sys', '2')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['easycustomizer']) ?>' do='system' btn='<?php gec($GLOBALS["lang"]['update']) ?>' act='easycustomizer'><?php gec($GLOBALS["lang"]['easycustomizer']) ?></li>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['appearance']) ?>' do='system' btn='<?php gec($GLOBALS["lang"]['update']) ?>' act='appearance'><?php gec($GLOBALS["lang"]['appearance']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'sys', '5')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['header_footer']) ?>' do='system' btn='<?php gec($GLOBALS["lang"]['update']) ?>' act='hf'><?php gec($GLOBALS["lang"]['header_footer']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'sys', '3')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['banip']) ?>' do='system' btn='<?php gec($GLOBALS["lang"]['update']) ?>' act='banip'><?php gec($GLOBALS["lang"]['banip']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'sys', '4')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['filterwords']) ?>' do='system' btn='<?php gec($GLOBALS["lang"]['update']) ?>' act='filterwords'><?php gec($GLOBALS["lang"]['filterwords']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'sys', '1')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['settings']) ?>' do='system' btn='<?php gec($GLOBALS["lang"]['update']) ?>' act='settings'><?php gec($GLOBALS["lang"]['settings']) ?></li>
                                                <?php
                                            }
                                            ?>
                                            <li class='ajx switchmode' data-act=1 data-do='profile' data-type='mode'><?php gr_profile('mode'); ?></li>
                                            <li class='standby'><?php gec($GLOBALS["lang"]['stand_by']); ?></li>
                                            <li class='ajx' data-act=1 data-do='logout'><?php gec($GLOBALS["lang"]['logout']) ?></li>
                                        </ul>
                                    </div>
                                </i>
                                <i class='gi-bell-1 malert goright d-md-none' data-block='alerts'></i>
                            </span>
                            <span class='logo'>
                                <img src="gem/ore/grupo/global/sitelogo.png" class="d-none d-md-block" />
                                <img src="gem/ore/grupo/global/mobilelogo.png" class="d-block d-md-none" />
                            </span>
                            <span class='icons'>
                                <i class="gi-list-add subnav udolist">
                                    <div class='swr-menu r-end'>
                                        <ul>
                                            <?php
                                            if (gr_role('access', 'files', '1')) {
                                                ?>
                                                <li act='files'><form class='uploadfiles' method='post' action='' enctype="multipart/form-data">
                                                    <input type='file' multiple name='file[]' />
                                                    <input type="hidden" name="act" value="1">
                                                    <input type="hidden" name="type" value="upload">
                                                    <input type="hidden" name="do" value="files">
                                                </form>
                                                    <span><?php gec($GLOBALS["lang"]['upload_file']) ?></span></li>
                                                <?php
                                            } if (gr_role('access', 'groups', '1')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['create_group']) ?>' do='create' btn='<?php gec($GLOBALS["lang"]['create']) ?>' act='group'><?php gec($GLOBALS["lang"]['create_group']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'users', '1')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['create_user']) ?>' do='create' btn='<?php gec($GLOBALS["lang"]['create']) ?>' act='user'><?php gec($GLOBALS["lang"]['create_user']) ?></li>
                                                <?php
                                            }if (gr_role('access', 'roles', '1')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['create_role']) ?>' do='create' btn='<?php gec($GLOBALS["lang"]['create']) ?>' act='role'><?php gec($GLOBALS["lang"]['create_role']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'languages', '1')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['add_language']) ?>' do='create' btn='<?php gec($GLOBALS["lang"]['add']) ?>' act='language'><?php gec($GLOBALS["lang"]['add_language']) ?></li>
                                                <?php
                                            } if (gr_role('access', 'fields', '1')) {
                                                ?>
                                                <li class='formpop' title='<?php gec($GLOBALS["lang"]['add_custom_field']) ?>' do='create' btn='<?php gec($GLOBALS["lang"]['add']) ?>' act='customfield'><?php gec($GLOBALS["lang"]['add_custom_field']) ?></li>
                                                <?php
                                            } ?>
                                        </ul>
                                    </div>
                                </i>
                                <span class="vwp d-md-none mprf" no="<?php gec($usr['id']); ?>">
                                    <img class="lazyimg" data-src="<?php gec(gr_img('users', $usr['id'])); ?>">
                                </span>
                            </span>
                        </div>
                        <div class="search">
                            <i class="gi-search"></i>
                            <input type="text" placeholder='<?php gec($GLOBALS["lang"]['search_here']) ?>' />
                        </div>
                        <div class="tabs">
                            <ul>
                                <li class='active' act='groups' side='lside' openfirst='1' zero='0' unseen='<?php gec(gr_group('unseen')) ?>' zval='<?php gec($GLOBALS["lang"]['zero_groups']) ?>'><?php gec($GLOBALS["lang"]['groups']) ?> <i></i></li>
                                <?php
                                if (gr_role('access', 'privatemsg', '2')) {
                                    ?>
                                    <li act='pm' side='lside' zero='0' unread='0' zval='<?php gec($GLOBALS["lang"]['zero_pm']) ?>'><?php gec($GLOBALS["lang"]['pm']) ?> <i></i></li>
                                    <?php
                                } ?>
                                <?php
                                if (gr_role('access', 'files', '5')) {
                                    ?>
                                    <li act='files' <?php if (gr_role('access', 'files', '1')) { gec('class=uploadable'); } ?> side='lside' zero='0KB' zval='<?php gec($GLOBALS["lang"]['zero_files']) ?>'><?php gec($GLOBALS["lang"]['files']) ?></li>
                                    <?php
                                } ?>

                                <li side='lside' class='xtra'></li>
                                <span class="gruploader">
                                    <i class="gi-up-open-1 animated rotateIn infinite" data-toggle="tooltip" title="<?php gec($GLOBALS["lang"]['uploading']) ?>"></i>
                                </span>
                            </ul>
                        </div>
                        <div class="content">
                            <div class='grloader listloader'>
                                <div>
                                    <div>
                                        <div class="spin">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='dragfile dragupload'>
                                <div>
                                    <div>
                                        <div class="icon"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="d-none grproceed loadside appnd" offset=0></span>
                            <ul class='list fh'>

                            </ul>
                            <span class="addmore">
                                <span>
                                    <i class="gi-plus"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6 nomob panel" no=0>
                        <div class='head groupnav d-none'>
                            <i class='icon gi-left-open goback d-md-none'></i>
                            <span class='left'>
                                <span>
                                    <img class="lazyimg" data-src="gem/ore/grupo/global/load.gif">
                                    <span></span>
                                </span></span>
                            <span class='right'>
                                <i class='gi-bell-1 malert goright d-md-none' data-block='palert'></i>
                                <?php
                                if (gr_role('access', 'files', '5')) {
                                    ?>
                                    <i class='icon gi-archive goback d-md-none' data-block="files"></i>
                                    <?php
                                } ?>
                                <i class='gi-users goright d-md-none' data-block='crew'></i>
                                <i class="gi-search searchmsgs"></i>
                                <i class="gi-switch d-none d-sm-inline-block fullview"></i>
                                <i class="gi-dot-3 subnav">
                                    <div class='swr-menu r-end'>
                                        <ul></ul>
                                    </div>
                                </i></span>
                        </div>
                        <div class="searchbar">
                            <span>
                                <i class="gi-search"></i>
                                <input type="text" placeholder='<?php gec($GLOBALS["lang"]['search_messages']) ?>' />
                            </span>
                        </div>
                        <div class='room fh'>
                            <span class='groupreload'><i class='turnchat' do='on'><i class='gi-ccw'></i><?php gec($GLOBALS["lang"]['reload']) ?></i></span>
                            <div class='grloader msgloader'>
                                <div>
                                    <div>
                                        <div class="spin"></div>
                                    </div>
                                </div>
                            </div>
                            <div class='dragfile dragattach'>
                                <div>
                                    <div>
                                        <div class="icon"></div>
                                    </div>
                                </div>
                            </div>
                            <ul class='msgs fh'>
                                <div class='zeroelem fh'>
                                    <div class="welcome">
                                        <span>
                                            <img src="gem/ore/grupo/global/welcome.png" />
                                            <i class="title"><?php gec(gr_lang('get', 'welcome_user')) ?></i>
                                            <i class="desc"><?php gec(gr_lang('get', 'welcome_msg')) ?></i>
                                            <i class="foot"><?php gec(gr_lang('get', 'welcome_footer')) ?></i>
                                        </span>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class='textbox d-none disabled'>
                            <div class="mentstore"></div>
                            <div class="mentions">
                                <ul>
                                </ul>
                                <input type='hidden' />
                            </div>
                            <?php
                            if ($GLOBALS["default"]['tenor_enable'] == 'enable' && gr_role('access', 'features', '3')) {
                                ?>
                                <div class="grgif">
                                    <div class="wrap">
                                        <span class="search"><input spellcheck="false" type="text" placeholder="<?php gec($GLOBALS["lang"]['search_gifs_tenor']) ?>" /></span>
                                        <div class="gifs">
                                            <span class="loading"></span>
                                            <ul class='grgifconts'>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } ?>
                            <span class='box'>
                                <span class='icon left'>
                                    <i class='gr-emoji' data-toggle="tooltip" title="<?php gec($GLOBALS["lang"]['emojis']) ?>"></i>
                                    <?php
                                    if ($GLOBALS["default"]['tenor_enable'] == 'enable' && gr_role('access', 'features', '3')) {
                                        ?>
                                        <i class='gr-gif' data-toggle="tooltip" title="<?php gec($GLOBALS["lang"]['gifs']) ?>"></i>
                                        <?php
                                    } if (gr_role('access', 'features', '4')) {
                                        ?>
                                        <i class='gr-qrcode' data-toggle="tooltip" title="<?php gec($GLOBALS["lang"]['qrcode']) ?>"></i>
                                        <?php
                                    } ?>
                                </span>
                                <textarea placeholder="<?php gec($GLOBALS["lang"]['type_message']) ?>"></textarea>
                                <span class='icon'>
                                    <?php
                                    if (gr_role('access', 'files', '4')) {
                                        ?>
                                        <i class='gr-attach' data-toggle="tooltip" title="<?php gec($GLOBALS["lang"]['attach']) ?>"><form class='atchmsg' enctype="multipart/form-data">
                                            <input type="hidden" name="act" value="1">
                                            <input type="hidden" name="do" value="group">
                                            <input type="hidden" name="id" class='gid'>
                                            <input type="hidden" name="type" value="attachmsg">
                                            <input type='file' name='attachfile' class='attachfile' />
                                        </form>
                                        </i>
                                        <?php
                                    } ?>
                                    <?php
                                    if (gr_role('access', 'features', '2')) {
                                        ?>
                                        <i class='gr-mic' data-toggle="tooltip" title="<?php gec($GLOBALS["lang"]['voice_message']) ?>">
                                            <button class="mstart" onclick="startRecording(this);"></button>
                                            <button class="mstop animated infinite fadeIn" onclick="stopRecording(this);" disabled></button>
                                        </i>
                                        <?php
                                    } ?>
                                </span>
                                <input type='hidden' value=0 class='replyid' />
                                <i class='sendbtn'><i></i></i>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3 nomob aside rside">
                        <div class='top'>
                            <span class='left'>
                                <i class='icon gi-left-open goback d-md-none'></i>
                                <span class="vwp" no="<?php gec($usr['id']); ?>">
                                    <img class="lazyimg" data-src="<?php gec(gr_img('users', $usr['id'])); ?>">
                                    <span><?php gec(gr_profile('get', $usr['id'], 'name')); ?>
                                        <span>@<?php gec(usr('Grupo', 'select', $usr['id'])['name']); ?></span>
                                    </span>
                                </span></span>
                            <span class='right'>
                                <?php gec(gr_lang('list')) ?>
                            </span>
                        </div>
                        <div class="search">
                            <i class="gi-search"></i>
                            <input type="text" spellcheck="false" placeholder='<?php gec($GLOBALS["lang"]['search_here']) ?>' />
                        </div>
                        <div class="tabs">
                            <ul>
                                <li act='alerts' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_alerts']) ?>' side='rside'><?php gec($GLOBALS["lang"]['alerts']) ?> <i></i></li>
                                <li act='crew' class='grtab d-none' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_crew']) ?>' side='rside'><?php gec($GLOBALS["lang"]['crew']) ?></li>
                                <li act='complaints' comp=0 class='grtab d-none' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_complaints']) ?>' side='rside'><?php gec($GLOBALS["lang"]['complaints']) ?> <i></i></li>
                                <li side='rside' class='xtra'></li>
                            </ul>
                        </div>
                        <div class="content">
                            <div class='grloader listloader'>
                                <div>
                                    <div>
                                        <div class="spin"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="d-none grproceed loadside appnd" offset=0></span>
                            <ul class='list fh groups'>

                            </ul>
                            <div class="profile">
                                <div class="top">
                                    <span class="coverpic"><img class="lazyimg" data-src="" /><span></span></span>
                                    <span class="edit"><span><i class="gi-picture-1"></i></span><i class='formpop' title='<?php gec($GLOBALS["lang"]['edit_profile']) ?>' data-side="profile" do='edit' btn='<?php gec($GLOBALS["lang"]['update']) ?>' xtid="" act='profile'><?php gec($GLOBALS["lang"]['edit_profile']) ?></i></span>
                                    <span class="dp"><img class="lazyimg" data-src="" /></span>
                                    <span class="name"></span>
                                    <span class="role"></span>
                                    <span class="refresh vwp d-none">refresh</span>
                                </div>
                                <div class="middle">
                                    <span class="pm loadgroup" ldt="user" no=""><?php gec($GLOBALS["lang"]['message']) ?></span>
                                    <span class="stats">
                                        <span><span>0</span><i><?php gec($GLOBALS["lang"]['hearts']) ?></i></span>
                                        <span><span>0</span><i><?php gec($GLOBALS["lang"]['shares']) ?></i></span>
                                        <span><span>0</span><i><?php gec($GLOBALS["lang"]['last_login']) ?></i></span>
                                    </span>
                                </div>
                                <div class="bottom">
                                    <div>
                                        <ul>
                                        </ul>
                                        <div>
                                            <div>
                                                <span>
                                                    0
                                                    <span><?php gec($GLOBALS["lang"]['empty_profile']) ?></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <section class="grupo-standby">
        <div>
            <span><img class="lazyimg" data-src="<?php gec(mf("grupo/global/site-logo.png")); ?>" /></span>
        </div>
    </section>

    <section class="grupo-pop<?php gec(' '.$GLOBALS["lang"]['core_align']) ?>">
        <div>
            <form method='post' autocomplete="off" class='grform' spellcheck="false">
                <span class="grformspin">
                    <span></span>
                </span>
                <span class="head"></span>
                <span class="search">
                    <i class="gi-search"></i>
                    <input spellcheck="false" type="text" placeholder="<?php gec($GLOBALS["lang"]['search_here']) ?>" />
                </span>
                <div class="fields">

                </div>

                <input type="hidden" name="act" value="1">
                <input type="hidden" name="do" class="grdo">
                <input type="hidden" name="type" class="grtype">
                <input type="submit" class='grsub' form='.grform'>
                <span class="cancel"><?php gec($GLOBALS["lang"]['cancel']) ?></span>
            </form>
        </div>
    </section>

    <section class="grupo-video">
        <div>
            <div>
                <span> <i class="gi-cancel"></i></span>
            </div>
        </div>
    </section>
    <section class="gr-prvlink">
        <div class="grdrag">
            <i class="gi-cancel"></i>
            <span>
                <span class="loading"></span>
            </span>
            <img alt="preview" />
            <i class="submt">open</i>
        </div>
    </section>
    <section class="grupo-preview">
        <div>
            <div class="loader grdrag">
                <div class="gr-ldone">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="img grdrag">
                <span class="prclose"></span>
                <div></div>
            </div>
            <div class="video grdrag">
                <span class="prclose"></span>
                <div>
                    <video id="videprvw" controls>
                        <source src="" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="embed grdrag">
                <span class="prclose"></span>
                <div>
                </div>
            </div>
        </div>
    </section>
    <div class="out d-none"></div>
    <span class='autodelmsgz d-none'><?php gec(vc($GLOBALS["default"]['autodeletemsg'], 'num')) ?></span>
    <span class='pastescreen d-none'></span>
    <div class="dumb d-none">
        <span class='loadside goback lastseenz' act='lastseen' zero='0' srch=0 zval='<?php gec($GLOBALS["lang"]['zero_seen']) ?>' side='rside'><?php gec($GLOBALS["lang"]['seen_by']) ?></span>
        <span class='loadside srchbx' act='search' srch='' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_search']) ?>' side='lside'><?php gec($GLOBALS["lang"]['search']) ?></span>
        <span class='liveupdate'><?php gec($GLOBALS["lang"]['refresh']) ?></span>
        <span class='webtitle'><?php gec($GLOBALS["default"]['sitename'].' - '.$GLOBALS["default"]['siteslogan']); ?></span>
        <span class='newmsgalert'><?php gec($GLOBALS["lang"]['newmsgalert']) ?></span>
        <input type="hidden" class='liveuptime' value="<?php gec(vc($GLOBALS["default"]['refreshrate'], 'num')) ?>" />
        <span class="loadgroup"></span>
        <audio id='gralert'>
            <source src="<?php gec(gr_profile('get', $usr['id'], 'alert')); ?>" />
        </audio>
        <input type='hidden' class='hidid' value=1/>
        <li class='loadside ruserz' act='rusers' zero='0' zval='<?php gec($GLOBALS["lang"]['zero_users']) ?>' side='rside'><?php gec($GLOBALS["lang"]['users']) ?></li>
        <audio id="graudio">
            <source src="" type="audio/mp3">
        </audio>
        <div class="sendaudiomsg">
            Record Audio
        </div>
        <div class="gdefaults">
            <span class='tenorapi'><?php gec($GLOBALS["default"]['tenor_api']) ?></span>
            <span class='pagespeedapi'><?php gec($GLOBALS["default"]['pagespeed_api']) ?></span>
            <span class='tenorlimit'><?php gec(vc($GLOBALS["default"]['tenor_limit'], 'num')) ?></span>
            <span class="defload"></span>
            <span class="minmsglen"><?php gec(vc($GLOBALS["default"]['min_msg_length'], 'num')) ?></span>
            <span class="maxmsglen"><?php gec(vc($GLOBALS["default"]['max_msg_length'], 'num')) ?></span>
            <span class="enabletextarea"><?php gec (gr_role('access', 'features', '1')) ?></span>
            <span class="sharescreenshot"><?php gec (gr_role('access', 'features', '6')) ?></span>
            <span class="rdmre"><?php gec(vc($GLOBALS["default"]['add_readmore_after'], 'num')) ?></span>
            <span class="sndmsgalgn"><?php gec($GLOBALS["default"]['sent_msg_align']) ?></span>
            <span class="rcvmsgalgn"><?php gec($GLOBALS["default"]['received_msg_align']) ?></span>
        </div>
        <div class="gphrases">
            <span class='sending'><?php gec($GLOBALS["lang"]['sending']) ?></span>
            <span class='uploading'><?php gec($GLOBALS["lang"]['uploading']) ?></span>
            <span class='loading'><?php gec($GLOBALS["lang"]['loading']) ?></span>
            <span class='pleasewait'><?php gec($GLOBALS["lang"]['please_wait']) ?></span>
            <span class='readmore'><?php gec($GLOBALS["lang"]['read_more']) ?></span>
            <span class='failed'><?php gec($GLOBALS["lang"]['failed']) ?></span>
            <span class='searchmin'><?php gec($GLOBALS["lang"]['search_min']) ?></span>
            <span class='visit'><?php gec($GLOBALS["lang"]['visit']) ?></span>
            <span class='play'><?php gec($GLOBALS["lang"]['play']) ?></span>
            <span class='minlenreq'><?php gec($GLOBALS["lang"]['req_min_msg_length']) ?> (<?php gec(vc($GLOBALS["default"]['min_msg_length'], 'num')) ?>)</span>
            <span class='exceededmsg'><?php gec($GLOBALS["lang"]['exceeded_max_msg_length']) ?></span>
            <span class='notxtmsg'><?php gec($GLOBALS["lang"]['notxtmsg']) ?></span>
        </div>
        <div class="firstload">
            <?php
            if (!empty($loadgroup)) {
                $cu = gr_group('user', $loadgroup, $usr['id']);
                if ($cu[0]) {
                    if ($cu['role'] != 3) {
                        gr_prnt('<span class="loadgroup" ldt="group" no="'.$loadgroup.'">loadgroup</span>');
                    }
                } else {
                    gr_prnt('<span class="formpop" title="'.$GLOBALS["lang"]['join_group'].'" do="group" ldt="group" btn="'.$GLOBALS["lang"]['join'].'" act="join" no="'.$loadgroup.'">joingroup</span>');
                }
            }
            ?>
        </div>
        <pre id="log"></pre>
    </div>
    <?php gr_core('hf', 'footer'); ?>
</body>
<?php
css("custom");
gr_cbg();
js("riches/kit/jquery/jquery-3.4.1.min");
js("riches/kit/jquery/jquery-migrate-1.4.1.min");
js("riches/kit/jqueryui/jquery-ui");
js("riches/kit/jqueryui/jquery.ui.touch-punch.min");
js("riches/kit/jquerylazy/jquery.lazy.min");
js("riches/kit/jquerylazy/jquery.lazy.plugins.min");
js("riches/kit/popper/umd/popper.min");
js("riches/kit/bootstrap/bootstrap.min");
js("riches/kit/textcomplete/dist/jquery.textcomplete.min");
js("riches/kit/colorpicker/dist/js/bootstrap-colorpicker.min");
js("riches/kit/jsvideourlparser/dist/jsVideoUrlParser.min");
js("riches/kit/emojionearea/dist/emojionearea");
js("riches/kit/recorderjs/dist/recorder");
js("riches/kit/qrcode/qrcode.min");
js("riches/kit/nicescroll/jquery.nicescroll.min");
js("ajx", "caret", "gr-mic", "grgifs", "gr-live", "grupo");
gr_google();
gr_reactprof();
?>
</html>