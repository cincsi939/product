<?
#require_once("../../../common/preloading.php");
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_list_person";
$module_code 		= "list_person"; 
$process_id			= "list_person";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: Rungsit
#DateCreate	::05/102007
#LastUpdate	::05/102007
#DatabaseTabel::
#END
#########################################################
session_start() ; 



include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
require_once "../../../common/class.writeexcel_workbook.inc.php";
require_once "../../../common/class.writeexcel_worksheet.inc.php";

//include("timefunc.inc.php");

set_time_limit(3600);
if ($maxlimit = ""){ $maxlimit=200 ; } 
$getdepid = $depid ;


if ($xsiteid == "") { $xsiteid = $_SESSION[secid] ; } 
$masterdb = "cmss" ; 
$masterIP = "192.168.2.12";
#$masterIP = "127.0.0.1";
$nowIP = HOST;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>��§ҹʶҹФ����ú��ǹ</title>

</head>
<body  >
<?
conn($masterIP) ; 
$sql = " SELECT secname  FROM `eduarea` WHERE `secid` LIKE '$xsiteid'  "; 
$result = mysql_db_query($masterdb , $sql) ;  
$rs = mysql_fetch_assoc($result) ; 
$rssecname  = $rs[secname] ; 
################################################################## �Ҫ��������

$provid =  substr($xsiteid , 0 ,2) ; 
$sql = " SELECT * FROM `ccaa` WHERE `ccType` LIKE '%Aumpur%' AND `ccDigi` LIKE '$provid%'     "; 
$result = mysql_db_query($masterdb , $sql) ;  
echo mysql_error() ; 
while ( $rs = mysql_fetch_assoc($result) ){ 
	$ampid = substr($rs[ccDigi],0,4) ; 
	$arr_amp[$ampid]   = $rs[ccName] ; 
}
#  ccDigi				ccName				ccType				
$sql = " SELECT * FROM `ccaa` WHERE `ccType` LIKE '%Tamboon%' AND `ccDigi` LIKE '$provid%'     "; 
$result = mysql_db_query($masterdb , $sql) ;  
echo mysql_error() ; 
echo "<hr>".$sql ; 
while ( $rs = mysql_fetch_assoc($result) ){ 
	$tamid = substr($rs[ccDigi],0,6) ; 
	$arr_tam[$tamid]   = $rs[ccName] ; 
}
/*
echo "<hr> arr_amp :::::::: <pre>";
print_r($arr_amp) ;
echo "</pre>" ; 
echo "<hr> arr_tam :::::::: <pre>";
print_r($arr_tam) ;
echo "</pre>" ; 
*/
?>
<?
########################################## ������鹵�駤��  EXCEL
$xfilename = "SCvoiceexecutive_". trim($xsiteid) . ".xls"  ; 
$filename =  "../../../../competency__tmpxls/" .  $xfilename;
#$filename=  ".competency__tmpxls/" .  $xfilename;
#$filename=  "xxx.xls"  ;

 
$fname = tempnam(  "../../../../competency__tmpxls/", $xfilename  );
#$fname = tempnam(  "competency__tmpxls/", $xfilename  );
#echo "  xfilename     ::::::::::    $xfilename    <br><br> ";
#echo "  fname     ::::::::::    $fname    <br><br> ";  

$workbook =& new writeexcel_workbook($fname);
$worksheet =& $workbook->addworksheet('��ª���');
#######################################################################
$header_h1   =& $workbook->addformat(array('align' => 'left','font'=>'Angsana New','color'=>'black','size'=>18,'fg_color'=>0x16,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));

$header_merge   =& $workbook->addformat(array('align' => 'center','font'=>'Angsana New','color'=>'black','size'=>16,'fg_color'=>0x16,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1 , 'merge'=>1));

$header_row   =& $workbook->addformat(array('align' => 'center','font'=>'Angsana New','color'=>'black','size'=>16,'fg_color'=>0x16,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));

$data_row   =& $workbook->addformat(array('align' => 'left','font'=>'Angsana New','color'=>'black','size'=>14,'fg_color'=>'0x0E' ,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));

