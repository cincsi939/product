<?php
    header("Content-Type: text/plain; charset=windows-874");
    $arr1=array('91254700','91254701','91254702','91254703','91254704','91254705') ;
    $arr2=array('ครูผู้ช่วย','คศ.1','คศ.2','คศ.3','คศ.4','คศ.5') ;   
    //ข้อมูลเกี่ยวกับฐานข้อมูลที่ใช้
	include ("../../../config/conndb_nonsession.inc.php")  ;
  //$xidcard='1179900025145';$xsiteid='5001';$level_new='91254702' ;  
  	$sql_select = "SELECT CZ_ID,level_id,radub  FROM `view_general` where  CZ_ID='$xidcard' ";
  // get $level_new="";
  // get $radub_new="";

   $index_new=array_search($level_new,$arr1);
    if($index_new===false){
            echo"empty";
    }else{
        $result1= mysql_db_query( STR_PREFIX_DB."$xsiteid",$sql_select );     
        if($result1){
            $row=mysql_fetch_array($result1);
            if($row[level_id]!=""){
               $index=array_search($row[level_id],$arr1);
            }else{
               $index=array_search($row[radub],$arr2); 
            }
            if($index===false){
                echo"empty";
            }else{
                 if($index==$index_new)   {
                   echo"ok";
                }elseif($index+1<$index_new)   {
                   echo"no:เลือกระดับข้ามขั้นที่ควรจะได้  เช่น $arr2[$index] ระดับต่อไปที่ควรจะได้คือ". $arr2[$index+1];
                }else{
                     echo"ok";
                }
            }      
            
        }else{
         echo "error query ".mysql_error();
        }        
           // ปิดการเชื่อมต่อ
           mysql_close();
    }
?>