<table width="100%" border="0" cellpadding="0" cellspacing="0" height="67" style="background-image:url('images/bg_tab.png');">
  <tbody><tr>
    <td width="50" align="left">
    <br>
    &nbsp;
      <a href="?id=<? echo $_GET['id'];?>&frame=form1<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>"><img src="images/arrow_left.png" align="absmiddle" border="0"></a>
        </td>
    <td width="25%" align="left">
    <br>
    <span class="infomenu_next"><a href="?id=<? echo $_GET['id'];?>&frame=form1<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>"  class="infomenu_next"><? echo $menu1;?></a></span>
    </td>
    <td style="background-image:url('images/background_tab.png'); background-position:center; background-repeat:no-repeat;" width="448" align="center">
    <br>
   <span class="infomenu"><? echo $menu2;?></span>
    </td>
    <td width="25%" align="right">
    <br>
    <span class="infomenu_next"><a href="?id=<? echo $_GET['id'];?>&frame=form3<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>"  class="infomenu_next"><? echo $menu3;?></a></span>
    </td>
    <td width="50" align="right">
    <br>
<a href="?id=<? echo $_GET['id'];?>&frame=form3<? if (!empty($_GET['report_type'])){ echo "&report_type=".$_GET['report_type']; }?>"><img src="images/arrow_right.png" align="absmiddle" border="0"></a>
        &nbsp;
    </td>
  </tr>
</tbody></table>



<?php

/*$sql = "SELECT tbl2_type,tbl2_id,tbl2_name,tbl2_idcard,tbl2_birthday,tbl2_age,r_name,education,tbl2_problem,tbl2_help";
$sql .= " FROM question_tbl2";
$sql .= " INNER JOIN tbl_relation ON tbl_relation.id = question_tbl2.tbl2_relation";
$sql .= " INNER JOIN eq_member_education ON eq_member_education.educ_id = question_tbl2.tbl2_education";
$sql .= " WHERE main_id=".$xml->Position1->NodeData7;
$sql .= " order by tbl2_id asc";*/

//$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value,reportdate from eq_var_data where siteid=1 AND form_id=2 AND pin='".$xml->Position1->NodeData7."'";
$sql = "select eq_idcard,eq_type,eq_prename,eq_firstname,eq_lastname,eq_age,eq_relation,eq_education from eq_person where eq_type != 0 AND eq_partner_id = ".$xml->Position1->NodeData7;

$tbl2 = $con->select($sql);

$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value,reportdate from eq_var_data where siteid=1 AND pin= ".$xml->Position1->NodeData7;
$eq = $con->select($sql);
foreach($eq as $rd)
{
	$value['v'.$row['vid']] = $row['value'];	
}
?>
<div class="container">
	<div class="infodata" >
