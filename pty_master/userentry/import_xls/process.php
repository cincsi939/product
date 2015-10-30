<?php
header ("Content-Type: text/html; charset=tis-620"); 
set_time_limit(0) ;
include('root_path.php');
include ("../../../common/std_function.inc.php") ;
include ("../../../common/common.inc.php") ; 
//include ("../../../config/conndb_nonsession.inc.php") ;  
//include ("date_function.php") ;   
include ("deletedata.php") ;
include "../epm.inc.php";
if(isset($_POST['secid'])){$secid = $_POST['secid'];}else{$secid="";}  
if (isset($_GET['process'])){$process=$_GET['process'];}else{$process="";}  
#=================================
//$secid='5001';   //ต้องเอาออก khuan
#================================
$dbsite =STR_PREFIX_DB. $secid;

ini_set("memory_limit","64M") ;
ini_set('upload_max_filesize',8000000);
require_once 'Excel/reader.php'; 
//
function CheckIDCard($StrID){
    if(strlen($StrID)==13){
    $id=str_split($StrID); 
    $sum=0;    
    for($i=0; $i < 12; $i++){
         $sum += floatval($id[$i])*(13-$i); 
    }   
    if((11-$sum%11)%10!=floatval($id[12])){
         return false;
    }else{
         return true; 
    }
}else{
    return false;
}   
}

function chkFormatDate( $year,$month,$day )
    {
        if( preg_match( '`^\d{1,2}-\d{1,2}-\d{4}$`' , $day."-".$month."-".$year )){
              return checkdate($month,$day,$year);               
        }else{
            return false; 
        }  
        
    }

function DateDiff($strDate1,$strDate2){ //yyyy-mm-dd              
    return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24     
} 
 function TimeDiff($strTime1,$strTime2){              
    return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60     
}    
function DateTimeDiff($strDateTime1,$strDateTime2){               
    return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60     
}

function ChkdateBegin($xdate,$xbirth){
list($year_start,$month_start,$day_start) = split('[/.-]', $xdate);
list($year_birth,$month_birth,$day_birth) = split( '[/.-]', $xbirth); 
list($year_now,$month_now,$day_now) = split('[/.-]',  date("Y/m/d")  );
$date1=$year_start.'-'.$month_start.'-'.$day_start; 
$returnvalue=array(err=>"",strdate=>$date1) ; 
$date2=$year_now.'-'.$month_now.'-'.$day_now;  
$datediff_now= DateDiff($date1 ,$date2)  ; 
if($datediff_now<0){
   $returnvalue['err']="T2" ;   
}else{
     $date2=$year_birth.'-'.$month_birth.'-'.$day_birth;     
     $datediff_birth=  intval(DateDiff($date2 ,$date1)/365)  ;      
     if($datediff_birth<15){ 
        $returnvalue['err']="T1" ;  
     }else{
       $returnvalue['err']="";
     }
    
}  
    
    return  $returnvalue;   
}
function convertDateE2T2($xdate,$strPatten){//return dd/mm/yyyy +543
if($xdate!="") {
  list($year_start,$month_start,$day_start) = split('[/.-]', $xdate); 
    if( chkFormatDate($year_start,$month_start,$day_start) ) {
         return ($year_start+543).$strPatten .$month_start.$strPatten.$day_start  ; 
    }else{
         return""; 
    } 
 }else{
 return"";          
}    }

function convertDateE2T($xdate,$strPatten){//return dd/mm/yyyy +543
if($xdate!="") {
    list($year_start,$month_start,$day_start) = split('[/.-]', $xdate);  
      if( chkFormatDate($year_start,$month_start,$day_start) ) {
        return $day_start.$strPatten.$month_start.$strPatten.($year_start+543)  ;
      }else{
          return""; 
      }
    
}else{
 return"";
}
}
function convertDateT2E($xdate,$strPatten){ //return yyyy-543/mm/dd  
if($xdate!="") {
  list($day_start,$month_start,$year_start) = split('[/.-]', $xdate); 
    if( chkFormatDate($year_start,$month_start,$day_start) ) {
         return ($year_start-543).$strPatten .$month_start.$strPatten.$day_start  ; 
    }else{
         return""; 
    } 
 }else{
 return"";
}
}

