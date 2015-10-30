<?php
###################################################################
## CLASS POLICY TIMELINE STAT 
###################################################################
## Version :		20100407.001 (Created/Modified; Date.RunNumber)
## Created Date :		2010-04-07 10:09
## Created By :		Mr.KIDSANA PANYA (JENG)
## E-mail :			kidsana@sapphire.co.th
## Tel. :			084-0558131
## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
###################################################################
	session_start(); set_time_limit(0);
	define('FPDF_FONTPATH','../hr3/hr_report/fpdf/font/');
	include ("../../config/conndb_nonsession.inc.php") ;
	include ("../../common/class_policy_timeline_stat.php");
	//echo "sad";
	include ("fnc_smstunnel.php");
	include ("func_send_mail.php");
	
include('../hr3/hr_report/fpdf/fpdf.php');
include('../hr3/hr_report/kp7_class.php');
include("../hr3/hr_report/class.activitylog.php");
include("../../common/std_function.inc.php");
include("../hr3/hr_report/gif.php");
include("../hr3/hr_report/barcode/core.php");
include("../../common/class-date-format.php");
	
############  ��ǹ�ͧ��� gen pdf �ҡ�к�
$activity_id = "A0001"; // ���� log ����� PDF
$server_id = "S0001"; // ���� server
$kp7_active=1;
$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$mm_now = date("n");
$date_now = date("j");
$picture_logo = "krut.jpg" ;
$hrpicture = "../hr3/hr_report/bimg/nopicture.jpg" ;
$barcode = $_GET[barcode];
$db_temp = "cmss_pts";


function AddLogGenKp7File($siteid,$table_name_target="",$get_cz_id="",$status_orgfile="",$status_sysfile=""){
	global $db_temp;
		if($status_orgfile != ""){
				$status_orgfile1 = " ,status_orgfile='$status_orgfile' ";
		}else{
				$status_orgfile1 = "";	
		}//end if($status_orgfile != ""){
		
		if($status_sysfile != ""){
				$status_sysfile1 = " ,status_sysfile='$status_sysfile' ";
		}else{
				$status_sysfile1 = "";
		}// end if($status_sysfile != ""){
		$sql_check = "SELECT CZ_ID FROM {$table_name_target} WHERE  CZ_ID = '$get_cz_id' ";
		//echo $sql_check;
		$result_check = mysql_db_query($db_temp,$sql_check);
		$rsc = mysql_fetch_assoc($result_check);
			if($rsc[CZ_ID] != ""){
					$sql_log = "UPDATE $table_name_target SET siteid='".$siteid."' $status_orgfile1 $status_sysfile1  WHERE CZ_ID='$get_cz_id'";
			}else{
					$sql_log = "INSERT INTO $table_name_target  SET CZ_ID='$get_cz_id', siteid='".$siteid."' $status_orgfile1 $status_sysfile1";	
			}//end if($rsc[CZ_ID] != ""){
				//echo $sql_log;
			mysql_db_query($db_temp,$sql_log);
			
	}//end function AddLogCopyKp7File(){


function Rmkdir($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}


function writeimgfile($data,$hrpicture){
	$f = fopen($hrpicture,"w");
	fputs($f,$data);
	fclose($f);
}


function convert_gif2png($p_fl, $p_new_fl){
	if($gif = gif_loadFile($p_fl)) {
		// OK
		if(gif_outputAsPng($gif, $p_new_fl)) {
			// OK
			return true;
		}
		else {
			return false;
		}
	}
	else {
			return false;
	}

} // function

	
	// �ѧ��蹡� �ʴ��� �ѹ ��͹ �� ��
function  showthaidate($number){

$digit=array('�ٹ��','˹��','�ͧ','���','���','���','ˡ','��','Ỵ','���','�Ժ');
$num=array('','�Ժ','����','�ѹ','����','�ʹ','��ҹ');
$number = explode(".",$number);
$c_num[0]=$len=strlen($number[0]);
$c_num[1]=$len2=strlen($number[1]);
$convert='';
if($len > 2){
	$a1 = $len - 1 ;
	$f_digit = substr($number[0],$a1,1);
}
//�Դ�ӹǹ���
for($n=0;$n< $len;$n++){
	$c_num[0]--;
	$c_digit=substr($number[0],$n,1);
	if($c_num[0]==0&& $c_digit==0)$digit[$c_digit]='';

	if($len>1 && $len <= 2){
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='���';
	}else if ($len>3){
		if($f_digit == 0){
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='˹��';
		}else{
			if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='���';
		}
	}else{
		if($c_num[0]==0&& $c_digit==1)$digit[$c_digit]='˹��';
	}

	if($c_num[0]==0&& $c_digit==2)$digit[$c_digit]='�ͧ';
	if($c_num[0]==1&& $c_digit==0)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==1)$digit[$c_digit]='';
	if($c_num[0]==1&& $c_digit==2)$digit[$c_digit]='���'; 

	$convert.=$digit[$c_digit];
		if($c_num[0] > 0 && $c_digit != 0 && $c_digit != ""){
			$convert.=$num[$c_num[0]]; 
		}
}
$convert .= "";
if($number[1]==''){$convert .= "";}

//�Դ�ش�ȹ���
for($n=0;$n< $len2;$n++){ 
$c_num[1]--;
$c_digit=substr($number[1],$n,1);
if($c_num[1]==0&& $c_digit==1)$digit[$c_digit]='˹��';
if($c_num[1]==0&& $c_digit==2)$digit[$c_digit]='�ͧ';
if($c_num[1]==1&& $c_digit==2)$digit[$c_digit]='�ͧ'; 
if($c_num[1]==1&& $c_digit==1)$digit[$c_digit]='';
$convert.=$digit[$c_digit];
$convert.=$num[$c_num[1]]; 
}
if($number[1]!='')$convert .= "";
return $convert;

}//end function  showthaidate($number){

############################################## ��ǹ�ͧ��� gen �ҡ�к�	//echo "sad";

	function queueNumError($profile_id=""){
		$dbname_pts = "cmss_pts";
		$sql_SelectQueueNumError = " SELECT
					cmss_pts.pts_log_timeline_stat.siteid,
					count(cmss_pts.pts_log_timeline_stat.table_name) AS countTable,
					".DB_MASTER.".eduarea.secname
					FROM
					cmss_pts.pts_log_timeline_stat
					Inner Join ".DB_MASTER.".eduarea ON ".DB_MASTER.".eduarea.secid = cmss_pts.pts_log_timeline_stat.siteid WHERE pts_log_timeline_stat.profile_id='".$profile_id."' AND status_id <> '1' AND pts_log_timeline_stat.profile_status_id IN( SELECT MAX(pts_log_timeline_stat.profile_status_id) FROM pts_log_timeline_stat WHERE pts_log_timeline_stat.profile_id='".$profile_id."' )  AND pts_log_timeline_stat.profile_status_id IN(SELECT MAX(pts_profile_status.status_id) FROM pts_profile_status WHERE pts_profile_status.profile_id='".$profile_id."' AND ( profile_status='Play' OR  profile_status='Replay'  OR  profile_status='Resume'  ) ) GROUP BY pts_log_timeline_stat.siteid HAVING countTable >= 1 ";
		$Query_SelectQueueNumError = mysql_db_query($dbname_pts,$sql_SelectQueueNumError);
		$RowNumError = mysql_num_rows($Query_SelectQueueNumError);
		return $RowNumError;
	}

	$dateTime = intval(date("H"));
	$workname="�к����ͧ�ԧʶԵ� � ��ǧ����" ;
	$email_sys = "service@sapphire.co.th";
	$id = "";

	if( $dateTime >= 0 ){
		//echo "xxxx";die;
	//(($dateTime >= 0 && $dateTime < 8) || ($dateTime >= 20 && $dateTime <=24 )) || $_GET['run_time']=='on'
	// $dateTime >= 0
	$query_check = mysql_db_query('cmss_pts',"SELECT queue_id FROM pts_queue_process WHERE queue_status = 'Working'  ") or die(mysql_error());
	$num_check = mysql_num_rows($query_check);
		//echo $num_check;die;
		if($num_check == 0){//�������ա�û���ǳ��
		//echo $num_check;die;
			$query = mysql_db_query('cmss_pts',"SELECT *  FROM pts_queue_process WHERE (queue_status = 'Play' OR queue_status = 'Resume') ORDER BY queue_profile_id ASC LIMIT 0,1 ");//AND queue_date <= '".date('Y-m-d')."' 
			$num_wait = mysql_num_rows($query);
			//echo "xxx".$num_wait;die;
			if($num_wait > 0){

				$rows = mysql_fetch_array($query);//���¡������
				$queryIndex = mysql_db_query('cmss_pts',"SELECT *  FROM pts_profile_index WHERE profile_id='".$rows['queue_profile_id']."'  ");
				$rowsIndex = mysql_fetch_array($queryIndex);//���¡������
				mysql_db_query('cmss_pts',"UPDATE pts_queue_process SET queue_status = 'Working', queue_start_process=NOW() WHERE queue_id = '".$rows['queue_id']."' ");//���ʶҹ��� working

					$siteid_sent = $rows['queue_siteid']; // ����ࢵ
					$dbsite = STR_PREFIX_DB.$rows['queue_siteid']; // �ҹ�����Ţͧࢵ���з�ҡ� backup ������
					function get_picture($id){
					global $siteid_sent;
					$imgpath = "../../../edubkk_image_file/$siteid_sent/";
					$ext_array = array("jpg","jpeg","png","gif");
					if ($id <= "") return "";
				
					for ($i=0;$i<count($ext_array);$i++){
						$img_file = $imgpath . $id . "." . $ext_array[$i];
						if (file_exists($img_file)) return $img_file;
					}
				
					return "";
				}


				$PTS = new policy_timeline_stat($rows['queue_profile_id'], $rows['queue_siteid']);
				$dbname_cmss = DB_MASTER;
				$setNameTable = "_".$PTS->profile_id."_".$rowsIndex['number_active']; //���͵����ѧ���ҧ 㹡�����ͧ������ 
				//echo "id :: ".$setNameTable;die;
				#�ҵ��ҧ�ҹ�����ŷ����� allschool_ ��е�ʹ��� profile_id ����ըӹǹ���ҧ�����ҧ
				$table_view_general = " WHERE `Tables_in_{$PTS->dbnamePTS}` = 'allschool{$setNameTable}' ";
				$countTable_allschool = $PTS->countTable($PTS->dbnamePTS,$table_view_general);

				#�ҵ��ҧ�ҹ�����ŷ����� view_general_ ��е�ʹ��� profile_id ����ըӹǹ���ҧ�����ҧ
				$table_view_general = " WHERE `Tables_in_{$PTS->dbnamePTS}` = 'view_general{$setNameTable}' ";
				$countTable_view_general = $PTS->countTable($PTS->dbnamePTS,$table_view_general);

				#�ҵ��ҧ�ҹ�����ŷ����� view_j18_ ��е�ʹ��� profile_id ����ըӹǹ���ҧ�����ҧ
				$table_view_j18 = " WHERE `Tables_in_{$PTS->dbnamePTS}` = 'view_j18{$setNameTable}' ";
				$countTable_view_j18 = $PTS->countTable($PTS->dbnamePTS,$table_view_j18);
				
				###  �ҵ��ҧ pts_log_gen_kp7file_��е�ʹ��� profile_id
				$table_pts_log_gen_kp7file =  " WHERE `Tables_in_{$PTS->dbnamePTS}` = 'pts_log_gen_kp7file {$setNameTable}' ";
				$countTable_pts_loggen = $PTS->countTable($PTS->dbnamePTS,$table_pts_log_gen_kp7file);
				
				#�ҡ����յ��ҧ�ҹ�����ŷ����� view_j18_ ��е�ʹ��� profile_id ���ӡ�����ҧ���ҧ������ç���ҧ
				if($countTable_allschool == 0){
					$PTS->createTable($dbname_cmss, 'allschool', 'allschool'.$setNameTable);
				}

				#�ҡ����յ��ҧ�ҹ�����ŷ����� view_general_ ��е�ʹ��� profile_id ���ӡ�����ҧ���ҧ������ç���ҧ
				if($countTable_view_general == 0){
					$PTS->createTable($dbname_cmss, 'view_general', 'view_general'.$setNameTable);
				}

				#�ҡ����յ��ҧ�ҹ�����ŷ����� view_j18_ ��е�ʹ��� profile_id ���ӡ�����ҧ���ҧ������ç���ҧ
				if($countTable_view_j18 == 0){
					$PTS->createTable($dbname_cmss, 'view_j18', 'view_j18'.$setNameTable);
				}

				#��ҧ������㹵��ҧ�ҹ������ �ҡ��ͧ��� replace
				if($rows['queue_status'] =="Resume"){
					$PTS->truncateTable('allschool'.$setNameTable);
					$PTS->truncateTable('view_general'.$setNameTable);
					$PTS->truncateTable('view_j18'.$setNameTable);
				}
				###  �ӡ�äѴ�͡��� pdf �鹩�Ѻ
				# �ҡ���ҧ log �����㹴��Թ������ҧ���ҧ����͹
				if($countTable_pts_loggen == 0){
					$PTS->createTable($PTS->dbnamePTS, 'pts_log_gen_kp7file', 'pts_log_gen_kp7file'.$setNameTable);	
				}
				##�ӡ�äѴ�͡���
				$PTS->CopyKp7FileOriginal($dbname_cmss,"view_general","pts_log_gen_kp7file".$setNameTable,$setNameTable);
###########################################################################   ��ǹ�ͧ��� gen pdf �ҡ�к�
###########################################################################
###########################################################################"
				$his_name = "";
				$his_name1 = "";
				
	$sqlm = " SELECT DISTINCT ".DB_MASTER.".allschool.id AS id1,".DB_MASTER.".allschool.office,$dbsite.general.idcard,$dbsite.general.name_th,$dbsite.general.surname_th,$dbsite.general.approve_status FROM ".DB_MASTER.".allschool INNER JOIN $dbsite.general  ON $dbsite.general.schoolid = ".DB_MASTER.".allschool.id ORDER BY $dbsite.general.schoolid ASC "  ;
//echo "$dbsite :: ".$sqlm;die;
$resultm = mysql_db_query($dbsite,$sqlm);
while($rsm = mysql_fetch_assoc($resultm)){
	
if($rsm[approve_status] == "approve"){
	$set_wk =1 ;$word_wk="����";
	$genbarcode = true;
}else{
	$set_wk =1 ;$word_wk="���������ҧ��Ǩ�ͺ";
	$genbarcode = false;
}
if($preview_status==1){
	$set_wk =1 ;$word_wk="Preview";
	$genbarcode = false;
}

	$x_path = "../../../kp7file_pts_system/$setNameTable/$siteid_sent/";
	
	if(!(is_dir($x_path))){
		Rmkdir($x_path);
	}//if(!(is_dir($x_path))){
		
	$id = "$rsm[idcard]";	 // ���ʺѵû�ЪҪ�
mysql_select_db($dbsite);
$pdf=new KP7();
$pdf->AliasNbPages();
$pdf->AddThaiFonts();
$pdf->AddPage();

$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id' ";
		$result = mysql_db_query($dbsite,$sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);
		$date_bd = explode("-",$rs[birthday]); // �ѹ�Դ
		$getidcard = 	$rs[idcard] ;
			if ($rs[contact_tel] == ""){
				$xcontact_tel = " - ";
			}else{
				$xcontact_tel = $rs[contact_tel];
			}
		$rs[contact_add] = str_replace("�.","�Ӻ�",$rs[contact_add]);
		$rs[contact_add] = str_replace("�.","�����",$rs[contact_add]);
		$rs[contact_add] = str_replace("�.","�ѧ��Ѵ",$rs[contact_add]);
		$hrpicture = array();
		$np = 0;
	$xresult = mysql_db_query($dbsite," select * from general_pic where id='$id' and kp7_active='$kp7_active' order by no ;");
		while ($xrs = mysql_fetch_assoc($xresult)){
			$img_file = "../../../../edubkk_image_file/$rs[siteid]/$xrs[imgname]";
			$hrpicture[$np] = $img_file;
			$hrpicture_yy[$np] = $xrs[yy];
			$x = explode(".",$img_file);
			$ext[$np] = strtoupper($x[count($x) - 1]);
			if ($ext[$np] == "GIF"){
				$hrpicture[$np] = "bimg/temppicture.png" ;	
				convert_gif2png($img_file,$hrpicture[$np]);
				$ext[$np] = "PNG";

			}
			$np++;
		}

//------ �ʴ��ٻ ----------
				
		$pdf->Image("$picture_logo",100,5,14,17,"JPG",'');
$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(71,10);
$pdf->Cell(71,30,'�������Ӥѭ�����',0,0,'C');
			
$pdf->SetXY(10,30); // ��ǹ�ʴ���ͺ�ٻ

			$col_width = array(27,27,27,27,27,27,27); // ��˹��������ҧ column
			$col_height = 31;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height," ",1,0,'C');


			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height," ",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height," ",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],$col_height," ",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],$col_height," ",1,0,'C');

			$x += $col_width[4];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],$col_height," ",1,0,'C');

			$x += $col_width[5];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],$col_height," ",1,0,'C');

