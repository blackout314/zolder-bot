<?php

require 'config.php';
define('API_KEY',   $TOKEN);
define('DEBUG',     false);  
require 'utils.php';

$data   = file_get_contents("php://input");
$update = json_decode($data, true);

if(DEBUG) {
    logThis(999, json_encode($update));
}

$new    = $update['message']['new_chat_members'];
$left   = $update['message']['left_chat_member'];

$msg    = $update['message']['text'];
$chat_id = $update['message']['from']['id'];

if($msg == "/start" || $msg == "/help"){
    makeHTTPRequest('sendMessage',[
        'chat_id'   => $update['message']['from']['id'],
        'text'      => "!zbalance <i>address</i>\n!ztx <i>address</i> last 10 tx",
        'parse_mode'=> 'HTML',
    ]);
}

if(preg_match('/^\/balance(\s)+([0-9a-z])+/i', $msg)) {
    $addr = trim(str_replace('/balance','',$msg));

    makeHTTPRequest('sendMessage',[
        'chat_id'   => $update['message']['from']['id'],
        'text'      => 'address [<b>'.$addr.'</b>] - ZLD '.returnZold($addr),
        'parse_mode'=> 'HTML',
    ]);
}

if(preg_match('/^\/show(\s)+([0-9a-z])+/i', $msg)) {   
    $addr = trim(str_replace('/show','',$msg));

    makeHTTPRequest('sendMessage',[
        'chat_id'   => $update['message']['from']['id'],
        'text'      => 'address '.$addr."\n```\n".returnTx($addr)."\n```",
        'parse_mode'=> 'Markdown',
    ]);
}