function getconnection($secid,$db_name,$username, $password,$dbnamemaster) {
     //   $sql="SELECT    area_info.IP  FROM     ".DB_MASTER.".eduarea  INNER JOIN  ".DB_MASTER.".area_info     ON (eduarea.area_id = area_info.area_id) WHERE  eduarea.secid='".$secid."'";		
	//	$Result_area = mysql_db_query($dbnamemaster,$sql);
	//	$rs_area = mysql_fetch_array($Result_area);
	//	$server_name=$rs_area[IP];
        #==========================================
        $server_name="localhost";	
        #==========================================
	    $link =connectdb($server_name,$db_name,$username, $password);
        return  $link ;
	 } 
 
 function getdatebeginFormPOBEC($link,$tbl_name,$idcode) {        
        $sql="SELECT   IDCODE, DATE_F   FROM   ".$tbl_name . " WHERE IDCODE='". $idcode  ."'";	        			
			$Result_POBEC=	mysql_query($sql, $link);
				while($rs_POBEC = mysql_fetch_array($Result_POBEC)){ 					
					$date=$rs_POBEC[DATE_F];					
				}
				mysql_free_result( $Result_POBEC);                  
				return $date   ;
     }
         
function insertlog($userid,$secid,$servername,$db_name,$username,$password,$subject,$numcount,$xfile) {    
    $link =connectdb($servername,$db_name,$username, $password);
    $logtime = date("y-m-d h:i:s");        
    $sql="insert into logupdate_user_importslx(idcard,sec_id,subject,logtime,numcount,filename)";          
    $sql.="values('$userid','$secid','$subject',NOW(),'$numcount','$xfile')";
    $is= mysql_query($sql);        
}    
     
     
function GetRandomString($length){      
    $template = "1234567890abcdefghijklmnopqrstuvwxyz";      
    settype($length, "integer");
    settype($rndstring, "string");
    settype($a, "integer");
    settype($b, "integer");
      
    for ($a = 0; $a <= $length; $a++) {
        $b = mt_rand(0, strlen($template) - 1);
        $rndstring .= $template[$b];
    }
       
    return $rndstring;
}

