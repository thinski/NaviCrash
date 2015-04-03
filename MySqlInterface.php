<?php
	require_once('./CrashData.php');
class MySqlInterface {
	
	var $password="";
	function MySqlInterface($host,$user,$password) {
		//连接mysql数据库 
			//$con=mysql_connect("localhost", "test", "123456");
			$con=mysql_connect($host,$user,$password);
			if(!$con)
			  {
				die('Could not connect: ' . mysql_error());
			  }
			  
			//选择数据库 
			$db_selected = mysql_select_db("navicrash", $con);

			if(!$db_selected)
			  {
				die ("Can\'t use test_db : " . mysql_error());
			  }
	}

	function getCrashData($sql) {

		mysql_real_escape_string($sql);
			
		$result = mysql_query($sql);

		$cr = new CrashData();
		while ($row = mysql_fetch_array($result)) {
			$cr->day[] = $row['day'];
			$cr->map[] = $row['map'];
			$cr->mapnavi[] = $row['mapnavi'];
			$cr->rate[] = $row['rate'];
			$cr->sv[] = $row['sv'];
			$cr->os[] = $row['os'];

			

		}
		return $cr;
	}
}