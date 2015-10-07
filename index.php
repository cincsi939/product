<?php
/**
 * @comment �����˹�ҡ���ʴ���������¡���Ѻ����ͧ
 * @projectCode 
 * @tor 
 * @package core
 * @author Kaisorrawat Panyo	
 * @access public
 * @created 08/08/2015
 */
// include'connect.php';
session_start();
############################################################# 
$ApplicationName="OSCC";
$VERSION="1.0";
#############################################################
include ("../../config/config.inc.php");
require_once("../../common/SMLcore/SMLcoreBack.php");
include ("../../common/paginator/function_get_pages.php");
// include("../../config/selectDB_oscc.php");
$fullname = $_SESSION['session_fullname'];
$staffid = $_SESSION['session_staffid'];


?>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-874">
		<link rel="stylesheet" href="../../common/oscc_font/style_font.css">
		<link rel="stylesheet" href="../../common/oscc_css/responsive.css">
		<link rel="stylesheet" href="../../common/oscc_css/menu.css">
        <title>�Ѻ����ͧ�����ͧ�ء��</title>
		<style>

		
		#infodata,#healty_chart,#familydata,#fingerdata,.whitebg{
			border-radius:5px;
			/*border:1px #CCCCCC solid;*/
			margin-top:15px;
			background-color:#FFF;
			/*box-shadow: 3px 3px 3px #888888;*/
			/*padding:10px;*/
			min-height:400px;
			/*padding-top:50px;*/
		}
		.whitebg td{
			padding-left:10px;
			height:25px;
			font-size:12px;
		}
        .tbl_dashboard{
             border : 1px solid #666;
             border-radius: 5px 5px 5px 5px;
             box-shadow: 3px 3px 5px #888888;
             background-color:#444;
        }
        .bg_header{
            background-image:url('../../images/img_oscc/bg_header.jpg');
            background-repeat:repeat-x; 
            background:#cae8ea;
        }
		.menu_list{
			font-family: !important;
			font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
			border-radius: 5px 5px 5px 5px;
			border : 1px solid #BBB;
			 background-image:url('../../images/img_oscc/bg_gline.png');
			 font-size:18px;
			  box-shadow: 1px 1px 2px  #888888;
	 
		}
		.menu_list_dis{
			font-family: !important; 
			font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
			 font-size:18px;
			 font-weight:bold;	
			 color:#CCC;
			 text-shadow:#FFF;
			 TEXT-DECORATION:none;
		}

		.menu_list a{
			font-family: !important;
			font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
			font-weight:bold;
			
			color:#666;
			text-shadow:#FFF;
			font-size: 18px;
			TEXT-DECORATION:none;
		}
		.menu_list a.active,
		.menu_list a:hover{
			font-family: !important;
			font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
			 font-size:18px;
			 text-shadow:#FFF;
			 TEXT-DECORATION:none;
			 COLOR: #f3960b;
			 font-weight:bold;
		}
		.row {
		  margin-right: -15px;
		  margin-left: -15px;
		}
		.col-md-5{
			position: relative;
			min-height: 1px;
			padding-right: 15px;
			padding-left: 15px;
			float: left;
			width: 41.66666667%;
		}
		
		#infodata1 {
			border-radius:5px;
			border:1px #CCCCCC solid;
			/*margin-top:15px;*/
			background-color:#FFF;
			box-shadow: 3px 3px 3px #888888;
			padding:10px;
			min-height:400px;
			/*padding-top:50px;*/
		}
		/*.active{
		  color: #f4a023;
		  text-shadow:#FFF;
		  cursor: default;
		  background-color: #fff;
		  border: 1px solid #ddd;
		  border-bottom-color: transparent;
		}*/
		</style>
	</head>
	<body style="margin-top: 0px; margin-bottom: 0px; margin-right: 0px; margin-left: 0px;">
		<?php
			include ("header.php");
		?><br>
		<?php
		@include("menu.php");
		?>
        <div class="row">
            <div class="col-md-5">
               <h3 style="font-family: THSarabunNew;font-weight: bold; font-size: 18px;margin-top: -10px;"> <img width="24" src="../personal_data/icon/report_child_1.png">  <?php echo $_SESSION['session_orgname']?></h3>
            </div>
        </div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="visible-md visible-lg" valign="top" width="200" align="center">
			        
					
						
						<?php
						include "left_menu.php";
						?>
						
					
					
				</td>
				<td valign="top" style="">
					<div style=" margin-left:15px; background-color:#e4e4e4;">
						<div class="table-responsive">
							<table class="table" width="95%" border="0" cellpadding="0" cellspacing="0" align="center">
								<tr>
									<td>
									<div id="infodata1" >
										
									
										<div id="infodata" >
											
											<?php
											// �ʴ������š���Ѻ��
											$sql = "SELECT