function Getschool2array($sec_id,$dbnamemaster){ 
$sql="SELECT id , office  FROM   ".DB_MASTER.".allschool  WHERE siteid='$sec_id'" ;
$Result_office = mysql_db_query($dbnamemaster,$sql);
while($rs_office = mysql_fetch_array($Result_office)){
    $id=$rs_office[id];
    $office=$rs_office[office];    
    $officeArray[$id]=$office;
}
mysql_free_result( $Result_office); 
return $officeArray   ;}   
// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();  
// Set output Encoding.
$data->setOutputEncoding('TIS-620'); 
if($process!=""){


    
$sql="SELECT     secid, secname FROM  ".DB_MASTER.".eduarea WHERE secid not like '99%'";                                 
$Result = mysql_db_query($dbnamemaster,$sql);
$stroption.=  '<option value="0"><=กรุณาเลือกรายการ=></option> ';  
while($rs_ch = mysql_fetch_array($Result)){
$arreducation[$rs_ch[secid]]= $rs_ch[secname];
$stroption.=  '<option value="'. $rs_ch[secid].'">'.$rs_ch[secname].'</option> ';                                      
}    
$strtext="";
$arrschool=Getschool2array($secid,$dbnamemaster); 

$username="sapphire"; 
$password="sprd!@#$%";
$linkpobec=connectdb("localhost" ,"temp_pobec_import", $username, $password)  ; 
$link=getconnection($secid,$dbsite ,$username, $password,$dbnamemaster);
if($process=="execute"){

    $myfile = GetRandomString(7);
    while(is_file($myfile.".xls")){
        $myfile = GetRandomString(7);
    }
    $filename2= $_FILES['fileToUpload']['name'] ;
    
    //echo "$name<hr>";die;
    if(!copy($fileToUpload,"upload_tmp/".$myfile.".xls")){
        //cannot copy file
        echo "การอัพโหลดข้อมูล ผิดพลาด ไม่สามารถ Backup ไฟล์ $filename2 ได้";
        die;
    }else{
        //write log keyin
        chmod("upload_tmp/".$myfile.".xls", 0777); 
    }
$sent_file = $myfile.".xls";

$data->read('upload_tmp/'.$myfile.'.xls');

//$data->read('upload_tmp/xbdsqkpz.xls');
if(!count($data->sheets)){
    echo "&error_msg=ไม่สามารถอ่านข้อมูลในไฟล์ได้ อาจเป็นผลมาจากไฟลไม่ถูกต้อง หรือรูปแบบไฟล์ไม่ถูกต้อง";
    die;
}
//------------ start เช็คฟิลด์ ---------------------------------------------
$colume=array("idcard"=>"เลขบัตรประชาชน",
                "prename_th"=>"คำนำหน้านาม",
                "name_th"=>"ชื่อ",
                "surname_th"=>"สกุล",
                "birthday"=>"วัน เดือน ปี เกิด",
                "position_now"=>"ตำแหน่งล่าสุด",                
                "begindate"=>"วันเริ่มปฏิบัติราชการ",
                "schoolid"=>"สถานศึกษา/หน่วยงาน") ;
$rowstart=7;                   
$setstrartrow =$rowstart+2; 
$strdelx="";         
 for ($i = $setstrartrow ; $i < ($data->sheets[0]['numRows']) ; $i++) {   //rows  
 $index =trim($data->sheets[0]['cells'][$i][1]) ; 
  $colume_insert=array("id"=>"","idcard"=>"","prename_th"=>"","name_th"=>"","surname_th"=>"",
                    "birthday"=>"","position"=>"","position_now"=>"","schoolid"=>"","begindate"=>"","schooltext"=>"","chkidcard"=>"N","chkdate"=>"N") ;     
    for($j=0;$j<=$data->sheets[0]['numCols'];$j++){               //cols
            $valcol = trim($data->sheets[0]['cells'][$rowstart][$j]) ;           
            $colInArray =array_search( $valcol,$colume);
            $val="";   
            if($colInArray){ 
              $val=trim($data->sheets[0]['cells'][$i][$j]) ;        
              $colume_insert[$colInArray]=$val;			  
             //กรณีต้องการ set ค่าให้กับ filds อื่น 
              if ($colInArray=="idcard") {
                 $colume_insert["id"]=$val;	
                     if(strlen($strdelx)>0){$strdelx.=",";}	
                     	 $strdelx="'".$val."'";	
                    if(strlen($strdelx)>0){ 
                         DelData ($arrayTable,$strdelx,$link)  ;  //ลบข้อมูลคนที่มี idcard นี้
                    } 	   
              }
              elseif($colInArray=="position_now"){
                 $colume_insert["position"]=$val; 
              }
              elseif($colInArray=="birthday"){
                if($val!=""){ $colume_insert["birthday"]= convertDateT2E($val,"-") ;} 
              }
              elseif($colInArray=="begindate"){
                 if($val!=""){  $colume_insert["begindate"]= convertDateT2E($val,"-");} 
              }  
             elseif($colInArray=="schoolid"){
                 $colume_insert["schooltext"]= $colume_insert["schoolid"];                 
                 $strreplace= str_replace('สพท. ',"สำนักงานเขตพื้นที่การศึกษา",$val) ;   //ค้นหารหัสสถานศึกษา              
                 $Sid =array_search( $strreplace,$arreducation); 
                 if($Sid){
                    $colume_insert["schoolid"] =$Sid;
                 } 
                 else{ //ค้นหารหัสสถานศึกษา     อีกตารางหนึ่ง
                   $colume_insert["schoolid"]=array_search($strreplace,$arrschool);                    
                 }                
              }          
              
            }  
            
    }   
  //   check data
 $data_insert[] =$colume_insert ;
 unset($colume_insert); 
 } 
 unset($arrschool);
 unset($arreducation); 


 
 
}
elseif($process=="edit"){
    $idindex=$_POST['id'];
    $idcard=$_POST['idcard'];  
    $prename_th=$_POST['prename_th'];  
    $name_th=$_POST['name_th'];  
    $surname_th=$_POST['surname_th'];  
    $birthday=$_POST['birthday'];  
    $position=$_POST['position'];  
    $position_now=$_POST['position_now']; 
    $schoolid=$_POST['schoolid'];  
    $schooltext=$_POST['schoolname']; 
    $begindate=$_POST['begindate'];
    
    if(isset($_POST['chkid'])){$chkidcard=$_POST['chkid'];}  
    if(isset($_POST['chkdate'])){$chkdate=$_POST['chkdate'];}    
   foreach($idindex as $key){
        $colume_insert=array("id"=>"","idcard"=>"","prename_th"=>"","name_th"=>"","surname_th"=>"",
                    "birthday"=>"","position"=>"","position_now"=>"","schoolid"=>"","begindate"=>"","schooltext"=>"","chkidcard"=>"N","chkdate"=>"N") ;      
        $colume_insert["id"]= trim($key) ;
        $colume_insert["idcard"]= $idcard[trim($key)] ;
        $colume_insert["prename_th"]= $prename_th[trim($key)] ;
        $colume_insert["name_th"]= $name_th[trim($key)] ;
        $colume_insert["surname_th"]= $surname_th[trim($key)] ;
        if($birthday[trim($key)]!=""){$colume_insert["birthday"]= convertDateT2E($birthday[trim($key)] ,"-");}    //  รับข้อมูล dd/mm/yyyy ไทยมาแปลงเป็น อังกฤษ
        $colume_insert["position"]= $position[trim($key)] ;
        $colume_insert["position_now"]= $position_now[trim($key)] ;
        $colume_insert["schoolid"]= $schoolid[trim($key)] ;        
        $colume_insert["schooltext"]  =$schooltext[trim($key)]   ;                                                          
        if($begindate[trim($key)]!=""){$colume_insert["begindate"]= convertDateT2E(trim($begindate[trim($key)]) ,"-");} //  รับข้อมูล dd/mm/yyyy ไทยมาแปลงเป็น อังกฤษ
        $xval="";
       
        if(count($chkidcard)>0){
            if( array_key_exists(trim($key),$chkidcard)){
             if($chkidcard[trim($key)]=="on"){$colume_insert["chkidcard"]="Y";}   
            }       
             
        }
        if(count($chkdate)>0){
            if( array_key_exists(trim($key),$chkdate)){ 
             if($chkdate[trim($key)]=="on"){$colume_insert["chkdate"]="Y";} 
            }
        }  
        $data_insert[trim($key)] =$colume_insert ;           
        unset($colume_insert);       
   }  

}



// loop for save    
 $colume_err_def=array("type"=>"", "id"=>"","idcard"=>"","prename_th"=>"","name_th"=>"","surname_th"=>"",
                    "birthday"=>"","position"=>"","position_now"=>"", "schoolid"=>"","begindate"=>"","schooltext"=>"") ; 
$n_total=0;
$n_save=0;
$n_error=0;

//  เริ่มต้น loop บันทึกข้อมูล
foreach ($data_insert as $key => $datavalue){ 
  $err_msg=array(idcard=>"",schoolid=>"",begindate=>"",msg=>"");  
  $n_total++; 
  //เริ่ม ตรวจสอบ บัตรประชาชน   
  if($datavalue['idcard']!=""){ 
         if(CheckIDCard($datavalue['idcard'])){
                   $sql="select * from general where id='".$datavalue["idcard"] ."'" ;
                   $Result_id = mysql_query($sql);               
                   $rs_id = mysql_num_rows($Result_id); 
                  // echo $sql ."<br>";
                   if($rs_id==0){
                     $err_msg["idcard"] ="";  
                   }else{
                     $err_msg["idcard"]="Missing";  //บัตรประชาชนซ้ำ
                   }                  
         }
         else{
            $err_msg["idcard"]="Error"; //บัตรประชาชนไม่ถูกต้อง
         }
  }
  else{
    $err_msg["idcard"]="Empty";    //บัตรประชาชนไม่มี
  }
  //สิ้นสุด ตรวจสอบ บัตรประชาชน  
     
  //เริ่ม ตรวจสอบ รหัสสถานศึกษา  
  if($datavalue['schoolid']!=""){ 
      $err_msg["schoolid"]="";
  }else{
     $err_msg["schoolid"]="Empty";    //รหัสสถานศึกษา ไม่มี   
  }
   //สิ้นสุด ตรวจสอบ รหัสสถานศึกษา   
  
 // เริ่ม ตรวจสอบ  วันเริ่มรับราชการ
  if($datavalue['begindate']!=""){      
       $varre=ChkdateBegin($datavalue['begindate'] ,$datavalue['birthday'])  ;
         //  $datavalue['begindate']=$varre["strdate"];
           if($varre["err"]==""){
               $err_msg["begindate"]="";
           }else{           
            if($varre["err"]=="T1"){
              $err_msg["begindate"]="OverBirth"; // วันเริ่มรับราชการ น้อยกว่าวันที่เกิด 15 ปี
            }else{
              $err_msg["begindate"]="OverNOW";  // วันเริ่มรับราชการ มากกว่าปัจจุบัน
            }               
           }      
  }else{   
        $datavalue['begindate']= getdatebeginFormPOBEC($linkpobec,"pobec_".$secid,$datavalue['idcard']);
        if($datavalue['begindate']!=""){    
           $varre=ChkdateBegin($datavalue['begindate'] ,$datavalue['birthday'])  ;
           $datavalue['begindate']=$varre["strdate"];
           if($varre["err"]==""){
               $err_msg["begindate"]="";
           }else{           
            if($varre["err"]=="T1"){
              $err_msg["begindate"]="OverBirth"; // วันเริ่มรับราชการ กับ วันที่เกิด ห่างกันไม่ถึง 15 ปี
            }else{
              $err_msg["begindate"]="OverNOW";  // วันเริ่มรับราชการ มากกว่าปัจจุบัน
            }               
           }
        }else{              
           $err_msg["begindate"]="Empty";  // วันเริ่มรับราชการ ไม่มี  
        }  
  
  } 
  $confirm="N"; 
 if($err_msg["schoolid"]==""){ 
  if(strtoupper($err_msg["idcard"])=="MISSING"){
     if($datavalue['chkidcard']=="Y"){
         $confirm="Y"; 
         if($err_msg["begindate"]!=""){
             $confirm="N";
             if(strtoupper($err_msg["begindate"])=="OVERBIRTH"){ 
                if($datavalue['chkdate']=="Y"){
                   $confirm="Y";
                }
                else{
                 $confirm="N";
                }         
             }
         }
     }
  } 
 }
   // สิ้นสุด ตรวจสอบ  วันเริ่มรับราชการ   
             if($err_msg["idcard"]==""&& $err_msg["schoolid"]==""&& $err_msg["begindate"]==""){
                    unset($datavalue['schooltext']);                      
                    unset($datavalue['chkidcard']);
                    unset($datavalue['chkdate']); 
                    $datavalue['begindate']= convertDateE2T2($datavalue['begindate'],"-")  ;    //  รับข้อมูล   yyyy/mm/dd อังกฤษมาแปลงเป็น ปีไทย  yyyy
                    $datavalue['birthday']= convertDateE2T2($datavalue['birthday'],"-") ;       //  รับข้อมูล   yyyy/mm/dd อังกฤษมาแปลงเป็น ปีไทย  yyyy 
                    $isql ="INSERT INTO  general(" . implode(",", array_keys($datavalue)).",siteid) Values ('".implode("','", array_values($datavalue))."','$secid')"  ;                     
                    $isr = mysql_query($isql,$link);
                                 
                    $n_save++;                                   
                 }else{
                    if($process=="edit"&&$confirm=="Y"){
                        
                        $strWhere=" WHERE id='".$datavalue["id"] ."'" ; 
                        $strSql=""; 
                        unset($datavalue['schooltext']); 
                        unset($datavalue['chkidcard']);
                        unset($datavalue['chkdate']);                      
                        unset($datavalue['idcard']); 
                        unset($datavalue['id']);    
                         $datavalue['begindate']= convertDateE2T2($datavalue['begindate'],"-")  ; //  รับข้อมูล   yyyy/mm/dd อังกฤษมาแปลงเป็น ปีไทย  yyyy 
                          $datavalue['birthday']= convertDateE2T2($datavalue['birthday'],"-") ;  //  รับข้อมูล   yyyy/mm/dd อังกฤษมาแปลงเป็น ปีไทย  yyyy  
                        foreach ($datavalue as $skey => $xvalue){ 
                             if(strlen($strSql) >0){$strSql.=",";}
                             $strSql.= $skey. "='".$xvalue."'" ;
                             
                        }    
                        $strSql.=  ",siteid='".$secid."'" ;                      
                        $isql="UPDATE general SET ".$strSql.$strWhere ;                                    
                        $isr = mysql_query($isql,$link);               
                        $n_save++;                       
                    }else{                   
                        $n_error++;
                        $rs_error=array_merge($colume_err_def, $datavalue);   
                        $rs_error["type"]= $err_msg;   
                        $rowerror[$datavalue["id"]] =$rs_error;   
                        unset($rs_error);  
                    }                     
                 } 
     // loop for save
}
//  สิ้นสุด loop บันทึกข้อมูล   
unset($data_insert); 
// บันทึก logFile 
 insertlog($_SESSION[session_staffid] ,$secid,$host,$dbnamemaster, $username, $password,"import ข้อมูล " ,$n_save,$sent_file);
}

       
?>