$pdf->SetXY(8,30); // ��ǹ�ʴ��ٻ

			$col_width = array(27,27,27,27,27,27,27); // ��˹��������ҧ column
			$col_height = 24;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[0]) $pdf->Image($hrpicture[0],$x+4,$y+1,23,30,$ext[0],'C');


			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[1]) $pdf->Image($hrpicture[1],$x+4,$y+1,23,30,$ext[1],'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[2]) $pdf->Image($hrpicture[2],$x+4,$y+1,23,30,$ext[2],'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[3]) $pdf->Image($hrpicture[3],$x+4,$y+1,23,30,$ext[3],'C');

			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[4]) $pdf->Image($hrpicture[4],$x+4,$y+1,23,30,$ext[4],'C');

			$x += $col_width[4];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[5]) $pdf->Image($hrpicture[5],$x+4,$y+1,23,30,$ext[5],'C');

			$x += $col_width[5];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			if ($hrpicture[6]) $pdf->Image($hrpicture[6],$x+4,$y+1,23,30,$ext[6],'C');

$pdf->SetXY(10,61); // ��ǹ�ʴ���ͧ �� �.�.
			
			$col_width = array(27,27,27,27,27,27,27); // ��˹��������ҧ column
			$col_height = 10;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			//�ó�����к� �.�. �ٻ��� 1
			if($hrpicture_yy[0] >0){
			$pdf->Cell($col_width[0],($col_height/2),"�.�. $hrpicture_yy[0]",0,0,'C');
			}else if($hrpicture[0] !=""){
			$pdf->Cell($col_width[0],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[0],($col_height/2),"�.�.",0,0,'C');
			}
			// �� if 1
	


			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// �ó�����к� �.�. �ٻ��� 2
			if($hrpicture_yy[1] >0){
			$pdf->Cell($col_width[1],($col_height/2),"�.�. $hrpicture_yy[1]",0,0,'C');
			}else if($hrpicture[1] !=""){
			$pdf->Cell($col_width[1],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[1],($col_height/2),"�.�.",0,0,'C');
			}
			// �� if 2
		

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// �ó�����к� �.�. �ٻ��� 3
			if($hrpicture_yy[2] >0){
			$pdf->Cell($col_width[2],($col_height/2),"�.�. $hrpicture_yy[2]",0,0,'C');
			}else if($hrpicture[2] !=""){
			$pdf->Cell($col_width[2],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[2],($col_height/2),"�.�.",0,0,'C');
			}
			// �� if 3
		

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// �ó�����к� �.�. �ٻ��� 4
				if($hrpicture_yy[3] >0){
				$pdf->Cell($col_width[3],($col_height/2),"�.�. $hrpicture_yy[3]",0,0,'C');
				}else if($hrpicture[3] !=""){
				$pdf->Cell($col_width[3],($col_height/2),"�.�. ����к�",0,0,'C');
				}else{
				$pdf->Cell($col_width[3],($col_height/2),"�.�.",0,0,'C');
				}
				// �� if 4
			

			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// �ó�����кػվ.�.
			if($hrpicture_yy[4] >0){
			$pdf->Cell($col_width[4],($col_height/2),"�.�. $hrpicture_yy[4]",0,0,'C');
			}else if($hrpicture[4] !=""){
			$pdf->Cell($col_width[4],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[4],($col_height/2),"�.�.",0,0,'C');
			}
			// ��


			$x += $col_width[4];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
				// �ó������ �.�.
			if($hrpicture_yy[5] >0){
			$pdf->Cell($col_width[5],($col_height/2),"�.�. $hrpicture_yy[5]",0,0,'C');
			}else if($hrpicture[5] !=""){
			$pdf->Cell($col_width[5],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[5],($col_height/2),"�.�. ",0,0,'C');
			}
			
			//��
			

			$x += $col_width[5];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height/2),"�ٻ��� �",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height),"",1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			
			// �ó�����кػվ.�.
			if($hrpicture_yy[6] >0){
			$pdf->Cell($col_width[6],($col_height/2),"�.�. $hrpicture_yy[6]",0,0,'C');
			}else if($hrpicture[6] !=""){
			$pdf->Cell($col_width[6],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[6],($col_height/2),"�.�. ",0,0,'C');
			}
			
			//�� if
	

