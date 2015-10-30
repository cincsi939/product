

<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="hr.css" type="text/css" rel="stylesheet">
<SCRIPT language=JavaScript 
src="bimg/swap.js"></SCRIPT>
<script language="javascript" src="chk_number.js"></script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>

</head>

<body onLoad="refresh_list1();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom ">

      <!-- main Table  -->
      <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#2C2C9E">
        <tr>
          <td height="30"><font style="font-size:16px; font-weight:bold; color:#FFFFFF;">&nbsp;&nbsp;&nbsp;ประเภทและชนิดของเครื่องราชย์/เหรียญตรา</font></td>
          <td width="108" height="30" align="right" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        </tr>
        <tr bgcolor="#CACACA">
          <td width="862" align="right" bgcolor="#888888">&nbsp;</td>
          <td align="right" bgcolor="#888888"><img src="../../../../competency/images_sys/back.jpg" width="18" height="18" onClick="history.go(-1)" alt="ย้อนกลับ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><form  name ="form1" method = POST  action = "<?  echo $PHP_SELF ; ?>" onSubmit="return ch();" >
                        <!--  INPUT TYPE="hidden" NAME="position_now" VALUE="< ?=$rs[position_now]?>"----><br>
<div align="right"></div>							
                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('basicdata','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;<img src="bimg/profile_expanded.gif" name="ctrlbasicdata" width="9" height="9" border="0" id="ctrlbasicdata" >&nbsp;&nbsp;&nbsp; </font></b><font color="#000000">เครื่องขัตติยราชอิสริยาภรณ์อันมีเกียรติคุณรุ่งเรื่องยิ่งมหาจักรีบรมราชวงศ์</font></td>
                              </tr>
                              <tr>
                                <td><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- มหาจักรีบรมราชวงศ์ (ม.จ.ก.)  </td>
                              </tr>
                            </table>
                            <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('officer','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlofficer" width="9" height="9" border="0" id="ctrlofficer" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b>เครื่องราชอิสริยาภรณ์อันเป็นโบราณมงคลนพรัตนราชวราภรณ์</td>
                              </tr>
                              <tr>
                                <td><DIV id=swapofficer><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- นพรัตนราชวราภรณ์ (น.ร.) </DIV></td>
                              </tr>
                            </table>
 
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b>เครื่องราชอิสริยาภรณ์ อันมีศักดิ์รามาธิบดี </td>
                              </tr>
                              <tr>
                                <td><DIV id=swapnow><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- รามาธิบดี ชั้น ๑ (เสนางคะบดี)   ส.ร.<br>
                                    <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- รามาธิบดี ชั้น ๒ (มหาโยธิน)   ม.ร.<br>
                                      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- รามาธิบดี ชั้น ๓ (โยธิน ) ย.ร.<br>
                                        <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- รามาธิบดี ชั้น ๔ (อัสวิน) อ.ร.<br>
                                            <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- รามมาลาเข็มกล้ากลางสมร (ร.ม.ก.)<br>
                                            <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- รามมาลา (ร.ม.) 
                              <br>
                                      <br>
</DIV></td>
                              </tr>
                          </table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
                              <tr>
                                <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;</font></b><font color="#000000">เครื่องราชอิสริยาภรณ์จุลจอมเกล้า</font> </td>
                              </tr>
                              <tr>
                                <td><DIV id=swapnow>
                                  <p><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ปฐมจุลจอมเกล้าวิเศษ   (ป.จ.ว.)<br>
                                    <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ปฐมจุลจอมเกล้า (ป.จ.)<br>  
                                      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ทุติยจุลจอมเกล้าวิเศษ   (ท.จ.ว.)<br>  
                                      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ทุติยจุลจอมเกล้า   (ท.จ.)                                    <br>  
                                      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ตติยจุลจอมเกล้าวิเศษ   (ต.จ.ว.)                                    <br>  
                                      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ตติยจุลจอมเกล้า (ต.จ.)<br>  
                                      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ตติยานุจุลจอมเกล้า   (ต.อ.จ.) </p>
                                  </DIV></td>
                              </tr>
                          </table>
						  
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b>ครื่องราชอิสริยาภรณ์อันเป็นที่เชิดชูยิ่งช้างเผือก </td>
  </tr>
  <tr>
    <td><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- มหาปรมาภรณ์ช้างเผือก   (ม.ป.ช.)<br>  
      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ประถมาภรณ์ช้างเผือก   (ป.ช.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ทวีติยาภรณ์ช้างเผือก   (ท.ช.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ตริตาภรณ์ช้างเผือก   (ต.ช.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- จัตุรถาภรณ์ช้างเผือก   (จ.ช.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เบญจมาภรณ์ช้างเผือก   (บ.ช.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญทองช้างเผือก (ร.ท.ช.)<br>
                <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>-                เหรียญเงินช้างเผือก (ร.ง.ช.) </td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b> เครื่องราชอิสริยาภรณ์อันมีเกียรติยิ่งมงกุฏไทย </td>
  </tr>
  <tr>
    <td><DIV id=div2><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- มหาวชิรมงกุฏ (ม.ว.ม.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ประถมาภรณ์มงกุฏไทย   (ป.ม.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ทวีติยาภรณ์มงกุฏไทย   (ท.ม.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ตริตาภรณ์มงกุฏไทย   (ต.ม.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- จัตุรถาภรณ์มงกุฏไทย   (จ.ม..)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เบญจมาภรณ์มงกุฏไทย   (บ.ม.)<br>  
          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญทองมงกุฏไทย (ร.ท.ม.)<br>
                    <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>-                  เหรียญเงินมงกุฏไทย (ร.ง.ม.)</DIV></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b> เครื่องราชอิสริยาภรณ์อันเป็นที่สรรเสริญยิ่งดิเรกคุณาภรณ์ </td>
  </tr>
  <tr>
    <td><DIV id=div3><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- ปฐมดิเรกคุณาภรณ์ (ป.ภ.)<br>
      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- 
      ทุติยดิเรกคุณาภรณ์ (ท.ภ.)<br>
      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- 
      ตติยดิเรกคุณาภรณ์ (ต.ภ.)<br>
      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- 
      จตุตถดิเรกคุณาภรณ์ (จ.ภ.)<br>
      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- 
      เบญจมดิเรกคุณาภรณ์ (บ.ภ.)<br>
      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- 
      เหรียญทองดิเรกคุณาภรณ์ (ร.ท.ภ.)<br>
      <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>-       เหรียญเงินดิเรกคุณาภรณ์ (ร.ง.ภ.) </DIV></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b>  เหรียญบำเหน็จกล้าหาญ</strong></td>
  </tr>
  <tr>
    <td><DIV id=div><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญกล้าหาญประดับช่อชัยพฤกษ์<SPAN lang="th"> (ร.ก)</SPAN><br>
            <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- 
           เหรียญกล้าหาญ<br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญชัยสมรภูมิ (ช.ส.)(การรบสงครามอินโดจีน)<br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญชัยสมรภูมิ (ช.ส.)(การรบสงครามมหาเอเชียบูรพา)<br>
                <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- 
                เหรียญชัยสมรภูมิ (ช.ส.)(การร่วมรบกับสหประชาชาติ ณ ประเทศเกาหลี)<br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญชัยสมรภูมิ (ช.ส.)
              การรบสงคราม 
                ณ   สาธารณรัฐเวียดนาม
                (ประดับเปลวระเบิด)<br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญพิทักษ์เสรีชน ชั้นที่   ๑<SPAN lang="th">(</SPAN>ส.ช.๑<SPAN lang="th">)</SPAN><br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญพิทักษ์เสรีชน ชั้นที่ ๒   ประเภทที่ ๑<SPAN lang="th">(</SPAN>ส.ช.๒/๑<SPAN lang="th">)</SPAN><br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญพิทักษ์รัฐธรรมนูญ (พ.ร.ธ.) <br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญพิทักษ์เสรีชน ชั้นที่ ๒ ประเภทที่   ๒<SPAN lang="th">(</SPAN>ส.ช.๒/๒)<br>
    </DIV></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b>  เหรียญบำเหน็จในราชการ</td>
  </tr>
  <tr>
    <td><DIV id=div4><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญดุษฎีมาลา เข็มศิลปวิทยา(สำหรับพระราชทาน ทหาร,ตำรวจ)</strong><br>
            <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- 
             เหรียญดุษฎีมาลา เข็มศิลปวิทยา(สำหรับพระราชทานแก่พลเรือน)</strong><br>
                   <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญช่วยราชการ เขตภายใน (การรบสงครามอินโดจีน) </strong><br>
                   <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญช่วยราชการ<SPAN lang="th">เขต</SPAN>ภายใน (การรบสงครามมหาเอเชียบูรพา)</strong><br>
                     <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญราชการชายแดน</strong> (ช.ด.) <br>
                        <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญจักรมาลา</strong> (ร.ม.)<br>
                          <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญจักรพรรดิมาลา</strong> (ร.จ.พ.) <br>
                            <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญลูกเสือสรรเสริญ</strong> ชั้น ๑ <br>
                            <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญลูกเสือสรรเสริญ</strong> ชั้น ๒<br>
                            <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญลูกเสือสรรเสริญ</strong> ชั้น ๓                            <br>
                              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญลูกเสือสดุดี</strong><br>
                                <br>
    </DIV></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b>  เหรียญบำเหน็จองค์พระมหากษัตริย์</td>
  </tr>
  <tr>
    <td><DIV id=div5>
      <p><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญรัตนาภรณ์ ชั้น ๑  </strong><br>
        <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญรัตนาภรณ์ ชั้น ๒ </strong><br>
        <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญรัตนาภรณ์ ชั้น ๓ </strong><br>
        <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญรัตนาภรณ์ ชั้น ๔ </strong><br>
        <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญรัตนาภรณ์ ชั้น ๕ </strong><br>
        <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญราชรุจิ ทอง</strong><br>
        <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญราชรุจิ เงิน </strong><br>
        <br>
        </p>
      </DIV></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#CACACA" onClick="javascript:swap('now','bimg/profile_collapsed.gif','bimg/profile_expanded.gif');"  style="CURSOR: hand">&nbsp;<b class="gcaption"><font color="#000000">&nbsp;</font></b><b><font color="#000000"><img src="bimg/profile_expanded.gif" name="ctrlnow" width="9" height="9" border="0" id="ctrlnow" >&nbsp;&nbsp;&nbsp;&nbsp;</font></b>  เหรียญที่พระราชทานเป็นที่ระลึก</td>
  </tr>
  <tr>
    <td><DIV id=div6>
      <p><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- <SPAN lang="TH">เหรียญสตพรรษมาลา</SPAN></strong> </strong>(ส.ม.)<br>
            <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- <SPAN lang="TH">เหรียญรัชฎาภิเษกมาลา</SPAN></strong> </strong><br>
            <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>-<SPAN lang="TH"> เหรียญประพาสมาลา</SPAN></strong><br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- <SPAN lang="TH">เหรียญราชินี</SPAN></strong><br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- <SPAN lang="TH">เหรียญทวีธาภิเษก</SPAN></strong><br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- <SPAN lang="TH">เหรียญรัชมงคล</SPAN></strong><br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- <SPAN lang="TH">เหรียญรัชมังคลาภิเษก</SPAN></strong><br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- <SPAN lang="TH">เหรียญบรมราชาภิเษก   ร.๖<br>
              </SPAN></strong><SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- เหรียญบรมราชาภิเษก   ร.๗</SPAN></strong><SPAN lang="TH"> </SPAN><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญบรมราชาภิเษก   ร.๙</SPAN></strong> (</strong><SPAN lang="TH">ทอง)</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญบรมราชาภิเษก   ร.๙</SPAN></strong> (</strong><SPAN lang="TH">เงิน)</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญชัย</SPAN></strong><br>        
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญเฉลิมพระนคร</SPAN></strong> </strong><SPAN lang="TH">๑๕๐ ปี</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญงานฉลอง</SPAN></strong> </strong><SPAN lang="TH">๒๕   พุทธศตวรรษ</SPAN></strong><SPAN lang="TH"> </SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญที่ระลึก</SPAN></strong><SPAN lang="TH">ในการเสด็จพระราชดำเนิน</SPAN></strong><SPAN lang="TH">เยือนสหรัฐอเมริกา   และยุโรป</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญรัชฎาภิเษก</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญที่ระลึก</SPAN></strong><SPAN lang="TH">พระราชทานสถาปนา</SPAN></strong><SPAN lang="TH">สมเด็จพระบรมโอรสาธิราชฯ</SPAN></strong> 
              </strong><SPAN lang="TH">สยามมกุฎราชกุมาร</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญสนองเสรีชน</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญที่ระลึก</SPAN></strong><SPAN lang="TH">พระราชทานสถาปนา</SPAN></strong><SPAN lang="TH">สมเด็จพระเทพรัตนราชสุดา   ฯ</SPAN></strong> </strong><SPAN lang="TH">สยามบรมราชกุมารี</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญสรรเสริญลูกเสือ</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญกาชาดสมนาคุณ</SPAN></strong>(</strong><SPAN lang="TH">ชั้นที่ ๑)</SPAN></strong><br>
              <SPAN lang="TH"><b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- </SPAN></strong><SPAN lang="TH">เหรียญกาชาดสมนาคุณ</SPAN></strong>(</strong><SPAN lang="TH">ชั้นที่ ๒)</SPAN></strong><br>
              <b class="gcaption"><font color="#000000">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </font></b>- <SPAN lang="TH">เหรียญกาชาดสมนาคุณ</SPAN></strong>(</strong><SPAN lang="TH">ชั้นที่ ๓)</SPAN></strong><br>
              <br>
      </p>
      </DIV></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
                        </form   ></td>
                      </tr>
                  </table></td>
                </tr>
              </table>
            <SCRIPT LANGUAGE="JavaScript">
<!--
var unitname = new Array(<?=$ngroup?>);
var unitid = new Array(<?=$ngroup?>);
var salarylist = new Array(<?=$nradub?>);
<?
		for($i=0;$i<$ngroup;$i++){
			$x1 = ""; $x2 = "";
			$uresult = mysql_query("select  *  from  office_detail where beunder='" . $groupid[$i] . "';");
			while ($urs=mysql_fetch_array($uresult,MYSQL_ASSOC)) {
				if ($x1 > "") $x1.=",";
				$x1 .= "'$urs[th_name]'";

				if ($x2 > "") $x2.=",";
				$x2 .= "'$urs[id]'";
			}				
			echo "unitname[" . $groupid[$i] . "]=new Array($x1);\n";
			echo "unitid[" . $groupid[$i] . "]=new Array($x2);\n";
		}

		$x3 = "";
		for($i=0;$i<$nradub;$i++){
			if ($x3 > "") $x3 .=",";
			$x3 .= "'$srunid[$i]'";
		}

?>
var radub_id = new Array(<?=$x3?>);


function ShowUnit(id){
	f1 = document.forms[0];
	
	for(var count = f1.unit.options.length - 1; count >= 0; count--){
        f1.unit.options[count] = null;
    }

	for (i=0;i<unitname[id].length;i++){
		newoption = new Option(unitname[id][i], unitid[id][i], false, false); 
		f1.unit.options[f1.unit.length] = newoption;
	}


}


function ShowSalary(id){
	
	f1 = document.forms[0];
<?
// เงินเดือน แยกตามระดับ
		echo "if (id == '') {salary=null;}\n";
		for($i=0;$i<$nradub;$i++){
			$x1 = ""; 
			$uresult = mysql_query("select  salary  from  hr_salarylist where radub='" . $radublist[$i] . "';");
			while ($urs=mysql_fetch_array($uresult,MYSQL_ASSOC)) {
				if ($x1 > "") $x1 .=",";

				$x1 .= "'$urs[salary]'";
			}			

			if ($x1){
				echo "else if (id == '$radublist[$i]') {salary=new Array($x1);}\n";
			}else{
				echo "else if (id == '$radublist[$i]') {salary=null;}\n";
			}
		}
		echo "else {salary=null;}\n";

?>
	
	for(var count = f1.salary.options.length - 1; count >= 0; count--){
        f1.salary.options[count] = null;
    }

	for (i=0;i<salary.length;i++){
		newoption = new Option(salary[i], salary[i], false, false); 
		f1.salary.options[f1.salary.length] = newoption;
	}


}
//-->
        </SCRIPT></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

</html>
