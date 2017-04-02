<?php
session_start();
require '../login/Facebook/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '696113500523537',
    'app_secret' => 'f7c94fe5f0f51cc9a04fc2512b5c58cd',
    'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('http://radiusdev.guestcompass.nl/callback.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
exit;