<?php
//include ("session.inc.php");
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_specialduty";
$module_code 		= "specialduty"; 
$process_id			= "specialduty";
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
//include ("checklogin.php");
//include ("phpconfig.php");
//conn2DB();
if ($_SERVER[REQUEST_METHOD] == "POST"){
	if($action=="changeRow"){
		for($i=0;$i<count($runno);$i++){
			$sql		= " update hr_specialduty set runid='".$runno[$i]."' where id='$id' and no='".$no[$i]."' ";		
			$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
		}
//		header("Location: ?id=$id");
		echo"<meta http-equiv='refresh' content='0;URL=specialduty.php?action=edit'>";
		exit;
	}
add_log("ข้อมูลการปฏิบัติราชการพิเศษ",$id,$action);
/*
#######################################################################  Start คำนวณจำนวน วัน				
function find_dayofmonth($mm , $yy ){ 
	 $mm = (int) $mm ; 
	$arr_mm = array("","31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");	 
	$ddreturn = $arr_mm[$mm] ; 
	 if ($mm == 2 ){ 
	 	$yytmp = $yy % 4  ;
		if ($yytmp == 0 ){ $ddreturn = 29 ; }else{ $ddreturn = 28 ; } 
	 }
	  return $ddreturn ; 
} #### fucntion find_dayofmonth($mm){ 
	$dds = $double_start_day ; 	$mms = $double_start_month ; 	$yys = $double_start_year ; 
	$ddEnd = $double_end_day ; 	$mmEnd = $double_end_month ; 	$yyEnd = $double_end_year ; 

	# SELECT DATEDIFF('1997-11-30 23:59:59','1997-12-31');
# echo "<br>   เริ่มต้น ========   $dds   :::   $mms      :::  $yys   ";	
# echo "<br>   สิ้นสุด  ========   $ddEnd   :::   $mmEnd      :::  $yyEnd   ";	
	#=========> เช็ควัน 
	if ($dds < $ddEnd){  ######### เช็ควันที่ start น้อยกว่า วันที่ สิ้นสุดหรือไม่
		$ddtotal = $ddEnd - $dds    ; 
		$mm_1 = 1 ; 
	}else{	 ################### วันที่ start น้อยกว่าวันที่ สิ้นสุด ตัวแปร  $mm_1 เก็บ ไว้ เพื่อ ลบ เดือนออก 1 
		$ddinmonth = find_dayofmonth($mms , $yys ) ; 
		$ddtotal = $ddinmonth-$dds  + $ddEnd  ;  
		$mm_1 = 2 ; 		 		
	} ##### END if ($dds < $ddEnd){  
#		echo "<br><br>บรรทัดที่ ". __LINE__  . " <br><br> ddinmonth ::  $ddinmonth   |||||| ddtotal ::  $ddtotal  ||| mm_1 :$mm_1    ";	
	if ($mms < $mmEnd){ 	 ################ เดือนเิริ่มต้น น้อยกว่า เดือน สิ้นสุดหรือไม่
		$mmtotal = $mmEnd - $mms - $mm_1 ; $mm = $mmtotal  ; 
		$yy_1 = 0 ; 
	}else{ 	 ################### เดือนเิริ่มต้น มากกว่า เดือนสิ้นสุด 
		$mm_toendyear =  12- $mms ;  ########### เหลืออีกกี่เดือน จะหมด ปี
		$mmtotal = $mm_toendyear + $mmEnd  - $mm_1; 
		$yy_1 = 1 ; 
	}##### END if ($mms < $mmEnd){ 	
	$yytotal = $yyEnd - $yys - $yy_1; 
	############# จำนวนที่ลาทั้งหมด  $ddtotal  วัน  $mmtotal  เดือน $yytotal	 ปี 
# 	echo "    จำนวนที่ลาทั้งหมด  $ddtotal  วัน  $mmtotal  เดือน $yytotal	 ปี       ";
# die; 	
####  double_duty double_sick 
$totalduty = $double_duty  + $double_sick  ;  
#ได้จำนวนวันทั้งหมดแล้ว  
#######################################################################  Start คำนวณจำนวน วัน
*/

	if ($comment){
		$yy = intval($yy);

			 if ($_POST[action]=="edit2")
			 {
	$ddtotal = $double_getdd ;  $mmtotal = $double_getmm ; 	$yytotal = $double_getyy ; 
if ($doubletime == "double"){ 

	$start_date = $double_start_year ."-". "$double_start_month"  ."-". "$double_start_day" ; 
	$end_date = $double_end_year ."-". "$double_end_month"  ."-". "$double_end_day" ; 




$sql = "update  hr_specialduty set  
  yy='$yy', comment='$comment' ,kp7_type='$kp7_type' ,kp7_active='$kp7_type'  ,double_start='$start_date' , double_end='$end_date' ,    double_sick='$double_sick' ,   double_duty='$double_duty' ,
    double_getyy='$yytotal' ,double_getmm ='$mmtotal' ,double_getdd ='$ddtotal',double_type='$double_type'  
 where no ='$no' and id ='$id' ;";
}else{ ###### END if ($doubletime == "double"){  
$sql = "update  hr_specialduty set  yy='$yy', comment='$comment' ,kp7_type='$kp7_type'  ,kp7_active='$kp7_type',double_type='$double_type' where no ='$no' and id ='$id' ;";	
} ###### END if ($doubletime == "double"){  

			 
				
				$returnid = add_monitor_logbefore("hr_specialduty","no ='$no' and id ='$id'");
				mysql_query($sql);
				add_monitor_logafter("hr_specialduty","no ='$no' and id ='$id'",$returnid);
				
				if (mysql_errno())
				{
					$msg = "ไม่สามารถแก้ไขข้อมูลได้" . mysql_error() ;
				}
				else
				{
				echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
				}
									
					
			}else
				{

if ($doubletime == "double"){ 
	$ddtotal = $double_getdd ;  $mmtotal = $double_getmm ; 	$yytotal = $double_getyy ; 
	$start_date = $double_start_year ."-". "$double_start_month"  ."-". "$double_start_day" ; 
	$end_date = $double_end_year ."-". "$double_end_month"  ."-". "$double_end_day" ; 
	
####################################################################### END คำนวณจำนวน วัน	
	$sql = "
	INSERT INTO  hr_specialduty 
	(id,yy,comment,kp7_type  ,kp7_active ,double_type,double_start,double_end,
	double_sick,double_duty,double_getyy,double_getmm,double_getdd) 
	VALUES 
	('$id','$yy','$comment','$kp7_type','$kp7_type' , '$double_type' , '$start_date' , '$end_date' , 
	'$double_sick' ,'$double_duty' ,'$yytotal' , '$mmtotal' , '$ddtotal' 	)	
	"; 

# double_getdd 
}else{ ###### END if ($doubletime == "double"){  
	$strSQL="SELECT max(runid) as runid FROM hr_specialduty WHERE id='$id'";
	$Result=mysql_query($strSQL);
	$Rs=mysql_fetch_assoc($Result);
	 $runid_new=$Rs[runid]+1;
	$sql = "INSERT INTO  hr_specialduty (id,yy,comment,kp7_type,kp7_active,runid) VALUES ('$id','$yy','$comment','$kp7_type' ,'$kp7_type','$runid_new')";
} ###### END if ($doubletime == "double"){  

				$returnid = add_monitor_logbefore("hr_specialduty","");
				$result = mysql_query($sql)or die(" Line ". __LINE__ ."<hr>".mysql_error());
				$max_idx = mysql_insert_id();
				add_monitor_logafter("hr_specialduty","no ='$max_idx' and id ='$id'",$returnid);

					
#  echo "บรรทัดที่ :: " . __LINE__ ."::::: $sql "  ;	 die; 					
						if($result)
						{
						echo "
							<script language=\"javascript\">
							alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
							location.href='?id=$id&action=edit';
							</script>
							";
					//		header("Location: ?id=$id&action=edit");
							exit;
						}else
						{	$msg = "ไม่สามารถบันทึกข้อมูลได้ " . mysql_error() ;}

			}

	}else{ // if($comment)
		$msg = "กรุณาระบุข้อความในรายการ";
	}

}else if ($_GET[action] == 'delete')
	{
	add_log("ข้อมูลการปฏิบัติราชการพิเศษ",$id,$action);
		mysql_query("delete from hr_specialduty where no = $no and id='$id';");
		if (mysql_errno())
			{
			$msg = "Cannot delete parameter.";
			}else
			{
			header("Location: ?id=$id&action=edit");
			echo "<script language=\"javascript\">
							location.href='?id=$id&action=edit';
							</script>";
			exit;
			}

}
	

