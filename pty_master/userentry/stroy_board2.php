<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="../hr3/tool_competency/diagnosticv1/css/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #F60;
}
a:active {
	color: #000;
}
</style>
</head>
<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong>รายงานข้อมูลที่ต้อง QC</strong></td>
        </tr>
        <tr>
          <td align="left"><form id="form1" name="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>เดือนปี : </strong></td>
                <td width="86%" align="left">
                  <select name="mm" id="mm">
                  <option value="">เลือกเดือน</option>
                  <option value='01' >มกราคม</option><option value='02' >กุมภาพันธ์</option><option value='03' >มีนาคม</option><option value='04' selected='selected'>เมษายน</option><option value='05' >พฤษภาคม</option><option value='06' >มิถุนายน</option><option value='07' >กรกฎาคม</option><option value='08' >สิงหาคม</option><option value='09' >กันยายน</option><option value='10' >ตุลาคม</option><option value='11' >พฤศจิกายน</option><option value='12' >ธันวาคม</option>                  </select>
                 <strong> ปี </strong>
                 <select name="yy1" id="yy1">
                 <option value="">เลือกปี</option>
                 <option value='2552' >2552</option><option value='2553' >2553</option><option value='2554' >2554</option><option value='2555' selected='selected'>2555</option>                 </select>
                 <select name="site_id" id="site_id">
                 <option value="">เลือก site งาน</option>
                 <option value="999"  selected='selected' >เลือกทั้งหมด</option>
                 <option value='8' >Keydata Part-Time</option><option value='3' >Keydata02 (ห้องหลัง)</option><option value='69' >ศูนย์บันทึกข้อมูลจังหวัดอุดรธานี (BLUE)</option><option value='71' >ศูนย์บันทึกข้อมูลจังหวัดอุดรธานี (ORANGE)</option><option value='6' >ศูนย์บันทึกข้อมูลจังหวัดอุดรธานี (Training)</option><option value='53' >ศูนย์บันทึกข้อมูลจังหวัดเชียงใหม่</option><option value='42' >ศูนย์บันทึกข้อมูลจังหวัดเชียงใหม่ (Club road)</option><option value='70' >ศูนย์บันทึกข้อมูลจังหวัดเชียงใหม่ (OZONE หน้ามช)</option><option value='51' >ศูนย์บันทึกข้อมูลจังหวัดเชียงใหม่ (PAYAP)</option><option value='5' >ศูนย์บันทึกข้อมูลจังหวัดเชียงใหม่ (Training)</option><option value='4' >ศูนย์บันทึกข้อมูลจังหวัดเชียงใหม่ (yellow sapphire)</option>                 
                 </select>
                 <input type="submit" name="button2" id="button" value="แสดงรายงาน">
