<?php
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_prohibit";
$module_code 		= "prohibit"; 
$process_id			= "prohibit";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
include("../../../common/function_kp7_logerror.php");
$idcard=$_SESSION[idoffice];
$staffid=$_SESSION[session_staffid];
$time_start = getmicrotime();

//$id 		= (empty($_POST[id])) ? $_GET[id] : $_POST[id] ;
//$action 	= $_GET[action];

if($_SERVER[REQUEST_METHOD] == "POST"){

			if($action == "ChangRows"){

			for($i=0;$i<count($runno);$i++){
				$sql		= " update hr_prohibit set runno='".$runno[$i]."' where id='$id' and no='".$no[$i]."' ";		
				$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
				}
				echo"<meta http-equiv='refresh' content='0;URL=prohibit.php?id=$id&action=edit&vprohibit=1'>";
					exit;
		}	

add_log("�����š�����Ѻ�ɷҧ�Թ��",$id,$action);
	if ($comment){
		$yy = intval($yy);
		if ($_POST[action]=="edit2")
			 {
/*			 echo "<pre>";
			 print_r($_POST);
			 echo "yy=".$xmm1."<br>";die;
*/			
		if($yy == ""){
			$yy = "0000";	
		}
		if($xmm1 == ""){
				$xmm1 = "00";
		}
		if($dd == ""){
				$dd = "00";
		}
		$txt_yy = "$yy-$xmm1-$dd";
				$sql = "update  hr_prohibit set  yy='$txt_yy', comment='$comment', refdoc='$refdoc', kp7_active='$kp7_active',label_yy='$label_yy',prohibit_type='$prohibit_type' where no ='$no' and id ='$id' ;";
				//echo $sql;die;
				//$returnid = add_monitor_logbefore("hr_prohibit","no ='$no' and id ='$id'");
				mysql_query($sql);
				//add_monitor_logafter("hr_prohibit"," no ='$no' and id ='$id' ",$returnid);
				
				if (mysql_errno())
				{
					$msg = "�������ö��䢢�������"."__________".LINE."_________".mysql_error;
				}
				else
				{
					
		######################
		$temp_subject_error=explode("::",$_POST['subject_error']);
		$temp_value_key_error=explode("::",$_POST['value_key_error']);
		$temp_label_key_error=explode("::",$_POST['label_key_error']);
		$temp_submenu_id=explode("::",$_POST['submenu_id']);
		$numTemp=count($temp_subject_error);
		
		for($a=1;$a<$numTemp;$a++){
			save_kp7_logerror($idcard,$temp_subject_error[$a],get_real_ip(),'UPDATE',$temp_value_key_error[$a],$temp_label_key_error[$a],$staffid,$temp_submenu_id[$a]);
		}		
		######################
					echo "
				<script language=\"javascript\">
				alert(\"�ӡ�û�Ѻ��ا�������������\\n \");
				location.href='prohibit.php?id=$id&action=edit&vprohibit=1';
				</script>
				";
				//	header("Location: ?id=$id&action=edit");
					exit;
				}
									
					
			}else
				{
						if($yy == ""){
							$yy = "0000";	
						}
						if($xmm1 == ""){
								$xmm1 = "00";
						}
						if($dd == ""){
								$dd = "00";
						}
				
				 $txt_yy = "$yy-$xmm1-$dd";
				$strID="SELECT max(runno) as runno FROM hr_prohibit WHERE id='$id'";
				$ResultID=mysql_query($strID);
				$RsID=mysql_fetch_array($ResultID);
				$IDmax=$RsID[runno]+1;
				$sql = "INSERT INTO  hr_prohibit (id,yy,comment,refdoc,kp7_active,label_yy,runno,prohibit_type) VALUES ('$id','$txt_yy','$comment','$refdoc','$kp7_active','$label_yy','$IDmax','$prohibit_type')";
	//	echo $sql;
					
					//$returnid = add_monitor_logbefore("hr_prohibit","");
					$result  = mysql_query($sql);
					$max_idx = mysql_insert_id();
					//add_monitor_logafter("hr_prohibit"," no ='$max_idx' and id ='$id' ",$returnid);
				

					if($result)
					{
					
		######################
		$temp_subject_error=explode("::",$_POST['subject_error']);
		$temp_value_key_error=explode("::",$_POST['value_key_error']);
		$temp_label_key_error=explode("::",$_POST['label_key_error']);
		$temp_submenu_id=explode("::",$_POST['submenu_id']);
		$numTemp=count($temp_subject_error);
		
		for($a=1;$a<$numTemp;$a++){
			save_kp7_logerror($idcard,$temp_subject_error[$a],get_real_ip(),'INSERT',$temp_value_key_error[$a],$temp_label_key_error[$a],$staffid,$temp_submenu_id[$a]);
		}		
		######################
							echo "
							<script language=\"javascript\">
							alert(\"�ӡ�úѹ�֡�������������\\n \");
							location.href='prohibit.php?id=$id&action=edit&vprohibit=1';
							</script>
							";
					//	header("Location: ?id=$id&action=edit");
						exit;
					}else
					{	$msg= "�������ö�ѹ�֡�������� ";}
				}
				

	}else{ // if($comment)
		$msg = "��س��кآ�ͤ������¡��"."__________".LINE."_________".mysql_error;;
	}
	header("Location: ?id=$id&action=edit&msg=$msg");	
	exit;
}else if ($_GET[action] == 'delete')
	{
	add_log("�����š�����Ѻ�ɷҧ�Թ��",$id,$action);
		mysql_query("delete from hr_prohibit where no = $no and id='$id';");
		if (mysql_errno())
			{
			$msg = "Cannot delete parameter.";
			}else
			{
		//	header("Location: ?id=$id&action=edit");
						echo "<script language=\"javascript\">
						location.href='prohibit.php?id=$id&action=edit&vprohibit=1';
							</script>";
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
<title>������Ѻ�ɷҧ�Թ��</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style3 {color: #FFFFFF}
.style4 {
	color: #000000;
	font-weight: bold;
}
.style5 {color: #000000}
.style6 {color: #8C0000}
.style7 {font-weight: bold}
-->
</style>
<!-- send id to menu flash -->
<?php /*?><script type="text/javascript" src="../../../common/calendar_list.js"></script><?php */?>
<script>
var imgDir_path="../../../common/popup_calenda/images/calendar/";
</script>
<script src="../../../common/popup_calenda/popcalendar.js" type="text/javascript"></script>
<script src="../../../common/popup_calenda/function.js" type="text/javascript"></script>
<script language="javascript" src="jquery.js"></script>
<script src="../../../common/check_label_values/script.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../common/check_label_values/calendar_list.js"></script>
<script language=javascript>
addnone=1;
displaymonth='s';			
function check(){

if(document.post.yy.value.length==0){
			alert("�ô�кػ� �.�.");
			document.post.yy.focus();
			return false;
	}else if(document.post.prohibit_type.value == "0"){
		alert("�к���Ǵ�ɷҧ�Թ��");
		document.post.prohibit_type.focus();
		return false;
	}else if(document.post.comment.value.length==0){
		alert("�к���¡��");
		document.post.comment.focus();
		return false;
	}else if (document.post.chk_yy.value == 'false'){			
			if(!confirm("�ѹ��͹�����ç�Ѻ��ͧ�ʴ��� ��.7 ��ͧ��ô��Թ��õ���������")){
					document.post.subject_error.value="";
					document.post.value_key_error.value="";
					document.post.label_key_error.value="";
					document.post.submenu_id.value="";
					return false;
			}else{
					document.post.subject_error.value=document.post.subject_error.value+"::"+"�ѹ��͹�����ç�Ѻ��ͧ�ʴ��� ��.7";
					document.post.value_key_error.value=document.post.value_key_error.value+"::"+document.post.dd.value+"/"+document.post.xmm1.value+"/"+document.post.yy.value;
					document.post.label_key_error.value=document.post.label_key_error.value+"::"+document.post.label_yy.value;
					document.post.submenu_id.value=document.post.submenu_id.value+"::"+"7";
			}
	}else {
		return true;
	}
	
}		


$(document).ready(function() {
	path="../../../common/check_label_values/";
	check_true='<img src="'+path+'images/checked.gif" width="18" height="18" />';
	check_false='<img src="'+path+'images/unchecked.gif" width="18" height="18" />';
	
	$('#label_yy').after("<span id='msg_label_yy' class='span_check'></span>").blur(function(){check_values_label($(this).attr('id'),'value_yy','label','date',"chk_yy");});
	
});
</script>
</head>

<body bgcolor="#A3B2CC">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="left" valign="top"> &nbsp; <br>            &nbsp;<a href="kp7_prohibit.php?id=<?=$id?>" title="��Ǩ�ͺ������ ��.7"> <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > <span class="style5">��Ǩ�ͺ�͡��â����� �.�.7 ����硷�͹ԡ�� </span></a><br>
            <br>
         
              <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                <tr> 
                  <td align="left" valign="top" ><b> <span class="style3">&nbsp;<span class="style5">���� / ʡ�� &nbsp;&nbsp; <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?>
                    </u></span></span></b> </td>
                </tr>
              </table>
              <br>
              <? if($vprohibit==1)
			  {?>
 &nbsp; &nbsp; &nbsp;<span class="style4">��. ������Ѻ�ɷҧ�Թ��
              </span><br>
			  
			  	<form name="post" method="post" action="?">
				<input type="hidden" name="action" value="ChangRows">
				<input type="hidden" name="id" value="<?=$id?>">

              <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="black">
                
                <tr bgcolor="#999999" align="center">
                  <td width="100" bgcolor="#A3B2CC"><strong>���§�ӴѺ</strong></td> 
                  <td width="100" bgcolor="#A3B2CC"><strong>�.�.</strong></td>
                  <td bgcolor="#A3B2CC"><strong>��¡��</strong></td>
				  <td bgcolor="#A3B2CC"><strong>�͡�����ҧ�ԧ</strong></td>
                  <td bgcolor="#A3B2CC"><input type="button" name="add2" value="����������" onClick="location.href='prohibit.php?id=<?=$id?>&action=edit2s' "></td>
                </tr>
                <?
				$i=0;
				$result = mysql_query("select * from hr_prohibit where id='$id' order by runno asc");
				$row=mysql_num_rows($result);
				while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
					$i++;
					if ($i % 2) {
						$bg = "#FFFFFF";
					}else{
						$bg = "#F0F0F0";
					}
					
					if($rs[label_yy] !=""){
					 $yyy= $rs[label_yy];
					 }else{
					 	$arr_yy = explode("-",$rs[yy]);
							if($rs[yy] == "0000-00-00"){
								$yyy="";
							}else{
								if($arr_yy[0] > 0 and $arr_yy[1] > 0 and $arr_yy[2] > 0){
									$yyy = intval($arr_yy[2])." ".$month[intval($arr_yy[1])]." ".$arr_yy[0];
								}else if($arr_yy[0] > 0 and $arr_yy[1] > 0 and $arr_yy[2] < 1){
									$yyy = $month[intval($arr_yy[1])]." ".$arr_yy[0];
								}else if($arr_yy[0] > 0 and $arr_yy[1] < 1 and $arr_yy[2] < 1){
									$yyy = $arr_yy[0];
								}else{
									$yyy = "";
								} // end if($arr_yy[0] > 0 and $arr_yy[1] > 0 and $arr_yy[2] > 0){
							} // end if($rs[yy] == "0000-00-00"){
					 }//end if($rs[label_yy] !=""){
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
                  <td> 
                    <?=$yyy?>                  </td>
                  <td align="left"> 
                    <?=$rs[comment] ?>                  </td>
				  <td align="left">
					<?=$rs[refdoc]?>				  </td>
                  <td width="120"><a href="prohibit.php?id=<?=$rs[id]?>&no=<?=$rs[no]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> &nbsp; <a href="#" onClick="if (confirm('�س�зӡ��ź��������ǹ�����������!!')) location.href='?action=delete&id=<?=$rs[id]?>&no=<?=$rs[no]?>';"><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a> </td>
                </tr>

                <?
	} //while
// List Template
?>                <tr align="center" bgcolor="<?=$bg?>">
                  <td colspan="5"><input type="submit" value="�ѹ�֡������§�ӴѺ����ʴ���� �.�.7">
                    <input type="button" name="viewdata2" value="��Ѻ˹���á" onClick="location.href='prohibit_all_1.php?action=edit' ">				  </td>
                  </tr>
              </table>
	</form>		  
              <?
			  }
			  else
			  {

If ($_GET[action]=="edit2")
{
		$sql = "select * from hr_prohibit where no='$no' and id = '$id'   ;";
		$result = mysql_query($sql);
		if ($result)
		{
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		}


}


$arr1yy = explode("-",$rs[yy]);
?>
              <br>
			     <form name="post" method="post" action="<?=$PHP_SELF?>" onSubmit="return check();">
              <INPUT TYPE="hidden" NAME="no" VALUE="<?=$no?>">
              <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
              <table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
                <tr> 
                  <td align="right" valign="top" width="261"><font color="red">*</font><B>�ѹ��͹��</B></td>
                  <td align="left" valign="top" width="613"> 
              <select name="dd" id="dd" >  </select>
			 
		<?
  /*	          <option value="00">����к�</option>
				for($d = 1; $d < 32;$d++){
				$xdd = sprintf("%02d",$d);
					if($xdd == $arr1yy[2]){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
					echo "<option value=\"".sprintf("%02d",$d)."\" $sel1>". sprintf("%02d",$d) ."</option>";
				}*/
			?>
          

<select name="xmm1" id="xmm1">  </select> 

<?
/*<option value="00">����к� </option>
	for($m = 1; $m < 13; $m++){
		$xmm = sprintf("%02d",$m);
		if($xmm == $arr1yy[1]){ $sel2 = "selected='selected'";}else{ $sel2 = "";}
		echo "<option value=\"".sprintf("%02d",$m)."\" $sel2>".$month[$m]."</option>";
	}*/
?>
          

				  <select name="yy" id="yy"></select>
                  <?
						/*$thisyear = date("Y") + 543;
						echo "<option value=''>����к�</option>";
						for ($i=$thisyear;$i>=2470;$i--){
							if ($arr1yy[0] == $i){
								echo "<option value='$i' selected>$i</option>";
							}else{
								echo "<option value='$i'>$i </option>";
							}
						}*/
						   
				 ?>
	<input  type="hidden" name="value_yy"  id="value_yy" value=""  />
	
				 	&nbsp;&nbsp;<input type="text" name="label_yy" id="label_yy" value="<?=$rs[label_yy]?>">
                    <input  type="hidden" name="chk_yy"  id="chk_yy" value="true"  />
      <script>
				  generate_calendarlist('value_yy','label_yy','dd','xmm1','yy','<?=$arr1yy[2]?>','<?=$arr1yy[1]?>','<?=$arr1yy[0]?>');
	<?php /*?>create_calendar('dd','xmm1','yy','<?=$arr1yy[2]?>','<?=$arr1yy[1]?>','<?=$arr1yy[0]?>');<?php */?>
</script> 
				 <span class="style6">
				 
				 <br>
				 �ҡ��ҹ�ѹ�֡㹪ͧ�ʴ��� ��.7 �к��йӢ����Ź���ʴ���� ��.7 ᷹</span></td>
                </tr>
                <tr>
                  <td align="right" valign="top"><span class="style7"><font color="red">*</font>��Ǵ�ɷҧ�Թ��  </span></td>
                  <td align="left" valign="top"><label>
            <select name="prohibit_type">
			<option value="0">�к���Ǵ</option>
			<?
				$sql_pt = "SELECT * FROM hr_prohibit_type ORDER BY  orderby ASC";
				$result_pt = mysql_db_query($dbnamemaster,$sql_pt);
				while($rs_pt = mysql_fetch_assoc($result_pt)){
					if($rs_pt[runid] == $rs[prohibit_type]){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
					echo "<option value='$rs_pt[runid]' $sel1>$rs_pt[prohibit_type]</option>";
				}
			?>
            </select>
                  </label></td>
                </tr>
                <tr> 
                  <td align="right" valign="top" width="261"><B><font color="red">*</font>��¡��</B></td>
                  <td align="left" valign="top" width="613"> <textarea name="comment" ROWS="7" COLS="60"><?=$rs[comment]?></textarea>				  </td>
                </tr>
				<tr>
					<td align="right" valign="top" width="261"><B>�͡�����ҧ�ԧ</B></td>
					<td align="left" valign="top" width="613">
						<input type="text" name="refdoc" size="60" value="<?=$rs[refdoc]?>">				  </td>
				</tr>
				<tr>
				  <td align="right" valign="top">&nbsp;<input type="hidden" name="kp7_active" value="1" size="60" ></td>
				  <td align="left" valign="top"><label>
				    <input name="kp7_active1" type="radio" value="1" disabled checked="checked" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
				    �ʴ���� �.�. 7
				  </label>
				    <label>
				    <input name="kp7_active1" type="radio" value="0" disabled <? if($rs[kp7_active]=="0"){ echo "checked";}?>>
				    ����ʴ���� �.�. 7				    </label>
                    
     <input name="submenu_id" id="submenu_id" type="hidden" size="50" value="" >
    <input name="subject_error" id="subject_error" type="hidden" size="50" value="" >
    <input name="value_key_error" id="value_key_error" type="hidden" size="50" value="" >
    <input name="label_key_error" id="label_key_error" type="hidden" size="50" value="" >
                    </td>
			    </tr>
              </table>
			  <BR><BR>
              <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
                <tr valign="middle"> 
                  <td align="center" colspan=2><input type="submit" name="send" value="  �ѹ�֡  ">
                    <input type="button" name="add" value="¡��ԡ" onClick="location.href='prohibit.php?id=<?=$id?>&action=edit&vprohibit=1' ">
                    <input type="button" name="viewdata" value="��Ѻ˹���á" onClick="location.href='prohibit_all_1.php?action=edit' "></td>
                </tr>
              </table>
            </form><? }?>
            <p>&nbsp;</p>
            <p>&nbsp;</p>          </td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>