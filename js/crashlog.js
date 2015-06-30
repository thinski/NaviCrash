/**
 * Created by apple on 7/2/14.
 */

function loadBrief() {
    var os = get_get('os');
    var appVersionList = document.getElementsByName('appversion');
    var selectedAppVersion = '';
    if(os == 1) {
        selectedAppVersion = navi_get_cookie('ios_app_version');
    }
    else if(parseInt(os) === 0) {
        selectedAppVersion = navi_get_cookie('android_app_version');
    }
    if(selectedAppVersion) {
        for(var i = 0; i < appVersionList.length; i++) {
            if(selectedAppVersion == appVersionList[i].value) {
                appVersionList[i].checked = true;
                break;
            }
        }
    }


}

function getDateCondiction(type,page){
    //获取 $_GET 参数
    var os = get_get('os');
    var reloadurl = '/hunter/api/crashlog/?datatype=reload&os=' + os;
    var beginTime = document.getElementById("selectBeginTime").value;
    var endTime = document.getElementById("selectEndTime").value;
    var os_version = getCheckedRadio('osversion');
    var app_version = getCheckedRadio('appversion');
    var mobile_type = getCheckedRadio('mobiletype');
    page = page !==undefined ? page : 1;
    if(type == 3) {
        reloadurl += '&begintime=' + (Date.parse(beginTime)/1000);
        reloadurl += '&endtime=' + (Date.parse(endTime)/1000);
        reloadurl += '&os_version=' + os_version;
        reloadurl += '&version=' + app_version;
        reloadurl += '&mobile_type=' + mobile_type;
        reloadurl += '&pageIndex=' + page;
        //alert(reloadurl);
        var request = new XMLHttpRequest();
        request.onreadystatechange=function()
        {

            if (request.readyState == 4 && request.status == 200)
            {
//                alert(reloadurl);
                getPageBrief();
                getCrashNoForData();
                var crashList = request.responseText;
                crashListA = eval('('+crashList+')');
                crashList =crashListA.list;
                var crashListlength = crashList.length;
                var sum = 0;
                for(var i = 0; i < crashListlength; i++) {
                    sum += parseInt(crashList[i]['SUM(count)']);
                }
                var content = '<div class="col-md-12"><table class="table table-bordered table-hover" style="margin-bottom:auto;">';
                content += '<thead><tr bgcolor="#000000"><th><font color="white">#</font></th><th><font color="white">Crash Key</font></th><th style="min-width: 65px"><font color="white">状�?</font></th><th style="min-width: 120px"><font color="white">处理�?</font></th><th><font color="white">Crash 次数</font></th><th><font color="white">类型百分�?</font></th><th><font color="white">操作</font></th></tr></thead>';
                content += '<tbody>';

                for(i = 0; i < crashListlength; i++) {
                    var url = "/hunter/archive/?os="+ os + "&crash_key=" + encodeURIComponent(crashList[i]['crash_key']) + "&app_version=" + app_version;
//                    alert(url);
                    //alert(crashList[i]['crash_key']);
                    //alert(url);
                    content += '<tr>';
                    content += '<td>' + (i+1) + '</td>';
                    content += '<td style="word-break:break-all">' + crashList[i]['crash_key'] + '</td>';

                    content += '<td style="word-break:break-all">' + crashList[i]['status'] + '</td>';
                    content += '<td style="word-break:break-all">' + crashList[i]['executor'] + '</td>';

                    content += '<td style="width:90px">' + crashList[i]['SUM(count)'] + '</td>';
                    content += '<td style="width:130px">' + ForDight(((crashList[i]['SUM(count)'])/sum)*100, 5) + '%' + '</td>';
                    content += '<td style="width:80px"><a href=' + url + '>查看详情</a></td>';
                    content += '</tr>';
                }
                content += '</tbody></table>';
                content += '<div style="text-align:center;"><ul class="pagination pagination-lg">'
                  +'<li><a href="javascript:getDateCondiction('+type+',1)">&laquo;</a></li>';
                   var pagePre   = 3;
                   var pageTail  = 2;
                   var pageCount = crashListA.pageCount;
                   pageStart = pageEnd = page;
                   var pageStart = (page - pagePre ) > 1 ? (page - pagePre ) : 1;
                   var pageEnd   = (page + pageTail) > pageCount ? pageCount : (page + pageTail);
                   if((pageEnd - pageStart) < (pagePre + pageTail)){
                        //补齐
                        while((pageEnd < pageCount) && (pageEnd - pageStart) < (pagePre + pageTail)){
                            pageEnd ++;
                        }
                        while((pageStart > 1) && (pageEnd - pageStart) < (pagePre + pageTail)){
                            pageStart --;
                        }
                   }
                   
                   for (i=pageStart ; i <= pageEnd ; i++){
                        if (i == page){
                            content += '<li class="active"><a href="javascript:getDateCondiction('+type+','+i+')">'+i+'</a></li>';
                        }else{
                            content += '<li ><a href="javascript:getDateCondiction('+type+','+i+')">'+i+'</a></li>';
                        }
                   }
                    
                    
                  
                  content +='<li><a href="javascript:getDateCondiction('+type+','+crashListA.pageCount+')">&raquo;</a></li>'
                            +'</ul></div></div>';
               
                document.getElementById("firstLoad").innerHTML = content;
            }
        }
        request.open("GET", reloadurl, true);
        request.send();
    }


    //查询全部的数�?
    else {
        var request = new XMLHttpRequest();
        request.onreadystatechange=function()
        {
            if (request.readyState == 4 && request.status == 200)
            {
                var crashList = request.responseText;
                crashListA = eval('('+crashList+')');
                crashList =crashListA.list;
                var crashListlength = crashList.length;
                var content = '<div class="col-md-12"><table class="table table-bordered table-hover">';
                content += '<thead><tr bgcolor="#000000"><th><font color="white">#</font></th><th><font color="white">Crash Key</font></th><th><font color="white">Crash 次数</font></th><th><font color="white">Crash �?</font></th><th><font color="white">操作</font></th></tr></thead>';
                content += '<tbody>';

                for(var i = 0; i < crashListlength; i++) {
                    var url = "/hunter/archive/?os="+ os + "&crash_key=" + encodeURIComponent(crashList[i]['crash_key']);
                    content += '<tr>';
                    content += '<td>' + (i+1) + '</td>';
                    content += '<td style="word-break:break-all">' + crashList[i]['crash_key'] + '</td>';
                    content += '<td style="width:90px">' + crashList[i]['SUM(count)'] + '</td>';
                    content += '<td style="width:80px">' + crashList[i]['SUM(count)'] + '</td>';
                    content += '<td style="width:80px"><a href=' + url + '>查看详情</a></td>';
                    content += '</tr>';
                }
                content += '</tbody></table></div>';
                content += '<ul class="pagination">'
                  +'<li><a href="#">&laquo;</a></li>'
                  +'<li><a href="#">1</a></li>'
                  +'<li><a href="#">2</a></li>'
                  +'<li><a href="#">3</a></li>'
                  +'<li><a href="#">4</a></li>'
                  +'<li><a href="#">5</a></li>'
                  +'<li><a href="#">&raquo;</a></li>'
                  +'</ul>';
                document.getElementById("firstLoad").innerHTML = content;
            }
        }
        request.open("GET", reloadurl, true);
        request.send();
    }
}

