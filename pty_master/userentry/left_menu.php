
<?
$arr_staffreport = array();
$sql_staffreport  = "SELECT t1.staffid, t1.status_active FROM  keystaff_analyse_cost as t1 WHERE t1.status_active='1'";
$result_staffreport = mysql_db_query($dbnameuse,$sql_staffreport);
while($rssf = mysql_fetch_assoc($result_staffreport)){
		$arr_staffreport[$rssf[staffid]] = $rssf[staffid];
}//end while($rssf = mysql_fetch_assoc($result_staffreport)){




$staff_idarray = array('10217','10357','10192','10169','10092','10525','10559','10660','10591','10571','10762','10694','10399','10394');
if(in_array($_SESSION['session_staffid'],$staff_idarray)){
	$unlock_approve = 1;
}else{
	$unlock_approve = 0;	
}

if ($_SESSION[session_sapphire] == 1 ){
	if($_SESSION[session_staffid] == "11026"){ // ����Ѻ���˹���Ѫ���
		$main_url = "../../report/report_keydata_main.php" ;
	}else{
		$main_url = "index_key_report.php" ;
	}
}else if($_SESSION[session_status_extra] == "QC"){ // �ó���˹�ҷ�����ɷ������龹ѡ�ҹ sapphire
$main_url = "report_user_preview1.php";
}else{
$main_url = "report_user_preview1.php" ;
}

if($_SESSION[session_staffid] == "11026"){
	$menu_group = array("˹����ѡ"=>"$main_url,iframe_body","�ʴ� Session"=>"print_r_session.php,iframe_body","�͡�ҡ�к�"=>"logout.php,_top");
}else{
$menu_group = array("˹����ѡ"=>"$main_url,iframe_body","�ѹ�֡�������Թ��͹���Ҵ���"=>"../hr3/tool_competency/script_check_data/script_checke_datasalary.php,_blank","�ѹ�֡������ update 48 ࢵ����ͧ"=>"report_keyupdate_areamain.php,iframe_body","�к����Ң�����"=>"qsearch2.php,iframe_body","���һ���ѵԡ�èѴ�Ӣ�����"=>"../req_approve/req_search.php,iframe_body","��èѴ��â������к�"=>"","��§ҹ��õԴ�����èѴ�Ӣ����Ż�����Ԣͧ ���. ʾ�."=>"","��§ҹ����Ѻ��������"=>"","���ͺ��������"=>"../diagnose/bandwidth/initialmeter.php,_blank","��Ǩ�ͺ��ù�����ٻ �.�.7"=>"../pic2cmss_entry_new/site_report.php?profile_id=4&direct_check=ON,_blank","�ʴ� Session"=>"print_r_session.php,iframe_body","�͡�ҡ�к�"=>"logout.php,_top");
}

//diagnose/bandwidth/initialmeter.php


