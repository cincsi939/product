<?

### ��ҵ���÷����������
## http://202.129.35.103/pty_master/application/hr3/hr_report/kp7103.php?xidcard=3501800010958&xsiteid=5001&tmpuser=16092494&tmppass=3501800010958

ob_start();
session_start();
set_time_limit(0);
define('FPDF_FONTPATH','../hr_report/fpdf/font/');

//include("../../../config/conndb_nonsession.inc.php");
include('../hr_report/fpdf/fpdf.php');
include('../hr_report/kp7_class.php');
include("../hr_report/class.activitylog.php");
include("../../../common/std_function.inc.php");
include("../hr_report/gif.php");
include("../hr_report/barcode/core.php");
include("../../../common/class-date-format.php");


			$host = "202.129.35.104";
			$username = "sapphire";
			$password = "sprd!@#$%";
			$dbnamemaster =DB_MASTER;
			$db_temp = DB_CHECKLIST;

function conn(){
				global $username,$password ,$host;
				$myconnect = mysql_connect($host,$username,$password) OR DIE("Unable to connect to database :: $host ");
				$iresult = mysql_query("SET character_set_results=tis-620");
				$iresult = mysql_query("SET NAMES TIS620");
			}

$action="gen";
$action="gen";
$dbsite = STR_PREFIX_DB.$xsiteid;
$dbname = STR_PREFIX_DB.$xsiteid;
$db_temp = DB_CHECKLIST;
if($profile_id == ""){
	$profile_id = 1;
}


conn();

			$sql = " SELECT date(DATE_SUB( NOW() , INTERVAL -3 MONTH ) ) AS new_expire  ";  
			$result	= mysql_query($sql) ;  
			$rs = mysql_fetch_assoc($result) ;  
			$arrdate11 = explode("-",$rs[new_expire] ) ;  
			$xyy = $arrdate11[0] + 543;  
			$new_date = $xyy   ."-".  $arrdate11[1]  ."-".  $arrdate11[2]   ;  

 

			$expire_datesql  =      $rs[new_expire]  ; 
			$expire_date  =  convert_date1($new_date) ; 

//$xlimit = " LIMIT 0,100";
//$xlimit = "";

mysql_select_db("$dbsite");
$kp7_active=1;

$activity_id = "A0001"; // ���� log ����� PDF
$server_id = "S0001"; // ���� server

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$monthsname = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$mm_now = date("n");
$date_now = date("j");
$picture_logo = "krut.jpg" ;
$hrpicture = "bimg/nopicture.jpg" ;
$barcode = $_GET[barcode];

function xget_real_ip()
{
	$ip = false;
	if(!empty($_SERVER['HTTP_CLIENT_IP']))	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if($ip){
			array_unshift($ips, $ip);
			$ip = false;
		}
	for($i = 0; $i < count($ips); $i++){
		if(!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])){
			if(version_compare(phpversion(), "5.0.0", ">=")){
				if(ip2long($ips[$i]) != false){
					$ip = $ips[$i];
					break;
				}
			} else {
				if(ip2long($ips[$i]) != - 1){
					$ip = $ips[$i];
					break;
				}
			}
		}
	}
}
return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}
### �� log ��� gen�������Ф���
function SaveLogKp7sys($get_siteid){
		global $dbnamemaster;
		conn();
		$ip_gen = xget_real_ip();
		$sql_insert = "INSERT INTO kp7sys_log SET siteid='$get_siteid', ip_gen='$ip_gen',time_gen=NOW()";
		mysql_db_query($dbnamemaster,$sql_insert);
		$last_id = mysql_insert_id();
		return $last_id;
}
#### �� log ��������´��� gen ���
function SaveLogKp7sysDetail($log_id,$get_idcard,$filesize_gen,$get_statusfile){
	global $dbnamemaster;
	conn();
	$sql_time = "SELECT updatetime FROM view_general WHERE CZ_ID='$get_idcard'";
	$result_time = mysql_db_query($dbnamemaster,$sql_time);
	$rst = mysql_fetch_assoc($result_time);
	$sqlg1 = "INSERT INTO  kp7sys_log_detail SET log_id='$log_id',idcard='$get_idcard',filesize_gen='$filesize_gen',status_gen='$get_statusfile',timedate_data='$rst[updatetime]',timeupdate=NOW()";
	//echo "$dbnamemaster  :: ".$sqlg1."<br>";
	mysql_db_query($dbnamemaster,$sqlg1);
}//end function SaveLogDetail(){

function SaveLogGen($idcard,$get_siteid,$status_gen){
		global $dbnamemaster;
		conn();
		$sql_gen = "REPLACE INTO  kp7sys_log_gen SET idcard='$idcard',status_gen='$status_gen',siteid='$get_siteid'";
		mysql_db_query($dbnamemaster,$sql_gen);
}//end function SaveLogGen($idcard,$status_gen){


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



//@20/7/2550
function get_picture($id){
	global $xsiteid;
	conn();
	$imgpath = "../../../../".PATH_IMAGES."/$xsiteid/";
	$ext_array = array("jpg","jpeg","png","gif");
	if ($id <= "") return "";

	for ($i=0;$i<count($ext_array);$i++){
		$img_file = $imgpath . $id . "." . $ext_array[$i];
		if (file_exists($img_file)) return $img_file;
	}

	return "";
}


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

}


//$last_id = SaveLogKp7sys($xsiteid); // id ����ش� gen file pdf
//$x_path = $_SERVER['DOCUMENT_ROOT']."/kp7sys/$xsiteid/";
	
//	if(!(is_dir($x_path))){
//		Rmkdir($x_path);
//	}//if(!(is_dir($x_path))){

function save_image($img,$fullpath){
	$remote_img = $img;
	$img = imagecreatefromjpeg($remote_img);
	$path = $fullpath;
	imagejpeg($img, $path); 
}



//$intA = 0;
//$intB = 0;
$sqlm = "SELECT * FROM general WHERE id='$xidcard'"  ;

$resultm = mysql_db_query($dbsite,$sqlm);
#############  ��ҧ��ҵ����
$his_name = "";
$xhis_name = "";
$his_name1 = "";
$xhis_name1 = "";

