<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\cmuoauthclass;
// use App\Models\userinfoclass;
class AuthController extends Controller
{
    public function callback(){
        session_start();
        // provide your application id,secret and redirect uri
        $appId = '';
        $appSecret = '';
        //$callbackUri[5] = 'http://localhost/php5/callback.php';
        $callbackUri[7] = 'http://localhost:8000/callback.php';
        $scope = 'cmuitaccount.basicinfo';
        $state = 'xyz';

        require('cmuoauthclass.php');
        // new CMU Oauth Instance.
        $cmuOauth = new cmuOauth();
        // set your application id,secret and redirect uri
        $cmuOauth->setAppId($appId);
        $cmuOauth->setAppSecret($appSecret);
        $cmuOauth->setCallbackUri($callbackUri[7]);
        $cmuOauth->setScope($scope);

        if (isset($_GET['error'])) {
        	session_destroy();
          exit($_GET['error']);
        } elseif(!isset($_GET['code'])){
        	//set state
        	$_SESSION['oauth2state'] = $cmuOauth->setState();

        	// initial redirect to CMU Oauth login page.
        	$cmuOauth->initOauth();

        // Check given state against previously stored one to mitigate CSRF attack
        } elseif(empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])){
        	if (isset($_SESSION['oauth2state'])) {
        		unset($_SESSION['oauth2state']);
        	}
        	exit('Invalid state');
        } else {
        	// code parse from CMU Oauth to your redirect uri.
        	$code = $_GET['code'];
        	// get access token from code.
        	$accessToken = $cmuOauth->getAccessTokenAuthCode($code);
          $_SESSION['accessToken']=$accessToken->access_token;
        }
        return view('test');
    }
}