


function DoImport()
{
	 
	 var fileObj = document.getElementById("importFile");
	 if(fileObj)
	 {
		 if(fileObj.value)
		 {
		   SwitchVisiable(false);
		   var url = "CopeWithImportData.php?fileName="+fileObj.value;
		   SendRequest(url);
		   //window.location.href = url;
		 }
		 else
		 {
			  alert("当前没有选择导入的文件,请重新选择.");
		 }
	 }
	 
}


function createXMLHttpRequest()
{
     var g_XMLHttpReq = null;
     if(window.XMLHttpRequest) 
      { //Mozilla 浏览器 
                 g_XMLHttpReq = new XMLHttpRequest(); 
      }else
      { // IE浏览器 
        /*try 
        { 
            g_XMLHttpReq = new ActiveXObject("Msxml2.XMLHTTP"); 
        } 
        catch (e) 
        { 
              try 
              { 
                    g_XMLHttpReq = new ActiveXObject("Microsoft.XMLHTTP"); 
              } 
              catch (e) 
              {
              } 
        } 
     }//else*/
            g_XMLHttpReq=new ActiveXObject("Microsoft.XMLHTTP");
    }   
    return g_XMLHttpReq;
}
/////////
function SendRequest(url)
{
    if(!g_XMLHttpReq)
    {
        createXMLHttpRequest();
    }
    g_XMLHttpReq.open("GET",url);
    g_XMLHttpReq.onreadystatechange = ChangeImportStat();
    g_XMLHttpReq.send(null);
}

function ChangeImportStat()
{
   if(g_XMLHttpReq.readyState == 4)
   {
       if(g_XMLHttpReq.status == 200)
       {
          SwitchVisiable(true);
       }  
   }
   else
   {
	  // SwitchVisiable(false);
   }
}

function SwitchVisiable(imported)
{//debugger;
	  var infoObj =  document.getElementById("Imported");
	  if(infoObj)
	  {
		  infoObj.style.display = imported? "inline":"none";
	  }
	  var info1Obj =  document.getElementById("Importing");
	  if(info1Obj)
	  {
		  info1Obj.style.display = imported? "none":"inline";
	  }
}

///////////////////////for query condition area set//////////////////////////
var g_CurArea = "";

function ConditionVisible(obj)
{
	NoDisplayArea(g_CurArea);
	var colVal = obj.value;
	var area = GetDisplayArea(colVal);
	
	if(area)
	{
		 g_CurArea = area;
		 var curObj = document.getElementById(area);
		 curObj.style.display = "inline";
	}
}

function NoDisplayArea(areaId)
{
	if(areaId)
	{
		 var Obj = document.getElementById(areaId);
		 Obj.style.display = "none";
    }
	else
	{
		 var Obj = document.getElementById("timeSet");
		 Obj.style.display = "none";
		 var Obj1 = document.getElementById("animalSet");
		 Obj1.style.display = "none";
		// var Obj2 = document.getElementById("typeSet");
		 //Obj2.style.display = "none";
	}
}

function GetDisplayArea(colName)
{
	 if((colName == "receptDate")||(colName == "entryInspectionDate"))
	 {
		 return "timeSet";
	 }
	 if(colName == "animalNo")
	 {
		 return "animalSet";
	 }
	 if(colName == "typeId")
	 {
		 return "typeSet";
	 }
	 return "";
	 
}

function DataCheck(colName)
{
	if((colName == "entryInspectionDate")||(colName == "receptDate"))
	{
		//todo:
		var tStart = document.getElementById("timeStart").value;
		var tEnd   = document.getElementById("timeEnd").value;
		
		if(!DateMatch(tStart)||!DateMatch(tEnd))
		{
			return false;
		}
		
		if((tStart > tEnd)&&(tStart != "")&&(tEnd != ""))
		{
			alert("开始日期大于结束日期,请重新输入日期范围.");
			return false;
		}
		
	}
	if(colName == "animalNo")
	{
		//todo:
		var minVal = document.getElementById("minVal").value;
		var maxVal = document.getElementById("maxVal").value;
		if((parseInt(minVal) > parseInt(maxVal))&&(minVal != "")&&(maxVal != ""))
		{
			alert("最小值大于最大值,请重新输入.");
			return false;
		}
	}
	if(colName == "typeId")
	{
		//todo:
		var num = 0;
		var retStr = "";
		var arr = ["pig","bull","sheep"];
		
		for(var i=0; i<arr.length; i++)
		{
			if(document.getElementById(arr[i]).checked == true)
			{
				num++;
			}
		}
		if(num == 0)
		{
			alert("请选择运送对象的类型.");
			return false;
		}
		
	}
	return true;
}

