<?php
require_once 'settings.php';

function cleanImages() {
  $images = (array)$_SESSION['images'];

  foreach ($images as $image)
    @unlink($settings['documentRoot'].$settings['upload']['path']['images'].$image);

  unset($_SESSION['images']);
}