<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="style/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="jquery.js"></script>
<script language="javascript" src="../js/daily_popcalendar.js"></script>
<script type="text/javascript" >
<!--
var xdivsel="";
var xdivsel_hidden="";
var siteid="<?=$secid?>"; 
    function lookup(inputString,inputhidden) {     
    xstr=   inputString.value; 
    xdivsel=inputString;
    xdivsel_hidden =inputhidden;
    var url="popup.php?siteid="+siteid+"&queryString="+xstr+"&ran="+ Math.random()*1000
    var oReturnValue=  window.showModalDialog(url); 
        if(oReturnValue!=null){
             fill(oReturnValue.Fleetstr,oReturnValue.FleetId) ;
        }
              
    } // lookup      
    function fill(thisValue,thisid) {
      xdivsel.value =thisValue;
      xdivsel_hidden.value =thisid;
    }
	
function checkID(id)
		{
		if(id.length==13){
			for(i=0, sum=0; i < 12; i++){
					sum += parseFloat(id.charAt(i))*(13-i); 
			}
			if((11-sum%11)%10!=parseFloat(id.charAt(12))){
					return false; 
				}else{
					return true;	
					}
			
		}else{
			return false; 
			}
		}
function CheckidCard(filde){
	var value=filde.value;
	if(value.length>0){
	if(!checkID(value)){
		alert('เลขบัตรประชาชนไม่ถูกต้อง');
		filde.value="";
		filde.focus();
		}
	}
	}	
	
