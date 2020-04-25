<?php
#-------------------------[Include]-------------------------#
require_once('./include/line_class.php');
require_once('./unirest-php-master/src/Unirest.php');
#-------------------------[Token]-------------------------#
$channelAccessToken = '42bf4fdee9c9b1ffa200ea1e464b7adb'; 
$channelSecret = 'B5NOu/S/9mAhz6xvblcr+h5O/gMgVV8fjplOiXhrvordrjzY/kgumcaxzJVY1tYCkX8drOg7LKwQctkQHKIeHOW4JXoseurNSDkY2poqShv9jfr+1EGjZPm4WTx6bfMQ1oKR2azkS/nfbwK2gsfBRQdB04t89/1O/w1cDnyilFU=';
#-------------------------[Events]-------------------------#
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$userId     = $client->parseEvents()[0]['source']['userId'];
$groupId    = $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp  = $client->parseEvents()[0]['timestamp'];
$type       = $client->parseEvents()[0]['type'];
$message    = $client->parseEvents()[0]['message'];
$profile    = $client->profil($userId);
$repro = json_encode($profile);
$messageid  = $client->parseEvents()[0]['message']['id'];
$msg_type      = $client->parseEvents()[0]['message']['type'];
$msg_message   = $client->parseEvents()[0]['message']['text'];
$msg_title     = $client->parseEvents()[0]['message']['title'];
$msg_address   = $client->parseEvents()[0]['message']['address'];
$msg_latitude  = $client->parseEvents()[0]['message']['latitude'];
$msg_longitude = $client->parseEvents()[0]['message']['longitude'];


#----command option----#
$usertext = explode(" ", $message['text']);
$command = $usertext[0];
$options = $usertext[1];
if (count($usertext) > 2) {
    for ($i = 2; $i < count($usertext); $i++) {
        $options .= '+';
        $options .= $explode[$i];
    }
}

#------------------------------------------


$modex = file_get_contents('./user/' . $userId . 'mode.json');


if ($modex == 'Normal') {
    $uri = "https://script.google.com/macros/s/AKfycbyoFvKMBiUHO8Bqeg9zhd8rBm4UBvUecwTFICgXdcXithAqrII/exec"; 
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $results = array_filter($json['user'], function($user) use ($command) {
    return $user['id'] == $command;
    }
  );

$i=0;
$bb = array();
foreach($results as $resultsz){
$bb[$i] = $resultsz;
$i++;
}


$textz .= "กรุณาระบุชื่อที่ต้องการค้นหา";
$textz .= "\n";
$textz .= $bb['0']['name'];
$textz .= "\n";
$textz .= $bb['1']['name'];
$textz .= "\n";
$textz .= $bb['2']['name'];
$textz .= "\n";
$textz .= $bb['3']['name'];
$textz .= "\n";
$textz .= $bb['4']['name'];
    $mreply = array(
        'replyToken' => $replyToken,
        'messages' => array( 
          array(
                'type' => 'text',
                'text' => $textz
     )
     )
     );

$enbb = json_encode($bb);
    file_put_contents('./user/' . $userId . 'data.json', $enbb);
    file_put_contents('./user/' . $userId . 'mode.json', 'keyword');
}

elseif ($modex == 'keyword') {
    $urikey = file_get_contents('./user/' . $userId . 'data.json');
    $deckey = json_decode($urikey, true);

    $results = array_filter($deckey, function($user) use ($command) {
    return $user['name'] == $command;
    }
  );


$i=0;
$zaza = array();
foreach($results as $resultsz){
$zaza[$i] = $resultsz;
$i++;
}

$enzz = json_encode($zaza);
    file_put_contents('./user/' . $userId . 'data.json', $enzz);

$text .= "result";
$text .= "\n";
$text .= $zaza[0][id];
$text .= " - ";
$text .= $zaza[0][name];
$text .= " - ";
$text .= $zaza[0][num];
$text .= " - ";
$text .= $zaza[0][other];
    $mreply = array(
        'replyToken' => $replyToken,
        'messages' => array( 
          array(
                'type' => 'text',
                'text' => $text
     )
     )
     );

    file_put_contents('./user/' . $userId . 'mode.json', 'Normal');
}
else {
  file_put_contents('./user/' . $userId . 'mode.json', 'Normal');
}





if (isset($mreply)) {
    $result = json_encode($mreply);
    $client->replyMessage($mreply);
}  

?>