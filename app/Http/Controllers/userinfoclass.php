<?php
/**
 *
 */
class UserInfo extends Models{

    function __construct() {
        # code...
    }

    function httpGet($url,$accessToken) {
        $httpHeader = array("Authorization: Bearer $accessToken");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result);
    }

    function getUserInfo($accessToken) {
        return $this->httpGet("https://misapi.cmu.ac.th/cmuitaccount/v1/api/cmuitaccount/basicinfo",$accessToken);
    }

    function getStudentBasicInfo($studentID, $accessToken) {
        return $this->httpGet("https://misapi.cmu.ac.th/cmuitaccount/v1/api/cmuitaccount/student/$studentID/basicinfo",$accessToken);
    }
}

?>