<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link rel="stylesheet" href="../<?php echo APP_REPORTBUILDER; ?>/common/font/Thai_Sans_Neue_Regular.css">
<style>
 body,td,th,a,input,select,span,div,tr,button {
  font-family: Thai Sans Neue Regular;
  font-size: 18px;
  color: #000000;
 }
 </style>
<?php
/**
 * @comment  header
 * @projectCode
 * @tor     
 * @package  core
 * @author Jakrit Monkong (jakrit@sapphire.co.th)
 * @created  14/09/2014
 * @access  public
 */
	@session_start();
	include('../../config/config_host.php');
	include('../survey/lib/class.function.php');
	$con = new Cfunction();
	$con->connectDB();

	$user = $_SESSION['username'];
	$pass = $_SESSION['pass'];
	
	$sql ="SELECT
				epm_staff.username AS user_id,
				epm_staff.`password` AS pass,
				org_groupmember.staffid,
				org_groupmember.gid,
				org_staffgroup.groupname
			FROM
			epm_staff
			INNER JOIN org_groupmember ON epm_staff.staffid = org_groupmember.staffid
			INNER JOIN org_staffgroup ON org_groupmember.gid = org_staffgroup.gid WHERE epm_staff.username = '".$user."' AND epm_staff.password = '".$pass."'";
	$results  = mysql_db_query(DB_USERMANAGER,$sql);
	$rs = mysql_fetch_array($results);
	if($rs <=0) { 
	header( "location:../usermanager/login.php");

	}
	
	function replacepin($pin){
		if($_SESSION['user_status']=='1' or $_SESSION['user_status']==''){
			return substr($pin,0,3).'XXXXXXXXXX';
		}else{
			return $pin;
		}
	}
	
	$year = ($month < 10) ? date('Y')  : date('Y')+1;
	$year = ($_GET['year'] == '') ? $year :  $_GET['year']-543;
	$year2 = $year+543;
?>
<style>
#tbhead_1 { height:80px;width:100px;}
#tbhead_2 { height:80px;}
#tbhead_3 { height:80px;width:462px;}
#phoneimg { display:none;}
.iconbox { height:26px; width:39px;}
@media screen and  (min-width: 1px) and (max-width: 360px) {
#tbhead_1 { display:none;width:0px;}
#tbhead_2 { display:none;width:0px;}
#tbhead_3 { display:none;width:0px;}
#phoneimg { display: block;}
.iconbox { height: auto; width:12%;}
}
@media (min-width: 361px)  and (max-width: 767px) { 

}
@media screen and  (min-device-width: 1px) and (max-device-width: 360px) {
#tbhead_1 { display:none;width:0px;}
#tbhead_2 { display:none;width:0px;}
#tbhead_3 { display:none;width:0px;}
#phoneimg { display: block;}

.iconbox { height: auto; width:8%;}
}
@media (min-device-width: 361px)  and (max-device-width: 767px) { 

}
</style>
<?php //print_r($_SESSION); ?>

<img src="../img/logo2_03.png" width="100%" id="phoneimg">
<table width="100%"  border="0" cellpadding="0" cellspacing="0"   style="background-image:url(../img/back01_07.png); background-size:auto 100% ;">
  <tr>
    <td id="tbhead_1"><img src="../img/logo_1_02.png" height="98%"></td>
    <td id="tbhead_2"><img src="../img/logo2_03.png" height="98%"></td>
    <td align="right" id="tbhead_3"><img src="../img/logo5_08.png" height="98%"></td>
  </tr>