$pdf->SetXY(10,71); // ��÷Ѵ ���� �ѹ ��͹ ���Դ

			$activitylog_name = "$rs[prename_th] $rs[name_th]";
			$activitylog_sername = "$rs[surname_th]";
			$activitylog_idcard = "$rs[idcard]";

			$col_width = array(189); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			
		$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id'  ;";
		$result = mysql_db_query($dbsite,$sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

$date_d = explode("-",$rs[startdate]); // �ѹ��觺�è�
$date_bd = explode("-",$rs[birthday]); // �ѹ�Դ
		$sqld="select * from general where id='$id' ";
					$qd2=mysql_db_query($dbsite,$sqld);
					$rsd2=mysql_fetch_array($qd2);
					$adsd2=$rsd2[type_dateshow];
					$sqlshow="select type_date,type_nec from type_showdate where id_type='$adsd2' ";
					$qshow=mysql_db_query($dbsite,$sqlshow);
					$rsshow1=mysql_fetch_array($qshow);	
			if($rsshow1[type_nec]=="n" )
		 {
		 	$b_birth=$rsshow1[type_date];
		 }

		else
		 {		
		//if($adsd2 ==300 or $adsd2==299or $adsd2==293or $adsd2==292)
			//  if($adsd2 !=293 or $adsd2 !=299 or $adsd2 != 292 or $adsd2 !=300)
			 if($adsd2 ==341 or $adsd2==351or $adsd2==361 or $adsd2==371)
				 {
				$b_day1 = new date_format;
				$year_d=($date_bd[0]-543);
				$b_birth= $b_day1->show_date($rsshow1[type_date],$year_d."-".$date_bd[1]."-".$date_bd[2]);
			 	
				 }
			else
				{
				$b_birth=intval($date_bd[2])." ��͹ ".$monthname[intval($date_bd[1])]." �.�.".$date_bd[0];
				}
		}	
			// ������� �Դ�Դ��ǹ����ʴ��Ū�����Ңͧ��7
			$strSQL=mysql_query("SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
			$num_row_name=mysql_num_rows($strSQL);
			
			if($num_row_name > 0){
				$sql_history_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active <> '$kp7_active' ORDER BY runno DESC";
				$result_h_name = mysql_query($sql_history_name);
				$his_name= "";
				while($rsh1 = mysql_fetch_assoc($result_h_name)){
					$his_name .= " ($rsh1[prename_th]$rsh1[name_th]  $rsh1[surname_th]) ";
				} //end while($rsh1 = mysql_fetch_assoc($result_h_name)){

					$strRs=mysql_fetch_assoc($strSQL);
					$txt_his_name = "�.  ���� $strRs[prename_th] $strRs[name_th] $strRs[surname_th]".$his_name." �Դ�ѹ��� $b_birth";
					$arr_name1 = array(); 
					$arr_name1 = $pdf->alignstr($txt_his_name,160);
					$num_name1 = count($arr_name1); // check �ӹǹ��÷Ѵ column 1
					if($num_name1 == "1"){
						$pdf->Cell($col_width[0],$col_height,"$txt_his_name ",1,0,'L');
						$y=$y+$col_height;
					}else{
						$pdf->Cell($col_width[0],($col_height*$num_name1)," ",1,'L');
						for($n=0;$n<$num_name1;$n++){
							//if(($num_name1-$n) == 1){ $border_line = 1;}else{ $border_line = 0;}
							$pdf->SetXY($x ,$y);
							$pdf->Cell($col_width[0],$col_height,"$arr_name1[$n]",0,0,'L');
							$y=$y+$col_height;
						}

					}//end if($num_name1 == "1"){
					//$pdf->Cell($col_width[0],$col_height,"�.  ���� $strRs[prename_th] $strRs[name_th] $strRs[surname_th]    �Դ�ѹ���  ".$b_birth.'',1,0,'L');
					
					
					}else{
					
			$sql_history_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active <> '$kp7_active' ORDER BY runno DESC";
			$result_h_name = @mysql_query($sql_history_name);
			$k=0;
			$xhis_name = "";
			while($rsh1 = @mysql_fetch_assoc($result_h_name)){
			$k++;
				if($k > 1){ // �����Һ�÷Ѵ�á㹡ó�����ա�á�˹� ʶҹ������ʴ���� �.�.7
				$xhis_name .= " ($rsh1[prename_th]$rsh1[name_th]  $rsh1[surname_th]) ";
				}// end if($k > 1){
			}// end while($rsh1 = @mysql_fetch_assoc($result_h_name)){

					
					
					
				$sql_noAt = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' ORDER BY runno DESC LIMIT 0,1 ";
				$result_noAt = mysql_query($sql_noAt);
				$rs_noAt = mysql_fetch_assoc($result_noAt);
				
				$txt_his_name = "�. ���� $rs_noAt[prename_th]$rs_noAt[name_th]  $rs_noAt[surname_th]".$xhis_name." �Դ�ѹ��� $b_birth";
				$arr_name1 = array(); 
				$arr_name1 = $pdf->alignstr($txt_his_name,160);
				$num_name1 = count($arr_name1); // check �ӹǹ��÷Ѵ column 1
				if($num_name1 == 1){
					$pdf->Cell($col_width[0],$col_height,"$txt_his_name",1,0,'L');
					$y=$y+$col_height;
				}else{
					$pdf->Cell($col_width[0],($col_height*$num_name1)," ",1,'L');
					for($n=0;$n<$num_name1;$n++){
						
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"$arr_name1[$n]",0,0,'L');
						$y=$y+$col_height;
					}
				}//end 	if($num_name1 == 1){

				
				
		//$pdf->Cell($col_width[0],$col_height,"�.  ���� $rs_noAt[prename_th]$rs_noAt[name_th]  $rs_noAt[surname_th]   �Դ�ѹ��� ".$b_birth.'',1,0,'L');

					}// end if($num_row_name > 0){
				//�����ǹ�ͧ��ûԴ�Դ����ʴ�����¡�â����Ţͧ�ؤ��
			/*$pdf->Cell($col_width[0],$col_height,"�.  ���� $rs[prename_th] $rs[name_th] $rs[surname_th]    �Դ�ѹ���  ".intval($date_bd[2])."  ��͹ ".$monthname[intval($date_bd[1])]."  �.�. ".$date_bd[0].'',1,0,'L');
*/
// �ѹ�֡ log gen barcode
if($genbarcode == true){
	$temp_pdf_path = "";
	$expire_date = "";
	$activitylog_admin_id = $_SESSION[idoffice];
	$activitylog_admin_office = $_SESSION[office_name];
	$activitylog_admin_office_sname = $_SESSION[office_sername];
	$makelog = new activity_log;
	$makelog->save_log("$activitylog_idcard","$activitylog_name","$activitylog_sername","$server_id","$activity_id","$temp_pdf_path","$expire_date","$activitylog_admin_id","$activitylog_admin_office","$activitylog_admin_office_sname");
	$activitylog_barcode =  $makelog->getbarcode();
	$makelog->update_temp();
}

///

$pdf->SetXY(10,79); // ��÷Ѵ �������

			$col_width = array(189); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			// ������鹡�ûԴ�Դ����ʴ��Ţ����� �������㹡�7
			$strSQL1=mysql_db_query($dbsite,"SELECT * FROM hr_addhistoryaddress WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
				$num_row_address=mysql_num_rows($strSQL1);
					if($num_row_address != ""){
						$Rs1=mysql_fetch_assoc($strSQL1);
					$pdf->Cell($col_width[0],$col_height,"�.  �������Ѩ�غѹ  ��ҹ�Ţ��� $Rs1[address] ���Ѿ�� $xcontact_tel",1,0,'L');
					}else{
					$pdf->Cell($col_width[0],$col_height,"�.  �������Ѩ�غѹ  ���Ѿ�� $xcontact_tel",1,0,'L');
					}
			// ����ûԴ�ԡ����ʴ��Ţ����ŷ������� ��7
			
		//	$pdf->Cell($col_width[0],$col_height,"�.  �������Ѩ�غѹ  ��ҹ�Ţ��� $rs[contact_add] ���Ѿ�� $xcontact_tel",1,0,'L');

$pdf->SetXY(10,87); // ��÷Ѵ ����ͧ�Ҫ��������ó�

			$col_width = array(189); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�.  ����ͧ�Ҫ��������ó� �ѹ������Ѻ����ѹ�觤׹ �������͡�����ҧ�ԧ",1,0,'L');

$pdf->SetXY(10,95); // ��ǵ��ҧ����������ͧ�Ҫ

			$col_width = array(20,69,20,15,15,15,15,20); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�ѹ������Ѻ",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"����ͧ�Ҫ �/����­���",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"�ӴѺ���",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"�������",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),"����",1,0,'C');

			$x += $col_width[4];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height),"�͹",1,0,'C');

			$x += $col_width[5];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height),"˹��",1,0,'C');

			$x += $col_width[6];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[7],($col_height),"ŧ�ѹ���",1,0,'C');

// ����� query ����������ͧ�Ҫ

			$y =  $pdf->GetY();
			$y = $y+($col_height);
		$sql = "select * from getroyal where id = '$id' and kp7_active='$kp7_active' order by orderid,date asc; ";
		$result = mysql_db_query($dbsite,$sql);
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
			$date_g = explode("-",$rs[date]); // �ѹ������Ѻ
			$date_g2 = explode("-",$rs[date2]); // ŧ�ѹ���
			$x = $pdf->lMargin;
			$col_height = 5;
if($rs[label_date2] !="")
			{
				$date2=$rs[label_date2];
			}
			else
			{
			if($rs[date2] != " "){
			if($date_g2[2] !=0 and $date_g2[1] !=0 and $date_g2[0] !=0 )
			{
			$date2 = intval($date_g2[2])." ".$monthsname[intval($date_g2[1])]. " " .$date_g2[0] ;
			//$date2=$monthsname[intval($date_g2[1])]. " " .$date_g2[0] ;
			}
			else if($date_g2[2]==0 and $date_g2[1]==0  and $date_g2[0]==0 )
			{
			$date2="";
			}
			
			else if($date_g2[2] ==0 and $date_g2[1]==0 )
			{
			$date2=$date_g2[0] ;
			}
			else if($date_g2[2] ==0)
			{
					$date2=$monthsname[intval($date_g2[1])]. " " .$date_g2[0] ;
			}
		}
	}
	if($rs[label_date] !="")
		{
			$date1=$rs[label_date];
		}
	else
		{
			if($rs[date] !="0-0-0")
			{
			$date1 = intval($date_g[2])." ".$monthsname[intval($date_g[1])]." ".$date_g[0];
			}
			else
			{
				$date1="";
			}
		}//END 

			$pdf->SetFont('Angsana New','',12);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height," $date1",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$rs[getroyal]",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"$rs[no]",1,0,'C');

			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"$rs[bookno]",1,0,'C');

			$x += $col_width[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),"$rs[book]",1,0,'C');

			$x += $col_width[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height),"$rs[section]",1,0,'C');

			$x += $col_width[5];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[6],($col_height),"$rs[page]",1,0,'C');

			$x += $col_width[6];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[7],($col_height),"$date2",1,0,'C');

			$y +=  $col_height;
		}

// �ӹǹ�ѹ��

$row1_y = $pdf->GetY();

			$x = $pdf->lMargin;
			$y = $row1_y+$col_height;
			$col_height = 6;

		$sql = "select * from hr_absent where id='$id' order by yy; ";
		$result = mysql_db_query($dbsite,$sql);
		$num_row = mysql_num_rows($result);
		if ((12+($num_row*5)+$y) > 265) {$pdf->AddPage();$y=30;}

$pdf->SetXY($x,$y); 
$pdf->SetFont('Angsana New','',12);
$pdf->Cell(189,$col_height,"�. �ӹǹ�ѹ����ش�Ҫ��� �Ҵ�Ҫ��� �����",1,1,'L');

			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;

$pdf->SetXY($x,$y);

			$col_width = array(21,21,36,37,37,37);
			$col_height = 12;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�.�.",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"�һ���",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"�ҡԨ��оѡ��͹",1,0,'C');

			$x += $col_width[2];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"�����",1,0,'C');

			$x += $col_width[3];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),"�Ҵ�Ҫ���",1,0,'C');

			$x += $col_width[4];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height),"���֡�ҵ��",1,0,'C');