//获取 $_GET 参数函数
function get_get(param){
    querystr = window.location.href.split("?")

    if(querystr[1]){
        GETs = querystr[1].split("&");
        GET = new Array();
        for(i=0;i<GETs.length;i++){
            tmp_arr = GETs[i].split("=");
            key = tmp_arr[0];
            GET[key] = tmp_arr[1];
        }
    }
    return GET[param];
}

//保留有效数字的函�?
function ForDight(Dight,How){
    var result = Math.round(Dight*Math.pow(10,How))/Math.pow(10,How);
    return result;
}

//获取 radio 选择了的�?
function getCheckedRadio(name) {

    var checkedElement = null;
    var list = document.getElementsByName(name);
    for(var i = 0; i < list.length; i++) {
        if(list[i].checked) {
            checkedElement = list[i].value;
        }
    }

	if(checkedElement === "all") {
		checkedElement = null;
	}

    return checkedElement;
}

//获取起始和结束时间，计算时间区域，用于画图展�?
function getDateList() {

    var beginTime = document.getElementById("selectBeginTime").value;
    var endTime = document.getElementById("selectEndTime").value;
    var dateList = [];
    var i = 0;
    if(beginTime != endTime) {
        while(beginTime != endTime) {
            dateList[i++] = beginTime;
            beginTime = date('Y-m-d', Date.parse(beginTime)/1000 + 86400);
        }
        dateList[i] = beginTime;
    }
    else {
        dateList[0] = beginTime;
    }
    //alert(dateList);
    return dateList;
}


