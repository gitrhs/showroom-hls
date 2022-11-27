<?php
//first get id
$id = $_GET['user'];
//file get content
$homepage = file_get_contents("https://www.showroom-live.com/lite/$id");
//get crf token
$csrf1 = explode("SrGlobal.csrfToken = '", $homepage);
$csrf2 = explode("';", $csrf1[1]);
$csrf = $csrf2[0];

//get roomid
$roomid1 = explode("SrGlobal.room_id= ", $homepage);
$roomid2 = explode(";", $roomid1[1]);
$roomid = $roomid2[0];
//call json
//https://www.showroom-live.com/api/live/streaming_url?room_id=372499&abr_available=1&csrf_token=RNVbEDByebMGKW483rtvU7UstPbrM5rU4U_TW_5m
function REQUEST($URL1) {
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, $URL1);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch1, CURLOPT_USERAGENT, 'Mozilla/5.0 (Android 11; Mobile; rv:87.0) Gecko/87.0 Firefox/87.0');
curl_setopt($ch1, CURLOPT_ENCODING, 'gzip, deflate');
curl_setopt ($ch1, CURLOPT_POST, 0);
$headers1 = [
        'Host: www.showroom-live.com',
        'User-Agent: Mozilla/5.0 (Android 11; Mobile; rv:87.0) Gecko/87.0 Firefox/87.0',
        'Accept: application/json, text/plain, */*',
        'Accept-Language: en-US,en;q=0.5',
        'Accept-Encoding: gzip, deflate, br',
        'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
        'Cache-Control: no-cache;no-store,must-revalidate;max-age=0, no-cache',
        'Connection: keep-alive',
        "Referer: https://www.showroom-live.com/lite/$id",
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Site: same-origin',
        'Pragma: no-cache'
];
 curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);
$jalan1 = curl_exec($ch1);
return $jalan1;
}

$url1 = "https://www.showroom-live.com/api/live/streaming_url?room_id=$roomid&abr_available=1&csrf_token=$csrf";
$data1 = REQUEST($url1);

$inkey1 = explode('{"streaming_url_list":[{"url":"', $data1);
$inkey2 = explode('playlist.m3u8', $inkey1[1]);
//check if live or offline
$needle = 'https';

if (strpos($inkey2[0], $needle) !== false) {
$inkey = "$inkey2[0]"."playlist.m3u8";
echo $inkey;
} else {
    echo "Streamer is offline right now!";
}
?>