$rsm = mysql_fetch_assoc($resultm);
	$id = $rsm[idcard]; // �Ţ�ѵ�
	$gsiteid = $rsm[siteid];// ����ࢵ
	
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

		
conn();
mysql_select_db($dbsite);
//**************************************

$pdf=new KP7();
$pdf->AliasNbPages();
$pdf->AddThaiFonts();
$pdf->AddPage();

$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id'  ;";
		$result = mysql_query($sql);
		//echo "$sql";die;
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
		$xresult = mysql_query(" select * from general_pic where id='$id' and kp7_active='$kp7_active' order by no ;");
		while ($xrs = mysql_fetch_assoc($xresult)){
			$img_file = "../../../../".PATH_IMAGES."/$rs[siteid]/$xrs[imgname]";
			$img_folder = "../../../../".PATH_IMAGES."/$rs[siteid]/";
			$url = "http://$host/".PATH_IMAGES."/$rs[siteid]/$xrs[imgname]";
				if(!is_dir($img_folder)){
					Rmkdir($img_folder,"0777");	
				}
				
				//save_image($url,$img_file);
			
				#### �ӡ�äѴ�͡��������ջ��·ҧ
				$hd_get = fopen($url, "r");			
					$data = NULL;
					if($hd_get) {
							while (!feof($hd_get)) {
							  $data .= fread($hd_get, 8192);
							}
					fclose($hd_get);
					
	
								$hd_put= @fopen($img_file, "w+");
								if($hd_put) {
									fwrite($hd_put, $data);
									fclose($hd_put);
								}

					} else {
						#print "Cannot Open $url ";
					}
		####  end �Ѵ�͡������ server			
			@chmod("$img_file",0777);	
	
			if(file_exists($img_file)){
				$hrpicture[$np] = $img_file;
				

			if($xrs[label_yy] != ""){
				$xyy = str_replace("�.�.","",$xrs[label_yy]);
			}else if($xrs[yy] > 0){
				$xyy = $xrs[yy];
			}else{
				$xyy = "";	
			}//end if($xrs[label_yy] != ""){
				
			$hrpicture_yy[$np] = $xyy;

	
			$x = explode(".",$img_file);
			$ext[$np] = strtoupper($x[count($x) - 1]);
			if ($ext[$np] == "GIF"){
				$hrpicture[$np] = "bimg/temppicture.png" ;	
				convert_gif2png($img_file,$hrpicture[$np]);
				$ext[$np] = "PNG";

			}
			$np++;
			}//end if(file_exists($img_file)){
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
			if($hrpicture_yy[0] != ""){
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
			if($hrpicture_yy[1] != ""){
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
			if($hrpicture_yy[2] != ""){
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
				if($hrpicture_yy[3] != ""){
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
			if($hrpicture_yy[4] != ""){
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
			if($hrpicture_yy[5] != ""){
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
			if($hrpicture_yy[6] != ""){
			$pdf->Cell($col_width[6],($col_height/2),"�.�. $hrpicture_yy[6]",0,0,'C');
			}else if($hrpicture[6] !=""){
			$pdf->Cell($col_width[6],($col_height/2),"�.�. ����к�",0,0,'C');
			}else{
			$pdf->Cell($col_width[6],($col_height/2),"�.�. ",0,0,'C');
			}
			
			//�� if
	
$y=71;
$pdf->SetXY(10,$y); // ��÷Ѵ ���� �ѹ ��͹ ���Դ

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
		$result = mysql_query($sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

$date_d = explode("-",$rs[startdate]); // �ѹ��觺�è�
$date_bd = explode("-",$rs[birthday]); // �ѹ�Դ
		$sqld="select * from general where id='$id' ";
					$qd2=mysql_query($sqld);
					$rsd2=mysql_fetch_array($qd2);
					$adsd2=$rsd2[type_dateshow];
					$sqlshow="select type_date,type_nec from type_showdate where id_type='$adsd2' ";
					$qshow=mysql_query($sqlshow);
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
	#$expire_date = "";
	$activitylog_admin_id = $_SESSION[idoffice];
	$activitylog_admin_office = $_SESSION[office_name];
	$activitylog_admin_office_sname = $_SESSION[office_sername];
	$makelog = new activity_log;

	
	
	$makelog->save_log("$activitylog_idcard","$activitylog_name","$activitylog_sername","$server_id","$activity_id","$temp_pdf_path","$expire_datesql","$activitylog_admin_id","$activitylog_admin_office","$activitylog_admin_office_sname","$request_type","$insertid" );
	$activitylog_barcode =  $makelog->getbarcode();
	$makelog->update_temp();
}

///

$pdf->SetXY(10,$y); // ��÷Ѵ �������

			$col_width = array(189); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			// ������鹡�ûԴ�Դ����ʴ��Ţ����� �������㹡�7
			$strSQL1=mysql_query("SELECT * FROM hr_addhistoryaddress WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
				$num_row_address=mysql_num_rows($strSQL1);
					if($num_row_address != ""){
						$Rs1=mysql_fetch_assoc($strSQL1);
						$xpos = strpos($Rs1['address'], PREFIX_ADD); #��Ǩ�ͺ prefix ���� replace ��� ��ҹ�Ţ����͡
						$txt_address = ($xpos === false)? PREFIX_ADD." $Rs1[address]":"$Rs1[address]";
						
						$txt_his_addr = "�.  �������Ѩ�غѹ $txt_address ���Ѿ�� $xcontact_tel";
						//$pdf->Cell($col_width[0],$col_height,"�.  �������Ѩ�غѹ $txt_address ���Ѿ�� $xcontact_tel",1,0,'L');
					}else{
						$txt_his_addr = "�.  �������Ѩ�غѹ  ���Ѿ�� $xcontact_tel";
						//$pdf->Cell($col_width[0],$col_height,"�.  �������Ѩ�غѹ  ���Ѿ�� $xcontact_tel",1,0,'L');
					}
					
					$arr_addr1 = array(); 
					$arr_addr1 = $pdf->alignstr($txt_his_addr,$line_page_address);
					$num_addr1 = count($arr_addr1); // check �ӹǹ��÷Ѵ column 1
					if($num_addr1 == "1"){
						$pdf->Cell($col_width[0],$col_height,$txt_his_addr,1,0,'L');
						$y=$y+$col_height;
					}else{
						$pdf->Cell($col_width[0],($col_height*$num_addr1)," ",1,'L');
						for($n=0;$n<$num_addr1;$n++){
							$pdf->SetXY($x ,$y);
							$pdf->Cell($col_width[0],$col_height,$arr_addr1[$n],0,0,'L');
							$y=$y+$col_height;
						}

					}// ����ûԴ�ԡ����ʴ��Ţ����ŷ������� ��7
			
		//	$pdf->Cell($col_width[0],$col_height,"�.  �������Ѩ�غѹ  ��ҹ�Ţ��� $rs[contact_add] ���Ѿ�� $xcontact_tel",1,0,'L');
$y=$y+$col_height;
$pdf->SetXY(10,$y); // ��÷Ѵ ����ͧ�Ҫ��������ó�

			$col_width = array(189); // ��˹��������ҧ column
			$col_height = 8;

			$pdf->SetFont('Angsana New','',12);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"�.  ����ͧ�Ҫ��������ó� �ѹ������Ѻ����ѹ�觤׹ �������͡�����ҧ�ԧ",1,0,'L');


$y=$y+$col_height;
$pdf->SetXY(10,$y); // ��ǵ��ҧ����������ͧ�Ҫ

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
		$result = mysql_query($sql);
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
			$date1=trim($rs[label_date]);
		}
	else
		{
			if($rs[date] !="0-0-0")
			{
				if($rs[date] != "0000-00-00"){
				$date1 = intval($date_g[2])." ".$monthsname[intval($date_g[1])]." ".$date_g[0];
				}else{
				$date1 = "";
				}
			}
			else
			{
				$date1="";
			}
		}//END 

		if($rs[getroyal_label] != ""){
			$txt_getroyal = $rs[getroyal_label];	
		}else{
			$txt_getroyal = $rs[getroyal];
		}



			$pdf->SetFont('Angsana New','',12);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height," $date1",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$txt_getroyal",1,0,'L');

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
		$result = mysql_query($sql);
		$num_row = mysql_num_rows($result);
		//if ((12+($num_row*5)+$y) > 265) {$pdf->AddPage();$y=30;}

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
			$arr_str1 = $pdf->alignstr($rs[label_education],35);
			}else if($rs[other_absent] !=""){
			$arr_str1 = $pdf->alignstr($rs[other_absent],35);
			}else if($rs[label_birth] !=""){
			$arr_str1 = $pdf->alignstr($rs[label_birth],35);
			}else if($rs[etc] !=0){
			$tem_etc="�Ҿ���� ".$rs[etc]." �ѹ";
			$arr_str1 = $pdf->alignstr($tem_etc,50);
			}else if($rs[birth] !=0){
			$tem_birth="�Ҥ�ʹ ".$rs[birth]." �ѹ";
			$arr_str1 = $pdf->alignstr($tem_birth,50);
			}else if($rs[education] >363){
			$absent_a="���֡�ҵ��";
			$arr_str1 = $pdf->alignstr($absent_a,35);
			}else if($rs[education] <364){
			$arr_str1 = $pdf->alignstr($rs[education],35);
			}else{
			$arr_str1 = $pdf->alignstr($tem_0,35);
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
			### �Ѵ����ǹ�ͧ����ʴ��š�âҴ�Ҫ���
			$arr_str_absent = $pdf->alignstr($str_absent,35);
			$num_arr_absent = count($arr_str_absent);
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
			
		if(($num_arr1==1)and($num_arr_year==1) and ($num_arr_absent == 1)){// �ó��պ�÷Ѵ����
		
			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			
			if($rs[merge_col]==1){
			$pdf->Cell(($col_width[0]+$col_width[1]+$col_width[2]+$col_width[3]+$col_width[4]+$col_width[5]),($col_height),"         $rs[special_exp]",1,0,'L');
			}else{
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
			$pdf->Cell($col_width[4],($col_height),"$arr_str_absent[0]",1,0,'C');

			$x += $col_width[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[5],($col_height),"$arr_str1[0]",1,0,'C');		
		}

	}else{
			## �Ҩӹǹ loop �٧�ش
			$loop1 = max($num_arr1,$num_arr_year,$num_arr_absent);
			//if($num_arr1>$num_arr_year){ $loop1=$num_arr1; }else{ $loop1=$num_arr_year; }
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
					$pdf->Cell($col_width[4],($col_height*$loop1)," ",1,0,'C');

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
					$pdf->Cell($col_width[4],($col_height*$loop1),"",1,0,'C');
					
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[5],($col_height*$loop1),"",1,0,'C');

			}// end if $num_arr_yeay
			
				if($num_arr_absent ==1){
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
					$pdf->Cell($col_width[4],($col_height*$loop1),"$arr_str_absent[$n]",1,0,'C');
					
					$x += $col_width[4];
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[5],($col_height*$loop1),"",1,0,'C');

			}// end if $if($num_arr_absent ==1){

					
					if(($num_arr1>1)and($num_arr_year>1) and ($num_arr_absent  > 1) ){//�ó������º�÷Ѵ
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
									$pdf->Cell($col_width[4],($col_height*$loop1),"",1,0,'C');

									$x += $col_width[4];
									$pdf->SetXY($x ,$y);
									$pdf->Cell($col_width[5],($col_height*$loop1),"",1,0,'C');
					}// end if ($num_arr1>1)
			}	// end if ($n==0)
			
		if($n<$loop1 && $n != 0 ){$y  += $col_height;}
		
			if($flagaddpage==0){ // �����˹������  
			
				if($num_arr1!=1){
					$x = $pdf->lMargin;
			
					$pdf->SetXY($x ,$y);

						$pdf->SetFont('Angsana New','',10);
						$pdf->Cell($col_width[0],$col_height,"",0,0,'C');
			
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
						$pdf->Cell($col_width[4],($col_height),"",0,0,'C');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),"$arr_str1[$n]",0,0,'C');
				
				}//end if($num_arr1==1)
				if($num_arr_year !=1){
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
						$pdf->Cell($col_width[4],($col_height),"",0,0,'C');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),"$arr_str1[$n]",0,0,'C');
				
				}//end if($num_arr_year)
				
					if($num_arr_absent !=1){
					$x = $pdf->lMargin;
					$pdf->SetXY($x ,$y);

						$pdf->SetFont('Angsana New','',10);
						$pdf->Cell($col_width[0],$col_height,"",0,0,'C');
			
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
						$pdf->Cell($col_width[4],($col_height),"$arr_str_absent[$n]",0,0,'C');
			
						$x += $col_width[4];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[5],($col_height),"",0,0,'C');
				
				}//end if($num_arr_absent )


				if(($num_arr1>1)and($num_arr_year>1) and ($num_arr_absent > 1)){
				
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
						$pdf->Cell($col_width[4],($col_height),"$arr_str_absent[$n]",0,0,'C');
			
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
			$pdf->Cell($col_width[4],($col_height),"$arr_str_absent[$n]",1,0,'C');

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
		$result = mysql_query($sql);

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
			$arr_str1 = $pdf->alignstr($rs[detail],130);
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
		$result = mysql_query($sql);

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
		$result = mysql_query($sql);
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
			if($y>= 260){ 
			$pdf->AddPage();$pdf-> xheader();
				}	
			} // end while


