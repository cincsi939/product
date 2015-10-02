
<script>
 window.parent.document.getElementById('rpb_iframe').style.height="450px";
 window.parent.document.getElementById('rpb_iframe').style.width="550px";
 function Link()
 {
  //var reportId = 406;
//  var chkType;
//  if(document.getElementById('cond1_1').checked)
//  {
//	  chkType = document.getElementById('cond1_1').value;
//  }
//  else if(document.getElementById('cond1_2').checked)
//  {
//	   chkType = document.getElementById('cond1_2').value;
//  }
//  else
//  {
//	   chkType = '';
//  }
  var reportId = <?php echo $_GET['linkID']; ?>;
  window.parent.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/reportbuilder/report_preview.php?id='+reportId;
 }
</script>
<script>
	function show_search_display(){
	document.getElementById('div_search').style.display="none";
}
function show_search(){
	if(document.getElementById('div_search_icon').style.display=="none"){
		document.getElementById('div_search').style.display="none";
		document.getElementById('div_search_icon').style.display="";
	}else{
		document.getElementById('div_search').style.display="";
		document.getElementById('div_search_icon').style.display="none";
	}
	
}
</script>

<table width="100%" border="0" align="center">
        <tr>
            <td align="center">
          <div align="right"> <img src="../application/img/icon_setting.png" onClick="show_search();" align="absmiddle" style="cursor:pointer;"/></div>
            		
                    <div id="div_search_icon" >
                    	<div style="height:45px;">&nbsp;</div>
                    	
                        <?php
						
						//if(isset($_GET['selectType'])){
						?>
							<table width="360" height="350" border="0" align="center" style="background-image:url(../application/img/หนี้สิน_03_1.png); background-position:center; background-repeat:no-repeat; border:1px #CCC solid;">
                             <tr>
                                <td valign="top" align="right" style="height:30px; font-size:18px;">
									<strong>รายงานสภาวะหนี้ครัวเรือน จังหวัดตราด</strong>
                                </td>
                              <tr>
                                <td valign="top">
                                <div style="margin-left:20px;font-size:22px;">
                                	<?php
										if($_GET['chkType']==1){
											echo '<img src="http://'.$_SERVER['HTTP_HOST'].'/trat_eq/application/survey/main/images/trues.png" width="20" align="absmiddle"> ล้านบาท';
										}
										else
										{
											echo '<img src="http://'.$_SERVER['HTTP_HOST'].'/trat_eq/application/survey/main/images/trues.png" width="20" align="absmiddle"> บาท';
										}
									?>
                                </div>
                                </td>
                              </tr>
                             
                            </table>
						
                        <?php //}else{ ?>
                        <?php /*?><img src="../application/img/search_02.png" align="absmiddle" style="cursor:pointer;"/><?php */?>
                        <?php // } ?>
                	</div>
                </td>
          </tr>
          <tr>
            <td  align="center" >
            <table width="90%" height="360" border="0" align="center" id="div_search" style="background-image:url(../application/img/หนี้สิน_03_1.png); background-position:center; background-repeat:no-repeat; display:none;" >
              <tr>
                <td align="center">
                
                
                <table width="98%" border="0" cellpadding="0" cellspacing="0">

                  <tr>
                    <td style="border:1px #CCC solid;">
                    		<form action="" method="get">
                    		<table width="100%" border="0" id="tab_a1" cellpadding="1" cellspacing="0" align="center" >
                            <tr style=" padding:10px;">
                            <td colspan="2" style="margin:5px;padding:5px; height:25px;">
                            <strong>รายงานสภาวะหนี้ครัวเรือน จังหวัดตราด</strong>
                            <table width="98%" border="0">
                              <tr>
                                <td>
                                                <!--<input type="hidden" name="selectType" value="1"/>-->
                                                <?php
													/*if(($_GET['chkType']=='0') and ($_GET['linkID']==406 or $_GET['linkID']==407))
													{
														//echo '<input type="image" name="b_search" src="../application/img/search_data.png" >';
													}
													else
													{
														//echo '<input type="image" name="b_search" src="../application/img/search_data.png" onClick="Link()" >';
													}
													
													if(($_GET['chkType']=='1') and ($_GET['linkID']==408 or $_GET['linkID']==409))
													{
														//echo '<input type="image" name="b_search" src="../application/img/search_data.png" >';
													}
													else
													{
														//echo '<input type="image" name="b_search" src="../application/img/search_data.png" onClick="Link()" >';
													}*/
													
												?>
                                                
                                                </td>
                                <td><div style="text-align:right;">
                                                        <label>
                                                        <input type="radio" name="chkType" id="cond1_1" value="0" <?php  if($_GET['chkType']=='0'){echo 'checked'; }else {echo 'onClick="Link()"';} ?> >&nbsp;บาท</label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label >
                                                        <input type="radio" name="chkType" id="cond1_2" value="1" <?php  if($_GET['chkType']=='1'){echo 'checked';}else {echo 'onClick="Link()"';} ?> >&nbsp;ล้านบาท</label>
                                                        </div></td>
                              </tr>
                            </table>
                            
                            </td>
                          </tr>
                        </table>
                        </form>
                        <?php /*?><form action="" method="get">
                        <table width="100%" border="0" id="tab_a2" cellpadding="1" cellspacing="0" align="center" style=" display:none;">
                            <tr style=" padding:10px;">
                            <td colspan="2" style="margin:5px;padding:5px; height:25px;">
                            <strong>รายการความช่วยเหลือที่ต้องการ</strong>
                            <table width="98%" border="0">
                              <tr>
                                <td><input type="hidden" name="report_year" value="<?php echo $report_year;?>"/>
                                                <input type="hidden" name="report_type" value="<?php echo $report_type;?>"/>
                                               <input type="image" name="b_search" src="../application/img/search_data.png">
                                                </td>
                                <td><div style="text-align:right;">
                                                        <label >
                                                        <input type="radio" name="cond1" id="cond1_1" value="AND" <?php echo ($_GET['cond1']=='AND')?'checked':'';?> >&nbsp;And (และ)</label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label >
                                                        <input type="radio" name="cond1" id="cond1_2" value="OR" <?php echo ($_GET['cond1']=='OR')?'checked':'checked';?>>&nbsp;Or (หรือ)</label>
                                                        </div></td>
                              </tr>
                            </table>
                            </td>
                          </tr>
                          <tr> 
                           <td>
                          
                            </td>
                          </tr> 
                        </table>
                        </form><?php */?>
                    </td>
                  </tr>
                </table>
                
                   
                    
                </td>
              </tr>
            </table>
            
                    
            </td>
          </tr>
          
        </table>