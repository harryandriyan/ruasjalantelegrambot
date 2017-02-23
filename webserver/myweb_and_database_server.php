<?php
/*
this apps will handle request from your hook apps..
storing files pyhsically and recorded into database 
dont forget to set permisson at folder file


dont forget to create database and 
copy paste file sql into your database mysql server
remove file aql after you finish execute those sql files into your database server

file database sql located on folder sql

@Ruasjalanbot is bot to sharing latest traffic jam
you may upload pictures/photo , video or Voice through telegram,
the result will displayed on http://ruasjalan.com

Developed By Kukuh TW (kukuhtw.com)
kukuhtw@kukuhtw.com
kukuhtw@gmail.com
@kukuhtwbot http://telegram.me/kukuhtwbot

*/

include("db.php");
include("function.php");


//set telegram admin username here...
$ADMINUSERNAME="kukuhtw";
$URLDATABASERVER="http://yourweb-and-database-server-here.id/";
$YOURSECRETCODE="s920jmdkfj92183513d!"; // <--- this must be same with on your hook apps 

date_default_timezone_set("Asia/Jakarta");
$tanggalhariini = date("Y/m/d");
$SECRETKEYSERVER = md5($tanggalhariini.$YOURSECRETCODE)

$jamhariini = date("h:i:sa");
$saatini = $tanggalhariini. " Jam ".$jamhariini;
$ipaddress = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$username = isset($_POST['username']) ? $_POST['username'] : '';
$input = isset($_POST['input']) ? $_POST['input'] : '';
$browser = isset($_POST['browser']) ? $_POST['browser'] : '';
$postingid = isset($_POST['postingid']) ? $_POST['postingid'] : '';
$mode = isset($_POST['mode']) ? $_POST['mode'] : '';
$chatid = isset($_POST['chatid']) ? $_POST['chatid'] : '';
$picid = isset($_POST['picid']) ? $_POST['picid'] : '';

$originfile = isset($_POST['originfile']) ? $_POST['originfile'] : '';
$mime_type = isset($_POST['mime_type']) ? $_POST['mime_type'] : '';
$voice_file_size = isset($_POST['voice_file_size']) ? $_POST['voice_file_size'] : '';
$message_id = isset($_POST['message_id']) ? $_POST['message_id'] : '';
$text = isset($_POST['text']) ? $_POST['text'] : '';

$secretkeyfromhook = isset($_POST['secretkeyfromhook']) ? $_POST['secretkeyfromhook'] : '';
if ($secretkeyfromhook!=$SECRETKEYSERVER) {
	// if secret key doesn't macth.. don't let intruder apps sneak into your database server !!
	$pesan="Wrong Secret CODE !!!, sorry cant access my apps !";
	$sql = " select '$pesan' as pesan ";
	$pdo=new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
	$statement=$pdo->prepare($sql);
	$statement->execute();
	$results=$statement->fetchAll(PDO::FETCH_ASSOC);
	$json=json_encode($results);
	echo $datajson;
	exit;
}


//user should give or send caption images after they uploaded photo
if ($mode=="textcaption") {
	$getLastActivity = getLastActivity($username,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);	
	// captionpic_36
	$check_lastactivity_uploadphoto = substr($getLastActivity, 0, 11);
	
	if ($getLastActivity=="") {
		$pesan="";
		$sql = " select '$pesan' as pesan ";
		$pdo=new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
		$statement=$pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll(PDO::FETCH_ASSOC);
		$json=json_encode($results);
		echo $datajson;
		exit;
	}
	
	$ambilpicid = str_replace("captionpic_","",$getLastActivity);
	$ambilpicid=trim($ambilpicid);
	$content=$text;
	$datajson =  captionphoto($username,$ambilpicid,$content,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	echo $datajson;
	exit;
	
}

// if admin want to delete pic based on ID
if ($mode=="deletepic" && $username==$ADMINUSERNAME ) {
	$datajson = deletepic($picid,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword)	;
	echo $datajson;
	exit;
}


//handle task when user upload audio voice
if ($mode=="uploadvoice")
{
	checkuserexists($username,$saatini,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$namafile1 = $tanggalhariini;
	$namafile1 = str_replace("/","",$namafile1);
	$namafile2 = $jamhariini;
	$namafile2 = str_replace(":","",$namafile2);
	$namafile =  $namafile1.$namafile2;
	$randresultfile = rand(1111,9999);
	$path = "file/".$username. "-".$namafile."-".$randresultfile. ".oga";	
	// this one will copy file at telegram hosting file to your server
	downloadFile($originfile, $path);
	$targetfile=$URLDATABASERVER.$path;
	$content="";
	$datajson = addposting($username,$chatid,$message_id,$targetfile,$originfile,$content,$saatini,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	echo $datajson;
	exit;
	
}

//handle task when user upload audio video
if ($mode=="uploadvideo")
{
	checkuserexists($username,$saatini,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$namafile1 = $tanggalhariini;
	$namafile1 = str_replace("/","",$namafile1);
	$namafile2 = $jamhariini;
	$namafile2 = str_replace(":","",$namafile2);
	$namafile =  $namafile1.$namafile2;
	$randresultfile = rand(1111,9999);
	$extfile = substr($originfile, -3);  
	$path = "file/".$username. "-".$namafile."-".$randresultfile. ".".$extfile;	
	// this one will copy file at telegram hosting file to your server
	downloadFile($originfile, $path);
	$targetfile=$URLDATABASERVER.$path;
	$content="";
	$datajson = addposting($username,$chatid,$message_id,$targetfile,$originfile,$content,$saatini,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	echo $datajson;
	exit;
	
}

//handle task when user upload audio photo
if ($mode=="uploadPhoto")
{
	checkuserexists($username,$saatini,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$namafile1 = $tanggalhariini;
	$namafile1 = str_replace("/","",$namafile1);
	$namafile2 = $jamhariini;
	$namafile2 = str_replace(":","",$namafile2);
	$namafile =  $namafile1.$namafile2;
	$randresultfile = rand(1111,9999);
	$path = "file/".$username. "-".$namafile."-".$randresultfile. ".jpg";	
	// this one will copy file at telegram hosting file to your server
	downloadFile($originfile, $path);
	$targetfile=$URLDATABASERVER.$path;
	$content="";
	$datajson = addposting($username,$chatid,$message_id,$targetfile,$originfile,$content,$saatini,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	echo $datajson;
	exit;
	
}

// this one will copy file at telegram hosting file to your server
function downloadFile($url, $path)
{
    $newfname = $path;
    $file = fopen ($url, 'rb');
    if ($file) {
        $newf = fopen ($newfname, 'wb');
        if ($newf) {
            while(!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
            }
        }
    }
    if ($file) {
        fclose($file);
    }
    if ($newfname) {
        fclose($newf);
    }
}

?>