<?php
require_once 'init.php';

$images = (array)$_SESSION['images'];

if (empty($_SESSION['facebook']['id']))
  die(json_encode(array('error' => 'You must authorize first.')));

if (!empty($_FILES)) {
  if ($_FILES['file']['error'][0] > 0) {
    die(json_encode(array('error' => 'There was an error uploading the file.')));
  }
  $image = $_FILES['file']['tmp_name'][0];
  $info = getimagesize($image);

  if (!empty($info) && is_array($info) && !empty($info['mime'])) {
    $ext = pathinfo($_FILES['file']['name'][0], PATHINFO_EXTENSION);
    $path = $settings['documentRoot'].'/'.$settings['upload']['path']['images'];
    $filename = md5(md5(time()));
    if (!move_uploaded_file($image, $path.$filename.'.'.$ext))
      die(json_encode(array('error' => 'Unable to move the image. Wrong permissions.')));
    else {
      /*
        Generation of thumbnail images
      */
      $im = new Intervention\Image\ImageManagerStatic;

      $img = $im->make($path.$filename.'.'.$ext);
      $img->resize(120, 120);
      $img->save($path.$filename.'_r120'.'.'.$ext);

      $img = $im->make($path.$filename.'.'.$ext);
      $img->resize(300, 300);
      $img->save($path.$filename.'_r300'.'.'.$ext);

      $img = $im->make($path.$filename.'.'.$ext);
      $img->crop(120, 120);
      $img->save($path.$filename.'_c120'.'.'.$ext);

      $img = $im->make($path.$filename.'.'.$ext);
      $img->crop(300, 300);
      $img->save($path.$filename.'_c300'.'.'.$ext);
    }
    $images[] = array('name' => $filename, 'ext' => $ext);
    $_SESSION['images'] = $images;
  } else {
    die(json_encode(array('error' => 'This is not an image.')));
  }
}