$pdf->AddPage(); // �����˹�һ���ѵ���Ңͧ������

$sql = "select t1.*,t2.religion as religionname,t3.blood as bloodgroup from  (general t1 left join $dbnamemaster.hr_religion t2 on t1.region=t2.id) left join $dbnamemaster.hr_blood t3 on t1.blood=t3.id where t1.id='$id'  ;";
		$result = mysql_query($sql);
		$rs=mysql_fetch_array($result,MYSQL_ASSOC);

$date_d = explode("-",$rs[startdate]); // �ѹ��觺�è�
$date_bd = explode("-",$rs[birthday]); // �ѹ�Դ
//$date_bg = explode("-",$rs[begindate]); // �ѹ�������Ժѵԧҹ
$retire =  $pdf->retireDate($rs[birthday]);

$sql1="select type_date,type_nec from type_showdate where id_type='$rs[type_dateshow2]' ";
$query1=mysql_query($sql1)or die(mysql_error());
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
			$q_showbdate=mysql_query($sql_showbdate)or die (mysql_error());
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
$pdf->Cell(30,35,"$rs[minis_now]");
$pdf->SetXY(73,10);
$pdf->Cell(73,35,"���  $rs[subminis_now]");
$pdf->SetXY(190,10);
$pdf->Cell(190,35,'�.�.�');
$y=30;
$pdf->SetXY(10,$y); // ��˹���÷Ѵ���������¡�÷�� 1-9

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
		$strSQL3=mysql_query("SELECT * FROM hr_addhistorymarry WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
				$num_row_marry=mysql_num_rows($strSQL3);
						$xi = $xi+1;
						if($xi == "1"){ $xbor = "1";}else{ $xbor = "0";}
						

					if($num_row_marry != ""){
						$Rs3=mysql_fetch_assoc($strSQL3);
						if($num_name1 == 1){
							$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������ $Rs3[prename_th] $Rs3[name_th] $Rs3[surname_th] ",1,0,'L');
						}else{
						
							$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������ $Rs3[prename_th] $Rs3[name_th] $Rs3[surname_th] ",$xbor,0,'L');
							$pdf->SetXY($x ,$y);
							$pdf->Cell($col_width[1],($col_height*$num_name1),"",1,0,'L');
					
						}//end if($num_name1 == 1){
						
					}else{
						if($num_name1 == "1"){
							$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������ ",1,0,'L');
						}else{
							$pdf->Cell($col_width[1],$col_height,"�. ���ͤ������ ",$xbor,0,'L');
							$pdf->SetXY($x ,$y);
							$pdf->Cell($col_width[1],($col_height*$num_name1),"   ",1,0,'L');
						}//end if($num_name1 == "1"){
						
					}//end if($num_row_marry != ""){
				// ����� �Դ�Դ����ʴ��Ť������
		

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
		######## ��ǹ����ʴ��� �ѹ��觺�è�
		if($rs[startdate_label] != ""){
			$show_startdate_label = $rs[startdate_label];
		}else{
			$show_startdate_label = intval($date_d[2])." ".$monthname[intval($date_d[1])]." ".$date_d[0];
		}	
		
			if($num_name1 == 1){
				$pdf->Cell($col_width[2],($col_height),"�. �ѹ��觺�è�  ".$show_startdate_label.'',1,0,'L');
				$y=$y+$col_height;
			}else{
				$pdf->Cell($col_width[2],($col_height),"�. �ѹ��觺�è�  ".$show_startdate_label.'',0,0,'L');
					$pdf->SetXY($x ,$y);
				$pdf->Cell($col_width[2],($col_height*$num_name1)," ",1,0,'L');
				$y= $y+($col_height*$num_name1);
//				for($i=0;$i<$num_name1;$i++){
//					if(($num_name1 - $i) == "1"){ $border_line = 1;}else{ $border_line = 0;}
//					$y=$y+$col_height;
//					$pdf->Cell($col_width[2],($col_height)," ",$border_line,0,'L');
//				}

			}//end 	if($num_name1 == 1){
			

$pdf->SetXY(10,$y); // 38

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

$pdf->SetXY(10,$y);

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
			
				$strSQL5=mysql_query("SELECT * FROM hr_addhistoryfathername WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
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
$y=$y+$col_height;
$pdf->SetXY(10,$y);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y ;
			$pdf->SetXY($x ,$y);
		#### ��ǹ�ѹ��͹���Դ label
				if($rs[birthday_label] != ""){
					$txt_birthday = " ( ".$rs[birthday_label]." )";
				}else{
					$txt_birthday = "( ".showthaidate(intval($date_bd[2]))." ".$monthname[intval($date_bd[1])]." ".showthaidate($date_bd[0])." )";
				}

			$pdf->Cell($col_width[0],$col_height3,"$txt_birthday",0,0,'R');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height3,"",0,0,'L');

			$x += $col_width[1];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height3,"",0,0,'L');


