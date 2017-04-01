<?php

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

    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']
}

$user = $fb->getUser();

if ($user) {
    try {
        $likes = $fb->api("/me/likes/830775716985965");
        if( !empty($likes['data']) )
            echo "I like!";
        else
            echo "not a fan!";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
exit;
//if ($user) {
//    $logoutUrl = $fb->getLogoutUrl();
//} else {
//    $loginUrl = $fb->getLoginUrl(array(
//        'scope' => 'user_likes'
//    ));
//}

echo "<pre>";
//var_dump($data); exit;