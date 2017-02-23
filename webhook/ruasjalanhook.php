<?php
/*
@Ruasjalanbot is bot to sharing latest traffic jam
you may upload pictures/photo , video or Voice through telegram,
the result will displayed on http://ruasjalan.com

Developed By Kukuh TW (kukuhtw.com)
kukuhtw@kukuhtw.com
kukuhtw@gmail.com
@kukuhtwbot http://telegram.me/kukuhtwbot

I am using Telegrambot sdk here
https://github.com/irazasyed/telegram-bot-sdk

I am using 2 apps here
One will act role as webhook (Telegram will forward users request to here)
the other ones will act role as database server (this apps will store/save images/video/audio uploaded by user)

1. Webhook - Apps that connect telegram Api
set weeb hook by doing this
https://api.telegram.org/botYOURTOKENHERE/setwebhook?url=https://yourhosted-weebhook-hosting-server.com/yourapp/ruasjalanhook.php

2. Webserver - Apps that will connect your hook apss to your database server

Demo:
1. open your telegram messenger, add @ruasjalanbot, upload pictures
2. see result at ruasjalan.com

*/

//clone or download SDK telegram here https://github.com/irazasyed/telegram-bot-sdk
include("vendor/autoload.php");
	
$API_KEY = 'YOURTOKENHERE:YOURTOKENHERE';
$BOT_NAME = 'ruasjalanBot';
$URL="https://api.telegram.org/bot".$API_KEY;
$URLDATABASERVER="http://yourweb-and-database-server-here.id/myweb_and_database_server.php";
$YOURSECRETCODE="s920jmdkfj92183513d!"; // <--- this must be same with on your web database server

date_default_timezone_set("Asia/Jakarta");
$tanggalhariini = date("Y/m/d");
$secretkeyfromhook  = md5($tanggalhariini.$YOURSECRETCODE);

// this is for maintaining file, admin can delete content not suitable
$ADMINUSERNAME="kukuhtw";

use Telegram\Bot\Api;
$telegram = new Api($API_KEY);
$response = $telegram->setWebhook(['url' => 'https://yourhosted-weebhook-hosting-server.com/yourapp/ruasjalanhook.php']);
	
$update = file_get_contents("php://input");
$updatearray = json_decode($update, TRUE);
$length = count($updatearray["result"]);
$username = $updatearray["message"]["chat"]["username"];
$chatid = $updatearray["message"]["chat"]["id"];
$message_id = $updatearray["message"]["message_id"];
$text = $updatearray["message"]["text"];
$text=strtolower($text);


$keyboard = [
    ['About', 'How To Use']
];
$reply_markup = $telegram->replyKeyboardMarkup([
	'keyboard' => $keyboard, 
	'resize_keyboard' => true, 
	'one_time_keyboard' => true
]);
$response = $telegram->sendMessage([
	'chat_id' => $chatid, 
	'text' => ' pilih menunya ', 
	'reply_markup' => $reply_markup
]);
$messageId = $response->getMessageId();

if ($text=="about") {
	$response = "@".$BOT_NAME." is a bot to sharing information about latest traffic. ";
	$response .= " You can upload pictures or video, and the results ";
	$response .= " will appeared on RuasJalan.com"; 
	file_get_contents($URL."/sendmessage?chat_id=$chatid&text=$response");
}

if ($text=="how to use") {
	$response = " click icon paperclick attachment below this. ";
	$response .= " select pictures or video and clik send. ";
	$response .= " thats it.. very simple isnt it ?"; 
	file_get_contents($URL."/sendmessage?chat_id=$chatid&text=$response");
}



if ($username=="") {
	$username = "".$updatearray["message"]["chat"]["id"]."";

}

$countdata = count($updatearray['message']["photo"]);
if ($countdata>=1) {
	$countdata=$countdata-1;
}

$photo_file_id = $updatearray["message"]["photo"][$countdata]["file_id"];
$file_size = $updatearray["message"]["photo"][$countdata]["file_size"];
$width = $updatearray["message"]["photo"][$countdata]["width"];
$height = $updatearray["message"]["photo"][$countdata]["height"];
$message_id = $updatearray["message"]["message_id"];

