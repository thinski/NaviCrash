#!/bin/bash

#java -jar getCrash.jar

cat android_navi_crash.txt|while read line
do
	day=echo $line | awk -F '$' {print $1} 
	map=echo $line | awk -F '$' {print $2} 
	mapnavi=echo $line | awk -F '$' {print $3}
	rate=echo $line | awk -F '$' {print $4}  
	sv=echo $line | awk -F '$' {print $5} 
	os=echo $line | awk -F '$' {print $6} 
	echo $day $mapnavi
done 

mysql -u "test" -p "123456" navicrash <<EOF
INSERT INTO crashdata SET day=$day,map=$map,mapnavi=$mapnavi,rate=$rate,sv=$sv,os=$os;
EOF