</table>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"  style="padding:3px; background-image:url(../img/background_06.png); background-size:100% auto;">
<a href="../survey/home.php"><img src="../img/icon1_6.png"  class="iconbox" title="หน้าหลัก" border="0"></a>
<?php //if(count($_SESSION)<5){ ?><a href="../survey/dashboard.php"><img src="../img/icon1_2.png" class="iconbox"  title="Dashboard" border="0"></a><?php //} ?>
<!--a href="../survey/dashboard_childpayment.php?frame=1"><img src="../img/icon1_1.png" class="iconbox"  title="รายงานการเบิกจ่ายเงินอุดหนุนเด็กแรกเกิด จำแนกรายพื้นที่" border="0"></a>
<a href="../survey/dashboard_childpayment_other.php?frame=1"><img src="../img/icon1_1.png" class="iconbox"  title="รายงานสรุปผลการเบิกจ่ายเงินอุดหนุนเด็กแรกเกิด" border="0"></a>
<?php //if(count($_SESSION)<5){ ?><a href="../survey/search_question_form.php"><img src="../img/icon1_3.png" class="iconbox"  title="ค้นหาขั้นสูง" border="0"></a><?php //} ?>
<?php if($_SESSION['username']=='root'){ ?><a href="../survey/question_form.php?frame=form_excel"><img src="../img/icon1_4.png" class="iconbox"  title="ส่งออก Excel" border="0"></a><?php } ?> -->
<a href="../rev_supp/index.php"><img src="../img/icon-rev-supp.png" class="iconbox"  title="รายงานการรับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด" border="0"></a>
<a href="../usermanager/login.php"><img src="../img/icon1_5.png" class="iconbox"  title="ออกจากระบบ" border="0"></a>

	</td>
  </tr>
  <tr>
    <td align="right">

	<? if ($box_search == 'on' and $_GET['frame'] =='' ){?>

	<FORM method="post" action="dashboard.php?year=<?php echo $year2?>">
	  <TABLE  height="40" border="0" cellspacing="0" cellpadding="0" background="../img/scr_10.png">
	    <TR>
	      <td width="60" align="right">&nbsp;</td>
            <TD width="203" align="left"><SPAN style="background-position:bottom;"><SPAN class="sbox_l" ALIGN="right"></SPAN> <SPAN class="sbox" ALIGN="right">
              <INPUT type="text" id="srch_fld"  name="search_info" size="35" align="right" onBlur="if (this.value == '') {
                                        this.value = 'ค้นหา (เลขบัตร,ชื่อ,นามสกุล)';
                                        document.all.srch_fld.style.color = '#C0C0C0';
                                } else {
                                        document.all.srch_fld.style.color = '#000000';
                                }" onFocus="if (this.value == 'ค้นหา (เลขบัตร,ชื่อ,นามสกุล)') {
                                        this.value = '';
                                        document.all.srch_fld.style.color = '#C0C0C0';
                                } else {

                                        document.all.srch_fld.style.color = '#000000';
                                }"  value="<?php echo ((!empty($_POST["search_info"])) ? ($_POST["search_info"]) : ((!isset($_GET["reset_search"]) && !empty($_SESSION["search_info"]) ) ? $_SESSION["search_info"] : "ค้นหา (เลขบัตร,ชื่อ,นามสกุล)")); ?>" style="color: #C0C0C0;width:100%;"  onKeyPress="if (this.value == '') {
                                        document.all.srch_fld.style.color = '#C0C0C0';
                                } else {
                                        document.all.srch_fld.style.color = '#000000';
                                }" />
            </SPAN><SPAN class="sbox_r" id="srch_clear"></SPAN></SPAN></TD>
            <TD width="55" align="left">
              <INPUT type="submit" name="search" value="ค้นหา" />
              <!--<INPUT  type="button" name="reset_search" value="ล้างค่า"  onclick="window.location = 'mb_index.php?reset_search=Reset';"/>-->
              <?php /*?><IMG src="../img/icon_info.gif" alt="ค้นหาตามหมายเลขบัตรประชาชน ชื่อนามสกุล" width="16" height="16"  onclick="alert('ค้นหาตามหมายเลขบัตรประชาชน ชื่อนามสกุล');"  onMouseOver="this.style.cursor = 'hand';" align="absmiddle" />&nbsp;</SPAN><A href="form_search.php"><SPAN style="background-position:bottom;"><nobr>ค้นหาขั้นสูง</nobr></SPAN></A><?php */?>
            </TD>
          </TR>
	    </TABLE>
    </FORM>	<? } ?>
	
	</td>
  </tr>
</table>
