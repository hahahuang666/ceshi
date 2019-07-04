<?php
include_once "wxBizDataCrypt.php";
$appid =$_GET['appid'];
$secret =$_GET['secret'];
$js_code=$_GET['code'];
$iv = ($_GET['iv']);
$encryptedData=($_GET['encryptedData']);
$grant_type='authorization_code';

$objSession=http_curl("https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$js_code&grant_type=$grant_type");
$session_key = json_decode($objSession)->session_key;

$decodeData = new WXBizDataCrypt($appid, $session_key);
$errCode = $decodeData->decryptData($encryptedData, $iv, $data );

if ($errCode == 0) {
    print($data . "\n");
} else {
    print($errCode . "\n");
}

function http_curl($url){
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,30);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $response=curl_exec($curl);
    curl_close($curl);
    return $response;
}