t1.sv_received_ID,
t1.sv_received_Label,
t1.Officer_ID,
t1.chan_compl_ID,
t1.way_advise_ID,
t1.inform,
t1.pname_ID,
t1.`name`,
t1.s_name,
t1.home_num,
t1.road,
t1.subdistrict_id,
t1.district_id,
t1.ccDigi,
t1.tel,
t1.email,
t1.subPname,
t1.gid,
t2.sv_details_ID,
t2.maj_prob_ID,
t2.min_prob_ID,
t2.level_urge_ID,
t2.type_inform,
t2.date,
t2.inputTime,
t2.titleEvent,
t2.locale,
t2.subdistric_id_de,
t2.distric_id_de,
t2.ccDigi_de,
t2.data_issue,
t2.data_hide,
t3.ove_oper_ID,
t4.crisis_cen_ID
FROM
	sv_received as t1 INNER JOIN sv_details_event as t2 on t1.sv_received_ID=t2.sv_received_ID
	LEFT JOIN  sv_procedure_cease as t3 on t1.sv_received_ID=t3.sv_received_ID
	LEFT JOIN sv_responsible as t4 on t1.sv_received_ID=t4.sv_received_ID
WHERE
t1.gid = '".$_SESSION['session_org']."'
GROUP BY
	t1.sv_received_ID
ORDER BY
	t1.sv_received_ID DESC