//document
$document_id = $updatearray["message"]["document"]["file_id"];
$mime_type = $updatearray["message"]["document"]["mime_type"];

//voice
$voice_mime_type = $updatearray["message"]["voice"]["mime_type"];
$voice_file_id = $updatearray["message"]["voice"]["file_id"];
$voice_file_size = $updatearray["message"]["voice"]["file_size"];

//video
$video_file_id = $updatearray["message"]["video"]["file_id"];

	//$response = " %0A %0A Server Trouble !! MessageID : ".$message_id;
	//$response .= " %0A %0A video_file_id : ".$video_file_id;
	//file_get_contents($URL."/sendmessage?chat_id=$chatid&text=$response");
	//exit;
	
	
if ($document_id!="" && $mime_type !="image/jpeg" ) {
	$response = "sorry , we detected this file as a not pic or photos, send your pic as a photo not as a file";
	$response = $response. " %0A %0A Sorry, Bot can't process this file , you should send a photo not a file. get your photo from camera devices ";
	file_get_contents($URL."/sendmessage?chat_id=".$chatid."&reply_to_message_id=$message_id&text=$response");
	exit;
}			

if ($document_id!="" && $mime_type =="image/jpeg" ) {
	$photo_file_id = $document_id;
}			

// if user upload video 
if ($video_file_id!="") {
	
	$response = " one moment please, your video is currently uploading .......... ";
	file_get_contents($URL."/sendmessage?chat_id=".$chatid."&reply_to_message_id=$message_id&text=$response");
	
	$fields = array(
	'file_id' => $video_file_id,
	'secretkeyfromhook' => $secretkeyfromhook
	);

	$fields_string="";
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	$URLGETFILE = $URL. "/getFile";
	$ch=curl_init($URLGETFILE);
	//echo "<br>urlch = ".$ch;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	$content = curl_exec($ch);
	$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
	curl_close($ch);
	$json = json_decode($content, true);
	
	$file_path = $json['result']['file_path'];

	$originfile = "https://api.telegram.org/file/bot".$API_KEY."/".$file_path;
	
	
	// sekarang upload ke server hosting sharepic di botchatid.com/
			
	$mode="uploadvideo";
	$fields = array(
	'username' => $username,
	'mode' => $mode,
	'message_id' => $message_id,
	'chatid' => $chatid,
	'originfile' => $originfile,
	'secretkeyfromhook' => $secretkeyfromhook,
		);
	
	$fields_string="";
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	$ch=curl_init($URLDATABASERVER);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	$content = curl_exec($ch);
	$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
	curl_close($ch);
	$json = json_decode($content, true);
	
	$pesan_dari_server = $json[0]['pesan'];
	$last_id = $json[0]['last_id'];
	
	$response = $pesan_dari_server;
	file_get_contents($URL."/sendmessage?chat_id=$chatid&text=$response");
	exit;

}


// if user upload audio
if ($voice_mime_type=="audio/ogg") {

	$response = " one moment please, your voice is currently uploading .......... ";
	file_get_contents($URL."/sendmessage?chat_id=".$chatid."&reply_to_message_id=$message_id&text=$response");

	$fields = array(
			'file_id' => $voice_file_id,
			'message_id' => $message_id,
			'secretkeyfromhook' => $secretkeyfromhook
			);

			$fields_string="";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');
			$URLGETFILE = $URL. "/getFile";
			$ch=curl_init($URLGETFILE);
			//echo "<br>urlch = ".$ch;
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			$content = curl_exec($ch);
			$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
			curl_close($ch);
			$json = json_decode($content, true);
		
			$file_path = $json['result']['file_path'];
			$originfile = "https://api.telegram.org/file/bot".$API_KEY."/".$file_path;
			
			$mode="uploadvoice";
			$fields = array(
			'username' => $username,
			'mode' => $mode,
			'chatid' => $chatid,
			'mime_type' => $voice_mime_type,
			'message_id' => $message_id,
			'voice_file_size' => $voice_file_size,
			'originfile' => $originfile
			);
	
			$fields_string="";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');
			$ch=curl_init($URLDATABASERVER);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			$content = curl_exec($ch);
			$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
			curl_close($ch);
			$json = json_decode($content, true);
	
			$pesan_dari_server = $json[0]['pesan'];
			$taskid_pesan_dari_server = $json[0]['taskid'];
			$response = $pesan_dari_server;
			file_get_contents($URL."/sendmessage?chat_id=".$chatid."&text=$response");		
}