if ($_SESSION[session_sapphire] == 1  and $_SESSION[session_staffid] != "11026"){
	


/*$menu_array = array(

"��èѴ��â������к�"=>array("�к��ͺ���§ҹ �.�.7"=>"index_assign_key.php","��Ǩ�ͺ����Ѻ�ͧ��úѹ�֡������"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","�����èѴ�����Ǵ��¡�õ�Ǩ������"=>"../validate_management/index.php,_blank",
							 "����ͧ���㹡�ûŴ�Ѻ�ͧ������"=>"unlock_approve.php,_blank","�к�������ٻ �.�.7"=>"../hr3/tool_competency/pic2cmss/_index.php","��§ҹ�Ѵ��ü����"=>"org_user.php","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank","�к� Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank"),
*/
$menu_array = array(
"��èѴ��â������к�"=>array("�к��ѹ�֡������ �á. ੾�Т����ŻѨ�غѹ"=>"index_report_keylast.php,_blank","����ͧ��ͨѴ��â������ç���¹"=>"../hr3/hr_tools2/manage_school.php","��§ҹ����ҧ����Ѻ�ͧ�š�úѹ�֡������ࢵ������ͧ"=>"../hr3/tool_competency/diagnosticv1/index_list_approve_day_site.php,_blank","�к��ͺ���§ҹ����Ѻ���˹�ҷ��ࢵ"=>"index_assign_area.php","��§ҹ��û�Ѻ��ا�����ŵ����ǧ����"=>"report_check_data_profile_timeall.php","�׹�ѹ��䢢����� �.�.7 �ҡ����ͧ����䢢�����"=>"req_admin_verify.php","��˹��Դ�Դ�к��Ѻ�ͧ������"=>"../req_approve/admin_sapphire/main_manager.php,_blank","�к��Ŵ�Ѻ�ͧ�����ŹѺ�������ç���¹"=>"../raise_salary/unapprove_school/index.php,_blank","��˹�ʶҹС�û�ͧ�ѹ�����š���ͺ���§ҹ"=>"assign_protection.php","�к��ͺ���§ҹ �.�.7"=>"index_assign_key.php","��Ǩ�ͺ����Ѻ�ͧ��úѹ�֡������"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","�����èѴ�����Ǵ��¡�õ�Ǩ������"=>"../validate_management/index.php,_blank","����ͧ���㹡�ûŴ�Ѻ�ͧ������"=>"unlock_approve.php,_blank","��§ҹ�Ѵ��ü����"=>"org_user.php","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank","�к� Mornitor Keyin"=>"../msg_alert/login.php?user=$user&pwd=$pwd,_blank","��§ҹ Download Excel ������ ���."=>"../gpf_download/index_download.php,_blank"),


"��§ҹ��õԴ�����èѴ�Ӣ����Ż�����Ԣͧ ���. ʾ�."=>array("��§ҹ�ӹǹ��¡�÷���ѧ������Ѻ��ا�����ŵ����ǧ����"=>"report_check_data_profile.php","��§ҹ��Ǩ�ͺ�������ٻ�Ҫ��ä����кؤ�ҡ�÷ҧ����֡��"=>"report_check_data_image.php"),

//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ����Ѻ��������"=>array("��§ҹ������͡�Է°ҹ�"=>"../../report/report_vitaya_wrong.php,_blank","��§ҹ������͡���˹��������ѹ��Ѻ�дѺ"=>"../../report/report_vitaya_not_match.php,_blank","��§ҹ��������鹷ع"=>"manage_keyin_data/performance_per_head.php,_blank","��§ҹ����Ѻ monitor ��ṹ��ä����������С��QC�͡���"=>"../hr3/tool_competency/report_monitor_qc/report_monitor_qc.php,_blank","��§ҹ�������¹�Ţ�ѵ�"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","��§ҹʶԵԡ�úѹ�֡������"=>"report_keyin_user.php","��§ҹ��ػ��Һѹ�֡�͡���"=>"report_keyin_user_p2p.php",
"��ػ�Ҿ�����úѹ�֡������"=>"report_sum_area.php?action=view",
"��§ҹʶԵ�����Ѻ��������"=>"index_key_report.php",
"�����ҧҹ�١��ҧ��Ш�"=>"staff_worktime.php","��§ҹʶԵԡ�õ�Ǩ������"=>"../validate_management/report_validate.php,_blank","��§ҹ��� Incentive"=>"index_incentive.php","��§ҹ�Ѳ�ҡ�úѹ�֡�����Ţͧ��ѡ�ҹ���������"=>"report_keydata_error.php,_blank","��§ҹ��������ż�������"=>"report_executive_area.php,_blank","��§ҹ��ѡ�ҹ��������źѹ�֡������ Sub ����ҧҹ"=>"report_check_userkeydata.php,_blank")

//"��§ҹ��ػ��úѹ�֡������"=>"report_sum.php",
//"�����ż� Ranking "=>"ranking.inc.php",
);

if (!(array_key_exists($_SESSION['session_staffid'], $arr_staffreport))) {
  unset($menu_array['��§ҹ����Ѻ��������']['��§ҹ��������鹷ع']);	
}


if($_SESSION[session_sub] == "0"){ // �ó������������÷������ö���¡��˹����§ҹ��ä���ҹ�ͧ SUB
	unset($menu_array['��§ҹ']['��§ҹ��ѡ�ҹ��������źѹ�֡������ Sub ����ҧҹ']);	
}



} else if($_SESSION[session_status_extra] == "QC" or $_SESSION[session_status_extra] == "QC_WORD"){ // �ó���˹�ҷ�����ɷ������龹ѡ�ҹ sapphire
$menu_array = array(

"��èѴ��â������к�"=>array("�к��ѹ�֡������ �á. ੾�Т����ŻѨ�غѹ"=>"index_report_keylast.php,_blank","�к��ͺ���§ҹ �.�.7"=>"index_assign_key.php","��Ǩ�ͺ����Ѻ�ͧ��úѹ�֡������"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","�к�������Ǩ�ͺ������"=>"report_alert_qc1.php,_blank","����ͧ���㹡�ûŴ�Ѻ�ͧ������"=>"unlock_approve.php,_blank","��§ҹ�Ѵ��ü����"=>"org_user.php","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank"),

//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ����Ѻ��������"=>array("��§ҹ�������¹�Ţ�ѵ�"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ�Ѳ�ҡ�úѹ�֡�����Ţͧ��ѡ�ҹ���������"=>"report_keydata_error.php,_blank","��§ҹ��������ż�������"=>"report_executive_area.php,_blank")



);

	if($unlock_approve != "1"){ // ����� QC �ҧ����ҹ�鹷��������ٹ��
		unset($menu_array['��èѴ��â������к�']['����ͧ���㹡�ûŴ�Ѻ�ͧ������']);	
	}//end 	if($unlock_approve != "1"){ 

}else if($_SESSION[session_status_extra] == "GRAPHIC"){
			
		$menu_array = array(
"��èѴ��â������к�"=>array("�к��ѹ�֡������ �á. ੾�Т����ŻѨ�غѹ"=>"index_report_keylast.php,_blank","��䢢�������ǹ���"=>"user_properties.php"),
"��§ҹ����Ѻ��������"=>array("��§ҹ�������¹�Ţ�ѵ�"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);
	
}else if($_SESSION[session_status_extra] == "CALLCENTER"){
	//$menu_group = array("�к����Ң�����"=>"qsearch2.php,iframe_body");
	$menu_array = array(
"��èѴ��â������к�"=>array("�к��ѹ�֡������ �á. ੾�Т����ŻѨ�غѹ"=>"index_report_keylast.php,_blank","����ͧ��ͨѴ��â������ç���¹"=>"../hr3/hr_tools2/manage_school.php","�׹�ѹ��䢢����� �.�.7 �ҡ����ͧ����䢢�����"=>"req_admin_verify.php","��Ǩ�ͺ����Ѻ�ͧ��úѹ�֡������"=>"../hr3/tool_competency/diagnosticv1/index.php,_blank","��˹��Դ�Դ�к��Ѻ�ͧ������"=>"../req_approve/admin_sapphire/main_manager.php,_blank","�к��Ŵ�Ѻ�ͧ�����ŹѺ�������ç���¹"=>"../raise_salary/unapprove_school/index.php,_blank","����ͧ���㹡�ûŴ�Ѻ�ͧ������"=>"unlock_approve.php,_blank","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank"),
"��§ҹ����Ѻ��������"=>array("��§ҹ�������¹�Ţ�ѵ�"=>"../hr3/tool_competency/change_idcard/report_change_idcard.php,_blank","ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] "));


	if($unlock_approve != "1"){ // ����� QC �ҧ����ҹ�鹷��������ٹ��
		unset($menu_array['��èѴ��â������к�']['����ͧ���㹡�ûŴ�Ѻ�ͧ������']);	
	}//end 	if($unlock_approve != "1"){ 

}else if($_SESSION[session_status_extra] == "site_area"){
	
	$menu_array = array(
"��èѴ��â������к�"=>array("��§ҹ��������稢ͧ��ùѺ���"=>"https://master.cmss-otcsc.com/edubkk_master/application/raise_salary/performance/index_report_announce_master.php","��§ҹ��Ǩ�ͺ��÷Ӣ���������繻Ѩ�غѹ�ͧ���˹�ҷ��ࢵ"=>"../confirm_teacher/admin/index.php?xsiteid=".$_SESSION[session_site]."","��§ҹ��Ǩ�ͺ��èѴ���ٻ�Ҿ"=>"../hr3/tool_competency/script_check_data/script_check_picture_all.php","��§ҹ��õ�Ǩ�ͺ�ѧ����͹����Թ��͹"=>"../confirm_teacher/confirm_user/report_casecheck_money.php?xsiteid=".$_SESSION[session_site]."&action=view&login_type=site&lock_edu=1","�Ŵ����׹�ѹ�����š�ùѺ��Ǣͧ�ç���¹"=>"../raise_salary/unapprove_school/index_admin.php?lock=1&select_edu=".$_SESSION[session_site]."","��§ҹ����ҧ����Ѻ�ͧ�š�úѹ�֡������ࢵ������ͧ"=>"../hr3/tool_competency/diagnosticv1/index_list_approve_day_site.php,_blank","��§ҹ��û�Ѻ��ا�����ŵ����ǧ����"=>"report_check_data_profile_timeall.php","�Ѻ�ͧ��Ҥ�ṹ��úѹ�֡������"=>"report_keypiont_perday_index.php","�ӹǹ��¡�÷���ѧ������Ѻ��ا�����ŵ����ǧ����"=>"report_check_data_profile.php","ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin","��䢢�������ǹ���"=>"user_properties.php","�к���ͧ������䢢�����"=>"../req_approve/admin_sapphire/index.php,_blank")
//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
/*"��§ҹ����Ѻ��������"=>array("�ӹǹ��¡�÷���ѧ������Ѻ��ا�����ŵ����ǧ����"=>"report_check_data_profile.php","ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")*/ );
	
}else{

$menu_array = array(
"��èѴ��â������к�"=>array("�к��ѹ�֡������ �á. ੾�Т����ŻѨ�غѹ"=>"index_report_keylast.php,_blank","��䢢�������ǹ���"=>"user_properties.php","�Ѻ�ͧ��Ҥ�ṹ��úѹ�֡������"=>"report_keypiont_perday_index.php","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin"),
//"��§ҹ����Ѻ�ͧ������"=>"report_audit.php",
"��§ҹ����Ѻ��������"=>array("ʶԵԡ�úѹ�֡�����Ţͧ���ͧ"=>"report_keyin_user2.php?staffid=$_SESSION[session_staffid] ","��§ҹ Incentive ��Ш���͹"=>"report_incentive_per_month.php?sent_staffid=$_SESSION[session_staffid]&staff=keyin")

);

unset($menu_group['��Ǩ�ͺ��ù�����ٻ �.�.7']);
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
"�����ҧҹ�١��ҧ��Ш�"=>"staff_worktime.php","��§ҹʶԵԡ�õ�Ǩ������"=>"../validate_management/report_validate.php,_blank","��§ҹ��� Incentive"=>"index_incentive.php")*/
	unset($menu_array['��§ҹʶԵ�����Ѻ��������']);
	unset($menu_array['�����ҧҹ�١��ҧ��Ш�']);
	unset($menu_array['��§ҹʶԵԡ�õ�Ǩ������']);

}


if($_SESSION[session_status_extra] == "QC_WORD"){
		unset($menu_array['��èѴ��â������к�']['����ͧ���㹡�ûŴ�Ѻ�ͧ������']);	
		unset($menu_array['��èѴ��â������к�']['�к��ͺ���§ҹ �.�.7']);	
		unset($menu_array['��èѴ��â������к�']['�к�������Ǩ�ͺ������']);	
		unset($menu_array['��èѴ��â������к�']['��§ҹ�Ѵ��ü����']);	
		unset($menu_array['��èѴ��â������к�']['�к���ͧ������䢢�����']);
		unset($menu_array['��§ҹ����Ѻ��������']['��§ҹ�������¹�Ţ�ѵ�']);
		unset($menu_array['��§ҹ����Ѻ��������']['��§ҹ�Ѳ�ҡ�úѹ�֡�����Ţͧ��ѡ�ҹ���������']);
		unset($menu_array['��§ҹ����Ѻ��������']['��§ҹ��������ż�������']);
}else if($_SESSION[session_status_extra] == "NOR" and $_SESSION[session_sapphire] != "1"){
		unset($menu_group['��§ҹ��õԴ�����èѴ�Ӣ����Ż�����Ԣͧ ���. ʾ�.']);	
		unset($menu_group['��§ҹ����Ѻ��������']);
		
}
if($_SESSION[session_status_extra] == "site_area"){
		unset($menu_group['��§ҹ��õԴ�����èѴ�Ӣ����Ż�����Ԣͧ ���. ʾ�.']);	
		unset($menu_group['��§ҹ����Ѻ��������']);
		unset($menu_group['�ѹ�֡������ update 48 ࢵ����ͧ']);
		
}// end if($_SESSION[session_status_extra] == "site_area"){


## �Դ���ٷ������ͧ����͡
unset($menu_group['�ѹ�֡�������Թ��͹���Ҵ���']);
unset($menu_group['�ѹ�֡������ update 48 ࢵ����ͧ']);
unset($menu_group['���һ���ѵԡ�èѴ�Ӣ�����']);
unset($menu_group['��§ҹ��õԴ�����èѴ�Ӣ����Ż�����Ԣͧ ���. ʾ�.']);	


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