<!--                 <input type="hidden" name="xtype" value="2">
                 <input type="hidden" name="mm" value="04">
                 <input type="hidden" name="yy1" value="2555">
                  <input type="hidden" name="site_id" value="999">
                  <input type="hidden" name="group_ratio" value="">
                  <input type="hidden" name="period_time" value="">-->
                 
                 &nbsp;
                 <!--<a href="report_alert_qc_view.php" target="_blank" >แสดงข้อมูลQC</a>&nbsp;&nbsp;||&nbsp;&nbsp;--><!--<a href="CC_subgroupqc_GroupL.php?group_id=2&xtype=2&mm=04&yy1=2555&configdate=2012-04&xscript=1" target="_blank">ประมวลผลคำนวณจุดQC</a>--><br><i>หมายเหตุ หากการแบ่งกลุ่ม QC ไม่ถูกต้องให้คลิ๊ก "แบ่งกลุ่ม QCใหม่"  ของพนักงานคีย์ข้อมูลอีกครั้ง </i></td>
              </tr>
            </table>
          </form></td>
        </tr>
                <tr>
          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
             <td width="9%" align="center" bgcolor="#FFFFFF"><strong><a href="?xtype=2&mm=04&yy1=2555&site_id=999">กลุ่ม L</a></strong></td>
              <td width="26%" align="center" bgcolor="#E9E9E9"><strong><a href="../hr3/tool_competency/diagnosticv1/report_qc.php?mm=04&yy1=2555&site_id=999" target="_blank">กลุ่ม N [1]</a><!-- || <a href="?xtype=3&mm=04&yy1=2555&site_id=999&group_ratio=2&period_time=am">กลุ่ม N [2]</a>--> || <a href="?xtype=3&mm=04&yy1=2555&site_id=999&group_ratio=3&period_time=am">กลุ่ม N [3 - 4 หรือมากกว่า]</a></strong></td>
              <td width="14%" align="center" bgcolor="#E9E9E9"><strong><a href="?xtype=5&mm=04&yy1=2555&site_id=999">parttime(L)</a></strong></td>
              <td width="27%" align="center" bgcolor="#E9E9E9"><strong><a href="../hr3/tool_competency/diagnosticv1/report_qc_parttime.php" target="_blank">parttime N [1]</a> || <!--<a href="?xtype=4&mm=04&yy1=2555&site_id=999&group_ratio=2&period_time=pm">parttime N [2]</a> ||--> <a href="?xtype=4&mm=04&yy1=2555&site_id=999&group_ratio=3&period_time=pm">parttime N [3 - 4 หรือมากกว่า]</a> </strong></td>
              <td width="24%" bgcolor="#E9E9E9"><a href="report_alert_keyupdate_qc.php?mm=04&yy1=2555" target="_blank">กลุ่มพนักงานคีย์ข้อมูล update</a></td>
            </tr>
            <tr>
              <td colspan="5" align="left" bgcolor="#E9E9E9"><strong>แสดงข้อมูลกลุ่ม L ประจำเดือน เมษายน 2555</strong></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
            <tr>
              <td width="4%" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="16%" align="center" bgcolor="#D4D4D4"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="4%" align="center" bgcolor="#D4D4D4"><strong>กลุ่ม</strong></td>
              <td width="76%" align="center" bgcolor="#D4D4D4"><strong>จำนวนรอบการสุ่มตรวจสอบข้อมูล   อัตราส่วน 1:20</strong></td>
              </tr>
                        <tr bgcolor="#FFFFFF">
                          <td align="center">1</td>
                          <td align="left">นางสาวทัศนาพร   แซ่กือ<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11045&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
                          <td align="center">L</td>
                          <td align="left">
                            <table width="10%" border="0" cellspacing="2" cellpadding="1">
                              <tr>
                                <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=209&datekey=2012-04&staffid=11045&xidcard=&status_unfully=1' target='_blank'>[11]</a></td>
                                </tr>
                            </table>
                            
                          </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">2</td>
              <td align="left">นางสาวปริญญา   ทาเหล็ก<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11055&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=230&datekey=2012-04&staffid=11055&xidcard=&status_unfully=1' target='_blank'>[9]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">3</td>
              <td align="left">นางสาวนุชรีพรรณ   บุญสง่า<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11134&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=259&datekey=2012-04&staffid=11134&xidcard=&status_unfully=1' target='_blank'>[17]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">4</td>
              <td align="left">นางสาวพิมพร หันธนู<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11140&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FF0000"><a href='report_alert_qc_detail.php?loopx=412&datekey=2012-04&staffid=11140&xidcard=' target='_blank'>[20]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">5</td>
              <td align="left">นางสาวพิมพร หันธนู<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11343&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=246&datekey=2012-04&staffid=11343&xidcard=&status_unfully=1' target='_blank'>[3]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">6</td>
              <td align="left">นางสาวกฤชอร   ทองศรี<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11357&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=219&datekey=2012-04&staffid=11357&xidcard=&status_unfully=1' target='_blank'>[15]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">7</td>
              <td align="left">นางสาวอรทัย   อินต๊ะสืบ<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11369&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFFFF">[0]</td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">8</td>
              <td align="left">นางสาวอุมาภรณ์   เคนแสนโคตร<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11403&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=196&datekey=2012-04&staffid=11403&xidcard=&status_unfully=1' target='_blank'>[3]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">9</td>
              <td align="left">นางสาวกัญญาภัค   แก้วหนัก<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11407&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=167&datekey=2012-04&staffid=11407&xidcard=&status_unfully=1' target='_blank'>[3]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">10</td>
              <td align="left">นางสาวพรรณิกา   พรหมสวัสดิ์<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11419&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=151&datekey=2012-04&staffid=11419&xidcard=&status_unfully=1' target='_blank'>[2]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">11</td>
              <td align="left">นางสาวอำภาพร   เต๋จ๊ะ<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11424&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFFFF">[0]</td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">12</td>
              <td align="left">นางสาวจินตนา   แก้วสุวรรณ<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11429&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=344&datekey=2012-04&staffid=11429&xidcard=&status_unfully=1' target='_blank'>[16]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">13</td>
              <td align="left">นางสาวปวีณา   เบิกบาน (Fulltime)<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11472&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=107&datekey=2012-04&staffid=11472&xidcard=&status_unfully=1' target='_blank'>[11]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">14</td>
              <td align="left">นางสาวพัชรี   ปิยะจันทร์<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11526&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=223&datekey=2012-04&staffid=11526&xidcard=&status_unfully=1' target='_blank'>[16]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">15</td>
              <td align="left">นางสาวสุดารัตน์   เทโวขัติ<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11541&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=205&datekey=2012-04&staffid=11541&xidcard=&status_unfully=1' target='_blank'>[13]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">16</td>
              <td align="left">นางสาวเยาวลักษณ์   โหลามนต์<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11543&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFFFF">[0]</td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">17</td>
              <td align="left">นางสาวกัลยาลักษณ์   อนุพันธ์<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11775&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=206&datekey=2012-04&staffid=11775&xidcard=&status_unfully=1' target='_blank'>[9]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">18</td>
              <td align="left">นางสาวอรณิช   ชะนะ<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11877&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=139&datekey=2012-04&staffid=11877&xidcard=&status_unfully=1' target='_blank'>[2]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">19</td>
              <td align="left">นายสามารถ   แซ่โซ้ง<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11879&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=131&datekey=2012-04&staffid=11879&xidcard=&status_unfully=1' target='_blank'>[19]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">20</td>
              <td align="left">นางสาวนวลระหง   ขุนนที<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=11932&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=56&datekey=2012-04&staffid=11932&xidcard=&status_unfully=1' target='_blank'>[11]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">21</td>
              <td align="left">นางสาวพัชรี   โยเหลา<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12109&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFFFF">[0]</td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">22</td>
              <td align="left">นางสาวกฤษณา   ขระเขื่อน<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12162&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="10%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=44&datekey=2012-04&staffid=12162&xidcard=&status_unfully=1' target='_blank'>[12]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">23</td>
              <td align="left">นางสาวปรียานุช   ปาลี<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12275&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=50&datekey=2012-04&staffid=12275&xidcard=&status_unfully=1' target='_blank'>[12]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">36</td>
              <td align="left">นางสาวสุนิสา   แข่งขัน<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12362&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=41&datekey=2012-04&staffid=12362&xidcard=&status_unfully=1' target='_blank'>[6]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">37</td>
              <td align="left">นางสาวนลพรรณ   คำปลิว<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12367&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=41&datekey=2012-04&staffid=12367&xidcard=&status_unfully=1' target='_blank'>[6]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">38</td>
              <td align="left">นางสาวอรอนงค์   วงศ์ศรีใส<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12369&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=57&datekey=2012-04&staffid=12369&xidcard=&status_unfully=1' target='_blank'>[7]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">39</td>
              <td align="left">นางสาวพัชราภรณ์   สอนใจ<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12388&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=43&datekey=2012-04&staffid=12388&xidcard=&status_unfully=1' target='_blank'>[4]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">40</td>
              <td align="left">นางสาวพักศณกรณ์   เกี๋ยงศิลา<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12399&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=57&datekey=2012-04&staffid=12399&xidcard=&status_unfully=1' target='_blank'>[5]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">41</td>
              <td align="left">นางสาววรารัตน์   แสงแก้ว<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12401&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=30&datekey=2012-04&staffid=12401&xidcard=&status_unfully=1' target='_blank'>[14]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">42</td>
              <td align="left">นางสาวจันทิรา   จันทร์น้ำ<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12403&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=41&datekey=2012-04&staffid=12403&xidcard=&status_unfully=1' target='_blank'>[17]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">43</td>
              <td align="left">นางสาวภานิศา   คีรีสัตยกุล<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12465&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=89&datekey=2012-04&staffid=12465&xidcard=&status_unfully=1' target='_blank'>[11]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#F0F0F0">
              <td align="center">44</td>
              <td align="left">นางสาวบุษญามาส   อ้ายจาง<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12490&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFF66"><a href='report_alert_qc_detail.php?loopx=25&datekey=2012-04&staffid=12490&xidcard=&status_unfully=1' target='_blank'>[3]</a></td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                        <tr bgcolor="#FFFFFF">
              <td align="center">45</td>
              <td align="left">นายไพโรจน์   พันธุราษฎร์<a href="CC_subgroupqc_GroupN.php?group_id=2&configdate=2012-04&staffid=12739&site_id=999&period_time=" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center">L</td>
              <td align="left">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	                      <td align="center" width="100%" bgcolor="#FFFFFF">[0]</td>
                                  </tr>
              </table>
              
              </td>
              </tr>
                      </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
</body>
</html>
