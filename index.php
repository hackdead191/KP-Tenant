<?php

$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("text message");
$bot->replyMessage($event->getReplyToken(), $outputText);
