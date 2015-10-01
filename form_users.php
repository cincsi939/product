<?php
if($_GET['id_received']!=''){
$subject_ID = $_GET['id_received'];
}else{
	 header("Location: index.php");
                        exit;

}
/**
 * @comment ฟอร์มหน้าการบันทึกข้อมูล ผู้ใช้บริการ?
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

//ดึงแถบแสดง
require_once("../../common/SMLcore/SMLcoreBack.php");
include("../../config/config.inc.php");
// include("../../config/selectDB_oscc.php");
include('library.php');
require_once('../../config/define_var.php');
//ดึงข้อมูล ตารางคำนำหน้าชื่อ
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
//ดึงข้อมูล ตารางประเภทผู้ขอบริการ
$type_subscribers = fncSelectData('type_subscribers','subscriber','type_subsc_ID');
//ดึงข้อมูล ตารางศาสนา
$religions = fncSelectData('religions','religion','religion_ID');
//ดึงข้อมูล ตารางเชื้อชาติ สัญชาติ
$nationalities = fncSelect("
SELECT id,nationality_th FROM dcy_master.tbl_nationality ORDER BY `priority` ASC, friendly_country DESC, nationality_th ASC");
//ดึงข้อมูล ตารางสถานภาพ
$cond_persons = fncSelectData('cond_persons','condpers','cond_pers_ID');
//ดึงข้อมูล ตารางอาชีพ
$careers = fncSelectData('careers','career','career_ID');
//ดึงข้อมูล ตารางสถานภาพครอบครัว
$cond_families = fncSelectData('cond_families','physcondfam','cond_fam_ID');
//ดึงข้อมูล ตารางวิธีการเดินทาง
$way_travels = fncSelectData('way_travels','travel','way_trav_ID');
//ดึงข้อมูล ตารางความเห็นเข้าข่ายการค้ามนุษย์
$trade_opinion = fncSelectData('trade_opinion','opintrade','trade_opin_ID');
//ดึงข้อมูล ตารางข้อมูลรับเรื่อง
$received = fncSelectData('sv_received','Officer_ID','sv_received_ID');

	foreach ($received as $key => $value) {
	}
$idKey = $key;

//ดุงข้อมูล ตารางข้อมูลผู้ใช้บริการ
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
		<!-- วันที่ -->
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
        <title>รับเรื่องราวร้องทุกข์</title>
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
		
		//แปลง คริสตศักราช เป็น พุทธศักราช
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
		//เลือกจังหวัด ที่อยู่ตามทะเบียนบ้าน
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
		//เลือกจังหวัด ที่อยู่ปัจจุบัน
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
		//ตรวจสอบ อักษรพิเศษ
	    function check_specail_cha(text){
	   		var  special_cha = /([.*+?^=!:@${}()|\[\]\\])/g ;
	   		return special_cha.test(text);
	    }
		//ตรวจสอบ เบอร์โทร 10  ตัว
		function isPhoneNo(input){
			var regExp = /^0[0-9]{8,9}$/i;
			return regExp.test(input);
		}
		//ตรวจสอบ เลขบัตร 13 หลัก
		function checkID(id){
			if(id.length != 13) return false;
			for(i=0, sum=0; i < 12; i++)
				sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
				return false; return true;
		}
		
		//ตรวจสอบ form 
		function chkfrom(){
			//ตรวจสอบช่อง คำนำหน้าชื่อ
			if(form1.pname_ID.value == '0'){
				alert('ระบุคำนำหน้าชื่อ');
				form1.pname_ID.focus();
				return false;
			}
			// ตรวจสอบช่อง input ชื่อ
			if(form1.name.value == ''){
				alert('ระบุชื่อ');
				form1.name.focus();
				return false;
			}
			if(form1.name.value != ''){
				if(check_specail_cha(form1.name.value)){
					alert('ตรวจสอบชื่อ');
					return false;
				}
			}
			// ตรวจสอบช่อง input นามสกุล
			if(form1.s_name.value == ''){
				alert('ระบุนามสกุล');
				form1.s_name.focus();
				return false;
			}
			if(form1.s_name.value != ''){
				if(check_specail_cha(form1.s_name.value)){
					alert('ตรวจสอบนามสกุล');
					return false;
				}
			}
			// ตรวจสอบช่อง input ตำหนิ รูปพรรณ หรือลักษณะลักษณะพิเศษ
			if(form1.special.value == ''){
				alert('ระบุตำหนิ รูปพรรณ หรือลักษณะลักษณะพิเศษ');
				form1.special.focus();
				return false;
			}
			if(form1.special.value != ''){
				if(check_specail_cha(form1.special.value)){
					alert('ตรวจสอบอักษร');
					return false;
				}
			}
			//ตรวจสอบช่อง เพศ
			if(form1.sex.value == '0'){
				alert('ระบุเพศ');
				form1.sex.focus();
				return false;
			}
			//ตรวจสอบช่อง ประเภทผู้ใช้บริการ
			if(form1.type_subsc_ID.value == '0'){
				alert('ระบุประเภทผู้ใช้บริการ');
				form1.type_subsc_ID.focus();
				return false;
			}
			//ตรวจสอบช่อง input เลขที่บัตรประชาชน
			if(form1.idcard.value == ''){
				alert('ระบุเลขที่บัตรประชาชน');
				form1.idcard.focus();
				return false;
			}
 		   if ( form1.idcard.value.length != 13)
 		   {
 		      alert('กรอกหมายเลขที่บัตรประชาชน 13 หลัก');
 		      return false;
 		   }
			if(!checkID(document.form1.idcard.value)){
				alert('รหัสประชาชนไม่ถูกต้อง');
				form1.idcard.focus();
				return false;
			}
			//ตรวจสอบช่อง input หมายเลขหนังสือเดินทาง
			/*if(form1.passport.value == ''){
				alert('ระบุหมายเลขหนังสือเดินทาง');
				form1.passport.focus();
				return false;
			}*/
			//ตรวจสอบช่อง input ศาสนา
			if(form1.religion_ID.value == '0'){
				alert('ระบุศาสนา');
				form1.religion_ID.focus();
				return false;
			}
			//ตรวจสอบช่อง input เชื้อชาติ
			if(form1.nat_ID.value == '0'){
				alert('ระบุเชื้อชาติ');
				form1.nat_ID.focus();
				return false;
			}
			//ตรวจสอบช่อง input สัญชาติ
			if(form1.race_ID.value == '0'){
				alert('ระบุสัญชาติ');
				form1.race_ID.focus();
				return false;
			}
			//ตรวจสอบช่อง input เกิดวันที่
			if(form1.birthday.value == ''){
				alert('ระบุเกิดวันที่');
				form1.birthday.focus();
				return false;
			}
			//ตรวจสอบช่อง input อายุ ณ วันที่แจ้ง
			if(form1.age_date.value == ''){
				alert('ระบุอายุ ณ วันที่แจ้ง');
				form1.age_date.focus();
				return false;
			}
			if(form1.age_date.value != ''){
				if(check_specail_cha(form1.age_date.value)){
					alert('กรุณากรอกเป็นตัวเลข');
					form1.age_date.focus();
					return false;
				}
			}
			if(isNaN(document.form1.age_date.value)) {
				alert('กรุณากรอกเป็นตัวเลข');
			    document.form1.age_date.focus();
			    return false;
			}
			//ตรวจสอบช่อง input สถานภาพ
			if(form1.cond_pers_ID.value == '0'){
				alert('ระบุสถานภาพ');
				form1.cond_pers_ID.focus();
				return false;
			}
			//ตรวจสอบช่อง input ประเภทอาชีพ
			/*if(form1.career_ID.value == '0'){
				alert('ระบุประเภทอาชีพ');
				form1.career_ID.focus();
				return false;
			}*/
			// ตรวจสอบช่อง input บ้านเลขที่ ตามทะเบียนบ้าน
			// if(form1.h_Number_reg.value == ''){
