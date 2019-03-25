<?php

function returnZold($address) {
  $re = '/Balance\:\s[0-9\.]+/m';
  $str = file_get_contents('http://159.203.19.189:4096/wallet/'.$address.'.txt');
  preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
  $zold = explode(' ',$matches[0][0]);
  return $zold[1];
}

function makeHTTPRequest($method,$datas=[]){
  $url = "https://api.telegram.org/bot".API_KEY."/".$method;
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
  $res = curl_exec($ch);
  if(curl_error($ch)) {
    var_dump(curl_error($ch));
  } else {
    return json_decode($res);
  }
}

function logThis($id, $msg) {
  $file   = './'. date('Ymd-').'bot.log';
  file_put_contents($file, date('Y-m-d H:i').' | '.$id.' | '.$msg."\n", FILE_APPEND);
}

