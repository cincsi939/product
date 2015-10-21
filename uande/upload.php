<?php
session_start();
  
	$testses=session_id;
	//echo $testses(); 
	$d =date("d");
	$mont= date("m");
	$yearr= date("Y");
	$yearthai = $yearr+543;
	$tm= date("h_i_s");
	 $test = $d.'/'.$mont.'/'.$yearthai.'/'.$tm;
	//echo $test;
	
	
	 $jj =$testses().'_'.$mont.'_'.$yearthai.'_'.$tm;
	//echo $jj;
	//echo $namesec;
	
  
	set_time_limit(0);
	include"topmenu.php";
	include "condb.php";
	require_once "xsl_reader/reader.php";
	
	
  ?>
  
 <html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<!--<meta http-equiv="Content-Type" content="text/html;charset=tis-620"  />-->
<!--<meta http-equiv=Content-Type content="text/html; charset=tis-620">-->
<title>Upload excel data</title>
</head>
<body>

	  <div class="container">
		<div class="well">
           
     
<?php $_POST['bt_submit']=="";
	  $_POST['seround']=="";
?>
<?php
//echo $_POST['bt_submit'];
if($_POST['bt_submit'] != ""){
	
	 
	# upload file
	$filename = $jj.".xls";
    $dir = "excel_file/".$filename;
	move_uploaded_file($_FILES['checklist']['tmp_name'],$dir);
					$reer = $_FILES['checklist']['error'];
					 if($reer==1){
						echo $jj.'maxsize'; 
					}elseif($reer==0){
						echo $jj.'success'; 
					}elseif($reer==4){
						echo "PlessinputFileUpload"; 
					}		
						  $semont=$_POST['seround'];
						  //echo $semont;
	/*$sqlFile = "INSERT INTO round_num(mm,yy,)
	            VALUES('$semont','$yearthai')";
		//echo $sqlFile;
				
		mysql_query($sqlFile)or die(mysql_error());*/
		
	
	# insert data to temp
	$data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('TIS-620');
	if($reer==0){
		$data->read($dir);
	}else{
		
	}
    
    $setstrartrow = 4;
	#echo "debug => <br><pre>";
	//print_r($data);
	//echo $data->sheets[0]['numRows'];
	
	for($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
		
		
         
		
		$idcard = trim($data->sheets[0]['cells'][$i][1]); // บัตรประชาชน
			if($idcard==""){
				break;
			}else{
			 
			}
		$WorkingPeple = trim($data->sheets[0]['cells'][$i][2]); // ชื่อผู้ทำ
        $rank= trim($data->sheets[0]['cells'][$i][3]); //ตำแนหน่ง
        $Department = trim($data->sheets[0]['cells'][$i][4]); //ไซต์งาน
		$WorkingDate = trim($data->sheets[0]['cells'][$i][5]); //วันที่ทำงาน
			$cdate = str_replace('/', '-', $WorkingDate);
			$workday=date('Y-m-d', strtotime($cdate));
		$ProjectCode = trim($data->sheets[0]['cells'][$i][6]); //รหัสโครงงาน
        $tor = trim($data->sheets[0]['cells'][$i][7]); //หัวข้อ Tor
        $WorkingDetail = trim($data->sheets[0]['cells'][$i][8]);//รายระเอียดงาน
        $WorkingPercent = trim($data->sheets[0]['cells'][$i][9]); // เปอร์เซ้น / วัน
		$WorkingTime  = trim($data->sheets[0]['cells'][$i][10]); // เวลางาน/ วัน
		$JobAssignment= trim($data->sheets[0]['cells'][$i][11]); // ผู้มอบหมายงาน
        $A = trim($data->sheets[0]['cells'][$i][13]); // ผู้รับการประเมิน
		$B = trim($data->sheets[0]['cells'][$i][14]); // ผู้สั่งงาน
		$C = trim($data->sheets[0]['cells'][$i][16]); // ผู้รับการประเมิน
		$D = trim($data->sheets[0]['cells'][$i][17]); // ผู้สั่งงาน
		$E = trim($data->sheets[0]['cells'][$i][19]); // คะแนน 1 - 5
		$F = trim($data->sheets[0]['cells'][$i][20]); // คะแนน 1 - 5
		$checkinsert = "select id from personal_point where IdCard='$idcard' AND mmont = '$semont' ";
     //  echo $checkinsert;
	   $result = mysql_query($checkinsert);
	if (mysql_num_rows($result) != 0) {
		$list=mysql_num_rows($result);
		//echo "ในฐานข้อมูลมีข้อมูลประจำเดือนที่เลือกอยู่แล้ว $list รายการ ต้องการ แก้ไขข้อมูลเข้าใหม่หรือไม่";
	
			$k='0';
		while ($row = mysql_fetch_assoc($result)) {
				$rid=$row["id"];
			 	//echo $rid;
				$delrow = "DELETE from personal_point where id='$rid'";
				$k++;
		}
	
	}
		
	echo "ลบข้อมูล $k แถวแล้ว" ;
	/*while ($row = mysql_fetch_assoc($result)) {
    echo $row["id"];
    
	}*/
	
		 
				$sqlTemp = "INSERT INTO personal_point(idcard,WorkingPeple,Department,WorkingDate,ProjectCode,tor,WorkingDetail,WorkingPercent,WorkingTime,JobAssignment,rank,mmont,file_name,A,B,C,D,E,F,yyear)
					 VALUES('$idcard','$WorkingPeple','$Department','$workday','$ProjectCode','$tor','$WorkingDetail','$WorkingPercent','$WorkingTime','$JobAssignment','$rank','$semont','$filename','$A','$B','$C','$D','$E','$F','$yearthai')";
		//echo $sqlTemp;
		
		mysql_query($sqlTemp)or die(mysql_error());				   
		 
	}// end for		
}	
?>

<form  method="post" name="frm" enctype="multipart/form-data" >
<table width="100%" border="0" cellspacing="0" cellpadding="3">
 
 <tr>
	<?php echo $jj; ?>
    <td align="right"><strong>กรุณาเลือกไฟล์ที่ต้องการ upload</strong></td>
    <td>
    <input name="checklist" type="file" />
    </td>
 </tr>
 <tr>
	<td align="right"><strong> กรุณาระบุรอบที่ต้องการอัพโหลด </strong> 
		<select id="seround" name="seround">
	<?php
	$selectround = "select * from round_num where status_active = '1'";
	
    for ($m = 1;$m <= 12;$m++)
    {
        echo "<option value=$m>$m</option>";
		
    }
	?>
	
</select>
  </td>
 </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><input name="bt_submit" type="submit" value="Upload" /></td>
  </tr>
</table>
</form>
     </div>
	  </div>


</body>
</html>
  