function chkall(filde,tick){	
	var xfildlist=document.form1
	for(i=0;i<xfildlist.length;i++)
		{
           if(filde== xfildlist.elements[i].id){		xfildlist.elements[i].checked=tick;	}	
		}
	}
-->
</script>
<style type="text/css">
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
.style8 {
	font-family: "Times New Roman", Times, serif;
	font-size: 12;
	color: #000000;
	font-weight: bold;
}
.style9 {
	font-family: "Times New Roman", Times, serif;
	font-size: 12px;
}
.style12 {
	font-size: 14px;
	color: #000000;
	font-family: "Times New Roman", Times, serif;
	font-weight: bold;
}
.suggestionsBox {
        position: relative;
        left: 30px;
        margin: 10px 0px 0px 0px;
        width: 200px;
        background-color: #212427;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        border: 2px solid #000;    
        color: #fff;
    }
    
    .suggestionList {
        margin: 0px;
        padding: 0px;
    }
    
    .suggestionList li {
        
        margin: 0px 0px 3px 0px;
        padding: 3px;
        cursor: pointer;
    }
    
    .suggestionList li:hover {
        background-color: #659CD8;
    }
-->
</style>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<link href="style/style_excel.css" rel="stylesheet" type="text/css" />
</head>
<body >
 <? 
 
