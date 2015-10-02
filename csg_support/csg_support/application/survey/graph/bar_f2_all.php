<?php
/**
 * @comment 	???
 * @projectCode
 * @tor 	   
 * @package		core
 * @author		Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created    	10/09/2014
 * @access     	public
 */
?>
<script>
window.parent.document.getElementById('rpb_iframe').style.height="320px";
window.parent.document.getElementById('rpb_iframe').style.width="450px";
</script>
<?php
header ('Content-type: text/html; charset=tis-620'); 
require_once('../lib/nusoap.php'); 
require_once("../lib/class.function.php");
$con = new Cfunction();

$ws_client = $con->configIPSoap();
$jquery = array('file' => 'jquery');
$highcharts = array('file' => 'highcharts');
echo $ws_client->call('includefile', $jquery);
echo $ws_client->call('includefile', $highcharts);

$sql_district_all = "SELECT
SUM(IF((report_type=1),1,0)) as t_1,
SUM(IF((report_type=2),1,0)) as t_2,
SUM(IF((report_type=3),1,0)) as t_3,
SUM(IF((report_type=4),1,0)) as t_4,
SUM(IF((report_type=5),1,0)) as t_5
FROM
question_project.reportbuilder_f2_2";
 $con->connectDB();
$result_district_all  = $con->select($sql_district_all);
foreach($result_district_all as $rd){}
// @modify Phada Woodtikarn 10/09/2014 ������ѹ��ǹ�� 100
$sum = $rd['t_1'] + $rd['t_2'] + $rd['t_3'] + $rd['t_4'] + $rd['t_5'];
if($sum != 0){
	$rd['t_1'] = $rd['t_1'] / $sum * 100;
	$rd['t_2'] = $rd['t_2'] / $sum * 100;
	$rd['t_3'] = $rd['t_3'] / $sum * 100;
	$rd['t_4'] = $rd['t_4'] / $sum * 100;
	$rd['t_5'] = $rd['t_5'] / $sum * 100;
}else{
	$rd['t_1'] = 0;	
	$rd['t_2'] = 0;
	$rd['t_3'] = 0;
	$rd['t_4'] = 0;
	$rd['t_5'] = 0;
}
// @end
$data = $rd['t_1'].','.$rd['t_2'].','.$rd['t_3'].','.$rd['t_4'].','.$rd['t_5'];
$para = array(
	'type' => 'pie',
	'categories' => '������������',
	'title' => '�ӹǹ �����ʺ�ѭ��/������ʹ��͹ (��)',
	'name' => '�� (���� 0 � 18 ��),���Ǫ� (���� 19 � 25 ��),����ç�ҹ (���� 25 � 60 ��),����٧���� ( 60 �բ���),���ԡ��',
	'data' => $data,
	'sliced' => 'false,false,false,false,false',// �ʴ���ҷ�����͡�͡���ʴ��������
	'width' => '400',
	'height' => '300',
	'graphdiv' => 'graphdiv'
);			  
$result = $ws_client->call('graph', $para);
		echo $result;
?>