
<?
if ($_SESSION[session_sapphire] == 1 ){
$main_url = "index_key_report.php" ;
}else if($_SESSION[session_status_extra] == "QC"){ // �ó���˹�ҷ�����ɷ������龹ѡ�ҹ sapphire
$main_url = "report_user_preview1.php";
}else{
$main_url = "report_user_preview1.php" ;
}


$menu_group = array("˹����ѡ"=>"$main_url,iframe_body","�к����Ң�����"=>"qsearch2.php,iframe_body","��èѴ��â������к�"=>"","��§ҹ"=>"","���ͺ��������"=>"../diagnose/bandwidth/initialmeter.php,_blank","�͡�ҡ�к�"=>"logout.php,_top");

//diagnose/bandwidth/initialmeter.php


if ($_SESSION[session_sapphire] == 1 ){
	


$menu_array = array(

"��èѴ��â������к�"=>array("�к��ͺ���§ҹ �.�.7"=>"index_assign_key.php","��Ǩ�ͺ����Ѻ�ͧ��úѹ�֡������"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","�����èѴ�����Ǵ��¡�õ�Ǩ������"=>"../validate_management/index.php,_blank",
							 "����ͧ���㹡�ûŴ�Ѻ�ͧ������"=>"unlock_approve.php,_blank","�к�������ٻ �.�.7"=>"../pic2cmss_entry/login_main.php,_blank","��§ҹ�Ѵ��ü����"=>"org_user.php","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank","�к� Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank"),

//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ"=>array("��§ҹʶԵԡ�úѹ�֡������"=>"report_keyin_user.php","��§ҹ��ػ��Һѹ�֡�͡���"=>"report_keyin_user_p2p.php",
"��ػ�Ҿ�����úѹ�֡������"=>"report_sum_area.php?action=view",
"��§ҹʶԵ�����Ѻ��������"=>"index_key_report.php",
"�����ҧҹ�١��ҧ��Ш�"=>"staff_worktime.php","��§ҹʶԵԡ�õ�Ǩ������"=>"../validate_management/report_validate.php,_blank","��§ҹ��� Incentive"=>"index_incentive.php,_blank")
//"��§ҹ��ػ��úѹ�֡������"=>"report_sum.php",
//"�����ż� Ranking "=>"ranking.inc.php",
);
} else if($_SESSION[session_status_extra] == "QC"){ // �ó���˹�ҷ�����ɷ������龹ѡ�ҹ sapphire
$menu_array = array(

"��èѴ��â������к�"=>array("�к��ͺ���§ҹ �.�.7"=>"index_assign_key.php","��Ǩ�ͺ����Ѻ�ͧ��úѹ�֡������"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","�к�������Ǩ�ͺ������"=>"report_alert_qc1.php,_blank","�к�������ٻ �.�.7"=>"../pic2cmss_entry/login_main.php,_blank","��§ҹ�Ѵ��ü����"=>"org_user.php","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank"),

//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ"=>array("ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")



);


}else if($_SESSION[session_status_extra] == "GRAPHIC"){
			
		$menu_array = array(
"��èѴ��â������к�"=>array("��䢢�������ǹ���"=>"user_properties.php","�к�������ٻ �.�.7"=>"../pic2cmss_entry/login_main.php,_blank"),
"��§ҹ"=>array("ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);
	
}else if($_SESSION[session_status_extra] == "CALLCENTER"){
	$menu_array = array(
"��èѴ��â������к�"=>array("��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank"),
"��§ҹ"=>array("ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] "));
}else{

$menu_array = array(
"��èѴ��â������к�"=>array("��䢢�������ǹ���"=>"user_properties.php","�Ѻ�ͧ��Ҥ�ṹ��úѹ�֡������"=>"report_keypiont_perday_index.php"),
//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ"=>array("ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);

}

if($_SESSION[session_staffid] != 93 AND $_SESSION[session_staffid] != 9948 AND $_SESSION[session_staffid] != 95 AND $_SESSION[session_staffid] != 57 AND $_SESSION[session_staffid] != 9974){
	unset($menu_array['��§ҹ�Ѵ��ü����']);
}

if($_SESSION[session_staffid] == 10691){ // �ó��� user�ͧ �.�.�. �������Ҵ�˹����§ҹ
	unset($menu_group['��èѴ��â������к�']);
	unset($menu_group['�к����Ң�����']);
/*	"��§ҹ"=>array("��§ҹʶԵԡ�úѹ�֡������"=>"report_keyin_user.php","��§ҹ��ػ��Һѹ�֡�͡���"=>"report_keyin_user_p2p.php",
"��ػ�Ҿ�����úѹ�֡������"=>"report_sum_area.php?action=view",
"��§ҹʶԵ�����Ѻ��������"=>"index_key_report.php",
"�����ҧҹ�١��ҧ��Ш�"=>"staff_worktime.php","��§ҹʶԵԡ�õ�Ǩ������"=>"../validate_management/report_validate.php,_blank","��§ҹ��� Incentive"=>"index_incentive.php,_blank")*/
	unset($menu_array['��§ҹʶԵ�����Ѻ��������']);
	unset($menu_array['�����ҧҹ�١��ҧ��Ш�']);
	unset($menu_array['��§ҹʶԵԡ�õ�Ǩ������']);

}


		echo "<DIV id=content>";
		echo "<UL id=navmenu-v>";
  $c= 0;
  foreach ($menu_group as $caption=>$url){
  		$exdata = explode(",",$url);
		$url = $exdata[0];
		$target = $exdata[1];
		// ���ҧ��Ǣ��
		if($url==""){
			$strurl = "<LI ><A href=\"#\">$caption +</A>"; 
			$endLI = "</LI>";
		}else{
			$strurl = "<LI><a href=\"$url\" TARGET=\"$target\">$caption</a></LI>";
			$endLI = "";
		}
		echo "$strurl";
	
			
			foreach ($menu_array as $key=>$val){
				if($key==$caption){
						echo "<UL>";
					
						foreach ($val as $key1=>$url1){
							$exdata1 = explode(",",$url1);
							$url1 = $exdata1[0];
							if($exdata1[1] != ""){
							$target = $exdata1[1];
							}else{
							$target = 'iframe_body';
							}
							echo "<LI><a href=\"$url1\" TARGET=\"$target\" >$key1</a></LI>";
						}
					echo "</UL>";
				}
			}
			echo $endLI;
	}
		echo "</UL>";
		echo "</DIV>";


?>