$y=$y+$col_height3;
$pdf->SetXY(10,$y);

			$col_width = array(63,63,63);
			$col_height = 8;

			$pdf->SetFont('Angsana New','',10);
			$row1_x = $pdf->GetX();
			$row1_y = $pdf->GetY();

			$x = $row1_x;
			$y = $row1_y;
			$pdf->SetXY($x ,$y);
		###  ��Ǩ�ͺ����ʴ��Ż��ª����ѹ���³�����Ҫ���
		if($rs[retire_label] != ""){
				$retire = $rs[retire_label];
			}else{
				$retire = $retire;
			}
		### end ��Ǩ�ͺ����ʴ��Ż��ª����ѹ���³�����Ҫ���
			
			$pdf->Cell($col_width[0],$col_height,"�. �ѹ�ú���³����  $retire",1,0,'L');

			$x += $col_width[0];
			$y  = $row1_y;
			$pdf->SetXY($x ,$y);
			
			// ������鹻Դ�Դ����ʴ��� ������ô�
				$strSQL4=mysql_query("SELECT * FROM hr_addhistorymothername WHERE gen_id='$id' AND kp7_active='$kp7_active' order by runno desc");
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
$y=$y+$col_height;
$pdf->SetXY(10,$y);
$pdf->SetFont('Angsana New','',10);
$pdf->Cell(189,6,'��. ����ѵԡ���֡�� �֡ͺ����д٧ҹ ',1,1,'C');
$y=$y+$col_height;
$pdf->SetXY(10,$y);

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
### ��Ѻ�ٻẺ����ʴ��š���֡����С�ý֡ͺ����д٧ҹ����
$sql_show = "SELECT 
runid as run_id,runno as run_no,place as place ,startyear as s_year,finishyear as e_year,year_label as la_year,grade as grade, kp7_active as at_kp7,type_graduate as g_type
  FROM graduate  WHERE id = '$id'
