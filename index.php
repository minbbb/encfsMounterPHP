<?php
session_start();
?>
<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Encfs</title>
<style>
.umountForm{
	display: inline-block;
	margin-right: 15px;
}
.forms input[type="submit"]{
	width: 100%;
}
.mountList li{
	list-style-type: none;
}
.mountList{
	padding-left: 0px;
	white-space: nowrap;
}
</style>
</head>
<body>
<form method="POST" id="mount"></form>
<form method="POST" id="umount"></form>
<table class="forms">
	<tr>
		<td>Name of dir: </td>
		<td><input type="text" name="name" required form="mount"/></td>
	</tr>
	<tr>
		<td>Pass: </td>
		<td><input type="password" name="pass" required form="mount"/></td>
	</tr>
	<tr>
		<td>
			<input type="hidden" name="umountAll" value="on" form="umount"/>
			<input type="submit" value="all unmount" form="umount"/>
		</td>
		<td>
			<input type="submit" value="mount" form="mount"/>
		</td>
	</tr>		
</table>
<?php

$decryptDirs = "/var/www/example.com/public_html/DIR_WITH_THIS_SCRIPT/decrypt/";
$encryptDirs = array( //Name of dir's
    "first" => "/mnt/abc/encrypted/",
    "second" => "/path/to/encrypted/direction",
);

function randomString($length) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = random_int(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
if(!empty($_POST["pass"])){
	if(!array_key_exists($_POST["name"], $encryptDirs)){
		echo "Error while mounting";//Not found directory
	}else{
		$dirName = randomString(64);
		mkdir($decryptDirs.$dirName, 0700);
		shell_exec('echo "'.$_POST["pass"].'" | encfs -S '.$encryptDirs[$_POST["name"]].' '.$decryptDirs.$dirName);
		$checkMount = shell_exec('mount | grep "'.$decryptDirs.$dirName.'"');
		if(empty($checkMount)){
			rmdir($decryptDirs.$dirName);
			echo "Error while mounting";
		}else{
			$_SESSION['decryptDirs'][] = $dirName;
		}
	}
}
if($_POST["umountAll"] == 'on'){
	foreach($_SESSION['decryptDirs'] as $dir){
		shell_exec('fusermount -u '.$decryptDirs.$dir);
		rmdir($decryptDirs.$dir);
	}
	unset($_SESSION['decryptDirs']);
}
if(!empty($_POST["umount"])){
	foreach($_SESSION['decryptDirs'] as $key => $dir){
		if($dir == $_POST["umount"]){
			shell_exec('fusermount -u '.$decryptDirs.$dir);
			rmdir($decryptDirs.$dir);
			unset($_SESSION['decryptDirs'][$key]);
			break;
		}
	}
}
?>
<ul class="mountList">
<?php
if(!empty($_SESSION['decryptDirs'])){
	foreach($_SESSION['decryptDirs'] as $temp){
		echo '<li><form class="umountForm" method="POST"><input type="hidden" name="umount" value="'.$temp.'"/><input type="submit" value="x"/></form><a href="decrypt/'.$temp.'">'.$temp.'</a></li>';
	}
}
?>
</ul>
</body>
</html>