// แสดงข้อมูล

$sql = "select * from  general where id='$id'  ;";
$result = mysql_query($sql);
if ($result){
$rs=mysql_fetch_array($result,MYSQL_ASSOC);
} else {
	$msg = "ไม่พบข้อมูลที่ระบุ";
}
		
		
?>



<html>
<head>
<title>การปฏิบัติราชการพิเศษ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style3 {color: #000000}
.style4 {font-size: 11px}
.style5 {color: #8C0000}
-->
</style>
<!-- send id to menu flash -->
</style>
<script type="text/javascript" src="../../../common/calendar_list.js"></script>
<script language="javascript">
addnone=1;
displaymonth='l';	

function onSelect(val, divid){
	if(val == 0){
 		document.getElementById(divid).style.display	= 'none';  
	} else {
		document.getElementById(divid).style.display	= 'block';  
	}
} 


function check(){
	if(document.post.yy.value.length==0){
		alert("โปรดระบุปีพ.ศ.");
		document.post.yy.focus();
		return false;
	}else if(document.post.comment.value.length==0){
		alert("กรุณาระบุข้อความในรายการ");
		document.post.comment.focus();
		return false;
	}else{
		return true;
	}
	
}		


</script>

</head>

<body bgcolor="#A3B2CC">
<?
if ($msg){
?>
<CENTER><h2><FONT COLOR="red"><?=$msg?></FONT><BR>
    <input type=button value=" ย้อนกลับ " onClick="history.back();">
</h2>
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
          <td align="left" valign="top"> <br>            &nbsp;<a href="kp7_specialduty.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7" class="style3"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" ><span class="style3"> ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a><br>
            <br>

              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" ><b>ชื่อ / สกุล &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></b> </td>
                </tr>
              </table>
              <br>
<?
$arr_kp7str[] = ""; 
$arr_kp7str[0] = ""; 
$arr_kp7str[1] = "  <img src='../../../images_sys/check_green.gif' width='16' height='13'>  "; 


?>				  
              <table width="98%" border="0" align="center">
                <tr>
                  <td><span class="gcaption style4">๖. การปฏิบัติราชการพิเศษ</span></td>
                </tr>
              </table>
			  	<form name="changR" method="post" action="<?=$PHP_SELF?>">			
				<input type="hidden" name="action" value="changeRow">
				<input type="hidden" NAME="id" VALUE="<?=$id?>">
              <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="#000000">
                
                <tr bgcolor="#999999" align="center">
                  <td width="91" bgcolor="#A3B2CC"><strong>ลำดับที่</strong></td> 
                  <td width="99" bgcolor="#A3B2CC"><strong>พ.ศ.</strong></td>
                  <td width="443" bgcolor="#A3B2CC"><strong>รายการ</strong></td>
                  <td width="103" bgcolor="#A3B2CC">แสดงผลใน ก.พ. 7</td>
                  <td bgcolor="#A3B2CC">
<? 				  
#				  <input type="button" name="addstd" value="เพิ่มข้อมูล" onClick="location.href='specialduty.php?id=<?=$id?     >&action=edit2std' ">
?>				  
				  <input type="button" name="addspec" value="เพิ่มข้อมูล ราชการทวีคูณ" onClick="location.href='specialduty.php?id=<?=$id?>&action=edit2special' ">				  </td>
                </tr>
                <?

				$i=0;
				$result = mysql_query("select * from hr_specialduty where id='$id' order by runid ASC;");
				$row=mysql_num_rows($result);
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
					$i++;
					if ($i % 2) {
						$bg = "#FFFFFF";
					}else{
						$bg = "#F0F0F0";
					}
			?>
                <tr align="center" bgcolor="<?=$bg?>">
                  <td> <select name="runno[]">
                        <?
					for($e=1;$e<=$row;$e++){
						$selected = ($e == $i) ? " selected " : "" ;
						echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
							}
					?>
                      </select>
                    </label>
				  <input type="hidden" name="no[]" value="<?=$rs[no]?>">	</td> 
                  <td> 
                    <?=$rs[yy]?>                  </td>
                  <td align="left"> 
             <?=$rs[comment] ?>                  
			
 <?
# double_getyy,double_getmm,double_getdd
# echo "  <hr> จำนวนที่ลาทั้งหมด  $rs[double_getdd]  วัน  $rs[double_getmm]  เดือน $rs[double_getyy]	 ปี    " ; 
#  echo "  <hr> จำนวนที่ลาทั้งหมด  $rs[ddtotal]  วัน  $rs[mmtotal]  เดือน $rs[yytotal]	 ปี    " ;
 ?>			</td>
                  <td align="center"><?=$arr_kp7str[$rs[kp7_type]] ?></td>
                  <td width="196"><a href="specialduty.php?id=<?=$rs[id]?>&no=<?=$rs[no]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&no=<?=$rs[no]?>';"><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </td>
                </tr>

                <?
	} //while
// List Template
?>                <tr align="center" bgcolor="<?=$bg?>">
                  <td colspan="5" bgcolor="#FFFFFF"><input name="submit" type="submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7">
                  <input type="button" name="back2" value="กลับหน้าแรก" onClick="location.href='specialduty_all_1.php?id=<?=$id?>&action=edit' "></td>
                  </tr>
              </table>
			  	</form>
              <?

If ($_GET[action]=="edit2")
{
		$sql = "select * from hr_specialduty where no='$no' and id = '$id'   ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}


}
?>
              <br>
<?
if ($action != "edit" )   { 
?>		   <form name="post" method="post"action = "?id=<?=$id?>" onSubmit="return check();">
              <INPUT TYPE="hidden" NAME="no" VALUE="<?=$no?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">	  
              <table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr>
                  <td align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top"><input type="radio" name="kp7_type" value="1" checked="checked"<? if($rs[kp7_type]=="1"){ echo "checked";}?>>
                  แสดงผลใน ก.พ. 7&nbsp;
                  <input type="radio" name="kp7_type" value="0" <? if($rs[kp7_type]=="0"){ echo "checked"; }?>>
                  ไม่แสดงผลใน ก.พ. 7</td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="256"><font color="red">*</font> <B>พ.ศ.</B></td>
                  <td align="left" valign="top" width="618"> 
				  <select name="yy">
                  <?
						$thisyear = date("Y") + 543;
						echo "<option value=''>ไม่ระบุ</option>";
						for ($i=$thisyear;$i>=2470;$i--){
							if ($rs[yy] == $i){
								echo "<option value='$i' selected>$i</option>";
							}else{
								echo "<option value='$i'>$i</option>";
							}
						}
						   
				 ?>
				 </select>                  </td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="256"><B>รายการ</B></td>
                  <td align="left" valign="top" width="618"> 
				  <TEXTAREA NAME="comment" ROWS="7" COLS="60"><?=$rs[comment]?></TEXTAREA> 			  </td>
                </tr>
              </table>
              <?
#กด edit แล้วข้อมูลไม่ update 
#$rs[comment]
/*
$rs[double_type]
$rs[double_start]
$rs[double_end]
$rs[double_sick]
$rs[double_duty]
$rs[double_getyy]
$rs[double_getmm]
$rs[double_getdd]
*/
if  ($rs[double_type] <>"") { 
	$doubletiem_double = " checked  ";
	$doubletiem_double1 = " <script language=\"javascript\">  onSelect('1','SalAdj'); </scripit>    ";	
	# echo " <script language=\"javascript\">  document.getElementById(divid).style.display	= 'block';   </scripit> "; 	
}else{
	$doubletiem_no = " checked ";
}
?>
              <? 
# echo " ||||||| $rs[double_type]  ||||||| action:    $action ";
#  if  ($rs[double_type] =="") {    		 edit2special
#if  ($action == "edit2std" ) {      echo "  <div id='SalAdj' style=\"display:none;\">	 ";   $div1str = "</div>"; } 
#if  ($action == "edit2" ) {      echo "  <div id='SalAdj' style=\"display:none;\">	 ";   $div1str = "</div>"; } 
$allow_special  = "";
if  ($action == "edit2special" ) {     $allow_special  = "yes";    } 
if  (($action == "edit2" )and($rs[double_type] !=""))  {      $allow_special  = "yes";    } 
#  $allow_special  
# edit2special 
# edit2

if ( $allow_special   == "yes") { 
 ?>	
              <table width="90%" border="0" align="center">
                <tr>
                  <td colspan="3" align="center"> <span class="style5">**ข้อมูลเชิงสถิติ กรุณาระบุ**  </span></td>
                </tr>

                <tr>
                  <td width="17%" align="right">ประเภท</td>
                  <td colspan="2">
<?

//if ($action == "edit2special"){$ml_selected=" selected='selected' ";$std_selected="" ;}else{$std_selected=" selected='selected' ";$ml_selected="" ;}
if ($rs[double_type] == "Martial_Law"){ $ml_selected = " selected='selected' " ; $std_selected = ""; }else{$ml_selected = "" ;$std_selected=" selected='selected' "; } 
//if ($rs[double_type] == ""){ $std_selected = " selected='selected' " ; }else{$std_selected = "" ; } 

?> 
<select name="double_type" id="double_type">	
                    <option <?=$std_selected?>>ไม่นับเวลาทวีคูณ</option>			  	  
                    <option value="Martial_Law" <?=$ml_selected?> >กฎอัยการศึก</option>
	
                  </select>
                    <input name="doubletime" type="hidden" id="doubletime" value="double"></td>
                </tr>
                <tr>
                  <td align="right">ตั้งแต่</td>
                  <td colspan="2"><?
				  //DateInput_key($rs[double_start],"double_start","ไม่ระบุ");
				  $d1=explode("-",$rs[double_start]);
				  ?>
                  
                  วันที่
				    <select name="double_start_day"  id="double_start_day"  onChange="check_date('double_start_day','double_start_month','double_start_year');">
			        </select>
เดือน
<select name="double_start_month" id="double_start_month" onChange="check_date('double_start_day','double_start_month','double_start_year');">
</select>
ปี พ.ศ.
<select name="double_start_year"  id="double_start_year" onChange="check_date('double_start_day','double_start_month','double_start_year');">
</select>
<script>
	create_calendar('double_start_day','double_start_month','double_start_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
</script></td>
                </tr>
                <tr>
                  <td height="26" align="right">ถึง</td>
                  <td colspan="2"><?
				  //DateInput_key($rs[double_end],"double_end","ไม่ระบุ");
				  $d1=explode("-",$rs[double_end]);
				  ?>
                  
                  วันที่
				    <select name="double_end_day"  id="double_end_day"  onChange="check_date('double_end_day','double_end_month','double_end_year');">
			        </select>
เดือน
<select name="double_end_month" id="double_end_month" onChange="check_date('double_end_day','double_end_month','double_end_year');">
</select>
ปี พ.ศ.
<select name="double_end_year"  id="double_end_year" onChange="check_date('double_end_day','double_end_month','double_end_year');">
</select>
<script>
	create_calendar('double_end_day','double_end_month','double_end_year','<?=$d1[2]?>','<?=$d1[1]?>','<?=$d1[0]?>');
</script></td>
                </tr>
                <tr>
                  <td align="right">ลาป่วย </td>
                  <td width="16%"><input name="double_sick" type="text" id="double_sick" size="5" value="<?=$rs[double_sick]?>" > 
                  วัน </td>
                  <td width="67%">ลากิจ 
                    <input name="double_duty" type="text" id="double_duty" size="5" value="<?=$rs[double_duty]?>">
วัน </td>
                </tr>
<?
# if ($action != "edit2special"){ 
?>
                <tr>
                  <td align="right">คงเหลือเวลาราชการทวีคูณ </td>
                  <td colspan="2">
<? # disabled="disabled"  ?> 				  
				  <input name="double_getyy" type="text" id="double_getyy" size="5" value="<?=$rs[double_getyy]?>"  >
                    ปี 
                    <input name="double_getmm" type="text" id="double_getmm" size="5" value="<?=$rs[double_getmm]?>"  > 
                    เดือน 
                    <input name="double_getdd" type="text" id="double_getdd" value="<?=$rs[double_getdd]?>" size="5" > 
                    วัน </td>
                </tr>
<? #  } ####### if ($action != "edit2special"){   ?>
              </table>
<?  
#   echo   $div1str  ; 
} ################## END  if ( $allow_special   == "yes") {   
?>  
  <!-------------    </div>                <div id='SalAdj' style="display:none;">				    ----->  
              <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                <tr valign="middle"> 
                  <td align="center" colspan=2> 
                    &nbsp; 				  
                   			 <input type="submit" name="send" value="  บันทึก  "> &nbsp; 	
                     		<input type="reset" value="  ยกเลิก  " ONCLICK="location.href='specialduty.php?id=<?=$id?>&action=edit'"> 
                             <input type="button" name="viewdata3" value="กลับหน้าแรก" onClick="location.href='specialduty_all_1.php?id=<?=$id?>&action=edit' ">          </td>
                </tr>
              </table>
<? } # END if ($action== "edit" ){  ?> 			  
            </form>
<? /* 
ALTER TABLE `hr_specialduty` ADD `double_type` VARCHAR( 50 ) NOT NULL ,
ADD `double_start` DATE NOT NULL ,
ADD `double_end` DATE NOT NULL ,
ADD `double_sick` INT NOT NULL ,
ADD `double_duty` INT NOT NULL ,
ADD `double_getyy` INT NOT NULL ,
ADD `double_getmm` INT NOT NULL ,
ADD `double_getdd` INT NOT NULL ;			
*/  
?></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>