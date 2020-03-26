<?php if(!defined('s7V9pz')) {die();}?><?php
fc('grupo');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php gec($GLOBALS["lang"]['banned_page_title']) ?>">
    <meta name="author" content="Baevox">
    <meta name="generator" content="Grupo">
    <title><?php gec($GLOBALS["lang"]['banned_page_title']) ?></title>
    <link rel="shortcut icon" type="image/png" href="<?php pr(mf("grupo/global/favicon.png")); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500,600,700,700i,800" rel="stylesheet">
    <?php
    css("404");
    css("banned");
    ?>
</head>
<body>
    <div id="notfound">
        <div class="notfound ouch">
            <div class="notfound-404">
                <h1><?php gec($GLOBALS["lang"]['banned_page_ouch']) ?></h1>
            </div>
            <h2><?php gec($GLOBALS["lang"]['banned_page_heading']) ?></h2>
            <p>
                <?php gr_prnt($GLOBALS["lang"]['banned_page_desc']) ?>
            </p>
            <a href="mailto:<?php pr($GLOBALS["default"]['sysemail']); ?>"><?php gec($GLOBALS["lang"]['banned_page_go_to_btn']) ?></a>
        </div>
    </div>

</body>
</html>