// 				alert('ระบุบ้านเลขที่ตามทะเบียนบ้าน');
// 				form1.h_Number_reg.focus();
// 				return false;
// 			}
			if(form1.h_Number_reg.value != ''){
				if(check_specail_cha(form1.h_Number_reg.value)){
					alert('ตรวจสอบบ้านเลขที่ตามทะเบียนบ้าน');
					return false;
				}
			}
			if(isNaN(document.form1.h_Number_reg.value)) {
			        alert('กรุณากรอกที่อยู่ตามทะเบียนบ้านเป็นตัวเลข');
			        document.form1.h_Number_reg.focus();
			        return false;
			}

			//ตรวจสอบช่อง จังหวัด ที่อยู่ตามทะเบียนบ้าน
			if(form1.province_id_reg.value == '0'){
				alert('ระบุจังหวัด');
				form1.province_id_reg.focus();
				return false;
			}
			//ตรวจสอบช่อง input เบอร์โทรศัพท์ ที่อยู่ตามทะเบียนบ้าน
			if(form1.phone_reg.value == ''){
				alert('ระบุเบอร์โทรศัพท์ที่อยู่ตามทะเบียนบ้าน');
				form1.phone_reg.focus();
				return false;
			}
		   /*if ( form1.phone_reg.value.length != 10)
		   {
		      alert('กรอกหมายเลขโทรศัพท์ 10 หลัก');
			  form1.phone_reg.focus();
		      return false;
		   }

		   for (i = 0; i < form1.phone_reg.value.length; i++ ) {
		      if ( form1.phone_reg.value.charCodeAt(i) < 48 || form1.phone_reg.value.charCodeAt(i) > 57 ) {
		         alert('กรุณากรอกเบอร์โทรศัพท์เป็นตัวเลข');
				 form1.phone_reg.focus();
		         return false;
		      } else {

		         if ( ((i == 0) && (form1.phone_reg.value.charCodeAt(i) != 48)) || ((i == 1) && (form1.phone_reg.value.charCodeAt(i) != 56)) )
		         {
		            alert('กรุณากรอกเบอร์โทรศัพท์เป็นตัวเลข');
					form1.phone_reg.focus();
		            return false;
		         }
		      }
		   }*/
			// ตรวจสอบช่อง input บ้านเลขที่ ปัจจุบัน
			// if(form1.h_Number_current.value == ''){
