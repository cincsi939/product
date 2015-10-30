<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_sheet";
$module_code 		= "sheet"; 
$process_id			= "sheet";
$VERSION 				= "9.91";
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
	add_log("ข้อมูลผลงานทางวิชาการ",$id,$action);
			// ประกอบค่าจาก select box
			if($start_year==""){$start_year=0;}else{$start_year=$start_year;}
			if($start_month==""){$start_month=0;}else{$start_month=$start_month;}
			if($start_day==""){$start_day=0;}else{$start_day=$start_day;}
			
			if($end_year==""){$end_year=0;}else{$end_year=$end_year;}
			if($end_month==""){$end_month=0;}else{$end_month=$end_month;}
			if($end_day==""){$end_day=0;}else{$end_day=$end_day;}
			 
			  $startdate = $start_year.'-'.$start_month.'-'.$start_day;
			  $enddate = $end_year.'-'.$end_month.'-'.$end_day;

			 if ($_POST[action]=="edit2")
			 {  
			 
				$sql = "update sheet set  topic='$topic' ,startdate ='$startdate',enddate='$enddate' ,sheetname='$sheetname' ,refer='$refer'  where id ='$id' and runid='$runid' ;";
	
				$returnid = add_monitor_logbefore("sheet"," id ='$id' and runid='$runid' ");
				mysql_query($sql);
				add_monitor_logafter("sheet"," id ='$id' and runid='$runid' ",$returnid);
			
				if (mysql_errno())
				{
					$msg = "Cannot update parameter information.";
				}
				else
				{
					echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit&vsheet=1';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
				}
									
					
			}else
				{
				
					$sql = "INSERT INTO  sheet (id,startdate,enddate,sheetname,topic,refer) VALUES ('$id','$startdate','$enddate','$sheetname','$topic','$refer')";
		
					$returnid = add_monitor_logbefore("sheet","");
					$result  = mysql_query($sql);
					$max_idx = mysql_insert_id();
					add_monitor_logafter("sheet","  id ='$id' AND runid='$max_idx' ",$returnid);
					
					if($result)
					{
					echo "
				<script language=\"javascript\">
				alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit&vsheet=1';
				</script>
				";
					//	header("Location: ?id=$id&action=edit");
						exit;
					}else
					{	echo "ไม่สามารถบันทึกข้อมูลได้ ";}
				}
				

}else if ($_GET[action] == 'delete')
	{
		add_log("ข้อมูลการศึกษา",$id,$action);
		mysql_query("delete from sheet  where id = $id and runid='$runid';");
		if (mysql_errno()){
			$msg = "Cannot delete parameter.";
			}else
			{
			//header("Location: ?id=$id&action=edit");
			echo"<meta http-equiv='refresh' content='0;URL=sheet_all_1.php?id=$id&action=edit&vsheet=1'>";
			exit;
			}
	
}else
		{		
	 	$sql = "select * from  general where id='$id'  ;";
		$result = mysql_query($sql);
		if ($result){
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		} else {
		$msg = "Cannot find parameter information.";
		echo $msg;
		}
}
	
		?>



<html>
<head>
<title>ผลงานทางวิชาการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {  
	margin				: 0px  0px; 
	padding				: 0px  0px;
}

