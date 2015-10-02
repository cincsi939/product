<?php
/**
 * @comment  หน้าหลัก
 * @projectCode
 * @tor     
 * @package  core
 * @author Jakrit Monkong (jakrit@sapphire.co.th)
 * @created  13/09/2014
 * @access  public
 */
error_reporting(E_ALL ^ E_NOTICE);
//header ('Content-type: text/html; charset=utf-8'); 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<title>หน้าหลัก</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style_menu.css">
<style>
@font-face {
    font-family: 'supermarket';
    src: url('font/supermarket.eot');
    src: url('font/supermarket.eot?#iefix') format('embedded-opentype'),
         url('font/supermarket.woff') format('woff'),
         url('font/supermarket.ttf') format('truetype'),
		 url('font/supermarket.svg#supermarketRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'ThaiSansNeue-Black';
    src: url('font/ThaiSansNeue-Black.otf');
    src: url('font/ThaiSansNeue-Black.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'ThaiSansNeue-Regular';
    src: url('font/ThaiSansNeue-Regular.otf');
    src: url('font/ThaiSansNeue-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}


.info_text { width:80%; padding:5px; text-align:left;}
.info_text {
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
	font-size:18px;
}

p {
	font-family: !important; font-family: ThaiSansNeue-Regular,Tahoma,supermarketRegular !important;
	font-size:18px;
	padding-top:0px;	padding-bottom:0px;
	margin-top:8px;	margin-bottom:8px;
}
h1 { color:#960f55; font-size:28px;}

.col35 { width:35%; }
.col65 { width:65%; }
.picimg { width:70%;}
.imgmap { width:80%;}
@media (min-width: 1px) and (max-width: 480px) {
.info_text { width:97%;padding:5px;text-align:left;}
.picimg { width:50%;}
.col35 { width:100%; text-align:center;}
.col65 { width:100%; }
}
@media (min-width: 481px)  and (max-width: 767px) { 
.info_text { width:97%;padding:5px;text-align:left;}
.picimg { width:50%;}
.col35 { width:100%; text-align:center;}
.col65 { width:100%; }
}


@media (min-device-width: 1px) and (max-device-width: 480px) {
.info_text { width:97%;padding:5px;text-align:left;}
.picimg { width:50%;}
.col35 { width:100%; text-align:center;}
.col65 { width:100%; }
}
@media (min-device-width: 481px)  and (max-device-width: 767px) { 
.info_text { width:97%;padding:5px;text-align:left;}
.picimg { width:30%;}
.col35 { width:100%; text-align:center;}
.col65 { width:100%; }
.imgmap { width:60%;}
}
</style>
</head>
<body>
<?  include "header.php";?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td align="center">
	<div class="info_text">
	
<div>
	<h1>ความเป็นมา</h1>
	<p>โครงการเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด
	ตามที่กระทรวงการพัฒนาสังคมและความมั่นคงของมนุษย์ (พม.) เสนอแผนพัฒนาเด็กปฐมวัย โดยให้จัดสรรงบประมาณสำหรับเด็กแรกเกิดจนถึงอายุ 1 ปี จำนวน 400 บาท/คน/เดือน เพื่อเป็นการช่วยเหลือประชาชนที่มีรายได้น้อย โดยจะจ่ายให้กับผู้ที่อยู่นอกระบบประกันสังคม
	ทั้งนี้ จะทดลองประเมินผล 1 ปี ผู้ที่อยู่ในข่ายต้องมีสัญชาติไทย เริ่มวันที่ 1 ต.ค. 58 ถึงวันที่ 30 ก.ย. 59 วงเงินงบประมาณ 600 กว่าล้านบาท ซึ่งเชื่อว่าเพียงพอเนื่องจากปัจจุบันการเกิดลดน้อยลง เพื่อให้พ่อแม่ได้มีเงินสวัสดิการดูแลเด็กให้มีคุณภาพในอนาคต
	ทั้งนี้ รายละเอียดของโครงการเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิด ที่ ครม.มีมติเห็นชอบหลักการ ตามที่กระทรวงการพัฒนาสังคมและความมั่นคงของมนุษย์ (พม.) เสนอ มีสาระสำคัญสรุปได้ดังนี้
 1  วัตถุประสงค์ : เป็นการจัดสวัสดิการพื้นฐานเพื่อสร้างระบบการคุ้มครองทางสังคมและเป็นหลักประกันสิทธิขั้นพื้นฐานให้เด็กแรกเกิดได้รับการเลี้ยงดูที่มีคุณภาพ รวมทั้งเป็นมาตรการจูงใจให้พ่อแม่ ผู้ปกครอง ผู้ดูแลเด็ก นำเด็กเข้ารับบริการทางสาธารณสุขที่มีคุณภาพอย่างเป็นระบบ
 2  กลุ่มเป้าหมายและงบประมาณ : เด็กแรกเกิดสัญชาติไทยที่บิดาและ/หรือมารดามีสัญชาติไทย เกิดระหว่างวันที่ 1 ตุลาคม 2558 – 30 กันยายน 2559 และอยู่ในครัวเรือนยากจนและครัวเรือนที่เสี่ยงต่อความยากจน โดยอุดหนุนรายละ 400 บาทต่อคนต่อเดือน เป็นเวลา 1 ปี
 3  พื้นที่การดำเนินงาน : ครัวเรือนยากจนและครัวเรือนที่เสี่ยงต่อความยากจนทั่วประเทศ
 4  เป้าหมาย : จัดสวัสดิการพื้นฐานเพื่อสร้างระบบการคุ้มครองทางสังคม ลดความเหลื่อมล้ำและเป็นหลักประกันสิทธิขั้นพื้นฐานให้เด็กแรกเกิดได้รับการเลี้ยงดูที่มีคุณภาพ
 5  ประโยชน์ที่ประชาชนได้รับ :
 5.1  ประโยชน์ต่อการพัฒนาประเทศ : เป็นการลงทุนที่คุ้มค่าเพื่อพัฒนาทรัพยากรมนุษย์และสร้างรากฐานที่สำคัญของการพัฒนาประเทศ เพื่อให้เด็กสามารถเติบโตเป็นประชากรที่มีคุณภาพของสังคมและเป็นกำลังสำคัญในการพัฒนาประเทศต่อไปในอนาคต
 5.2  ประโยชน์ต่อเด็ก : เด็กแรกเกิดได้รับการเลี้ยงดูที่มีคุณภาพ เข้าถึงบริการทางสาธารณสุข มีคุณภาพอย่างเป็นระบบ ซึ่งจะสามารถส่งเสริมให้เด็กแรกเกิดและปฐมวัย มีพัฒนาการเหมาะสมตามวัย เป็นพื้นฐานที่สำคัญในการพัฒนาอย่างต่อเนื่องในช่วงวัยอื่นๆ ต่อไป
 5.3  ประโยชน์ต่อพ่อแม่ ผู้ปกครอง ผู้ดูแลเด็ก : ได้รับการช่วยเหลือแบ่งเบาภาระค่าใช้จ่ายในการดูแลเด็ก รวมทั้งทำให้พ่อแม่ ผู้ปกครอง ผู้ดูแลเด็ก มีความรู้ความเข้าใจในการเลี้ยงดูและส่งเสริมพัฒนาการเด็กผ่านโรงเรียนพ่อแม่
 6  ผลสัมฤทธิ์และตัวชี้วัด : ร้อยละ 95 ของเด็กที่ได้รับเงินอุดหนุนเพื่อการเลี้ยงดูเด็กแรกเกิดได้รับการเลี้ยงดูที่มีคุณภาพและมีพัฒนาการที่เหมาะสมตามวัย
 7  การติดตามประเมินผล : ติดตามประเมินผลโดยกลไกคณะอนุกรรมการส่งเสริมการพัฒนาเด็กปฐมวัยระดับจังหวัด องค์กรปกครองส่วนท้องถิ่น และหน่วยงานที่เกี่ยวข้อง</p>
<center><img src="../img/homehr.jpg" width="70%" height="20"></center>
</div>



<div>
	<div class="col35" style="float:left;text-align:center;"><a href="eq_paper.pdf" target="_blank" title="ดาวน์โหลดแบบสอบถาม"><img src="../img/homepic1.jpg" border="0" class="picimg"></a></div>
	<div class="col65" style="float:right;">
	

<center><img src="../img/homehr.jpg" width="70%" height="20"></center>
			</p>
			
			
</div>

	
	
	</div>
</div>
<table width="100%" border="0">
  <tr>
    <td height="3"></td>
  </tr>
</table>
<div>
	<div class="col35" style="float:left;">&nbsp;</div>
	<div class="col65" style="float:right;">
	
<div>
		
<center><img src="../img/homehr.jpg" width="70%" height="20"></center>
				</div>
	
	</div>
	
	</div>
</div>

<table width="100%" border="0">
  <tr>
    <td height="3"></td>
  </tr>
</table>

<div>
	<div class="col35" style="float:left; text-align:center;"><img src="../img/homepic2.jpg"  class="picimg" border="0"></div>
	<div class="col65" style="float:right;">
	
<center><img src="../img/homehr.jpg" width="70%" height="20"></center>
</div>


	</div>
</div>


<div>
	<div class="col65"  style="float:left; text-align:left;">
	
<h1>ขอบเขตการดำเนินงาน</h1>
	
<p>๑.จัดตั้งคณะทำงานใน๓ระดับ ได้แก่
<p style="padding-left:25px;">(๑)ระดับตำบล : องค์กรปกครองส่วนท้องถิ่น ศูนย์พัฒนาครอบครัวระดับตำบล โรงเรียน โรงพยาบาลส่งเสริมสุขภาพประจำตำบล ผู้นำชุมชน อาสาสมัครต่างๆ
<p style="padding-left:25px;">(๒)ระดับอำเภอ : อำเภอ โรงพยาบาลอำเภอ โรงเรียน สถานีตำรวจภูธร ศพส.อำเภอ เป็นต้น</p>
<p style="padding-left:25px;">(๓)ระดับจังหวัด : องค์การบริหารส่วนจังหวัด สำนักงานพัฒนาสังคม และความมั่นคงของมนุษย์ จังหวัด สำนักงานสาธารณสุขจังหวัด สำนักงานเขตพื้นที่การศึกษาประถมศึกษาตราด สำนักงานเขต พื้นที่การศึกษามัธยม เขต๑๗และหน่วยงานอื่นที่เกี่ยวข้อง</p>
<p>๒.จัดประชุมชี้แจงหน่วยงานที่เกี่ยวข้องเพื่อให้เกิดความรู้ความเข้าใจเกี่ยวกับขั้นตอนการดำเนินงาน และมีองค์ความรู้ที่ใช้ในการดำเนินงาน</p>
<p>๓.ลงพื้นที่สำรวจและจัดเก็บข้อมูลเด็กและครอบครัวรายครัวเรือน โดยคณะทำงานระดับตำบล</p>
<p>๔.วิเคราะห์ปัญหา และวางแผนการให้ความช่วยเหลือ โดยการจัดลำดับความรุนแรง
ของปัญหาเป็น เขียว เหลือง แดง แล้วสรุปข้อมูลจำนวนเด็กและครอบครัวเสนอ
คณะทำงานระดับอำเภอ และระดับจังหวัดเพื่อให้ทราบกลุ่มเป้าหมายที่จะดำเนินการ
ช่วยเหลือในปี๒๕๕๘</p>
<p>๕.ดำเนินการให้การช่วยเหลือ ตามขั้นตอนดังนี้</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เด็กในระบบ --> ศูนย์ช่วยเหลือนักเรียน --> ระดับอำเภอ -->ระดับจังหวัด</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เด็กนอกระบบ --> ศูนย์พัฒนาครอบครัวระดับตำบล -->ระดับอำเภอ -->ระดับจังหวัด</p>

<p>๖.ติดตาม ประเมินผลและสรุปผลการดำเนินตามโครงการรายงานต่อองค์การบริหารส่วนจังหวัดตราด</p>
	
	</div>
	<div class="col35" style="float:right;text-align:left;">
		<h1>พื้นที่ดำเนินการ</h1>
		<center><img src="../img/mapbg.jpg" class="imgmap"></center>
	</div>
</div>




</div>
</td>
  </tr>
</table>
</body>
</html>