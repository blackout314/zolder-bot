<?php
require 'config.php';

define('API_KEY',     $TOKEN);

require 'utils.php';


$data   = file_get_contents("php://input");
$update = json_decode($data, true);

logThis(999, json_encode($update));

$new    = $update['message']['new_chat_members'];
$left   = $update['message']['left_chat_member'];

$msg    = $update['message']['text'];

if($msg == "/start" || $msg == "/help"){
    $chat_id = $update['message']['from']['id'];

    makeHTTPRequest('sendMessage',[
        'chat_id'   => $update['message']['from']['id'],
        'text'      => '!zbalance <i>address</i>',
        'parse_mode'=> 'HTML',
    ]);
}

if(preg_match('/^!zbalance(\s)+([0-9a-z])+/i', $update['message']['text'])) {
    $chat_id = $update['message']['from']['id'];
    $addr = trim(str_replace('!zbalance','',$update['message']['text']));

    makeHTTPRequest('sendMessage',[
        'chat_id'   => $update['message']['from']['id'],
        'text'      => 'address [<b>'.$addr.'</b>] - ZLD '.returnZold($addr),
        'parse_mode'=> 'HTML',
    ]);
}