a:link { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:visited { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:active { 
	color					: #0099FF; 
	text-decoration	: underline
}

a:hover { 
	color					: #0099FF; 
	text-decoration	: underline;
}
.style5 {color: #000000}
</style>

<!-- send id to menu flash -->
<script type="text/javascript" src="../../../common/calendar_list.js"></script> 
<script language=javascript>
addnone=1;
displaymonth='l';
function check(){

	if(document.post.sheetname.value.length==0){
		alert("ระบุชื่อผลงาน");
		document.post.sheetname.focus();
		return false;
	} else {
		return true;
	}
	
}	
</script>
</head>

<body bgcolor="#A3B2CC">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="30"><br>
      <?
	   if($action =="edit" and $vsheet==0){
	?>
	<table width="98%" border="0" align="center">
	<?
	if($dis_menu){ echo ""; // เริ่มต้นการปิดเมนู
	?>
	<?
	}else{
	?>
      <tr>
        <td width="25%"><a href="sheet_all_1.php?id=<?=$arr_general[id]?>&action=edit&vsheet=1" title="แก้ไขข้อมูลส่วนบุคคล" > <img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style5">เพิ่ม/ลบ/แก้ไข ข้อมูล</span></a> <span class="style5">&nbsp; </span></td>
        <td width="39%"></td>
<?  if ($vsheet !=0 ){   ?> 
        <td width="36%">&nbsp;</td>
<?  } #  if ($vsheet !=0 ){   ?> 
      </tr>
	<?
	}//จบการปิดเมนู
	?>  
    </table>
        <br>
    <? }?></td>
    <td width="50" height="30">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="left" valign="top">
          <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" width="450"><b>ชื่อ / สกุล &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?></u>
                    &nbsp;&nbsp; </b></td>
                </tr>
            </table>
              <span > &nbsp;&nbsp;<strong><br>
              &nbsp;&nbsp;&nbsp;&nbsp;ผลงานทางวิชาการ</strong></span><br>
              <br>
              <? if($action=="edit")
			  { 
			  if($vsheet==0)
			  {
			 
			  ?>
              <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" BGCOLOR=black>
                
                <tr bgcolor="#A3B2CC" align="center"> 
                  <td width="14%"><strong>วันที่</strong></td>
                  <td width="15%"><strong>ถึงวันที่</strong></td>
                  <td width="36%"><strong>ชื่อผลงาน</strong></td>
                  <td width="35%"><strong>เนื้อหาโดยย่อ</strong></td>
                </tr>
                <?
//conn2DB();
	$i=0;
	$result = mysql_query("select * from sheet where id='$id' order by startdate,enddate asc");
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}
		$sd=explode("-",$rs[startdate]);
		$startday=MakeDate($rs[startdate]);
		
		$ed=explode("-",$rs[enddate]);
		$endday=MakeDate($rs[enddate]);

?>
                <tr align="center" valign="top" bgcolor="<?=$bg?>"> 
                  <td align="center"> 
					 <?=$startday?>            </td>
                  <td align="center"> 
                    <?=$endday?>                  </td>
                  <td align="left"> 
                    <?=$rs[sheetname]?>                  </td>
                  <td align="left"> 
                    <?=$rs[topic]?>                  </td>
                </tr>
                <?
	} //while
// List Template
?>
              </table>
              <?
			  			  } //END  if($vsheet==0)
						  
else if($vsheet==1)
{
?>

<table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" BGCOLOR=black>
                
                <tr bgcolor="#A3B2CC" align="center">
               
                  <td width="137"><strong>วันที่</strong></td>
                  <td width="126"><strong>ถึงวันที่</strong></td>
                  <td width="195"><strong>ชื่อผลงาน</strong></td>
                  <td width="306"><strong>เนื้อหาโดยย่อ</strong></td>
                  <td><strong></strong><input type="button" name="add" value="เพิ่มข้อมูล" onClick="location.href='sheet_all_1.php?id=<?=$id?>&ex_date=d_add'"></td>
                </tr>
                <?
//conn2DB();
	$i=0;
	$result = mysql_query("select * from sheet where id='$id' order by startdate,enddate asc");
	$row=mysql_num_rows($result);
	while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		$i++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}
		$sd=explode("-",$rs[startdate]);
		$startday=MakeDate($rs[startdate]);
		
		$ed=explode("-",$rs[enddate]);
		$endday=MakeDate($rs[enddate]);
?>
                <tr align="center" valign="top" bgcolor="<?=$bg?>">
                  <td align="center"> 
                    <?=$startday?>                  </td>
                  <td align="center"> 
                    <?=$endday?>                  </td>
                  <td align="left"> 
                    <?=$rs[sheetname]?>                  </td>
                  <td align="left"> 
                    <?=$rs[topic]?>                  </td>
                  <td width=83> <a href="sheet_all_1.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&action=edit2&vsheet=1"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
                    &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>                  </td>

                <?
	} //while
// List Template
?>
                     </tr>
                <tr align="center" valign="top" bgcolor="<?=$bg?>">
                  <td colspan="6" align="center"><input type="button" name="back2" value="กลับหน้าแรก" onClick="location.href='sheet_all_1.php?id=<?=$id?>&action=edit&vsheet=0'">
				
				  </td>
                </tr>      
				 </table>

<?
}//END	else if($vsheet==1)_--------------------------------			  

			  
			  }//END  if($action=="edit")
