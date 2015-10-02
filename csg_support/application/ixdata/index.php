<?
include "../survey/header.php";?>
<?php
//session_start();
//require_once('../survey/lib/class.function.php');
require_once('xsl_reader/reader.php');

$con = new Cfunction();
$con->connectDB();
$new_tmp = 'tmp/';
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');
$new_tmp = 'tmp/';
if($_POST['b_import']){

		$file = $_FILES['excel_file']["tmp_name"];
		$newfile = date('Ymd').'-'.time().'.xls';
		if (!copy($file, $new_tmp.$newfile)) {
			echo "failed to copy $file...\n";
			exit();
		}else{
			chmod($new_tmp.$newfile, 0777);
			$data->read($new_tmp.$newfile);
			# เช็คข้อมูลเลขบัตรประชาชนซ้ำ
			$setstrartrow = 2;
			$numRows=0;
			for($ci = $setstrartrow; $ci <= $data->sheets[0]['numRows']; $ci++) {
				$processing_idcard[trim($data->sheets[0]['cells'][$ci][2])] += 1;
				if($processing_idcard[trim($data->sheets[0]['cells'][$ci][2])] > 1){
					$txt_alert = iconv('utf-8', 'tis-620', "ขออภัย Excel ของท่าน ข้อมูลเลขบัตรประชาชนซ้ำกรุณาตรวจสอบ");
					echo "<script>alert('ขออภัย Excel ของท่าน ข้อมูลเลขบัตรประชาชนซ้ำกรุณาตรวจสอบ');window.location='?';</script>";
					exit();
				}
			}
			
			if($data->sheets[0]['cells'][1][65]==''){
				$txt_alert = iconv('utf-8', 'tis-620', 'ขออภัย Excelของท่านไม่ถูกต้อง');
				echo "<script>alert('ขออภัย Excelของท่านไม่ถูกต้อง');window.location='?';</script>";
				exit();
			}else{
			$setstrartrow = 2;
			$numRows=0;
			$sqlDel = "DELETE FROM processing_data ";
			mysql_query($sqlDel);
			for($i = $setstrartrow ; $i <= $data->sheets[0]['numRows']; $i++) {
						
					  	$processing_id = trim($data->sheets[0]['cells'][$i][1]);
						$processing_idcard = trim($data->sheets[0]['cells'][$i][2]);
						$question_prename = trim($data->sheets[0]['cells'][$i][3]);
						$processing_firstname = trim($data->sheets[0]['cells'][$i][4]);
						$processing_lastname = trim($data->sheets[0]['cells'][$i][5]);
						$processing_fullname = trim($data->sheets[0]['cells'][$i][6]);
						$processing_qu = trim($data->sheets[0]['cells'][$i][7]);
						$processing_round = trim($data->sheets[0]['cells'][$i][8]);
						$processing_year = trim($data->sheets[0]['cells'][$i][9]);
						$question_address = trim($data->sheets[0]['cells'][$i][10]);
						$question_parish = trim($data->sheets[0]['cells'][$i][11]);
						$question_district = trim($data->sheets[0]['cells'][$i][12]);
						$question_province = trim($data->sheets[0]['cells'][$i][13]);
						$question_sex = trim($data->sheets[0]['cells'][$i][14]);
						$question_age = trim($data->sheets[0]['cells'][$i][15]);
						$question_typehome = trim($data->sheets[0]['cells'][$i][16]);
						$processing_q7 = trim($data->sheets[0]['cells'][$i][17]);
						$processing_q8 = trim($data->sheets[0]['cells'][$i][18]);
						$processing_q9 = trim($data->sheets[0]['cells'][$i][19]);
						$processing_q10 = trim($data->sheets[0]['cells'][$i][20]);
						$processing_q11 = trim($data->sheets[0]['cells'][$i][21]);
						$processing_q12 = trim($data->sheets[0]['cells'][$i][22]);
						$processing_q13 = trim($data->sheets[0]['cells'][$i][23]);
						$processing_q14 = trim($data->sheets[0]['cells'][$i][24]);
						$processing_q15 = trim($data->sheets[0]['cells'][$i][25]);
						$processing_q16 = trim($data->sheets[0]['cells'][$i][26]);
						$processing_q17 = trim($data->sheets[0]['cells'][$i][27]);
						$processing_q18 = trim($data->sheets[0]['cells'][$i][28]);
						$processing_q19 = trim($data->sheets[0]['cells'][$i][29]);
						$processing_q20 = trim($data->sheets[0]['cells'][$i][30]);
						$processing_q21 = trim($data->sheets[0]['cells'][$i][31]);
						$processing_q22 = trim($data->sheets[0]['cells'][$i][32]);
						$processing_q23 = trim($data->sheets[0]['cells'][$i][33]);
						$processing_q24_1 = trim($data->sheets[0]['cells'][$i][34]);
						$processing_q24_2 = trim($data->sheets[0]['cells'][$i][35]);
						$processing_q24_3_1 = trim($data->sheets[0]['cells'][$i][36]);
						$processing_q24_3_2 = trim($data->sheets[0]['cells'][$i][37]);
						$processing_q24_3_3 = trim($data->sheets[0]['cells'][$i][38]);
						$processing_q24_3_4 = trim($data->sheets[0]['cells'][$i][39]);
						$processing_q24_4 = trim($data->sheets[0]['cells'][$i][40]);
						$processing_q24_5 = trim($data->sheets[0]['cells'][$i][41]);
						$processing_q24_6 = trim($data->sheets[0]['cells'][$i][42]);
						$processing_q24_7 = trim($data->sheets[0]['cells'][$i][43]);
						$processing_q24_8_1 = trim($data->sheets[0]['cells'][$i][44]);
						$processing_q24_8_2 = trim($data->sheets[0]['cells'][$i][45]);
						$processing_d_1 = trim($data->sheets[0]['cells'][$i][46]);
						$processing_c_1 = trim($data->sheets[0]['cells'][$i][47]);
						$processing_s_1 = trim($data->sheets[0]['cells'][$i][48]);
						$processing_d_2 = trim($data->sheets[0]['cells'][$i][49]);
						$processing_c_2 = trim($data->sheets[0]['cells'][$i][50]);
						$processing_s_2 = trim($data->sheets[0]['cells'][$i][51]);
						$processing_d_3 = trim($data->sheets[0]['cells'][$i][52]);
						$processing_c_3 = trim($data->sheets[0]['cells'][$i][53]);
						$processing_s_3 = trim($data->sheets[0]['cells'][$i][54]);
						$processing_d_4 = trim($data->sheets[0]['cells'][$i][55]);
						$processing_c_4 = trim($data->sheets[0]['cells'][$i][56]);
						$code_parish = trim($data->sheets[0]['cells'][$i][57]);
						$code_district = trim($data->sheets[0]['cells'][$i][58]);
						$code_province = trim($data->sheets[0]['cells'][$i][59]);
						$arrProcessingDate = explode('/',trim($data->sheets[0]['cells'][$i][60]));
						$processing_date = ($arrProcessingDate[2]-543).'-'.$arrProcessingDate[1].'-'.$arrProcessingDate[0];
						$amount_child = trim($data->sheets[0]['cells'][$i][61]);
						$amount_young = trim($data->sheets[0]['cells'][$i][62]);
						$amount_work = trim($data->sheets[0]['cells'][$i][63]);
						$amount_old = trim($data->sheets[0]['cells'][$i][64]);
						$amount_cripple = trim($data->sheets[0]['cells'][$i][65]);
						
						//$processing_id = iconv('tis-620','utf-8',$processing_firstname);
						
						$question_prename = iconv('utf-8','tis-620',$question_prename);
						$processing_firstname =iconv('utf-8','tis-620',$processing_firstname);
						$processing_lastname = iconv('utf-8','tis-620',$processing_lastname);
						$processing_fullname = iconv('utf-8','tis-620',$processing_fullname);
						$processing_qu =  iconv('utf-8','tis-620',$processing_qu);
						$processing_round = iconv('utf-8','tis-620',$processing_round);
						$processing_year = iconv('utf-8','tis-620',$processing_year);
						$question_address = iconv('utf-8','tis-620',$question_address);
						$question_parish = iconv('utf-8','tis-620',$question_parish);
						$question_district = iconv('utf-8','tis-620',$question_district);
						$question_province = iconv('utf-8','tis-620',$question_province);
						$question_sex = iconv('utf-8','tis-620',$question_sex);
						$question_age = iconv('utf-8','tis-620',$question_age);
						$question_typehome = iconv('utf-8','tis-620',$question_typehome);
						$processing_q7 = iconv('utf-8','tis-620',$processing_q7);
						$processing_q8 = iconv('utf-8','tis-620',$processing_q8);
						$processing_q9 = iconv('utf-8','tis-620',$processing_q9);
						$processing_q10 = iconv('utf-8','tis-620',$processing_q10);
						$processing_q11 = iconv('utf-8','tis-620',$processing_q11);
						$processing_q12 = iconv('utf-8','tis-620',$processing_q12);
						$processing_q13 = iconv('utf-8','tis-620',$processing_q13);
						$processing_q14 = iconv('utf-8','tis-620',$processing_q14);
						$processing_q15 = iconv('utf-8','tis-620',$processing_q15);
						$processing_q16 = iconv('utf-8','tis-620',$processing_q16);
						$processing_q17 = iconv('utf-8','tis-620',$processing_q17);
						$processing_q18 = iconv('utf-8','tis-620',$processing_q18);
						$processing_q19 = iconv('utf-8','tis-620',$processing_q19);
						$processing_q20 = iconv('utf-8','tis-620',$processing_q20); 
						$processing_q21 = iconv('utf-8','tis-620',$processing_q21);
						$processing_q22 = iconv('utf-8','tis-620',$processing_q22);
						$processing_q23 = iconv('utf-8','tis-620',$processing_q23);
						$processing_q24_1 = iconv('utf-8','tis-620',$processing_q24_1);
						$processing_q24_2 = iconv('utf-8','tis-620',$processing_q24_2);
						$processing_q24_3_1 = iconv('utf-8','tis-620',$processing_q24_3_1);
						$processing_q24_3_2 = iconv('utf-8','tis-620',$processing_q24_3_2);
						$processing_q24_3_3 = iconv('utf-8','tis-620',$processing_q24_3_3);
						$processing_q24_3_4 = iconv('utf-8','tis-620',$processing_q24_3_4);
						$processing_q24_4 = iconv('utf-8','tis-620',$processing_q24_4);
						$processing_q24_5 = iconv('utf-8','tis-620',$processing_q24_5);
						$processing_q24_6 = iconv('utf-8','tis-620',$processing_q24_6);
						$processing_q24_7 = iconv('utf-8','tis-620',$processing_q24_7);
						$processing_q24_8_1 = iconv('utf-8','tis-620',$processing_q24_8_1);
						$processing_q24_8_2 =iconv('utf-8','tis-620',$processing_q24_8_2);
						$processing_d_1 = iconv('utf-8','tis-620',$processing_d_1);
						$processing_c_1 =iconv('utf-8','tis-620',$processing_c_1);
						$processing_s_1 = iconv('utf-8','tis-620',$processing_s_1);
						$processing_d_2 = iconv('utf-8','tis-620',$processing_d_2);
						$processing_c_2 = iconv('utf-8','tis-620',$processing_c_2);
						$processing_s_2 = iconv('utf-8','tis-620',$processing_s_2);
						$processing_d_3 = iconv('utf-8','tis-620',$processing_d_3);
						$processing_c_3 = iconv('utf-8','tis-620',$processing_c_3);
						$processing_s_3 = iconv('utf-8','tis-620',$processing_s_3);
						$processing_d_4 = iconv('utf-8','tis-620',$processing_d_4);
						$processing_c_4 = iconv('utf-8','tis-620',$processing_c_4);
						
						if($processing_id != ""){
							$numRows++;
						$sqlAdd = "INSERT INTO processing_data
													SET processing_id='$processing_id',
													processing_idcard='$processing_idcard',
													question_prename='$question_prename',
													processing_firstname='$processing_firstname',
													processing_lastname='$processing_lastname',
													processing_fullname='$processing_fullname',
													processing_qu='$processing_qu',
													processing_round='$processing_round',
													processing_year='$processing_year',
													question_address='$question_address',
													question_parish='$question_parish',
													question_district='$question_district',
													question_province='$question_province',
													question_sex='$question_sex',
													question_age='$question_age',
													question_typehome='$question_typehome',
													processing_q7='$processing_q7',
													processing_q8='$processing_q8',
													processing_q9='$processing_q9',
													processing_q10='$processing_q10',
													processing_q11='$processing_q11',
													processing_q12='$processing_q12',
													processing_q13='$processing_q13',
													processing_q14='$processing_q14',
													processing_q15='$processing_q15',
													processing_q16='$processing_q16',
													processing_q17='$processing_q17',
													processing_q18='$processing_q18',
													processing_q19='$processing_q19',
													processing_q20='$processing_q20',
													processing_q21='$processing_q21',
													processing_q22='$processing_q22',
													processing_q23='$processing_q23',
													processing_q24_1='$processing_q24_1',
													processing_q24_2='$processing_q24_2',
													processing_q24_3_1='$processing_q24_3_1',
													processing_q24_3_2='$processing_q24_3_2',
													processing_q24_3_3='$processing_q24_3_3',
													processing_q24_3_4='$processing_q24_3_4',
													processing_q24_4='$processing_q24_4',
													processing_q24_5='$processing_q24_5',
													processing_q24_6='$processing_q24_6',
													processing_q24_7='$processing_q24_7',
													processing_q24_8_1='$processing_q24_8_1',
													processing_q24_8_2='$processing_q24_8_2',
													processing_d_1='$processing_d_1',
													processing_c_1='$processing_c_1',
													processing_s_1='$processing_s_1',
													processing_d_2='$processing_d_2',
													processing_c_2='$processing_c_2',
													processing_s_2='$processing_s_2',
													processing_d_3='$processing_d_3',
													processing_c_3='$processing_c_3',
													processing_s_3='$processing_s_3',
													processing_d_4='$processing_d_4',
													processing_c_4='$processing_c_4',
													code_parish='$code_parish',
													code_district='$code_district',
													code_province='$code_province',
													processing_date='$processing_date',
													amount_child='$amount_child',
													amount_young='$amount_young',
													amount_work='$amount_work',
													amount_old='$amount_old',
													amount_cripple='$amount_cripple',
													processing_time=NOW()
													";
						mysql_query($sqlAdd);
						}
						
						//echo $sqlAdd."<br/>";
			}
			//die($sqlAdd);
			$sqlUpload = "INSERT INTO log_import_data 
										SET file_name='".$newfile."', 
										file_comment='".$_FILES['excel_file']['name']."', 
										num_data='".$numRows."', updatetime=NOW(); ";
		    $query = mysql_query($sqlUpload);
			echo "<script>alert('นำเข้าข้อมูลเรียบร้อย');window.location='?';</script>";
			exit();
			}
		}
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
	<title>กระบวนการนำเข้าข้อมูล</title>
	<meta name="author" content="Sapphire Research and Development" />
	<meta name="description" content="Import tools for xls to xml scheme. It support for Sapphire Research and Development Co.,Ltd. only" />
	<meta name="keywords" content="Sapphire Research and Development Co.,Ltd." />
	<meta name="application-name" content="Data export from xls to mysql and xml scheme" />
	<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" /></head>
    <script>
	function ckType_file(){
		 flile_upload = document.getElementById("excel_file");
		 flileVar = flile_upload.value;
		 arrFile = flileVar.split(".");
		 num_len = arrFile.length;
		 fileType = arrFile[(num_len-1)].toUpperCase();
		 if( fileType == "XLS" ){
			return true;
		 }else{
			 alert("อัพโหลดได้เฉพาะไฟล์ .xls เท่านั้น");
			 return false;
		 }
	}
    </script>
	
	<body style="margin:0px; font-size:14px;">

    <table width="100%" border="0" align="center">
  <tr>
    <td width="60%" style="background-color:#E7F4F0;" valign="top">
    <br/>
    <strong>นำเข้าข้อมูล</strong><br/>
    <form action="" method="post" enctype="multipart/form-data" onSubmit="return ckType_file();">
    <table width="80%" border="0">
      <tr>
        <td align="right" width="50%">นำเข้าไฟล์ Excel:&nbsp;</td>
        <td><input type="file" id="excel_file" name="excel_file" ></td>
        <td><input type="submit" name="b_import" value="นำเข้าข้อมูล"/></td>
      </tr>
    </table>
    </form>
    </td>
    <td style="background-color:#EEE;">
    	<strong>ประวัติการไฟล์นำเข้า</strong>
    	<table width="99%" border="0" cellpadding="1" cellspacing="1">
          <tr align="center" style="background-color:#CCC;">
            <td width="50">ลำดับ</td>
            <td>ไฟล์นำเข้า</td>
             <td width="100">จำนวนรายการ</td>
            <td width="180">วันที่-เวลา</td>
          </tr>
          <?php
		  $sqlLog = "SELECT * FROM `log_import_data` ORDER BY updatetime DESC";
		  $queryLog = mysql_query($sqlLog) or die(mysql_error());
		  $intLog = 0;
		  while($rowLog = mysql_fetch_assoc($queryLog)){
			  $intLog++;
          ?>
          <tr style="background-color:#FFF">
            <td align="center"><?php echo  $intLog;?></td>
            <td><a href="<?php echo $new_tmp.$rowLog['file_name'];?>" target="_blank"><?php echo $rowLog['file_comment'];?></a></td>
            <td align="right"><?php echo number_format($rowLog['num_data']);?></td>
            <td align="center"><?php echo $rowLog['updatetime'];?></td>
          </tr>
          <?php } ?>
        </table>
    </td>
  </tr>
</table>
	
	</body>
</html>