UNION
SELECT
 runid as run_id,runno as run_no,place as place,startdate as s_year,enddate as e_year,'',subject as grade ,kp7_active as at_kp7,''
  FROM seminar WHERE id = '$id' and kp7_active='$kp7_active'  order by run_no ASC";
  $result_show = mysql_db_query($dbname,$sql_show);
  $i=0;
  while($rs_s = mysql_fetch_assoc($result_show)){
	  $key_runid[$i] = $rs_s[run_id];
	  $key_runno[$i] = $rs_s[run_no];
	  $key_place[$i] = $rs_s[place];
	  $key_startdate[$i] = $rs_s[s_year];
	  $key_enddate[$i] = $rs_s[e_year];
	  $key_labeldate[$i] = $rs_s[la_year];
	  $key_grade[$i] = $rs_s[grade];
	  $key_kp7[$i] = $rs_s[at_kp7];
	  $key_gtype[$i] = $rs_s[g_type];
	  $i++;
  }//end while($rs_s = mysql_fetch_assoc($result_show)){

### end ��Ѻ����ʴ�������
// �زԡ���֡��
		$active="1";
		//$sql = "select * from graduate where id='$id' and kp7_active='$kp7_active' order by runno asc;";
		//$result = mysql_query($sql);

		$y =  $pdf->GetY();
		$y = $y+($col_height/2);
		$col_height = 5;
	//while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		
