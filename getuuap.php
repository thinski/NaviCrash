<?php
$url="https://uuap.baidu.com/login?username=xiaofeng03&password=baidu%4003&rememberMe=on&_eventId=submit";
function access_url($url) {    
    if ($url=='') return false;    
    $fp = fopen($url, 'r') or exit('Open url faild!');    
    if($fp){  
    while(!feof($fp)) {    
        $file.=fgets($fp)."";  
    }  
    fclose($fp);    
    }  
    return $file;  
}  

//echo access_url($url);

function curl_url() {
$post_data = array();  
$post_data['username'] = "xiaofeng03";  
$post_data['password'] = "baidu%4003";  
$post_data['rememberMe'] = "on";  
$post_data['_eventId'] = "submit";  
$url="https://uuap.baidu.com/login";  
$o="";  
foreach ($post_data as $k=>$v)  
{  
    $o.= "$k=".urlencode($v)."&";  
}  
$post_data=substr($o,0,-1);  
$ch = curl_init();  
curl_setopt($ch, CURLOPT_POST, 1);  
curl_setopt($ch, CURLOPT_HEADER, 0);  
curl_setopt($ch, CURLOPT_URL,$url);  
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
//为了支持cookie  
//curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');  
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  
$result = curl_exec($ch);  
curl_close($ch);
return $result;
}

echo curl_url();
?>