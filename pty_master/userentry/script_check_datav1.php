<?
include ("../../../../config/conndb_nonsession.inc.php")  ;
include('function.inc_v1.php') ;
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$year1 = (date("Y")+543)."09-30";

	if($xsiteid == ""){
		$xsiteid = "7002";
	}else{
		$xsiteid = $xsiteid;	
	}
	$db_site = STR_PREFIX_DB.$xsiteid;
	$key_action = "search";
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ตรวจสอบข้อผิดพลาดการบันทึกข้อมูล</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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
        <? if($key_action == "search"){ 
		
//			$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
//			$e			= (!isset($e) || $e == 0) ? 10 : $e ;
//			$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 					
				
$sql_search = "SELECT
CAST( ".DB_MASTER.".allschool.id as SIGNED) as xschool,
FLOOR((TIMESTAMPDIFF(MONTH,begindate,'$year1')/12)) as age_gov,
$db_site.general.idcard,
$db_site.general.siteid,
$db_site.general.schoolid,
$db_site.general.prename_th,
$db_site.general.name_th,
$db_site.general.surname_th,
 ".DB_MASTER.".allschool.office
FROM
$db_site.general
Inner Join  ".DB_MASTER.".allschool ON $db_site.general.schoolid =  ".DB_MASTER.".allschool.id
ORDER BY xschool ASC ";

//		$xresult = mysql_db_query($db_site,$sql_search);
//		$all= @mysql_num_rows($xresult);
//		$allpage	= ceil($all / $e);
//		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
//		$xpage=$allpage +1;
//		
//	if($page <= $allpage){
//			$sql_search .= " LIMIT $i, $e";
//	}else if($page == $xpage){
//		$i=0;
//			$sql_search .= " ";
//	}else{
//			$sql_search .= " LIMIT $i, $e";
//	}
	
	
				$result_search = mysql_db_query($db_site,$sql_search);
				$num_search = @mysql_num_rows($result_search);
				$search_sql = $sql_search ; 
				//echo $num_search;
				if($num_search < 1){
					echo "<tr><td colspan='3' align='center'><b> - ไมพบรายการที่ค้นหา - </b></td></tr>";
				}else if($num_search == "1"){
				
				
				$rs = mysql_fetch_assoc($result_search);
				$dbsite = STR_PREFIX_DB.$rs[siteid];
				$checklastyy = CheckLastSalary($rs[siteid],$rs[idcard]);
				if($checklastyy['NUMSALARY'] > 0){ // แสดงกรณีบันทึกข้อมูลถึงปัจจุบันเท่านั้น
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
        <tr><td width="100%" align="center">&nbsp;</td></tr>
        <?
				}else{
					echo "<tr><td colspan='3'><center> <b>ข้อมูลของ  $rs[fullname] ยังบันทึกข้อมูลเงินเดือนยังไม่เสร็จ ขณะนี้บันทึกถึง วันที่". DateThai($checklastyy['maxdate']) ."</b></center></tr></td>";  
				}//end if($checklastyy['NUMSALARY']> 0){

				} else{
		?>
        <tr>
          <td align="center">
          
          <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return CheckFromSubmit();">
          
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#999999"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
                  <td width="11%" align="center" bgcolor="#CCCCCC"><strong>รหัสบัตร</strong></td>
                  <td width="13%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ - นามสกุล</strong></td>
                  <td width="10%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
                  <td width="15%" align="center" bgcolor="#CCCCCC"><strong>สังกัด</strong></td>
                  <td width="11%" align="center" bgcolor="#CCCCCC"><strong>สถานะตรวจข้อมูล<br />
                    เบื้องต้นของคนคีย์</strong></td>
                  <td width="11%" align="center" bgcolor="#CCCCCC"><strong>ความสมบูรณ์ของ<br />
                    การบันทึกข้อมูล</strong></td>
                  </tr>
                <? 
				//$i=0;
				$j=0;
					while($rs = mysql_fetch_assoc($result_search)){
							 $dbsite = STR_PREFIX_DB.$rs[siteid];
							 $checklastyy = CheckLastSalary($rs[siteid],$rs[idcard]);
							if($checklastyy['NUMSALARY'] > 0){
									if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
							$arr = CheckData($rs[idcard],$dbsite);
							$CheckError = CheckDataV1($rs[idcard],$dbsite);
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
							
				?>
                <tr bgcolor="<?=$bg?>">
                  <td align="center"><?=$i?></td>
                  <td align="left"><?=$rs[idcard]?></td>
                  <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
                  <td align="left"><?=$rs1[position_now]?></td>
                  <td align="left"><? echo ShowArea($rs[siteid])."/".$rs1[schoolname];?></td>
                  <td align="center"><?
				  if(CheckUserKeyApprove($rs[idcard]) > 0){ echo "ยืนยัน";}else{ echo "<font color='#FF0000'>ยังไม่ยืนยัน</font>";}
				  ?></td>
                  <td align="center"><? if($CheckError > 0){ echo "<font color='red'><a href='result_data_error.php?idcard=$rs[idcard]&xsiteid=$rs[siteid]&fullname=$rs[fullname]' target='_blank'>INCOMPLATE</a></font>";}else{ echo "<font color='green'>OK</font>";}?></td>
                  </tr>
                <? 
					}//end if($checklastyy['NUMSALARY'] > 0){
				} //end while(){
					?>
                   <tr bgcolor="<?=$bg?>">
                     <td colspan="7" align="center" bgcolor="#FFFFFF"><? //$sqlencode = urlencode($search_sql)  ; ?>	
	<? //=devidepage($allpage, $keyword ,$sqlencode )?></td>
                     </tr>
                   <tr bgcolor="<?=$bg?>">
                  <td colspan="7" align="center" bgcolor="#FFFFFF">&nbsp;</td>
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