if(count($key_runid) > 0){
	$row = count($key_runid);
	$i=0;
	foreach($key_runid as $k => $v){
	if($key_labeldate[$k] != ""){ 
		$showdate1 = $key_labeldate[$k];
	}else{
		if($key_startdate[$k] == "" or $key_startdate[$k] == "0"){
			$showdate1 = $key_enddate[$k];	
		}else if($key_enddate[$k] == "" or $key_enddate[$k] == "0"){
				$showdate1 = $key_startdate[$k];	
		}else{
			    $showdate1 = 	"$key_startdate[$k]-$key_enddate[$k]";
		}
	}//end if($key_labeldate[$k] != ""){ 
			
			
//			if($rs[place] !=""){
//				$place=$rs[place];
//				}else{
//			$str1="select * from graduate inner join $dbnamemaster.hr_adduniversity on graduate.university_level=hr_adduniversity.u_id where graduate.id='$id' and graduate.runid='".$rs[runid]."' and kp7_active='$kp7_active'";
//				$Rs1=mysql_query($str1);
//				$rs11=mysql_fetch_array($Rs1);
//				 $place=$rs11[u_name];
//				}
	if($key_place[$k] !=""){
		$place= $key_place[$k];
	}else{
		$str1="select * from graduate inner join $dbnamemaster.hr_adduniversity on graduate.university_level=hr_adduniversity.u_id where graduate.id='$id' and graduate.runid='".$key_runid[$k]."' and kp7_active='$kp7_active'";
		$Rs1=mysql_query($str1);
		$rs11=mysql_fetch_array($Rs1);
		$place = $rs11[u_name];
	}
		
				
				
/*	if($rs[grade] !=""){
	$grade=$rs[grade];
	}else{
	$str1="select * from graduate inner join $dbnamemaster.hr_adddegree on graduate.degree_level=hr_adddegree.degree_id where graduate.id='$id' and graduate.runid='".$rs[runid]."' and kp7_active='$kp7_active'";
	$Rs1=mysql_query($str1);
	$rs11=mysql_fetch_array($Rs1);
	$grade=$rs11[degree_fullname];
	}
*/	
	
	if($key_grade[$k] !=""){
		$grade =  $key_grade[$k];
	}else{
	$str1="select * from graduate inner join $dbnamemaster.hr_adddegree on graduate.degree_level=hr_adddegree.degree_id where graduate.id='$id' and graduate.runid='".$key_runid[$k]."' and kp7_active='$kp7_active'";
	$Rs1=mysql_query($str1);
	$rs11=mysql_fetch_array($Rs1);
	$grade = $rs11[degree_fullname];
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
			} // end foreach(){
	}//end if(count($key_runid) > 0){
// -----------------  �֡ͺ�� ��д٧ҹ ------------------------
// 
//		$sql = "select * from seminar where id = '$id' AND  kp7_active = '$kp7_active' order by runno,startdate,enddate; ";
//		$result = mysql_query($sql);
//
//		$y =  $pdf->GetY();
//		$col_height = 5;
//		$y =  $y-$col_height;
//		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
//
//				if($rs[enddate]=="" OR $rs[enddate]==0){
//					$showdate1 = "$rs[startdate]" ;
//				}else if($rs[startdate]==""  OR $rs[startdate]==0 ){
//					$showdate1 = "$rs[enddate]" ;
//				}else{
//					$showdate1 = "$rs[startdate]"."-"."$rs[enddate]";
//				}
//				
//
//				$y +=  $col_height;
//				if (($y) > 260) {$pdf->AddPage();$pdf-> aheader();$y=37;}
//				$date_s = explode("-",$rs[startdate]);
//				$date_e = explode("-",$rs[enddate]);
//				
//				$arr_str1 = array(); 
//				$arr_str1 = $pdf->alignstr($rs[place],60);
//				$num_arr1 = count($arr_str1); // check �ӹǹ��÷Ѵ column 1
//
//				$arr_str2 = array(); 
//				$arr_str2 = $pdf->alignstr($rs[subject],75);
//				$num_arr2 = count($arr_str2); // check �ӹǹ��÷Ѵ column 2
//				
//				$arr_str3 = array(); 
//				$arr_str3 = $pdf->alignstr($showdate1,26);
//				$num_arr3 = count($arr_str3); // check �ӹǹ��÷Ѵ column 2
//
//				$x = $pdf->lMargin;
//
//			if(($num_arr1 == 1) and ($num_arr2 == 1) and ($num_arr3 == 1)){ // �պ�÷Ѵ����
//
//				$pdf->SetFont('Angsana New','',10);
//				$pdf->SetXY($x ,$y);
//				$pdf->Cell($col_width[0],$col_height,"$rs[place] ",1,0,'L');
//
//				$x += $col_width[0];
//				$pdf->SetXY($x ,$y);
//				$pdf->Cell($col_width[1],$col_height,"$showdate1",1,0,'C');
//
//				$x += $col_width[1];
//				$pdf->SetXY($x ,$y);
//				$pdf->Cell($col_width[2],$col_height," $rs[subject]",1,0,'L');
//
//			}else{ // �����º�÷Ѵ
//			$loop1=max($num_arr1,$num_arr2,$num_arr3);
//				//if(($num_arr1>$num_arr2)){$loop1 = $num_arr1; }else{$loop1 = $num_arr2; }
//
//			for ($n=0;$n<$loop1;$n++) {
//				$y1 = $y ;
//				$y1  += $col_height;
//				$flagaddpage = 0; // ���������Ѻ�� loop ���˹������
//
//				if($y1 >= 260){ 
//				$pdf->AddPage();$pdf-> aheader();
//					if($loop1>1){
//							$y=37+$col_height;
//						if($n==0){
//							$flagaddpage = 0;
//						}else{
//							$flagaddpage = 1;
//						}
//					}else{
//						$y=37;
//					}
//				} // new page if row > 270
//
//			if($n==0){ // ��÷Ѵ�á����ʴ�������
//
//				if($num_arr1==1){
//
//					$x = $pdf->lMargin;
//
//					$pdf->SetFont('Angsana New','',10);
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[0],($col_height*$loop1),"$arr_str1[$n]",1,0,'L');
//
//					$x += $col_width[0];
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'C');
//
//					$x += $col_width[1];
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'L');
//
//				} //  end ($num_arr1==1)
//
//			if($num_arr2==1){
//
//					$x = $pdf->lMargin;
//
//					$pdf->SetFont('Angsana New','',10);
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'L');
//
//					$x += $col_width[0];
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'C');
//
//					$x += $col_width[1];
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[2],($col_height*$loop1),"$arr_str2[$n]",1,0,'L');
//
//				} // end if ($num_arr2==1)
//				
//				if($num_arr3 ==1){
//
//					$x = $pdf->lMargin;
//
//					$pdf->SetFont('Angsana New','',10);
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'L');
//
//					$x += $col_width[0];
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[1],($col_height*$loop1),"$arr_str3[$n]",1,0,'L');
//
//					$x += $col_width[1];
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'L');
//
//				} // end if ($num_arr2==1)
//				
//			if(($num_arr1>1) and ($num_arr2>1) and ($num_arr3>1)){ // ��������º�÷Ѵ����ͧ column
//
//					$x = $pdf->lMargin;
//
//					$pdf->SetFont('Angsana New','',10);
//					$x = $pdf->lMargin;
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'L');
//
//					$x += $col_width[0];
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'C');
//
//					$x += $col_width[1];
//					$pdf->SetXY($x ,$y);
//					$pdf->Cell($col_width[2],($col_height*$loop1),"",1,0,'L');
//
//				} // end if ($num_arr1>1) and ($num_arr2>1)
//
//			} // end if ($n==0)
//
//			if($n<$loop1 && $n != 0 ){$y  += $col_height;}
//				if($flagaddpage==0){ // �����˹������ 
//					if($num_arr1 !=1){
//			
//						$x = $pdf->lMargin;
//
//						$pdf->SetFont('Angsana New','',10);
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');
//
//						$x += $col_width[0];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[1],$col_height,"",0,0,'C');
//
//						$x += $col_width[1];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[2],$col_height,"",0,0,'L');
//
//					} // end if ($num_arr1==1) 	
//
//					if($num_arr2 !=1){
//
//						$x = $pdf->lMargin;
//
//						$pdf->SetFont('Angsana New','',10);
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[0],$col_height,"",0,0,'L');
//
//						$x += $col_width[0];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[1],$col_height,"",0,0,'C');
//
//						$x += $col_width[1];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[2],$col_height,"$arr_str2[$n]",0,0,'L');
//
//					} // end if ($num_arr2==1)
//					if($num_arr3 !=1){
//
//						$x = $pdf->lMargin;
//
//						$pdf->SetFont('Angsana New','',10);
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[0],$col_height,"",0,0,'L');
//
//						$x += $col_width[0];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[1],$col_height,"$arr_str3[$n]",0,0,'L');
//
//						$x += $col_width[1];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[2],$col_height,"",0,0,'L');
//
//					} // end if ($num_arr2==1)
//
//					if(($num_arr1>1) and ($num_arr2>1)and ($num_arr3>1)){
//
//						$x = $pdf->lMargin;
//
//						$pdf->SetFont('Angsana New','',10);
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",0,0,'L');
//
//						$x += $col_width[0];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[1],$col_height,"$arr_str3[$n]",0,0,'L');
//
//						$x += $col_width[1];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[2],$col_height,"$arr_str2[$n]",0,0,'L');
//
//					} // end if (($num_arr1>1) and ($num_arr2>1))
//
//				}else{ // loop ���˹������  
//
//						$y = $y + $col_height;
//						$x = $pdf->lMargin;
//
//						$pdf->SetFont('Angsana New','',10);
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[0],$col_height,"$arr_str1[$n]",1,0,'L');
//
//						$x += $col_width[0];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[1],$col_height,"$arr_str3[$n]",1,0,'L');
//
//						$x += $col_width[1];
//						$pdf->SetXY($x ,$y);
//						$pdf->Cell($col_width[2],$col_height,"$arr_str2[$n]",1,0,'L');
//				
//				} // end else if $flagaddpage==0
//
//			} // end for
//			} // end if else
//			} // end while

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
		$result = mysql_query($sql);
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
			//�礤��� label_yy ����դ���������----------------------------
			if($rs[label_yy] !=""){ 
				$yyy=$rs[label_yy];
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

			} //end if($rs[label_yy]){
			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[comment],85);
			$num_arr1 = count($arr_str1);
			
			$arr_str2 = array(); 
			$arr_str2 = $pdf->alignstr($rs[refdoc],45);
			$num_arr2 = count($arr_str2);

			$x = $pdf->lMargin;

			if($num_arr1 == 1 && $num_arr2==1){ // �պ�÷Ѵ����

			$pdf->SetFont($font_format,'',10);
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
			if($y1 >= $line_page_prohibit){$pdf->AddPage();}

			if($n==0){ // ��¹��÷Ѵ�á

			$pdf->SetFont($font_format,'',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],($col_height*$num_arr1),"$yyy",1,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height*$num_arr1),"",1,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height*$num_arr1),"",1,0,'L');

			} // end if ��¹��÷Ѵ����ͧ

			if($n<$num_arr1 && $n != 0 ){$y += $col_height;}
			
			$x = $pdf->lMargin;

			$pdf->SetFont($font_format,'',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"",0,0,'C');

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],$col_height,"$arr_str1[$n]",0,0,'L');

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],$col_height,"$arr_str2[$n]",0,0,'L');

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
		$result = mysql_query($sql);
		$num_row = mysql_num_rows($result);
		
		$arr_strx1 = array(); 
		$resultx1 = mysql_query(" select comment from hr_nosalary where id = '$id' and kp7_active='$kp7_active'; ");				
		while($rsx1=mysql_fetch_array($resultx1)){
			$arr_strx1 = $pdf->alignstr($rsx1[comment],85);
			$num_arrx1 += count($arr_strx1);
		}


		if ((12+($num_arrx1*6)+$y+50) > 265) {$pdf->AddPage();$y=30;$pdf->bheader();}else{$pdf->bheader();} // �Ѵ���˹���������Թ˹�� �ͧ��ǹ���� ���ŧ���� ((h �ͧ��� ��+(�ӹǹ��*h)+��� y+h �ͧ ��ǹ���� 50)

		if($y!=30){ $y =  $pdf->GetY();}
		$y = $y+($col_height);
		$col_height = 5;
		while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
		###########  ��ǹ�ͧ����ʴ����ѹ����� label
			if($rs[label_date] != ""){
					$show_date_nosalary = "$rs[label_date]";
			}else{
				###  ��Ѻ����ͧ�ͧ����ʴ����ѹ���
				if($rs[fromdate] != "0000-00-00" and $rs[todate] != "0000-00-00"){
					$date_f = explode("-",$rs[fromdate]);
					$date_t = explode("-",$rs[todate]);
					$show_date_nosalary = intval($date_f[2])." ".$monthsname[intval($date_f[1])]." ".intval($date_f[0])." - ".intval($date_t[2])." ".$monthsname[intval($date_t[1])]." ".intval($date_t[0]);

				}else{
					if($rs[fromdate] != "0000-00-00" and $rs[todate] == "0000-00-00"){
						$date_f = explode("-",$rs[fromdate]);	
						$show_date_nosalary = intval($date_f[2])." ".$monthsname[intval($date_f[1])]." ".intval($date_f[0]);
					}else if($rs[fromdate] == "0000-00-00" and $rs[todate] != "0000-00-00"){
						$date_t = explode("-",$rs[todate]);
						$show_date_nosalary = intval($date_t[2])." ".$monthsname[intval($date_t[1])]." ".intval($date_t[0]);
					}else{
						$show_date_nosalary = "-";	
					}//end if($rs[fromdate] != "0000-00-00" and $rs[todate] == "0000-00-00"){
				}//end if($rs[fromdate] != "0000-00-00" and $rs[todate] != "0000-00-00"){
					
			}// end 	if($rs[label_date] != ""){

			$arr_str1 = array(); 
			$arr_str1 = $pdf->alignstr($rs[comment],85);
			$num_arr1 = count($arr_str1);

			$x = $pdf->lMargin;

			if($num_arr1 == 1){ // �պ�÷Ѵ����
			
			$pdf->SetFont('Angsana New','',10);
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[0],$col_height,"$show_date_nosalary",1,0,'C');

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
			$pdf->Cell($col_width[0],($col_height*$num_arr1),"$show_date_nosalary",1,0,'C');

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
		$result = mysql_query($sql);
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
// set row color
			if($rs[system_type]!= ""){
				$pdf->SetFillColor(211,209,209);
				$setfillrow = 1 ;
			}else{
				$setfillrow = 0 ;
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
		#############  �Ţ�����˹� 
			if($rs[label_noposition] != "" and $rs[label_noposition] != NULL){
					$show_noposition = $rs[label_noposition];
			}else{
					$show_noposition = $rs[noposition];
			}
		#### end �Ţ�����˹�


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
			$arr_str4 = $pdf->alignstr($show_noposition,11);
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
			$pdf->Cell($col_width[0],($col_height),"$dateforshow",1,0,'C',$setfillrow);

			$x += $col_width[0];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[1],($col_height),trim($rs[pls]),1,0,'L',$setfillrow);

			$x += $col_width[1];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[2],($col_height),"$show_noposition",1,0,'C',$setfillrow);

			$x += $col_width[2];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[3],($col_height),"$radub",1,0,'C',$setfillrow);

			$x += $col_width[3];
			$pdf->SetXY($x ,$y);
			$pdf->Cell($col_width[4],($col_height),$salaryshow,1,0,'R',$setfillrow);

			$x += $col_width[4];
			$pdf->SetXY($x ,$y);
			$pdf->Cell(($col_width[5]+$col_width[6]),($col_height),"$rs[noorder] $showdate1",1,0,'L',$setfillrow);

			}else{ // ��������º�÷Ѵ
			
			$loop1=max($num_arr1,$num_arr2,$num_arr3,$num_arr4,$num_arr5,$num_arr6);

		//	if($num_arr1>$num_arr2){$loop1 = $num_arr1; }else{$loop1 = $num_arr2; }
			
			for ($n=0;$n<$loop1;$n++) {
				$y_base = $y1 = $y ;
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
					$pdf->Cell($col_width[1],($col_height*$loop1),"$arr_str1[$n]",B,0,'L',$setfillrow);
		
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
					$pdf->Cell(($col_width[5]+$col_width[6]),($col_height*$loop1),"$arr_str2[$n]",1,0,'L',$setfillrow);
		

				} // end if ($num_arr2==1)		
				
				if($num_arr3==1){

					$x = $pdf->lMargin;

					$pdf->SetFont('Angsana New','',10);
					$pdf->SetXY($x ,$y);
					$pdf->Cell($col_width[0],($col_height*$loop1),"$arr_str3[$n]",1,0,'C',$setfillrow);
		
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
					$pdf->Cell($col_width[2],($col_height*$loop1),"$arr_str4[$n]",1,0,'C',$setfillrow);
		
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
					$pdf->Cell($col_width[3],($col_height*$loop1),"$arr_str5[$n]",1,0,'C',$setfillrow);
		
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
					$pdf->Cell($col_width[4],($col_height*$loop1),"$arr_str6[$n]",1,0,'R',$setfillrow);
		
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
					$pdf->Cell($col_width[1],($col_height),"$arr_str1[$n]",0,0,'L',$setfillrow);
		
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
					if($setfillrow==1){  // ��¹��鹢ͺ�ó��к���պ�� �Ѵ���24/5/2553
						$x = $pdf->lMargin;
						$y_tmp = $y ;
						$y = $y_base ; 
						$pdf->SetFont('Angsana New','',10);
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[0],($col_height*$loop1),"",1,0,'C');
			
						$x += $col_width[0];
						$pdf->SetXY($x ,$y);
						$pdf->Cell($col_width[1],($col_height*$loop1),"",1,0,'L');
			
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

						$y = $y_tmp ;
					}
				
			} // end for
			} // end if else
			
			$his_name = "";
			$xhis_name = "";
			$his_name1 = "";
			$xhis_name1 = "";

			
			} // end while


