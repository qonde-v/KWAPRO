//日期常量
var DATETIME={
	YYYYMMDD		:	'yyyy-mm-dd',
	YYYYMMDDHHMM	:	'yyyy-mm-dd hh:mm',
	YYYYMMDDHHMMSS	:	'yyyy-mm-dd hh:mm:ss'
};

function addZero(x) {
  return (x < 0 || x > 9 ? "" : "0") + x
}
function getValidStr(str) {
	str += "";
	if (str=="undefined" || str=="null" || str=="NaN")
		return "";
	else
		return str;
}

//get the date from clinet
function getNowDate(){
	var d = new Date();
	var curDateTime = d.getFullYear() +"-"
									+addZero(d.getMonth()+1)+"-"
									+addZero(d.getDate())
	return curDateTime;
}
//get the dateTime from clinet
function getNowTime(){
	var d = new Date();
	var curDateTime = d.getFullYear() +"-"
	+addZero(d.getMonth()+1)+"-"
	+addZero(d.getDate())+" "
	+addZero(d.getHours())+":"
	+addZero(d.getMinutes());
	return curDateTime;
}

//将日期时间转日期
function DateTimeToDate(dateTime){
	var tempInt=dateTime.indexOf(' ');
	var newDate=dateTime.substring(0,tempInt);
	return newDate;
}

//得到某年某月的最后一天
function getMonthEndDate(YYYY,   MM){   
      var d =new Date(YYYY, MM,0);   
      return d.getDate();
}

//get the time from clinet
function showNowTime(obj){
	var d = new Date();
	var curDateTime = d.getFullYear() +"-"
					+addZero(d.getMonth()+1)+"-"
					+addZero(d.getDate())+" "
					+addZero(d.getHours())+":"
					+addZero(d.getMinutes());
	if(getValidStr(obj.value)==""){
		obj.value=curDateTime;
	}
}

//日期对象转日期字符串
function dateToDateStr(dateObj){
	var d = dateObj;
	var dateStr = d.getFullYear() +"-"
					+addZero(d.getMonth()+1)+"-"
					+addZero(d.getDate())+" "
					+addZero(d.getHours())+":"
					+addZero(d.getMinutes());
	
	return dateStr;
}

//get the date from clinet
function showNowDate(obj){
	var d = new Date();
	var curDateTime = d.getFullYear() +"-"
									+addZero(d.getMonth()+1)+"-"
									+addZero(d.getDate())
	if(getValidStr(obj.value)==""){
		obj.value=curDateTime;
	}
}

//get the month from clinet
function showNowMonth(obj){
	var d = new Date();
	var curDateTime = d.getFullYear() +"-"
									+addZero(d.getMonth()+1);
	if(getValidStr(obj.value)==""){
		obj.value=curDateTime;
	}
}

//get the year from clinet
function showNowYear(obj){
	var d = new Date();
	var curDateTime = d.getFullYear() ;
	if(getValidStr(obj.value)==""){
		obj.value=curDateTime;
	}
}

//时间运算 dataObj 日期对象 isFlag ('true'为向历史运算,'false'为向未来运算) number 为毫秒数
function operationDate(dateObj,isFlag,number){
	var timeNumber;
	if(isFlag=='true'){
		timeNumber=(Date.parse(dateObj)-number);
	}else{
		timeNumber=(Date.parse(dateObj)+number);
	}
	var newDateObj=new Date();
	newDateObj.setTime(timeNumber);
	return newDateObj;
}

 //验证短日期，形如 (2003-12-05) 
function strCheckDate(str){ 
    var r = str.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/); 
    if(r==null)return false; 
    var d= new Date(r[1], r[3]-1, r[4]); 
    return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]); 
} 
 //长时间，形如 (2003-12-05 13:04) 
function strCheckTime(str){
    var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2})$/; 
    var r = str.match(reg); 
    if(r==null)return false; 
    var d= new Date(r[1], r[3]-1,r[4],r[5],r[6]);
	return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]&&d.getHours()==r[5]&&d.getMinutes()==r[6]);

}

//时间验证 dataStr 时间字符串 parameter 为验证哪种时间格式
function validate_Date(dateStr,parameter){
	var flag=false;
	parameter=parameter.toLowerCase();
	switch(parameter){
		case DATETIME.YYYYMMDD :
			flag=strCheckDate(dateStr);
			break;
		case DATETIME.YYYYMMDDHHMM :
			flag=strCheckTime(dateStr);
			break;
		default :
			flag=false;
			break;
	}
	
	return flag;
}

//格式化时间串
function formatDateTime(strDateTime,dataformat,timeformat){
	var selTime = false;
	//是否显示时间
	if(timeformat==null || timeformat=='undefined' || timeformat==''){
		selTime=false;
	}else{
		selTime=true;
	}
		
	if(strFormat == 'yyyy-mm-dd HH:MM'){
		
	}
}

//得到此日期所在当前年的当前星期
function getWeekDay(d){
	var weekdays = new Array("日","一","二","三","四","五","六");
	return weekdays[d.getDay()];
}

//时间字符转化为Date类型(兼容两种时间字符格式，长时间和短时间)
function dateStrConversionDate(longDateStr){
	var date;
	var cut_Begin = new Array();
	longDateStr=new String(longDateStr);
	
	var longFlag=null;
	if(longDateStr.length==10)
		longFlag=false;
	
	if(longDateStr.length==16)
		longFlag=true;
	
	if(longDateStr.length!=0 && longFlag==null){
		alert("errConversionDate!");
		return false;
	}

	if(longFlag){
		var dbs=longDateStr.split(" ");
		var dbd=dbs[0];
		var dbt=dbs[1];
		var list = dbd.split("-");
		cut_Begin[0]=list[0];
		cut_Begin[1]=list[1]-1;
		cut_Begin[2]=list[2];
		list = dbt.split(":");
		cut_Begin[3]=list[0];
		cut_Begin[4]=list[1];
		
		date=new Date(cut_Begin[0],cut_Begin[1],cut_Begin[2],cut_Begin[3],cut_Begin[4]);
	}else{
		var dbd=longDateStr.split("-");
		var list=dbd;
		cut_Begin[0]=list[0];
		cut_Begin[1]=list[1]-1;
		cut_Begin[2]=list[2];
		date=new Date(cut_Begin[0],cut_Begin[1],cut_Begin[2]);
	}
	return date;
}
//将DWR和一般的js日期对象转换成 "yyyy-MM-dd hh:mm" 格式字符串
function coral_transferTime(obj){
	if(obj!=null && obj!=""){
		var theTime = obj.getFullYear() +"-"
				+addZero(obj.getMonth()+1)+"-"
				+addZero(obj.getDate())+" "
				+addZero(obj.getHours())+":"
				+addZero(obj.getMinutes());

		return	theTime;
	}
	return "";
}


/**
 * 判断第一个日期是否大于第二个日期,如果大于,弹出传递的信息,
 * startName：第一个日期对应的文本框Id
 * endName ： 第二个日期对应的文本框Id
 * message ：提示信息
 */
function coral_startAndEndTime(startName,endName,message){
	var startTime=document.getElementById(startName);
	var endTime=document.getElementById(endName);
	var startTimeValue=dateStrConversionDate(startTime.value);
	var endTimeValue=dateStrConversionDate(endTime.value);
	if(endTimeValue<startTimeValue){
		alert(message);
		startTime.focus();
		return false;
	}
	return true;
}
