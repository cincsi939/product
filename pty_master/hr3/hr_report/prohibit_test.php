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
//			 echo "<pre>";
//			 print_r($_POST);
//			 echo "yy=".$xmm1."<br>";
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
<script type="text/javascript" src="../../../common/calendar_list.js"></script>
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
	} else {
		return true;
	}
	
}		
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
              <select name="dd" id="dd" onChange="check_date('dd','xmm1','yy');">  </select>
			 
		<?
  /*	          <option value="00">����к�</option>
				for($d = 1; $d < 32;$d++){
				$xdd = sprintf("%02d",$d);
					if($xdd == $arr1yy[2]){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
					echo "<option value=\"".sprintf("%02d",$d)."\" $sel1>". sprintf("%02d",$d) ."</option>";
				}*/
			?>
          

<select name="xmm1" id="xmm1" onChange="check_date('dd','xmm1','yy');">  </select> 

<?
/*<option value="00">����к� </option>
	for($m = 1; $m < 13; $m++){
		$xmm = sprintf("%02d",$m);
		if($xmm == $arr1yy[1]){ $sel2 = "selected='selected'";}else{ $sel2 = "";}
		echo "<option value=\"".sprintf("%02d",$m)."\" $sel2>".$month[$m]."</option>";
	}*/
?>
          

				  <select name="yy" id="yy" onChange="check_date('dd','xmm1','yy');"></select>
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
                 
                  <script>
	create_calendar('dd','xmm1','yy','<?=$arr1yy[2]?>','<?=$arr1yy[1]?>','<?=$arr1yy[0]?>');
</script> 
				 	&nbsp;&nbsp;<input type="text" name="label_yy" value="<?=$rs[label_yy]?>">
				 <span class="style6"><br>
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
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="left" valign="top"><label>
				    <input name="kp7_active" type="radio" value="1" checked="checked" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
				    �ʴ���� �.�. 7
				  </label>
				    <label>
				    <input name="kp7_active" type="radio" value="0" <? if($rs[kp7_active]=="0"){ echo "checked";}?>>
				    ����ʴ���� �.�. 7				    </label></td>
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