<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ruasjalan.com - Informasi Lalulintas terkini</title>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
	<meta property="og:title" content="RuasJalan.com" />
	<meta property="og:url" content="http://RuasJalan.com" />
	<meta property="og:image" content="http://RuasJalan.com/ruasjalanimage.jpg" />
	<meta property="og:description" content="TelegramBot @ruasjalanBot, Sharing Situasi Lalulintas menggunakan Video,Photo ataupun suara. " />
  
    <title>RuasJalan.com - Tempat Bertanya Informasi Lalulintas</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
   <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>
</head>
<body>


 <div class="container">
  <div class="jumbotron">
  <?php 
  
  //this is mycode adsense..you dont have to put ads here
  //include("ads320x100.php"); 
  
  ?>
        <h1>TelegramBot <a target="_new" href="http://telegram.me/ruasjalanBot">@ruasjalanBot</a></h1>
<p>RuasJalan.com adalah <a target="_new" href="http://telegram.me/ruasjalanBot">TelegramBot</a> 
Tempat berbagi update situasi lalu lintas terkini melalui Suara / Video ataupun Photo.
sharing photo cukup menggunakan telegrambot, buka apps telegram messenger,
lalu search @ruasjalanbot
</p>
<p>
</p>
<h3>Belum punya Apps Telegram Messenger ?</h3>
<h4><a target="_new" href="https://play.google.com/store/apps/details?id=org.telegram.messenger&hl=en">Versi Android Download disini</a></h4>
<h4><a target="_new" href="https://itunes.apple.com/en/app/telegram-messenger/id686449807?mt=8">Versi iOS Download disini</a></h4>
<h4><a target="_new" href="https://www.microsoft.com/en-us/store/apps/telegram-messenger/9wzdncrdzhs0">Versi Windows Phone Download disini</a></h4>
<p>Cara pengunaannya : Gunakan Apps Telegram Messenger , Add <a target="_new" href="http://telegram.me/ruasjalanBot">@ruasjalanbot</a> , kemudian ikuti instruksi yang tersedia</p>
<p>&nbsp;</p>
</div>

	  
<?php
include("db.php");
$sql = " select id,username, file_path_location	, content , saatini  ";
$sql .= " from postingruasjalanpic order by id desc limit 0,30 ";
$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$rt=0;
			$every3post=0;
			$data="";
			foreach($conn->query($sql) as $row) {
					$rt=$rt+1;
					$every3post=$every3post+1;					
					$id=$row['id'];
					$username=$row['username'];
					$file_path_location=$row['file_path_location'];
					$extfile = substr($file_path_location, -3);  
					$extfile=strtolower($extfile);
					$saatini=$row['saatini'];
					$keteranganwaktu = displaywaktu($saatini);
					$content=$row['content'];
					
					?>
		
<div class="col-xs-12">
	<h2><?php echo $rt ?>. Caption:<?php echo $content ?></h2>
	ID :<?php echo $id ?>
	<p>Upload oleh <?php echo $username ?> pada <?php echo $keteranganwaktu ?></p>
	
	<?php if ($extfile=="jpg") { ?>
	<p>Image : <img class="img-responsive" src="<?php echo $file_path_location ?>"></p>
	<?php } ?>

	<?php if ($extfile=="oga") { ?>
	 <audio controls>
    <source src="<?php echo $file_path_location ?>" type="audio/ogg">
	Your browser does not support the audio element.
	</audio> 
	<?php } ?>
	
	<?php if ($extfile=="mp4") { ?>
	 <video controls>
    <source src="<?php echo $file_path_location ?>" type="video/mp4">
	Your browser does not support the audio element.
	</video> 
	<?php } ?>
	
	<hr size="5">
	</div> <!-- end div row --> 

<?php
	if ($every3post==3) {
		$every3post=0;
		//this is mycode adsense..you dont have to put ads here
		//include("ads320x100.php");	
	}



 } // end looping