//画折线图的函�?
formChats = function(data){

    $(function () {
        $('#myChart').highcharts({
            title: {
                text: '',
                x: -20 //center
            },

            xAxis: {
                categories: getDateList()
            },
            yAxis: {
                title: {
                    text: '次数 (�?)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '�?'
            },
            series: [{
                name: 'Crash 次数',
                data: data
            }
                    /*
					{
						name: 'Crash 总数',
					    data: [1200,1200,1200,1200,1200,1200,1200,1200]
					}*/
			]
        });
    });
}



//获取时间区域，用于拉取对应时间的 crash 次数
function getCrashNoForData() {

    var dateList = getDateList();
    var os = get_get('os');
    var getCrashNoRUL = '/hunter/api/crashlog/?datatype=getCrashNoURL&os=' + os;
    getCrashNoRUL += '&begintime=' + (Date.parse(dateList[0])/1000);
    getCrashNoRUL += '&endtime=' + (Date.parse(dateList[dateList.length - 1])/1000);
    getCrashNoRUL += '&os_version=' + getCheckedRadio('osversion');
    getCrashNoRUL += '&version=' + getCheckedRadio('appversion');
    getCrashNoRUL += '&mobile_type=' + getCheckedRadio('mobiletype');
    //alert(getCrashNoRUL);
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            var crashNoList = request.responseText;
            crashNoList = eval(crashNoList);
            var dateList = getDateList();
            var data = [];
            var flag;
            for(var i = 0; i < dateList.length; i++) {
                flag = 1;
                for(var j = 0; j < crashNoList.length; j++) {
                    if(dateList[i] === date('Y-m-d', crashNoList[j]['date'])) {
                        data[i] = parseInt(crashNoList[j]['SUM(count)']);
                        flag = 0;
                        break;
                    }
                }
                if(flag) {
                    data[i] = 0;
                    flag = 0;
                }

            }
            //回调函数，在获取到数据的时候调用画折线图的函数
            formChats(data);
        }
    }
    request.open("GET", getCrashNoRUL, true);
    request.send();
}

//获取分页概要
function getPageBrief() {
    //获取 $_GET 参数

    var os = get_get('os');
    var pageBriefurl = '/hunter/api/crashlog/?datatype=pageBrief&pageIndex=0&os=' + os;
    var beginTime = document.getElementById("selectBeginTime").value;
    var endTime = document.getElementById("selectEndTime").value;
    var os_version = getCheckedRadio('osversion');
    var app_version = getCheckedRadio('appversion');

    pageBriefurl += '&begintime=' + (Date.parse(beginTime)/1000);
    pageBriefurl += '&endtime=' + (Date.parse(endTime)/1000);
    pageBriefurl += '&os_version=' + os_version;
    pageBriefurl += '&version=' + app_version;
    //alert(pageBriefurl);
    var request = new XMLHttpRequest();
    request.onreadystatechange=function()
    {

        if (request.readyState == 4 && request.status == 200)
        {
            var pageBrief = request.responseText;
            //pageBrief = eval(pageBrief);
            //alert(pageBrief);
            //当个数少于每一页的个数时，分页图标都不能点

        }
    }
    request.open("GET", pageBriefurl, true);
    request.send();
}