// ����� query ������ �ѹ��*******************************************************************************************************************

	while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
	
			$y += $col_height;
			if (($y) > 260) {$pdf->cfooter();$pdf->AddPage();$pdf-> absentheader();$y=42;}
			
            $tem_0="0";
			$arr_str1 = array(); 
			if($rs[label_education] !=""){
			$arr_str1 = $pdf->alignstr($rs[label_education],30);
			}else if($rs[other_absent] !=""){
			$arr_str1 = $pdf->alignstr($rs[other_absent],30);
			}else if($rs[label_birth] !=""){
			$arr_str1 = $pdf->alignstr($rs[label_birth],30);
			}else if($rs[etc] !=0){
			$tem_etc="�Ҿ���� ".$rs[etc]." �ѹ";
			$arr_str1 = $pdf->alignstr($tem_etc,50);
			}else if($rs[birth] !=0){
			$tem_birth="�Ҥ�ʹ ".$rs[birth]." �ѹ";
			$arr_str1 = $pdf->alignstr($tem_birth,50);
			}else if($rs[education] >363){
			$absent_a="���֡�ҵ��";
			$arr_str1 = $pdf->alignstr($absent_a,30);
			}else if($rs[education] <364){
			$arr_str1 = $pdf->alignstr($rs[education],30);
			}else{
			$arr_str1 = $pdf->alignstr($tem_0,30);
			}
			$num_arr1 = count($arr_str1); // check �ӹǹ��÷Ѵ column 1
			//------------------------------------------------------------------------------------------------------------------------------------
			if($rs[label_yy] !=""){//��Ǩ�ͺ����ʴ���㹪�ͧ ��
			$str_yy=$rs[label_yy];
			}else{
			$str_yy=$rs[yy];
			}
			//---------------------
			if($rs[label_sick] !=""){// ��Ǩ�ͺ����ʴ���㹪�ͧ ����
			$str_sick=$rs[label_sick];
			}else{
			$str_sick=$rs[sick];
			}
			//---------------
			if($rs[label_dv] !=""){//��Ǩ�ͺ����ʴ��� �Ҿ����
			$str_duty=$rs[label_dv];
			}else{
			$str_duty=$rs[duty]+$rs[vacation];
			}
			//----------------
			if($rs[label_late] !=""){// ��Ǩ�ͺ����ʴ��� ��������
			$str_late=$rs[label_late];
			}else{
			$str_late=$rs[late];
			}
			//-----------------
			if($rs[label_absent] !=""){
			$str_absent=$rs[label_absent];
			}else{
			$str_absent=$rs[absent];
			}
			//------------------------------------------------------------------------------------------------------------------------------------
			// �ӡ���¡ ʵ�ԧ 
			if($rs[label_yy] !=""){
			$arr_year=explode(",",$rs[label_yy]);
			$num_arr_year=count($arr_year);
			}else{
			$arr_year=explode(" ",$rs[yy]);
			$num_arr_year=count($arr_year);
			}
			
			
			$x = $pdf->lMargin;	
			$col_height = 5;
			
		if(($num_arr1==1)and($num_arr_year==1)){// �ó��պ�÷Ѵ����
		
			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			
			if($rs[merge_col]==1)
			{$pdf->Cell(($col_width[0]+$col_width[1]+$col_width[2]+$col_width[3]+$col_width[4]+$col_width[5]),($col_height),"         $rs[special_exp]",1,0,'L');}
			else
			{
			$pdf->Cell($col_width[0],($col_height),"$str_yy",1,0,'C');


			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"$str_sick",1,0,'C');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"$str_duty",1,0,'C');

			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"$str_late",1,0,'C');			

			$x += $col_width[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),"$str_absent",1,0,'C');

			$x += $col_width[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height),"$arr_str1[0]",1,0,'C');		
		}

	}else{
	
			if($num_arr1>$num_arr_year){ $loop1=$num_arr1; }else{ $loop1=$num_arr_year; }
				for ($n=0;$n<$loop1;$n++) {
				$y1 = $y ;
				$y1 = $y1 + $col_height ;
				$flagaddpage = 0; // ���������Ѻ�� loop ���˹������
				if($y1 >= 260){ 
				$pdf->cfooter(270);$pdf->AddPage();$pdf-> absentheader();
					if($loop1>1){
						$y=30+$col_height;
						if($n==0){
						$flagaddpage = 0;
						}else{
						$flagaddpage = 1;
						}
					}else{
						$y=30;
					}
				} // new page if row > 270
				
		if($n==0){	
			if($num_arr1==1){
					$x = $pdf->lMargin;	
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');
					
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"$str_sick",1,0,'C');

					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"$str_duty",1,0,'C');

					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height*$loop1),"$str_late",1,0,'C');

					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height*$loop1),"$str_absent",1,0,'C');

					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[5],($col_height*$loop1),"$arr_str1[$n]",1,0,'C');
					
			}//  end ($num_arr1==1)
			if($num_arr_year==1){
					$x = $pdf->lMargin;	
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"$arr_year[$n]",1,0,'C');

					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"$str_sick",1,0,'C');

					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"$str_duty",1,0,'C');

					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height*$loop1),"$str_late",1,0,'C');

					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height*$loop1),"$str_absent",1,0,'C');
					
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[5],($col_height*$loop1),"",1,0,'C');

			}// end if $num_arr_yeay
					
					if(($num_arr1>1)and($num_arr_year>1)){//�ó������º�÷Ѵ
									$x = $pdf->lMargin;	
									$pdf->SetXY($x ,$y);
									$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');

									$x += $col_width[0];
									$pdf->SetXY($x ,$y);
									$pdf->Cell($col_width[1],($col_height*$loop1),"$str_sick",1,0,'C');
						
									$x += $col_width[1];
									$pdf->SetXY($x ,$y);
									$pdf->Cell($col_width[2],($col_height*$loop1),"$str_duty",1,0,'C');

									$x += $col_width[2];
									$pdf->SetXY($x ,$y);
									$pdf->Cell($col_width[3],($col_height*$loop1),"$str_late",1,0,'C');
															
									$x += $col_width[3];
									$pdf->SetXY($x ,$y);
									$pdf->Cell($col_width[4],($col_height*$loop1),"$str_absent",1,0,'C');

									$x += $col_width[4];
									$pdf->SetXY($x ,$y);
									$pdf->Cell($col_width[5],($col_height*$loop1),"",1,0,'C');
					}// end if ($num_arr1>1)
			}	// end if ($n==0)
			
		if($n<$loop1 && $n != 0 ){$y  += $col_height;}
		
			if($flagaddpage==0){ // �����˹������  
			
				if($num_arr1==1){
					$x = $pdf->lMargin;
			
					$pdf->SetXY($x ,$y);

						$pdf->SetFont('Angsana New','',10);
						$pdf->Cell($col_width[0],$col_height,"$arr_year[$n]",0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,'',0,0,'C');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,'',0,0,'C');
			
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height),'',0,0,'C');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),'',0,0,'C');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),'',0,0,'C');
				
				}//end if($num_arr1==1)
				if($num_arr_year==1){
					$x = $pdf->lMargin;
					$pdf->SetXY($x ,$y);

						$pdf->SetFont('Angsana New','',10);
						$pdf->Cell($col_width[0],$col_height,'',0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,'',0,0,'C');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,'',0,0,'C');
			
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height),'',0,0,'C');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),'',0,0,'C');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),"$arr_str1[$n]",0,0,'C');
				
				}//end if($num_arr_year)

				if(($num_arr1>1)and($num_arr_year>1)){
				
					$x = $pdf->lMargin;
					$pdf->SetXY($x ,$y);
						$pdf->SetFont('Angsana New','',10);
						$pdf->Cell($col_width[0],$col_height,"$arr_year[$n]",0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,'',0,0,'C');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,'',0,0,'C');
			
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height),'',0,0,'C');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),'',0,0,'C');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),"$arr_str1[$n]",0,0,'L');
				}
			}else{
				$y = $y + $col_height;
				$x = $pdf->lMargin;
				$pdf->SetXY($x ,$y);
				$pdf->Cell($col_width[0],($col_height),"$arr_year[$n]",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"",1,0,'C');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"",1,0,'C');


			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"",1,0,'C');

			$x += $col_width[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),"",1,0,'C');

			$x += $col_width[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height),"$arr_str1[$n]",1,0,'L');
			
			
			}// end else if $flagaddpage==0
		} // end for
	}// end if else
} // end while

//****************************************************============================================= ������ҢҴ���
// ��������ö�����

$pdf->AddPage();

$pdf->SetFont('Angsana New','',14);
$pdf->SetXY(71,10);
$pdf->Cell(71,30,'�������Ӥѭ�����',0,0,'C');

$pdf->SetXY(10,30);

			$col_width = array(189); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�.  ��������ö�����",1,0,'L');

		$sql = "select t1.*,t2.major as majorname,t3.groupname from special t1 left join $dbnamemaster.hr_addmajor t2 on t1.major=t2.runid left join $dbnamemaster.specialgroup t3 on t1.specialgroup=t3.runid where t1.id='$id' and t1.kp7_active='$kp7_active' order by t1.runno asc";
		$result = mysql_db_query($dbsite,$sql);

$pdf->SetXY(10,38);

			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;

			$pdf->SetXY($x,$y);

			$col_width = array(189);
			$col_height = 6;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

/*			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�Ң�",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"�������������ö",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"��������´",1,0,'C');

		$y =  $pdf->GetY();
		$y = $y+($col_height);
		$col_height = 5;
*/
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[detail],145);
			$num_arr1 = count($arr_str1);

			$x = $pdf->lMargin;

			if($num_arr1 == 1){ // �պ�÷Ѵ����

			$pdf->SetFont('Angsana New','',12);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"$rs[detail]",1,0,'L');

/*			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$rs[groupname]",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"$rs[detail]",1,0,'L');
*/			
			$y +=  $col_height;

			}else{ // �����º�÷Ѵ

			for ($n=0;$n<$num_arr1;$n++) {
			$y1 = $y ;
			$y1  += $col_height;
			if($y1 >= 265){$pdf->AddPage();}
			
			if($n==0){ // ��¹��÷Ѵ�á

			$pdf->SetFont('Angsana New','',14);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$num_arr1),"",1,0,'L');

/*			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$num_arr1),"$rs[groupname]",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height*$num_arr1),"",1,0,'L');
*/
			} // end if ��¹��÷Ѵ����ͧ

			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
			$x = $pdf->lMargin;

			$pdf->SetFont('Angsana New','',14);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');

/*			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"",0,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"$arr_str1[$n]",0,0,'L');
*/
			if($n==($num_arr1-1)){$y += $col_height;}

			} // end else
			} // end 
			} // end while

// ��û�Ժѵ��Ҫ��þ����
			$row1_y = $pdf->GetY();

			$x = $pdf->lMargin;
			$y = $row1_y+($col_height+2);
			$col_height = 8;

$pdf->SetXY($x,$y); 
$pdf->SetFont('Angsana New','',12);
$pdf->Cell(189,$col_height,'�. ��û�Ժѵ��Ҫ��þ����',1,1,'L');

			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;

$pdf->SetXY($x,$y); // ��˹���ǵ��ҧ������

			$col_width = array(20,169);
			$col_height = 6;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�.�.",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"��¡��",1,0,'C');

			$y =  $pdf->GetY();
			$y = $y+($col_height);
			$col_height = 5;

		$sql = "select * from hr_specialduty where id='$id' and kp7_type='$kp7_active' order by runid ASC;";
		$result = mysql_db_query($dbsite,$sql);

		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
			
			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[comment],140);
			$num_arr1 = count($arr_str1);

			$x = $pdf->lMargin;

			if($num_arr1 == 1){ // �պ�÷Ѵ����

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"$rs[yy]",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$rs[comment]",1,0,'L');

			$y +=  $col_height;

			}else{ // �����º�÷Ѵ

			for ($n=0;$n<$num_arr1;$n++) {
			$y1 = $y ;
			$y1  += $col_height;
			if($y1 >= 265){$pdf->AddPage();}
			
			if($n==0){ // ��¹��÷Ѵ�á

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$num_arr1),"$rs[yy]",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$num_arr1),"",1,0,'L');

			} // end if ��¹��÷Ѵ����ͧ

			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
			$x = $pdf->lMargin;

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"",0,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$arr_str1[$n]",0,0,'L');

			if($n==($num_arr1-1)){$y += $col_height;}

			} // end else
			} // end 
			} // end while

// ��¡����� � ������

			$row1_y = $pdf->GetY();

			$x = $pdf->lMargin;
			$y = $row1_y+($col_height+2);
			$col_height = 8;

$pdf->SetXY($x,$y); 
$pdf->SetFont('Angsana New','',12);

$pdf->Cell(189,$col_height,'�. ��¡����� � ������',1,1,'L');

			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;

$pdf->SetXY($x,$y); // ��˹���ǵ��ҧ������

			$col_width = array(20,169);
			$col_height = 6;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�ӴѺ",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"��¡��",1,0,'C');

			$y =  $pdf->GetY();
			$y = $y+($col_height);
			$col_height = 5;

		$sql = "select * from hr_other where id='$id' and kp7_active='$kp7_active' ORDER BY runno asc";
		$result = mysql_db_query($dbsite,$sql);
		$no = 0;
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
			$no++; 
			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[comment],140);
			$num_arr1 = count($arr_str1);

			$x = $pdf->lMargin;

			if($num_arr1 == 1){ // �պ�÷Ѵ����
			
			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"$no",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$rs[comment]",1,0,'L');

			$y +=  $col_height;

			}else{ // �����º�÷Ѵ

			for ($n=0;$n<$num_arr1;$n++) {
			$y1 = $y ;
			$y1  += $col_height;
			if($y1 >= 265){$pdf->AddPage();}
			
			if($n==0){ // ��¹��÷Ѵ�á

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$num_arr1),"$no",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$num_arr1),"",1,0,'L');

			} // end if ��¹��÷Ѵ����ͧ

			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
			$x = $pdf->lMargin;

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"",0,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$arr_str1[$n]",0,0,'L');

			if($n==($num_arr1-1)){$y += $col_height;}

			} // end else
			} // end 
			} // end while


$pdf->AddPage(); // �����˹�һ���ѵ���Ңͧ������

