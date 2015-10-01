<?php
if($_GET['id_received']!=''){
$subject_ID = $_GET['id_received'];
}else{
	 header("Location: index.php");
                        exit;

}
/**
 * @comment �����˹�ҡ�úѹ�֡������ ������ԡ��?
 * @projectCode 
 * @tor 
 * @package core
 * @author Kaisorrawat Panyo
 * @access public
 * @created 08/08/2015
 */
session_start();
############################################################# 
$ApplicationName="OSCC";
$VERSION="1.0";
#############################################################

//�֧ᶺ�ʴ�
require_once("../../common/SMLcore/SMLcoreBack.php");
include("../../config/config.inc.php");
// include("../../config/selectDB_oscc.php");
include('library.php');
require_once('../../config/define_var.php');
//�֧������ ���ҧ�ӹ�˹�Ҫ���
$pre_names = fncSelect("SELECT
dcy_master.tbl_prename.*
FROM
dcy_master.tbl_prename WHERE priority != 3
ORDER BY (
 CASE `id`
 WHEN '83' 	THEN 1
 WHEN '84' 	THEN 2
 ELSE 3 END
									  ) ASC");
//�֧������ ���ҧ���������ͺ�ԡ��
$type_subscribers = fncSelectData('type_subscribers','subscriber','type_subsc_ID');
//�֧������ ���ҧ��ʹ�
$religions = fncSelectData('religions','religion','religion_ID');
//�֧������ ���ҧ���ͪҵ� �ѭ�ҵ�
$nationalities = fncSelect("
SELECT id,nationality_th FROM dcy_master.tbl_nationality ORDER BY `priority` ASC, friendly_country DESC, nationality_th ASC");
//�֧������ ���ҧʶҹ�Ҿ
$cond_persons = fncSelectData('cond_persons','condpers','cond_pers_ID');
//�֧������ ���ҧ�Ҫվ
$careers = fncSelectData('careers','career','career_ID');
//�֧������ ���ҧʶҹ�Ҿ��ͺ����
$cond_families = fncSelectData('cond_families','physcondfam','cond_fam_ID');
//�֧������ ���ҧ�Ըա���Թ�ҧ
$way_travels = fncSelectData('way_travels','travel','way_trav_ID');
//�֧������ ���ҧ���������Ң��¡�ä��������
$trade_opinion = fncSelectData('trade_opinion','opintrade','trade_opin_ID');
//�֧������ ���ҧ�������Ѻ����ͧ
$received = fncSelectData('sv_received','Officer_ID','sv_received_ID');

	foreach ($received as $key => $value) {
	}
$idKey = $key;

//�ا������ ���ҧ�����ż�����ԡ��
$services = fncSelectData('sv_services','Officer_ID','user_ID');

	foreach ($services as $keyUser => $data) {
		
	}
$keyUser += 1;
$idKeyUser = $keyUser;


?>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-874">
		<link rel="stylesheet" href="../../common/oscc_css/bootstrap_icon.css">
		<link rel="stylesheet" href="../../common/oscc_css/bootstrap_form.css">
		
		<!-- font --> 
		<link rel="stylesheet" href="../../common/oscc_font/style_font.css">
		
		<script src="../../common/jquery-1.8.2.min.js"></script>
		<!-- �ѹ��� -->
		<link href="../../common/SMLcore/Plugin/DatepickerTh/zebra_datepicker.css" rel="stylesheet" >
		<script src="../../common/DatepickerTh/ZebraDatepickerTh.min.js"></script>
		<script src="../../common/DatepickerTh/CheckDate.js"></script>
		<!-- tab menu -->
		
		<script src="../../common/oscc_js/tabcontent.js" type="text/javascript"></script>
		<script src="../../common/oscc_js/bootstrap.min.js"></script>
        <script src="js/form_users.js"></script>
		<link rel="stylesheet" href="../../common/oscc_css/responsive.css">
		<link rel="stylesheet" href="../../common/oscc_css/menu.css">
		<link href="../../common/oscc_css/tabcontent.css" rel="stylesheet" type="text/css" />
        <title>�Ѻ����ͧ�����ͧ�ء��</title>
		<style>

		.menu_list{
			 font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
			 border-radius: 5px 5px 5px 5px;
			 border : 1px soid_received #BBB;
			 background-image:url('../../images/img_oscc/bg_gline.png');
			 font-size:18px;
			 font-weight:bold;
			 box-shadow: 1px 1px 2px  #888888;
			 border-radius:5px; 
			 	-webkit-border-radius:5px; 
				-moz-border-radius:5px; 
	 
		}
		.menu_list_dis{
			 font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
			 font-size:18px;
			 font-weight:bold;
			 color:#CCC;
			 text-shadow:#FFF;
			 TEXT-DECORATION:none;
		}

		.menu_list a{
			 font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
			 font-size:18px;
			 font-weight:bold;
			 color:#666;
			 text-shadow:#FFF;
			 TEXT-DECORATION:none;
		}
		.menu_list a.active,
		.menu_list a:hover {
			 font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
			 font-size:18px;
			 font-weight:bold;
			 text-shadow:#FFF;
			 TEXT-DECORATION:none;
			 COLOR: #f3960b;
		}
		#infodata,#healty_chart,#familydata,#fingerdata,.whitebg{
			border-radius:5px;
			border:1px #CCCCCC soid_received;
			margin-top:0px;
			background-color:#FFF;
			box-shadow: 3px 3px 3px #888888;
			padding:20px;
			min-height:400px;
			padding-top:50px;
		}
		.whitebg td{
			padding-left:10px;
			height:25px;
			font-size:12px;
		}
        .tbl_dashboard{
             border : 1px soid_received #666;
             border-radius: 5px 5px 5px 5px;
             box-shadow: 3px 3px 5px #888888;
             background-color:#444;
        }
        .bg_header{
            background-image:url('../../images/img_oscc/bg_header.jpg');
            background-repeat:repeat-x; 
            background:#cae8ea;
        }
		.navGreen {
			font-family: Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
		    /*#F7819F
		    #F5A9BC
		    #F5A9BC*/
		    /*background: #F7819F;*/
		    background-color: #F7819F;
		    position: relative;
		    width: 95%;
		    /*min-height: 40px;*/
		    margin-left: 30px;
		    margin-bottom: 20px;
		    border: 1px soid_received transparent;
		}

		.rowBack {
		    background-color: #f8f8f8;
		}

		.divFont {
			font-family: Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
			font-size: 12px;
		}

		.labelCenter {
		    margin-top: 5px;
		}
		.center-block {
		  display: block;
		  margin-right: auto;
		  margin-left: auto;
		}
		
		.table_t {
  		  border-spacing: 0;
  		  border-collapse: collapse;
		  border-collapse: collapse !important;
		  width: 100%;
		  max-width: 100%;
		  margin-bottom: 20px;
	  	}
		
		textarea {
		  font-family: Tahoma,supermarketRegular,  "Microsoft Sans Serif" !important;
		  font-size: inherit;
	      line-height: inherit;
		  margin: 0;
		  font: inherit;
		  color: inherit;
		  overflow: auto;
		}
		ul {
		    list-style-type: none;
		    margin: 0;
		    padding: 0;
		}

		li {
		    display: inline;
		}
		.navbar-right {
		    float: right !important;
		    margin-right: -15px;
		  }
		  .navbar-right ~ .navbar-right {
		    margin-right: 0;
		  }
		  .navDiv{
		  	padding-bottom: 40px;
		  }
		  @media (min-width: 992px) {
		  	.col-md-9,.col-md-3{
		  		float: left;
		  	}
			.col-md-9 {
			    width: 75%;
			}
			.col-md-3 {
				width: 25%;
			}
		  }
		  .col-md-9,.col-md-3{
			  position: relative;
			  min-height: 1px;
			  padding-right: 15px;
			  padding-left: 15px;
		  }
		  .tabcontent
		  {
		      /*border: 1px solid #B7B7B7; */
		      padding: 30px;
		      background-color:#FFF;
		      border-radius: 0 3px 3px 3px;
		  }
  		.table {
    		  border-spacing: 0;
    		  border-collapse: collapse;
  		  border-collapse: collapse !important;
  		  width: 100%;
  		  max-width: 100%;
  		  margin-bottom: 20px;
  	  	}
		</style>
		<script type="text/javascript"language="javascript">
 
		   function CompareDate(date_compare,date_now) {
			   //Note: 00 is month i.e. January
			   var date_select = date_compare.split('/');
			   var date_select_now = date_now.split('/');
			   var dateStart = new Date((date_select[2]-543), date_select[1], date_select[0]); //Year, Month, Date
			   var dateEnd = new Date(date_select_now[2], date_select_now[1], date_select_now[0]); //Year, Month, Date
			   if (dateStart > dateEnd) {
					return false;
				}else{
					return true;
				}
			}
		 
			//CompareDate();
		</script>
		<script language="javascript">
		
		//�ŧ ���ʵ�ѡ�Ҫ �� �ط��ѡ�Ҫ
	    $(document).ready(function() {
	        // assuming the controls you want to attach the plugin to 
	        // have the "datepicker" class set
	        $('.datepicker').Zebra_DatePicker({
				format: 'd/m/Y',
				readonly_element:true,
				onSelect: function(dateText) {
					if(!CompareDate(dateText,'<?php echo  date('d/m/Y'); ?>')){
						$('#birthday').val('');
					}else{
						$('#age_date').val(calculateAge(dateText));
					}
					
				}
				//direction: [true, '<?php echo date('d/m/').(date('Y')+543);?>' ]
				//direction: [false, '<?php echo date('d/m/').(date('Y')+543);?>' ]
	        });
 
	    });
		//���͡�ѧ��Ѵ �������������¹��ҹ
		function chgAmphur(PvID){
			link_page = 'ajax.chgamphur.php?PvID='+PvID;
			$.get(link_page, function(data){
				//alert(data);
				$('#distric_box').html(data);
			});
			console.log(link_page);
		}
		function chgTambon(TbID){
			
			link_page = 'ajax.chgtambon.php?TbID='+TbID;
			
			$.get(link_page, function(data){
				//alert(data);
				$('#subDistric_box').html(data);
			});
			console.log(link_page);
		}
		//���͡�ѧ��Ѵ �������Ѩ�غѹ
		function chgAmphurDe(PvID){
			link_page = 'ajax.chgamphur.php?PvID='+PvID+'&Tpye=detail';
			$.get(link_page, function(data){
				//alert(data);
				$('#distric_box_de').html(data);
			});
			console.log(link_page);
		}
		function chgTambonDe(TbID){
			
			link_page = 'ajax.chgtambon.php?TbID='+TbID+'&Tpye=detail';
			
			$.get(link_page, function(data){
				//alert(data);
				$('#subDistric_box_de').html(data);
			});
			console.log(link_page);
		}
		//��Ǩ�ͺ �ѡ�þ����
	    function check_specail_cha(text){
	   		var  special_cha = /([.*+?^=!:@${}()|\[\]\\])/g ;
	   		return special_cha.test(text);
	    }
		//��Ǩ�ͺ ������ 10  ���
		function isPhoneNo(input){
			var regExp = /^0[0-9]{8,9}$/i;
			return regExp.test(input);
		}
		//��Ǩ�ͺ �Ţ�ѵ� 13 ��ѡ
		function checkID(id){
			if(id.length != 13) return false;
			for(i=0, sum=0; i < 12; i++)
				sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
				return false; return true;
		}
		
		//��Ǩ�ͺ form 
		function chkfrom(){
			//��Ǩ�ͺ��ͧ �ӹ�˹�Ҫ���
			if(form1.pname_ID.value == '0'){
				alert('�кؤӹ�˹�Ҫ���');
				form1.pname_ID.focus();
				return false;
			}
			// ��Ǩ�ͺ��ͧ input ����
			if(form1.name.value == ''){
				alert('�кت���');
				form1.name.focus();
				return false;
			}
			if(form1.name.value != ''){
				if(check_specail_cha(form1.name.value)){
					alert('��Ǩ�ͺ����');
					return false;
				}
			}
			// ��Ǩ�ͺ��ͧ input ���ʡ��
			if(form1.s_name.value == ''){
				alert('�кع��ʡ��');
				form1.s_name.focus();
				return false;
			}
			if(form1.s_name.value != ''){
				if(check_specail_cha(form1.s_name.value)){
					alert('��Ǩ�ͺ���ʡ��');
					return false;
				}
			}
			// ��Ǩ�ͺ��ͧ input ��˹� �ٻ��ó �����ѡɳ��ѡɳо����
			if(form1.special.value == ''){
				alert('�кص�˹� �ٻ��ó �����ѡɳ��ѡɳо����');
				form1.special.focus();
				return false;
			}
			if(form1.special.value != ''){
				if(check_specail_cha(form1.special.value)){
					alert('��Ǩ�ͺ�ѡ��');
					return false;
				}
			}
			//��Ǩ�ͺ��ͧ ��
			if(form1.sex.value == '0'){
				alert('�к���');
				form1.sex.focus();
				return false;
			}
			//��Ǩ�ͺ��ͧ ������������ԡ��
			if(form1.type_subsc_ID.value == '0'){
				alert('�кػ�����������ԡ��');
				form1.type_subsc_ID.focus();
				return false;
			}
			//��Ǩ�ͺ��ͧ input �Ţ���ѵû�ЪҪ�
			if(form1.idcard.value == ''){
				alert('�к��Ţ���ѵû�ЪҪ�');
				form1.idcard.focus();
				return false;
			}
 		   if ( form1.idcard.value.length != 13)
 		   {
 		      alert('��͡�����Ţ���ѵû�ЪҪ� 13 ��ѡ');
 		      return false;
 		   }
			if(!checkID(document.form1.idcard.value)){
				alert('���ʻ�ЪҪ����١��ͧ');
				form1.idcard.focus();
				return false;
			}
			//��Ǩ�ͺ��ͧ input �����Ţ˹ѧ����Թ�ҧ
			/*if(form1.passport.value == ''){
				alert('�к������Ţ˹ѧ����Թ�ҧ');
				form1.passport.focus();
				return false;
			}*/
			//��Ǩ�ͺ��ͧ input ��ʹ�
			if(form1.religion_ID.value == '0'){
				alert('�к���ʹ�');
				form1.religion_ID.focus();
				return false;
			}
			//��Ǩ�ͺ��ͧ input ���ͪҵ�
			if(form1.nat_ID.value == '0'){
				alert('�к����ͪҵ�');
				form1.nat_ID.focus();
				return false;
			}
			//��Ǩ�ͺ��ͧ input �ѭ�ҵ�
			if(form1.race_ID.value == '0'){
				alert('�к��ѭ�ҵ�');
				form1.race_ID.focus();
				return false;
			}
			//��Ǩ�ͺ��ͧ input �Դ�ѹ���
			if(form1.birthday.value == ''){
				alert('�к��Դ�ѹ���');
				form1.birthday.focus();
				return false;
			}
			//��Ǩ�ͺ��ͧ input ���� � �ѹ�����
			if(form1.age_date.value == ''){
				alert('�к����� � �ѹ�����');
				form1.age_date.focus();
				return false;
			}
			if(form1.age_date.value != ''){
				if(check_specail_cha(form1.age_date.value)){
					alert('��سҡ�͡�繵���Ţ');
					form1.age_date.focus();
					return false;
				}
			}
			if(isNaN(document.form1.age_date.value)) {
				alert('��سҡ�͡�繵���Ţ');
			    document.form1.age_date.focus();
			    return false;
			}
			//��Ǩ�ͺ��ͧ input ʶҹ�Ҿ
			if(form1.cond_pers_ID.value == '0'){
				alert('�к�ʶҹ�Ҿ');
				form1.cond_pers_ID.focus();
				return false;
			}
			//��Ǩ�ͺ��ͧ input �������Ҫվ
			/*if(form1.career_ID.value == '0'){
				alert('�кػ������Ҫվ');
				form1.career_ID.focus();
				return false;
			}*/
			// ��Ǩ�ͺ��ͧ input ��ҹ�Ţ��� �������¹��ҹ
			// if(form1.h_Number_reg.value == ''){
// 				alert('�кغ�ҹ�Ţ���������¹��ҹ');
// 				form1.h_Number_reg.focus();
// 				return false;
// 			}
			if(form1.h_Number_reg.value != ''){
				if(check_specail_cha(form1.h_Number_reg.value)){
					alert('��Ǩ�ͺ��ҹ�Ţ���������¹��ҹ');
					return false;
				}
			}
			if(isNaN(document.form1.h_Number_reg.value)) {
			        alert('��سҡ�͡�������������¹��ҹ�繵���Ţ');
			        document.form1.h_Number_reg.focus();
			        return false;
			}

			//��Ǩ�ͺ��ͧ �ѧ��Ѵ �������������¹��ҹ
			if(form1.province_id_reg.value == '0'){
				alert('�кبѧ��Ѵ');
				form1.province_id_reg.focus();
				return false;
			}
			//��Ǩ�ͺ��ͧ input �������Ѿ�� �������������¹��ҹ
			if(form1.phone_reg.value == ''){
				alert('�к��������Ѿ��������������¹��ҹ');
				form1.phone_reg.focus();
				return false;
			}
		   /*if ( form1.phone_reg.value.length != 10)
		   {
		      alert('��͡�����Ţ���Ѿ�� 10 ��ѡ');
			  form1.phone_reg.focus();
		      return false;
		   }

		   for (i = 0; i < form1.phone_reg.value.length; i++ ) {
		      if ( form1.phone_reg.value.charCodeAt(i) < 48 || form1.phone_reg.value.charCodeAt(i) > 57 ) {
		         alert('��سҡ�͡�������Ѿ���繵���Ţ');
				 form1.phone_reg.focus();
		         return false;
		      } else {

		         if ( ((i == 0) && (form1.phone_reg.value.charCodeAt(i) != 48)) || ((i == 1) && (form1.phone_reg.value.charCodeAt(i) != 56)) )
		         {
		            alert('��سҡ�͡�������Ѿ���繵���Ţ');
					form1.phone_reg.focus();
		            return false;
		         }
		      }
		   }*/
			// ��Ǩ�ͺ��ͧ input ��ҹ�Ţ��� �Ѩ�غѹ
			// if(form1.h_Number_current.value == ''){
// 				alert('�кغ�ҹ�Ţ���Ѩ�غѹ');
// 				form1.h_Number_current.focus();
// 				return false;
// 			}
			if(form1.h_Number_current.value != ''){
				if(check_specail_cha(form1.h_Number_current.value)){
					alert('��Ǩ�ͺ��ҹ�Ţ���Ѩ�غѹ');
					return false;
				}
			}
			if(isNaN(document.form1.h_Number_current.value)) {
			        alert('��سҡ�͡��ҹ�Ţ�������Ѩ�غѹ�繵���Ţ');
			        document.form1.h_Number_current.focus();
			        return false;
			}

			//��Ǩ�ͺ��ͧ �ѧ��Ѵ �������Ѩ�غѹ
			if(form1.province_id_current.value == '0'){
				alert('�кبѧ��Ѵ');
				form1.province_id_current.focus();
				return false;
			}

		//��Ǩ�ͺ��ͧ input �������Ѿ�� �������Ѩ�غѹ
		if(form1.phone_current.value == ''){
			alert('�к��������Ѿ��������Ѩ�غѹ');
			form1.phone_current.focus();
			return false;
		}
	  /* if ( form1.phone_current.value.length != 10)
	   {
	      alert('��͡�����Ţ���Ѿ�� 10 ��ѡ');
		  form1.phone_current.focus();
	      return false;
	   }

	   for (i = 0; i < form1.phone_current.value.length; i++ ) {
	      if ( form1.phone_current.value.charCodeAt(i) < 48 || form1.phone_current.value.charCodeAt(i) > 57 ) {
	         alert('��سҡ�͡�������Ѿ���繵���Ţ');
			 form1.phone_current.focus();
	         return false;
	      } else {

	         if ( ((i == 0) && (form1.phone_current.value.charCodeAt(i) != 48)) || ((i == 1) && (form1.phone_current.value.charCodeAt(i) != 56)) )
	         {
	            alert('��سҡ�͡�������Ѿ���繵���Ţ');
				form1.phone_current.focus();
	            return false;
	         }
	      }
	   }*/

	// ��Ǩ�ͺ��ͧ input ����-ʡ�źԴ�
	if(form1.name_father.value == ''){
		alert('�кت���-ʡ�źԴ�');
		form1.name_father.focus();
		return false;
	}
	if(!(isNaN(document.form1.name_father.value))) {
		alert("��͡�繵���ѡ��") ;
		document.form1.name_father.focus() ;
		return false ;
	}
	// ��Ǩ�ͺ��ͧ input ����-ʡ����ô�
	if(form1.name_mom.value == ''){
		alert('�кت���-ʡ����ô�');
		form1.name_mom.focus();
		return false;
	}
	if(!(isNaN(document.form1.name_mom.value))) {
		alert("��͡�繵���ѡ��") ;
		document.form1.name_mom.focus() ;
		return false ;
	}
	//��Ǩ�ͺ��ͧ ��ͺ����  ʶҹ�Ҿ
	if(form1.cond_fam_ID.value == '0'){
		alert('ʶҹ�Ҿ��ͺ����');
		form1.cond_fam_ID.focus();
		return false;
	}
	//��Ǩ�ͺ��ͧ �ӹǹ�ص÷��������֡�� �繵���Ţ�������
	if(isNaN(document.form1.studied.value)) {
		alert('��سҡ�͡�繵���Ţ');
       document.form1.studied.focus();
       return false;
   	}
	//��Ǩ�ͺ��ͧ �ӹǹ�ص÷����ѧ�֡�� �繵���Ţ�������
	if(isNaN(document.form1.study.value)) {
		alert('��سҡ�͡�繵���Ţ');
       document.form1.study.focus();
       return false;
   	}
	//��Ǩ�ͺ��ͧ �ӹǹ�ص÷��ӧҹ���� �繵���Ţ�������
	if(isNaN(document.form1.work.value)) {
		alert('��سҡ�͡�繵���Ţ');
       document.form1.work.focus();
       return false;
   	}
	//��Ǩ�ͺ��ͧ �ӹǹ�ص÷�������ӧҹ���� �繵���Ţ�������
	if(isNaN(document.form1.notwork.value)) {
		alert('��سҡ�͡�繵���Ţ');
       document.form1.notwork.focus();
       return false;
   	}
	//��Ǩ�ͺ��ͧ �Ըա���Թ�ҧ
	// if(form1.way_trav_ID.value == '0'){
// 		alert('�к��Ըա���Թ�ҧ');
// 		form1.way_trav_ID.focus();
// 		return false;
// 	}
	   //��Ǩ�ͺ��� checkbox �١��з�
	   	// var a=new Array();
	//    	a=document.getElementsByName("action[]");
	//    	//alert("Length:"+a.length); // �ʴ���Ҩӹǹ Checkbox ����շ������Ẻ�����
	//    	var p=0;
	//    	for(i=0;i<a.length;i++){
	//    		if(a[i].checked){
	//    			//alert(a[i].value); // �ʴ���ҷ��١���͡���
	//    			p=1;
	//    		}
	//    	}
	//    	if (p==0){
	//    		alert('�ô��ԡ���͡  ��ö١��з���ѡɳТ��㴢��˹��  !!');
	//    		return false;
	//    	}


		//��Ǩ�ͺ��� checkbox �����Ը���ѡɳ�
	   	// var b=new Array();
// 	   	b=document.getElementsByName("method[]");
// 	   	//alert("Length:"+a.length); // �ʴ���Ҩӹǹ Checkbox ����շ������Ẻ�����
// 	   	var k=0;
// 	   	for(j=0;j<b.length;j++){
// 	   		if(b[j].checked){
// 	   			//alert(a[i].value); // �ʴ���ҷ��١���͡���
// 	   			k=1;
// 	   		}
// 	   	}
// 	   	if (k==0){
// 	   		alert('�ô��ԡ���͡ ������Ը���ѡɳТ��㴢��˹�� ��ö١��з���ѡɳТ��㴢��˹�� !!');
// 	   		return false;
// 	   	}

		//��Ǩ�ͺ��� checkbox �����Ը���ѡɳ�
	   	// var c=new Array();
// 	   	c=document.getElementsByName("objective[]");
// 	   	//alert("Length:"+a.length); // �ʴ���Ҩӹǹ Checkbox ����շ������Ẻ�����
// 	   	var h=0;
// 	   	for(n=0;n<c.length;n++){
// 	   		if(c[n].checked){
// 	   			//alert(a[i].value); // �ʴ���ҷ��١���͡���
// 	   			h=1;
// 	   		}
// 	   	}
// 	   	if (h==0){
// 	   		alert('�ô��ԡ���͡ �ѵ�ػ��ʧ����㴢��˹�� !!');
// 	   		return false;
// 	   	}
	
	   
	   
		}
		
		function ShowDisabled(){
			if(form1.daughter.value != '' || form1.son.value != ''){
				document.getElementById("studied").disabled = false;
				document.getElementById("study").disabled = false;
				document.getElementById("work").disabled = false;
				document.getElementById("notwork").disabled = false;
				if(isNaN(document.form1.daughter.value)) {
					alert("��سҡ�͡�����Ũӹǹ�ص�˭ԧ�繵���Ţ") ;
					document.form1.daughter.focus() ;
					return false ;
				}
				if(isNaN(document.form1.son.value)) {
					alert("��سҡ�͡�����Ũӹǹ�صê���繵���Ţ") ;
					document.form1.son.focus() ;
					return false ;
				}
			}else{
				document.getElementById("studied").disabled = true;
				document.getElementById("study").disabled = true;
				document.getElementById("work").disabled = true;
				document.getElementById("notwork").disabled = true;
			}
			
			
		}
		function Count(){
			
			Son = $('#son').val();
			daughter = $('#daughter').val();
			if(Son == ''){
				Son = 0;
			}
			if(daughter == ''){
				daughter = 0;
			}
			var sumSon = parseInt(Son);
			var sumDaughter = parseInt(daughter);
			var result = sumSon + sumDaughter ;
			$('#sum').html('<input type="text" name="sum_child" class="" id="sum_child" placeholder="" style="width:50px;" value="'+result+'" disabled>');
			
			
		}
		 $(document).ready(function() {

			 $(".numberOnly").keydown(function (e) {
			         // Allow: backspace, delete, tab, escape, enter and .
			         if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			              // Allow: Ctrl+A, Command+A
			             (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
			              // Allow: home, end, left, right, down, up
			             (e.keyCode >= 35 && e.keyCode <= 40)) {
			                  // let it happen, don't do anything
			                  return;
			         }
			         // Ensure that it is a number and stop the keypress
			         if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			             e.preventDefault();
			         }
			});
			 
			Son = $('#son').val();
			daughter = $('#daughter').val();
			if(Son == ''){
				Son = 0;
			}
			if(daughter == ''){
				daughter = 0;
			}
			var sumSon = parseInt(Son);
			var sumDaughter = parseInt(daughter);
			var result = sumSon + sumDaughter ;
			$('#sum').html('<input type="text" name="sum_child" class="" id="sum_child" placeholder="" style="width:50px;" value="'+result+'" disabled>');
			
			
			
			
			
			if(form1.daughter.value != '' || form1.son.value != ''){
				document.getElementById("studied").disabled = false;
				document.getElementById("study").disabled = false;
				document.getElementById("work").disabled = false;
				document.getElementById("notwork").disabled = false;
				
				
				
			}else{
				document.getElementById("studied").disabled = true;
				document.getElementById("study").disabled = true;
				document.getElementById("work").disabled = true;
				document.getElementById("notwork").disabled = true;
			}
var st1,st2,st3,st4,sumst1,sumst2,sumst3,sumst4,sumset,sumall;
$( "#studied" ).keyup(function() {
	console.log($("#studied").val());
	console.log($("#study").val());
	console.log($("#work").val());
	console.log($("#notwork").val());
	console.log($("#sum_child").val());
				st1 = $("#studied").val();
				st2 = $("#study").val();
				st3 = $("#work").val();
				st4 = $("#notwork").val();
				sumall=$("#sum_child").val();
				if(st1==''){
				st1='0';
				}
				if(st2==''){
				st2='0';
				}
				if(st3==''){
				st3='0';
				}
				if(st4==''){
				st4='0';
				}
sumst1 = parseInt(st1);
sumst2 = parseInt(st2);
sumst3 = parseInt(st3);
sumst4 = parseInt(st4);

sumset = sumst1+sumst2+sumst3+sumst4;
if(sumset>sumall){
alert('�ص��Թ�ӹǹ');
$('#studied').val('');

}
});
$( "#study" ).keyup(function() {
	console.log($("#studied").val());
	console.log($("#study").val());
	console.log($("#work").val());
	console.log($("#notwork").val());
	console.log($("#sum_child").val());
				st1 = $("#studied").val();
				st2 = $("#study").val();
				st3 = $("#work").val();
				st4 = $("#notwork").val();
				sumall=$("#sum_child").val();
				if(st1==''){
				st1='0';
				}
				if(st2==''){
				st2='0';
				}
				if(st3==''){
				st3='0';
				}
				if(st4==''){
				st4='0';
				}
sumst1 = parseInt(st1);
sumst2 = parseInt(st2);
sumst3 = parseInt(st3);
sumst4 = parseInt(st4);

sumset = sumst1+sumst2+sumst3+sumst4;
if(sumset>sumall){
alert('�ص��Թ�ӹǹ');
$('#study').val('');
}
});
$( "#work" ).keyup(function() {
	console.log($("#studied").val());
	console.log($("#study").val());
	console.log($("#work").val());
	console.log($("#notwork").val());
	console.log($("#sum_child").val());
				st1 = $("#studied").val();
				st2 = $("#study").val();
				st3 = $("#work").val();
				st4 = $("#notwork").val();
				sumall=$("#sum_child").val();
				if(st1==''){
				st1='0';
				}
				if(st2==''){
				st2='0';
				}
				if(st3==''){
				st3='0';
				}
				if(st4==''){
				st4='0';
				}
sumst1 = parseInt(st1);
sumst2 = parseInt(st2);
sumst3 = parseInt(st3);
sumst4 = parseInt(st4);

sumset = sumst1+sumst2+sumst3+sumst4;
if(sumset>sumall){
alert('�ص��Թ�ӹǹ');
$('#work').val('');
}
});
$( "#notwork" ).keyup(function() {
	console.log($("#studied").val());
	console.log($("#study").val());
	console.log($("#work").val());
	console.log($("#notwork").val());
	console.log($("#sum_child").val());
				st1 = $("#studied").val();
				st2 = $("#study").val();
				st3 = $("#work").val();
				st4 = $("#notwork").val();
				sumall=$("#sum_child").val();
				if(st1==''){
				st1='0';
				}
				if(st2==''){
				st2='0';
				}
				if(st3==''){
				st3='0';
				}
				if(st4==''){
				st4='0';
				}
sumst1 = parseInt(st1);
sumst2 = parseInt(st2);
sumst3 = parseInt(st3);
sumst4 = parseInt(st4);

sumset = sumst1+sumst2+sumst3+sumst4;
if(sumset>sumall){
alert('�ص��Թ�ӹǹ');
$('#notwork').val('');
}
});

		
});
function cancal(){
	$('#form_cancal').submit();
}
		</script>


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
				<td valign="top" style="padding-top: 8px;">
					<div style=" margin-left:15px; margin-right:15px; background-color:#e4e4e4;">
						<div class="table-responsive">
						<table width="97%" class="table" border="0" cellpadding="0" cellspacing="0" align="center">
							<tr>
								<td>
									<div id="infodata" style="padding-top: 20px;">
					                    <table width="99%" border="0" cellpadding="3" cellspacing="1" align="center" class="">
										<!--����ᶺ�ʴ��Ţ����Ѻ�� ����ͧ ���� �ѹ���-->
										<?php
														$received = $_GET['id_received'];
														$titleEvent = $_GET['titleEvent'];
														$name = $_GET['name'];
														
														$dateReceived = "SELECT * FROM `sv_details_event`,sv_received,sv_responsible WHERE sv_received.sv_received_ID = '".$received."' AND sv_details_event.sv_received_ID = '".$received."' GROUP BY sv_received.sv_received_ID ";
														$dateReceivedQuery = mysql_query($dateReceived) or die("Error Query " .mysql_error());
														$rsReceived = mysql_fetch_assoc($dateReceivedQuery);
														
														$name_office = $rsReceived['name_office'];
														
														$DateThai2Eng = new DateFormatThai();
														$DateReceived = $DateThai2Eng->date('j M Y', $rsReceived['date']);
														
													?>
											<tr>
																<label for="" class="labelCenter"><? echo TXT_NO_RECIVED ?> :</label><span>&nbsp;<?=$rsReceived['sv_received_Label']?>&nbsp;&nbsp;&nbsp;</span>
																<label for="" class="labelCenter">����ͧ�Ѻ�� :</label><span>&nbsp;<?=$rsReceived['titleEvent']?>&nbsp;&nbsp;&nbsp;</span>
																<?php
																$sql_Pre = "SELECT `dcy_master`.`tbl_prename`.*,`sv_received`.pname_ID FROM `dcy_master`.`tbl_prename`,`sv_received` WHERE sv_received.sv_received_ID = '".$_GET['id_received']."' AND sv_received.pname_ID = tbl_prename.id ";
																$queryPre = mysql_query($sql_Pre) or die("Error Query " .mysql_error());
																$rsPre = mysql_fetch_assoc($queryPre);
																?>
																<label for="" class="labelCenter">���ͼ���� :</label><span>&nbsp;<?=$rsPre['prename_th']?><?=$rsReceived['name']?>&nbsp;<?=$rsReceived['s_name']?>&nbsp;&nbsp;&nbsp;</span>
																<label for="" class="labelCenter">�ѹ����Ѻ���˵� :</label><span>&nbsp;<?=$DateReceived?>&nbsp;&nbsp;&nbsp;</span>
															</tr>
															<!--����ᶺ�ʴ��Ţ����Ѻ�� ����ͧ ���� �ѹ���-->
					                        <tr style="background-color:#FFF;">
					                            <td>
													<?php
													$url="insert.php";
													if($_GET['edit'] == 'edit'){
														$iduser=$_GET['iduser'];
														$resultprofile = mysql_query("select * from sv_services where user_ID='$iduser' and services_ID='$idservices'");
														$resultpro=mysql_fetch_array($resultprofile);
														$url="update.php";
														}


													?>
														<?php
													   $sqlchk=mysql_query("select count(*)  as statust from sv_temp_trans where sv_received_ID ='$id_received'");
													   $sqlchkstatus=mysql_fetch_array($sqlchk);
													    $sqlchk1=mysql_query("select * from sv_temp_trans where sv_received_ID ='$id_received'");
														$sqlchkstatus1=mysql_fetch_array($sqlchk1);

													   if($sqlchkstatus['statust']>='1'&&$sqlchkstatus1['status_trans']=='Y'){
														   echo "</br>";
														   echo '<font color="#FF0000"><strong>�������ö���� ź ������� ������ԡ���� </strong></font>';
													   }else{
															
													?>
													<form action="<?php echo $url; ?>" method="post" name="form1" onSubmit="return chkfrom();">
										                <div class="navDiv">
															<div class="form-inline" align="right">
																<div class="form-group">
							                                        <button type="submit" name="submitFrafficking" class="btn btn-default" aria-label="Left Align" style="margin-top: 0px;">
							                                            �ѹ�֡
							                                        </button>
																	<?php
																	if($_REQUEST["cancal"] == "cancal"){

																		echo "<script>window.location='form_users.php?id_received='".$_GET['id_received']."' ';</script>";

																	}
																	?>
												                    <button type="reset" name="cancelApproval" class="btn btn-default" aria-label="Left Align" style="margin-top: 0px;" onclick="javascript:return cancal();">
												                        ¡��ԡ
												                    </button>
																</div>
															</div>   
										                	
										                </div>
									                <div class="col-md-3 " style="padding-left: 0px;">
														<table>
															<tr>
																<td style="width: 102px;">������ԡ��<td>
																<!-- <td><button type="button" class="btn btn-default" class="pull-right" style="margin-left:75px;">
									                        			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
									                    			</button>
																<td> -->
															</tr>
														</table>
														
									                    <div style="border:0px solid red;width:260px;height:420px;overflow:auto">
									                    <table class="table divFont">
															<?php
															$i = 1;
															$sql = "SELECT
sv_services.services_ID,
sv_services.pname_ID,
sv_services.user_ID,
sv_services.`name`,
sv_services.s_name,
`dcy_master`.`tbl_prename`.id,
`dcy_master`.`tbl_prename`.prename_th

FROM
	`sv_services`,
	`dcy_master`.`tbl_prename`
WHERE
	sv_services.pname_ID = tbl_prename.id
AND sv_received_ID ='$subject_ID'";

															$sqlQuery = mysql_query($sql) or die("Error Query " .mysql_error());
															while($rs = mysql_fetch_assoc($sqlQuery)){
															?>
															
									                        <tr>
									                            <td>
									                                <label style="font-weight: 100;" class="labelCenter"><?=$i?>. <?=$rs['prename_th']?> <?=$rs['name']?> <?=$rs['s_name']?> </label>
									                            </td>
																
																<td>
																	<img src="../images/setting_logo.png" width="24" height="24" class="show_menu" style="cursor:pointer" id="<?=$rs['services_ID']?>_<?=$subject_ID?>" onClick="showMenu('<?=$rs['services_ID']?>','<?=$subject_ID?>','<?=$rs['user_ID']?>');">
																	<div class="menuList" id="menuList<?=$rs['services_ID']?>_<?=$subject_ID?>"></div>
									                            </td>
									                            <!--td>
									                                <a href="form_users.php?edit=edit&iduser=<?=$rs['user_ID']?>&idservices=<?=$rs['services_ID']?>&id_received=<?=$subject_ID;?>" class="btn glyphicon glyphicon-pencil" type="button"></a>
									                            </td>
																<td>
									                                <a href="form_doc_users.php?user_ID=<?=$rs['user_ID']?>&id_received=<?=$subject_ID;?>&action=viewfolder"><img src="index_files/paperclip.gif" width="20px;"></a>
									                            </td>
									                            <td>
									                                <!-- <a href="delete.php" class="btn glyphicon glyphicon-trash" type="button"></a> >
																	<a href="JavaScript:if(confirm('Confirm Delete?')==true){window.location='delete.php?sv_services=<?=$rs['services_ID']?>&user_ID=<?=$rs['user_ID']?>';} " class="btn glyphicon glyphicon-trash" type="button"></a>
									                            </td-->
																
									                        </tr>
															<?php
															$i++;
															}
															?>
									                    </table>
													</div>
									                </div>
									                <div class="col-md-9">
														<ul class="tabs" data-persist="true">
															<li ><a href="#view1" style="display:inline">��������ǹ���</a></li>
														    <li ><a href="#view2" style="display:inline">��ͺ����</a></li>
														    <li ><a href="#view3" style="display:inline">������ӻ�֡��</a></li>
															<li ><a href="#view4" style="display:inline">���������</a></li>
														</ul>
														<div class="tabcontent divFont" style="width: 660px; padding-left: 10px;">
								                        	<input type="hidden" name="sv_received_ID" value="<?=$_GET['id_received'];?>">
															<input type="hidden" name="services_ID" value="<?=$_GET['idservices'];?>">
								                            <input type="hidden" name="user_ID" value="<?php 
															if($_GET['iduser']==''){
													
													echo $idKeyUser;

													}else{
													echo $iduser;
													}
													?>">
															<div id="view1" style="width: 630px;">
																<!-- ��������ǹ��� -->
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">���� <span style="color:#F00">*</span> :</label>
								                                        <select name="pname_ID" id="pname_ID" class="">
								                                            <option value="0">-</option>
								                                            <?php
																				if(mysql_num_rows($pre_names) > 0){
																					while($obj = mysql_fetch_object($pre_names)){
																			?>
								                                                <option value="<?=$obj->id?>" 
																				<?php  echo ($obj->id == $resultpro['pname_ID']) ? 'selected' : '';?> 
                                                                                sex=<?php echo $obj->gender?>><?=$obj->prename_th?></option>
								                                                <?php 
																			}}
																			?>
								                                        </select>
								                                        <input type="text" name="name" class="" id="name" placeholder="" value="<?=$resultpro['name'];?>">
								                                    </div>
								                                    <div class="form-group ">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">���ʡ�� <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="s_name" class="" id="s_name" placeholder="" style="width: 147.63636350631714px;"value="<?=$resultpro['s_name'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��˹� �ٻ��ó �����ѡɳ��ѡɳо���� <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="special" class="" id="special" placeholder=""value="<?=$resultpro['special'];?>">
								                                    </div>
								                                    <div class="form-group">
                                                                    	<div style="position:absolute; width:100%; height:20px;" id="sexSelect"></div>
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�� <span style="color:#F00">*</span> :</label>
								                                        <select name="sex" id="sex" class="" value="0">
																			<option value="0" <?php if(0==$resultpro['sex']){echo 'selected';}?>>---</option>
								                                            <option value="M" <?php if('M'==$resultpro['sex']){echo 'selected';}?>>���</option>
								                                            <option value="F" <?php if('F'==$resultpro['sex']){echo 'selected';}?>>˭ԧ</option>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">������������ԡ�� <span style="color:#F00">*</span> :</label>
								                                        <select name="type_subsc_ID" id="type_subsc_ID" class="" style="width:150px;">
								                                            <option value="0">---</option>
								                                            <?php
																				$countArr = count($type_subscribers);
																				//print_r($countArr);
																				if($countArr > 0){
																					foreach($type_subscribers as $j => $data ){
																			?>
								                                                <option value="<?=$j?>" <?php if($j==$resultpro['type_subsc_ID']){echo 'selected';}?>>
								                                                    <?=$data ?>
								                                                </option>
								                                                <?php 
																			}	
																		}
																	?>
								                                        </select>
								                                    </div>
								                                    <div class="form-group" id="etc_n1">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�к� :</label>
								                                        <input type="text" name="specify" class="" id="specify" placeholder="" value="<?=$resultpro['specify'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�Ţ�ѵû�Шӵ�ǻ�ЪҪ� <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="idcard" class="" id="idcard" placeholder="" style="width: 150.63636350631714px;" value="<?=$resultpro['idcard'];?>">
																		
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�����Ţ˹ѧ����Թ�ҧ<span style="color: #F00"> </span>:</label>
								                                        <input type="text" name="passport" class="" id="passport" placeholder="" value="<?=$resultpro['passport'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�͡��û�Шӵ������ :</label>
								                                        <input type="text" name="other_doc" class="" id="" placeholder="" style="width: 154.63636350631714px;" value="<?=$resultpro['other_doc'];?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��ʹ� <span style="color:#F00">*</span> :</label>
								                                        <select name="religion_ID" id="religion_ID" class="">
								                                            <option value="0">---</option>
								                                            <?php
																				$countArr = count($religions);
																				//print_r($countArr);
																				if($countArr > 0){
																					foreach($religions as $j => $data ){
																			?>
								                                                <option value="<?=$j?>" <?php if($j==$resultpro['religion_ID']){echo 'selected';} ?>>
								                                                    <?=$data ?>
								                                                </option>
								                                                <?php 
																			}	
																		}
																	?>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">���ͪҵ� <span style="color:#F00">*</span> :</label>
								                                        <select name="nat_ID" id="nat_ID" class="" style="width:150px;">
								                                            <option value="0">---</option>
								                                            <?php
																				if(mysql_num_rows($nationalities) > 0){
																					while($obj = mysql_fetch_object($nationalities)){
																			?>
								                                                <option value="<?=$obj->id?>" <?php if($obj->id==$resultpro['nat_ID']){echo 'selected';} ?>>
								                                                    <?=$obj->nationality_th ?>
								                                                </option>
								                                                <?php 
																			}}
																			?>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�ѭ�ҵ� <span style="color:#F00">*</span> :</label>
								                                        <select name="race_ID" id="race_ID" class="" style="width:151.81818175315857px;">
								                                            <option value="0">---</option>
								                                            <?php
																				$nationalities = fncSelect("
																				SELECT id,nationality_th 
																				FROM dcy_master.tbl_nationality 
																				ORDER BY `priority` ASC, friendly_country DESC, nationality_th ASC");
																				if(mysql_num_rows($nationalities) > 0){
																					while($obj = mysql_fetch_object($nationalities)){
																			?>
								                                                <option value="<?=$obj->id?>" <?php if($obj->id==$resultpro['nat_ID']){echo 'selected';} ?>>
								                                                    <?=$obj->nationality_th ?>
								                                                </option>
								                                                <?php 
																			}}
																			?>
								                                        </select>
								                                    </div>
								                                    <!--<div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">���� �к��ѭ�ҵ� :</label>
								                                        <input type="text" name="etc_nat" class="" id="" placeholder="" value="<?=$resultpro['etc_nat'];?>">
								                                    </div>-->
								                                </div>
																<?php
																$date_DB = explode("-", $resultpro['birthday']);
																	$date_DBTHAI = $date_DB['2'].'/'.$date_DB['1'].'/'.($date_DB['0']+543);
																	?>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�Դ�ѹ��� <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="birthday" class="datepicker" id="birthday" placeholder="" value="<?php if($resultpro['birthday'] !=''){ echo $date_DBTHAI; }?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">���� � �ѹ����� <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="age_date" class="" id="age_date" placeholder=""style="width:45px;" value="<?=$resultpro['age_date'];?>">&nbsp;&nbsp;��
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ʶҹ�Ҿ <span style="color:#F00">*</span> :</label>
								                                        <select name="cond_pers_ID" id="cond_pers_ID" class="" style="width:150px;">
								                                            <option value="0">---</option>
								                                            <?php
																				$countArr = count($cond_persons);
																				//print_r($countArr);
																				if($countArr > 0){
																					foreach($cond_persons as $j => $data ){
																			?>
								                                                <option value="<?=$j?>" <?php if($j==$resultpro['cond_pers_ID']){echo 'selected';} ?>>
								                                                    <?=$data ?>
								                                                </option>
								                                                <?php 
																			}	
																		}
																	?>
								                                        </select>
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�������Ҫվ  :</label>
								                                        <select name="career_ID" id="career_ID" class="" style="width:150px;">
								                                            <option value="0">---</option>
								                                            <?php
																				$countArr = count($careers);
																				//print_r($countArr);
																				if($countArr > 0){
																					foreach($careers as $j => $data ){
																			?>
								                                                <option value="<?=$j?>" <?php if($j==$resultpro['career_ID']){echo 'selected';} ?>>
								                                                    <?=$data ?>
								                                                </option>
								                                                <?php 
																			}	
																		}
																	?>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div>
								                                    <label for="" class="labelCenter" style="font-weight: 100;">�������������¹��ҹ</label>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��ҹ�Ţ��� :</label>
								                                        <input type="text" name="h_Number_reg" class="" id="h_Number_reg" placeholder="" style="width: 159.63636350631714px;" value="<?=$resultpro['h_Number_reg'];?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��� :</label>
								                                        <input type="text" name="road_reg" class="" id="" placeholder="" style="width: 185.63636350631714px;"value="<?=$resultpro['road_reg'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�ѧ��Ѵ <span style="color:#F00">*</span> :</label>
								                                        <select name="province_id_reg" id="province_id_reg" class="" OnChange="JavaScript:chgAmphur(this.value);" style="width: 150px; display: inline;">
								                                            <option value="0">--���͡�ѧ��Ѵ--</option>
																			<?php
																			$sql = "SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType = 'Changwat' ORDER BY ccName ";
																			$prov_res = mysql_query($sql) or die("Error Query " .mysql_error());
																			while($prov_row = mysql_fetch_array($prov_res)){
																				if($prov_row['ccDigi']==$resultpro['ccDigi_reg']){
																				$showselected= "selected";
																				}else{
																				$showselected= "";
																				}
																				echo "<option value='".$prov_row['ccDigi']."' ". $showselected ." >".str_replace("�ѧ��Ѵ","",$prov_row['ccName'])." </option>"; $sel = "";
																			}
																			?>
								                                        </select>
								                                    </div>
								                                    <div class="form-group" id="distric_box">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">����� <span style="color:#F00">*</span> :</label>
								                                        <select name="district_id" id="district_id" class="" style="width: 150px; display: inline;">
								                                            <option value="">--���͡�����--</option>
																			<?php   
														                                    
														                                    $lock =  substr($resultpro['ccDigi_reg'], 0, 2);
														                                    $am = mysql_db_query("dcy_oscc","SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Aumpur' AND ccDigi LIKE '".substr($resultpro['ccDigi_reg'],0,2)."%' ");
														                                    while( $ram = mysql_fetch_array($am) ) {
														                                      $slted = ( $ram['ccDigi'] == $resultpro['district_id_reg'] ) ? "selected" : "";
														                                      echo "<option value=\"".$ram['ccDigi']."\" $slted>".$ram['ccName']."</option>\n";
														                                      $slted="";
														                                    }
														                                   ?>
								                                        </select>
								                                    </div>
								                                    <div class="form-group" id="subDistric_box">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�Ӻ� <span style="color:#F00">*</span> :</label>
								                                        <select name="subdistrict_id" id="subdistrict_id" class="" style="width: 150px; display: inline;">
								                                            <option value="">--���͡�Ӻ�--</option>
																			 <?php 
														                                   
														                                      if($resultpro['district_id_reg'] != ""){
														                                        $am = mysql_query("SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Tamboon' AND ccDigi LIKE '".substr($resultpro['district_id_reg'],0,4)."%'  ");
														                                        while( $ram = mysql_fetch_array($am) ) {
														                                          $slted = ( $ram['ccDigi'] == $resultpro['subdistrict_id_reg'] ) ? "selected" : "";
														                                          echo "<option value=\"".$ram['ccDigi']."\" $slted>".$ram['ccName']."</option>\n";
														                                          $slted="";
														                                        }
														                                      }
														                                     ?>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�������Ѿ�� <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="phone_reg" class="" id="phone_reg" placeholder="" value="<?=$resultpro['phone_reg'];?>">
								                                    </div>
								                                </div>
								                                <div>
								                                    <label for="" class="labelCenter" style="font-weight: 100;">�������Ѩ�غѹ</label>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��ҹ�Ţ��� :</label>
								                                        <input type="text" name="h_Number_current" class="" id="h_Number_current" placeholder="" style="width: 159.63636350631714px;" value="<?=$resultpro['h_Number_current']?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��� :</label>
								                                        <input type="text" name="road_current" class="" id="" placeholder="" style="width: 185.63636350631714px;" value="<?=$resultpro['road_current']?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�ѧ��Ѵ <span style="color:#F00">*</span> :</label>
								                                        <select name="province_id_current" id="province_id_current" class="" OnChange="JavaScript:chgAmphurDe(this.value);" style="width: 150px; display: inline;">
								                                            <option value="0">--���͡�ѧ��Ѵ--</option>
																			<?php

																			$sql = "SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType = 'Changwat' ORDER BY ccName ";
																			$prov_res = mysql_query($sql) or die("Error Query " .mysql_error());
																			while($prov_row = mysql_fetch_array($prov_res)){
																				if($prov_row['ccDigi']==$resultpro['ccDigi_current']){
																				$showselected= "selected";
																				}else{
																				$showselected= "";
																				}
																				$sel = "";
																				echo "<option value=\"".$prov_row['ccDigi']."\" $showselected >".str_replace("�ѧ��Ѵ","",$prov_row['ccName'])." </option>"; $sel = "";
																			}
																			?>
								                                        </select>
								                                    </div>
								                                    <div class="form-group" id="distric_box_de">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">����� <span style="color:#F00">*</span> :</label>
								                                        <select name="distric_id_de" id="distric_id_de" class="" style="width: 150px; display: inline;">
								                                            <option value="">--���͡�����--</option>
																			<?php   
														                                    
														                                    $lock =  substr($resultpro['ccDigi_current
																							'], 0, 2);
														                                    $am = mysql_db_query("dcy_oscc","SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Aumpur' AND ccDigi LIKE '".substr($resultpro['ccDigi_current'],0,2)."%' ");
														                                    while( $ram = mysql_fetch_array($am) ) {
														                                      $slted = ( $ram['ccDigi'] == $resultpro['district_id_current'] ) ? "selected" : "";
														                                      echo "<option value=\"".$ram['ccDigi']."\" $slted>".$ram['ccName']."</option>\n";
														                                      $slted="";
														                                    }
														                                   ?>
								                                        </select>
								                                    </div>
								                                    <div class="form-group" id="subDistric_box_de">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�Ӻ� <span style="color:#F00">*</span> :</label>
								                                        <select name="subdistric_id_de" id="subdistric_id_de" class="" style="width: 150px; display: inline;">
								                                            <option value="">--���͡�Ӻ�--</option>
																			<?php 
														                                   
														                                      if($resultpro['district_id_current'] != ""){
														                                        $am = mysql_query("SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType='Tamboon' AND ccDigi LIKE '".substr($resultpro['district_id_current'],0,4)."%'  ");
														                                        while( $ram = mysql_fetch_array($am) ) {
														                                          $slted = ( $ram['ccDigi'] == $resultpro['subdistrict_id_current'] ) ? "selected" : "";
														                                          echo "<option value=\"".$ram['ccDigi']."\" $slted>".$ram['ccName']."</option>\n";
														                                          $slted="";
														                                        }
														                                      }
														                                     ?>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�������Ѿ�� <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="phone_current" class="" id="phone_current" placeholder="" value="<?=$resultpro['phone_current'];?>">
								                                    </div>
								                                </div>
														    </div>
															<!-- ��ͺ���� -->
															<?php
												
														$resultprofile2 = mysql_query("select * from sv_family where user_ID='$iduser' and sv_received_ID='$_GET[id_received]'");
														$resultpro2=mysql_fetch_array($resultprofile2);
														
													?>
														    <div id="view2">
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">����-ʡ�źԴ� <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="name_father" class="" id="name_father" placeholder="" style="width:213px;" value="<?=$resultpro2['name_father'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">����-ʡ����ô� <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="name_mom" class="" id="name_mom" placeholder="" style="width:200px;"value="<?=$resultpro2['name_mom'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
							                                        <label for="" class="labelCenter" style="font-weight: 100;">ʶҹ�Ҿ <span style="color:#F00">*</span> :</label>
								                                        <select name="cond_fam_ID" class="" id="cond_fam_ID" style="width:100px;">
								                                            <option value="0">---</option>
								                                            <?php
																				$countArr = count($cond_families);
																				//print_r($countArr);
																				if($countArr > 0){
																					foreach($cond_families as $j => $data ){
																			?>
								                                                <option value="<?=$j?>" <?php if($j==$resultpro2['cond_fam_ID']){echo 'selected';} ?>>
								                                                    <?=$data ?>
								                                                </option>
								                                                <?php 
																					}	
																				}
																			?>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�պصèӹǹ :</label>
								                                        <span id="sum"><input type="number" name="sum_child" class="" id="sum_child" placeholder="" style="width:50px;" disabled></span>
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��&nbsp;&nbsp;</label>
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�պصê�¨ӹǹ :</label>
								                                        <input type="number" min="0"  name="son" class="numberOnly" id="son" placeholder="" style="width:50px;" onKeyUp="JavaScript:Count();" onChange="JavaScript:ShowDisabled();" value="<?=$resultpro2['son'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��&nbsp;&nbsp;</label>
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�պص�˭ԧ�ӹǹ :</label>
								                                        <input type="number" min="0" name="daughter" class="numberOnly" id="daughter" placeholder="" style="width:50px;" onKeyUp="JavaScript:Count();" onChange="JavaScript:ShowDisabled();" value="<?=$resultpro2['daughter'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��</label>
								                                    </div>
								                                </div>
								                                <div class="form-inline table" id="">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�ӹǹ�ص÷��������֡�� :</label>
								                                        <input type="text" name="studied" class="" id="studied" placeholder="" style="width:100px;" disabled value="<?=$resultpro2['studied'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��&nbsp;&nbsp;</label>
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�ӹǹ�ص÷����ѧ�֡�� :</label>
								                                        <input type="text" name="study" class="" id="study" placeholder="" style="width:100px;" disabled value="<?=$resultpro2['study'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��</label>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�ӹǹ�ص÷��ӧҹ���� :</label>
								                                        <input type="text" name="work" class="" id="work" placeholder="" style="width:120px;" disabled value="<?=$resultpro2['work'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��&nbsp;&nbsp;</label>
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�ӹǹ�ص÷�������ӧҹ���� :</label>
								                                        <input type="text" name="notwork" class="" id="notwork" placeholder="" style="width:120px;" disabled value="<?=$resultpro2['notwork'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��</label>
								                                    </div>
								                                </div>              
														    </div>
															<!-- ��֡�� -->
															<?php
												
														$resultprofile3 = mysql_query("select * from sv_consult where user_ID='$iduser' and sv_received_ID='$_GET[id_received]'");
														$resultpro3=mysql_fetch_array($resultprofile3);

													?>
														    <div id="view3">
								                                <div>
								                                    <label for="" class="labelCenter" style="font-weight: 100;">������ͧ��âͧ������ԡ�� :</label>
								                                </div>
								                                <div>
								                                    <div class="form-group">
								                                        <textarea name="requirements" rows="10" cols="80"><?=$resultpro3['requirements'];?></textarea>
								                                    </div>
								                                </div>
								                                <div>
								                                    <label for="" class="labelCenter" style="font-weight: 100;">�����Դ��繢ͧ�ѡ�ѧ��ʧ������ :</label>
								                                </div>
								                                <div>
								                                    <div class="form-group">
								                                        <textarea name="comment" rows="10" cols="80" ><?=$resultpro3['comment'];?></textarea>
								                                    </div>
								                                </div>
														     </div>
															 <!-- ��������� -->
															 <?php
												
														$resultprofile4 = mysql_query("select * from sv_frafficking where user_ID='$iduser' and sv_received_ID='$_GET[id_received]'");
														$resultpro4=mysql_fetch_array($resultprofile4);

													?>
														      <div id="view4">
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�Թ�ҧ���-�͡������ª�ͧ�ҧ� :</label>
								                                        <input type="text" name="type_travel" class="" id="" placeholder="" value="<?=$resultpro4['type_travel'];?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">�Ըա���Թ�ҧ :</label>
								                                        <select name="way_trav_ID" id="way_trav_ID" class="" style="width:100px;">
								                                            <option value="0">---</option>
								                                            <?php
																			$countArr = count($way_travels);
																			//print_r($countArr);
																			if($countArr > 0){
																				foreach($way_travels as $j => $data ){
																		?>
								                                                <option value="<?=$j?>" <?php if($j==$resultpro4['way_trav_ID']){echo 'selected';}?>>
								                                                    <?=$data ?>
								                                                </option>
								                                                <?php 
																				}	
																			}
																		?>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">����-ʡ�Ţͧ�����������㹡���Թ�ҧ :</label>
								                                        <input type="text" name="name_help" class="" id="" placeholder="" value="<?=$resultpro4['name_help'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" >�١��з���ѡɳТ��㴢��˹�觴ѧ���仹�� :</label>
																		
								                                        <table>
								                                            <tr>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="1"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='1' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> �Ѵ��
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="2"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='2' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ����
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="3"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='3' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ���
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="4"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='4' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ��˹���
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="5"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='5' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ���Ҩҡ
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                            <tr>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="6"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='6' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ����ѧ����
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="7"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='7' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ˹�ǧ�˹����
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="8"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='8' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> �ѡ�ѧ
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="9"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='9' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> �Ѵ������������
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="150">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="action[]" id="action[]" value="10"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_action where user_ID='$iduser' and answer_ID='10' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> �Ѻ���
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                        </table>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter">�����Ը���ѡɳТ��㴢��˹�觴ѧ���仹�� :</label>
								                                        <table>
								                                            <tr>
								                                                <td width="250">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="method[]" id="method[]" value="1"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_method where user_ID='$iduser' and answer_ID='1' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ������
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="250">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="method[]" id="method[]" value="2"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_method where user_ID='$iduser' and answer_ID='2' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ����ѧ�ѧ�Ѻ
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="250">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="method[]" id="method[]" value="3"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_method where user_ID='$iduser' and answer_ID='3' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> �ѡ�ҵ��
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                            <tr>
								                                                <td width="250">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="method[]" id="method[]" value="4"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_method where user_ID='$iduser' and answer_ID='4' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ��ͩ�
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="250">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="method[]" id="method[]" value="5"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_method where user_ID='$iduser' and answer_ID='5' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ��͡�ǧ
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="250">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="method[]" id="method[]" value="6"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_method where user_ID='$iduser' and answer_ID='6' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ���ӹҨ���Ԫͺ
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                            <tr>
								                                                <td colspan="3">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="method[]" id="method[]" value="7"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_method where user_ID='$iduser' and answer_ID='7' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ������Թ���ͼŻ���ª�����ҧ������黡��ͧ���ͼ�������������黡��ͧ���ͼ������������Թ��������зӤ����Դ㹡����ǧ�ҼŻ���ª��ҡ�ؤ�ŷ�赹����
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                        </table>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter">�����ѵ�ػ��ʧ����㴢��˹�觴ѧ���仹�� :</label>
								                                        <table>
								                                            <tr>
								                                                <td width="350">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="objective[]" id="objective[]" value="1"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_objective where user_ID='$iduser' and answer_ID='1' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> �����ǧ�ҼŻ���ª��ҡ��ä�һ���ǳ�
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="350">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="objective[]" id="objective[]" value="2"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_objective where user_ID='$iduser' and answer_ID='2' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> 
								                                                            ��ü�Ե����������ѵ��������������
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                            <tr>
								                                                <td width="350">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="objective[]" id="objective[]" value="3"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_objective where user_ID='$iduser' and answer_ID='3' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> �����ǧ�ҼŻ���ª��ҧ����ٻẺ���
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="350">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="objective[]" id="objective[]" value="4"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_objective where user_ID='$iduser' and answer_ID='4' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ������ŧ�繷��
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                            <tr>
								                                                <td width="350">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="objective[]" id="objective[]" value="5"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_objective where user_ID='$iduser' and answer_ID='5' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ��ù��Ңͷҹ
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="350">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="objective[]" id="objective[]" value="6"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_objective where user_ID='$iduser' and answer_ID='6' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ��úѧ�Ѻ���ç�ҹ���ͺ�ԡ��
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                            <tr>
								                                                <td width="350">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="objective[]" id="objective[]" value="7"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_objective where user_ID='$iduser' and answer_ID='7' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ��úѧ�Ѻ�Ѵ���������͡�ä��
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                                <td width="350">
								                                                    <div class="checkbox">
								                                                        <label style="font-size: 12px;">
								                                                            <input type="checkbox" name="objective[]" id="objective[]" value="8"<?php
																		$resultprofile4 = mysql_query("select count(*) as count from sv_trafficking_objective where user_ID='$iduser' and answer_ID='8' and sv_received_ID='$_GET[id_received]'");
																		$resultpro4=mysql_fetch_array($resultprofile4);
																		if(1==$resultpro4['count']){
																		echo 'checked';
																		}
																		?>> ������㴷�����¤�֧�ѹ�ѹ�繡�âٴ�մ�ؤ��
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                        </table>
								                                    </div>
								                                </div>
																<?php
																$resultprofile5 = mysql_query("select * from sv_frafficking where user_ID='$iduser' and sv_received_ID='$_GET[id_received]'");
														$resultpro5=mysql_fetch_array($resultprofile5);
																		?>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">��ػ������� :</label>
								                                        <select name="trade_opin_ID" class="" style="width:300px;">
								                                            <option value="0">---</option>
								                                            <?php
																			$countArr = count($trade_opinion);
																			print_r($countArr);
																			if($countArr > 0){
																				foreach($trade_opinion as $j => $data ){
																		?>
								                                                <option value="<?=$j?>" <?php if($j==$resultpro5['trade_opin_ID']){echo 'selected';}?>>
								                                                    <?=$data ?>
								                                                </option>
								                                                <?php 
																				}	
																			}
																		?>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div>
								                                    <label for="" class="labelCenter" style="font-weight: 100;">���վĵԡ��� ��� :</label>
								                                </div>
								                                <div>
								                                    <div class="form-group">
								                                        <textarea name="behavior" rows="6" cols="80"><?=$resultpro5['behavior'];?></textarea>
								                                    </div>
								                                </div>
														     </div>
													 	</div>
									             
													</div>
													</form>
												
													<?php
													   }
													?>
													<form action="" method="post" name="form_cancal" id="form_cancal">
														<input type="hidden" value="cancal" name="cancal">
													</form>
													
					                            </td>
					                        </tr>
					                    </table>
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
	         @include("../../common/oscc_js/menu.js");
	         ?>
		</script>
        		<script>
$(document).ready(function(){

$('#name').keyup(function(){
var pname_ID = $('#pname_ID').val();
if(pname_ID==0){
alert('��س����͡�ӹ�˹�Ҫ���');
}else{
}

});

	//��͹���� ������
$('#etc_n1').hide();
	$('#type_subsc_ID').change(function(){
		var type_subsc_ID =$(this).val();
		if(type_subsc_ID==8){
		$('#etc_n1').show();

		}else{
		$('#etc_n1').hide();
		}
	});


	$('#pname_ID').change(function(){
	var pname_ID = $(this).val();
if(pname_ID==0){
alert('��س����͡�ӹ�˹�Ҫ���');
}else{
}
	});

			 });
var flag = 0;
var register_click_id = 0;
function showMenu(service_id,id_received,user_id){
if(flag == 0 || register_click_id != service_id+'_'+id_received){
	$('#menuList'+register_click_id).hide();
	$.ajax({
		type: "GET",
		url: "ajax_menuSetting.php?service_id="+service_id+"&id_received="+id_received+"&user_id="+user_id,
		success: function(data){
			data = $.trim(data);
			$('#menuList'+service_id+'_'+id_received).empty().append(data);
			$('#menuList'+service_id+'_'+id_received).hide();
			
			$('#menuList'+service_id+'_'+id_received).show('fast');
			flag = 1;
			register_click_id = service_id+'_'+id_received;
		}
	});
}else if(register_click_id == service_id+'_'+id_received){
	$('#menuList'+service_id+'_'+id_received).hide();
	flag = 0;
}
}
</script>

	</body>
</html>