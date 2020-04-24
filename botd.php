<?php
$access_token = 'LKS+MqpDhHmggUVeLPFpiwy1IAvxbhtl4PfGKneYaXfoLcqRNnyWd7Oro9pyK/drkX8drOg7LKwQctkQHKIeHOW4JXoseurNSDkY2poqShuPkxG8NX8f+FqfWU5Wrs6wx9TRQz5tjcp5t0CvXAQL7QdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