/**
 * @param  {string} format    格式
 * @param  {int}    timestamp 要格式化的时�? 默认为当前时�?
 * @brief  和PHP一样的时间戳格式化函数
 * @return {string} 格式化的时间字符�?
 */
function date(format, timestamp){
    var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date());
    var pad = function(n, c){
        if((n = n + "").length < c){
            return new Array(++c - n.length).join("0") + n;
        } else {
            return n;
        }
    };
    var txt_weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var txt_ordin = {1:"st", 2:"nd", 3:"rd", 21:"st", 22:"nd", 23:"rd", 31:"st"};
    var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var f = {
        // Day
        d: function(){return pad(f.j(), 2)},
        D: function(){return f.l().substr(0,3)},
        j: function(){return jsdate.getDate()},
        l: function(){return txt_weekdays[f.w()]},
        N: function(){return f.w() + 1},
        S: function(){return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th'},
        w: function(){return jsdate.getDay()},
        z: function(){return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0},

        // Week
        W: function(){
            var a = f.z(), b = 364 + f.L() - a;
            var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1;
            if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){
                return 1;
            } else{
                if(a <= 2 && nd >= 4 && a >= (6 - nd)){
                    nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31");
                    return date("W", Math.round(nd2.getTime()/1000));
                } else{
                    return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);
                }
            }
        },

        // Month
        F: function(){return txt_months[f.n()]},
        m: function(){return pad(f.n(), 2)},
        M: function(){return f.F().substr(0,3)},
        n: function(){return jsdate.getMonth() + 1},
        t: function(){
            var n;
            if( (n = jsdate.getMonth() + 1) == 2 ){
                return 28 + f.L();
            } else{
                if( n & 1 && n < 8 || !(n & 1) && n > 7 ){
                    return 31;
                } else{
                    return 30;
                }
            }
        },

        // Year
        L: function(){var y = f.Y();return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0},
        //o not supported yet
        Y: function(){return jsdate.getFullYear()},
        y: function(){return (jsdate.getFullYear() + "").slice(2)},

        // Time
        a: function(){return jsdate.getHours() > 11 ? "pm" : "am"},
        A: function(){return f.a().toUpperCase()},
        B: function(){
            // peter paul koch:
            var off = (jsdate.getTimezoneOffset() + 60)*60;
            var theSeconds = (jsdate.getHours() * 3600) + (jsdate.getMinutes() * 60) + jsdate.getSeconds() + off;
            var beat = Math.floor(theSeconds/86.4);
            if (beat > 1000) beat -= 1000;
            if (beat < 0) beat += 1000;
            if ((String(beat)).length == 1) beat = "00"+beat;
            if ((String(beat)).length == 2) beat = "0"+beat;
            return beat;
        },
        g: function(){return jsdate.getHours() % 12 || 12},
        G: function(){return jsdate.getHours()},
        h: function(){return pad(f.g(), 2)},
        H: function(){return pad(jsdate.getHours(), 2)},
        i: function(){return pad(jsdate.getMinutes(), 2)},
        s: function(){return pad(jsdate.getSeconds(), 2)},
        //u not supported yet

        // Timezone
        //e not supported yet
        //I not supported yet
        O: function(){
            var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4);
            if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t;
            return t;
        },
        P: function(){var O = f.O();return (O.substr(0, 3) + ":" + O.substr(3, 2))},
        //T not supported yet
        //Z not supported yet

        // Full Date/Time
        c: function(){return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P()},
        //r not supported yet
        U: function(){return Math.round(jsdate.getTime()/1000)}
    };

    return format.replace(/[\\]?([a-zA-Z])/g, function(t, s){
        if( t!=s ){
            // escaped
            ret = s;
        } else if( f[s] ){
            // a date function exists
            ret = f[s]();
        } else{
            // nothing special
            ret = s;
        }
        return ret;
    });
}
