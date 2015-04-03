<html>
<head >
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="./css/test.css" />

	<title> NaviCrash </title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>	
	<body>
<?php require_once ("./titlebar.html"); ?>

<div id="crashtable" class="updatestyle">
<?php
	require_once './MySqlInterface.php';

	$cr = new CrashData();
	$msql = new MySqlInterface("localhost","root","");
	$sql = "select * from crashdata order by day";

	$cr = $msql->getCrashData($sql);
	$num = count($cr->day);
	echo "<table class=\"table table-hover\">\n";
	echo "<tr><th>时间</th><th>导航crash数</th><th>地图crash数</th><th>导航crash占比</th><th>版本号</th></tr>";
	for($i=0;$i<$num;$i++) {
		echo "<tr>";
		echo "<td>" . $cr->day[$i] . "</td>";
		echo "<td>" . $cr->mapnavi[$i] . "</td>";
		echo "<td>" . $cr->map[$i] . "</td>";
		echo "<td>" . sprintf("%.2f", $cr->rate[$i]*100) . "%" . "</td>";
		echo "<td>" . $cr->sv[$i] . "</td>";
		//echo "<td>" . $cr->os[$i] . "</td>";
		echo "</tr>\n";
	}
	echo "</table>\n";
?>
	</div>
	
	</body>

</html>