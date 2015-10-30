<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_nosalary";
$module_code 		= "nosalary"; 
$process_id			= "nosalary";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
$time_start = getmicrotime();
if ($_SERVER[REQUEST_METHOD] == "POST"){

	if($action == "ChangRows"){

			for($i=0;$i<count($runno);$i++){
				$sql		= " update hr_nosalary set runno='".$runno[$i]."' where id='$id' and no='".$no[$i]."' ";		
				$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
				}
				echo"<meta http-equiv='refresh' content='0;URL=nosalary.php?id=$id&action=edit&vnosalary=1'>";
				exit;
		}	

	add_log("ข้อมูลวันที่ไม่ได้รับเงินเดือน",$id,$action);
	if ($comment){
			  $fromdate = $from_year.'-'.$from_month.'-'.$from_day;
			  $todate = $to_year.'-'.$to_month.'-'.$to_day;

			if ($fromdate > $todate){
				$msg = "วันที่เริ่มต้น ต้องไม่มากกว่า วันที่สิ้นสุด";
			}else{

				 if ($_POST[action]=="edit2")
				 {
					$sql = "update  hr_nosalary set  fromdate='$fromdate', todate='$todate',comment='$comment',refdoc='$refdoc',kp7_active='$kp7_active',label_date='$label_date' where no ='$no' and id ='$id' ;";
					
					$returnid = add_monitor_logbefore("hr_nosalary"," no ='$no' and id ='$id'");
					mysql_query($sql);
					add_monitor_logafter("hr_nosalary"," no ='$no' and id ='$id' ",$returnid);
					
					if (mysql_errno())
					{
						$msg = "ไม่สามารถแก้ไขข้อมูลได้"   .__LINE__.  mysql_error()  ;
					}
					else
					{
							echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='nosalary.php?id=$id&action=edit&vnosalary=1';
				</script>
				";
					//	header("Location: ?id=$id&action=edit");
						exit;
					}
										
						
				}else{

					$result = mysql_query("select * from hr_nosalary where (id='$id') and (fromdate='$fromdate' ) and (todate='$todate');");
					if (mysql_num_rows($result) > 0){
						$msg = "ข้อมูลซ้ำกับช่วงวันที่ที่มีอยู่แล้ว";
					}else{
					$strID="SELECT max(runno) as runno FROM hr_nosalary WHERE id='$id'";
					$ResultID=mysql_query($strID);
					$RsID=mysql_fetch_array($ResultID);
					$IDmax=$RsID[runno]+1;
						$sql = "INSERT INTO  hr_nosalary (id,fromdate,todate,comment,refdoc,kp7_active,runno,label_date) VALUES ('$id','$fromdate','$todate','$comment','$refdoc','$kp7_active','$IDmax','$label_date')";
			
					$returnid = add_monitor_logbefore("hr_nosalary","");
					$result  = mysql_query($sql);
					$max_idx = mysql_insert_id();
					add_monitor_logafter("hr_nosalary"," no ='$max_idx' and id ='$id' ",$returnid);	
										

						if($result)
						{
							echo "
							<script language=\"javascript\">
							alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
						location.href='nosalary.php?id=$id&action=edit&vnosalary=1';
							</script>
							";
						//	header("Location: ?id=$id&action=edit");
							exit;
						}else
						{	$msg = "ไม่สามารถบันทึกข้อมูลได้ "   .__LINE__.  mysql_error()  ;}

					}


				} // if edit2

			} // if fromdate > todate
				
	}else{ // if comment
		$msg = "กรุณาป้อนข้อมูลในช่องรายการ";
	}


}else if ($_GET[action] == 'delete')
	{
		add_log("ข้อมูลวันที่ไม่ได้รับเงินเดือน",$id,$action);
		mysql_query("delete from hr_nosalary where no = $no and id='$id';");
		if (mysql_errno())
			{
			$msg = "ไม่สามารถลบข้อมูลได้"   .__LINE__.  mysql_error()  ;
			}else
			{
		//	header("Location: ?id=$id&action=edit");
						echo "<script language=\"javascript\">
						location.href='nosalary.php?id=$id&action=edit&vnosalary=1';
							</script>";
			exit;
			}
	
}