?>
  
  
<p>&nbsp;</p>
<center>RUASJALAN.COM</center>
</div> <!-- container-->
<p>&nbsp;</p>


<p>&nbsp;</p>

</body>
</html>
<?php
function displaywaktu($string) {
$tahun = substr($string,0,4);
$bulan = substr($string,5,2);
if ($bulan=="01") {
	$bulandesc="January";
}else if ($bulan=="02") {
	$bulandesc="February";
}else if ($bulan=="03") {
	$bulandesc="Maret";
}else if ($bulan=="04") {
	$bulandesc="April";
}else if ($bulan=="05") {
	$bulandesc="May";
}else if ($bulan=="06") {
	$bulandesc="Juni";
}else if ($bulan=="07") {
	$bulandesc="July";
}else if ($bulan=="08") {
	$bulandesc="Agustus";
}else if ($bulan=="09") {
	$bulandesc="September";
}else if ($bulan=="10") {
	$bulandesc="Oktober";
}else if ($bulan=="11") {
	$bulandesc="November";
}else if ($bulan=="12") {	
	$bulandesc="Desember";
}
/*
2016/10/13 Jam 06:32:21pm
*/
$tanggal = substr($string,8,2);
$jam = substr($string,15,2);
$menit = substr($string,18,2);
$detik = substr($string,21,2);
$ampm = substr($string,23,2);

if ($jam=="01" && $ampm=="am") {
		$ketwaktku="malam";
}
if ($jam=="02" && $ampm=="am") {
		$ketwaktku="malam";
}
if ($jam=="03" && $ampm=="am") {
		$ketwaktku="malam menjelang pagi";
}
if ($jam=="04" && $ampm=="am") {
		$ketwaktku="pagi buta";
}
if ($jam=="05" && $ampm=="am") {
		$ketwaktku="pagi";
}
if ($jam=="06" && $ampm=="am") {
		$ketwaktku="pagi";
}
if ($jam=="07" && $ampm=="am") {
		$ketwaktku="pagi";
}
if ($jam=="08" && $ampm=="am") {
		$ketwaktku="pagi";
}
if ($jam=="09" && $ampm=="am") {
		$ketwaktku="pagi menjelang siang";
}
if ($jam=="10" && $ampm=="am") {
		$ketwaktku="pagi menjelang siang";
}
if ($jam=="11" && $ampm=="am") {
		$ketwaktku="siang";
}
if ($jam=="12" && $ampm=="pm") {
		$ketwaktku="siang";
}
if ($jam=="01" && $ampm=="pm") {
		$ketwaktku="siang";
}
if ($jam=="02" && $ampm=="pm") {
		$ketwaktku="siang";
}
if ($jam=="03" && $ampm=="pm") {
		$ketwaktku="siang menjelang sore";
}
if ($jam=="04" && $ampm=="pm") {
		$ketwaktku="sore";
}
if ($jam=="05" && $ampm=="pm") {
		$ketwaktku="sore";
}
if ($jam=="06" && $ampm=="pm") {
		$ketwaktku="sore menjelang malam";
}
if ($jam=="07" && $ampm=="pm") {
		$ketwaktku="malam";
}
if ($jam=="08" && $ampm=="pm") {
		$ketwaktku="malam";
}
if ($jam=="09" && $ampm=="pm") {
		$ketwaktku="malam";
}
if ($jam=="10" && $ampm=="pm") {
		$ketwaktku="malam";
}
if ($jam=="11" && $ampm=="pm") {
		$ketwaktku="malam";
}
if ($jam=="12" && $ampm=="pm") {
		$ketwaktku="malam";
}

if ($jam=="05" && $ampm=="apache_child_terminate") {
		$ketwaktku="Pagi";
}
$full = $tanggal." ".$bulandesc." ".$tahun. " Jam ".$jam. ":".$menit.":".$detik. " ".$ketwaktku;
return $full;
}

?>