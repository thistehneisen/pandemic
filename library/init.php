<?php
session_start();

require_once 'settings.php';
require_once 'functions.php';
require_once 'idatabase.class.php';
$db = new iDataBase($settings['database']['hostname'], $settings['database']['username'], $settings['database']['password'], $settings['database']['database'], '');

require_once $settings['documentRoot'].'/vendor/autoload.php';

$fb = new \Facebook\Facebook([
  'app_id' => $settings['facebook']['app']['id'],
  'app_secret' => $settings['facebook']['app']['secret'],
  'default_graph_version' => 'v3.2'
]);

$jsHelper = $fb->getJavaScriptHelper();
try {
  $accessToken = $jsHelper->getAccessToken();
  $response = $fb->get('/me?locale=lv_LV&fields=id,name,picture', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // nasing
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // nasing
}

if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: '.$settings['fullAddress']);
  exit;
}

if (!empty($response)) {
  $graphNode = $response->getGraphNode();

  $db->insert('users', array(
    'id' => $graphNode['id'],
    'name' => $graphNode['name'],
    'picture' => $graphNode['picture']['url'],
    'lastlogin' => date("Y-m-d H:i:s"),
    'access_token' => $accessToken,
    'ip' => $_SERVER['REMOTE_ADDR']
  ), true);

  $_SESSION['facebook']['id'] = $graphNode['id'];
}
