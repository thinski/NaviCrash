<html>
<head >
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="./css/test.css" />
	<link rel="stylesheet" type="text/css" href="./css/crashDefault.css" />
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" type="text/css">
	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/crashlog.js"></script>
  	<script type="text/javascript" src="./js/highcharts.js"></script>
 	<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>    
	<script type="text/javascript" src="js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>   

	<title> NaviCrash </title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>	
	<body>
<?php require_once ("./titlebar.html"); 
	if (isset($_POST['action']) && $_POST['action'] == 'submitted') {
		$start = $_POST['start'];
		$end = $_POST['end'];
	} else {
		$start = date('Y-m-d',time()-86400*9);
		$end = date('Y-m-d',time());
	}
	$start = date('Y-m-d',strtotime($start));
	$end = date('Y-m-d',strtotime($end));
?>

 <div class="container">
           <!--    <div class = "col-md-12"> -->
                    <table class = "table table-bordered">
                        <thead>
                            <tr style="background-color: #006699">
                                <th><font color="white">请选择时间段</font></th>
                                <th colspan="5" >
							<form action="navicrash.php" method="post">
                                    <div class="select_time" >
										<!--class="time"  -->
                                        <input style="text-align:left; float:left;width:100px;" type="text" value=<?php echo $start; ?> id="selectBeginTime" name="start" data-date-format="yyyy-mm-dd">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <script>
                                            $('#selectBeginTime').datetimepicker({
                                                format: 'yyyy-mm-dd',
                                                //startDate: document.getElementById("selectEndTime").value,   
                                                minView: 2
                                            });
                                        </script>
                                        <input style="text-align:left; float:left;width:100px;" type="text" value=<?php echo $end;  ?> id="selectEndTime" name="end" data-date-format="yyyy-mm-dd">
                                        <script>
                                            $('#selectEndTime').datetimepicker({
                                                format: 'yyyy-mm-dd',
                                                minView: 2
                                            });
                                        </script>
                                   	    <input type="hidden" name="action" value="submitted" />
                                       <input type="submit" class="btn btn-sm btn-warning" value="确定" />
                                    </div>
									
								</form>	
                                </th>

                            </tr>
                        </thead>
                    </table>
         <!--       </div>   -->
            </div>

<div id="crashtable" class="container">
<?php
	require_once './MySqlInterface.php';

	

	$cr = new CrashData();
	$msql = new MySqlInterface("localhost","root","");
	
	$sql = "select * from crashdata where os = 'android' and day >=" ."'" .$start."'"." and day<="."'".$end."'" . " order by day DESC ";
	
	$cr = $msql->getCrashData($sql);
	$num = count($cr->day);
	$value_date = "[";
	$crashrate = "[";
	echo "<table class=\"table table-bordered\">\n";
	echo "<tr><th>时间</th><th>导航crash数</th><th>地图crash数</th><th>导航crash占比</th><th>版本号</th></tr>";
	for($i=$num-1;$i>=0;$i--) {
		echo "<tr>";
		echo "<td>" . $cr->day[$i] . "</td>";
		echo "<td>" . $cr->mapnavi[$i] . "</td>";
		echo "<td>" . $cr->map[$i] . "</td>";
		echo "<td>" . sprintf("%.2f", $cr->rate[$i]*100) . "%" . "</td>";
		echo "<td>" . $cr->sv[$i] . "</td>";
		//echo "<td>" . $cr->os[$i] . "</td>";
		echo "</tr>\n";
		if($i !=  0) {
			$value_date = $value_date . "'" .date('Y-m-d',strtotime($cr->day[$i])). "'" .",";
		} else {
			$value_date = $value_date . "'" .date('Y-m-d',strtotime($cr->day[$i])) ."'"  . "]";
		}

		if($i !=  0) {
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