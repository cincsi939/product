<?
$array_logerror=array();

function getuser2($site,$idcard,$salarybefor="0"){
	global $tbl_general;
 $sql="SELECT CZ_ID,prename_th,name_th,surname_th,prename_th,salary,vitaya FROM $tbl_general where"; 
 $sql.=" CZ_ID='$idcard'"; 
 $result=mysql_db_query("edubkk_$site",$sql);
 //echo $sql."<br>";
 
 if(mysql_num_rows($result)>0){ 
      $rows_person=mysql_fetch_array($result);
       $sname=$rows_person[name_th].":".$rows_person[surname_th].":".$rows_person[salary].":".$rows_person[vitaya];
	   if($salarybefor){$befor_salary=getbeforsalary($site,$idcard,$rows_person[salary]);}
      return $sname.":".$befor_salary.":".$rows_person[prename_th];
      break; 
 }else{
      return "";
 }
}//end function getuser2($site,$idcard,$salarybefor="0"){
	
	
function date_eng($date,$add=0){
	global $tbl_general;
     if($date!=""){
         $date=substr($date,0,10);
         list($year,$month,$day) = split('[/.-]', $date);
		 
         return   ($year+$add)."-".$month."-".$day ;
     }else{
          return "";
     }
 }//end function date_eng($date,$add=0){