function GetQueryStrByCol(colName)
{
	if((colName == "issueDate")||(colName == "entryInspectionDate"))
	{
		//todo:
		var tStart = document.getElementById("timeStart").value;
		var tEnd   = document.getElementById("timeEnd").value;
		
		return tStart + "_" + tEnd;

	}
	if(colName == "animalNo")
	{
		//todo:
		var minVal = document.getElementById("minVal").value;
		var maxVal   = document.getElementById("maxVal").value;
		
		return minVal + "_" + maxVal;
	}
	if(colName == "typeId")
	{
		//todo:
		var retStr = "";
		var arr = ["pig","bull","sheep"];
		
		for(var i=0; i<arr.length; i++)
		{
			if(document.getElementById(arr[i]).checked == true)
			{
				retStr = retStr + i + "_"; 
			}
		}
		return retStr;
		
	}
	////case other colname
	return document.getElementById("queryKeyWord").value;
}

function DoQuery()
{
  // alert("hello");
  // window.location.reload();
   var colObj = document.getElementById("curColumn");
   //alert(window.location.href);
   href=GetHref();   
   if(colObj)
   {
	   if(DataCheck(colObj.value))
	   {
	     var queryStr = GetQueryStrByCol(colObj.value);
             if(queryStr=="_"||queryStr==""){
               alert('请添写完整查寻信息'); 
             return ;
              }    
            //alert(queryStr);
           window.location.href = href+"search/search_concrete_info/"+colObj.value+"/"+queryStr;
	   }
	   else
	   {
		    return ;
	   }
   }
}
///////
function DateMatch(dateStr)
{
   if(dateStr == "")
   {
	   return true;
   }
   var arr = [];
   arr = dateStr.split("-");
   if(arr.length == 3)
   {
	   if((parseInt(arr[1]) < 13)&&(DateMatchMonth(arr[1],arr[2])))
	   {
		   return true;
	   }
   }
   alert("当前输入的日期格式有误,请重新输入.");
   return false;
}

function DateMatchMonth(month,day)
{
	var monthLast = ["31","28","31","30","31","30","31","31","30","31","30","31"];
	
	if(day > monthLast[month-1])
	{
		return false;
	}
	return true;
}

function seeItem(serial_no){
  //alert($serial_no);
  //window.location.href="/getDetailedInfo/"+$serial_no;
  href=GetHref();
  //alert(href);
  window.open (href+"admin_search/getDetailedInfo/"+serial_no,'newwindow','height=600,width=1000,top=10,left=10,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,   location=no,status=no');
}

// return http://localhost/porkdata/
function GetHref(){
  href=window.location.href+"";
  var hrefArray=href.substring(7,href.length).split("/");
  href="http://"+hrefArray[0]+ "/"+hrefArray[1]+"/";
  return href;
}