$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id'  ;";
		$result = mysql_db_query($dbsite,$sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

$date_d = explode("-",$rs[startdate]); // �ѹ��觺�è�
$date_bd = explode("-",$rs[birthday]); // �ѹ�Դ
//$date_bg = explode("-",$rs[begindate]); // �ѹ�������Ժѵԧҹ
$retire =  $pdf->retireDate($rs[birthday]);

$sql1="select type_date,type_nec from type_showdate where id_type='$rs[type_dateshow2]' ";
$query1=mysql_db_query($dbsite,$sql1)or die(mysql_error());
$rs1=mysql_fetch_array($query1);
			if($rs1[type_nec]=="n" )
		 {
		 	$b_birthday=$rs1[type_date];
		 }
		 else
		 {
		$b_day = new date_format;
		$b_birthday= $b_day->show_date($rs1[type_date],($date_bd[0]-543)."-".$date_bd[1]."-".$date_bd[2]);
		}
			
			$date_bg = explode("-",$rs[begindate]); // �ѹ�������Ժѵԧҹ
			$sql_showbdate="select * from  type_showdate where id_type='$rs[type_showbegindate]' ";
			$q_showbdate=mysql_db_query($dbsite,$sql_showbdate)or die (mysql_error());
			$rssdate=mysql_fetch_assoc($q_showbdate);
			if($rssdate[type_nec]=="n")
			{
				$showbedate=$rssdate[type_date];
			}
			else
			{
		$b_showday = new date_format;
		$showbedate= $b_showday->show_date($rssdate[type_date],($date_bg[0]-543)."-".$date_bg[1]."-".$date_bg[2]);
			}



$retire =  $pdf->retireDate($rs[birthday]);

if($rs[label_persontype2now] !="")
{
	$str_position=$rs[label_persontype2now];
}
else
{
	$str_position=$rs[persontype2_now];
}
/*
if($rs[persontype2_now]=="����Ҫ��ä��" or $rs[position_now]=="���" or $rs[position_now]=="�ͧ����ӹ�¡��ʶҹ�֡��" or $rs[position_now]=="����ӹ�¡��ʶҹ�֡��" or $rs[position_now]=="����ӹ�¡���ç���¹"){
	$str_position = "���";
}else{
	$str_position = "�ؤ�ҡ÷ҧ����֡����蹵���ҵ�� 38 �. (2)";
}

$d1=explode("-",$rs[birthday]);
if($d1[1] <= 10){
	if($d1[1] >= 10 && $d1[2] >= 01){
		$retire = "�ѹ��� 30 ��͹ �ѹ��¹ �.�.".intval($d1[0] + 61)."";
	} else {
		$retire = "�ѹ��� 30 ��͹ �ѹ��¹ �.�.".intval($d1[0] + 60)."";
	}	
} elseif($d1[1] >= 11){
	$retire = "�ѹ��� 30  ��͹ �ѹ��¹ �.�.".intval($d1[0] + 61)."";
}
*/
// ��ǹ���
$pdf->Image("$picture_logo",100,5,14,17,JPG,'');
$pdf->SetFont('Angsana New','',12);
$pdf->SetXY(10,10);
$pdf->Cell(30,35,"��з�ǧ  $rs[minis_now]");
$pdf->SetXY(73,10);
$pdf->Cell(73,35,"���  $rs[subminis_now]");
$pdf->SetXY(190,10);
$pdf->Cell(190,35,'�.�.�');

$pdf->SetXY(10,30); // ��˹���÷Ѵ���������¡�÷�� 1-9

			$col_width = array(63,63,63); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
						//������鹡�ûԴ�Դ����ʴ��� ����㹡�7
			$strSQL2=mysql_query("SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
				$num_row_name1=mysql_num_rows($strSQL2);
					if($num_row_name1 > 0){
					
				$sql_history_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active <> '$kp7_active' ORDER BY runno DESC";
				$result_h_name = mysql_query($sql_history_name);
				$his_name1 = "";
				while($rsh1 = mysql_fetch_assoc($result_h_name)){
					$his_name1 .= " ($rsh1[prename_th]$rsh1[name_th]  $rsh1[surname_th]) ";
				}// end 	while($rsh1 = @mysql_fetch_assoc($result_h_name)){
					
					$Rs2=mysql_fetch_assoc($strSQL2);
					$txt_his_name = "�. ���� $Rs2[prename_th]$Rs2[name_th]  $Rs2[surname_th] ".$his_name1;
					$arr_name1 = array(); 
					$arr_name1 = $pdf->alignstr($txt_his_name,55);
					$num_name1 = count($arr_name1); // check �ӹǹ��÷Ѵ column 1
						if($num_name1 == "1"){
							$pdf->Cell($col_width[0],$col_height,"$txt_his_name",1,0,'L');
							$y=$y+$col_height;
						}else{
							$pdf->Cell($col_width[0],($col_height*$num_name1)," ",1,0,'L');
								for($n=0;$n<$num_name1;$n++){
								$pdf->SetXY($x ,$y);
								$pdf->Cell($col_width[0],$col_height,"$arr_name1[$n]",0,0,'L');
								$y=$y+$col_height;
								}//end for($n=0;$n<$num_name1;$n++){
						}//end if($num_name1 == "1"){
						
						//$pdf->Cell($col_width[0],$col_height,"�. ���� $Rs2[prename_th] $Rs2[name_th] $Rs2[surname_th]",1,0,'L');
					}else{
					
						$sql_history_name = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' AND kp7_active <> '$kp7_active' ORDER BY runno DESC";
						$result_h_name = @mysql_query($sql_history_name);
						$k=0;
						$xhis_name1 = "";
						while($rsh1 = @mysql_fetch_assoc($result_h_name)){
						$k++;
							if($k > 1){
							$xhis_name1 .= " ($rsh1[prename_th]$rsh1[name_th]  $rsh1[surname_th]) ";
							}//end if($k > 1){
						}// end 	while($rsh1 = @mysql_fetch_assoc($result_h_name)){

					
						$sql_noAt1 = "SELECT * FROM hr_addhistoryname WHERE gen_id='$id' ORDER BY runno DESC LIMIT 0,1 ";
						$result_noAt1 = mysql_query($sql_noAt1);
						$rs_noAt1 = mysql_fetch_assoc($result_noAt1);
						
						$txt_his_name = "�. ���� $rs_noAt1[prename_th]$rs_noAt1[name_th]  $rs_noAt1[surname_th]".$xhis_name1;
						$arr_name1 = array(); 
						$arr_name1 = $pdf->alignstr($txt_his_name,55);
						$num_name1 = count($arr_name1); // check �ӹǹ��÷Ѵ column 1
							if($num_name1 == 1){
								$pdf->Cell($col_width[0],$col_height,"$txt_his_name",1,0,'L');
								$y=$y+$col_height;
							}else{
							$pdf->Cell($col_width[0],($col_height*$num_name1)," ",1,0,'L');
								for($n=0;$n<$num_name1;$n++){
									$pdf->SetXY($x ,$y);
									$pdf->Cell($col_width[0],$col_height,"$arr_name1[$n]",0,0,'L');
									$y=$y+$col_height;
								}
							}//end 	if($num_name1 == 1){


						//$pdf->Cell($col_width[0],$col_height,"�.  ���� $rs_noAt1[prename_th]$rs_noAt1[name_th]  $rs_noAt1[surname_th] ",1,0,'L');
					}//end if($num_row_name1 > 0){
			// ����ûԴ�Դ����ʴ���� �� 7
			//$pdf->Cell($col_width[0],$col_height,"�. ���� $rs[prename_th] $rs[name_th] $rs[surname_th]",1,0,'L');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			// ������� �Դ�Դ����ʴ��Ť������
			$strSQL3=mysql_db_query($dbsite,"SELECT * FROM hr_addhistorymarry WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
				$num_row_marry=mysql_num_rows($strSQL3);
					if($num_row_marry != ""){
						$Rs3=mysql_fetch_assoc($strSQL3);
					$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������ $Rs3[prename_th] $Rs3[name_th] $Rs3[surname_th]",1,0,'L');
					}else{
					$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������ ",1,0,'L');
					}
				// ����� �Դ�Դ����ʴ��Ť������
		

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"�. �ѹ��觺�è�  ".intval($date_d[2])." ".$monthname[intval($date_d[1])]." ".$date_d[0].'',1,0,'L');

$pdf->SetXY(10,38);

			$col_width = array(63,63,63);
			$col_height = 8;
			$col_height2 = 14;
			$col_height3 = 6;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height2,'',1,0,'L');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height2,'',1,0,'L');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height2,'',1,0,'L');

//****************  data *********************

$pdf->SetXY(10,38);

			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�. �ѹ ��͹ �� �Դ  ".$b_birthday.'',0,0,'L');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			// ������鹻Դ�Դ ����ʴ��� ���� �Դ�
			
				$strSQL5=mysql_db_query($dbsite,"SELECT * FROM hr_addhistoryfathername WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
					$num_row_father=mysql_num_rows($strSQL5);
					if($num_row_father != ""){
						$Rs5=mysql_fetch_assoc($strSQL5);
						$pdf->Cell($col_width[1],$col_height,"�. ���ͺԴ�  $Rs5[father_prename] $Rs5[father_name] $Rs5[father_surname]",0,0,'L');
					}else{
					$pdf->Cell($col_width[1],$col_height,"�. ���ͺԴ� ",0,0,'L');
					}
			//�� �Դ�Դ ����ʴ��� ���� �Դ�
			
			//$pdf->Cell($col_width[1],$col_height,"�. ���ͺԴ�  $rs[father_prename] $rs[father_name] $rs[father_surname]",0,0,'L');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"�. �ѹ�������Ժѵ��Ҫ��� ".$showbedate.'',0,0,'L');

$pdf->SetXY(10,44);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y ;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height3,"( ".showthaidate(intval($date_bd[2]))." ".$monthname[intval($date_bd[1])]." ".showthaidate($date_bd[0])." )",0,0,'R');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height3,"",0,0,'L');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height3,"",0,0,'L');



$pdf->SetXY(10,52);

			$col_width = array(63,63,63);
			$col_height = 8;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�. �ѹ�ú���³����  $retire",1,0,'L');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			
			// ������鹻Դ�Դ����ʴ��� ������ô�
				$strSQL4=mysql_db_query($dbsite,"SELECT * FROM hr_addhistorymothername WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
					$num_row_mother=mysql_num_rows($strSQL4);
						if($num_row_mother != ""){
								$Rs4=mysql_fetch_assoc($strSQL4);
						$pdf->Cell($col_width[1],$col_height,"�. ������ô�  $Rs4[mother_prename] $Rs4[mother_name] $Rs4[mother_surname]",1,0,'L');	
						}else{
						$pdf->Cell($col_width[1],$col_height,"�. ������ô� ",1,0,'L');
						}
			
			// ���Դ�Դ����ʴ��� ������ô�
			//$pdf->Cell($col_width[1],$col_height,"�. ������ô�  $rs[mother_prename] $rs[mother_name] $rs[mother_surname]",1,0,'L');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"�. ����������Ҫ���  $str_position",1,0,'L');

// ��¡�÷�� 10

$pdf->SetXY(10,60);
$pdf->SetFont('Angsana New','',10);
$pdf->Cell(189,6,'��. ����ѵԡ���֡�� �֡ͺ����д٧ҹ ',1,1,'C');

$pdf->SetXY(10,66);

			$col_width = array(69,30,90);
			$col_height = 8;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2)," ʶҹ�֡�� �֡ͺ�� ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",1,1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"��д٧ҹ",0,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2)," ����� - �֧ ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"",1,1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"(��͹ ��)",0,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2)," �زԷ�����Ѻ ",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"",1,1,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height/2),"�к��Ң��Ԫ��͡ (�����)",0,0,'C');

// �زԡ���֡��
	$active="1";
		$sql = "select * from graduate where id='$id' order by runno asc;";
		$result = mysql_db_query($dbsite,$sql);

		$y =  $pdf->GetY();
		$y = $y+($col_height/2);
		$col_height = 5;
	while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
	if($rs[startyear] !="" and $rs[finishyear] !="")
	{
		$showdate1 = "$rs[startyear] "."-"." $rs[finishyear]";
	}
	else if($rs[startyear]=="")
	{
		$showdate1=$rs[finishyear];
	}
	else if($rs[finishyear]=="")
	{
			$showdate1=$rs[startyear];
	}else{
		$showdate1=$rs[year_label];
	}
			
			
			if($rs[place] !=""){
				$place=$rs[place];
				}else{
			$str1="select * from graduate inner join $dbnamemaster.hr_adduniversity on graduate.university_level=hr_adduniversity.u_id where graduate.id='$id' and graduate.runid='".$rs[runid]."'";
				$Rs1=mysql_db_query($dbsite,$str1);
				$rs11=mysql_fetch_array($Rs1);
				 $place=$rs11[u_name];
				}
				
	if($rs[grade] !=""){
	$grade=$rs[grade];
	}else{
	$str1="select * from graduate inner join $dbnamemaster.hr_adddegree on graduate.degree_level=hr_adddegree.degree_id where graduate.id='$id' and graduate.runid='".$rs[runid]."'";
	$Rs1=mysql_db_query($dbsite,$str1);
	$rs11=mysql_fetch_array($Rs1);
	$grade=$rs11[degree_fullname];
	}
			$arr_str1 = array(); 
			if($rs[degree_level] !=""){
			$arr_str1 = $pdf->alignstr($grade,70);
			}else{
			$arr_str1 = $pdf->alignstr($grade,70);
			}
			$num_arr1 = count($arr_str1);
			
			$arr_str2 = array(); 
			$arr_str2 = $pdf->alignstr($place,65);
			$num_arr2 = count($arr_str2);
			
			$arr_str3 = array(); 
			if($rs[year_label]!=""){
			$arr_str3 = $pdf->alignstr($rs[year_label],25);
			}else{
			$arr_str3 = $pdf->alignstr($showdate1,25);
			}
			$num_arr3 = count($arr_str3);

			$x = $pdf->lMargin;
		//	$col_height = 5;
			if($num_arr1 == 1 and $num_arr2==1 and $num_arr3==1 ){ // �պ�÷Ѵ����

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"$place",1,1,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			if($rs[year_label]!=""){
			$pdf->Cell($col_width[1],$col_height,"$rs[year_label]",1,0,'C');
			}else{
			$pdf->Cell($col_width[1],$col_height,"$showdate1",1,0,'C');
			}
			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"$grade",1,1,'L');

			

			}else{ // �����º�÷Ѵ
		
			$loop1=max($num_arr1,$num_arr2,$num_arr3);

			for ($n=0;$n<$loop1;$n++) {
				$y1 = $y ;
				$y1 = $y1 + $col_height ;
			if($y1 >= 265){$pdf->AddPage();}


			if($n==0){ // ��÷Ѵ�á����ʴ�������
  			if($num_arr1==1)
			{
			$x = $pdf->lMargin;
			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'C');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height*$loop1),"$arr_str1[$n]",1,0,'L');
			}//end//  end ($num_arr1==1)
			
			
			if($num_arr2==1){
			$x = $pdf->lMargin;
			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$loop1),"$arr_str2[$n]",1,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'C');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'L');
			}//end ($num_arr2==1)
			
			if($num_arr3 == 1){
			$x = $pdf->lMargin;
			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'L');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$loop1)," $arr_str3[$n]",1,0,'C');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'L');
			
			}//end ($num_arr3==1)
					


			if(($num_arr1>1) and ($num_arr2>1) and ($num_arr3>1))	
			{
						$x = $pdf->lMargin;
						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'C');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'C');
		
			}
			
			} // end if n==0

			if($n<$loop1 && $n != 0 ){$y  += $col_height;}
			
			if($num_arr1 != 1){
					$x = $pdf->lMargin;
					
					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height),"",0,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height),"",0,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height),"$arr_str1[$n]",0,0,'L');
					}//end  $num_arr1 != 1
			if($num_arr2 != 1)
			{
					$x = $pdf->lMargin;
					
					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height),"$arr_str2[$n]",0,0,'L');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height),"",0,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height),"",0,0,'C');
			}
					if($num_arr3 != 1)
			{
					$x = $pdf->lMargin;
					
					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height),"",0,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height),"$arr_str3[$n]",0,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height),"",0,0,'C');
			}
						if(($num_arr1>1) and ($num_arr2>1) and ($num_arr3>1))
			{
					$x = $pdf->lMargin;
					
					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height),"$arr_str2[$n]",0,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height),"$arr_str3[$n]",0,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height),"$arr_str1[$n]",0,0,'C');
			}
			
			} // end else
			} // end 
			$y +=  $col_height;
			} // end while