// 				alert('ระบุบ้านเลขที่ปัจจุบัน');
// 				form1.h_Number_current.focus();
// 				return false;
// 			}
			if(form1.h_Number_current.value != ''){
				if(check_specail_cha(form1.h_Number_current.value)){
					alert('ตรวจสอบบ้านเลขที่ปัจจุบัน');
					return false;
				}
			}
			if(isNaN(document.form1.h_Number_current.value)) {
			        alert('กรุณากรอกบ้านเลขที่อยู่ปัจจุบันเป็นตัวเลข');
			        document.form1.h_Number_current.focus();
			        return false;
			}

			//ตรวจสอบช่อง จังหวัด ที่อยู่ปัจจุบัน
			if(form1.province_id_current.value == '0'){
				alert('ระบุจังหวัด');
				form1.province_id_current.focus();
				return false;
			}

		//ตรวจสอบช่อง input เบอร์โทรศัพท์ ที่อยู่ปัจจุบัน
		if(form1.phone_current.value == ''){
			alert('ระบุเบอร์โทรศัพท์ที่อยู่ปัจจุบัน');
			form1.phone_current.focus();
			return false;
		}
	  /* if ( form1.phone_current.value.length != 10)
	   {
	      alert('กรอกหมายเลขโทรศัพท์ 10 หลัก');
		  form1.phone_current.focus();
	      return false;
	   }

	   for (i = 0; i < form1.phone_current.value.length; i++ ) {
	      if ( form1.phone_current.value.charCodeAt(i) < 48 || form1.phone_current.value.charCodeAt(i) > 57 ) {
	         alert('กรุณากรอกเบอร์โทรศัพท์เป็นตัวเลข');
			 form1.phone_current.focus();
	         return false;
	      } else {

	         if ( ((i == 0) && (form1.phone_current.value.charCodeAt(i) != 48)) || ((i == 1) && (form1.phone_current.value.charCodeAt(i) != 56)) )
	         {
	            alert('กรุณากรอกเบอร์โทรศัพท์เป็นตัวเลข');
				form1.phone_current.focus();
	            return false;
	         }
	      }
	   }*/

	// ตรวจสอบช่อง input ชื่อ-สกุลบิดา
	if(form1.name_father.value == ''){
		alert('ระบุชื่อ-สกุลบิดา');
		form1.name_father.focus();
		return false;
	}
	if(!(isNaN(document.form1.name_father.value))) {
		alert("กรอกเป็นตัวอักษร") ;
		document.form1.name_father.focus() ;
		return false ;
	}
	// ตรวจสอบช่อง input ชื่อ-สกุลมารดา
	if(form1.name_mom.value == ''){
		alert('ระบุชื่อ-สกุลมารดา');
		form1.name_mom.focus();
		return false;
	}
	if(!(isNaN(document.form1.name_mom.value))) {
		alert("กรอกเป็นตัวอักษร") ;
		document.form1.name_mom.focus() ;
		return false ;
	}
	//ตรวจสอบช่อง ครอบครัว  สถานภาพ
	if(form1.cond_fam_ID.value == '0'){
		alert('สถานภาพครอบครัว');
		form1.cond_fam_ID.focus();
		return false;
	}
	//ตรวจสอบช่อง จำนวนบุตรที่ไม่ได้ศึกษา เป็นตัวเลขหรือไหม
	if(isNaN(document.form1.studied.value)) {
		alert('กรุณากรอกเป็นตัวเลข');
       document.form1.studied.focus();
       return false;
   	}
	//ตรวจสอบช่อง จำนวนบุตรที่กำลังศึกษา เป็นตัวเลขหรือไหม
	if(isNaN(document.form1.study.value)) {
		alert('กรุณากรอกเป็นตัวเลข');
       document.form1.study.focus();
       return false;
   	}
	//ตรวจสอบช่อง จำนวนบุตรที่ทำงานแล้ว เป็นตัวเลขหรือไหม
	if(isNaN(document.form1.work.value)) {
		alert('กรุณากรอกเป็นตัวเลข');
       document.form1.work.focus();
       return false;
   	}
	//ตรวจสอบช่อง จำนวนบุตรที่ไม่ได้ทำงานแล้ว เป็นตัวเลขหรือไหม
	if(isNaN(document.form1.notwork.value)) {
		alert('กรุณากรอกเป็นตัวเลข');
       document.form1.notwork.focus();
       return false;
   	}
	//ตรวจสอบช่อง วิธีการเดินทาง
	// if(form1.way_trav_ID.value == '0'){
