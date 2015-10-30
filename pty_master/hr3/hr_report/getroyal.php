<?
					session_start();
					//	include ("../../../inc/conndb_nonsession.inc.php")  ;
						include ("../../../common/std_function.inc.php")  ;
						unset($_SESSION[checkusr]);


#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_getroyal";
$module_code 		= "getroyal"; 
$process_id			= "getroyal";
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
if ($runid != ""){ $getrunid = $runid ; } 
if($_SERVER[REQUEST_METHOD] == "POST"){

	     $sqlgen="select  *  from  general   where id='$id'";
	   $relult=mysql_query($sqlgen);
	   while($ros=mysql_fetch_array($relult)){

		   $begindate=$ros['begindate'];
	   }

add_log("ข้อมูลเครื่องราชอิสรยาภรณ์",$id,$action);


	        $d=explode("/", $_POST['txtdate']);
			$date =$d[2]."-".$d[1]."-".$d[0];
			/*
		    $e=explode("/", $_POST['txtgetdate']);
			$date2 =$e[2]."-".$e[1]."-".$e[0];
*/
//$date 	= $getyear.'-'.$getmonth.'-'.$getday;
$date2 	= $subyear.'-'.$submonth.'-'.$subday;

if($_POST[action]=="edit2"){

          if($date<=$begindate)
				   { 
					 echo "
					<script language=\"javascript\">
					alert(\"วันที่ได้รับและวันส่งคืน ต้องไม่น้อยกว่าวันที่รับราชการ\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
	$sql = " update getroyal set date='$date', getroyal='$list1_1', date2='$date2', no='$no', bookno='$bookno', book='$book', section='$section', ";
	$sql .= " page='$page',kp7_active='$kp7_active' where id ='$id' and  runid='$runid'; ";


	mysql_query($sql);
				   }
	if(mysql_errno()){
		$msg = "Cannot update parameter information.";
	} else {
				echo "
				<script language=\"javascript\">
				alert(\"ทำการปรับปรุงข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
	//	header("Location: ?id=$id&action=edit");
		exit;
	}						
					
} else if($_POST[action]=="edit3") {

	foreach($_POST as $key => $val){
		$ch = substr($key,0,1);
		if($ch=="_"){
			$ep = explode("_",$key);
			mysql_query("UPDATE `getroyal` SET `orderid`='$_POST[$key]' WHERE (`id`='$ep[1]') AND (`runid`='$ep[2]')  ");
		}
	}

}else{
	
	               if($date<=$begindate)
				   { 
					 echo "
					<script language=\"javascript\">
					alert(\"วันที่ได้รับและวันส่งคืน ต้องไม่น้อยกว่าวันที่รับราชการ\\n \");
					location.href='?id=$id&action=edit';
					</script>
				     ";
				   }else {
	$sql = "  SELECT  orderid  FROM `getroyal` WHERE `id` = '$id' ORDER BY `orderid` DESC LIMIT 0,1  ";				   
	$result = @mysql_query($sql) ; 
	$rs = @mysql_fetch_assoc($result) ; 
	$neworder  = 	 $rs[orderid] +1 ; 

	$sql 		= "insert into getroyal set id='$id', date='$date', getroyal='$list1_1', date2='$date2', no='$no', bookno='$bookno', ";
	$sql		.= " book='$book', section='$section',kp7_active='$kp7_active', page='$page' , orderid=$neworder ; ";
	$result  = mysql_query($sql);


				   }
	if($result){

			echo "
				<script language=\"javascript\">
				alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit';
				</script>
				";
		//header("Location: ?id=$id&action=edit");
		exit;
	
	} else {	
		echo "ไม่สามารถบันทึกข้อมูลได้ "  .__LINE__.  mysql_error()   ;}
	}				

} else if ($_GET[action] == 'delete') {

	add_log("ข้อมูลเครื่องราชอิสรยาภรณ์",$id,$action);
	mysql_query("delete from getroyal where id = $id and runid='$runid';");
	if (mysql_errno()){
		$msg = "Cannot delete parameter."  .__LINE__.  mysql_error()   ;
	} else {
		  echo"<meta http-equiv='refresh' content='0;URL=getroyal.php'>";
		header("Location: ?id=$id&action=edit");
		exit;
	}
	
}else {		

	$sql 		= "select * from  general where id='$id'  ;";
	$result 	= mysql_query($sql);
	if ($result) {
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
	} else {
		$msg = "Cannot find parameter information."  .__LINE__.  mysql_error()   ;
		echo $msg;
	}
}	

if($action == "edit2"){

		$sql 		= "select * from getroyal where id='$id' and runid= '$runid' ;";
		$result 	= mysql_query($sql);
		$rs		= mysql_fetch_assoc($result);	

}

?>
<html>
<head>
<title>การรับพระราชทางเครื่องราชอิสริยาภรณ์</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>

<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style2 {color: #FFFFFF}
-->
</style>

<!-- send id to menu flash -->
<script language=javascript>
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->

     var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList() {
   var provid = document.getElementById("list1").value;
    if(provid == "" ) {
        clearproductList();
        return;
    }
    var url = "getroyal_ajax.php?runid=" + provid;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList();
        }
    }
}

function updateproductList() {
    clearproductList();
    var secname = document.getElementById("list1_1");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
	
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");			
           option = document.createElement("option");
		   
		  if(x[1] == "<?=$rs[getroyal]?>"){ 
		 //option.options[i].selected = true; // works
		 option.setAttribute("selected","selected");
		 }

		   option.setAttribute("value",x[1]);

           option.appendChild(document.createTextNode(x[0]));
           secname.appendChild(option);
	}
    }
}
function clearproductList() {
    var secname = document.getElementById("list1_1");
    while(secname.childNodes.length > 0) {
              secname.removeChild(secname.childNodes[0]);
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
          <td  valign="top"> <a href="kp7_getroyal.php?id=<?=$id?>" title="ตรวจสอบข้อมูล กพ.7"><br>
          &nbsp; <img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" > ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </a><br>
            
              <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td align="left" valign="top" ><b>ชื่อ / สกุล &nbsp;&nbsp; 
                    &nbsp <u>
                    <?=$rs[prename_th]?>
                    <?=$rs[name_th]?>
                    <?=$rs[surname_th]?></u>
                    &nbsp;&nbsp; </b></td>
                </tr>
              </table>
              <br>
			  <form name=order_form  method = POST  action = "<?  echo $PHP_SELF ; ?>" >
			  <INPUT TYPE="hidden" name="action" value='edit3'>
			  <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
              <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
                <tr bgcolor="#A3B2CC" align="center">
                  <td colspan="9" bgcolor="#2C2C9E"><span class="style1">เครื่องราชอิสริยาภรณ์</span></td>
                </tr>
                <tr bgcolor="#A3B2CC" align="center"> 
				  <td width="80"><strong>เรียงลำดับ</strong></td>
                  <td width="260"><strong>เครื่องราช/เหรียญตรา</strong></td>
                  <td width="139"><strong>วันเดือนปี ที่ได้รับ</strong></td>
                  <td width="86">ลำดับที่</td>
                  <td width="86">เล่มที่</td>
                  <td width="85">เล่ม</td>
                  <td width="89">ตอน</td>
                  <td width="88">หน้า</td>
                  <td><a href="getroyal.php">เพิ่มข้อมูลอีก</a></td>
                </tr>
                <?
	$i=0;
	$result1 = mysql_query("select * from getroyal  where id='$id' order by orderid,date ASC");
	$rayalrow = mysql_num_rows($result1);
	//$rayalrow = $rayalrow +1 ; 
	while ($rs1=mysql_fetch_array($result1,MYSQL_ASSOC)){
		$i++;
		if ($i % 2) {
		$bg = "#EFEFEF";
		}else{
		$bg = "#DDDDDD";
		}
		$runid = $rs1[runid];
		$xrunid = $rs1[runid];		
?>
                <tr bgcolor="<?=$bg?>"> 
				<td><? //<SELECT NAME="<?=("_".$id."_".$runid);?>
				<?
				/*
				for($g=1;$g<=$rayalrow;$g++){
							$sl = "";
						if($g==$rs1[orderid]){
							$sl = "selected=selected";
						}
						echo "<option value=$g $sl>$g</option>";
					}	
		</SELECT>		*/?>
						<select name="<?=("_".$id."_".$runid);?>">
<?
for($g=1;$g<=$rayalrow;$g++){
	$selected = ($g == $i) ? " selected " : "" ;
	echo "<option value=\"".$g."\" ".$selected.">".$g."</option>";
}
?>	
	</select>
				</td>
                  <td align="center"> 
                    <?=$rs1[getroyal]?>                  </td>
                  <td align="center">  
                    <?=MakeDate($rs1[date]);?>                  </td>
                  <td align="center">&nbsp;<?=$rs1[no]?></td>
                  <td align="center">&nbsp;<?=$rs1[bookno]?></td>
                  <td align="center">&nbsp;<?=$rs1[book]?></td>
                  <td align="center">&nbsp;<?=$rs1[section]?></td>
                  <td align="center">&nbsp;<?=$rs1[page]?></td>
                  <td width="75" align="center"> <a href="<?  echo $PHP_SELF ; ?>?id=<?=$rs1[id]?>&runid=<?=$rs1[runid]?>&action=edit2"><img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
                    &nbsp; <a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs1[id]?>&runid=<?=$rs1[runid]?>';" ><img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>                  </td>
                </tr>
                <?
	} //while

// List Template
?>
<tr bgcolor="#A3B2CC" align="center">
<td colspan=9 align=left><INPUT TYPE="submit" value='เรียงลำดับ'></td>
</tr>
              </table>
			  </form>
<?

$e=explode("-",$rs['date']);
$date=$e[2]."/".$e[1]."/".$e[0];

$d=explode("-",$rs['date2']);
$date2=$d[2]."/".$d[1]."/".$d[0];
?>

              <br>
	  <form  method = POST  action = "<?  echo $PHP_SELF ; ?>" >
	  <INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
	  <INPUT TYPE="hidden" NAME="runid" VALUE="<?=$getrunid?>">
	  <INPUT TYPE="hidden" NAME="action" VALUE="<?=$_GET[action]?>">
		<table width="100%" border="0" cellspacing="4" cellpadding="1" align="center">
		<? if ($_GET[action]=="edit2") {?>
              <tr> 
            <td align="right" valign="top" width="262">วันเดือนปี ที่ได้รับ</td>
            <td align="left" valign="top" width=\"612"> 
           <INPUT onfocus="blur();" readOnly name="txtdate" value="<?=$date ?>"> 
           <INPUT class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.txtdate, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี"></td>
            </tr>
			<? }else{ ?>
           <tr> 
            <td align="right" valign="top" width="262">วันเดือนปี ที่ได้รับ</td>
            <td align="left" valign="top" width="612"> 
           <INPUT onfocus="blur();" readOnly name="txtdate"  > 
           <INPUT class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.txtdate, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี"></td>
            </tr>
			  <? }?>
              <tr>
                <td height="25" colspan="2"><strong>&nbsp;&nbsp;&nbsp;</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="cordon_group1.php" target="_blank">เรียกดูรายละเอียดประเภทและชนิดของเครื่องราชย์/เหรียญตรา</a></td>
                </tr>
              <tr> 
<td height="25" align="right"><font color="red">*</font>ประเภทเครื่องราช&nbsp;</td>
<td><? 	

	$d=$rs[getroyal]; 
echo " <!---- $d  -----------> ";	

$xxx = explode("(" , $d ) ;
$d = trim($xxx[0])  ;
			$sql="SELECT * FROM  $dbnamemaster.cordon_list  WHERE name= '$d' ";
			
			$s=mysql_query($sql) or die(mysql_error());
			$ss=mysql_fetch_array($s);
			$list_name=$ss[name];
			$list_group=$ss[groupid];
			$group="select * from $dbnamemaster.cordon_group where runid='$list_group'";
			//echo "$group<hr>";
			$group_qurty=mysql_query($group)or die("cannot Query".mysql_error());
			$f_group=mysql_fetch_array($group_qurty);
			$G_name=$f_group[name];
			$G_id=$f_group[runid];
	
	
			?>
  <select name=list1 size=1 id=list1 onChange=refreshproductList();>
            <option value=0>ระบุประเภทเครื่องราชย์</option> 
<?  	 	 	$query_area = mysql_query(" SELECT  runid , name  FROM  $dbnamemaster.cordon_group  where runid<>9999 order by runid ") ;
			while($rs_area = mysql_fetch_assoc($query_area)){
		 	?> 
            <option value="<? echo $rs_area[runid]?>" <? if ( $rs_area[runid] == $G_id ){ echo " selected "; }  ?> > <? echo $rs_area[name]?> </option>
            <? }

			 ?>
       	    </select> 
<?       
			//echo " $list_name";
			echo "<script language=\"javascript\">";
			echo "refreshproductList();";
			echo "</script>";
	//***********เรียกใช้  	 function refreshproductList() เมื่อมีการ คลิกที่ edit2 เพื่อสั่งให้ refreshproductList() ทำงานอีกครั้งหนึ่ง*****

?> 
&nbsp;		  </td>
</tr>
<tr>
  <td height="25" align="right"><font color="red">*</font>ระบุชนิด</td>

  <td>
<select name='list1_1' id='list1_1'></select> </td>
</tr>
<tr>
	<td height="25" align="right">ลำดับที่&nbsp;</td>
	<td><input type="text" name="no" style="width:100px;" value="<?=$rs[no]?>"></td>
</tr>
<tr>
	<td height="25" align="right">เล่มที่&nbsp;</td>
	<td><input type="text" name="bookno" style="width:100px;" value="<?=$rs[bookno]?>"></td>
</tr>
<tr>
	<td height="25" align="right">เล่ม&nbsp;</td>
	<td><input type="text" name="book" style="width:100px;" value="<?=$rs[book]?>"></td>
</tr>
<tr>
	<td height="25" align="right">ตอน&nbsp;</td>
	<td><input type="text" name="section" style="width:100px;" value="<?=$rs[section]?>"></td>
</tr>
<tr>
	<td height="25" align="right">หน้า&nbsp;</td>
	<td><input type="text" name="page" style="width:100px;" value="<?=$rs[page]?>"></td>
</tr>
<tr>
  <td height="25" align="right">ให้รายการนี้แสดงผลใน ก.พ.7</td>
  <td><input name="kp7_active" type="radio" value="1" checked="checked" <? if($rs[kp7_active]=="1"){echo "checked";}?>>
แสดงผล
  <input name="kp7_active" type="radio" value="0" <? if($rs[kp7_active]=="0"){echo "checked";}?>>
ไม่แสดงผล</td>
</tr>
	<? if ($_GET[action]=="edit2") {
	
	  $d1=explode("-",$rs[date2]);
	?>
              <tr> 
            <td align="right" width="262">ลงวันที่</td>
            <td align="left"  width="612">
วันที่
  <select name="subday" >
 
    <?
	echo " <option   value=0 selected >ไม่ระบุ </option>";
for ($i=1;$i<=31;$i++){
	if (intval($d1[2])== $i){
		echo "<option SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option>" .  sprintf("%02d",$i) . "</option>";
	}
}
?>
  </select>
เดือน
<select name="submonth" >
  <?
  echo " <option value=0 selected >ไม่ระบุ </option>";
for ($i=1;$i<=12;$i++){
	if (intval($d1[1])== $i){
	
		echo "<option  SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option>" .  sprintf("%02d",$i) . "</option>";
	}
}
?>
</select>
ปี พ.ศ.
<select name="subyear" >

  <?
  echo " <option  value=0 selected >ไม่ระบุ </option>";
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y1;$i<=$y2;$i++){
	if ($d1[0]== $i){
		echo "<option SELECTED>$i</option>";
	}else{
		echo "<option>$i</option>";
	}
}
?>
</select></td>
              </tr>
			<? }else{?>
            <tr> 
            <td align="right"  width="262">ลงวันที่</td>
            <td align="left"  width="612"> 
	
	วันที่
  <select name="subday" >
    <?
	echo "<option value=0>"."ไม่ระบุ". "</option>";
for ($i=1;$i<=31;$i++){
	if (intval($d1[2])== $i){
		echo "<option >" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option>" .  sprintf("%02d",$i) . "</option>";
	}
}
?>
  </select>
เดือน
<select name="submonth" >
  <?
  	echo "<option value=0>"."ไม่ระบุ". "</option>";
for ($i=1;$i<=12;$i++){
	if (intval($d1[1])== $i){
		echo "<option >" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option>" .  sprintf("%02d",$i) . "</option>";
	}
}
?>
</select>
ปี พ.ศ.
<select name="subyear" >
  <?
  	echo "<option value=0>"."ไม่ระบุ". "</option>";
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y1;$i<=$y2;$i++){
	if ($d1[0]== $i){
		echo "<option >$i</option>";
	}else{
		echo "<option>$i</option>";
	}
}
?>
</select>
	
	
	
	
          <? // <INPUT onfocus="blur();" readOnly name="txtgetdate"  > 
           //<INPUT class="index2"style="FONT-SIZE: 11px; WIDTH: 80px" onClick="popUpCalendar(this, form.txtgetdate, 'dd/mm/yyyy')" type="button"value="วัน เดือน ปี"></td>
          //  </tr>
			 }?>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
<tr align="center"> 
	<td><input type="submit" name="send" value="  บันทึก  ">
	  <input type=button ONCLICK="location.href='getroyal.php' "  value="ยกเลิก" name="button" /></td>
</tr>
</table>
</form>
	</td>
</tr>
</table>      
	</td>
</tr>
</table>
<? include("licence_inc.php"); ?>
</body>
</html>
			<? 
			
			$time_end = getmicrotime(); writetime2db($time_start,$time_end);
			
		 ?>