$data_row_center   =& $workbook->addformat(array('align' => 'center','font'=>'Angsana New','color'=>'black','size'=>14,'fg_color'=>'0x0E' ,'bold'=>0,'bottom'=>1,'right'=>1,'left'=>1,'top'=>1));

$data_only   =& $workbook->addformat(array('align' => 'left','font'=>'Angsana New','color'=>'black','size'=>14,'fg_color'=>'0x0E' ,'bold'=>0,'bottom'=>0,'right'=>0,'left'=>0,'top'=>0));
/* 
$header_top
$header_top_r
$header_top_l
$header_top_down
*/ 
#######################################################################
#
# Write a general heading
#
$worksheet->set_column('A:B', 12);
$worksheet->set_column('B:C', 30);
#$worksheet->set_column('C:D:E:F:G', 20);

$worksheet->set_column('C:D', 12);
$worksheet->set_column('D:E', 15);
$worksheet->set_column('E:F', 20);
$worksheet->set_column('F:G', 20);
$worksheet->set_column('G:H', 20);
#$worksheet->set_column('G','H', 0,$data_only,0);
$heading  =& $workbook->addformat(array(
align => 'left', 
bold    => 1,
color   => 'blue',
size    => 18,
merge   => 1,
));


$headings = array( "$tmpname" , '' );
$worksheet->write_row('B1', $headings, $heading);

####################################################################### ����õ�駤�� 
#######################################################################
#
# Some text examples
#
$text_format =& $workbook->addformat(array(
bold=> 0,
italic => 0,
color => 'black',
size => 16,
font => 'Angsana New'
));

# �����ç���¹	�����ç���¹ 	�ӹǹ�ͧ / ������ �.�.	�����	�Ӻ�
$worksheet->write('A1', $rssecname  , $header_merge );
$worksheet->write('B1', ""  , $header_merge );
$worksheet->write('C1',  ""  , $header_merge );
$worksheet->write('D1',  ""  , $header_merge );
$worksheet->write('E1',  ""  , $header_merge );
$worksheet->write('F1',  ""  , $header_merge );
$worksheet->write('G1',  ""  , $header_merge );
#$worksheet->write('A2', "��سҵ�Ǩ�ͺ��������� ��� �Ӻ� ��Ҷ١��ͧ�������   "  , $data_only );
#$worksheet->write('A3', "㹡ó� ��� ���١��ͧ���� �к�����ա���к�����ͧ�� ��� ʾ�. ���������������� �Ӻ����١��ͧ   "  , $data_only );
#$worksheet->write('A4', "���ʵӺ�* :: ��ͤ����к�����ͧ�к�� � ������ ����ҡ��ͧ�������¹�ŧ ���������,�Ӻ� ���ź ���ʵӺ�� ʴ��� F ����  "  , $data_only );

$worksheet->write('A2', "��سҵ�Ǩ�ͺ  "  , $data_only );
$worksheet->write('B2', "1.�ӹǹ����ӹ�¡���ç���¹ 㹡óշ�������  ����к� 0 �� �ç���¹����� , �ç���¹���������غ��ԡ���ѧ����ջ�С�����ҧ�繷ҧ���  "  , $data_only );

$worksheet->write('B3', "2.�ӹǹ�ͧ/������ ����ӹ�¡���ç���¹ 㹡óշ�������  ����к� 0 �� �ç���¹����ըӹǹ�ѡ���¹��ӡ���ࡳ��������ͧ�� �ͧ����ӹ�¡���ç���¹  "  , $data_only );

$worksheet->write('B4', "3.����� �Ӻŷ�����ç���¹ �١��ͧ������� �ҡ���١��ͧ ��س��кت�������� �Ӻ� �������駡�͡ ����� \"edit\" �ʴ��� �����˵�    "  , $data_only );
$worksheet->write('B5', "4.㹡óշ�� ����� ��з�����ç���¹ �к�����к�����ͧ�� ��س��кت�������� �Ӻ� �������駡�͡ ����� \"add\" �ʴ��� �����˵�   "  , $data_only );