// 		alert('ระบุวิธีการเดินทาง');
// 		form1.way_trav_ID.focus();
// 		return false;
// 	}
	   //ตรวจสอบการ checkbox ถูกกระทำ
	   	// var a=new Array();
	//    	a=document.getElementsByName("action[]");
	//    	//alert("Length:"+a.length); // แสดงค่าจำนวน Checkbox ที่มีทั้งหมดในแบบฟอร์ม
	//    	var p=0;
	//    	for(i=0;i<a.length;i++){
	//    		if(a[i].checked){
	//    			//alert(a[i].value); // แสดงค่าที่ถูกเลือกไว้
	//    			p=1;
	//    		}
	//    	}
	//    	if (p==0){
	//    		alert('โปรดคลิกเลือก  การถูกกระทำในลักษณะข้อใดข้อหนึ่ง  !!');
	//    		return false;
	//    	}


		//ตรวจสอบการ checkbox โดยใช้วิธีในลักษณะ
	   	// var b=new Array();
// 	   	b=document.getElementsByName("method[]");
// 	   	//alert("Length:"+a.length); // แสดงค่าจำนวน Checkbox ที่มีทั้งหมดในแบบฟอร์ม
// 	   	var k=0;
// 	   	for(j=0;j<b.length;j++){
// 	   		if(b[j].checked){
// 	   			//alert(a[i].value); // แสดงค่าที่ถูกเลือกไว้
// 	   			k=1;
// 	   		}
// 	   	}
// 	   	if (k==0){
// 	   		alert('โปรดคลิกเลือก การใช้วิธีในลักษณะข้อใดข้อหนึ่ง การถูกกระทำในลักษณะข้อใดข้อหนึ่ง !!');
// 	   		return false;
// 	   	}

		//ตรวจสอบการ checkbox โดยใช้วิธีในลักษณะ
	   	// var c=new Array();
