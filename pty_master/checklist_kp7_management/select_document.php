<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include("checklist2.inc.php");

$xtypedoc = $_POST['type_doc'];
$xtype_p = $_POST['type_problem'];
$xpid = $_POST['problem_status_id'];


if($_POST['type_doc'] < 1){
	
	$sql1 = "SELECT * FROM tbl_temp_profile WHERE page_load='2' and status_load='1'";
	$result1 = mysql_db_query($dbname_temp,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
			$sql_del = "DELETE FROM tbl_temp_profile_detail  WHERE  load_id='$rs1[load_id]'";
			mysql_db_query($dbname_temp,$sql_del);
			mysql_db_query($dbname_temp,"DELETE FROM tbl_temp_profile  WHERE  load_id='$rs1[load_id]'");
	}//end while($rs1 = mysql_fetch_assoc($result1)){
		

	
		
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
echo "<script language=\"javascript\">
window.opener.location='report_document_problem.php?type_doc=$type_doc&profile_id=$profile_id&xsiteid=$xsiteid&xlv=$xlv&typeproblem=$type_problem&schoolid=$schoolid&problem_status_id=$problem_status_id&txt_title=$txt_title&school_type=$school_type';
</script>
";

}//end if($_SERVER['REQUEST_METHOD'] == "POST"){



?>

<html>
<head>
<title>เลือกประเภทการแสดงผลข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
function confirmDelete(delUrl) {
  if (confirm("คุณแน่ใจที่จะลบข้อมูล cmss จริงหรือไม่")) {
    document.location = delUrl;
  }
}

function CheckF(){
	if(document.form1.comment.value == ""){
		alert("กรุณาระบุเหตุผลการลบ");
		document.form1.comment.focus();
		return false;	
	}//end 
}// end function CheckF(){



function show_table1() {
	if(document.form1.type_doc[2].checked == true){
			document.getElementById("table1").style.display = "";
			document.getElementById("table2").style.display = "none";
	}else if(document.form1.type_doc[3].checked == true){
		document.getElementById("table1").style.display = "none";
		document.getElementById("table2").style.display = "";
	}
}




</script>

  <style>
