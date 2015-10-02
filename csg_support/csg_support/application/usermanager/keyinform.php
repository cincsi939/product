
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style.css" rel=stylesheet>
<link rel="stylesheet" type="text/css" href=" css/dhtmlxtabbar.css">
<script  src="js/dhtmlxcommon.js"></script>
<script  src="js/dhtmlxtabbar.js"></script>
<script  src="js/dhtmlxtabbar_start.js"></script>
<script type="text/javascript" charset="utf-8" src="js/jquery-1.2.3.pack.js"></script>  
<script type="text/javascript">
 $(document).ready(function(){
$('.mover').hide();

$('#slideToggle').click(function(){

$(this).siblings('.mover').slideToggle();
});

});
</script>




<!--<link rel="stylesheet" type="text/css" href="codebase/common/style.css">-->

<STYLE type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style3 {color: #FFFFFF; font-weight: bold; }
.style4 {color: #999999}
.style5 {color: #009933}
#sr_table{
	width:30%;
}

#sr_table,#sr_table tr th,#sr_table tr td{
	border:#BBCEDD solid 1px ;
	border-collapse:collapse;
	height:30px;
}

#type{
	background-image:url(img/header_bg6.gif);
	color: #FFF;
}
.sub_type{
	text-align:center;
}

.navy{
	background-color:#F2F7F7;
}



-->
</STYLE>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="9%"  align="left" style="background-image: url(img/repeat_fl.png);">&nbsp;</td>
    <td width="41%" align="left" style="background-image: url(img/repeat_fl.png);">&nbsp;</td>
    <td width="50%" height="98" align="right" valign="top" style="background-image: url(img/repeat_fl.png);"><font color="#FFFFFF"><br />
   แบบสอบถามสถาพครอบครัว&nbsp;&nbsp;</font></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td height="500" align="center" valign="top">
    
    <TABLE id="sr_table">
    	<TR>
            <TH id="type">เลือกแบบสำรวจ</TH>
        </TR> 
			<TR onMouseOver="hiLght(this,'#FFCC99');" onMouseOut="hiLght(this,'#FFF')" onClick="dashLink('1');">
				<TD class="sub_type">แบบสอบถามสถาพครอบครัว</TD>
			</TR>
		    </TABLE>
    
    </td>
  </tr>
  <tr>
    <td align="right"><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="97%" align="right">
<div class="container">
  <div class="pusher" id="slideToggle"><strong>Copy right &copy; 2014 by </strong>  [<u>ข้อสงวนลิขสิทธิ์</u>]</div>
  <div style="display: none;" class="mover">เว็บไซต์ familylove.go.th ขอสงวนสิทธิ์การคัดลอก พิมพ์ซ้ำ หรือเผยแพร่รวมถึงการทำเฟรมหรือวิธีอื่นๆ ที่คล้ายกัน 
โดยไม่ได้รับอนุญาตเป็นลายลักษณ์อักษร อย่างเป็นทางการเท่านั้น
 </div>
</div></td>
          <td width="3%" valign="middle"><img src="img/icon32_00094.gif" alt="Call-Center" width="32" height="32" align="absmiddle" /></td>
        </tr>
      </table></td>
  </tr>