function searchInfoCheck(){
     //alert("hello");
     var searchInfo="";
     if(document.getElementById("companyName").value!=""){
       searchInfo+="companyName@"+document.getElementById("companyNameSelect").value+"@"+document.getElementById("companyName").value+"@";
     }
     if(document.getElementById("animalInspectionCertificateNo").value!=""){
       searchInfo+="animalInspectionCertificateNo@"+document.getElementById("animalInspectionCertificateNoSelect").value+"@"+document.getElementById("animalInspectionCertificateNo").value+"@";
     }
     if(document.getElementById("truckLicenseNo").value!=""){
       searchInfo+="truckLicenseNo@"+document.getElementById("truckLicenseNoSelect").value+"@"+document.getElementById("truckLicenseNo").value+"@";
     }
      if(document.getElementById("animalNo").value!=""){
       searchInfo+="sumAnimalNo@"+document.getElementById("animalNoSelect").value+"@"+document.getElementById("animalNo").value+"@";
     }
      if(document.getElementById("stationName").value!=""){
       searchInfo+="stationName@"+document.getElementById("stationNameSelect").value+"@"+document.getElementById("stationName").value+"@";
     }
     if(document.getElementById("receiptNum").value!=""){
       searchInfo+="sumReceiptNum@"+document.getElementById("receiptNumSelect").value+"@"+document.getElementById("receiptNum").value+"@";
     }
     if(document.getElementById("sourceAreaCountyName").value!=""){
       searchInfo+="sourceAreaCountyName@"+document.getElementById("sourceAreaCountyNameSelect").value+"@"+document.getElementById      ("sourceAreaCountyName").value+"@";
     }
      if(document.getElementById("sourceAreaTownName").value!=""){
       searchInfo+="sourceAreaTownName@"+document.getElementById("sourceAreaTownNameSelect").value+"@"+document.getElementById      ("sourceAreaTownName").value+"@";
     }
      if(document.getElementById("destinationName").value!=""){
       searchInfo+="destinationName@"+document.getElementById("destinationNameSelect").value+"@"+document.getElementById      ("destinationName").value+"@";
     }
      if(document.getElementById("cardSerialNo").value!=""){
       searchInfo+="cardSerialNo@"+document.getElementById("cardSerialNoSelect").value+"@"+document.getElementById      ("cardSerialNo").value+"@";
     }
	if(document.getElementById("provinceName").value!=""){
		searchInfo+="provinceName@"+document.getElementById("provinceNameSelect").value+"@"+document.getElementById      ("provinceName").value+"@";
	}
	if(document.getElementById("cityName").value!=""){
		searchInfo+="cityName@"+document.getElementById("cityNameSelect").value+"@"+document.getElementById      ("cityName").value+"@";
	}
     var inspectStart=document.getElementById("entryInspectionDateStart").value;
     var inspectEnd=document.getElementById("entryInspectionDateEnd").value;
     var href=GetHref();
     if((inspectStart!="")&&(inspectEnd!="")){
       if(!checkInputDate(inspectStart,inspectEnd))
       {
         // alert("开始日期大于结束日期,请重新输入日期范围.");
          return;
       }
      searchInfo+="entryInspectionDate@"+document.getElementById("entryInspectionDateSelect").value+"@"+inspectStart+"_"+inspectEnd+"@";
     } 
     var receiptStart=document.getElementById("receiptDateStart").value;
     var receiptEnd=document.getElementById("receiptDateEnd").value;
     if((receiptStart!="")&&(receiptEnd!="")){
        if(!checkInputDate(receiptStart,receiptEnd))
       {
         // alert("开始日期大于结束日期,请重新输入日期范围.");
          return;
       }
       searchInfo+="receiptDate@"+document.getElementById("receiptDateSelect").value+"@"+receiptStart+"_"+receiptEnd+"@";
     }
     if(searchInfo==""){
      alert("请输入查询信息");
      return; 
     }
     window.location.href=href+"admin_search/search_concrete_info/"+searchInfo;
}
 
function recordSearchInfoCheck(){
       var searchInfo="";
       if(document.getElementById("animalInspectionCertificateNo").value!=""){
       searchInfo+="animalInspectionCertificateNo@"+document.getElementById("animalInspectionCertificateNoSelect").value+"@"+document.getElementById    ("animalInspectionCertificateNo").value+"@";
     }
  if(document.getElementById("stationName").value!=""){
       searchInfo+="stationName@"+document.getElementById("stationNameSelect").value+"@"+document.getElementById("stationName").value+"@";
     }
 if(document.getElementById("truckLicenseNo").value!=""){
       searchInfo+="truckLicenseNo@"+document.getElementById("truckLicenseNoSelect").value+"@"+document.getElementById("truckLicenseNo").value+"@";
     }
 if(document.getElementById("receiptNum").value!=""){
       searchInfo+="sumReceiptNum@"+document.getElementById("receiptNumSelect").value+"@"+document.getElementById("receiptNum").value+"@";
     }
 if(document.getElementById("animalNo").value!=""){
       searchInfo+="sumAnimalNo@"+document.getElementById("animalNoSelect").value+"@"+document.getElementById("animalNo").value+"@";
     }
   if(document.getElementById("destinationName").value!=""){
       searchInfo+="destinationName@"+document.getElementById("destinationNameSelect").value+"@"+document.getElementById      ("destinationName").value+"@";
     }
      if(document.getElementById("cardSerialNo").value!=""){

       searchInfo+="cardSerialNo@"+document.getElementById("cardSerialNoSelect").value+"@"+document.getElementById      ("cardSerialNo").value+"@";
     }
 var inspectStart=document.getElementById("entryInspectionDateStart").value;
     var inspectEnd=document.getElementById("entryInspectionDateEnd").value;
     var href=GetHref();
     if((inspectStart!="")&&(inspectEnd!="")){
       if(!checkInputDate(inspectStart,inspectEnd))
       {
         // alert("开始日期大于结束日期,请重新输入日期范围.");
          return;
       }
       searchInfo+="entryInspectionDate@"+document.getElementById("entryInspectionDateSelect").value+"@"+inspectStart+"_"+inspectEnd+"@";
     } 
     var receiptStart=document.getElementById("receiptDateStart").value;
     var receiptEnd=document.getElementById("receiptDateEnd").value;
     if((receiptStart!="")&&(receiptEnd!="")){
       if(!checkInputDate(receiptStart,receiptEnd))
       {
         // alert("开始日期大于结束日期,请重新输入日期范围.");
          return;
       }
       searchInfo+="receiptDate@"+document.getElementById("receiptDateSelect").value+"@"+receiptStart+"_"+receiptEnd+"@";
     }
     if(searchInfo==""){
      alert("请输入查询信息");
      return; 
     }
     window.location.href=href+"record_search/search_concrete_info/"+searchInfo;
}