function checkImport($siteid,$obec_schoolid,$obec_position_id,$obec_post_code,$obec_position_name,$obec_idcard,$obec_salary,$obec_radub_id,$obec_radub_name,$obec_bdate,$nid="",$idcardtemp,$xadd="1",$befor_salary="",$lv="",$use_money="",$special_money="",$status_outsite="",$outsite="",$outsite_schoolid="",$upsalary=0){
global $tbl_general;
global $tbl_j18_group;
global $tbl_j18_position;
    $db="edubkk_$siteid";
    $sqlinsert="";
    $dbmasster=DB_MASTER;	
	$str=getuser2($siteid,$idcardtemp);
    $obec_bdate =date_eng(substr($obec_bdate,0,10),543);   
    $arr=explode(":",$str) ;
    //ตรวสสอบเลขที่ตำแหน่ง ตรงกัน
    $sql="select *,CZ_ID as  idcard from $tbl_general as general where RTRIM(REPLACE(noposition,' ',''))='$obec_position_id' and schoolid='$obec_schoolid'"; 
    $result=mysql_db_query($db,$sql); 
    if(mysql_num_rows($result)>0){
        //มี idcard หรือป่าว
       if($obec_idcard!=""){
           $sql="select *,CZ_ID as  idcard from $tbl_general as general where RTRIM(REPLACE(noposition,' ',''))='$obec_position_id'and schoolid='$obec_schoolid'  and CZ_ID='$obec_idcard'";
         //   echo $sql."<br>";
           $result=mysql_db_query($db,$sql); 
            if(mysql_num_rows($result)>0){  //idcard ตรงป่าว 
                $row=mysql_fetch_array($result);
				$nowsalary=($upsalary>0)?$upsalary:$row[salary];
                if($row[salary]>$obec_salary){
               	 	 $xsalary = $nowsalary;
                }else{
               		 $xsalary = $obec_salary;
                }
				
				
                 $sqlinsert="set school_id='$obec_schoolid',
                  position_id='$obec_position_id',
                  post_code='$obec_post_code',
                  position_name='$obec_position_name',                  
                  radub_name='$obec_radub_name',
                  radub_id='$obec_radub_id',
                  CZ_ID='$row[idcard]',
                  salary='$nowsalary',salary_position ='$xsalary',CZ_ID_POBEC='$idcardtemp',modulename='checkImport มี idcard'" ;
				  $reval="$row[idcard]"; 
            }else{              
              
              $sql="select *,CZ_ID as  idcard  from $tbl_general as general where RTRIM(REPLACE(noposition,' ',''))='$obec_position_id'and schoolid='$obec_schoolid' and name_th='$arr[0]' and surname_th='$arr[1]' and birthday='$obec_bdate'";
			  $obec_idcard="";
              $result=mysql_db_query($db,$sql);
                if(mysql_num_rows($result)>0){
                $nowsalary=($upsalary>0)?$upsalary:$row[salary];
                if($row[salary]>$obec_salary){
               	 	 $xsalary = $nowsalary;
                }else{
               		 $xsalary = $obec_salary;
                } 
                 $sqlinsert="set school_id='$obec_schoolid',
                  position_id='$obec_position_id',
                  post_code='$obec_post_code',
                  position_name='$obec_position_name',                  
                  radub_name='$obec_radub_name',
                  radub_id='$obec_radub_id',
                  CZ_ID='$row[idcard]',
                  salary='$nowsalary',salary_position ='$xsalary',CZ_ID_POBEC='$idcardtemp',modulename='checkImport มี idcard แต่ค้นหา id นี้ไม่เจอ '" ; 
				  $reval="$row[idcard]"; 
              }
            }  // position_id='$row[noposition]', 
     }  
    }else{ //ไม่พบ
        $sql="select *,CZ_ID as  idcard  from $tbl_general as general where CZ_ID='$obec_idcard' and schoolid='$obec_schoolid' and name_th='$arr[0]' and surname_th='$arr[1]' and birthday='$obec_bdate'";
		//echo $sql."<br>";
		      $obec_idcard="";
              $result=mysql_db_query($db,$sql);
              if(mysql_num_rows($result)>0){
                 $row=mysql_fetch_array($result); 
                $nowsalary=($upsalary>0)?$upsalary:$row[salary];
                if($row[salary]>$obec_salary){
               	 	 $xsalary = $nowsalary;
                }else{
               		 $xsalary = $obec_salary;
                }
                 $sqlinsert="set school_id='$obec_schoolid',
                  position_id='$obec_position_id',
                  post_code='$obec_post_code',
                  position_name='$obec_position_name',                  
                  radub_name='$obec_radub_name',
                  radub_id='$obec_radub_id',
                  CZ_ID='$row[idcard]',
                  salary='$nowsalary',salary_position ='$xsalary',CZ_ID_POBEC='$idcardtemp',modulename='checkImport กรณีไม่พบ'" ; 
				  $reval="$row[idcard]"; 
              }      
    } //end if 
    
     
   if($sqlinsert==""){// กรณีไม่เข้าเงื่อไขไดๆ
      $str=getuser2($siteid,$idcardtemp);
      if($str==""){
         $obec_idcard="";
      }else{
	  $obec_idcard="$idcardtemp";
	  }
	   $nowsalary=($upsalary>0)?$upsalary:$row[salary];
      $sqlinsert="set school_id='$obec_schoolid',
                  position_id='$obec_position_id',
                  post_code='$obec_post_code',
                  position_name='$obec_position_name',                  
                  radub_name='$obec_radub_name',
                  radub_id='$obec_radub_id',                  
                  CZ_ID='$obec_idcard',
                   salary='$nowsalary',salary_position='$obec_salary',CZ_ID_POBEC='$idcardtemp',time_stmp=NOW(),modulename='checkImport กรณีไม่เข้าเงื่อไขไดๆ '" ;
    $reval="0";
   } 
   
   if($befor_salary!=""){
     $sqlinsert.=",salary_position_be='$befor_salary',lv='$lv',use_money='$use_money',special_money='$special_money'"  ;

   }
    if($status_outsite!=""){
     $sqlinsert.=",status_outsite='$status_outsite',outsite='$outsite',outsite_school='$outsite_schoolid'"  ;
   }  
   
     if($nid==""){
		
       $sqlinsert="insert $tbl_j18_position ".$sqlinsert ; 
	   if($xadd=="1"){
		 
		    mysql_db_query($db,$sqlinsert)or die(mysql_error()); 
		   }
     }else{
		 
        $sqlinsert="update $tbl_j18_position ".$sqlinsert ." where nid='$nid'"  ;
        mysql_db_query($db,$sqlinsert); 
     } 
 
  
  
 //echo "$reval = $db:".$sqlinsert."<br>"; 
 // $sql="insert into j18_position_log(CZ_ID,str_sql) values('$idcardtemp','$sqlinsert')";
//  mysql_db_query($db,$sql); 
 return $reval;     
}//end function checkImport($siteid,$obec_schoolid,$obec_position_id,$obec_post_code,$obec_position_name,$obec_idcard,$obec_salary,$obec_radub_id,$obec_radub_name,$obec_bdate,$nid="",$idcardtemp,$xadd="1",$befor_salary="",$lv="",$use_money="",$special_money="",$status_outsite="",$outsite="",$outsite_schoolid="",$upsalary=0){
	