else
{

If ($_GET[action]=="edit2")
{
		$sql = "select * from sheet where id='$id' and runid= '$runid' ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}

}
?>
              <br>
			   <form name="post" method="post" action="<?=$PHP_SELF?>" onSubmit="return check();">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="runid" VALUE="<?=$runid?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td align="right" valign="middle" width="266">ตั้งแต่</td>
                  <td align="left" valign="middle" width="608"> 
                    วันที่ <select name="start_day" id="start_day"  onChange="check_date('start_day','start_month','start_year');"></select>
                     เดือน <select name="start_month" id="start_month"  onChange="check_date('start_day','start_month','start_year');"></select>
                      ปี พ.ศ.<select name="start_year" id="start_year"  onChange="check_date('start_day','start_month','start_year');"></select>
				  <?
				  
				  if($ex_date=="d_add"){
				  $startdate_x="";
				  }else{
				  $startdate_x=$rs[startdate];
				  }
				  $d1=explode("-",$startdate_x);
				  ?>
 <script>
	create_calendar('start_day','start_month','start_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
</script>                   
&nbsp;<? /*=DateInput_key($startdate_x,"start","ไม่ระบุ");*/?>  
 </td>
                </tr>
                <tr> 
                  <td align="right" valign="middle" width="266">ถึง</td>
                  <td align="left" valign="middle" width="608"> 
				  วันที่
				    <select name="end_day" id="end_day"  onChange="check_date('end_day','end_month','end_year');">
			        </select>
เดือน
<select name="end_month" id="end_month"  onChange="check_date('end_day','end_month','end_year');">
</select>
ปี พ.ศ.
<select name="end_year" id="end_year"  onChange="check_date('end_day','end_month','end_year');">
</select>
<?
				  if($ex_date=="d_add"){
				  $encdate_x="";
				  }else{
				   $encdate_x=$rs[enddate];
				  }
				  $d1=explode("-",$encdate_x);
				  ?>
<script>
	create_calendar('end_day','end_month','end_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
</script>                    
&nbsp;<? /*=DateInput_key($encdate_x,"end","ไม่ระบุ");*/?>                  </td>
                </tr>

                <tr> 
                  <td align="right" valign="middle" width="266"><font color="red">*</font> ชื่อผลงาน</td>
                  <td align="left" valign="top" width="608"> 
                    <input type="text" name="sheetname" size="55" value="<?=$rs[sheetname]?>">
                  </td>
                </tr>
                <tr> 
                  <td align="right" valign="middle" width="266">ที่มา/การนำเสนอ</td>
                  <td align="left" valign="top" width="608">
                    <input type="text" name="refer" size="55" value="<?=$rs[refer]?>">
                  </td>
                </tr>
                <tr> 
                  <td align="right" valign="middle" width="266">เนื้อย่อโดยย่อ</td>
                  <td align="left" valign="top" width="608"><textarea name="topic" cols="50" rows="10"><?=$rs[topic]?></textarea>
                  </td>
                </tr>
              </table>
              <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                <tr valign="middle"> 
                  <td align="center" > &nbsp;&nbsp;
                    <input type="submit" name="send" value="  บันทึก  "><input type="button" name="back" value="ยกเลิก" onClick="location.href=' sheet_all_1.php?id=<?=$id?>&action=edit&vsheet=1' ">
                    <input type="button" name="viewdata3" value="กลับหน้าแรก" onClick="location.href='sheet_all_1.php?action=edit&vsheet=0' ">                  </td>
                </tr>
              </table>
            </form>
			
<? }?>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </td></tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>