$month1 = array("", "���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");
$th_yy = date("Y")+543 ; 
$month_nm = date("n") ; 
$timenow = date("j") ." ". $month1[$month_nm] ." ". $th_yy   ." (". (int)date("H")   .":". (int)date("i")   .":". (int)date("s")   .")"    ;  # 20 �.�. 2549 (12:30:41)


$worksheet->write('A6', "������ �.�ѹ���   $timenow  "  , $data_only );



$worksheet->write('A7', "�����ç���¹", $header_row);
$worksheet->write('B7', "�����ç���¹ ", $header_row);
$worksheet->write('C7', "�ӹǹ�.�. ", $header_row);
$worksheet->write('D7', "�ӹǹ�ͧ / ������", $header_row);
$worksheet->write('E7', "�����  ", $header_row );
$worksheet->write('F7', "�Ӻ�  ", $header_row );
#$worksheet->write('G6', "���ʵӺ�*", $header_row );
$worksheet->write('G7', "�����˵�*", $header_row );
	$a_row = 7; $b_row = 7; $c_row =7; $d_row = 7; $e_row =7; $f_row = 7; $g_row = 7; 
################################################################ ����ǵ��ҧ
## Style ## header_row || data_row   || data_row_center
################################################################ ������֧������ 
/*      
$sql = " 
SELECT  allschool.id,  
allschool.office, allschool.voice_exe, allschool.moiareaid, ccaa.ccName
FROM  allschool
Inner Join ccaa ON allschool.moiareaid = substring(ccaa.ccDigi,1,6) 
WHERE `siteid` LIKE '$xsiteid'
ORDER BY `office`
";
    */          
  $sql = " SELECT  id , office , voice_exe , moiareaid , sc_head FROM `allschool` WHERE `siteid` LIKE '$xsiteid' ORDER BY `office`  ";
$result = mysql_db_query($masterdb , $sql) ;  
echo mysql_error() ; 


while ($rs = mysql_fetch_assoc($result)){ 
# 	echo " <hr>  <div> ";  	print_r($rs) ; 
	$a_row++; $b_row++; $c_row++;  $d_row++; $e_row++; $f_row++; $g_row++;
	$tamid =  $rs[moiareaid]  ; 
	$ampid = substr($tamid , 0 ,4 ) ; 
	$ampname = $arr_amp[$ampid] ; 
	$tamname = $arr_tam[$tamid] ; 	
	$a_show = "A" . $a_row ; 
	$b_show = "B" . $b_row ; 
	$c_show = "C" . $c_row ; 
	$d_show = "D" . $d_row ; 
	$e_show = "E" . $e_row ; 	
	$f_show = "F" . $f_row ; 
	$g_show = "G" . $g_row ; 	
	$worksheet->write("$a_show", "$rs[id]", $data_row);
	$worksheet->write("$b_show", "$rs[office] ", $data_row);
	$worksheet->write("$c_show", "$rs[sc_head] ", $data_row);		
	$worksheet->write("$d_show", "$rs[voice_exe] ", $data_row);	
/*       */     	
	$worksheet->write("$e_show", "$ampname ", $data_row );			
	$worksheet->write("$f_show", "$tamname ", $data_row );		
	if ($tamname =="" and  $ampname ==""){  $tamid = "" ;  $strnote="add"; } else{   $strnote=""; }
#	$worksheet->write("$g_show", "$tamid", $data_row );	
	$worksheet->write("$g_show", "$strnote", $data_row );		
	
			
} #########  while ($rs = mysql_fetch_   => SELECT  id , office  FROM `allschool` 

################################################################ �Դ��÷ӧҹ 
$workbook->close();
echo $fname;

$fh=fopen($fname, "rb");
$contents = fread($fh,filesize($fname));
# echo " <hr> $contents   ";
$dlfile=fopen( $filename , "w");
$w = fwrite($dlfile,$contents);
fclose($dlfile);

# header ("Location: $filename ");    die;	
# header('Content-Disposition: attachment; filename="$filename"');
?>
</body>
</html>