// แสดงข้อมูล
$sql = "select * from  general where id='$id' ;";
$result = mysql_query($sql);
if ($result){
	$rs=mysql_fetch_array($result,MYSQL_ASSOC);
} else {
	$msg = "ไม่พบข้อมูลที่ระบุ";
}
	
?>



<html>
<head>
<title>วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็ม</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style2 {color: #000000}
.style4 {color: #000000; font-weight: bold; }
.style5 {	color: #990000;
	font-style: italic;
}
.style6 {color: #8C0000}
-->
</style>
<script type="text/javascript" src="../../../common/calendar_list.js"></script>
<!-- send id to menu flash -->
<script>
addnone=1;
displaymonth='l';
</script>
</head>

<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="30"><a href="kp7_nosalary.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"> <span class="style4">&nbsp;&nbsp;  &nbsp;</span><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style2">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a> </td>
    <td width="50" height="30"> 
      <div align="center"></div>
    </td>
  </tr>
</table>
<?
if ($msg){
?>
<CENTER><h2><FONT COLOR="red"><?=$msg?></FONT></h2>
<input type=button value=" ย้อนกลับ " onClick="history.back();">
</CENTER>
<?
	exit;
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="left" valign="top">
              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" ><b> &nbsp;ชื่อ / สกุล &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></b> </td>
                </tr>
              </table>
              <span class="style4"><br>
              &nbsp;&nbsp;  &nbsp;๑๒. วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็ม หรือวันที่มิได้ประจำ   ปฏิบัติหน้าที่อยู่ในเขตที่ได้มีประกาศใช้กฎอัยการศึก</span><br>
              <br>
              <?
$arr_kp7str[] = ""; 
$arr_kp7str[0] = ""; 
$arr_kp7str[1] = "  <img src='../../../images_sys/check_green.gif' width='16' height='13'>  "; 

if($vnosalary==1)
{
?>
		<form name="post" method="post" action="?">
		<input type="hidden" name="action" value="ChangRows">
		<input type="hidden" name="id" value="<?=$id?>">
<table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
                
                <tr bgcolor="#999999" align="center">
                  <td width="80" bgcolor="#A3B2CC"><strong>เรียงลำดับ</strong></td> 
                  <td bgcolor="#A3B2CC"><strong>ตั้งแต่ - ถึง (วัน เดือน ปี) </strong></td>
				  <td width="323" bgcolor="#A3B2CC"><strong>รายการ</strong></td>
				  <td width="160" bgcolor="#A3B2CC"><strong>เอกสารอ้างอิง</strong></td>
                  <td bgcolor="#A3B2CC"><input type="button" name="add" value="เพิ่มข้อมูล" onClick="location.href='nosalary.php?id=<?=$id?>&action=edit2s' "></td>
                </tr>
                <?

				$i=0;
				$result = mysql_query("select * from hr_nosalary where id='$id' order by runno asc");
				$row=mysql_num_rows($result);
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
					$i++;
					if ($i % 2) {
						$bg = "#FFFFFF";
					}else{
						$bg = "#F0F0F0";
					}
					
			##########  วันที่
					if($rs[label_date] != "" and $rs[label_date] != NULL){ // กรแสดงผลวันที่
						$show_date = $rs[label_date];
					}else{
						$show_date = MakeDate($rs[fromdate])." - ".MakeDate($rs[todate]);
					}

			
					
			?>
                <tr align="center" bgcolor="<?=$bg?>">
                  <td align="center">
				  	<select name="runno[]">
						<?
						for($e=1;$e<=$row;$e++){
							$selected = ($e == $i) ? " selected " : "" ;
							echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
								}
						?>	
				  </select>	
					<input type="hidden" name="no[]" value="<?=$rs[no]?>">				  </td> 
                  
				  <td align="center"><?=$show_date?></td>
				  <td align="left"> 
                    <?=$rs[comment] ?>                  </td>
				  <td align="left"> 
                    <?=$rs[refdoc] ?>                  </td>
                  <td width="77"><a href="nosalary.php?id=<?=$rs[id]?>&no=<?=$rs[no]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&no=<?=$rs[no]?>';"><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </td>
                
                <?
	} //while
// List Template
?></tr>
                <tr align="center" bgcolor="<?=$bg?>">
                  <td colspan="5" align="center"><input type="submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7">
                    <input type="button" name="back" value="กลับหน้าแรก" onClick="location.href='nosalary_all_1.php?id=<?=$id?>'">				  </td>
                </tr>
              </table>
	</form>		  
              <?
			  }
			  else
			  {

If ($_GET[action]=="edit2")
{
		$sql = "select * from hr_nosalary where no='$no' and id = '$id'   ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}


}
?>
                  <form  method = POST  action = "?id=<?=$id?>" >
              <INPUT TYPE="hidden" NAME="no" VALUE="<?=$no?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td align="right" valign="middle" width="258"><font color="red">*</font> <B>ตั้งแต่ วันที่</B></td>
                  <td align="left" valign="middle" width="616"> 
                   &nbsp; <?
                   //DateInput_key($rs[fromdate],"from","ไม่ระบุ");
				  $d1=explode("-",$rs[fromdate]); 
				   ?>
                      วันที่
				  <select name="from_day"  id="from_day"  onChange="check_date('from_day','from_month','from_year');"></select>

				  
				เดือน
				<select name="from_month" id="from_month" onChange="check_date('from_day','from_month','from_year');"></select>

				
				ปี พ.ศ.
				<select name="from_year"  id="from_year" onChange="check_date('from_day','from_month','from_year');"></select>
          
<script>
	create_calendar('from_day','from_month','from_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
</script>
      
                                     </td>
                </tr>
				<tr> 
                  <td align="right" valign="middle" width="258"><font color="red">*</font> <B>ถึง วันที่</B></td>
                  <td align="left" valign="middle" width="616"> 
                     &nbsp; <?
					 //DateInput_key($rs[todate],"to","ไม่ระบุ");
					  $d1=explode("-",$rs[todate]); 
					 ?>
                     วันที่
				                       <select name="to_day"  id="to_day"  onChange="check_date('to_day','to_month','to_year');">
                    </select>
เดือน
<select name="to_month" id="to_month" onChange="check_date('to_day','to_month','to_year');">
</select>
ปี พ.ศ.
<select name="to_year"  id="to_year" onChange="check_date('to_day','to_month','to_year');">
</select>
<script>
	create_calendar('to_day','to_month','to_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
</script></td>
                </tr>
				<tr>
				  <td align="right" valign="middle">&nbsp;</td>
				  <td align="left" valign="middle"><input name="label_date" type="text"  value="<?=$rs[label_date]?>" size="30">
			      <span class="style6"><br>
			      หากท่านบันทึกในชองแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span></td>
			    </tr>
                <tr> 
                  <td align="right" valign="middle" width="258"><B>รายการ</B></td>
                  <td align="left" valign="top" width="616"> <TEXTAREA NAME="comment" ROWS="7" COLS="60"><?=$rs[comment]?></TEXTAREA>				  </td>
                </tr>
				<tr> 
                  <td align="right" valign="middle" width="258"><B>เอกสารอ้างอิง</B></td>
                  <td align="left" valign="top" width="616"> 
                    <input type="text" name="refdoc" size="60" value="<?=$rs[refdoc]?>">                  </td>
                </tr>
				<tr>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="left" valign="top"><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <input name="kp7_active" type="radio" value="1" checked="checked" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
				    แสดงผลใน ก.พ. 7
				    <input name="kp7_active" type="radio" value="0" <? if($rs[kp7_active=="0"]){ echo "checked";}?>>
				  ไม่แสดงผลใน ก.พ.7 </label></td>
			    </tr>
              </table>

			  <BR><BR>
              <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                <tr valign="middle"> 
                  <td align="center" colspan=2> &nbsp;&nbsp;
                    <input type="submit" name="send" value="  บันทึก  ">
                  <input type="button" name="add2" value="ยกเลิก" onClick="location.href='nosalary.php?id=<?=$id?>&action=edit&vnosalary=1' ">
                  <input type="button" name="viewdata" value="กลับหน้าแรก" onClick="location.href='nosalary_all_1.php?action=edit' "></td>
                </tr>
              </table>
            </form><? }?>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>