function receiptSearchInfoCheck(){
       var searchInfo="";
       if(document.getElementById("companyName").value!=""){
       searchInfo+="companyName@"+document.getElementById("companyNameSelect").value+"@"+document.getElementById("companyName").value+"@";
     }
       if(document.getElementById("sourceAreaCountyName").value!=""){
       searchInfo+="sourceAreaCountyName@"+document.getElementById("sourceAreaCountyNameSelect").value+"@"+document.getElementById      ("sourceAreaCountyName").value+"@";
     }
      if(document.getElementById("sourceAreaTownName").value!=""){
       searchInfo+="sourceAreaTownName@"+document.getElementById("sourceAreaTownNameSelect").value+"@"+document.getElementById      ("sourceAreaTownName").value+"@";
     }
       if(document.getElementById("animalInspectionCertificateNo").value!=""){
       searchInfo+="animalInspectionCertificateNo@"+document.getElementById("animalInspectionCertificateNoSelect").value+"@"+document.getElementById    ("animalInspectionCertificateNo").value+"@";
     }
 if(document.getElementById("truckLicenseNo").value!=""){
       searchInfo+="truckLicenseNo@"+document.getElementById("truckLicenseNoSelect").value+"@"+document.getElementById("truckLicenseNo").value+"@";
     }
 if(document.getElementById("animalNo").value!=""){
       searchInfo+="sumAnimalNo@"+document.getElementById("animalNoSelect").value+"@"+document.getElementById("animalNo").value+"@";
     }
    if(document.getElementById("receiptNum").value!=""){
       searchInfo+="sumReceiptNum@"+document.getElementById("receiptNumSelect").value+"@"+document.getElementById("receiptNum").value+"@";
     }
    if(document.getElementById("destinationName").value!=""){
       searchInfo+="destinationName@"+document.getElementById("destinationNameSelect").value+"@"+document.getElementById      ("destinationName").value+"@";
     }
     if(document.getElementById("cardSerialNo").value!=""){
       searchInfo+="cardSerialNo@"+document.getElementById("cardSerialNoSelect").value+"@"+document.getElementById      ("cardSerialNo").value+"@";
     }
 var inspectStart=document.getElementById("entryInspectionDateStart").value;
     var inspectEnd=document.getElementById("entryInspectionDateEnd").value;
     var href=GetHref();
     if((inspectStart!="")&&(inspectEnd!="")){
         if(!checkInputDate(inspectStart,inspectEnd))
       {
         // alert("开始日期大于结束日期,请重新输入日期范围.");
          return;
       }
       searchInfo+="entryInspectionDate@"+document.getElementById("entryInspectionDateSelect").value+"@"+inspectStart+"_"+inspectEnd+"@";
     } 
     var receiptStart=document.getElementById("receiptDateStart").value;
     var receiptEnd=document.getElementById("receiptDateEnd").value;
     if((receiptStart!="")&&(receiptEnd!="")){
       if(!checkInputDate(receiptStart,receiptEnd))
       {
         // alert("开始日期大于结束日期,请重新输入日期范围.");
          return;
       }
       searchInfo+="receiptDate@"+document.getElementById("receiptDateSelect").value+"@"+receiptStart+"_"+receiptEnd+"@";
     }
     if(searchInfo==""){
      alert("请输入查询信息");
      return; 
     }
     window.location.href=href+"receipt_search/search_concrete_info/"+searchInfo;
}