.graph {
position: relative; /* IE is dumb */
width: 100%;
border: 1px solid #B1D632;
padding: 2px;
}
.graph .bar {
display: block;
position: relative;
background: #B1D632;
text-align: center;
color: #333;
height: 30px;
line-height: 30px;
}
.graph .bar span { position: absolute; left: 1em; width: 100%;text-align: center;font-size:14px;color:#FFFFFF; }

.graph_error {
position: relative; /* IE is dumb */
width: 100%;
border: 1px solid #FF9900;
padding: 2px;
}
.graph_error .bar {
display: block;
position: relative;
background: #FF9900;
text-align: center;
color: #333;
height: 30px;
line-height: 30px;
}
.graph_error .bar span { position: absolute; left: 1em; width: 100%;text-align: center;font-size:14px;color:#FFFFFF; }

.graph_error_all {
position: relative; /* IE is dumb */
width: 100%;
border: 1px solid #FF0000;
padding: 2px;
}
.graph_error_all .bar {
display: block;
position: relative;
background: #FF0000;
text-align: center;
color: #333;
height: 30px;
line-height: 30px;
}
.graph_error_all .bar span { position: absolute; left: 1em; width: 100%;text-align: center;font-size:14px;color:#FFFFFF; }
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style3 {	color: #666666;
	font-size: 11px;
}
.style15 {font-size: 12px; color: #CCCCCC; }
  .style17 {
	color: #FFFFFF;
	font-weight: bold;
}
.style20 {font-size: 12px; color: #FFFF00; }
.style25 {color: #000000; font-weight: bold; }
  </style>
  <script language="javascript">
			var xsiteid = "<?=$xsiteid?>";
			var xlv="<?=$xlv?>";
			var schoolid="<?=$schoolid?>";
			var school_type="<?=$school_type?>";
			var txt_title="<?=$txt_title?>";
 			 var xtypedoc1 = "<?=$xtypedoc?>";
  			  var xid = "<?=$xtypedoc?>";
 			 var typep = "<?=$xtype_p?>";
 			 var pid = "<?=$xpid?>";
			 

  	var int = self.setInterval('getLogforce()',8000);
	function getLogforce(){
		if(xtypedoc1 > 0){
		var pts_success = document.getElementById("pts_success");
		forceInformation( <?=$profile_id?> );
		pts_success.scrollTop = pts_success.scrollHeight;

			
		}//end 
	}//end function getLogforce(){




  </script>
</head>
<BODY onLoad="getLogforce();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="" onSubmit="return submitfrom()">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" bgcolor="#DBDBDB"><strong>เลือกรูปแบบการแสดงผลข้อมูล</strong></td>
          </tr>
        <tr>
          <td width="21%" align="right" bgcolor="#EFEFEF"><label>
            <input type="radio" name="type_doc" id="type_doc1" value="11" onClick="show_table1(this.value)">
          </label></td>
          <td width="79%" align="left" bgcolor="#EFEFEF">แสดงจำนวนปัญหารายหน่วยงาน</td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EFEFEF"><label>
            <input type="radio" name="type_doc" id="type_doc2" value="2" onClick="show_table1(this.value)">
          </label></td>
          <td align="left" bgcolor="#EFEFEF">แสดงรายละเอียดรายบุคคล</td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EFEFEF"><label>
            <input type="radio" name="type_doc" id="type_doc3" value="3" onClick="show_table1(this.value)">
          </label></td>
          <td align="left" bgcolor="#EFEFEF">แสดงข้อมูลรายหมวดปัญหา</td>
        </tr>
        <tr>
          <td colspan="2" align="center" bgcolor="#EFEFEF">
          <table width="100%" border="0" cellspacing="1" cellpadding="3" id="table1" style="display:none">
            <tr>
              <td width="21%" align="right">เลือกหมวดปัญหา</td>
              <td width="79%" align="left">
                <select name="type_problem" id="type_problem">
                <option value="99">แสดงหมวดปัญหาทั้งหมด</option>
                <option value="100">ขาดเอกสารประกอบ</option>
                <?
                	$sqlp = "SELECT * FROM tbl_problem ORDER BY problem_id ASC";
					$resultp = mysql_db_query($dbname_temp,$sqlp);
					while($rsp = mysql_fetch_assoc($resultp)){
							echo "<option value='$rsp[problem_id]'>$rsp[problem]</option>>";
					}//end while($rsp = mysql_fetch_assoc($resultp)){
				?>
                </select>
              </td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td align="right" bgcolor="#EFEFEF">
            <input type="radio" name="type_doc" id="type_doc4" value="4" onClick="show_table1(this.value)">
          </td>
          <td align="left" bgcolor="#EFEFEF">แสดงข้อมูลแยกสถานะการแก้ไขเอกสาร</td>
        </tr>
        <tr>
          <td colspan="2" align="right" bgcolor="#EFEFEF"><table width="100%" border="0" cellspacing="1" cellpadding="3" id="table2" style="display:none">
            <tr>
              <td width="21%" align="right">เลือกสถานะการแก้ไขเอกสาร</td>
              <td width="79%" align="left">
                <select name="problem_status_id" id="problem_status_id">
                <?
                	$sql_problem_status = "SELECT * FROM tbl_checklist_problem_status ORDER BY orderby ASC";
					$result_ps = mysql_db_query($dbname_temp,$sql_problem_status);
					while($rsps = mysql_fetch_assoc($result_ps)){
						if($rsps[problem_status_id] == $problem_status_id){ $sel = "selected='selected'";}else{ $sel = "";}
							echo "<option value='$rsps[problem_status_id]'>$rsps[problen_status_name]</option>";
					}//end  while($rsps = mysql_fetch_assoc($result_ps)){
						
				?>
                </select>
              </td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td bgcolor="#EFEFEF">&nbsp;</td>
          <td bgcolor="#EFEFEF"><label>
            <input type="submit" name="button" id="button" value="ตกลง">
            <input type="button" name="btn" id="btnC" value="ปิดหน้าต่าง" onClick="window.close();">
<input type="hidden" name="xsiteid" value="<?=$xsiteid?>">
<input type="hidden" name="schoolid" value="<?=$schoolid?>">
<input type="hidden" name="xlv" value="<?=$xlv?>">
<input type="hidden" name="school_type" value="<?=$school_type?>">
<input type="hidden" name="txt_title" value="<?=$txt_title?>">

          </label></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <? if($xtypedoc > 0){	  ?>
       <script language="javascript">

 
 	function CreateXmlHttp(){
		//Creating object of XMLHTTP in IE
		try {
			XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch(oc) {
				XmlHttp = null;
			}
		}
		//Creating object of XMLHTTP in Mozilla and Safari 
		if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
			XmlHttp = new XMLHttpRequest();
		}
		return XmlHttp; 
	} // end function CreateXmlHttp

	function getTimeStamp(){
		var d = new Date();
		var strTime = d.getHours()+'-'+d.getMinutes()+'-'+d.getSeconds();
		return strTime;
	}

	function getInternetSpeed(bandwidth_support){
		time      = new Date();
		starttime = time.getTime();	
		XmlHttpInternetSpeed = CreateXmlHttp();
			XmlHttpInternetSpeed.open("get", "../policy_timeline_stat/get_speed.php?ram="+getTimeStamp(), true);
			XmlHttpInternetSpeed.onreadystatechange=function() {
				if (XmlHttpInternetSpeed.readyState==4) {
					if(XmlHttpInternetSpeed.status==200) {
						//var res_internetSpeed = XmlHttpInternetSpeed.responseText;
						time          = new Date();
						endtime       = time.getTime();
						if (endtime == starttime){
							downloadtime = 0;
						}else{
							downloadtime = (endtime - starttime)/1000;
						}
						kbytes_of_data = 128;
						linespeed  = kbytes_of_data/downloadtime;
						kbps   = (Math.round((linespeed*8)*10*1.024))/10;		
						if(kbps >= 1000000){
							valueSpeed = (kbps/1024)/1024;
							unitSpeed = "Gbps";
						}
						if(kbps >= 1000){
							valueSpeed = kbps/1024;
							unitSpeed = "Mbps";
						}else{
							valueSpeed = kbps;
							unitSpeed = "Kbps";
						}
						
						document.getElementById("Internet_Speed_Alert").innerHTML =  (parseInt(kbps) < parseInt(bandwidth_support))?strImgAlert+" Internet Speed  ต้องสูงเกินกว่าที่กำหนด ("+bandwidth_support+" Kbps)":"";			
						document.getElementById("Internet_Speed").innerHTML = valueSpeed.toFixed(3)+" "+unitSpeed;
						Internet_Speed_Alert
					} else if (XmlHttpInternetSpeed.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้x1");
					}
				}
			};
			XmlHttpInternetSpeed.send(null);
	}

	function logForceSucess( profile_id ){
		XmlHttpSucess = CreateXmlHttp();
		XmlHttpSucess.open("get", "../policy_timeline_stat/ajax.pts_force_success.php?profile_id="+profile_id+"&ram="+getTimeStamp(), true);
		XmlHttpSucess.onreadystatechange=function() {
			if (XmlHttpSucess.readyState==4) {
				if(XmlHttpSucess.status==200) {
					var res_success = XmlHttpSucess.responseText;
					document.getElementById("pts_force_success").innerHTML = res_success;
				} else if (XmlHttpSucess.status==404) {
					alert("ไม่สามารถทำการดึงข้อมูลได้x2");
				}
			}
		};
		XmlHttpSucess.send(null);
	}

	var strImgAlert  =  '<img src="../policy_timeline_stat/images/alert.png" border="0" align="absmiddle">';

	function forceInformation( profile_id ){
		XmlHttpInformation = CreateXmlHttp();
		XmlHttpInformation.open("get", "../policy_timeline_stat/ajax.load_page.php?profile_id="+profile_id+"&ram="+getTimeStamp(), true);
		XmlHttpInformation.onreadystatechange=function() {
			if (XmlHttpInformation.readyState==4) {
				if(XmlHttpInformation.status==200) {
					var res = XmlHttpInformation.responseText;
					
					var graph = document.getElementById("graph"+profile_id);
				//	alert(graph);
					arrNum = res.split(",");
					//alert(res);

				
					//document.getElementById("numAll").innerHTML = arrNum[0];//All
					//document.getElementById("numError").innerHTML = arrNum[1];//Error
					//document.getElementById("numForce").innerHTML = arrNum[2];//Force
					//document.getElementById("numUnforce").innerHTML = arrNum[3];//Unforce
					//document.getElementById("timeWasted").innerHTML = arrNum[4];//เวลาที่ใช้
					document.getElementById("Cpu_Usage").innerHTML = parseInt(arrNum[6])+"%";
					document.getElementById("Memory_Usage").innerHTML = parseInt(arrNum[7])+"%";
					document.getElementById("Hdd_Usage").innerHTML = parseInt(arrNum[8])+"%";
					document.getElementById("Cpu_Usage_Rate").style.width = parseInt(arrNum[6])+"%";
					//alert(arrNum[7]);
					document.getElementById("Memory_Usage_Rate").style.width = parseInt(arrNum[7])+"%";
					//alert(arrNum[12]);
					document.getElementById("Hdd_Usage_Rate").style.width = parseInt(arrNum[8])+"%";
					getInternetSpeed(arrNum[12]);
					//alert(arrNum[14]);
					
					//เมื่อค่าสูงเกินกว่าที่กำหนด
					document.getElementById("Cpu_Usage_Alert").innerHTML =  (parseInt(arrNum[6]) > parseInt(arrNum[9]))?strImgAlert+"การใช้งาน CUP สูงเกินกว่าที่กำหนด ("+arrNum[9]+"%)":"";
					document.getElementById("Cpu_Usage_Border").style.border = (parseInt(arrNum[6]) > parseInt(arrNum[9]))?"1px #FF0000 solid":"1px #9ED850 solid";
					document.getElementById("Memory_Usage_Alert").innerHTML =  (parseInt(arrNum[7]) > parseInt(arrNum[10]))?strImgAlert+"การใช้งาน Memory สูงเกินกว่าที่กำหนด ("+arrNum[10]+"%)":"";
					document.getElementById("Memory_Usage_Border").style.border = (parseInt(arrNum[7]) > parseInt(arrNum[10]))?"1px #FF0000 solid":"1px #9ED850 solid";
					document.getElementById("Hdd_Usage_Alert").innerHTML =  (parseInt(arrNum[8]) > parseInt(arrNum[11]))?strImgAlert+"การใช้งาน Harddisk สูงเกินกว่าที่กำหนด ("+arrNum[11]+"%)":"";
					document.getElementById("Hdd_Usage_Border").style.border = (parseInt(arrNum[8]) > parseInt(arrNum[11]))?"1px #FF0000 solid":"1px #9ED850 solid";
					

			
					if(arrNum[0] == arrNum[1] && arrNum[0] > 0){
						graph.className = "graph_error_all";
							
					}else if(arrNum[0] > arrNum[1] && arrNum[1] > 0 ){
						graph.className = "graph_error";
					}else{
						graph.className = "graph";
					}
					
//alert(arrNum[2]);
//alert(arrNum[0]);
					var percenProcess = (arrNum[2]*100)/arrNum[0];
					var percenProcessFixed = (percenProcess < 100)?percenProcess.toFixed(2):percenProcess;
					
					setProgess( profile_id, percenProcessFixed);
					
					logForceSucess( profile_id );
					if(percenProcessFixed == 100){
/*					window.opener.location='report_document_problem.php?type_doc='+xid+'&profile_id='+profile_id+'&xsiteid='+xsiteid+'&xlv='+xlv+'&typeproblem='+typep+'&schoolid='+schoolid+'&problem_status_id='+pid;*/
	setTimeout("window.close()",4000);
					}
					
					//logForceError( profile_id );

				} else if (XmlHttpInformation.status==404) {
					alert("ไม่สามารถทำการดึงข้อมูลได้x3");
				}
			}
		};
		XmlHttpInformation.send(null);
	}

	function setProgess( profile_id, percenProcess){
		var newWidth = percenProcess;
		//var newWidth = 20;
		
		//alert(newWidth);
		if(newWidth <= 100 && newWidth > 0){
			document.getElementById("progress"+profile_id).style.width = newWidth+"%";
			document.getElementById("val"+profile_id).innerHTML = newWidth+"%";
		}else{
			document.getElementById("progress"+profile_id).style.width = "0%";
			document.getElementById("val"+profile_id).innerHTML = "0%";
		}
	}
	
	function profileStatus( buttonID, profile_id ){
		var button_status = document.getElementById( buttonID );
		XmlHttpStatus = CreateXmlHttp();
		XmlHttpStatus.open("get", "../policy_timeline_stat/ajax.pts_profile_status.php?profile_id="+profile_id+"&profile_status="+button_status.value+"&ram="+getTimeStamp(), true);
		XmlHttpStatus.onreadystatechange=function() {
			if (XmlHttp.readyState==4) {
				if(XmlHttpStatus.status==200) {q
					var res = XmlHttpStatus.responseText;
				} else if (XmlHttpStatus.status==404) {
					alert("ไม่สามารถทำการดึงข้อมูลได้x4");
				}
			}
		};
		XmlHttpStatus.send(null);
	}

 </script>

      
  <tr>
    <td>		<TABLE width="100%">
					<TR>
						<TD>
						<fieldset style="color:#000000;border:1px #000000 solid;font-size:14px;">
						<legend><B style="color:#000000;">ข้อมูลระบบ</B></legend>
						<TABLE width="99%" style="color:#000000;font-size:12px;">
						<TR>
							<TD width="100" bgcolor="#EFEFEF"><B>CPU Usage</B></TD>
						  <TD width="100" align="right" bgcolor="#EFEFEF"><DIV id="Cpu_Usage"></DIV></TD>
							<TD width="230" align="left" bgcolor="#EFEFEF">
							<DIV id="Cpu_Usage_Border" style="border:#9ED850 1px solid;width:200px;height:15px;">
								<DIV id="Cpu_Usage_Rate" style="background-image:url(../policy_timeline_stat/images/rate_color.png);width:5%;height:15px;"></DIV>
							</DIV>
						  </TD>
						  <TD  align="left" bgcolor="#EFEFEF"><DIV id="Cpu_Usage_Alert"></DIV></TD>
						</TR>
						<TR>
							<TD bgcolor="#EFEFEF"><B>Memory Usage</B></TD>
						  <TD width="100" align="right" bgcolor="#EFEFEF"><DIV id="Memory_Usage"></DIV></TD>
							<TD align="left" bgcolor="#EFEFEF">
							<DIV id="Memory_Usage_Border" style="border:#9ED850 1px solid;width:200px;height:15;">
								<DIV id="Memory_Usage_Rate" style="background-image:url(../policy_timeline_stat/images/rate_color.png);width:5%;height:15px;"></DIV>
							</DIV>
						  </TD>
						  <TD  align="left" bgcolor="#EFEFEF"><DIV id="Memory_Usage_Alert"></DIV></TD>
						</TR>
						<TR>
							<TD bgcolor="#EFEFEF"><B>HDD Usage</B></TD>
						  <TD width="100" align="right" bgcolor="#EFEFEF"><DIV id="Hdd_Usage"></DIV></TD>
							<TD align="left" bgcolor="#EFEFEF">
							<DIV id="Hdd_Usage_Border" style="border:#9ED850 1px solid;width:200px;height:15;">
								<DIV id="Hdd_Usage_Rate" style="background-image:url(../policy_timeline_stat/images/rate_color.png);width:5%;height:15px;"></DIV>
							</DIV>
						  </TD>
						  <TD  align="left" bgcolor="#EFEFEF"><DIV id="Hdd_Usage_Alert"></DIV></TD>
						</TR>
						<TR>
							<TD bgcolor="#EFEFEF"><B>Internet Speed</B></TD>
						  <TD width="100" align="right" bgcolor="#EFEFEF"><DIV id="Internet_Speed"></DIV></TD>
							<TD align="left" bgcolor="#EFEFEF"></TD>
						  <TD align="left" bgcolor="#EFEFEF"><DIV id="Internet_Speed_Alert"></DIV> </TD>
						</TR>
						<TR>
							<TD></TD>
							<TD></TD>
						</TR>
						</TABLE>
						</fieldset>
						</TD>
					</TR>
					</TABLE></td>
  </tr>
  <tr>
    <td>			<!-- Begin Froce Percen -->
			   <TABLE width="100%">
			   <TR>
				    <TD align="left">
					   <div class="graph" id="graph<?=$profile_id?>">
					   <strong id="progress<?=$profile_id?>" class="bar" style="width:0%;"><span id="val<?=$profile_id?>">0%</span></strong>	</div></TD>
			   </TR>
			   </TABLE>
			  <!-- End Froce Percen -->
</td>
  </tr>
  <tr>
    <td>	<DIV id="pts_success" style=" overflow:auto; width:100%; height:25px;border:#BBBBBB 1px solid;">
			    <DIV id="pts_force_success"></DIV>
		      </DIV>		
</td>
  </tr>
  <?
  }//end if($xtypedoc > 0){
  ?>
</table>
</BODY>
</HTML>
