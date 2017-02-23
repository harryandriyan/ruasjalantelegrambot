<?
function clear_variable_post_get($namevariablel)
{
	//actually not necessary to use mysql_real_escape_string if you have implemented PDO
	$namevariablel = mysql_real_escape_string($namevariablel);
	$namevariablel = addslashes($namevariablel);
	$namevariablel=strip_tags($namevariablel);
	$return = $namevariablel;
	return $return;
}

function clearlastactivity($username,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword)  {
	$sql = " update userruasjalanpic set currentactivity='' where username= '$username' ";
	$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec($sql);
	
}

function captionphoto($username,$picid,$content,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {
	$sql = " update  postingruasjalanpic set content = '$content' where id = '$picid' and username='$username' ";
	$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec($sql);
	clearlastactivity($username,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;
	$pesan = "Thanks for your caption :".$content. " Pic ID:".$picid;
	$sql = " select '$pesan' as pesan ";
	$pdo=new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
	$statement=$pdo->prepare($sql);
	$statement->execute();
	$results=$statement->fetchAll(PDO::FETCH_ASSOC);
	$json=json_encode($results);
	return $json;		
}

function getLastActivity($username,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {
	$sql = " select currentactivity from userruasjalanpic where username = '$username' ";
	$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$rt=0;
			$data="";
			foreach($conn->query($sql) as $row) {
					$rt=$rt+1;
					$currentactivity=$row['currentactivity'];
			}
	return $currentactivity;	
	
}

function checkuserexists($username,$regdate,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {
	$username = clear_variable_post_get($username);
	$sql = " select count(username) as total from userruasjalanpic where username='$username' ";
	$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$rt=0;
			foreach($conn->query($sql) as $row) {
					$rt=$rt+1;
					$total=$row['total'];
			}
	if ($total<=0) {
		$sql = " insert into userruasjalanpic (username,regdate) values ('$username','$regdate') ";
		try {
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = $sql ;
			$conn->exec($sql);
			$last_id = $conn->lastInsertId();
			//echo "<h2>New record created successfully. Last inserted ID is: " . $last_id."</h2>";
		}
		catch(PDOException $e)
		{

		}
	} // end if 
} // end function

function deletepic($id,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {
	
	$sql = " select file_path_location from postingruasjalanpic where id = '$id' ";
	$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$rt=0;
			$data="";
			foreach($conn->query($sql) as $row) {
					$rt=$rt+1;
					$file_path_location=$row['file_path_location'];
			}
	// PUT YOUR URL FILE HERE	
	$namafile = str_replace("http://your-database-server.id/file/","",$file_path_location);		
	$namafile = "file/" .$namafile;
    array_map( "unlink", glob( $namafile ) );
	
	$pesan = " gambar id : ".$id. " telah dihapus ! urlfile = ".$namafile;
	$sql = " delete from postingruasjalanpic where id = '$id' ";
	$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = $sql ;
	$conn->exec($sql);
	$sql = " select '$pesan' as pesan ";
	$pdo=new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
	$statement=$pdo->prepare($sql);
	$statement->execute();
	$results=$statement->fetchAll(PDO::FETCH_ASSOC);
	$json=json_encode($results);
	return $json;		
	
}

function addposting($username,$chatid,$messageId,$targetfile,$originfile,$content,$saatini,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = " insert into postingruasjalanpic ";
	$sql .= " (username,chatid,messageId,file_path_location,originfile,content,saatini) ";
	$sql .= " values ";
	$sql .= "('$username','$chatid','$messageId','$targetfile','$originfile','$content','$saatini') ";
	try {
		$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = $sql ;
		$conn->exec($sql);
		$last_id = $conn->lastInsertId();

		$pesan= $username. " SELAMAT !, Photo/Gambar/Suara sudah berhasil masuk di server ruasjalan.com dan @ruasjalanbot , Sekarang Berikan Caption/Deskripsi Photp/Video/Suara ini. " ;
		}
		catch(PDOException $e)
		{
			$pesan="maaf terjadi error ketika menyimpan data posting ".$username;
		}

		$sql = " update userruasjalanpic set currentactivity ='captionpic_$last_id' where username='$username' ";
		$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec($sql);
		
		
		$sql = " select '$pesan' as pesan , '$last_id' as last_id ";
		$pdo=new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
		$statement=$pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll(PDO::FETCH_ASSOC);
		$json=json_encode($results);
		return $json;
}
		
?>