$y = 270;

$pdf->SetFillColor(0,0,0);
$pdf->cfooter();



//=======================\

			
			$his_name = "";
			$xhis_name = "";
			$his_name1 = "";
			$xhis_name1 = "";
			
			
		unset($key_runid); 
		unset($key_runno); 
		unset($key_place); 
		unset($key_startdate);
		unset($key_enddate); 
		unset($key_labeldate); 
		unset($key_kp7); 
		unset($key_gtype); 
		
		
$find_str = "cmss"; // ��Ǩ�ͺ�ó��繡�� login �� ��.ࢵ��ҹ��
$xpost = strpos($_GET[tmpuser],$find_str);

if($_GET[tmpuser] != "" and (!($xpost === false))){
	$setpass = $_GET[tmpuser]."#".$_GET[tmppass] ;
}else{
	$setpass = "$date_bd[2]"."$date_bd[1]"."$date_bd[0]"."$getidcard" ;
}

//	$pdf->SetXY($x ,$y);
//	$pdf->Cell(0,5,"$setpass == $tmpuser",1,0,'C');

if(substr($_SERVER["REMOTE_ADDR"],0,8) != "192.168." AND  substr($_SERVER["REMOTE_ADDR"],0,8) != "127.0.0." ){
	if($_GET[xsiteid] !=DB_MASTER){ // �ó� login ���дѺ������������ͧ�Դ password
		if($nonpass != 1){
			$pdf->SetProtection(array('print'),'competency',"$setpass");
		}// end 	if($nonpass != 1){
	}// end if($_SESSION[secid] !=DB_MASTER){ 
}// end if(substr($_SERVER["REMOTE_ADDR"],0,8) != "192.168." AND  substr($_SERVER["REMOTE_ADDR"],0,8) != "127.0.0." ){

$pdf->SetFillColor(0,0,0);
$pdf->cfooter();

if($activitylog_barcode!=""){
	$pdf->Output("tmp_pdf/".$activitylog_barcode.".pdf",'F');
}

if($showpdf==1){

$pdf->Output("tmp_pdf/".$id.".pdf",'F');

echo "success";

}else{

$pdf->Output($id.".pdf",'D');

}


//$allgen = $intA+$intB;
	
//echo "Done :: �ӹǹ����������� $allgen ���  �����  $intA  ���  ��������  $intB  ���";
	

?>
