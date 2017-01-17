<?php
require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
 
session_start();

$config = [
    'consumer_key'      => 'Tv7rcVyFJW8Jos9gSfcnRTyj6',
    'consumer_secret'   => 'jvMcLHvPehmLe9X1jYZarKUUVTxY5flEGxZCDoKai7almmuwRW',
    'url_login'         => 'http://localhost/twitter_login.php',
    'url_callback'      => 'http://localhost/twitter_callback.php',
];


// create TwitterOAuth object
$twitteroauth = new TwitterOAuth($config['consumer_key'], $config['consumer_secret']);
 
// request token of application
$request_token = $twitteroauth->oauth(
    'oauth/request_token', [
        'oauth_callback' => $config['url_callback']
    ]
);
 
// throw exception if something gone wrong
if($twitteroauth->getLastHttpCode() != 200) {
    throw new \Exception('There was a problem performing this request');
}
 
// save token of application to session
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
 
// generate the URL to make request to authorize our application
$url = $twitteroauth->url(
    'oauth/authorize', [
        'oauth_token' => $request_token['oauth_token']
    ]
);
 
// and redirect
header('Location: '. $url);

