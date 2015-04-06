<html>
<head >
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="./css/test.css" />
	<script type="text/javascript" src="./js/jquery.min.js"></script>
  	<script type="text/javascript" src="./js/highcharts.js"></script>
 <script type="text/javascript" >

	$(function () { 
    $('#highcharts').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'crash占比趋势'
        },
        xAxis: {
            categories: ['my', 'first', 'chart']
        },
        yAxis: {
            title: {
                text: 'crash占比'
            }
        },
        credits: {
        	enabled : false
        },
        
        series: [{
            name: '时间',
            data: [1, 0, 4]
        }]
        
    });
});			
</script>

	<title> NaviCrash </title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>	
	<body>
<?php require_once ("./titlebar.html"); ?>

<div id="crashtable" class="container">
<?php
	require_once './MySqlInterface.php';

	$cr = new CrashData();
	$msql = new MySqlInterface("localhost","root","");
	$sql = "select * from crashdata order by day";

	$cr = $msql->getCrashData($sql);
	$num = count($cr->day);
	echo "<table class=\"table table-bordered\">\n";
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
	<div id="highcharts" class="container" >
		
</div>	
	</body>

</html>