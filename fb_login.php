<?php
//session_start();
//require '../login/Facebook/autoload.php';
//
//$fb = new Facebook\Facebook([
//    'app_id' => '696113500523537',
//    'app_secret' => 'f7c94fe5f0f51cc9a04fc2512b5c58cd',
//    'default_graph_version' => 'v2.8',
//]);
//
//$helper = $fb->getRedirectLoginHelper();
//$permissions = ['email', 'user_likes']; // optional
//$loginUrl = $helper->getLoginUrl('http://radiusdev.guestcompass.nl/callback.php', $permissions);
//
//echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
//exit;


session_start();

require '../login/Facebook/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '696113500523537',
    'app_secret' => 'f7c94fe5f0f51cc9a04fc2512b5c58cd',
    'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (isset($accessToken)) {
    // Logged in!
    $_SESSION['facebook_access_token'] = (string) $accessToken;

    $result = $fb->get('me/likes/830775716985965', $accessToken);

    $res = $result->getGraphEdge()->asArray();

    $pages = array();

    foreach($res as $page){
        $pages[] = $page['id'];
    }

    var_dump($pages);

    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']
} else {
    var_dump('Logged Out');
}