function DialogsearchCheck(seachpage){
     //alert("hello");
     var searchInfo="";
      if($( "#companyName" ).val()!="" && typeof($("#companyName" ).val())!="undefined") {
       searchInfo+="companyName@like@"+$( "#companyName" ).val()+"@";
     }
      if($( "#animalInspectionCertificateNo" ).val()!="" && typeof($("#animalInspectionCertificateNo" ).val())!="undefined") {
       searchInfo+="animalInspectionCertificateNo@like@"+$( "#animalInspectionCertificateNo" ).val()+"@";
     }
       if($( "#truckLicenseNo" ).val()!="" && typeof($("#truckLicenseNo" ).val())!="undefined") {
       searchInfo+="truckLicenseNo@like@"+$( "#truckLicenseNo" ).val()+"@";
       }
       if($( "#animalNo" ).val()!="" && typeof($("#animalNo" ).val())!="undefined") {
       searchInfo+="sumAnimalNo@"+$( "#animalNoSelect" ).val()+"@"+$( "#animalNo" ).val()+"@";
       }
       if($( "#stationName" ).val()!="" && typeof($("#stationName" ).val())!="undefined") {
       searchInfo+="truckLicenseNo@like@"+$( "#stationName" ).val()+"@";
       }
       if($( "#receiptNum" ).val()!="" && typeof($("#receiptNum" ).val())!="undefined") {
       searchInfo+="sumReceiptNum@"+$( "#receiptNoSelect" ).val()+"@"+$( "#receiptNum" ).val()+"@";
       }
       if($( "#sourceAreaCountyName" ).val()!="" && typeof($("#sourceAreaCountyName" ).val())!="undefined") {
       searchInfo+="sourceAreaCountyName@like@"+$( "#sourceAreaCountyName" ).val()+"@";
       }
       if($( "#sourceAreaTownName" ).val()!="" && typeof($("#sourceAreaTownName" ).val())!="undefined") {
       searchInfo+="sourceAreaTownName@like@"+$( "#sourceAreaTownName" ).val()+"@";
       }
       if($( "#destinationName" ).val()!="" && typeof($("#destinationName" ).val())!="undefined") {
       searchInfo+="destinationName@like@"+$( "#destinationName" ).val()+"@";
       }
      if($( "#cardSerialNo" ).val()!="" && typeof($("#cardSerialNo" ).val())!="undefined") {
       searchInfo+="cardSerialNo@like@"+$( "#cardSerialNo" ).val()+"@";
     }
       if($( "#provinceName" ).val()!="" && typeof($("#provinceName" ).val())!="undefined") {
       searchInfo+="provinceName@like@"+$( "#provinceName" ).val()+"@";
       }
       if($( "#cityName" ).val()!="" && typeof($("#cityName" ).val())!="undefined") {
       searchInfo+="cityName@like@"+$( "#cityName" ).val()+"@";
       }
     var inspectStart=$( "#entryInspectionDateStart" ).val();
     var inspectEnd=$( "#entryInspectionDateEnd" ).val();
     var href=GetHref();
     if((inspectStart!="")&&(inspectEnd!="") && typeof($("#entryInspectionDateStart" ).val())!="undefined" && typeof($("#entryInspectionDateEnd" ).val())!="undefined" ) {
      searchInfo+="entryInspectionDate@&lt&gt@"+inspectStart+"_"+inspectEnd+"@";
     } 
     var receiptStart=$( "#receiptDateStart" ).val();
     var receiptEnd=$( "#receiptDateEnd" ).val();
     if((receiptStart!="")&&(receiptEnd!="") && typeof($("#receiptDateStart" ).val())!="undefined" && typeof($("#receiptDateEnd" ).val())!="undefined") {
       searchInfo+="receiptDate@&lt&gt@"+receiptStart+"_"+receiptEnd+"@";
     }
     if(searchInfo==""){
      alert("");
      return; 
     }
     window.location.href=href+seachpage+"/search_concrete_info/"+searchInfo;
}


function SortData(obj){
    // var sortCol=obj.name;
     var upOrDown='';
     var idName='data';
     var colName=obj.title;
     var url=window.location.href;
    // alert(url);
     var xmlhttp;
    // alert(obj.title);
    //alert(obj.name);
     var colTable=document.getElementById('columnName');
     for(var i=0;i<colTable.rows[0].cells.length;i++)
     {
     colTable.rows[0].cells[i].style.backgroundColor='#E8E8E8';
     }
     if(obj.value==0){ 
        upOrDown='down';
        obj.value=1;
        obj.style.backgroundColor = '#FF1493';
     }else{
        upOrDown='up';
        obj.value=0; 
        obj.style.backgroundColor = '#00BFFF';
     }
    //obj.abbr=upOrDown;
    // alert(upOrDown);
    // alert(obj.value);
    //alert(window.location.href)
    var tempUrl=url.substring(7,url.length).split('/');
    if(url==(GetHref()+"admin_search")){
      url+="/index/"+colName+"@"+upOrDown+"/1";
      //alert(url);
    }else if("http://"+tempUrl[0]+"/"+tempUrl[1]+"/"+tempUrl[2]==(GetHref()+"admin_search"))
    {
      url+="/"+colName+"@"+upOrDown+"/1";
    }else{ 
      url+="&sort_info="+colName+"@"+upOrDown+"&change_page=1";
     // alert(url);
    }
    //alert(url);
    xmlhttp=createXMLHttpRequest();
    //alert(xmlhttp);
    xmlhttp.open("GET",url,true);
    xmlhttp.onreadystatechange = function(){
      if(xmlhttp.readyState==4&&xmlhttp.status==200){
    document.getElementById("infoDisplay").innerHTML=xmlhttp.responseText;
     }
    }
    xmlhttp.send();
}

