<?php
/**
 *
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
class cmuOauth extends Controller
{
  private $OAUTH_APP_ID = null;
  private $OAUTH_APP_SECRET = null;
  private $OAUTH_CALLBACK_URI = null;
  private $OAUTH_AUTHORIZE_URL = 'https://oauth.cmu.ac.th/v2/Authorize.aspx';
  private $OAUTH_TOKEN_URL = 'https://oauth.cmu.ac.th/v2/GetToken.aspx';
  private $SCOPE = null;
  private $STATE = null;

  function __construct($app_id = null, $app_secret = null, $call_back = null)
  {
    # code...
    $this->OAUTH_APP_ID = $app_id!==null?$app_id:null;
    $this->OAUTH_APP_SECRET = $app_secret!==null?$app_secret:null;
    $this->OAUTH_CALLBACK_URI = $call_back!==null?$call_back:null;
  }

  function setAppId($appid){
    $this->OAUTH_APP_ID = $appid;
  }

  function setAppSecret($appSecret){
    $this->OAUTH_APP_SECRET = $appSecret;
  }

  function setCallbackUri($uri){
    $this->OAUTH_CALLBACK_URI = $uri;
  }

  function setScope($scope){
    $this->SCOPE = $scope;
  }

  function setState(){
    $this->STATE = md5(uniqid(rand(), TRUE));
    return $this->STATE;
  }

  function initOauth(){
    header("location: $this->OAUTH_AUTHORIZE_URL?response_type=code&client_id=$this->OAUTH_APP_ID&redirect_uri=$this->OAUTH_CALLBACK_URI&scope=$this->SCOPE&state=$this->STATE");
    exit();
  }

  function getAccessTokenAuthCode($code){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $this->OAUTH_TOKEN_URL);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS,
    "code=$code".
    "&redirect_uri=$this->OAUTH_CALLBACK_URI".
    "&client_id=$this->OAUTH_APP_ID".
    "&client_secret=$this->OAUTH_APP_SECRET".
    "&grant_type=authorization_code");
    $result = curl_exec($curl);
    curl_close($curl);
    return json_decode($result);
  }

  function getAccessTokenClientCred(){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $this->OAUTH_TOKEN_URL);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_USERPWD, $this->OAUTH_APP_ID.":".$this->OAUTH_APP_SECRET);
    curl_setopt($curl, CURLOPT_POSTFIELDS,
    "grant_type=client_credentials".
    "&scope=$this->SCOPE");
    $result = curl_exec($curl);
    curl_close($curl);
    return json_decode($result);
  }
}

?>