// 	   	c=document.getElementsByName("objective[]");
// 	   	//alert("Length:"+a.length); // แสดงค่าจำนวน Checkbox ที่มีทั้งหมดในแบบฟอร์ม
// 	   	var h=0;
// 	   	for(n=0;n<c.length;n++){
// 	   		if(c[n].checked){
// 	   			//alert(a[i].value); // แสดงค่าที่ถูกเลือกไว้
// 	   			h=1;
// 	   		}
// 	   	}
// 	   	if (h==0){
// 	   		alert('โปรดคลิกเลือก วัตถุประสงค์ข้อใดข้อหนึ่ง !!');
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
					alert("กรุณากรอกข้อมูลจำนวนบุตรหญิงเป็นตัวเลข") ;
					document.form1.daughter.focus() ;
					return false ;
				}
				if(isNaN(document.form1.son.value)) {
					alert("กรุณากรอกข้อมูลจำนวนบุตรชายเป็นตัวเลข") ;
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
alert('บุตรเกินจำนวน');
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
alert('บุตรเกินจำนวน');
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
alert('บุตรเกินจำนวน');
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
alert('บุตรเกินจำนวน');
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
										<!--เพิ่มแถบแสดงเลขที่รับแจ้ง เรื่อง ชื่อ วันที่-->
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
																<label for="" class="labelCenter">เรื่องรับแจ้ง :</label><span>&nbsp;<?=$rsReceived['titleEvent']?>&nbsp;&nbsp;&nbsp;</span>
																<?php
																$sql_Pre = "SELECT `dcy_master`.`tbl_prename`.*,`sv_received`.pname_ID FROM `dcy_master`.`tbl_prename`,`sv_received` WHERE sv_received.sv_received_ID = '".$_GET['id_received']."' AND sv_received.pname_ID = tbl_prename.id ";
																$queryPre = mysql_query($sql_Pre) or die("Error Query " .mysql_error());
																$rsPre = mysql_fetch_assoc($queryPre);
																?>
																<label for="" class="labelCenter">ชื่อผู้แจ้ง :</label><span>&nbsp;<?=$rsPre['prename_th']?><?=$rsReceived['name']?>&nbsp;<?=$rsReceived['s_name']?>&nbsp;&nbsp;&nbsp;</span>
																<label for="" class="labelCenter">วันที่รับแจ้งเหตุ :</label><span>&nbsp;<?=$DateReceived?>&nbsp;&nbsp;&nbsp;</span>
															</tr>
															<!--เพิ่มแถบแสดงเลขที่รับแจ้ง เรื่อง ชื่อ วันที่-->
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
														   echo '<font color="#FF0000"><strong>ไม่สามารถเพิ่ม ลบ หรือแก้ไข ผู้ใช้บริการได้ </strong></font>';
													   }else{
															
													?>
													<form action="<?php echo $url; ?>" method="post" name="form1" onSubmit="return chkfrom();">
										                <div class="navDiv">
															<div class="form-inline" align="right">
																<div class="form-group">
							                                        <button type="submit" name="submitFrafficking" class="btn btn-default" aria-label="Left Align" style="margin-top: 0px;">
							                                            บันทึก
							                                        </button>
																	<?php
																	if($_REQUEST["cancal"] == "cancal"){

																		echo "<script>window.location='form_users.php?id_received='".$_GET['id_received']."' ';</script>";

																	}
																	?>
												                    <button type="reset" name="cancelApproval" class="btn btn-default" aria-label="Left Align" style="margin-top: 0px;" onclick="javascript:return cancal();">
												                        ยกเลิก
												                    </button>
																</div>
															</div>   
										                	
										                </div>
									                <div class="col-md-3 " style="padding-left: 0px;">
														<table>
															<tr>
																<td style="width: 102px;">ผู้ใช้บริการ<td>
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
															<li ><a href="#view1" style="display:inline">ข้อมูลส่วนตัว</a></li>
														    <li ><a href="#view2" style="display:inline">ครอบครัว</a></li>
														    <li ><a href="#view3" style="display:inline">การให้คำปรึกษา</a></li>
															<li ><a href="#view4" style="display:inline">ค้ามนุษย์</a></li>
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
																<!-- ข้อมูลส่วนตัว -->
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ชื่อ <span style="color:#F00">*</span> :</label>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">นามสกุล <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="s_name" class="" id="s_name" placeholder="" style="width: 147.63636350631714px;"value="<?=$resultpro['s_name'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ตำหนิ รูปพรรณ หรือลักษณะลักษณะพิเศษ <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="special" class="" id="special" placeholder=""value="<?=$resultpro['special'];?>">
								                                    </div>
								                                    <div class="form-group">
                                                                    	<div style="position:absolute; width:100%; height:20px;" id="sexSelect"></div>
								                                        <label for="" class="labelCenter" style="font-weight: 100;">เพศ <span style="color:#F00">*</span> :</label>
								                                        <select name="sex" id="sex" class="" value="0">
																			<option value="0" <?php if(0==$resultpro['sex']){echo 'selected';}?>>---</option>
								                                            <option value="M" <?php if('M'==$resultpro['sex']){echo 'selected';}?>>ชาย</option>
								                                            <option value="F" <?php if('F'==$resultpro['sex']){echo 'selected';}?>>หญิง</option>
								                                        </select>
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ประเภทผู้ใช้บริการ <span style="color:#F00">*</span> :</label>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ระบุ :</label>
								                                        <input type="text" name="specify" class="" id="specify" placeholder="" value="<?=$resultpro['specify'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">เลขบัตรประจำตัวประชาชน <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="idcard" class="" id="idcard" placeholder="" style="width: 150.63636350631714px;" value="<?=$resultpro['idcard'];?>">
																		
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">หมายเลขหนังสือเดินทาง<span style="color: #F00"> </span>:</label>
								                                        <input type="text" name="passport" class="" id="passport" placeholder="" value="<?=$resultpro['passport'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">เอกสารประจำตัวอื่นๆ :</label>
								                                        <input type="text" name="other_doc" class="" id="" placeholder="" style="width: 154.63636350631714px;" value="<?=$resultpro['other_doc'];?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ศาสนา <span style="color:#F00">*</span> :</label>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">เชื้อชาติ <span style="color:#F00">*</span> :</label>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">สัญชาติ <span style="color:#F00">*</span> :</label>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">อื่นๆ ระบุสัญชาติ :</label>
								                                        <input type="text" name="etc_nat" class="" id="" placeholder="" value="<?=$resultpro['etc_nat'];?>">
								                                    </div>-->
								                                </div>
																<?php
																$date_DB = explode("-", $resultpro['birthday']);
																	$date_DBTHAI = $date_DB['2'].'/'.$date_DB['1'].'/'.($date_DB['0']+543);
																	?>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">เกิดวันที่ <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="birthday" class="datepicker" id="birthday" placeholder="" value="<?php if($resultpro['birthday'] !=''){ echo $date_DBTHAI; }?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">อายุ ณ วันที่แจ้ง <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="age_date" class="" id="age_date" placeholder=""style="width:45px;" value="<?=$resultpro['age_date'];?>">&nbsp;&nbsp;ปี
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">สถานภาพ <span style="color:#F00">*</span> :</label>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ประเภทอาชีพ  :</label>
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
								                                    <label for="" class="labelCenter" style="font-weight: 100;">ที่อยู่ตามทะเบียนบ้าน</label>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">บ้านเลขที่ :</label>
								                                        <input type="text" name="h_Number_reg" class="" id="h_Number_reg" placeholder="" style="width: 159.63636350631714px;" value="<?=$resultpro['h_Number_reg'];?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ถนน :</label>
								                                        <input type="text" name="road_reg" class="" id="" placeholder="" style="width: 185.63636350631714px;"value="<?=$resultpro['road_reg'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">จังหวัด <span style="color:#F00">*</span> :</label>
								                                        <select name="province_id_reg" id="province_id_reg" class="" OnChange="JavaScript:chgAmphur(this.value);" style="width: 150px; display: inline;">
								                                            <option value="0">--เลือกจังหวัด--</option>
																			<?php
																			$sql = "SELECT ccDigi,ccName,ccType FROM ccaa WHERE ccType = 'Changwat' ORDER BY ccName ";
																			$prov_res = mysql_query($sql) or die("Error Query " .mysql_error());
																			while($prov_row = mysql_fetch_array($prov_res)){
																				if($prov_row['ccDigi']==$resultpro['ccDigi_reg']){
																				$showselected= "selected";
																				}else{
																				$showselected= "";
																				}
																				echo "<option value='".$prov_row['ccDigi']."' ". $showselected ." >".str_replace("จังหวัด","",$prov_row['ccName'])." </option>"; $sel = "";
																			}
																			?>
								                                        </select>
								                                    </div>
								                                    <div class="form-group" id="distric_box">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">อำเภอ <span style="color:#F00">*</span> :</label>
								                                        <select name="district_id" id="district_id" class="" style="width: 150px; display: inline;">
								                                            <option value="">--เลือกอำเภอ--</option>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ตำบล <span style="color:#F00">*</span> :</label>
								                                        <select name="subdistrict_id" id="subdistrict_id" class="" style="width: 150px; display: inline;">
								                                            <option value="">--เลือกตำบล--</option>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">เบอร์โทรศัพท์ <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="phone_reg" class="" id="phone_reg" placeholder="" value="<?=$resultpro['phone_reg'];?>">
								                                    </div>
								                                </div>
								                                <div>
								                                    <label for="" class="labelCenter" style="font-weight: 100;">ที่อยู่ปัจจุบัน</label>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">บ้านเลขที่ :</label>
								                                        <input type="text" name="h_Number_current" class="" id="h_Number_current" placeholder="" style="width: 159.63636350631714px;" value="<?=$resultpro['h_Number_current']?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ถนน :</label>
								                                        <input type="text" name="road_current" class="" id="" placeholder="" style="width: 185.63636350631714px;" value="<?=$resultpro['road_current']?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">จังหวัด <span style="color:#F00">*</span> :</label>
								                                        <select name="province_id_current" id="province_id_current" class="" OnChange="JavaScript:chgAmphurDe(this.value);" style="width: 150px; display: inline;">
								                                            <option value="0">--เลือกจังหวัด--</option>
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
																				echo "<option value=\"".$prov_row['ccDigi']."\" $showselected >".str_replace("จังหวัด","",$prov_row['ccName'])." </option>"; $sel = "";
																			}
																			?>
								                                        </select>
								                                    </div>
								                                    <div class="form-group" id="distric_box_de">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">อำเภอ <span style="color:#F00">*</span> :</label>
								                                        <select name="distric_id_de" id="distric_id_de" class="" style="width: 150px; display: inline;">
								                                            <option value="">--เลือกอำเภอ--</option>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ตำบล <span style="color:#F00">*</span> :</label>
								                                        <select name="subdistric_id_de" id="subdistric_id_de" class="" style="width: 150px; display: inline;">
								                                            <option value="">--เลือกตำบล--</option>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">เบอร์โทรศัพท์ <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="phone_current" class="" id="phone_current" placeholder="" value="<?=$resultpro['phone_current'];?>">
								                                    </div>
								                                </div>
														    </div>
															<!-- ครอบครัว -->
															<?php
												
														$resultprofile2 = mysql_query("select * from sv_family where user_ID='$iduser' and sv_received_ID='$_GET[id_received]'");
														$resultpro2=mysql_fetch_array($resultprofile2);
														
													?>
														    <div id="view2">
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ชื่อ-สกุลบิดา <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="name_father" class="" id="name_father" placeholder="" style="width:213px;" value="<?=$resultpro2['name_father'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ชื่อ-สกุลมารดา <span style="color:#F00">*</span> :</label>
								                                        <input type="text" name="name_mom" class="" id="name_mom" placeholder="" style="width:200px;"value="<?=$resultpro2['name_mom'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
							                                        <label for="" class="labelCenter" style="font-weight: 100;">สถานภาพ <span style="color:#F00">*</span> :</label>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">มีบุตรจำนวน :</label>
								                                        <span id="sum"><input type="number" name="sum_child" class="" id="sum_child" placeholder="" style="width:50px;" disabled></span>
								                                        <label for="" class="labelCenter" style="font-weight: 100;">คน&nbsp;&nbsp;</label>
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">มีบุตรชายจำนวน :</label>
								                                        <input type="number" min="0"  name="son" class="numberOnly" id="son" placeholder="" style="width:50px;" onKeyUp="JavaScript:Count();" onChange="JavaScript:ShowDisabled();" value="<?=$resultpro2['son'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">คน&nbsp;&nbsp;</label>
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">มีบุตรหญิงจำนวน :</label>
								                                        <input type="number" min="0" name="daughter" class="numberOnly" id="daughter" placeholder="" style="width:50px;" onKeyUp="JavaScript:Count();" onChange="JavaScript:ShowDisabled();" value="<?=$resultpro2['daughter'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">คน</label>
								                                    </div>
								                                </div>
								                                <div class="form-inline table" id="">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">จำนวนบุตรที่ไม่ได้ศึกษา :</label>
								                                        <input type="text" name="studied" class="" id="studied" placeholder="" style="width:100px;" disabled value="<?=$resultpro2['studied'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">คน&nbsp;&nbsp;</label>
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">จำนวนบุตรที่กำลังศึกษา :</label>
								                                        <input type="text" name="study" class="" id="study" placeholder="" style="width:100px;" disabled value="<?=$resultpro2['study'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">คน</label>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">จำนวนบุตรที่ทำงานแล้ว :</label>
								                                        <input type="text" name="work" class="" id="work" placeholder="" style="width:120px;" disabled value="<?=$resultpro2['work'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">คน&nbsp;&nbsp;</label>
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">จำนวนบุตรที่ไม่ได้ทำงานแล้ว :</label>
								                                        <input type="text" name="notwork" class="" id="notwork" placeholder="" style="width:120px;" disabled value="<?=$resultpro2['notwork'];?>">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">คน</label>
								                                    </div>
								                                </div>              
														    </div>
															<!-- ปรึกษา -->
															<?php
												
														$resultprofile3 = mysql_query("select * from sv_consult where user_ID='$iduser' and sv_received_ID='$_GET[id_received]'");
														$resultpro3=mysql_fetch_array($resultprofile3);

													?>
														    <div id="view3">
								                                <div>
								                                    <label for="" class="labelCenter" style="font-weight: 100;">ความต้องการของผู้ใช้บริการ :</label>
								                                </div>
								                                <div>
								                                    <div class="form-group">
								                                        <textarea name="requirements" rows="10" cols="80"><?=$resultpro3['requirements'];?></textarea>
								                                    </div>
								                                </div>
								                                <div>
								                                    <label for="" class="labelCenter" style="font-weight: 100;">ความคิดเห็นของนักสังคมสงเคราะห์ :</label>
								                                </div>
								                                <div>
								                                    <div class="form-group">
								                                        <textarea name="comment" rows="10" cols="80" ><?=$resultpro3['comment'];?></textarea>
								                                    </div>
								                                </div>
														     </div>
															 <!-- ค้ามนุษย์ -->
															 <?php
												
														$resultprofile4 = mysql_query("select * from sv_frafficking where user_ID='$iduser' and sv_received_ID='$_GET[id_received]'");
														$resultpro4=mysql_fetch_array($resultprofile4);

													?>
														      <div id="view4">
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">เดินทางเข้า-ออกประเทศโดยช่องทางใด :</label>
								                                        <input type="text" name="type_travel" class="" id="" placeholder="" value="<?=$resultpro4['type_travel'];?>">
								                                    </div>
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" style="font-weight: 100;">วิธีการเดินทาง :</label>
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">ชื่อ-สกุลของผู้ช่วยเหลือในการเดินทาง :</label>
								                                        <input type="text" name="name_help" class="" id="" placeholder="" value="<?=$resultpro4['name_help'];?>">
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter" >ถูกกระทำในลักษณะข้อใดข้อหนึ่งดังต่อไปนี้ :</label>
																		
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
																		?>> จัดหา
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
																		?>> ซื้อ
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
																		?>> ขาย
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
																		?>> จำหน่าย
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
																		?>> พามาจาก
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
																		?>> ส่งไปยังที่ใด
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
																		?>> หน่วงเหนี่ยว
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
																		?>> กักขัง
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
																		?>> จัดให้อยู่อาศัย
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
																		?>> รับไว้
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                        </table>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter">โดยใช้วิธีในลักษณะข้อใดข้อหนึ่งดังต่อไปนี้ :</label>
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
																		?>> ข่มขู่
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
																		?>> ใช้กำลังบังคับ
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
																		?>> ลักพาตัว
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
																		?>> ฉ้อฉล
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
																		?>> หลอกลวง
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
																		?>> ใช้อำนาจโดยมิชอบ
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
																		?>> โดยให้เงินหรือผลประโยชน์อย่างอื่นแก่ผู้ปกครองหรือผู้ดูแลเพื่อให้ผู้ปกครองหรือผู้ดูแลให้ความยินยอมแก่ผู้กระทำความผิดในการแสวงหาผลประโยชน์จากบุคคลที่ตนดูแล
								                                                        </label>
								                                                    </div>
								                                                </td>
								                                            </tr>
								                                        </table>
								                                    </div>
								                                </div>
								                                <div class="form-inline table">
								                                    <div class="form-group">
								                                        <label for="" class="labelCenter">โดยมีวัตถุประสงค์ข้อใดข้อหนึ่งดังต่อไปนี้ :</label>
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
																		?>> การแสวงหาผลประโยชน์จากการค้าประเวณี
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
								                                                            การผลิตหรือเผยแพร่วัตถุหรือสื่อลามก
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
																		?>> การแสวงหาผลประโยชน์ทางเพศในรูปแบบอื่น
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
																		?>> การเอาลงเป็นทาส
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
																		?>> การนำมาขอทาน
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
																		?>> การบังคับใช้แรงงานหรือบริการ
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
																		?>> การบังคับตัดอวัยวะเพื่อการค้า
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
																		?>> การอื่นใดที่คล้ายคลึงกันอันเป็นการขูดรีดบุคคล
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
								                                        <label for="" class="labelCenter" style="font-weight: 100;">สรุปความเห็น :</label>
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
								                                    <label for="" class="labelCenter" style="font-weight: 100;">โดยมีพฤติกรรม คือ :</label>
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
alert('กรุณาเลือกคำนำหน้าชื่อ');
}else{
}

});

	//ซ้อนอื่นๆ ประเภท
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
alert('กรุณาเลือกคำนำหน้าชื่อ');
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