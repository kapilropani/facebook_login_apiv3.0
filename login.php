<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="./style.css">
  </head>
<?php
session_start();
 
require ("vendor/autoload.php");
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

if(isset($_GET['state'])) {
  $_SESSION['FBRLH_state'] = $_GET['state'];
}
/*Step 1: Enter Credentials*/
$fb = new \Facebook\Facebook([
  'app_id' => getenv('API_ID'),
  'app_secret' => getenv('APP_SECERET'),
  'default_graph_version' => getenv('API_VERSION'),
  //'default_access_token' => '{access-token}', // optional
]);

/*Step 2 Create the url*/
if(empty($access_token)) {
  ?>
  <a class='loginBtn loginBtn--facebook' href='<?php echo $fb->getRedirectLoginHelper()->getLoginUrl("http://localhost/facebook_login/login.php") ?>'>Login with Facebook </a>
<?php }
/*Step 3 : Get Access Token*/
$access_token = $fb->getRedirectLoginHelper()->getAccessToken();
/*Step 4: Get the graph user*/
if(isset($access_token)) {
  try {
      $response = $fb->get('/me',$access_token);
      $fb_user = $response->getGraphUser();
      // set your redirection and everything here
      echo  $fb_user->getName();
      //  var_dump($fb_user);
  } catch (\Facebook\Exceptions\FacebookResponseException $e) {
      echo  'Graph returned an error: ' . $e->getMessage();
  } catch (\Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
  }
}