</table>
<script language="javascript">
	function Subtitle( Tab, id, no ) {
		roll_out(Tab);
		roll_over('Image'+id, '../../images/menu_icon/'+Tab+'/'+no+'_v2.png');
		
		if ( Tab == "tab1" ) {
			if ( id == "1" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ระบบฐานข้อมูลปฐมภูมิสมาชิก (Member Primary Data)";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบบันทึกข้อมูลพื้นฐานสมาชิกครัวเรือนในโครงการสายใยรัก โดยสามารถจำแนกข้อมูลออกเป็น 3 กลุ่ม ได้แก่<br>สมาชิกศูนย์ ๓ วัยฯ วัยเด็ก (0 - 18 ปี), สมาชิกศูนย์ ๓ วัยฯ วัยทำงาน (19 - 59 ปี), สมาชิกศูนย์ ๓ วัยฯ วัยสูงอายุ (60 ปีขึ้นไป) มีรายงานที่มองได้ทั้งในระดับ จังหวัด, อำเภอ, ตำบล หรือ หมู่บ้านได้ รวมทั้งสามารถสืบค้นข้อมูลและส่งออกเอกสารข้อมูลในรูปแบบของไฟล์ PDF ได้","แบบฟอร์มสำรวจข้อมูล (Research Form)","ระบบสนับสนุนกลไกลการขับเคลื่อน กำกับ ติดตามโครงการและงบประมาณ";
			} else if ( id == "2" ) {
				document.getElementById(Tab+"LbT").innerHTML = "แบบฟอร์มสำรวจข้อมูล (Research Form)";
				document.getElementById(Tab+"LbD").innerHTML = "แบบฟอร์มสำหรับการบันทึกข้อมูลการสำรวจ ได้แก่ แบบฟอร์ม สร.๐๑, แบบฟอร์ม สร.๐๒, แบบฟอร์ม สร.๐๓, แบบฟอร์ม สร.๐๔, แบบฟอร์ม สร.๐๕ และแบบฟอร์ม สร.๐๖";
			} else if ( id == "3" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ระบบสร้างแผนการดำเนินงานและรายงานกิจกรรมต่างๆ กสร. พิเศษ";
				document.getElementById(Tab+"LbD").innerHTML = "เป็นโปรแกรมประยุกต์สำหรับการกำกับ ติดตามการดำเนินโครงการและการเบิกจ่ายงบประมาณของหน่วยงานเริ่มตั้งแต่การจัดทำคำขออนุมัติโครงการ ระบบสามารถจำแนกโครงการตามแหล่งเงินงบประมาณ ดังนั้นผู้บริหารสามารถที่จะมองเห็นภาพรวมโครงการและงบประมาณทั้งหมดที่จะต้องบริหารจัดการทั้งหมด";
			} else if ( id == "4" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ระบบครุภัณฑ์ (Durable Articles)";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบครุภัณฑ์เป็นระบบเพื่อประโยชน์ในการอ้างถึง ตรวจนับและตรวจสอบคุณสมบัติและจำนวนของครุภัณฑ์ ว่าถูกต้องตรงตามทะเบียนที่ได้จัดเก็บไว้ในระบบหรือไม่ และเป็นประโยชน์สำหรับการวางแผนเพื่อจัดสรรครุภัณฑ์เพิ่มเติมหรือทดแทนให้กับแต่ละหน่วยงาน";
			} else if ( id == "5" ) {
				document.getElementById(Tab+"LbT").innerHTML = "การใช้พาหนะและน้ำมัน";
				document.getElementById(Tab+"LbD").innerHTML = "รองรับการบันทึกข้อมูลรถยนต์, รถจักรยานยนต์ และน้ำมัน";
			} else if ( id == "6" ) {
				document.getElementById(Tab+"LbT").innerHTML = "Quality of Life Improvement Program";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบการวัดและประเมินผลความสำเร็จของการให้ความช่วยเหลือในรูปดัชนีการยกระดับคุณภาพชีวิต";
			} else if ( id == "7" ) {
				document.getElementById(Tab+"LbT").innerHTML = "Individual Learning Map";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบแผนการเรียนรู้เพื่อยกระดับคุณภาพชีวิตรายบุคคล";
			} else if ( id == "8" ) {
				document.getElementById(Tab+"LbT").innerHTML = "การเรียนรู้ผ่านสื่ออิเล็กทรอนิกส์ (E-Learning)";
				document.getElementById(Tab+"LbD").innerHTML = "เพื่อเป็นช่องทางให้ประชาชนสามารถเข้าถึงองค์ความรู้ผ่านเครือข่ายอินเตอร์เน็ตสามารถรองรับทั้งระบบ on-demand , broadcast และหน่วยบริการอัจฉริยะเคลื่อนที่ในชุมชน";
			} else if ( id == "9" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ระบบงานสารบรรณอิเล็กทรอนิกส์ (E-Office)";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบงานสารบรรณอิเล็กทรอนิกส์ สำหรับหนังสือรับ, หนังสือส่งและหนังสือเวียน";
			} else if ( id == "10" ) {
				document.getElementById(Tab+"LbT").innerHTML = "Competency Management Supporting System";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบฐานข้อมูลบุคลากรในหน่วยงานเพื่อใช้จัดการควบคุมอัตรากำลัง และ เงินเดือน ";
			} else {
				document.getElementById(Tab+"LbT").innerHTML = "";
				document.getElementById(Tab+"LbD").innerHTML = "";
			}
		} else if ( Tab == "tab2" ) {
			if ( id == "12" ) {
				document.getElementById(Tab+"LbT").innerHTML = "รายงานระดับปฏิบัติการ";
				document.getElementById(Tab+"LbD").innerHTML = "รายงานที่ระดับปฏิบัติการ สามารถจะดูข้อมูลสถิติหรือข้อมูลที่ควรทราบ เพื่อที่จะประเมินผลได้";
			} else if ( id == "13" ) {
				document.getElementById(Tab+"LbT").innerHTML = "รายงานระดับผู้บริหาร";
				document.getElementById(Tab+"LbD").innerHTML = "รายงานที่ระดับผู้บริหาร สามารถจะดูข้อมูลสถิติหรือข้อมูลที่ควรทราบ เพื่อที่จะประเมินผลได้ ";
			} else if ( id == "14" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ระบบสารสนเทศภูมิศาสตร์ 3 มิติ แสดงดัชนีทางสังคม โครงการสายใยรักแห่งครอบครัว";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบสารสนเทศภูมิศาสตร์ หรือ Geographic Information System : GIS คือกระบวนการทำงานเกี่ยวกับข้อมูลในเชิงพื้นที่ด้วย ระบบคอมพิวเตอร์ ที่ใช้กำหนดข้อมูลและสารสนเทศ ที่มีความสัมพันธ์กับตำแหน่งในเชิงพื้นที่";
			} else if ( id == "15" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ระบบช่วยเหลือและแจ้งปัญหา การใช้งานโปรแกรม";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบช่วยเหลือและแจ้งปัญหา การใช้งานโปรแกรม (Help Desk) ประกอบไปด้วย เป็นระบบปฏิบัติการที่ช่วยให้ผู้ใช้ สามมาถแจ้งปัญหาเกี่ยวกับการใช้งานของระบบ (Helpdesk Reporting System) ระบบแสดงข้อมูลการประมวล (Network Monitoring) และ ระบบรายงานสถิติเวลา การประมวลผล";
			} else if ( id == "27" ) {
				document.getElementById(Tab+"LbT").innerHTML = "รายงานการติดตามและประมวลผล";
				document.getElementById(Tab+"LbD").innerHTML = "รายงานการติดตามและประมวลผล สามารถจะดูข้อมูลสถิติรายงานผลของการดำเนินโครงการและงบประมาณและความสำเร็จได้";	
			} else {
				document.getElementById(Tab+"LbT").innerHTML = "";
				document.getElementById(Tab+"LbD").innerHTML = "";
			}
		} else if ( Tab == "tab3" ) {
			if ( id == "15" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ระบบบริหารจัดการเว็บไซต์ (Web Portal Administrator)";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบบริหารจัดการเว็บไซต์ เป็นระบบที่ใช้ในการจัดการบหริหารจัดการ บทความ รูปภาพ และเนื้อหาต่างภายในเว็บไซต์ ";
			} else if ( id == "16" ) {
				document.getElementById(Tab+"LbT").innerHTML = "บริหารจัดการผู้ใช้งานระบบ (User Manager)";
				document.getElementById(Tab+"LbD").innerHTML = "บริหารจัดการผู้ใช้งานระบบ เป็นระบบที่ใช้ใน เพิ่ม ลบ แก้ไข รายชื่อผู้ใช้ และ สิทธิการเข้าถึงระบบโปรแกรมประยุกต์";
			} else {
				document.getElementById(Tab+"LbT").innerHTML = "";
				document.getElementById(Tab+"LbD").innerHTML = "";
			}
		} else if ( Tab == "tab4" ) {
			if ( id == "17" ) {
				document.getElementById(Tab+"LbT").innerHTML = "เครื่องมือ สร้างชั้นข้อมูลสารสนเทศภูมิศาสตร์ 3 มิติ (KML/KMZ builder)";
				document.getElementById(Tab+"LbD").innerHTML = "";
			} else if ( id == "18" ) {
				document.getElementById(Tab+"LbT").innerHTML = "เครื่องมือการสร้างแบบข้อคำถามเพื่อเก็บข้อมูลภาคสนาม (E-Questionnaire)";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบเครื่องมือสำหรับการสร้างแบบข้อคำถามเพื่อเก็บข้อมูลภาคสนาม เป็นระบบที่ออกแบบมาเพื่อการสร้างแบบสอบถามที่สามารถรองรับการใช้คำถาม คำตอบ สร้างแบบฟอร์ม และบริหารจัดการเทมเพลตของแบบสอบถาม เพื่อใช้สำรวจข้อมูลพื้นฐานของสมาชิกในโครงการ เพื่อให้สามารsถนำผลมาประมวลผลใช้เป็นฐานข้อมูลในอนาคตได้";
			} else if ( id == "19" ) {
				document.getElementById(Tab+"LbT").innerHTML = "เครื่องมือการสร้างรายงาน (Report Builder)";
				document.getElementById(Tab+"LbD").innerHTML = "โปรแกรม Report Builder เป็นโปรแกรมสำหรับการสร้างหน้ารายงานที่ช่วยทำให้โปรแกรมเมอร์ สร้างหน้ารายงานได้รวดเร็วขึ้น โดยที่ไม่ต้องสร้างหน้าตารายงาน, สร้าง Query Condition ในการดึงข้อมูลจากในฐานข้อมูลมาแสดงทีละรายงาน เพราะตัวโปรแกรมจะมี Tools ช่วยในการทำงานทุกอย่างโดยมีรูปแบบการใช้งานที่ง่าย";
			} else if ( id == "20" ) {
				document.getElementById(Tab+"LbT").innerHTML = "เครื่องมือการสร้างกราฟ สถิติ แผนภูมิ (Graph Builder)";
				document.getElementById(Tab+"LbD").innerHTML = "เป็นโปรแกรมสำหรับสร้างรายงานสรุปข้อมูลในรูปแผนภูมิและกราฟ ให้กับผู้บริหารได้มองเป็นภาพรวมและมิติสัมพัทธ์ข้อมูลเพิ่มเติมจากการรายงานข้อมูลในรูปแบบตารางความสัมพันธ์ ส่วนที่หนึ่งเป็นระบบแกนกลางสำหรับสร้างกราฟ (GraphBuilder Core Engine) และส่วนที่สองโปรแกรมอินเตอร์เฟซสำหรับผู้ใช้งานเพื่อกำหนดองค์ประกอบของกราฟ (GraphBuilder UI)";
			} else if ( id == "21" ) {
				document.getElementById(Tab+"LbT").innerHTML = "เครื่องมือการสร้างกราฟ สถิติ แผนภูมิ (Graph Builder)";
				document.getElementById(Tab+"LbD").innerHTML = "เป็นโปรแกรมสำหรับสร้างรายงานสรุปข้อมูลในรูปแผนภูมิและกราฟ ให้กับผู้บริหารได้มองเป็นภาพรวมและมิติสัมพัทธ์ข้อมูลเพิ่มเติมจากการรายงานข้อมูลในรูปแบบตารางความสัมพันธ์ ส่วนที่หนึ่งเป็นระบบแกนกลางสำหรับสร้างกราฟ (GraphBuilder Core Engine) และส่วนที่สองโปรแกรมอินเตอร์เฟซสำหรับผู้ใช้งานเพื่อกำหนดองค์ประกอบของกราฟ (GraphBuilder UI)";
			} else if ( id == "22" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ระบบแลกเปลี่ยนข้อมูลกลางด้วยมาตรฐาน XML (XML Data Exchange System)";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบระบบแลกเปลี่ยนข้อมูลกลางด้วยมาตรฐาน XML เป็นระบบสำหรับกระบวนการ Export XML และ Import XML ข้อมูลต่าง ๆ ที่ต้องการได้ โดยสามารถเลือก Field ที่ต้องการ Export XML ออกมาได้ เพื่อให้สามารถนำข้อมูลไปใช้ได้อย่างมีประสิทธิภาพ";
			} else if ( id == "23" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ระบบบริการเชื่อมต่อข้อมูลกลางด้วยมาตรฐาน XML (XML Web Service)";
				document.getElementById(Tab+"LbD").innerHTML = "ระบบบริการเชื่อมต่อข้อมูลกลางด้วยมาตรฐาน XML เป็นระบบสำหรับกระบวนการ Export XML ข้อมูลต่าง ๆ ที่ต้องการได้ โดยให้บริการตรวจสอบความเป็นตัวตนจริง (Authentication) ผ่านเว็บ ทำให้การบริการข้อมูลไปใช้ได้อย่างมีประสิทธิภาพ และมีความปลอดภัย";
			} else {
				document.getElementById(Tab+"LbT").innerHTML = "";
				document.getElementById(Tab+"LbD").innerHTML = "";
			}
		} else if ( Tab == "tab5" ) {
			if ( id == "24" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ข้อมูลทั่วไป (Personal Profile)";
				document.getElementById(Tab+"LbD").innerHTML = "ข้อมูลของผู้ใช้งานระบบ ประกอบเดียว  ชื่อ-นามสกล หน่วยงานที่สังกัด และ รหัสผ่าน ซึ่งสามารถแก้ไขส่วนตัวได้ ";
			} else if ( id == "25" ) {
				document.getElementById(Tab+"LbT").innerHTML = "สิทธิการใช้งานระบบ (Permission)";
				document.getElementById(Tab+"LbD").innerHTML = "สิทธิการเข้าถึงระบบโปรแกรมประยุกต์ต่างๆ";
			} else if ( id == "26" ) {
				document.getElementById(Tab+"LbT").innerHTML = "ข้อมูลการใช้งาน (System Log)";
				document.getElementById(Tab+"LbD").innerHTML = "";
			} else {
				document.getElementById(Tab+"LbT").innerHTML = "";
				document.getElementById(Tab+"LbD").innerHTML = "";
			}
		}
	}
	
	var tab1_c = 1;					var tab2_c = 11;				var tab3_c = 15;				var tab4_c = 17;				var tab5_c = 22;
	var tab1_t;						var tab2_t;						var tab3_t;						var tab4_t;						var tab5_t;
	var tab1_timer_is_on = 0;	var tab2_timer_is_on = 0;	var tab3_timer_is_on = 0;	var tab4_timer_is_on = 0;	var tab5_timer_is_on = 0;
	var tab1_indexCount = 1;	var tab2_indexCount = 1;	var tab3_indexCount = 1;	var tab4_indexCount = 1;	var tab5_indexCount = 1;
	
	function timedCount( Tab ) {
		if ( Tab == "tab1" ) {
			Subtitle( Tab, tab1_c, tab1_indexCount ); tab1_indexCount = tab1_indexCount + 1; if ( tab1_indexCount == 11 ) tab1_indexCount = 1; 
			tab1_c = tab1_c + 1; if ( tab1_c == 11 ) tab1_c = 1; tab1_t = setTimeout("timedCount('tab1')", 2000);
		}
		
		if ( Tab == "tab2" ) {
			Subtitle( Tab, tab2_c, tab2_indexCount ); tab2_indexCount = tab2_indexCount + 1; if ( tab2_indexCount == 5 ) tab2_indexCount = 1; 
			tab2_c = tab2_c + 1; if ( tab2_c == 15 ) tab2_c = 11; tab2_t = setTimeout("timedCount('tab2')", 2000);
		}
		
		if ( Tab == "tab3" ) {
			Subtitle( Tab, tab3_c, tab3_indexCount ); tab3_indexCount = tab3_indexCount + 1; if ( tab3_indexCount == 3 ) tab3_indexCount = 1; 
			tab3_c = tab3_c + 1; if ( tab3_c == 17 ) tab3_c = 15; tab3_t = setTimeout("timedCount('tab3')", 2000);
		}
		
		if ( Tab == "tab4" ) {
			Subtitle( Tab, tab4_c, tab4_indexCount ); tab4_indexCount = tab4_indexCount + 1; if ( tab4_indexCount == 6 ) tab4_indexCount = 1; 
			tab4_c = tab4_c + 1; if ( tab4_c == 22 ) tab4_c = 17; tab4_t = setTimeout("timedCount('tab4')", 2000);
		}
		
		if ( Tab == "tab5" ) {
			Subtitle( Tab, tab5_c, tab5_indexCount ); tab5_indexCount = tab5_indexCount + 1; if ( tab5_indexCount == 4 ) tab5_indexCount = 1; 
			tab5_c = tab5_c + 1; if ( tab5_c == 25 ) tab5_c = 22; tab5_t = setTimeout("timedCount('tab5')", 2000); 
		}
	}
	
	function doTimer( Tab ) {
//		if ( Tab == "tab1" ) if ( !tab1_timer_is_on ) { tab1_timer_is_on = 1; timedCount(Tab); }
//		if ( Tab == "tab2" ) if ( !tab2_timer_is_on ) { tab2_timer_is_on = 1; timedCount(Tab); }
//		if ( Tab == "tab3" ) if ( !tab3_timer_is_on ) { tab3_timer_is_on = 1; timedCount(Tab); }
//		if ( Tab == "tab4" ) if ( !tab4_timer_is_on ) { tab4_timer_is_on = 1; timedCount(Tab); }
//		if ( Tab == "tab5" ) if ( !tab5_timer_is_on ) { tab5_timer_is_on = 1; timedCount(Tab); }
	}
	
	function stopSlide( Tab ) {
		if ( Tab == "tab1" ) { clearTimeout(tab1_t); tab1_timer_is_on=0; }
		if ( Tab == "tab2" ) { clearTimeout(tab2_t); tab2_timer_is_on=0; }
		if ( Tab == "tab3" ) { clearTimeout(tab3_t); tab3_timer_is_on=0; }
		if ( Tab == "tab4" ) { clearTimeout(tab4_t); tab4_timer_is_on=0; }
		if ( Tab == "tab5" ) { clearTimeout(tab5_t); tab5_timer_is_on=0; }
	}
	
	function continSlide( Tab, id, no ) {
		if ( Tab == "tab1" ) { tab1_timer_is_on=0; tab1_indexCount = no; tab1_c = id; doTimer(Tab); }
		if ( Tab == "tab2" ) { tab2_timer_is_on=0; tab2_indexCount = no; tab2_c = id; doTimer(Tab); }
		if ( Tab == "tab3" ) { tab3_timer_is_on=0; tab3_indexCount = no; tab3_c = id; doTimer(Tab); }
		if ( Tab == "tab4" ) { tab4_timer_is_on=0; tab4_indexCount = no; tab4_c = id; doTimer(Tab); }
		if ( Tab == "tab5" ) { tab5_timer_is_on=0; tab5_indexCount = no; tab5_c = id; doTimer(Tab); }
	}
	
	window.onload = function () {
		setTimeout("doTimer('tab1')", 10);
		setTimeout("doTimer('tab2')", 10);
		setTimeout("doTimer('tab3')", 10);
		setTimeout("doTimer('tab4')", 10);
		setTimeout("doTimer('tab5')", 10);
	}
</script>