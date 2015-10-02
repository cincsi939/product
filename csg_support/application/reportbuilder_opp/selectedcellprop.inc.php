<?php
/**
 * @comment ตั้งค่า report header
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    22/07/2014
 * @access     public
 */
?>
<table id="cellprop" border="0" width="95%" align="center" cellspacing="1" cellpadding="0" bgcolor="black" style="display:none;">
<tr bgcolor="white">
	<td align="LEFT">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr valign="middle" height="30"> 
                <td align="center" width="35" bgcolor="#FF6633"><INPUT TYPE="checkbox" NAME="x" ONCLICK="this.checked = true;" CHECKED></td>
                <td width="1" BGCOLOR="BLACK"></td>
                <td align="left" width="60%" bgcolor="#999999"><b style="font-size: 12pt;">&nbsp;&nbsp;Selected Cell's Properties :</b></td>
                <td align="RIGHT" bgcolor="#999999"> 
                    <INPUT TYPE="submit" VALUE=" Save " STYLE="font-weight: bold;" NAME="property"> 
                    <INPUT TYPE="button" VALUE=" Cancel " STYLE="font-weight: bold;" ONCLICK="location.href='?id=<?=$id?>';"> &nbsp;
                </td>
            </tr>
        </table>
	</td>
</tr>
<tr bgcolor="#F0F0F0">
	<td align="LEFT">
    	<br>
			<table width="90%" border="0" cellspacing="1" cellpadding="2" align="CENTER" bgcolor="#6699E0">
                <tr valign="middle" bgcolor="#CCE8FD"> 
                    <td align="left" width="160">&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="xnformat" VALUE="1"> <B>Number Format</B></td>
                    <td align="left" width="500">  
						<?php // @modify Phada Woodtikarn 22/07/2014 เปลี่ยนคำ และเพิ่ม format date thai?>  
                        <select name="nformat">
                            <option value="0">Number Natural Value</option>
                            <option value="1">Number Normal Value</option>
                            <option value="2">Number Invert Value</option>
                            <option value="3">Date eng2thai(Short)</option>
                            <option value="4">Date eng2thai(Full)</option>
                            <option value="5">Age Year Month</option>
                            <?php // @modify Phada Woodtikarn 30/09/2014 เพิ่ม format ซ่อนข้อมูล ?>
                            <option value="6">Hidden Value</option>
                            <?php // @end ?>
                        <?php // @end ?>
                        </select>
                        <?php // @end ?>
                    </td>
                </tr>
                <?php // @modify Phada Woodtikarn 13/08/2014 เพิ่ม blank value ?>
                <tr valign="middle" bgcolor="#CCE8FD"> 
                  <td align="left" width="160">&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="xnblank" VALUE="1"> <B>Blank Value</B></td>
                  <td align="left" width="500">
					  <select name="nblank">
                          <option value="0">(Default)</option>
                          <option value="1">N/A</option>
                          <option value="2">-</option>
                          <option value="3">0</option>
                          <option value="4">NULL</option>
                          <option value="5">None</option>
					  </select>
                    </td>
                </tr>
                <?php // @end ?>
                <tr valign="middle" bgcolor="#CCE8FD"> 
                    <td align="left" width="160">&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="xdecpoint" VALUE="1"> <B>Decimal Point</B></td>
                    <td align="left" width="500">  
                        <SELECT NAME="decpoint">
                            <OPTION VALUE="0">Natural</OPTION>
                            <OPTION VALUE="1">2 decimal point (.00)</OPTION>
                            <OPTION VALUE="2">3 decimal point (.000)</OPTION>
                            <OPTION VALUE="3">No decimal point</OPTION>
                        </SELECT>
                    </td>
                </tr>
                
                <tr valign="middle" bgcolor="#CCE8FD"> 
                    <td align="left" width="160">&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="xfont" VALUE="1"> <B>Fonts</B></td>
                    <td align="left" width="500">  
                        <input type="text" name="font" size="60" value="">  
                        <INPUT TYPE="BUTTON" VALUE=" Select Font" CLASS="xbutton" onclick="SelectFont(document.mergeform.font, '');">
                    </td>
                </tr>
                <tr valign="middle" bgcolor="#CCE8FD"> 
                    <td align="left" width="160">&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="xalignment" VALUE="1"> <B>Alignment</B></td>
                    <td align="left" width="500">  
                        <SELECT NAME="alignment" style="width:100;">
                            <OPTION VALUE="LEFT">Left</OPTION>
                            <OPTION VALUE="RIGHT">Right</OPTION>
                            <OPTION VALUE="CENTER">Center</OPTION>
                        </SELECT>
                    </td>
                </tr>
                
                <tr valign="middle" bgcolor="#CCE8FD"> 
                    <td align="left" width="160">&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="xvalign" VALUE="1"> <B>Vertical Alignment</B></td>
                    <td align="left" width="500">  
                        <SELECT NAME="valign" style="width:100;">
                            <OPTION VALUE="TOP">Top</OPTION>
                            <OPTION VALUE="MIDDLE">Middle</OPTION>
                            <OPTION VALUE="BASELINE">Baseline</OPTION>
                        </SELECT>
                    </td>
                </tr>
                
                <tr valign="middle" bgcolor="#CCE8FD"> 
                    <td align="left" width="160">&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="xbgcolor" VALUE="1"> <B>Background</B></td>
                    <td align="left" width="500">  
                        <input type="text" name="bgcolor" size="10" class="kolorPicker" value=""> 
                        <!--<INPUT TYPE="BUTTON" VALUE=" Select Color" CLASS="xbutton" ONCLICK="PickColor(document.mergeform.bgcolor);">-->
                    </td>
                </tr>
            </table>
		<br>
	</td>
</tr>
</table>