//bila terjadi upload photo type photo
if ($photo_file_id!="") {
	
	$response = " one moment please, your photo is currently uploading .......... ";
	file_get_contents($URL."/sendmessage?chat_id=".$chatid."&reply_to_message_id=$message_id&text=$response");
		
	$fields = array(
	'file_id' => $photo_file_id,
	'secretkeyfromhook' => $secretkeyfromhook
	);

	$fields_string="";
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	$URLGETFILE = $URL. "/getFile";
	$ch=curl_init($URLGETFILE);
	//echo "<br>urlch = ".$ch;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	$content = curl_exec($ch);
	$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
	curl_close($ch);
	$json = json_decode($content, true);
	

	$file_path = $json['result']['file_path'];
	
	$originfile = "https://api.telegram.org/file/bot".$API_KEY."/".$file_path;
	
	
	// sekarang upload ke server hosting sharepic di botchatid.com/
			
	$mode="uploadPhoto";
	$fields = array(
	'username' => $username,
	'mode' => $mode,
	'message_id' => $message_id,
	'chatid' => $chatid,
	'originfile' => $originfile,
	'secretkeyfromhook' => $secretkeyfromhook
		);
	
	$fields_string="";
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	$ch=curl_init($URLDATABASERVER);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	$content = curl_exec($ch);
	$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
	curl_close($ch);
	$json = json_decode($content, true);
	
	$pesan_dari_server = $json[0]['pesan'];
	$last_id = $json[0]['last_id'];
	
	$response = $telegram->sendPhoto([
	'chat_id' => $chatid, 
	'photo' => $originfile,
	'caption' => $pesan_dari_server. " "
	]);
	$messageId = $response->getMessageId();
	exit;
	
	
} // end if photo_file_id!=""

if ($text!="") {
	$mode="textcaption";
	$fields = array(
	'username' => $username,
	'mode' => $mode,
	'message_id' => $message_id,
	'text' => $text,
	'chatid' => $chatid
	);
	

	$fields_string="";
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	$ch=curl_init($URLDATABASERVER);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	$content = curl_exec($ch);
	$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
	curl_close($ch);
	$json = json_decode($content, true);
	
	$pesan_dari_server = $json[0]['pesan'];
	$response = " %0A %0A Ads : http://kumpulblogger.com - PPC Lokal AdNetwork";
	file_get_contents($URL."/sendmessage?chat_id=$chatid&text=$response");	

}

// this is feature only for admin
// /deleteid_
$check_isdelete = substr($text, 0, 10);
if ($check_isdelete=="/deleteid_" && $username==$ADMINUSERNAME ) {
	$picid = str_replace("/deleteid_","",$text);
	$picid=trim($picid);

	//$response .= " %0A %0A picid : ".$picid;
	//file_get_contents($URL."/sendmessage?chat_id=$chatid&text=$response");
	
	$mode="deletepic";
	$fields = array(
	'username' => $username,
	'mode' => $mode,
	'message_id' => $message_id,
	'picid' => $picid,
	'chatid' => $chatid,
	'secretkeyfromhook' => $secretkeyfromhook
	);
	
	$fields_string="";
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	$ch=curl_init($URLDATABASERVER);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	$content = curl_exec($ch);
	$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
	curl_close($ch);
	$json = json_decode($content, true);
	$pesan_dari_server = $json[0]['pesan'];		
	$response = " %0A ".$pesan_dari_server;
	file_get_contents($URL."/sendmessage?chat_id=".$chatid."&text=$response");		
	// ============== END POST ===============
	exit;
}


?>
	