function hiddenOrViewSearchPanel(){
  //alert("hello");
  var curObj = document.getElementById("searchPanel");
  if(curObj.style.display == "inline"){
  curObj.style.display = "none";
  document.getElementById("hiddenOrViewSearchButton").value="展开查询栏";
  }else{
  curObj.style.display = "inline";
 document.getElementById("hiddenOrViewSearchButton").value="收起查询栏";
  }
}

function checkInputDate(startDate,endDate){
    //alert("hello");
    var stdt=new Date(startDate.replace("-","/"));
    var etdt=new Date(endDate.replace("-","/"));
    if(stdt>etdt){ 
     alert("开始时间必须小于结束时间")
     return false; 
    }else{
     return true;
    }
}

function showStatisticLabelButton(){
    var statisticsLabelButton=document.getElementById('statisticLabel');
    var statisticsCompanyLabelButton=document.getElementById('companyStatisticLabel');
    if(statisticsLabelButton!=null){
       statisticsLabelButton.style.display="inline";
    }
    if(statisticsCompanyLabelButton!=null){
       statisticsCompanyLabelButton.style.display="inline";
    }
    $("#entryInspectionDateStart").css("width","15%");
    $("#entryInspectionDateEnd").css("width","15%");
}

function showStatisticLabel(){
     var inspectStart=document.getElementById("entryInspectionDateStart").value;
     var inspectEnd=document.getElementById("entryInspectionDateEnd").value;
     var href=GetHref();
     if((inspectStart!="")&&(inspectEnd!="")){
       if(!checkInputDate(inspectStart,inspectEnd))
       {
          //alert("开始日期大于结束日期,请重新输入日期范围.");
          return;
       }
     window.open(href+"admin_search/statistics_label/"+inspectStart+"/"+inspectEnd);
  }
}

function showCompanyStatisticLabel(){
     var inspectStart=document.getElementById("entryInspectionDateStart").value;
     var inspectEnd=document.getElementById("entryInspectionDateEnd").value;
     var href=GetHref();
     if((inspectStart!="")&&(inspectEnd!="")){
       if(!checkInputDate(inspectStart,inspectEnd))
       {
          //alert("开始日期大于结束日期,请重新输入日期范围.");
          return;
       }
    window.open(href+"admin_search/statistics_comapny_label/"+inspectStart+"/"+inspectEnd);
  }
}

//Down search results 
function DoDownloadSearchResults(){
     var href=GetHref();
     window.location.href=href+"admin_search/convert_data_excel";
}
//date information
function HS_DateAdd(interval,number,date){
	number = parseInt(number);
	if (typeof(date)=="string"){var date = new Date(date.split("-")[0],date.split("-")[1],date.split("-")[2])}
	if (typeof(date)=="object"){var date = date}
	switch(interval){
	case "y":return new Date(date.getFullYear()+number,date.getMonth(),date.getDate()); break;
	case "m":return new Date(date.getFullYear(),date.getMonth()+number,checkDate(date.getFullYear(),date.getMonth()+number,date.getDate())); break;
	case "d":return new Date(date.getFullYear(),date.getMonth(),date.getDate()+number); break;
	case "w":return new Date(date.getFullYear(),date.getMonth(),7*number+date.getDate()); break;
	}
}
function checkDate(year,month,date){
	var enddate = ["31","28","31","30","31","30","31","31","30","31","30","31"];
	var returnDate = "";
	if (year%4==0){enddate[1]="29"}
	if (date>enddate[month]){returnDate = enddate[month]}else{returnDate = date}
	return returnDate;
}

