<html>
<head>
<title> 更新导航cookie</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="./css/bootstrap.css" />
<body>
<?php require_once ("./titlebar.html"); ?>
<?php
	if (isset($_POST['action']) && $_POST['action'] == 'submitted') {
    	echo '<pre>';
 		update_file($_POST['tag'],$_POST['content']);
    print_r($_POST);
    echo '<a href="'. $_SERVER['PHP_SELF'] .'">继续更新</a>';
 
    echo '</pre>';
    } else {
?>

<div class="text-center">


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	请选择要更新的内容：<br>
	<br>
	<select name="tag" > 
		<option value="getCrash"> 抓取指定日期数据 </option>
		<option value="NaviCookie"> 导航Cookie  </option>
		<option value="MapCookie">  地图Cookie   </option>
		<option value="LastestSV">  最新Android版本号 </option>
		<option value="iPhoneSV">  最新iOS版本号 </option>
	</select>	<br> <br>
	<textarea  rows="10" name = "content" ></textarea>
	<br>
	<input type="hidden" name="action" value="submitted" />
	<input  class="btn btn-default" type="submit" name="sumbit"	value="提交" />
</form>
</div>




<?php
}
?> 
<?php
	function update_file($tag, $content) {
		if ($tag == "NaviCookie")
			$filename = "NaviCookie.txt";
		elseif ($tag == "MapCookie") {
			$filename = "MapCookie.txt";
		}
		elseif ($tag == "LastestSV")
			$filename = "LastestSV.txt";
		elseif ($tag == "iPhoneSV")
			$filename = "IOSSV.txt";
		elseif ($tag == "getCrash"){
			get_crash($content);
			return;
		}else {
			$filename = "log.txt";
			echo "error tag";
		}
			

		$file = fopen($filename,"w");
		fwrite($file, $content);
		echo "write to file";
		fclose($file);
	}
	function get_crash($content) {
		echo "get crash data ". $content ."\n";
		$cmd = "sh run.sh " . $content;
		passthru($cmd);
	}
	?>
</body>
</head>
</html>
