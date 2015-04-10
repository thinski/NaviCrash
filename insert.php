<html>
<head>
<title> 添加导航crash数据</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="./css/bootstrap.css" />
<body>
<?php require_once ("./titlebar.html");
require_once './MySqlInterface.php';
 ?>


<?php
	if (isset($_POST['action']) && $_POST['action'] == 'submitted') {
    	echo '<pre>';
 		update_data($_POST['day'],$_POST['navicrash'],$_POST['mapcrash'],$_POST['rate'],$_POST['sv'],$_POST['os']);
    print_r($_POST);
    echo '<a href="'. $_SERVER['PHP_SELF'] .'">继续添加</a>';
 
    echo '</pre>';
    } else {
?>

<div class="text-center">


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<p>时间：</p>
	<input type="text" name = "day" /> <br> <br>
	<p>导航crash数：</p>
	<input type="text" name = "navicrash"/> <br> <br>
	<p>地图总crash数：</p>
	<input type="text" name = "mapcrash" /> <br> <br>
	<p>导航crash占比（不要加%）：</p>
	<input type="text" name = "rate"/> <br> <br>
	<p>版本号：</p>
	<input type="text" name = "sv" /> <br> <br>
	<p>系统(android，ios)：</p>
	<input type="text" name = "os" />	 <br> <br>
	<input type="hidden" name="action" value="submitted" />
	<input  class="btn btn-default" type="submit" name="sumbit"	value="提交" />
</form>
</div>
<?php
}
?> 

<?php
	
	function update_data($day,$navicrash,$mapcrash,$rate,$sv,$os) {
		$msql = new MySqlInterface("localhost","root","");
		$sql="";
		if($os == "ios")
			$sql = "INSERT INTO iphonedata ( day, map, mapnavi, rate, sv, os) VALUES ("."'". $day ."'"."," .$mapcrash ."," .$navicrash ."," .$rate."," ."'". $sv. "'". "," ."'".$os."'".")";
		
		elseif ($os == "android") {
			
			$sql = "INSERT INTO crashdata ( day, map, mapnavi, rate, sv, os) VALUES ("."'". $day ."'"."," .$mapcrash ."," .$navicrash ."," .$rate."," ."'". $sv. "'". "," ."'".$os."'".")";
		}
		echo $sql ."\n";
		$msql->insertData($sql);
	}
	?>
</body>
</head>
</html>
