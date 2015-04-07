<html>
<head >
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="./css/test.css" />
	<script type="text/javascript" src="./js/jquery.min.js"></script>
  	<script type="text/javascript" src="./js/highcharts.js"></script>
 

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
	$value_date = "[";
	$crashrate = "[";
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
		if($i != $num - 1) {
			$value_date = $value_date . "'" .date('Y-m-d',strtotime($cr->day[$i])). "'" .",";
		} else {
			$value_date = $value_date . "'" .date('Y-m-d',strtotime($cr->day[$i])) ."'"  . "]";
		}

		if($i != $num - 1) {
			$crashrate = $crashrate . sprintf("%.2f", $cr->rate[$i]*100) . ",";
		} else {
			$crashrate = $crashrate . sprintf("%.2f", $cr->rate[$i]*100) . "]";
		}
	}
	echo "</table>\n";
?>
	</div>

	<script type="text/javascript" >

	$(function () { 
    $('#highcharts').highcharts({
        chart: {
            type: 'line'
        },
        title: {
        	style:{
						  fontSize: '18px',
						  fontWeight:"bold"
					},
            text: 'crash占比趋势(%)'
        },
        xAxis: {
            categories: <?php echo $value_date; ?>
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
            name: 'Android组件',
            data: <?php echo $crashrate; ?>
        }]
        
    });
});			
</script>

<div id="highcharts" class="container" >
	
</div>	
	</body>

</html>