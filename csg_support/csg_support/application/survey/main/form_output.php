<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  10/09/2014
 * @access  public
 */
 ?>
<?php
//header("Content-Type: text/xml;");
require_once('lib/nusoap.php'); 
require_once("lib/class.function.php");

$form_type = "output";
$code =  urlencode(str_replace("\\","",$_GET['sqlid']));
$keyword =  urlencode(str_replace("\\","",$_GET['keyword']));

if ($_GET['type'] == "desc"){  $type = "desc"; } else { $type = "asc"; } 
if ($_GET['order_by'] != ""){ $order_by = $_GET['order_by']." ".$type; }
$perpage = "100";
$page = $_GET['page'];

$con = new Cfunction();

$ws_client = $con->configIPSoap();
$para =  array(
	"form_type"=> "output",
	"server_ip"  =>  "61.19.255.77",
	"database_name"  =>  "question_project", 
	"username"  =>  "family_admin",
	"password"  =>  "F@m!ly[0vE",
	"tbl_table"  =>  "view_avs",
	"tbl_map"  =>   "tbl_map",
	"normal"  =>  "question_id,master_id,master_idcard,question_firstname,question_lastname,master_round,master_idques,question_sex,question_age,question_Income,question_career,question_career_detail,question_parish,question_district,prename_th",
	'advance'  =>  "true",
	"output" =>  "question_id,master_id,master_idcard,question_firstname,question_lastname,master_round,master_idques,question_sex,question_age,question_Income,question_career,question_career_detail,question_parish,question_district,prename_th",
	"viewoutput" =>  "xml",
	"code"  => $code,
	"keyword"  => $keyword,
	"order_by"  => "",
	"perpage"  => "",
	"page"  => "1",
	"para_query"  => ""
);
$result =  $ws_client->call('advance_search_utf8', $para);
$xml = simplexml_load_string($result);
$num_rows = $xml->detail->numrows;
if($num_rows!=0)
{
//######### สร้าง array สำหรับ higlight สีที่คีย์เวิร์ด 
foreach ($xml->keyword->master_idcard as $value){ $keyword_idcard[] = $value; $keyword_idcard_color[] = "<font class='search_replace'>$value</font>";}
foreach ($xml->keyword->question_firstname as $value){ $keyword_firstname[] = $value; $keyword_firstname_color[] = "<font class='search_replace'>$value</font>";}
foreach ($xml->keyword->question_lastname as $value){ $keyword_lastname[] = $value; $keyword_lastname_color[] = "<font class='search_replace'>$value</font>";}
foreach ($xml->keyword->question_age as $value){ $keyword_age[] = $value; $keyword_age_color[] = "<font class='search_replace'>$value</font>";}
foreach ($xml->keyword->question_sex as $value){ $keyword_sex[] = $value; $keyword_sex_color[] = "<font class='search_replace'>$value</font>";}
foreach ($xml->keyword->question_Income as $value){ $keyword_Income[] = $value; $keyword_Income_color[] = "<font class='search_replace'>$value</font>";}
foreach ($xml->keyword->question_district as $value){ $keyword_district[] = $value; $keyword_district_color[] = "<font class='search_replace'>$value</font>";}
foreach ($xml->keyword->question_parish as $value){ $keyword_parish[] = $value; $keyword_parish_color[] = "<font class='search_replace'>$value</font>";}
//##########################################
?>

<script type="text/javascript" src="../js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
		$(document).ready(function() {		
			$('a[id^="show"]').fancybox({
				'width'				: '80%',
				'height'			: '100%',
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				onClosed	:	function() {
				}
			});
		});
</script>
<style>
.search_replace { background-color:#FF9;}
</style>
<TABLE width="100%">
	<TR>
	  <TD>&nbsp;</TD>
	  <TD align="right" valign="top">&nbsp;</TD>
  </TR>
	<TR>
		<TD>&nbsp;</TD>
		<TD align="right" valign="top"><strong>จำนวนทั้งหมด : <?php echo $num_rows; ?> รายการ</strong></TD>
	</TR>
</TABLE>
<TABLE width="100%" border="0" cellspacing="1" cellpadding="3" id="ppDriverTable" NAME="ppDriverTable" class="dtree" bgcolor="#BBCEDD" >
<tr  class="style7">
        <th width="46" >ลำดับ</th>
        <th width="127" >เลขประจำตัวประชาชน</th>
        <th width="133">ชื่อหัวหน้าครอบครัว</th>
        <th width="130">นามสกุล</th>
        <th width="82">อายุ(ปี)</th>
        <th width="80">เพศ</th>
        <th width="201">อาชีพ</th>
        <th width="137">รายได้ต่อปี (บาท)</th>
        <th width="76">อำเภอ</th>
        <th width="76">ตำบล</th>
</tr>
<?php
		$i = 0;
		$results = $xml->result;
		foreach($results as $row){
			$i++;
?> 
<tr class="data">
        <td align="center"><?php echo $i; ?></td>
        <td align="center"><a href="main/form_show.php?id=<?php echo $row->master_idcard; ?>" id="show"><?php echo str_replace($keyword_idcard,$keyword_idcard_color,$row->master_idcard); ?></a></td>
        <td align="left"><?php echo $row->prename_th; ?> <?php echo str_replace($keyword_firstname,$keyword_firstname_color,$row->question_firstname); ?></td>
        <td align="left"><?php echo str_replace($keyword_lastname,$keyword_lastname_color,$row->question_lastname); ?></td>
        <td align="center"><?php echo str_replace($keyword_age,$keyword_age_color,$row->question_age); ?></td>
        <td align="center"><?php echo str_replace($keyword_sex,$keyword_sex_color,$row->question_sex); ?></td>
        <td align="left"><?php echo $con->careerSelect($row->question_career);?> </td>
        <td align="right"><?php if($row->question_Income==0){echo 'ไม่ระบุ';}else{echo str_replace($keyword_Income,$keyword_Income_color,number_format(intval($row->question_Income)));} ?> </td>
        <td align="left"><?php echo str_replace($keyword_district,$keyword_district_color,$row->question_district); ?></td>
        <td align="left"><?php echo str_replace($keyword_parish,$keyword_parish_color,$row->question_parish); ?></td>
</tr>
<?php
		}
}
else
{
	echo '<center>';
	echo 'ไม่พบข้อมูล';
	echo '</center>';
}
?>    
</TABLE>
	
	