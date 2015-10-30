<?php
$arrayTable=array(general_pic=>"id",
                  getroyal=>"id",
                  goodman=>"id",
                  graduate=>"id",
                  hr_absent=>"id",
                  hr_nosalary=>"id",
                  hr_other=>"id",
                  hr_prohibit=>"id",
                  hr_specialduty=>"id",
                  hr_teaching=>"id",
                  req_print_kp7=>"id",
                  salary=>"id",
                  seminar=>"id",
                  seminar_form=>"id",
                  special=>"id",
                  general=>"id",
                  sheet=>"id",
                  log_approve=>"general_id",
                  log_req_notapprove=>"general_id" ,
                  hr_addhistoryaddress=>"gen_id",
                  hr_addhistoryfathername=>"gen_id",
                  hr_addhistorymarry=>"gen_id",
                  hr_addhistorymothername=>"gen_id",
                  hr_addhistoryname =>"gen_id",
                  view_general=>"CZ_ID",
                 // logupdate_user_dd=>"idcard",
                 // logupdate_user_hh=>"idcard",
                //  logupdate_user_mm=>"idcard",
                  general=>"idcard"
              );
 function DelData($Table,$Keysindex,$link){   
          
  foreach ($Table as $keys => $value ){
     $strDel="DELETE FROM ".$keys. " WHERE " .$value." in (".$Keysindex.")"   ;
     
     $result=mysql_query($strDel,$link)or die("Error: ".mysql_error()."<br> SQL: ".$strDel ."<br> Line :". __LINE__) ;     
  } 
  
 }             
?>
