<?php
require_once 'settings.php';

function jD($type, $data) { die(json_encode([$type => $data])); }
function cleanImages() {
  $images = (array)$_SESSION['images'];
  foreach ($images as $image) @unlink($settings['documentRoot'].$settings['upload']['path']['images'].$image);
  unset($_SESSION['images']);
}