// -----------------  �֡ͺ�� ��д٧ҹ ------------------------
 
		$sql = "select * from seminar where id = '$id' AND  kp7_active = '$kp7_active' order by runno,startdate,enddate; ";
		$result = mysql_db_query($dbsite,$sql);

		$y =  $pdf->GetY();
		$col_height = 5;
		$y =  $y-$col_height;
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){

				if($rs[enddate]=="" OR $rs[enddate]==0){
					$showdate1 = "$rs[startdate]" ;
				}else if($rs[startdate]==""  OR $rs[startdate]==0 ){
					$showdate1 = "$rs[enddate]" ;
				}else{
					$showdate1 = "$rs[startdate]"."-"."$rs[enddate]";
				}
				

				$y +=  $col_height;
				if (($y) > 260) {$pdf->AddPage();$pdf-> aheader();$y=37;}
				$date_s = explode("-",$rs[startdate]);
				$date_e = explode("-",$rs[enddate]);
				
				$arr_str1 = array(); 
				$arr_str1 = $pdf->alignstr($rs[place],60);
				$num_arr1 = count($arr_str1); // check �ӹǹ��÷Ѵ column 1

				$arr_str2 = array(); 
				$arr_str2 = $pdf->alignstr($rs[subject],75);
				$num_arr2 = count($arr_str2); // check �ӹǹ��÷Ѵ column 2
				
				$arr_str3 = array(); 
				$arr_str3 = $pdf->alignstr($showdate1,26);
				$num_arr3 = count($arr_str3); // check �ӹǹ��÷Ѵ column 2

				$x = $pdf->lMargin;

			if(($num_arr1 == 1) and ($num_arr2 == 1) and ($num_arr3 == 1)){ // �պ�÷Ѵ����

				$pdf->SetFont('Angsana New','',10);
				$pdf->SetXY($x ,$y);
				$pdf->Cell($col_width[0],$col_height,"$rs[place] ",1,0,'L');

				$x += $col_width[0];
				$pdf->SetXY($x ,$y);
				$pdf->Cell($col_width[1],$col_height,"$showdate1",1,0,'C');

				$x += $col_width[1];
				$pdf->SetXY($x ,$y);
				$pdf->Cell($col_width[2],$col_height," $rs[subject]",1,0,'L');

			}else{ // �����º�÷Ѵ
			$loop1=max($num_arr1,$num_arr2,$num_arr3);
				//if(($num_arr1>$num_arr2)){$loop1 = $num_arr1; }else{$loop1 = $num_arr2; }

			for ($n=0;$n<$loop1;$n++) {
				$y1 = $y ;
				$y1  += $col_height;
				$flagaddpage = 0; // ���������Ѻ�� loop ���˹������

				if($y1 >= 260){ 
				$pdf->AddPage();$pdf-> aheader();
					if($loop1>1){
							$y=37+$col_height;
						if($n==0){
							$flagaddpage = 0;
						}else{
							$flagaddpage = 1;
						}
					}else{
						$y=37;
					}
				} // new page if row > 270

			if($n==0){ // ��÷Ѵ�á����ʴ�������

				if($num_arr1==1){

					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"$arr_str1[$n]",1,0,'L');

					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'C');

					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'L');

				} //  end ($num_arr1==1)

			if($num_arr2==1){

					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'L');

					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'C');

					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"$arr_str2[$n]",1,0,'L');

				} // end if ($num_arr2==1)
				
				if($num_arr3 ==1){

					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'L');

					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"$arr_str3[$n]",1,0,'L');

					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'L');

				} // end if ($num_arr2==1)
				
			if(($num_arr1>1) and ($num_arr2>1) and ($num_arr3>1)){ // ��������º�÷Ѵ����ͧ column

					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',10);
					$x = $pdf->lMargin;
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'L');

					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'C');

					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'L');

				} // end if ($num_arr1>1) and ($num_arr2>1)

			} // end if ($n==0)

			if($n<$loop1 && $n != 0 ){$y  += $col_height;}
				if($flagaddpage==0){ // �����˹������ 
					if($num_arr1 !=1){
			
						$x = $pdf->lMargin;

						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');

						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,"",0,0,'C');

						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,"",0,0,'L');

					} // end if ($num_arr1==1) 	

					if($num_arr2 !=1){

						$x = $pdf->lMargin;

						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"",0,0,'L');

						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,"",0,0,'C');

						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,"$arr_str2[$n]",0,0,'L');

					} // end if ($num_arr2==1)
					if($num_arr3 !=1){

						$x = $pdf->lMargin;

						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"",0,0,'L');

						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,"$arr_str3[$n]",0,0,'L');

						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,"",0,0,'L');

					} // end if ($num_arr2==1)

					if(($num_arr1>1) and ($num_arr2>1)and ($num_arr3>1)){

						$x = $pdf->lMargin;

						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');

						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,"$arr_str3[$n]",0,0,'L');

						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,"$arr_str2[$n]",0,0,'L');

					} // end if (($num_arr1>1) and ($num_arr2>1))

				}else{ // loop ���˹������  

						$y = $y + $col_height;
						$x = $pdf->lMargin;

						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",1,0,'L');

						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],$col_height,"$arr_str3[$n]",1,0,'L');

						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],$col_height,"$arr_str2[$n]",1,0,'L');
				
				} // end else if $flagaddpage==0

			} // end for
			} // end if else
			} // end while

//-------------------------END ��ý֡ͺ��------------------------------------

// ��¡�÷�� 11
			$row1_y = $pdf->GetY();

			$x = $pdf->lMargin;
			$y = $row1_y+$col_height;
			$col_height = 6;

$pdf->SetXY($x,$y); // ��˹���ǵ��ҧ ��
$pdf->SetFont('Angsana New','',10);
$pdf->Cell(189,$col_height,'��. ������Ѻ�ɷҧ�Թ��',1,1,'C');

			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;

$pdf->SetXY($x,$y); // ��˹���ǵ��ҧ������

			$col_width = array(30,100,59);
			$col_height = 6;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�.�.",1,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"��¡��",1,0,'C');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"�͡�����ҧ�ԧ",1,0,'C');

// ����� query ��������¡�� �� 

			$y =  $pdf->GetY();
			$y = $y+($col_height);
			$col_height = 5;
		$sql = "select * from hr_prohibit where id = '$id' and kp7_active='$kp7_active' order by runno asc ";
		$result = mysql_db_query($dbsite,$sql);
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
			//�礤��� label_yy ����դ���������----------------------------
			if($rs[label_yy] !=""){ $yyy=$rs[label_yy];}
			else{$yyy=$rs[yy];}
			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[comment],85);
			$num_arr1 = count($arr_str1);

			$x = $pdf->lMargin;

			if($num_arr1 == 1){ // �պ�÷Ѵ����

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"$yyy",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$rs[comment]",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"$rs[refdoc]",1,0,'L');

			$y +=  $col_height;

			}else{ // �����º�÷Ѵ

			for ($n=0;$n<$num_arr1;$n++) {
			$y1 = $y ;
			$y1  += $col_height;
			if($y1 >= 265){$pdf->AddPage();}

			if($n==0){ // ��¹��÷Ѵ�á

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$num_arr1),"$yyy",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$num_arr1),"",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height*$num_arr1),"$rs[refdoc]",1,0,'L');

			} // end if ��¹��÷Ѵ����ͧ

			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
			$x = $pdf->lMargin;

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"",0,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$arr_str1[$n]",0,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"",0,0,'L');

			if($n==($num_arr1-1)){$y += $col_height;}

			} // end else
			} // end 
			} // end while
			
// ��¡�÷�� ��

			$row1_y = $pdf->GetY();

			$x = $pdf->lMargin;
			$y = $row1_y+($col_height+2);
			$col_height = 6;

		$sql = "select * from hr_nosalary where id = '$id' and kp7_active='$kp7_active'; ";
		$result = mysql_db_query($dbsite,$sql);
		$num_row = mysql_num_rows($result);
		
		$arr_strx1 = array(); 
		$resultx1 = mysql_db_query($dbsite,"select comment from hr_nosalary where id = '$id' and kp7_active='$kp7_active'; ");				
		while($rsx1=mysql_fetch_array($resultx1)){
			$arr_strx1 = $pdf->alignstr($rsx1[comment],85);
			$num_arrx1 += count($arr_strx1);
		}


		if ((12+($num_arrx1*6)+$y+50) > 265) {$pdf->AddPage();$y=30;$pdf->bheader();}else{$pdf->bheader();} // �Ѵ���˹���������Թ˹�� �ͧ��ǹ���� ���ŧ���� ((h �ͧ��� ��+(�ӹǹ��*h)+��� y+h �ͧ ��ǹ���� 50)

		if($y!=30){ $y =  $pdf->GetY();}
		$y = $y+($col_height);
		$col_height = 5;
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
			$date_f = explode("-",$rs[fromdate]);
			$date_t = explode("-",$rs[todate]);

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[comment],85);
			$num_arr1 = count($arr_str1);

			$x = $pdf->lMargin;

			if($num_arr1 == 1){ // �պ�÷Ѵ����
			
			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height," ".intval($date_f[2])." ".$monthsname[intval($date_f[1])]." ".intval($date_f[0])." - ".intval($date_t[2])." ".$monthsname[intval($date_t[1])]." ".intval($date_t[0]).'',1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$rs[comment]",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"$rs[refdoc]",1,0,'L');

			$y +=  $col_height;

			}else{ // �����º�÷Ѵ
						
			for ($n=0;$n<$num_arr1;$n++) {
			$y1 = $y ;
			$y1  += $col_height;
			if($y1 >= 265){$pdf->AddPage();$pdf->bheader();$y=30;}

			if($n==0){ // ��¹��÷Ѵ�á

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$num_arr1)," ".intval($date_f[2])." ".$monthsname[intval($date_f[1])]." ".intval($date_f[0])." - ".intval($date_t[2])." ".$monthsname[intval($date_t[1])]." ".intval($date_t[0]).'',1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$num_arr1),"",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height*$num_arr1),"$rs[refdoc]",1,0,'L');

			} // end if ��¹��÷Ѵ����ͧ

			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
			$x = $pdf->lMargin;

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"",0,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$arr_str1[$n]",0,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"",0,0,'L');

			if($n==($num_arr1-1)){$y += $col_height;}

			} // end else
			} // end 
			} // end while

// ��ǹ����

			$row1_x = $pdf->lMargin; // �����������
			$row1_y = $pdf->GetY(); // �Ѻ��Һ�÷Ѵ
			$x = $row1_x+10;
			$y = $row1_y+20;