function WeekDay(date){
	var theDate;
	if (typeof(date)=="string"){theDate = new Date(date.split("-")[0],date.split("-")[1],date.split("-")[2]);}
	if (typeof(date)=="object"){theDate = date}
	return theDate.getDay();
}
function HS_calender(){
	var lis = "";
	var style = "";
	style +="<style type='text/css'>";
	style +=".calender { width:170px; height:auto; font-size:12px; margin-right:14px; background:url(calenderbg.gif) no-repeat right center #fff; border:1px solid #397EAE; padding:1px}";
	style +=".calender ul {list-style-type:none; margin:0; padding:0;}";
	style +=".calender .day { background-color:#EDF5FF; height:20px;}";
	style +=".calender .day li,.calender .date li{ float:left; width:14%; height:20px; line-height:20px; text-align:center}";
	style +=".calender li a { text-decoration:none; font-family:Tahoma; font-size:11px; color:#333}";
	style +=".calender li a:hover { color:#f30; text-decoration:underline}";
	style +=".calender li a.hasArticle {font-weight:bold; color:#f60 !important}";
	style +=".lastMonthDate, .nextMonthDate {color:#bbb;font-size:11px}";
	style +=".selectThisYear a, .selectThisMonth a{text-decoration:none; margin:0 2px; color:#000; font-weight:bold}";
	style +=".calender .LastMonth, .calender .NextMonth{ text-decoration:none; color:#000; font-size:18px; font-weight:bold; line-height:16px;}";
	style +=".calender .LastMonth { float:left;}";
	style +=".calender .NextMonth { float:right;}";
	style +=".calenderBody {clear:both}";
	style +=".calenderTitle {text-align:center;height:20px; line-height:20px; clear:both}";
	style +=".today { background-color:#ffffaa;border:1px solid #f60; padding:2px}";
	style +=".today a { color:#f30; }";
	style +=".calenderBottom {clear:both; border-top:1px solid #ddd; padding: 3px 0; text-align:left}";
	style +=".calenderBottom a {text-decoration:none; margin:2px !important; font-weight:bold; color:#000}";
	style +=".calenderBottom a.closeCalender{float:right}";
	style +=".closeCalenderBox {float:right; border:1px solid #000; background:#fff; font-size:9px; width:11px; height:11px; line-height:11px; text-align:center;overflow:hidden; font-weight:normal !important}";
	style +="</style>";

	var now;
	if (typeof(arguments[0])=="string"){
		selectDate = arguments[0].split("-");
		var year = selectDate[0];
		var month = parseInt(selectDate[1])-1+"";
		var date = selectDate[2];
		now = new Date(year,month,date);
	}else if (typeof(arguments[0])=="object"){
		now = arguments[0];
	}
	var lastMonthEndDate = HS_DateAdd("d","-1",now.getFullYear()+"-"+now.getMonth()+"-01").getDate();
	var lastMonthDate = WeekDay(now.getFullYear()+"-"+now.getMonth()+"-01");
	var thisMonthLastDate = HS_DateAdd("d","-1",now.getFullYear()+"-"+(parseInt(now.getMonth())+1).toString()+"-01");
	var thisMonthEndDate = thisMonthLastDate.getDate();
	var thisMonthEndDay = thisMonthLastDate.getDay();
	var todayObj = new Date();
	today = todayObj.getFullYear()+"-"+todayObj.getMonth()+"-"+todayObj.getDate();
	
	for (i=0; i<lastMonthDate; i++){  // Last Month's Date
		lis = "<li class='lastMonthDate'>"+lastMonthEndDate+"</li>" + lis;
		lastMonthEndDate--;
	}
	for (i=1; i<=thisMonthEndDate; i++){ // Current Month's Date

		if(today == now.getFullYear()+"-"+now.getMonth()+"-"+i){
			var todayString = now.getFullYear()+"-"+(parseInt(now.getMonth())+1).toString()+"-"+i;
			lis += "<li><a href=javascript:void(0) class='today' onclick='_selectThisDay(this)' title='"+now.getFullYear()+"-"+(parseInt(now.getMonth())+1)+"-"+i+"'>"+i+"</a></li>";
		}else{
			lis += "<li><a href=javascript:void(0) onclick='_selectThisDay(this)' title='"+now.getFullYear()+"-"+(parseInt(now.getMonth())+1)+"-"+i+"'>"+i+"</a></li>";
		}
		
	}
	var j=1;
	for (i=thisMonthEndDay; i<6; i++){  // Next Month's Date
		lis += "<li class='nextMonthDate'>"+j+"</li>";
		j++;
	}
	lis += style;

	var CalenderTitle = "<a href='javascript:void(0)' class='NextMonth' onclick=HS_calender(HS_DateAdd('m',1,'"+now.getFullYear()+"-"+now.getMonth()+"-"+now.getDate()+"'),this) title='Next Month'>&raquo;</a>";
	CalenderTitle += "<a href='javascript:void(0)' class='LastMonth' onclick=HS_calender(HS_DateAdd('m',-1,'"+now.getFullYear()+"-"+now.getMonth()+"-"+now.getDate()+"'),this) title='Previous Month'>&laquo;</a>";
	CalenderTitle += "<span class='selectThisYear'><a href='javascript:void(0)' onclick='CalenderselectYear(this)' title='Click here to select other year' >"+now.getFullYear()+"</a></span>年<span class='selectThisMonth'><a href='javascript:void(0)' onclick='CalenderselectMonth(this)' title='Click here to select other month'>"+(parseInt(now.getMonth())+1).toString()+"</a></span>月"; 

	if (arguments.length>1){
		arguments[1].parentNode.parentNode.getElementsByTagName("ul")[1].innerHTML = lis;
		arguments[1].parentNode.innerHTML = CalenderTitle;

	}else{
		var CalenderBox = style+"<div class='calender'><div class='calenderTitle'>"+CalenderTitle+"</div><div class='calenderBody'><ul class='day'><li>日</li><li>一</li><li>二</li><li>三</li><li>四</li><li>五</li><li>六</li></ul><ul class='date' id='thisMonthDate'>"+lis+"</ul></div><div class='calenderBottom'><a href='javascript:void(0)' class='closeCalender' onclick='closeCalender(this)'>×</a><span><span><a href=javascript:void(0) onclick='_selectThisDay(this)' title='"+todayString+"'>Today</a></span></span></div></div>";
		return CalenderBox;
	}
}
function _selectThisDay(d){
	var boxObj = d.parentNode.parentNode.parentNode.parentNode.parentNode;
		boxObj.targetObj.value = d.title;
		boxObj.parentNode.removeChild(boxObj);
}
function closeCalender(d){
	var boxObj = d.parentNode.parentNode.parentNode;
		boxObj.parentNode.removeChild(boxObj);
}

