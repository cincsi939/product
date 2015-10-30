<?
session_start();
include("checklist2.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.style1 {color: #006600}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>

</head>
<body>
<?
	
	
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<? if($lv == ""){?>
 <tr>
    <td align="left">&nbsp;</td>
  </tr>

 <tr>
   <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
     <tr>
       <td colspan="3" align="left" bgcolor="#A8B9FF"><strong>ข้อมูลจำนวนบุคลากรที่เอกสารมีปัญหาแยกรายเขตพื้นที่การศึกษา</strong></td>
       </tr>
     <tr>
       <td width="6%" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
       <td width="61%" align="center" bgcolor="#A8B9FF"><strong>เขตพื้นที่การศึกษา</strong></td>
       <td width="33%" align="center" bgcolor="#A8B9FF"><strong>จำนวนรายการ(คน)</strong></td>
     </tr>
     <?
     $sql_edu = "SELECT
eduarea.secid,
eduarea.secname
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' 
ORDER BY  secname";
	 $result_edu = mysql_db_query($dbnamemaster,$sql_edu);
	 $i=0;
	 while($rs_e = mysql_fetch_assoc($result_edu)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
	 $arr1 = show_val_exsum("1",$rs_e[secid],"",$profile_id);
	 	if($xtype == "wait"){
			$val = $arr1['numN'];
		}else{
			$val = $arr1['numY0'];
		}
	 ?>
     <tr bgcolor="<?=$bg?>">
       <td align="center"><?=$i?></td>
       <td align="left"><?=$rs_e[secname]?></td>
       <td align="center"><? if($val > 0){ echo "<a href='?lv=1&sentsecid=$rs_e[secid]&xtype=$xtype&profile_id=$profile_id' target='_blank'>".number_format($val)."";}else{ echo "0";}?></td>
     </tr>
    <?
		$arr1 = "";
	 }//end  while(){
	?>
   </table></td>
 </tr>
 <? } //end if($lv == ""){
	 
	if($lv == "1"){	 
	if($xtype == "wait"){ $xtitle = "รายชื่อบุคลากรที่อยู่ระหว่างการตรวจสอบเอกสาร";}else if($xtype == "complate"){ $xtitle = "รายชื่อบุคลากรที่ตรวจเอกสารสมบูรณ์";}else if($xtype == "checkall"){ $xtitle = "รายชื่อบุคลากรที่ตรวจเอกสารแล้วทั้งหมด";}else if($xtype == "all"){ $xtitle = "จำนวนบุคลากรทั้งหมด";}else if($xtype == "mainpage"){ $xtitle = "รายชื่อบุคลากรที่เอกสารไม่มีปกหน้า";}else{ $xtitle = "รายชื่อบุคลากรที่เอกสารต้นฉบับไม่สมบูรณ์";}
?>
   <tr>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="8" bgcolor="#A8B9FF"><strong> <?=$xtitle."".show_area($sentsecid);?></strong>
		
		<? $xsc =get_school($schoolid,$sentsecid);

		echo $xsc['schoolname']   ;
		?> 
		</td>
        </tr>
      <tr>
        <td width="2%" align="center" bgcolor="#A8B9FF"><strong>ลำ<br>
          ดับ</strong></td>
        <td width="9%" align="center" bgcolor="#A8B9FF"><strong>รหัสบัตร</strong></td>
        <td width="7%" align="center" bgcolor="#A8B9FF"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="8%" align="center" bgcolor="#A8B9FF"><strong>ชื่อ</strong></td>
        <td width="11%" align="center" bgcolor="#A8B9FF"><strong>นามสกุล</strong></td>
        <td width="15%" align="center" bgcolor="#A8B9FF"><strong>ตำแหน่ง</strong></td>
        <td width="14%" align="center" bgcolor="#A8B9FF"><strong>สังกัด</strong></td>
        <td width="34%" align="center" bgcolor="#A8B9FF"><strong>ปัญหาเอกสารไม่สมบูรณ์</strong></td>
      </tr>
      <?
	if($schoolid != ""){
		  $conS = " AND schoolid='$schoolid'";
	}else{
		$conS = "";	
	}
	if($xtype == "wait"){
		$conW = " WHERE status_check_file='NO' AND siteid='$sentsecid' AND status_numfile='1'  ";	
	}else if($xtype == "complate"){
		$conW = " WHERE status_file='1' and status_check_file='YES' AND siteid='$sentsecid' and (mainpage IS NULL  or mainpage='' or mainpage='1')  AND  status_id_false='0' AND  status_numfile='1' ";
	}else if($xtype == "checkall"){
		$conW = " WHERE status_check_file='YES'  AND siteid='$sentsecid'";
	}else if($xtype == "all"){
		$conW = 	" WHERE siteid='$sentsecid' ";
	}else if($xtype == "mainpage"){
		$conW = 	" WHERE status_check_file='YES' and mainpage ='0' AND status_file='1' AND siteid='$sentsecid'  AND  status_id_false='0' AND  status_numfile='1'";
	}else{
		$conW = 	" WHERE status_check_file='YES' AND status_file='0' AND siteid='$sentsecid'  AND  status_id_false='0' AND  status_numfile='1' ";
	}// status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0'
	
	$con1 = " AND profile_id='$profile_id'";
	
      $sql = "SELECT * FROM tbl_checklist_kp7  $conW $conS $con1";
	  //echo $sql;
	  $result = mysql_db_query($dbtemp_check,$sql);
	  $i=0;
	  while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}	
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]";?></td>
        <td align="left"><? echo "$rs[name_th]";?></td>
        <td align="left"><? echo "$rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo show_school($rs[schoolid]);?></td>
        <td align="left">
 <?
	if($xtype != "mainpage" and $xtype != "complate"){
?>	
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#000000">
		
			<table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="38%" align="center" bgcolor="#A8B9FF"><strong>หมวดปัญหา</strong></td>
                <td width="62%" align="center" bgcolor="#A8B9FF"><strong>รายละเอียดปัญหา</strong></td>
                </tr>
                <?
					if($rs[mainpage_comment] != ""){
							echo " <tr bgcolor=\"#FFFFFF\">
                <td align=\"left\">ปกเอกสาร ก.พ.7 ต้นฉบับ</td>
                <td align=\"left\">$rs[mainpage_comment]</td>
                </tr>";
					}
				
                	$sql_detail = "SELECT * FROM tbl_checklist_problem_detail WHERE idcard='$rs[idcard]' AND profile_id='$profile_id'  AND status_problem = 0   ORDER BY menu_id,problem_id  ASC";
					$result_detail = mysql_db_query($dbtemp_check,$sql_detail);
					$j=0;
					while($rs_d = mysql_fetch_assoc($result_detail)){
						if ($j++ %  2){ $bg1 = "#F0F0F0";}else{$bg1 = "#FFFFFF";}	
				?>
              <tr bgcolor="<?=$bg1?>">
                <td align="left"><? echo GetTypeMenu($rs_d[menu_id])." => ".GetTypeProblem($rs_d[problem_id]);?></td>
                <td align="left"><?=$rs_d[problem_detail]?></td>
                </tr>
               <?
					}//end while(){
			   ?>
            </table>            
            </td>
          </tr>
        </table>
                        <?
					}else{
						echo " $rs[mainpage_comment]";	
					}
			?>

        </td>
      </tr>
     <?
     	}//end   while($rs = mysql_fetch_assoc($result)){
	 ?>
    </table>    
    </td>
  </tr>
 <? } //end ?>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</body>
</html>