$action="";
if($action == "report_fail"){
?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#144C85', EndColorStr='#ffffff');" height="480">
   <tr>
     <td valign="top"><br />
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td align="center"><span class="style8">รายงานความผิดพลาดของข้อมูลของไฟล์ต้นทาง</span></td>
         </tr>
         <tr>
           <td align="center">&nbsp;</td>
         </tr>
         <tr>
           <td align="center"><table width="80%" border="0" cellspacing="0" cellpadding="5">
             <tr>
               <td width="25%" align="right" valign="middle"><img src="../../../images_sys/arrow_130.gif" width="14" height="14" /></td>
               <td width="75%" align="left" valign="middle"><span class="style9"><? echo "ประเภทไฟล์ excel การนำเข้าไม่ถูกต้อง"; ?></span></td>
             </tr>
             <tr>
               <td align="right" valign="middle"><img src="images/arrow_130.gif" width="14" height="14" /></td>
               <td align="left" valign="middle"><span class="style9"><? echo "ฟิลด์ข้อมูลในไฟล์ excel การนำเข้าข้อมูลไม่สมบูรณ์"; ?></span></td>
             </tr>
             <tr>
               <td align="right" valign="middle"><img src="images/arrow_130.gif" width="14" height="14" /></td>
               <td align="left" valign="middle"><span class="style9"><? echo "ข้อมูลใน Record ไม่สมบูรณ์"; ?></span></td>
             </tr>
           </table></td>
         </tr>
         <tr>
           <td align="center">&nbsp;</td>
         </tr>
         <tr>
           <td align="center">&nbsp;</td>
         </tr>
         <tr>
           <td align="center"><label>
             <input type="button" name="btBlack" value="ย้อนกลับ" onClick="location.href='index.php'">
           </label></td>
         </tr>
       </table></td>
   </tr>
 </table>
 <?
 	}
	else{
 ?>

 <table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#999999" height="480">
   <tr>
     <td valign="top"><br />
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         
         
         <tr>
           <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normal" bordercolorlight="#CCCCCC">
             <tr>
               <td><table width="100%" border="0" cellpadding="5" cellspacing="0">
                 <tr>
                   <td colspan="3" align="center" class="style12">รายงานการนำเข้าข้อมูล</td>
                 </tr>
                 <tr>
                   <td colspan="3" align="center">
       <? 
       if(count($rowerror)>0 ){
       
       ?>            
                  <form method="post" action="process.php?process=edit" enctype="multipart/form-data" name="form1" id="form1">  
                      
                  <input type='hidden'   id='secid' name='secid' value='<?=$secid?>' >    
                    <div align="left"  > 
                    <div align="center"  style="width:100%" > 
                     <table  id='mytable' border="0" cellpadding="0" cellspacing="0" class="formdata" >
                       <tr>
                       <th  width="20px" height="30"> </th>
                         <th >สถานศึกษา/หน่วยงาน</th>
                         <th ><input type='checkbox'  id='idall' name='idall'  onClick="chkall('chkid' ,this.checked )" />เลขบัตรประชาชน</th>
                         <th ><input type='checkbox'  id='datebeginall' name='datebeginall'   onClick="chkall('chkdate' ,this.checked )"/>วันเริ่มปฎิบัติราชการ</th>
                         <th >รายละเอียด</th>
                         
                       </tr>
 <?	
               $indexcount=1;
               $icount=count($rowerror);
               
               foreach ($rowerror as $key => $schooltext){
                   
					echo '<tr>';
					echo '<th >'.$indexcount++.' </th>';	
                     $xid1="schoolname[".$key."]"; 
                     $xid2="schoolid[".$key."]"; 
                     $errcaption_schoolid="";
                     $errcaption_idcard="";  
                     $errcaption_begindate="";  
					 $idchk="";
					 $datechk="";
                    // $err_msg=array(idcard=>"",schoolid=>"",begindate=>"",msg=>""); 
                     $msgerr=$schooltext['type']; 
					 
                     if($msgerr['schoolid']!=""){                    
                        echo " <td align='left'>";    	       
                        echo"<input type='text'  id='schoolname'  name='$xid1' value='".$schooltext['schooltext']."'  readonly='readonly' />";     
					if( $icount>1){	
                        echo"<a href=\"#\" onClick=\"lookup(form1.schoolname['$xid1'],form1.schoolid['$xid2']);\"><img border=0 src=\"images/search.gif\"></a>";    
					}else{
						  echo"<a href=\"#\" onClick=\"lookup(form1.schoolname,form1.schoolid);\"><img border=0 src=\"images/search.gif\"></a>"; 
						}
                        $errcaption_schoolid="ไม่พบรหัส สถานศึกษา/หน่วยงาน";
                        $errcaption_schoolid=" <img border=0 src=\"images/school.gif\" alt=\" $errcaption_schoolid\"> ";  
                     }else{
                         echo " <td align='left' class='disible'>";  
                         echo"<input type='text'  id='schoolname'  name='$xid1' value='".$schooltext['schooltext']."'  readonly='readonly'class='disible' />";                       
                     }                  
                      echo"<input type='hidden'   id='schoolid' name='$xid2' value='".$schooltext['schoolid']."' >";
                        echo "</td>"; 
                  $xid1  ="idcard[".$key."]";    
				if($msgerr['idcard']!="" ){                						
				$event=" onblur=\"CheckidCard(this)\" "		;			
				  if(  strtoupper($msgerr['idcard'])=="EMPTY"){
                      $errcaption_idcard="ไม่ได้กรอก เลขบัตรประชาชน"; 
                  }elseif(strtoupper($msgerr['idcard'])=="MISSING"){  
                      $errcaption_idcard="เลขบัตรประชาชน ประชาชนซ้ำ ยืนยันต้องการใช้ข้อมูลปัจจุบัน"; 
                      if($schooltext['chkidcard']=="Y"){$ischk="checked"; }  else{$ischk="";}
					  $idchk=" <input type='checkbox'  id='chkid' name='chkid[". $key ."]' $ischk />";
                  } elseif(strtoupper($msgerr['idcard'])=="ERROR"){  
                      $errcaption_idcard="เลขบัตรประชาชน ไม่ถูกต้อง";   
                  } 
				  
				echo" <td align='left'>$idchk<input type='text'  id='idcard' maxlength='13' name='$xid1' value='".$schooltext['idcard']."'". $disabled."  $event /></td>"; 	  
                 $errcaption_idcard=" <img border=0 src=\"images/man.gif\" alt=\"$errcaption_idcard \"> ";       
                }else{ 
						echo" <td align='left' class='disible' ><input type='text'  id='idcard' maxlength='13' name='idcard[".$key."]' value='".$schooltext['idcard']."' readonly='readonly'  class='disible'/></td>"; 						
				}
             $xid="begindate[".$key."]";    
			if($msgerr['begindate']!=""){
                    if(strtoupper($msgerr['begindate'])=="EMPTY") {
                      $errcaption_begindate="ไม่ได้กรอกวันที่เริ่มรับราชการ";              
                    }elseif(strtoupper($msgerr['begindate'])=="OVERBIRTH") {
                       $errcaption_begindate="อายุรับราชการน้อยกว่า 15 ปี";  
                       if($schooltext['chkdate']=="Y"){$ischk="checked"; }  else{$ischk="";}   
					   $datechk=" <input type='checkbox'  id='chkdate' name='chkdate[". $key ."]' $ischk />";
                    }elseif(strtoupper($msgerr['begindate'])=="OVERNOW") {
                      $errcaption_begindate="วันที่เริ่มรับราชการ เกินวันที่ปัจจุบัน";  
                    }
				echo" <td align='left'>$datechk <input type='text'  id='begindate'  name='$xid' value='".convertDateE2T($schooltext['begindate'],"-")."'readonly='readonly'  />";			
				if( $icount>1){		
		            echo"<a href=\"#\"	 onClick=\" popUpCalendar(this,form1.begindate['$xid'],'dd-mm-yyyy')\"><img border=0 src=\"images/cal.jpg\"></a>";     
				}else{
				  echo"<a href=\"#\"	 onClick=\" popUpCalendar(this,form1.begindate,'dd-mm-yyyy')\"><img border=0 src=\"images/cal.jpg\"></a>";     	
					}
		 	        echo"</td>"; 		
                 $errcaption_begindate=" <img border=0 src=\"images/cal2.jpg\" alt=\"$errcaption_begindate\"> ";
				}else{ 				
				    echo" <td align='left' class='disible'><input type='text'  id='$xid'  name='begindate[".$key."]' value='".convertDateE2T($schooltext['begindate'],"-") ."' readonly='readonly' class='disible'/></td>";						
				}
						
							
                        echo" <td align='left' class='disible'>";
						echo"<input type='hidden'   id='prename_th' name='prename_th[".$key."]' value='".$schooltext['prename_th']."' >";
						echo" <input type='hidden'  id='name_th' name='name_th[".$key."]' value='".$schooltext['name_th']."'>"; 
                        echo" <input type='hidden'  id='surname_th' name='surname_th[".$key."]' value='".$schooltext['surname_th']."' >";						
                        echo" <input type='hidden'  id='birthday' name='birthday[".$key."]' value='".convertDateE2T($schooltext['birthday'],"-")."' >";                     
						echo"<input type='hidden'  id='position_now' name='position_now[".$key."]' value='".$schooltext['position_now']."' >";       
						echo" <input type='hidden' id='id'name='id[".$key."]' value=' ".$key."' />";
                        echo" <input type='hidden' id='position' name='position[".$key."]' value='".$schooltext['position']."' />";							
						echo $schooltext['prename_th'] ."  ". $schooltext['name_th']  ."  ".  $schooltext['surname_th']  ."  เกิด ".  convertDateE2T(  $schooltext['birthday'],"-")  ."  ตำแหน่ง ".   $schooltext['position_now'];			
				         echo "$errcaption_schoolid $errcaption_idcard $errcaption_begindate"; 
                      //echo '  </td>';	
				      //echo '  </tr>';                       
                      //  echo "<tr class='disible'>";
                      //  echo "<td ></td>";
                      //  echo "<td colspan=7>$errcaption_schoolid $errcaption_idcard $errcaption_begindate</td> ";                        
                      //  echo "</tr> ";
                     // echo "<td ></td>";  
                  //    echo "<td >$errcaption_schoolid $errcaption_idcard $errcaption_begindate</td>";
				   }		
                    
				  ?>                       

                       
                       <tr>
                       <td colspan="8" >
                       </td>
                        
                       </tr>
                    
                     </table>  
                     </div> 
                     *หมายเหตุ<br>
                     &nbsp; &nbsp; &nbsp;1&nbsp;<img src="images/school.gif" width="13" height="13">&nbsp;&nbsp;ข้อมูลสถานศึกษา/หน่วยงานไม่ถูกต้อง <br>
                     &nbsp; &nbsp; &nbsp;2&nbsp;<img src="images/man.gif" width="13" height="13">&nbsp;&nbsp;ข้อมูลเลขบัตรประชาชนไม่ถูกต้อง หรือไม่ได้กรอกเลขบัตรประชาชน<br>
                     &nbsp; &nbsp; &nbsp;3&nbsp;<img src="images/cal2.jpg" width="13" height="13">&nbsp;&nbsp;ข้อมูลวันเริ่มรับราชการไม่ถูกต้อง หรือไม่ได้กรอกวันเริ่มรับราชการ<br>
                     &nbsp; &nbsp; &nbsp;4<input name="" checked="checked" type="checkbox" value=""  id ="dd" disabled >&nbsp;มีไว้เพื่อยืนยันการใช้ข้อมูล อาจเนื่องมาจาก <br>
                      &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;4.1 ข้อมูลเลขบัตรประชาชนซ้ำกับข้อมูลที่มีอยู่แล้ว หากทำการยืนยันการใช้เลขบัตรประชาชนระบบจะทำการ แก้ไขข้อมูลเดิมเป็นข้อมูลชุดใหม่<br>
                     &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;4.2 ข้อมูลวันเริ่มรับราชการ กับวันเกิดน้อยกว่า 15 ปี 
                     
                     </div>                    
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     
  <tr>
    <td align="center">
    <span class="table_button"><input name="button1"  type="submit" class="bt" value="บันทึก" /></span>
   </td>
  </tr>
</table>
</form>        
                 
      <?}?>             
                   
                  </td>
                 </tr>

                 <tr>
                   <td align="right">&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td width="31%" align="right">จำนวนที่นำเข้าทั้งหมด </td>
                   <td width="36%"><?=$n_save?></td>
                   <td width="33%">รายการ</td>
                 </tr>
				
				
                 <tr>
                   <td align="right">รายงานข้อมูลที่นำเข้าไม่ได้</td>
                   <td ><?=($n_error)?></td>
                   <td>รายการ</td>
                 </tr>
                
                 <tr>
                   <td align="right">รวมจำนวนรายการทั้งหมด </td>
                   <td><?=$n_total?></td>
                   <td>รายการ</td>
                 </tr>
                 <tr>
                   <td align="right">&nbsp;</td>
                   <td>&nbsp;</td>
				   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td colspan="3" align="center"><label >
                     <input type="button" name="btClose" value="ย้อนกลับ" onClick="location.href='index.php'" />
                   </label></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
         </tr>
       </table></td>
   </tr>
</table>
 
 <?
}
?>
<script type="text/javascript" >
<!--
 //txtdisible();
-->
</script>
</body>
</html>