$pdf->SetXY($x,$y); // ��÷Ѵ�����

			$col_width = array(60,140); // �������ҧ column ����,���
			$col_height = 10;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"(ŧ����)________________________________________________",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height/2),"(��Ңͧ����ѵ�)",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height+5),"_____/_____/_________",0,0,'C');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"(ŧ����)________________________________________________",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2),"           (_______________________________________________)",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2)+10,"���˹�________________________________________________",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2)+20,"���˹����ǹ�Ҫ������ͼ�������˹����ǹ�Ҫ����ͺ����",0,0,'C');

			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),"",0,0,0,'');

			$y  = $row1_y+($col_height/2);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height/2)+30,"_____/_____/_________",0,0,'C');

$pdf-> AddPage();
$pdf-> cheader();

		$sql = "select * from salary where id = '$id' order by runno asc; ";
		$result = mysql_db_query($dbsite,$sql);
		$num_row = mysql_num_rows($result);
			
			while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		if($rs[label_salary] !="")
			{
			$salaryshow=$rs[label_salary];
			}
		else
			{
			if($rs[salary]==0){
			$salaryshow="";
			}
			else
			{
			$salaryshow=SetNumberFormat($rs[salary],0,0);
			}
			}
			if($rs[label_radub] !=""){$radub=$rs[label_radub];}
			else{ $radub=$rs[radub];}

			$rs[pls] = str_replace("\r", " ", trim($rs[pls]));
			//ત�������ҧ
			if($rs[noorder]=="#")
			{
				$rs[noorder]="";
			}
			else
			{
			$rs[noorder] = trim($rs[noorder]);
			}

			$y += $col_height;
			if (($y) > 260) {$pdf->cfooter();$pdf->AddPage();$pdf-> cheader();$y=36;}
			$date_s = explode("-",$rs[date]); // �ѹ��� �ѹ ��͹ ��
			
			if($rs[label_date] !="")
			{
			$dateforshow=$rs[label_date];
			}
			else
			{
				if($rs[date]=="")
				{
					$dateforshow="";
				}
				else
				{
				$dateforshow=intval($date_s[2])." ".$monthsname[intval($date_s[1])]." ".$date_s[0];
				}
			}
			
	
			if($rs[instruct]=="#"){
				$txtins = "";
			}else if($rs[instruct]!=""){
				$txtins="$rs[instruct]";
			}else{
				$txtins="��.";
			}

	
			//check dateorder__________
			if($rs[label_dateorder] !=""){
				$showdate1 = " $txtins " . $rs[label_dateorder] ;
			}else	{
				if ($rs[dateorder] == ""){
					$showdate1 = "";
				}else{
					$date_o	= explode("-",$rs[dateorder]); // �ѹ��� ŧ�ѹ���
					$xdate_o = " ".intval($date_o[2])." ".$monthsname[intval($date_o[1])]." ".$date_o[0].'';
					if($xdate_o != ""){$showdate1 = " $txtins " . $xdate_o ; }else{$showdate1 = "";}
				}
			}

			
 $ext="$rs[noorder]$showdate1";
/*			if($rs[salary]==0){$rs[salary]="-";} 
			$rs[pls] = str_replace("\r", " ", trim($rs[pls]));
			$rs[noorder] = trim($rs[noorder]);

			$y += $col_height;
			if (($y) > 260) {$pdf->cfooter();$pdf->AddPage();$pdf-> cheader();$y=36;}
			$date_s = explode("-",$rs[date]); // �ѹ��� �ѹ ��͹ ��
			if ($rs[dateorder] == ""){
				$xdate_o = "";
			}else{
				$date_o	= explode("-",$rs[dateorder]); // �ѹ��� ŧ�ѹ���
				$xdate_o = " ".intval($date_o[2])." ".$monthsname[intval($date_o[1])]." ".$date_o[0].'';
			}

			if($rs[instruct]=="#"){
				$txtins = "";
			}else if($rs[instruct]!=""){
				$txtins="$rs[instruct]";
			}else{
				$txtins="��.";
			}

			if($xdate_o != ""){$showdate1 = " $txtins " . $xdate_o ; }else{$showdate1 = "";}


*/

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[pls],65);
			$num_arr1 = count($arr_str1); // check �ӹǹ��÷Ѵ column 1

			$arr_str2 = array(); 
			$arr_str2 = $pdf->alignstr($ext,50);
			$num_arr2 = count($arr_str2); // check �ӹǹ��÷Ѵ column 2
			
			$arr_str3 = array(); 
			$arr_str3 = $pdf->alignstr($dateforshow,15);
			$num_arr3 = count($arr_str3); // check �ӹǹ��÷Ѵ column 3
			
			$arr_str4 = array(); 
			$arr_str4 = $pdf->alignstr($rs[noposition],11);
			$num_arr4 = count($arr_str4); // check �ӹǹ��÷Ѵ column 4
			
			$arr_str5 = array(); 
			$arr_str5 = $pdf->alignstr($radub,10);
			$num_arr5= count($arr_str5); // check �ӹǹ��÷Ѵ column 5
			
			$arr_str6 = array(); 
			$arr_str6 = $pdf->alignstr($salaryshow,10);
			$num_arr6= count($arr_str6); // check �ӹǹ��÷Ѵ column 5

			$x = $pdf->lMargin;

			$col_height = 5;
			
			if(($num_arr1 == 1) and ($num_arr2 == 1) and ($num_arr3 == 1) and ($num_arr4 == 1) and ($num_arr5 == 1) and ($num_arr6 == 1)){ // column 1 ��� column 2 �� 1 ��÷Ѵ

			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height),"$dateforshow",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),trim($rs[pls]),1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"$rs[noposition]",1,0,'C');

			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"$radub",1,0,'C');

			$x += $col_width[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),$salaryshow,1,0,'R');

			$x += $col_width[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell(($col_width[5]+$col_width[6]),($col_height),"$rs[noorder] $showdate1",1,0,'L');

			}else{ // ��������º�÷Ѵ
			
			$loop1=max($num_arr1,$num_arr2,$num_arr3,$num_arr4,$num_arr5,$num_arr6);

		//	if($num_arr1>$num_arr2){$loop1 = $num_arr1; }else{$loop1 = $num_arr2; }
			
			for ($n=0;$n<$loop1;$n++) {
				$y1 = $y ;
				$y1 = $y1 + $col_height ;
				$flagaddpage = 0; // ���������Ѻ�� loop ���˹������
				if($y1 >= 260){ 
				$pdf->cfooter(270);$pdf->AddPage();$pdf-> cheader();
					if($loop1>1){
						$y=30+$col_height;
						if($n==0){
						$flagaddpage = 0;
						}else{
						$flagaddpage = 1;
						}
					}else{
						$y=30;
					}
				} // new page if row > 270

			// ��� ��. �ʴ���
			if((($n+1) == $num_arr2)){if($rs[label_dateorder] !=""){
				$showdate1 = " $txtins " . $rs[label_dateorder] ;
			}else	{
				if ($rs[dateorder] == ""){
					$showdate1 = "";
				}else{
					$date_o	= explode("-",$rs[dateorder]); // �ѹ��� ŧ�ѹ���
					$xdate_o = " ".intval($date_o[2])." ".$monthsname[intval($date_o[1])]." ".$date_o[0].'';
					if($xdate_o != ""){$showdate1 = " $txtins " . $xdate_o ; }else{$showdate1 = "";}
				}
			}}
			else
			{
			$showdate1 = "";	
			}
			//if($xdate_o != ""){$showdate1 = " $txtins " . $xdate_o ; }else{$showdate1 = "";}
			if($n==0){ // ��÷Ѵ�á����ʴ�������

				if($num_arr1==1){

					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"$arr_str1[$n]",B,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height*$loop1),"",1,0,'R');
		
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell(($col_width[5]+$col_width[6]),($col_height*$loop1),"",1,0,'L');
		
				} //  end ($num_arr1==1)
	
				if($num_arr2==1){

					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"",B,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height*$loop1),"",1,0,'R');
		
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell(($col_width[5]+$col_width[6]),($col_height*$loop1),"$arr_str2[$n]",1,0,'L');
		

				} // end if ($num_arr2==1)		
				
				if($num_arr3==1){

					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"$arr_str3[$n]",1,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"",B,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height*$loop1),"",1,0,'R');
		
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell(($col_width[5]+$col_width[6]),($col_height*$loop1),"",1,0,'L');
		
				} // end if ($num_arr3==1)		
				
				if($num_arr4==1){

					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"",B,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"$arr_str4[$n]",1,0,'C');
		
					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height*$loop1),"",1,0,'R');
		
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell(($col_width[5]+$col_width[6]),($col_height*$loop1),"",1,0,'L');
		
				} // end if ($num_arr4==1)		
				
					if($num_arr5==1){
					$x = $pdf->lMargin;
					
					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"",B,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height*$loop1),"$arr_str5[$n]",1,0,'C');
		
					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height*$loop1),"",1,0,'R');
		
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell(($col_width[5]+$col_width[6]),($col_height*$loop1),"",1,0,'L');
		
				} // end if ($num_arr5==1)		

					if($num_arr6==1){
					$x = $pdf->lMargin;
					
					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height*$loop1),"",B,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height*$loop1),"",1,0,'C');
		
					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height*$loop1),"$arr_str6[$n]",1,0,'R');
		
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell(($col_width[5]+$col_width[6]),($col_height*$loop1),"",1,0,'L');
		
				} // end if ($num_arr6==1)		


				if(($num_arr1>1) and ($num_arr2>1) and ($num_arr3>1) and ($num_arr4>1) and ($num_arr5>1) and ($num_arr6>1)){ // ��������º�÷Ѵ

						$x = $pdf->lMargin;
						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],($col_height*$loop1),"",B,0,'L');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'C');
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[3],($col_height*$loop1),"",1,0,'C');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height*$loop1),"",1,0,'R');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell(($col_width[5]+$col_width[6]),($col_height*$loop1),"",1,0,'L');
			

				} // end if(($num_arr1>1) and ($num_arr2>1) and ($num_arr3>1) and ($num_arr4>1))
			} //end $n==0
			
// --------------------------------- End Row 1--------------------------------------------------

			if($n<$loop1 && $n != 0 ){$y  += $col_height;}
			
			if($flagaddpage==0){ // �����˹������  

				if($num_arr1 != 1){
					$x = $pdf->lMargin;
					
					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height),"",0,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height),"$arr_str1[$n]",0,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height),"",0,0,'C');
		
					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height),"",0,0,'C');
		
					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height),"",0,0,'R');
		
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell(($col_width[5]+$col_width[6]),$col_height,"",0,0,'L');
		

				} // end if ($num_arr1 !=1) 		

				if($num_arr2 != 1){
						$x = $pdf->lMargin;
						
						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height),"",0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],($col_height),"",0,0,'L');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],($col_height),"",0,0,'C');
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);

						$pdf->Cell($col_width[3],($col_height),"",0,0,'C');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),"",0,0,'R');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell(($col_width[5]+$col_width[6]),($col_height),"$arr_str2[$n]",0,0,'L');
			
				} // end if ($num_arr2 !=1)
	
					if($num_arr3 != 1){
						$x = $pdf->lMargin;
						
						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height),"$arr_str3[$n]",0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],($col_height),"",0,0,'L');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],($col_height),"",0,0,'C');
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);

						$pdf->Cell($col_width[3],($col_height),"",0,0,'C');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),"",0,0,'R');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell(($col_width[5]+$col_width[6]),($col_height),"",0,0,'L');
			
				} // end if ($num_arr3 !=1)

					if($num_arr4 != 1){
						$x = $pdf->lMargin;
						
						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height),"",0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],($col_height),"",0,0,'L');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],($col_height),"$arr_str4[$n]",0,0,'C');
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);

						$pdf->Cell($col_width[3],($col_height),"",0,0,'C');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),"",0,0,'R');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell(($col_width[5]+$col_width[6]),($col_height),"",0,0,'L');
			
				} // end if ($num_arr4 !=1)
				
						if($num_arr5 != 1){
						$x = $pdf->lMargin;
						
						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height),"",0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],($col_height),"",0,0,'L');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],($col_height),"",0,0,'C');
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);

						$pdf->Cell($col_width[3],($col_height),"$arr_str5[$n]",0,0,'C');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),"",0,0,'R');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell(($col_width[5]+$col_width[6]),($col_height),"",0,0,'L');
			
				} // end if ($num_arr5 !=1)

						if($num_arr6 != 1){
						$x = $pdf->lMargin;
						
						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height),"",0,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],($col_height),"",0,0,'L');
			
						$x += $col_width[1];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[2],($col_height),"",0,0,'C');
			
						$x += $col_width[2];
						$pdf->SetXY($x ,$y);

						$pdf->Cell($col_width[3],($col_height),"",0,0,'C');
			
						$x += $col_width[3];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[4],($col_height),"$arr_str6[$n]",0,0,'R');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell(($col_width[5]+$col_width[6]),($col_height),"",0,0,'L');
			
				} // end if ($num_arr6 !=1)


			if(($num_arr1>1) and ($num_arr2>1) and ($num_arr3>1) and ($num_arr4>1) and ($num_arr5>1) and ($num_arr6>1)){
			
					$x = $pdf->lMargin;
					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height),"$arr_str3[$n]",0,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height),"$arr_str1[$n]",0,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height),"$arr_str4[$n]",0,0,'C');
		
					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height),"$arr_str5[$n]",0,0,'C');
		
					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height),"$arr_str6[$n]",0,0,'R');
		
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell(($col_width[5]+$col_width[6]),($col_height),"$arr_str2[$n]",0,0,'L');
		
			}
			}else{ // loop ���˹������   
					$y = $y + $col_height;
					$x = $pdf->lMargin;
					
					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height),"$arr_str3[$n]",1,0,'C');
		
					$x += $col_width[0];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[1],($col_height),"$arr_str1[$n]",1,0,'L');
		
					$x += $col_width[1];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[2],($col_height),"$arr_str4[$n]",1,0,'C');
		
					$x += $col_width[2];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[3],($col_height),"$arr_str5[$n]",1,0,'C');
		
					$x += $col_width[3];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[4],($col_height),"$arr_str6[$n]",1,0,'R');
		
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell(($col_width[5]+$col_width[6]),($col_height),"$arr_str2[$n] $showdate1",1,0,'L');
		
			} // end else if $flagaddpage==0
			
			} // end for
			} // end if else
			} // end while