";
											
											if($_GET['debug'] == 'on'){
												echo $sql;
											}
											
											$k = 1;
											$sqlQuery = mysql_db_query(DB_OSCC,$sql) or die("Error Query " .mysql_error());
											// $Num_Rows = mysql_num_rows($sqlQuery);
											$page_all = mysql_num_rows($sqlQuery);
											
											$page = $_GET['page'];
											$per_page = 10;
											$view = $_GET['View'];
											$page_link = "index.php";
											$sqlPaging = getPaging($sql, $page_all, $page, $per_page, $view, $page_link );
											$intRow = ($page>0)?($page-1)*$per_page:0;
											$sqlQuery = mysql_db_query(DB_OSCC,$sqlPaging) or die("Error Query " .mysql_error());
											?>
											
										    
											<table width="99%" border="1" cellpadding="3" cellspacing="1" align="center" class="tbl_dashboard" style="font-size: 12px;">
												<tr align="center" class="bg_header" height="30">
													<td><b><?php echo TXT_NO?></b></td>
													<td><b><?php echo TXT_NO_RECIVED?></b></td>
													<td><b><?php echo TXT_DATE_RECIVED?></b></td>
													<td><b><?php echo TXT_TITLE_RECIVED?></b></td>
													<td><b><?php echo TXT_USER_RECIVED?></b></td>
													<td><b><?php echo TXT_PRIORITY_RECIVED?></b></td>
													<td><b><?php echo TXT_GPROUP_PLB_RECIVED?></b></td>
													<td><b><?php echo TXT_STATUS_RECIVED?></b></td>
													<td><b><?php echo TXT_INFORMER_RECIVED?></b></td>
													<td><b><?php echo TXT_TOOLS_RECIVED?></b></td>
												</tr>
												<?php
												while($rs = mysql_fetch_assoc($sqlQuery)){
													$intRow++;
													
													?>
													<tr style="background-color:#FFF;">
														<td align="center"><?=$intRow?></td>
														<td align="center" style="word-wrap: break-word;"><?=$rs['sv_received_Label']?></td>
														<?php
														
														
														$DateThai2Eng = new DateFormatThai();
														$DateReceived = $DateThai2Eng->date('j M Y', $rs['inputTime']);
														
														
														?>
														<td align="center"><?=$DateReceived?></td>
														<td align="left"><?=$rs['titleEvent']?></td>
														<?php
															$sql_Pre = "SELECT  t1.prename_th FROM ".DB_NAME.".tbl_prename AS t1 WHERE t1.id='".$rs['pname_ID']."' ";
															$queryPre = mysql_query($sql_Pre) or die("Error Query " .mysql_error());
															$rsPre = mysql_fetch_assoc($queryPre);
														?>
														<td align="left"><?=$rsPre['prename_th']?><?=$rs['name']?>&nbsp;&nbsp;<?=$rs['s_name']?></td>
														<?php
														
														$urgency = "SELECT urge  FROM levels_urgency WHERE level_urge_ID = '".$rs['level_urge_ID']."' ";
														$urgencyQuery =  mysql_query($urgency) or die("Error Query " .mysql_error());
														$rsUrgency = mysql_fetch_assoc($urgencyQuery);
														if($rsUrgency['urge'] == '��ǹ�ҡ'){
															
															$color = "#FF0000";
														}else{
															$color = "";
														}
														// while(){
															
														?>
															<td align="center" style="color:<?=$color?>"><?=$rsUrgency['urge']?></td>
														<?php
														// }
														
														$majplob = "SELECT majplob FROM major_probs WHERE major_probs.maj_prob_ID = '".$rs['maj_prob_ID']."' ";
														$majplobQuery = mysql_query($majplob) or die("Error Query " .mysql_error());
														$rsMajplob = mysql_fetch_assoc($majplobQuery);
														?>
															<td align="left"><?=$rsMajplob['majplob']?></td>
														<?php
															$sql_case = "
															SELECT
															t2.result
															FROM sv_procedure_cease AS t1 
															inner join overall_oper AS t2 ON t1.ove_oper_ID=t2.ove_oper_ID
															WHERE t1.sv_received_ID='".$rs['sv_received_ID']."'";
															
															$resultQuery = mysql_query($sql_case) or die("Error Query " .mysql_error());
															$rsResult = mysql_fetch_assoc($resultQuery);
															
															# �ʴ�����˹��§ҹ����Ѻ�Դ�ͺ
															$crisiscenter = "
															SELECT 
															t1.groupname
															FROM ".DB_USERMANAGER.".org_staffgroup AS t1 
															inner join sv_responsible AS t2 on t1.gid=t2.crisis_cen_ID
															WHERE t2.sv_received_ID='".$rs['sv_received_ID']."'";
															
															$crisiscenterQuery = mysql_query($crisiscenter) or die("Error Query " .mysql_error());
															$rsCrisiscenter = mysql_fetch_assoc($crisiscenterQuery);
															
														?>
														<td align="center" ><?=$rsResult['result']?><br>
															<?php
															$sqlUser = "SELECT
	sv_received.sv_received_ID,
	sv_services.sv_received_ID,
	sv_services.user_ID
FROM
	sv_services
INNER JOIN sv_received
ON sv_services.sv_received_ID = sv_received.sv_received_ID
WHERE
	sv_services.sv_received_ID = '".$rs['sv_received_ID']."' ";
	$QueryUser = mysql_query($sqlUser) or die("Error Query " .mysql_error());
	$rsUser = mysql_fetch_assoc($QueryUser);
															if($rsUser['user_ID'] == ''){
																?>
																<a href="JavaScript:if(confirm('�������ö���Թ��������ͧ�ҡ����բ����ż�����ԡ�� �׹�ѹ�����������ż�����ԡ��')==true){window.location='form_users.php?id_received=<?=$rs['sv_received_ID']?>';}">�ѧ�����������ͧ</a>
																<?php
															}else{
																?>
																<a href="form_get_send.php?id_received=<?=$rs['sv_received_ID']?>&crisiscenter=<?=$rsCrisiscenter['groupname']?>&send=send">
																	<?php
																	$sql_getsend = "SELECT 
																	type_getsend 
																	FROM sv_getsend_outside WHERE sv_received_ID='".$rs['sv_received_ID']."' ";
															
																	$getsendQuery = mysql_query($sql_getsend) or die("Error Query " .mysql_error());
																	$rsGetsend = mysql_fetch_assoc($getsendQuery);
															
															
															
																		if($rsGetsend['type_getsend'] == '0'){
																			$print = '�ѧ�����������ͧ';

																		}
																		if($rsGetsend['type_getsend'] == '1'){
																			$print = '�觵������ͧ����';

																		}else{
																			$print = '�ѧ�����������ͧ';
																		}
															
																		?>
																		<?=$print?></a>
																<?php
																
															}
															?>
														 </td>
																
														<?php
														
															?>
															<td align="left"><?=$rsCrisiscenter['groupname']?></td>
															
														
														<td colspan="2">
															<a href="form_approval.php?id_received=<?=$rs['sv_received_ID']?>&id_chan=<?=$rs['chan_compl_ID']?>&id_way=<?=$rs['way_advise_ID']?>&id_pname=<?=$rs['pname_ID']?>&id_maj=<?=$rs['maj_prob_ID']?>&id_min=<?=$rs['min_prob_ID']?>&id_level=<?=$rs['level_urge_ID']?>&id_crisis=<?=$rsCrisiscenter['groupname']?>&titleEvent=<?=$rs['titleEvent']?>&name=<?=$rs['name']?> <?=$rs['s_name']?>&date=<?=$DateReceived?>&edit=edit&page=<?=$page?> "><img src="../../images/img_oscc/document_edit.png" align="absmiddle"  width="24" border="0"></a>&nbsp;
															<?php
															$sqlTransfer = "SELECT sv_temp_trans.status_trans FROM sv_temp_trans WHERE sv_temp_trans.sv_received_ID = '".$rs['sv_received_ID']."' ";
															
															$QueryTransfer = mysql_query($sqlTransfer) or die("Error Query " .mysql_error());
															$rsTransfer = mysql_fetch_assoc($QueryTransfer);
															
															if($rsTransfer['status_trans'] == 'N' || $rsTransfer['status_trans'] == ''){
																?>
																<a href="JavaScript:if(confirm('�׹�ѹ���ź�����Ѻ�� <?=$rs['sv_received_Label']?>')==true){window.location='delete.php?id_received=<?=$rs['sv_received_ID']?>';} "><img src="../../images/img_oscc/file_delete.png" align="absmiddle"  width="24" border="0"></a>
																<?
															}else{
																?>
																<a href="JavaScript:alert('�����Ѻ�� <?=$rs['sv_received_Label']?> ���͹حҵ����ź������') "><img src="../../images/img_oscc/file_delete.png" align="absmiddle"  width="24" border="0"></a>
																
																<?php
															}
															
															?>
															

														</td>

													</tr>
													<?php
													$k++;
												}
												?>
											</table>
											
											</div>
											<footer>
												<div class="footer	">
													<br>
												    <!-- ������ <?php echo $Num_Rows; ?> ��¡��  | <?php echo $Num_Pages; ?> ˹�� | -->											  
											
												</div>
											</footer>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<script type="application/javascript">
			<?php
			 include("../../common/oscc_js/menu.js");
			 ?>
		</script>
	</body>
</html>