<?
	if($_SERVER['REQUEST_METHOD'] == "POST"){
			if($Aaction == "SAVE1"){ // บันทึกกรณีมีคนเดียว
				$sql_update = "UPDATE tbl_assign_key SET approve='2', comment_approve='$comment_approve1',staff_apporve='".$_SESSION['session_staffid']."' WHERE idcard='$idcard' AND siteid='$xsiteid'";
				//echo $sql_update."<br>";die;
				$result_update = mysql_db_query($db_name,$sql_update);
					if($result_update){
							echo "<script>alert('รับรองความถูกต้องของข้อมูลเรียบร้อยแล้ว'); location.href='?key_action=&action=browse_sys';</script>";
							exit();
					}
			}else if($Aaction == "SAVE2"){ // บันทึกกรณีมีหลายคน
				if(count($xapprove) > 0){
						foreach($xapprove as $key => $val){
							$sql_update = "UPDATE tbl_assign_key SET approve='2', comment_approve='$comment_approve[$key]',staff_apporve='".$_SESSION['session_staffid']."' WHERE idcard='$key' and siteid='$val' ";
							//echo $sql_update."<br>";
						mysql_db_query($db_name,$sql_update);
						}//end foreach($xapprove as $key => $val){
//die;
							echo "<script>alert('รับรองความถูกต้องของข้อมูลเรียบร้อยแล้ว'); location.href='?key_action=&action=browse_sys';</script>";
							exit();
				}//end if(count($xapprove) > 0){
			}// end if($Aaction == "SAVE1"){
			
	}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ตรวจสอบข้อผิดพลาดการบันทึกข้อมูล</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT SRC="../../../userentry/sorttable.js"></SCRIPT>

    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
    <script type="text/javascript">        
        var xmlHttp;
        var completeDiv;
        var inputField;
        var nameTable;
        var nameTableBody;
		var p;
		var name=new String();

        function createXMLHttpRequest() {
            if (window.ActiveXObject) {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            else if (window.XMLHttpRequest) {
                xmlHttp = new XMLHttpRequest();                
            }
        }

        function initVars() {
            inputField = document.getElementById("txtnames");            
            nameTable = document.getElementById("name_table");
            completeDiv = document.getElementById("popup");
            nameTableBody = document.getElementById("name_table_body");
        }

        function findNames() {
            initVars();
            if (inputField.value.length > 0) {
                createXMLHttpRequest();            
                var url = "CompleteData.php?names=" + inputField.value;                        
                xmlHttp.open("GET", url, true);
                xmlHttp.onreadystatechange = callback;
                xmlHttp.send(null);
            } else {
                clearNames();
            }
        }

        function callback() {
            if (xmlHttp.readyState == 4) {
                if (xmlHttp.status == 200) {
				    name =  document.getElementById("popup").innerHTML = xmlHttp.responseText;
					setNames();
                } else if (xmlHttp.status == 204){
                    clearNames();
                }
            }
        }
        
        function setNames() {         
           	p = name.split(",");  
            clearNames();
   	        var size = p.length;
            setOffsets();
            var row, cell, txtNode;
            for (var i = 0; i < size; i++) {
                var nextNode =p[i] 
                row = document.createElement("tr");
                cell = document.createElement("td");
                
                cell.onmouseout = function() {this.className='mouseOver';};
                cell.onmouseover = function() {this.className='mouseOut';};
                cell.setAttribute("bgcolor", "#FFFAFA");
                cell.setAttribute("border", "0");
                cell.onclick = function() { populateName(this); } ;                             

                txtNode = document.createTextNode(nextNode);
                cell.appendChild(txtNode);
                row.appendChild(cell);
                nameTableBody.appendChild(row);
				
            }
        }

        function setOffsets() {
            var end = inputField.offsetWidth;
            var left = calculateOffsetLeft(inputField);
            var top = calculateOffsetTop(inputField) + inputField.offsetHeight;

            nameTable.style.border = "black 1px solid";
            nameTable.style.left = left + "px";
            nameTable.style.top = top + "px";
            nameTable.style.width = end + "px";
        }
        
        function calculateOffsetLeft(field) {
          return calculateOffset(field, "offsetLeft");
        }

        function calculateOffsetTop(field) {
          return calculateOffset(field, "offsetTop");
        }

        function calculateOffset(field, attr) {
          var offset = 0;
          while(field) {
            offset += field[attr]; 
            field = field.offsetParent;
          }
          return offset;
        }

        function populateName(cell) {
            inputField.value = cell.firstChild.nodeValue;
            clearNames();
        }

        function clearNames() {
            var ind = nameTableBody.childNodes.length;
            for (var i = ind - 1; i >= 0 ; i--) {
                 nameTableBody.removeChild(nameTableBody.childNodes[i]);
            }
                 completeDiv.style.border = "none";
        }
		
		
function CheckFromSubmit(){

	var cnum = document.getElementById("num_checklist").value;	
		for(i=1;i <= cnum;i++){
				if( ((document.getElementById("xapprove"+i).checked == true) &&(document.getElementById("comment"+i).value == "")) && (document.getElementById("msgerr"+i).value != "")){
						alert("เนื่องจากผลการตรวจสอบการบันทึกข้อมูลจากระบบโดย script \nยังมีข้อมูลบางรายการที่ผิดพลาดอยู่ หากท่านต้องการยืนยันกรุณาใส่หมายเหตุการรับรองข้อมูลด้วย");
						document.getElementById("comment"+i).focus();
						return false;
				}
		}
	//alert(cnum);
	return true;
}
    </script>

</head>
<body>

  <br />
  <table width="98%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
          <td width="100%" align="right"><form id="form3" name="form3" method="post" action=""><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td colspan="3" align="left"><strong>ระบบตรวจสอบข้อมูลโดยระบบเพื่อยืนยันความถูกต้องของข้อมูล</strong></td>
  </tr>
  <tr>
    <td align="right"><strong>เขตพื้นที่การศึกษา : </strong></td>
    <td align="left"><label>
      <select name="key_siteid" id="key_siteid">
        <option value=""> เลือกเขตพื้นที่การศึกษา</option>
        <?
            	$sql_area = "SELECT
eduarea.secid,
eduarea.secname
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
group_type='keydata' ORDER BY eduarea.secname";
				$result_area = mysql_db_query($dbnamemaster,$sql_area);
				while($rs_a = mysql_fetch_assoc($result_area)){
					if($key_siteid == $rs_a[secid]){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$rs_a[secid]' $sel>$rs_a[secname]</option>";
				}
			?>
      </select>
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="33%" align="right"><strong>เลขบัตรประชาชน : </strong></td>
    <td width="34%" align="left"><label>
      <input name="key_idcard" type="text" id="key_idcard" size="25" value="<?=$key_idcard?>" />
    </label></td>
    <td width="33%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>ชื่อ : </strong></td>
    <td align="left"><label>
      <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>นามสกุล : </strong></td>
    <td align="left"><label>
      <input name="key_surname" type="text" id="key_surname" size="25" value="<?=$key_surname?>" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>วันที่คีย์ข้อมูล : </strong></td>
    <td align="left"><input name="date_key" onfocus="blur();" value="<?=$date_key?>" size="15" readonly="readOnly" />
      <input name="button" type="button"  onclick="popUpCalendar(this, form3.date_key, 'dd/mm/yyyy')"value="วันเดือนปี" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left"><label>
      <input type="submit" name="button" id="button" value="ค้นหา" />
      <input type="button" name="tbnC" value="ล้างค่า" onclick="location.href='?key_action=&amp;action=browse_sys'" />
      <input type="hidden" name="key_action" value="search" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
          </form></td>
        </tr>
        <? if($key_action == "search"){ 
		
			$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
			$e			= (!isset($e) || $e == 0) ? 10 : $e ;
			$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 

			
				 if($key_siteid != ""){
						 $conv .= " and  tbl_assign_key.siteid = '$key_siteid'";
				}
				if($key_idcard != ""){
						$conv .= " and  tbl_assign_key.idcard = '$key_idcard'";
				}
				
				if($key_name != ""){
						$conv .= " and  tbl_assign_key.fullname LIKE '%$key_name%'";
				}
				if($key_surname != ""){
						$conv .= " and  tbl_assign_key.fullname LIKE '%$key_surname%'";
				}
				if($date_key != ""){
					$arrd = explode("/",$date_key);
					$xdate_key = ($arrd[2]-543)."-".$arrd[1]."-".$arrd[0];
					$condate = " AND monitor_keyin.timeupdate LIKE '$xdate_key%'";
						
				}
				
				$sql_search1 = "SELECT distinct tbl_assign_key.idcard FROM  tbl_assign_key WHERE  tbl_assign_key.nonactive = '0' 
and tbl_assign_key.approve <> '2'  $conv ";
//echo "db_name :: $db_name ".$sql_search1;
				$result_search1 = mysql_db_query($db_name,$sql_search1);
				while($rss1 = mysql_fetch_assoc($result_search1)){
					if($in_idcard > "") $in_idcard .= ",";
					$in_idcard .= "'$rss1[idcard]'";
				}//end while($rss1 = mysql_fetch_assoc($result_search1)){
					if($in_idcard == ""){ $in_idcard = "''";}
					
				
			/*	 $sql_search = "SELECT distinct tbl_assign_key.idcard, tbl_assign_key.fullname, tbl_assign_key.siteid FROM tbl_assign_key
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard WHERE
tbl_assign_key.nonactive =  '0' and tbl_assign_key.approve <> '2'  $conv  $condate  order by fullname ASC";*/
$sql_search = "SELECT distinct monitor_keyin.idcard, monitor_keyin.keyin_name as fullname, monitor_keyin.siteid FROM monitor_keyin
where monitor_keyin.idcard IN($in_idcard) AND monitor_keyin.idcard <> '' $condate  order by fullname ASC ";
//echo $sql_search;
		$xresult = mysql_db_query($db_name,$sql_search);
		$all= @mysql_num_rows($xresult);
		//echo $all;
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_search .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_search .= " ";
	}else{
			$sql_search .= " LIMIT $i, $e";
	}
	
	//echo $sql_search;
				$result_search = mysql_db_query($db_name,$sql_search);
				$num_search = @mysql_num_rows($result_search);
				$search_sql = $sql_search ; 
				//echo $num_search;
				if($num_search < 1){
					echo "<tr><td colspan='3' align='center'><b> - ไมพบรายการที่ค้นหา - </b></td></tr>";
				}else if($num_search == "1"){
				
				
				$rs = mysql_fetch_assoc($result_search);
				$dbsite = STR_PREFIX_DB.$rs[siteid];
				$checklastyy = CheckLastSalary($rs[siteid],$rs[idcard]);
				//echo "$rs[siteid]&nbsp;$rs[idcard]<pre>";
				//print_r($checklastyy);
			
				 $xarr = CheckData($rs[idcard],$dbsite);
				 $CheckError1 = CheckDataV1($rs[idcard],$dbsite);
				 if($CheckError1 < 1){
					$xmsg = "ผลการตรวจสอบความถูกต้องข้องข้อมูล ผ่าน ";	
					//$disx = "";
				}else{
					$xmsg = " เกิดความผิดพลาดในการคีย์ข้อมูล";	
					//$disx = " disabled='disabled'";
				}
				$xstrSql = "SELECT id,idcard,prename_th,name_th,surname_th, siteid,schoolid, position_now FROM general WHERE id='$rs[idcard]'";
				$xresult = mysql_db_query($dbsite,$xstrSql);
				$xrs = mysql_fetch_assoc($xresult);
				$pathfile = "../../../../../edubkk_kp7file/$xrs[siteid]/$xrs[idcard]".".pdf";
		
		?>
        <tr><td align="center">
         <form action="" method="post" enctype="multipart/form-data" name="form2" id="form2">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="300" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="35" class="table2">&nbsp;</td>
            </tr>
        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="7%" align="center"><? echo "<a href='login_data.php?xname_th=$xrs[name_th]&xsurname_th=$xrs[surname_th]&xidcard=$xrs[idcard]&action=login&xsiteid=$xrs[siteid]' target='_blank'>";?><img src="../../../../images_sys/person.gif" width="16" height="13" border="0" alt="คลิ๊กเพื่อ login เข้าสู่ระบบ"><? echo "</a>";?></td>
                      <td width="93%" align="left"><strong>ผลสรุปการตรวจสอบข้อมูล</strong> &nbsp;<? if(is_file($pathfile)){?><a href="<?=$pathfile?>" target="_blank"><img src="../../../../images_sys/gnome-mime-application-pdf.png" width="20" height="21" alt="ตรวจสอบไฟล์ pdf ต้นฉบับ" border="0"></a><? } ?></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td width="24%" align="center" valign="top"><?
                  		$sql_showpic="select yy,imgname from general_pic where id='$rs[idcard]' and kp7_active='1' order by no  DESC ";
						$query=mysql_db_query($dbsite,$sql_showpic)or die("cannot query".mysql_error());
						$num=mysql_num_rows($query);
						
						if($num==0){
							echo "<img src=\"../../../../images_sys/noimage.jpg\">";
						}else{
							$rp=mysql_fetch_assoc($query);
							echo "<img src=\"../../../../../image_file/$rs[siteid]/$rp[imgname]\" width=120 height=160 >";
						}//end if($num==0){
                  
                  		
                  ?></td>
                  <td width="76%" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="22%" align="right" bgcolor="#FFFFFF"><strong>รหัสบัตรประชาชน : </strong></td>
                      <td width="51%" align="left" bgcolor="#FFFFFF"><?=$xrs[idcard]?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>ชื่อ - นามสกุล : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><? echo "$xrs[prename_th]$xrs[name_th]  $xrs[surname_th]";?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>ตำแหน่ง : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=$xrs[position_now]?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>สังกัด : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=ShowArea($xrs[siteid])."/".ShowSchool($xrs[schoolid]);?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
              <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="7%" align="center"><strong><img src="../../../../images_sys/useronline.gif" width="20" height="20" /></strong></td>
                      <td width="93%"><strong>รายละเอียดผู้บันทึกข้อมูล</strong></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>
                <?
              $sql_staff = "SELECT tbl_assign_sub.staffid, monitor_keyin.idcard, monitor_keyin.timeupdate, keystaff.prename, keystaff.staffname,
keystaff.staffsurname, keystaff.sapphireoffice, keystaff.image 
FROM tbl_assign_sub
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE  monitor_keyin.idcard =  '$rs[idcard]' AND tbl_assign_key.nonactive =  '0' ORDER BY monitor_keyin.timeupdate DESC LIMIT 1 ";
			$result_staff = mysql_db_query($db_name,$sql_staff);
			$rs_staff = mysql_fetch_assoc($result_staff);
				?>
                <tr>
                  <td width="31%" align="center" valign="top"><?
                  	if($rs_staff[image] != ""){
						echo "<img src=\"../../../userentry/images/personnel/$rs_staff[image]\" width=120 height=160>";	
					}else{
						echo "<img src=\"../../../../images_sys/noimage.jpg\">";	
					}
				  ?></td>
                  <td width="69%" align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr>
                      <td width="42%" align="right" bgcolor="#FFFFFF"><strong>ชื่อ-นามสกุล : </strong></td>
                      <td width="58%" align="left" bgcolor="#FFFFFF"><? echo "$rs_staff[prename]$rs_staff[staffname]  $rs_staff[staffsurname]";?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>วันที่บันทึกข้อมูล : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=DateThai($rs_staff[timeupdate]);?></td>
                    </tr>
                    <tr>
                      <td align="right" bgcolor="#FFFFFF"><strong>ประเภทพนักงาน : </strong></td>
                      <td align="left" bgcolor="#FFFFFF"><?=$arrstaff[$rs_staff[sapphireoffice]];?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td colspan="2" align="left"><strong><? echo $xmsg;?></strong></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?  if($CheckError1 > 0){
				  $i=0;
				foreach($xarr as $key => $val){	
				
				if($val != ""){
				 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			?>
                <tr bgcolor="<?=$bg?>">
                  <td width="6%" align="center" valign="top"><?=$i?></td>
                  <td width="94%" align="left"><?=$val?></td>
                </tr>
                <?
				}//end if($val != ""){
				}//end foreach(){	  
			  }//end if(CheckDataV1($rs[idcard],$dbsite) > 0){
				  
				if($checklastyy['NUMSALARY'] == 0){ // แสดงกรณีบันทึกข้อมูลถึงปัจจุบันเท่านั้น
				echo "<tr><td colspan='2'> <b>ข้อมูลของ  $rs[fullname] ยังบันทึกข้อมูลเงินเดือนยังไม่เสร็จ ขณะนี้บันทึกถึง วันที่". DateThai($checklastyy['maxdate']) ."</b></tr></td>"; 
				}//end 
			?>
              </table></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="20" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="19%" align="left"><strong>หมายเหตุการรับร้องข้อมูล :</strong></td>
            <td width="81%"><label>
              <textarea name="comment_approve1" id="comment_approve1" cols="50" rows="3"></textarea>
            </label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" align="center" valign="top"><label>
        <input type="hidden" name="idcard" value="<?=$rs[idcard]?>">
        <input type="hidden" name="xsiteid" value="<?=$rs[siteid]?>">
        <input type="hidden" name="Aaction" value="SAVE1">
          <input type="submit" name="button3" id="button3" value="ยืนยันข้อมูล" <?=$disx?>>
        </label></td>
      </tr>
        </table>
        </form>
        </td></tr>
        <?
//				}else{
//					echo "<tr><td colspan='3'><center> <b>ข้อมูลของ  $rs[fullname] ยังบันทึกข้อมูลเงินเดือนยังไม่เสร็จ ขณะนี้บันทึกถึง วันที่". DateThai($checklastyy['maxdate']) ."</b></center></tr></td>";  
//				}//end if($checklastyy['NUMSALARY']> 0){

				} else{
		?>
        <tr>
          <td align="center">
          
          <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return CheckFromSubmit();">
          
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3"  id="table0" class="sortable">
                <tr>
                  <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
                  <td width="10%" align="center" bgcolor="#CCCCCC"><strong>รหัสบัตร</strong></td>
                  <td width="10%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
                  <td width="12%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
                  <td width="11%" align="center" bgcolor="#CCCCCC"><strong>สังกัด</strong></td>
                  <td width="11%" align="center" bgcolor="#CCCCCC"><strong>สถานะตรวจข้อมูล<br />
                    เบื้องต้นของคนคีย์</strong></td>
                  <td width="11%" align="center" bgcolor="#CCCCCC"><strong>ความสมบูรณ์ของ<br />
                    การบันทึกข้อมูล</strong></td>
                  <td width="11%" align="center" bgcolor="#CCCCCC"><strong>กลุ่มคีย์ข้อมูล</strong></td>
                  <td width="15%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
                  <td width="6%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <? 
				//$i=0;
				$j=0;
				
					while($rs = mysql_fetch_assoc($result_search)){
							 $dbsite = STR_PREFIX_DB.$rs[siteid];
							 $checklastyy = CheckLastSalary($rs[siteid],$rs[idcard]);
							// echo "<pre>";
							// print_r($checklastyy);
									if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
							$arr = CheckData($rs[idcard],$dbsite);
							$CheckError = CheckDataV1($rs[idcard],$dbsite);
							if($checklastyy['NUMSALARY'] == 0){
								$CheckError = $CheckError+1;
							}//end if($checklastyy['NUMSALARY'] > 0){

							
							$sql1 = "SELECT position_now,schoolname FROM view_general WHERE CZ_ID='$rs[idcard]'";
							//echo $sql1;
							$result1 = mysql_db_query($dbsite,$sql1);
							$rs1 = mysql_fetch_assoc($result1);
							//echo "<pre>";
							//print_r($arr);
							if($CheckError > 0){ $dis = "disabled='disabled'";$j++; $msg_err = "error";}else{ $dis = ""; $msg_err = "";}
							$pathfile = "../../../../../edubkk_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
							if(is_file($pathfile)){
								$pdf_file = "<a href='$pathfile' target='_blank'><img src=\"../../../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" alt=\"ตรวจสอบไฟล์ pdf ต้นฉบับ\" border='0'></a>";
							}else{
								$pdf_file = "";
							}//end if(is_file($pathfile)){
								
								
					$sql_group_key = "SELECT
tbl_assign_sub.staffid,
monitor_keyin.idcard,
monitor_keyin.timeupdate,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff.sapphireoffice,
keystaff.image,
keystaff.keyin_group,
keystaff_group.groupname
FROM
tbl_assign_sub
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
WHERE  monitor_keyin.idcard =  '$rs[idcard]' AND tbl_assign_key.nonactive =  '0'
ORDER BY monitor_keyin.timeupdate DESC
LIMIT 1";
$result_group = mysql_db_query($db_name,$sql_group_key);
$rsgroup = mysql_fetch_assoc($result_group);
							
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$i?></td>
                  <td align="left"><?=$rs[idcard]?></td>
                  <td align="left"><?=$rs[fullname]?></td>
                  <td align="left"><?=$rs1[position_now]?></td>
                  <td align="left"><? echo ShowArea($rs[siteid])."/".$rs1[schoolname];?></td>
                  <td align="center"><?
				  if(CheckUserKeyApprove($rs[idcard]) > 0){ echo "ยืนยัน";}else{ echo "<font color='#FF0000'>ยังไม่ยืนยัน</font>";}
				  ?></td>
                  <td align="center"><? if($CheckError > 0){ echo "<font color='red'><a href='result_data_error.php?idcard=$rs[idcard]&xsiteid=$rs[siteid]&fullname=$rs[fullname]' target='_blank'>INCOMPLATE</a></font>";}else{ echo "<font color='green'>OK</font>";}?></td>
                  <td align="center"><?=$rsgroup[groupname]?></td>
                  <td align="center"><label>
                    <input name="comment_approve[<?=$rs[idcard]?>]" type="text" id="comment<?=$i?>" size="25">
                  </label></td>
                  <td align="center">
                  	<?=$pdf_file?>
                  <label>
                    <input type="checkbox" name="xapprove[<?=$rs[idcard]?>]" id="xapprove<?=$i?>" value="<?=$rs[siteid]?>">
                    <input type="hidden" name="msgerr[<?=$rs[idcard]?>]" id="msgerr<?=$i?>" value="<?=$msg_err?>">
                    
                  </label></td>
                </tr>
                <? 
					$CheckError = 0;
				} //end while(){
					?>
                   <tr bgcolor="<?=$bg?>">
                     <td colspan="10" align="center" bgcolor="#FFFFFF"><? $sqlencode = urlencode($search_sql)  ; ?>	
	<?=devidepage($allpage, $keyword ,$sqlencode )?></td>
                     </tr>
                   <tr bgcolor="<?=$bg?>">
                  <td colspan="8" align="center" bgcolor="#FFFFFF">&nbsp;</td>
                  <td colspan="2" align="center" bgcolor="#FFFFFF"><label>
                    <? if($i == $j){ $dis1 = "disabled='disabled'";}else{ $dis1 = "";}?>
                    <input type="submit" name="button2" id="button2" value="ยืนยันข้อมูล">
                    <input type="hidden" name="Aaction" id="Aaction" value="SAVE2">
                    <input  type="hidden" name="num_checklist" id="num_checklist" value="<?=$i?>">
                  </label></td>
                  </tr>

              </table></td>
            </tr>
          </table>
          
          </form>
          
          </td>
          </tr>
          
         <?
				}//end if($num_search < 1){
		 } //end if($key_action == "search"){ ?>
  </table></td>
    </tr>
      </table>
  </td>
    </tr>
  </table>

</body>
</html>