function Create_Table($Siteid){
$db_site  =STR_PREFIX_DB.$Siteid; 
//$Sql_Table=" DROP TABLE  j18_group ";
//$result=mysql_db_query($db_site,$Sql_Table) ;  

 $Sql_Table="CREATE TABLE IF NOT EXISTS `j18_group` (
  `nid` int(11) NOT NULL auto_increment,
  `school_id` varchar(12) default NULL,
  `i_code` varchar(16) default NULL,
  `office` varchar(200) default NULL,
  `remark` varchar(255) default NULL,
  `temp_id` int(11) default NULL,
  `n_year` int(4) default NULL,
  PRIMARY KEY  (`nid`),
  KEY `index_1` (`nid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=tis620";
 
 $result=mysql_db_query($db_site,$Sql_Table) ;
############################################################
 //$Sql_Table=" DROP TABLE  j18_position ";
 //$result=mysql_db_query($db_site,$Sql_Table) ; 
 $Sql_Table="CREATE TABLE IF NOT EXISTS `j18_position` (
  `nid` int(11) NOT NULL auto_increment,
  `school_id` varchar(11) default NULL COMMENT 'รหัสหน่วยงาน',
  `position_id` varchar(11) default NULL COMMENT 'เลขที่ตำแหน่ง',
  `post_code` varchar(11) default NULL COMMENT 'รหัสตำแหน่ง',
  `position_name` varchar(255) default NULL COMMENT 'ตำแหน่ง',
  `radub_id` varchar(50) default NULL COMMENT 'รหัสระดับ',
  `radub_name` varchar(255) default NULL COMMENT 'ชื่อระดับ',
  `CZ_ID` varchar(13) default NULL COMMENT 'เลขบัตร',
  `salary` int(11) default NULL COMMENT 'เงินเดือน',
  `CZ_ID_POBEC` varchar(13) default NULL COMMENT 'เลขบัตร pobe',
  `salary_position` int(11) default NULL,
  `position_locked` int(1) default '0' COMMENT '0=ใช้งานได้ 1=ใช้งานไม่ได้',
  `date_retire` datetime default NULL,
  `time_stmp` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `modulename` varchar(255) default NULL,
  `status_outsite` varchar(1) default NULL,
  `outsite` varchar(10) default NULL,
  `outsite_school` varchar(11) default NULL,
  `radub_id_be` varchar(255) default NULL,
  `radub_name_be` varchar(255) default NULL,
  `salary_position_be` float default NULL,
  `lv` float default NULL,
  `use_money` float default NULL,
  `special_money` float default NULL,
  PRIMARY KEY  (`nid`),
  KEY `index_1` (`nid`),
  KEY `index_CZ_ID` (`CZ_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=tis620  ";
 $result=mysql_db_query($db_site,$Sql_Table) ; 
     
}
function deleteall_rec($Siteid){
	global $tbl_j18_group,$tbl_j18_position;
    $db_site  =STR_PREFIX_DB.$Siteid; 
    $result=mysql_db_query($db_site,"truncate table $tbl_j18_group");
    $result=mysql_db_query($db_site,"truncate table $tbl_j18_position" );  
}
function get_general_match_id_pobec($siteid,$idcode){
    $sql="SELECT id_cmss as id,   id_pobec  FROM general_match_id_pobec where id_pobec='$idcode'";
    $result=mysql_db_query(STR_PREFIX_DB.$siteid,$sql);
    $row= mysql_fetch_array($result); 
    return $row[id];
     mysql_free_result($result);  
}


function Import_Data($Siteid){
	  global $tbl_j18_group,$tbl_j18_position;   
	 $db_site  =STR_PREFIX_DB.$Siteid;
	 $db_obec  ="temp_pobec_import"; 
	 $db_master=DB_MASTER;  
	 $sql="SELECT id,office,siteid,i_code FROM allschool where siteid='$Siteid'  and i_code<>'' order by id ";
	 $result_master=mysql_db_query($db_master,$sql);
	 while($row=mysql_fetch_array($result_master)){ 
		 
		$sql_chkpobec="SELECT count(N_POSITION) as nnum FROM pobec_$Siteid where I_CODE='$row[i_code]'";  
	   // echo   $sql_chkpobec;
		 $result=mysql_db_query($db_obec,$sql_chkpobec);
		 $rowcount =mysql_fetch_array($result);
		if($rowcount[nnum]>0){//ตรวจสอบว่ามีอัตราหรือป่าว 
		 $sql_chk="select count(nid) as nnum from  $tbl_j18_group as j18_group where school_id='$row[id]'";
		 $result=mysql_db_query($db_site,$sql_chk);
		 $rowdata =mysql_fetch_array($result);
		 if($rowdata[nnum]>0){
			$sql_ins=" update $tbl_j18_group  set i_code='$row[i_code]',office='$row[office]' where school_id='$row[id]'";   
		 }else{
			$sql_ins=" insert into $tbl_j18_group set school_id='$row[id]', i_code='$row[i_code]',office='$row[office]'";   
		 } //end    if($rowdata[nnum]>0){
		 $result=mysql_db_query($db_site,$sql_ins); 
		 
		 if($result){import_position($Siteid,$row[id],$row[office])  ; } // map คน=ตำแหน่ง ใน temp_pobec
		} //end  if($rowcount[nnum]>0){
	 }//end  while($row=mysql_fetch_array($result_master)){ 
	 return true;
} //end  function Import_Data($Siteid){

function import_position($Siteid,$schoolid,$schoolname){
  global $array_logerror,$temp_pobec_import;
  $db_site  =STR_PREFIX_DB.$Siteid;
  $table_pobec  ="pobec_".$Siteid;   
  $db_master=DB_MASTER;  
  $sql_schoolid="SELECT distinct  i_code FROM allschool  where id='$schoolid' and siteid='$Siteid' ";
//	echo $sql_schoolid;			  
  $result_school=mysql_db_query($db_master,$sql_schoolid) ;
  while($row_school=mysql_fetch_array($result_school)){
    $I_CODE=$row_school[i_code];
   /* $sql="SELECT postcode.POST_CODE, $table_pobec.N_POSITION,$table_pobec.IDCODE, $table_pobec.I_CODE,postcode.PP_NAME ,$table_pobec.N_RATE
FROM  $table_pobec  Inner Join postcode ON $table_pobec.POST_CODE = postcode.POST_CODE WHERE $table_pobec.I_CODE='$I_CODE'";    */
    $sql="SELECT DISTINCT pobec.N_POSITION,postcode.PP_NAME,postcode.POST_NAME,pobec.N_RATE,pobec.N_PATH,typerate.TYPEGROUP,pobec.IDCODE,pobec.I_CODE  ,pobec.DATE_B
          FROM postcode 
          right Join $table_pobec as pobec ON postcode.POST_CODE = pobec.POST_CODE 
          left Join typerate ON pobec.N_PATH = typerate.N_PATH WHERE pobec.I_CODE='$I_CODE'";
		  //echo $sql."<br>";
        $result=mysql_db_query($temp_pobec_import,$sql) ;
        $nnum=mysql_num_rows($result);             
        if($nnum>0){               
			while($row=mysql_fetch_array($result)){
			$idcode=get_general_match_id_pobec($Siteid,$row[IDCODE]);  
			$sql_chk=" select * from  $tbl_j18_position as j18_position where school_id='$schoolid' and position_id='$row[N_POSITION]'";
			$result_chk=mysql_db_query($db_site,$sql_chk) ;
			   if(trim($row[N_POSITION])!=""){          
						if(mysql_num_rows($result_chk) < 1){           
						 $vowels = array(" ", ".");
							$N_POSITION = str_replace($vowels, "", $row[N_POSITION]);  
						   checkImport($Siteid,$schoolid,$N_POSITION,$row[POST_CODE],$row[PP_NAME],$idcode,$row[N_RATE],$row[N_PATH],$row[TYPEGROUP],$row[DATE_B],"",$row[IDCODE]) ;
						}//end  if(mysql_num_rows($result_chk) < 1){   
				} //end    if(trim($row[N_POSITION])!=""){    
			}//end  while($row=mysql_fetch_array($result)){
		}else{ //หาไม่เจอเก็บไว้ใน array_logerror 
 //addlog: 
     if($I_CODE!=""){
      //  $strerr=  $sql  ;
         $strerr="ไม่พบรหัสตำแหน่ง";
     }else{
         $strerr="ไม่พบรหัสหน่วยงานใน POBEC";
     } //end   if($I_CODE!=""){
          $array_logerror[]=array(schoolid=>$schoolid,schoolname=>$schoolname,id_code=>$I_CODE,desc=>"$strerr");
        }//end   if($nnum>0){  
    }// end  while($row_school=mysql_fetch_array($result_school)){
    
}//end function import_position($Siteid,$schoolid,$schoolname){
	
################  function ตรวจสอบบัญชี จ.18 ก่อนการนำเข้าข้อมูล จ. 18
function CheckNumJ18($siteid){
	$db_site = STR_PREFIX_DB.$siteid;
	$sql = "SELECT COUNT(nid) AS NUM1 FROM j18_position";
	$result = @mysql_db_query($db_site,$sql);
	$rs = @mysql_fetch_assoc($result);
	return $rs[NUM1];
}//end function CheckNumJ18($siteid,$schoolid=""){
	
#####################  
function ProcessImpJ18($xsite){

	  Create_Table($xsite);
      if($del=='1'){deleteall_rec($xsite);}
      if(Import_Data($xsite)){       
          
          if(count($array_logerror)>0){
			echo"<table width=\"98%\"><tr><td bgcolor=\"#000\" cellspacing=\"1\" cellpadding=\"1\"> ";  			
            echo"<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" >  ";
            echo"<tr height=\"30\">";
            echo"<td colspan=\"5\" align=\"center\" bgcolor=\"#A5B2CE\"><strong>รายชื่อ รายการที่นำเข้าข้อมูลไม่ได้</strong></td> ";
            echo"</tr>";
            echo"<tr height=\"30\">";
            echo"<td width=\"10%\" align=\"center\" bgcolor=\"#A5B2CE\"><strong>ลำดับ</strong></td> ";
            echo"<td width=\"15%\" align=\"center\" bgcolor=\"#A5B2CE\"><strong>รหัสหน่วยงาน</strong></td> ";
            echo"<td width=\"20%\" align=\"center\" bgcolor=\"#A5B2CE\"><strong>ชื่อหน่วยงาน</strong></td> ";
            echo"<td width=\"15%\" align=\"center\" bgcolor=\"#A5B2CE\"><strong>รหัสหน่วยงาน(POBEC)</strong></td> ";
            echo"<td width=\"30%\" align=\"center\" bgcolor=\"#A5B2CE\"><strong>รายละเอียด</strong></td> "; 
            echo"</tr> ";
		$bg="bgcolor=''";	
				foreach($array_logerror as $key=>$values){ 
				if($bg=="bgcolor='#EFEFEF'"){$bg="bgcolor='#FFFFFF'";}else{$bg="bgcolor='#EFEFEF'";}
					echo"<tr $bg height=\"20\"> ";
					echo"<td align=\"center\">".($key+1)."</td> ";
					echo"<td align=\"center\">$values[schoolid]</td> ";
					echo"<td>$values[schoolname]</td>  ";
					echo"<td align=\"center\">$values[id_code]</td>  ";
					echo"<td align=\"center\">$values[desc]</td>  "; 
					echo"</tr> ";
				} //end  foreach($array_logerror as $key=>$values){ 
            echo"</table> ";
			echo"</td></tr></table> ";
          }//end  if(count($array_logerror)>0){
      } //end  if(Import_Data($xsite)){   
   
}//end function ProcessImpJ18($xsite){
	
function ListCondition_tranfer(){
	global $dbnamemaster;
	$sql="SELECT
	t1.config_field_name,
	t1.config_value
	FROM
	config_tranfer_cmss AS t1
	WHERE t1.config_status='Y'
	ORDER BY t1.config_id";
	$rs=mysql_db_query($dbnamemaster,$sql);
	$num=1; $numrow=mysql_num_rows($rs);
	while($row=mysql_fetch_assoc($rs)){
		if($num==1){
			$if=$row[config_value];
		}else{
			$if.=" AND ".$row[config_value];
		}
		$num++;
	}
	return $if;
}
?>