<table width="100%"  height="296" border="0" cellpadding="3" cellspacing="0" class="personal_tb">
      <tr>
        <td height="28" colspan="4" align="left" valign="top" bgcolor="#f2f2f2"><div class="infodata_font">ด้านกลุ่มเป้าหมาย</div></td>
      </tr>
      <tr>
        <td height="28" colspan="4" align="right"><strong>จำนวนกลุ่มเป้าหมายทั้งหมด <?php echo count($tbl2); ?> คน </strong></td>
      </tr>
      <tr>
        <td colspan="4" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td >

			<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="personal_tb" style="border-collapse:collapse;">
                <tr style="background-color:#f2f2f2;">
                  <td width="110" height="24" align="center" ><strong>เลขประจำตัวประชาชน</strong></td>
                  <td width="93" align="center" ><strong>กลุ่มเป้าหมาย</strong></td>
                  <td width="200" height="24" align="center" ><strong>ชื่อ - นามสกุล </strong></td>
                  <td width="50" align="center" ><strong>อายุ (ปี)</strong></td>
				  <td width="100" align="center" ><strong>ความสัมพันธ์</strong></td>
                  <td width="170" align="center" ><strong>การศึกษา</strong></td>
                  <td width="270" align="center" ><strong>สถาพปัญหา</strong></td>
                  <td width="270" align="center" ><strong>ความต้องการ</strong></td>
                </tr>
                <?php foreach($tbl2 as $row){
					$problem_code = '';
					$help_code = '';
					$problem = array();
					$help = array();
					if($row['eq_type']==1)
					{
						if($value['v159']){$problem[]=$value['v159'];}
						if($value['v160']){$problem[]=$value['v160'];}
						if($value['v161']){$problem[]=$value['v161'];}
						if($value['v162']){$problem[]=$value['v162'];}
						if($value['v163']){$problem[]=$value['v163'];}
						if($value['v164']){$problem[]=$value['v164'];}
						if($value['v165']){$problem[]=$value['v165'];}
						if($value['v166']){$problem[]=$value['v166'];}
						if($value['v167']){$problem[]=$value['v167'];}
						if($value['v168']){$problem[]=$value['v168'];}
						if($value['v169']){$problem[]=$value['v169'];}
						if($value['v170']){$problem[]=$value['v170'];}
						if($value['v171']){$problem[]=$value['v171'];}
						if($value['v172']){$problem[]=$value['v172'];}
						if($value['v173']){$problem[]=$value['v173'];}
						if($value['v174']){$problem[]=$value['v174'];}
						if($value['v175']){$problem[]=$value['v175'];}
						if($value['v176']){$problem[]=$value['v176'];}
						if($value['v177']){$problem[]=$value['v177'];}
						if($value['v178']){$problem[]=$value['v178'];}
						if($value['v179']){$problem[]=$value['v179'];}
						if($value['v180']){$problem[]=$value['v180'];}
						if($value['v181']){$problem[]=$value['v181'];}
						if($value['v182']){$problem[]=$value['v182'];}
						$problem_code = implode(',',$problem);
						
						if($value['v184']){$help[]=$value['v184'];}
						if($value['v185']){$help[]=$value['v185'];}
						if($value['v186']){$help[]=$value['v186'];}
						if($value['v187']){$help[]=$value['v187'];}
						if($value['v188']){$help[]=$value['v188'];}
						if($value['v189']){$help[]=$value['v189'];}
						if($value['v190']){$help[]=$value['v190'];}
						if($value['v191']){$help[]=$value['v191'];}
						if($value['v192']){$help[]=$value['v192'];}
						if($value['v193']){$help[]=$value['v193'];}
						$help_code = implode(',',$help);

					}
					elseif($row['eq_type']==2)
					{
						if($value['v199']){$problem[]=$value['v199'];}
						if($value['v200']){$problem[]=$value['v200'];}
						if($value['v201']){$problem[]=$value['v201'];}
						if($value['v202']){$problem[]=$value['v202'];}
						if($value['v203']){$problem[]=$value['v203'];}
						if($value['v204']){$problem[]=$value['v204'];}
						if($value['v205']){$problem[]=$value['v205'];}
						if($value['v206']){$problem[]=$value['v206'];}
						if($value['v207']){$problem[]=$value['v207'];}
						if($value['v208']){$problem[]=$value['v208'];}
						if($value['v209']){$problem[]=$value['v209'];}
						if($value['v210']){$problem[]=$value['v210'];}
						if($value['v211']){$problem[]=$value['v211'];}
						if($value['v212']){$problem[]=$value['v212'];}
						if($value['v213']){$problem[]=$value['v213'];}
						if($value['v214']){$problem[]=$value['v214'];}
						if($value['v215']){$problem[]=$value['v215'];}
						if($value['v216']){$problem[]=$value['v216'];}
						if($value['v217']){$problem[]=$value['v217'];}
						$problem_code = implode(',',$problem);
						
						if($value['v219']){$help[]=$value['v219'];}
						if($value['v220']){$help[]=$value['v220'];}
						if($value['v221']){$help[]=$value['v221'];}
						if($value['v222']){$help[]=$value['v222'];}
						if($value['v223']){$help[]=$value['v223'];}
						if($value['v224']){$help[]=$value['v224'];}
						if($value['v225']){$help[]=$value['v225'];}
						if($value['v226']){$help[]=$value['v226'];}
						if($value['v227']){$help[]=$value['v227'];}
						$help_code = implode(',',$help);
					}
					elseif($row['eq_type']==3)
					{
						if($value['v233']){$problem[]=$value['v233'];}
						if($value['v234']){$problem[]=$value['v234'];}
						if($value['v235']){$problem[]=$value['v235'];}
						if($value['v236']){$problem[]=$value['v236'];}
						if($value['v237']){$problem[]=$value['v237'];}
						if($value['v238']){$problem[]=$value['v238'];}
						if($value['v239']){$problem[]=$value['v239'];}
						if($value['v240']){$problem[]=$value['v240'];}
						if($value['v241']){$problem[]=$value['v241'];}
						if($value['v242']){$problem[]=$value['v242'];}
						if($value['v243']){$problem[]=$value['v243'];}
						if($value['v244']){$problem[]=$value['v244'];}
						if($value['v245']){$problem[]=$value['v245'];}
						if($value['v246']){$problem[]=$value['v246'];}
						$problem_code = implode(',',$problem);
						
						if($value['v248']){$help[]=$value['v248'];}
						if($value['v249']){$help[]=$value['v249'];}
						if($value['v250']){$help[]=$value['v250'];}
						if($value['v251']){$help[]=$value['v251'];}
						if($value['v252']){$help[]=$value['v252'];}
						if($value['v253']){$help[]=$value['v253'];}
						if($value['v254']){$help[]=$value['v254'];}
						if($value['v255']){$help[]=$value['v255'];}
						if($value['v256']){$help[]=$value['v256'];}
						if($value['v257']){$help[]=$value['v257'];}
						if($value['v258']){$help[]=$value['v258'];}
						$help_code = implode(',',$help);
					}
					elseif($row['eq_type']==4)
					{
						if($value['v264']){$problem[]=$value['v264'];}
						if($value['v265']){$problem[]=$value['v265'];}
						if($value['v266']){$problem[]=$value['v266'];}
						if($value['v267']){$problem[]=$value['v267'];}
						if($value['v268']){$problem[]=$value['v268'];}
						if($value['v269']){$problem[]=$value['v269'];}
						if($value['v270']){$problem[]=$value['v270'];}
						if($value['v271']){$problem[]=$value['v271'];}
						if($value['v272']){$problem[]=$value['v272'];}
						if($value['v273']){$problem[]=$value['v273'];}
						if($value['v274']){$problem[]=$value['v274'];}
						if($value['v275']){$problem[]=$value['v275'];}
						if($value['v276']){$problem[]=$value['v276'];}
						if($value['v277']){$problem[]=$value['v277'];}
						if($value['v278']){$problem[]=$value['v278'];}
						if($value['v279']){$problem[]=$value['v279'];}
						if($value['v280']){$problem[]=$value['v280'];}
						if($value['v281']){$problem[]=$value['v281'];}
						if($value['v282']){$problem[]=$value['v282'];}
						$problem_code = implode(',',$problem);
						
						if($value['v284']){$help[]=$value['v284'];}
						if($value['v285']){$help[]=$value['v285'];}
						if($value['v286']){$help[]=$value['v286'];}
						if($value['v287']){$help[]=$value['v287'];}
						if($value['v288']){$help[]=$value['v288'];}
						if($value['v289']){$help[]=$value['v289'];}
						if($value['v290']){$help[]=$value['v290'];}
						if($value['v291']){$help[]=$value['v291'];}
						if($value['v292']){$help[]=$value['v292'];}
						if($value['v293']){$help[]=$value['v293'];}
						if($value['v294']){$help[]=$value['v294'];}	
						if($value['v295']){$help[]=$value['v295'];}
						if($value['v296']){$help[]=$value['v296'];}
						$help_code = implode(',',$help);
					}
					elseif($row['eq_type']==5)
					{
						if($value['v302']){$problem[]=$value['v302'];}
						if($value['v303']){$problem[]=$value['v303'];}
						if($value['v304']){$problem[]=$value['v304'];}
						if($value['v305']){$problem[]=$value['v305'];}
						if($value['v306']){$problem[]=$value['v306'];}
						if($value['v307']){$problem[]=$value['v307'];}
						if($value['v308']){$problem[]=$value['v308'];}
						if($value['v309']){$problem[]=$value['v309'];}
						if($value['v310']){$problem[]=$value['v310'];}
						if($value['v311']){$problem[]=$value['v311'];}
						if($value['v312']){$problem[]=$value['v312'];}
						if($value['v313']){$problem[]=$value['v313'];}
						if($value['v314']){$problem[]=$value['v314'];}
						if($value['v315']){$problem[]=$value['v315'];}
						if($value['v316']){$problem[]=$value['v316'];}
						if($value['v317']){$problem[]=$value['v317'];}
						if($value['v318']){$problem[]=$value['v318'];}
						if($value['v319']){$problem[]=$value['v319'];}
						$problem_code = implode(',',$problem);
						
						if($value['v321']){$help[]=$value['v321'];}
						if($value['v322']){$help[]=$value['v322'];}
						if($value['v323']){$help[]=$value['v323'];}
						if($value['v324']){$help[]=$value['v324'];}
						if($value['v325']){$help[]=$value['v325'];}
						if($value['v326']){$help[]=$value['v326'];}
						if($value['v327']){$help[]=$value['v327'];}
						if($value['v328']){$help[]=$value['v328'];}
						if($value['v329']){$help[]=$value['v329'];}
						if($value['v330']){$help[]=$value['v330'];}	
						if($value['v331']){$help[]=$value['v331'];}
						if($value['v332']){$help[]=$value['v332'];}
						if($value['v333']){$help[]=$value['v333'];}
						if($value['v334']){$help[]=$value['v334'];}
						if($value['v335']){$help[]=$value['v335'];}
						if($value['v336']){$help[]=$value['v336'];}
						if($value['v337']){$help[]=$value['v337'];}
						if($value['v338']){$help[]=$value['v338'];}
						if($value['v339']){$help[]=$value['v339'];}
						if($value['v340']){$help[]=$value['v340'];}
						if($value['v341']){$help[]=$value['v341'];}
						if($value['v342']){$help[]=$value['v342'];}
						$help_code = implode(',',$help);
					}
				
				?>
                <tr <? if ($row['eq_type'] == $_GET['report_type']){  echo ' style="background-color:#F9FDC4" ';} ?>>
				  <td align="center" valign="top" ><?php echo replacepin($row['eq_idcard']); ?></td>
                  <td align="center" valign="top"  style="padding:0px;">

				  
<table width="100%" border="0">
  <tr>
<? if ($row['eq_type'] == $_GET['report_type']){ echo "<td><img src='images/trues.png'  border='0' width='25' style='margin-bottom:7px;'/></td>";}?>
    <td align="center" valign="middle"><?php echo $con->chkImg($row['eq_type'],'../../'); ?></td>
  </tr>
</table>
	  
				   </td>
                  <td align="left" valign="top" ><?php echo $row['eq_prename'].$row['eq_firstname'].' '.$row['eq_lastname']; ?></td>
				  <td align="center" valign="top" ><?php echo $row['eq_age']; ?></td>
                  <td align="center" valign="top" ><?php echo $row['eq_relation']; ?></td><?php //echo $row['eq_relation']; ?>
                  <td align="center" valign="top" ><?php echo $row['eq_education']; ?></td>
                  <td align="left" valign="top" ><?php
							 $x=$problem_code;
							 $i = 0;
							 if(($x!='')or($x!=NULL))
							 {
								$sql_2 = "SELECT problem_level,problem_detail FROM `question_problem` where problem_level IN(".$x.") AND problem_type = ".$row['eq_type']." order by problem_level asc";
								$det_problem = $con->select($sql_2);
								$all = count($det_problem);
								foreach($det_problem as $rd){
									$i++;
									if ($all != 1){ echo $i.' ';}
									echo $rd['problem_detail']."</br>";
							 }
							}
						?></td>
                  <td align="left"  valign="top">
                  
                  <?php
								$b = $help_code;
								$i = 0;
								if(($b!='')or($b!=NULL))
								{
									$sql_3 = "SELECT help_detail,help_level FROM `question_help` where help_level IN(".$b.") AND help_type = ".$row['eq_type']." order by help_level asc";
									$det_help = $con->select($sql_3);
								$all = count($det_help);
									foreach($det_help as $hd){
										$i++;
									if ($all != 1){ echo $i.' ';}
										echo $hd['help_detail']."</br>";
									} 
								}
							?>
                  
                  </td>
                </tr>
                <?php } ?>
            </table>
            
            </td>
          </tr>
        </table></td>
      </tr>
    </table>

	</div>

</div>



