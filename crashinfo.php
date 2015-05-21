<?php
require_once './MySqlInterface.php';
$os = $_GET['os'];
$daystart = $_GET['start'];
$dayend = $_GET['end'];
$del = $_GET['del'];
//echo " ---- ". $os ;
$cr = new CrashData();
	$msql = new MySqlInterface("localhost","root","");
	if($del == "true") {
		if($os == "android") {
			$sql = "delete from crashdata where day ="."'" .$daystart."'";
		}elseif ($os == "iphone") {
			$sql = "delete from iphonedata where day ="."'" .$daystart."'";
		}
		mysql_query($sql);
	}else {
		if($os == "android") {
			$sql = "select * from crashdata where day >="."'" .$daystart."'"." and day<="."'".$dayend."'";
		}elseif ($os == "iphone") {
			$sql = "select * from iphonedata where day >="."'" .$daystart."'"." and day<="."'".$dayend."'";
		}
		else {
			echo "os is error";
		}
		$cr = $msql->getCrashData($sql);
		echo (json_encode($cr));
	}