function CalenderselectYear(obj){
		var opt = "";
		var thisYear = obj.innerHTML;
		for (i=1970; i<=2020; i++){
			if (i==thisYear){
				opt += "<option value="+i+" selected>"+i+"</option>";
			}else{
				opt += "<option value="+i+">"+i+"</option>";
			}
		}
		opt = "<select onblur='selectThisYear(this)' onchange='selectThisYear(this)' style='font-size:11px'>"+opt+"</select>";
		obj.parentNode.innerHTML = opt;
}

function selectThisYear(obj){
	HS_calender(obj.value+"-"+obj.parentNode.parentNode.getElementsByTagName("span")[1].getElementsByTagName("a")[0].innerHTML+"-1",obj.parentNode);
}

function CalenderselectMonth(obj){
		var opt = "";
                var temp="";
		var thisMonth = obj.innerHTML;
		for (i=1; i<=12; i++){
			if (i==thisMonth){
                                if(i<10){
                                temp="0"+i;
                                alert(temp);
                                 }
				opt += "<option value="+temp+" selected>"+temp+"</option>";
			}else{
                                 if(i<10){
                                temp="0"+i;
                                 }
				opt += "<option value="+temp+">"+temp+"</option>";
			}
		}
		opt = "<select onblur='selectThisMonth(this)' onchange='selectThisMonth(this)' style='font-size:11px'>"+opt+"</select>";
		obj.parentNode.innerHTML = opt;
}
function selectThisMonth(obj){
	HS_calender(obj.parentNode.parentNode.getElementsByTagName("span")[0].getElementsByTagName("a")[0].innerHTML+"-"+obj.value+"-1",obj.parentNode);
}
function HS_setDate(inputObj){
	var calenderObj = document.createElement("span");
	calenderObj.innerHTML = HS_calender(new Date());
	calenderObj.style.position = "absolute";
	calenderObj.targetObj = inputObj;
	inputObj.parentNode.insertBefore(calenderObj,inputObj.nextSibling);
}

function get_radio_value(radio_name){
  var temp = document.getElementsByName(radio_name);
  for(var i=0;i<temp.length;i++)
  {
  if(temp[i].checked)
  return radio_value = temp[i].value;
  }
}

function Make_chart(){
   var href=GetHref();
   var start_date=document.getElementById("start_date").value;
   var end_date=document.getElementById("end_date").value;
   var accept_condition=get_radio_value("accept_condition");
   var time_scale=get_radio_value("time_scale");
   if((start_date!="")&&(end_date!="")&&(accept_condition!="")&&(time_scale!="")){
       window.location.href=href+"chart_all_town/change_chart_data/"+start_date+"_"+end_date+"/"+accept_condition+"/"+time_scale;
   }else{
       alert("请填写完整信息");
   }
}