$y = 270;
$setpass = "$date_bd[2]"."$date_bd[1]"."$date_bd[0]"."$getidcard" ;
if(substr($_SERVER["REMOTE_ADDR"],0,8) != "192.168." and  substr($_SERVER["REMOTE_ADDR"],0,8) != "127.0.0."){
	$pdf->SetProtection(array('print'),'competency',"$setpass");
}

$pdf->cfooter();

//=======================\
	$save_pdf = $_SERVER['DOCUMENT_ROOT']."/kp7file_pts_system/$setNameTable/$siteid_sent/".$id.".pdf";
	$checkFile = "../../../../kp7file_pts_system/$setNameTable/$siteid_sent/".$id.".pdf";
	if(is_file($checkFile)){
		AddLogGenKp7File("pts_log_gen_kp7file".$setNameTable,$id,"",1);	
	}else{
		AddLogGenKp7File("pts_log_gen_kp7file".$setNameTable,$id,"",0);		
	}//end if(is_file($save_pdf)){
	 
		$pdf->Output($save_pdf,'F');
		chmod("$save_pdf",0777);	
		
} //end 

				
###########################################################################
###########################################################################
############################################################################ end ��ǹ�ͧ��� gen pdf �ҡ�к�
				
				###  �ӡ�äѴ�͡ pdf �鹩�Ѻ
				#���ͧ������
				$PTS->dumpData($dbname_cmss,"view_general", "view_general".$setNameTable);
				$PTS->dumpData($dbname_cmss,"allschool", "allschool".$setNameTable);
				$PTS->dumpData($dbname_cmss,"view_j18", "view_j18".$setNameTable);
				######  
				
				
				
				
				
				
				mysql_db_query($PTS->dbnamePTS,"UPDATE pts_queue_process SET queue_status = 'Finish',queue_end_process=NOW() WHERE queue_id = '".$rows['queue_id']."' ");//���ʶҹ��� #���ҧ ʶҹС�÷ӧҹ�ͧ ����� 
				$query_Qall = mysql_db_query($PTS->dbnamePTS,"SELECT queue_siteid  FROM pts_queue_process WHERE queue_profile_id='".$PTS->profile_id."' ORDER BY queue_profile_id ");
				$num_Qall = mysql_num_rows($query_Qall);
				$query_QFinish = mysql_db_query($PTS->dbnamePTS,"SELECT queue_siteid  FROM pts_queue_process WHERE queue_profile_id='".$PTS->profile_id."' AND queue_status = 'Finish' ORDER BY queue_profile_id ");
				$num_QFinish = mysql_num_rows($query_QFinish);

				############### BEGIN Alert Message  #######################
				$Name = "�к����ͧ�ԧʶԵ� � ��ǧ����"; //senders name
				$email = "service@sapphire.co.th"; //senders e-mail adress
				$subject = "�к����ͧ�ԧʶԵ� � ��ǧ����"; //subject

				$sqlAert = " SELECT
						pts_profile.profile_id,
						pts_profile.profile_name,
						pts_profile.timeline_date,
						pts_profile.alert_type_before_day,
						pts_profile.alert_type_before_day_value,
						pts_profile.alert_type_ondate,
						pts_profile.alert_type_onerror,
						pts_profile.alert_type_oncomplete,
						pts_profile.type_alert_system,
						pts_profile.type_alert_sms,
						pts_profile.type_alert_email,
						pts_profile.profile_process
						FROM
						pts_profile
						WHERE pts_profile.profile_id='".$PTS->profile_id."'
				";
				$queryAert = mysql_db_query($PTS->dbnamePTS,$sqlAert);
				$rowAert = mysql_fetch_array($queryAert);
				$sqlProfileStatus = "SELECT type_status FROM `pts_profile_status` WHERE profile_id='".$PTS->profile_id."'  ORDER BY `status_id` DESC LIMIT 0,1 ";
				$queryProfileStatus = mysql_db_query($PTS->dbnamePTS,$sqlProfileStatus);
				$rowProfileStatus = mysql_fetch_array($queryProfileStatus);
				#� �ѹ���Ѵ�红�����
				if($rowAert['alert_type_ondate'] == "Yes"){
					/*
					if($num_QFinish == 1){
						$message_ondate = "��й������������Թ��èѴ�红�����ʶԵԢͧ����� '".$rowAert['profile_name']."' ";
						echo $message_ondate;
						echo "<br/>";
						#type_alert_email
						if($rowAert['type_alert_email'] == "Yes"){
							$sqlEmail = "SELECT * FROM `pts_alert_type_email` WHERE profile_id='".$rowAert['profile_id']."' ";
							$queryEmail = mysql_db_query($PTS->dbnamePTS,$sqlEmail);
							while($rowEmail = mysql_fetch_array($queryEmail)){
								if($message_ondate != "" && $rowEmail['email'] != "" ){
									$staff_mail = trim($rowEmail['email']); //recipient
									$msgtext	= $message_ondate;//mail body
									mail_daily_request($workname, $staff_mail , $email_sys ,$msgtext,$id);	
									echo $message_date;
									echo "<br/>";
									echo "Send Email-: ".trim($rowEmail['email'])."<br/>";
								}
							}
						}//type_alert_email
						#type_alert_sms
						if($rowAert['type_alert_sms'] == "Yes"){
							$sqlSms = "SELECT * FROM `pts_alert_type_sms` WHERE profile_id='".$rowAert['profile_id']."' ";
							$querySms = mysql_db_query($PTS->dbnamePTS,$sqlSms);
							while($rowSms = mysql_fetch_array($querySms)){
								if($message_ondate != "" && $rowSms['tel_no'] != ""){
									echo $message_ondate .= " [��ͤ����ѵ����ѵ� �ҡ�к� cmss-pts]";
									SendSMS(trim($rowSms['tel_no']), $message_ondate);
									echo "<br/>";
									echo "Send Sms: ".trim($rowSms['tel_no'])."<br/>";
								}
							}
						}//type_alert_sms
					}
					*/
				}//alert_type_ondate

				# ����͹������Դ�ѭ��㹡�èѴ�红�����ʶԵ�
				if($rowAert['alert_type_onerror'] == "Yes"){
					if( queueNumError($rowAert['profile_id']) >= 1 && $num_Qall == $num_QFinish){
						$message_error = "�Դ�ѭ��㹡�èѴ�红�����";
						echo $message_error;
						echo "<br/>";
						#type_alert_email
						if($rowAert['type_alert_email'] == "Yes"){
							$sqlEmail = "SELECT * FROM `pts_alert_type_email` WHERE profile_id='".$rowAert['profile_id']."' ";
							$queryEmail = mysql_db_query($PTS->dbnamePTS,$sqlEmail);
							while($rowEmail = mysql_fetch_array($queryEmail)){
								if($message_error != "" && $rowEmail['email'] != "" ){
									$staff_mail = trim($rowEmail['email']); //recipient
									$msgtext	= $message_error;//mail body
									//mail_daily_request($workname, $staff_mail , $email_sys ,$msgtext,$id);	
									echo $message_error;
									echo "<br/>";
									echo "Send Email: ".trim($rowEmail['email'])."<br/>";
								}
							}
						}//type_alert_email
						#type_alert_sms
						if($rowAert['type_alert_sms'] == "Yes"){
							$sqlSms = "SELECT * FROM `pts_alert_type_sms` WHERE profile_id='".$rowAert['profile_id']."' ";
							$querySms = mysql_db_query($PTS->dbnamePTS,$sqlSms);
							while($rowSms = mysql_fetch_array($querySms)){
								if($message_error != "" && $rowSms['tel_no'] != ""){
									echo $message_error .= " [cmss-pts]";
									//SendSMS(trim($rowSms['tel_no']), $message_error);
									echo "<br/>";
									echo "Send Sms: ".trim($rowSms['tel_no'])."<br/>";
								}
							}
						}//type_alert_sms
					}
				}//alert_type_onerror

				#����ͨѴ�红�����ʶԵ������������
				if($rowAert['alert_type_oncomplete'] == "Yes"){
					if($num_Qall == $num_QFinish){
						$message_finish = "�Ѵ�红�����ʶԵԢͧ����� '".$rowAert['profile_name']."' �����������\n";
						$message_finish .= $message_error;
						echo $message_finish;
						echo "<br/>";
						#type_alert_email
						if($rowAert['type_alert_email'] == "Yes"){
							$sqlEmail = "SELECT * FROM `pts_alert_type_email` WHERE profile_id='".$rowAert['profile_id']."' ";
							$queryEmail = mysql_db_query($PTS->dbnamePTS,$sqlEmail);
							while($rowEmail = mysql_fetch_array($queryEmail)){
								if($message_finish != "" && $rowEmail['email'] != "" ){
									$staff_mail = trim($rowEmail['email']); //recipient
									$msgtext	= $message_finish;//mail body
									mail_daily_request($workname, $staff_mail , $email_sys ,$msgtext,$id);	
									echo $message_finish;
									echo "<br/>";
									echo "Send Email-: ".trim($rowEmail['email'])."<br/>";
								}
							}
						}//type_alert_email
						#type_alert_sms
						if($rowAert['type_alert_sms'] == "Yes"){
							$sqlSms = "SELECT * FROM `pts_alert_type_sms` WHERE profile_id='".$rowAert['profile_id']."' ";
							$querySms = mysql_db_query($PTS->dbnamePTS,$sqlSms);
							while($rowSms = mysql_fetch_array($querySms)){
								if($message_finish != "" && $rowSms['tel_no'] != ""){
									echo $message_finish .= " [cmss-pts]";
									SendSMS(trim($rowSms['tel_no']), $message_finish);
									echo "<br/>";
									echo "Send Sms: ".trim($rowSms['tel_no'])."<br/>";
								}
							}
						}//type_alert_sms
					}//profile_process
				}//alert_type_oncomplete	

				############### END Alert Message  #######################

				//�óշ���ͧ��� Replay
				if($num_Qall == $num_QFinish){
					$sql_addProfileStatus = " INSERT INTO pts_profile_status SET  profile_id='".$PTS->profile_id."', user_id='', profile_status='Ready', type_status='Manual', profile_status_time=NOW() ";
					$Query_addProfileStatus = mysql_db_query($PTS->dbnamePTS,$sql_addProfileStatus) or die (mysql_error());
					#����ѹ��� � ��ǧ����
					mysql_db_query($PTS->dbnamePTS,"UPDATE pts_profile SET timeline_date = '".DATE("Y-m-d")."',profile_process='Finish' WHERE profile_id = '".$PTS->profile_id."' ");
				}
				 
				echo "<B>Success</B>";
			}
		}
	}

?>

