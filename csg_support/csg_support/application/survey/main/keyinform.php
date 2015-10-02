<script language="JavaScript">
function CreateXmlHttp(){
		//Creating object of XMLHTTP in IE
		try {
			XmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				XmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch(oc) {
				XmlHttp = null;
			}
		}
		//Creating object of XMLHTTP in Mozilla and Safari 
		if(!XmlHttp && typeof XMLHttpRequest != "undefined") {
			XmlHttp = new XMLHttpRequest();
		}
	} // end function CreateXmlHttp
</script>
<?php
require_once("lib/class.function.php");
$con = new Cfunction();
$con->connectDB();

$sql_years = 'SELECT master_years FROM question_master GROUP BY master_years';
$results_years = $con->select($sql_years);

?>
<style>
#sr_table{
	width:30%;
}

#sr_table,#sr_table tr th,#sr_table tr td{
	border:#BBCEDD solid 1px ;
	border-collapse:collapse;
	height:30px;
}

#sr_table tr td:hover{ background:#FF9}

#type{
	background-image:url("../img/header_bg6.gif");
	color: #FFF;
}
.sub_type{
	text-align:center;
}

.navy{
	background-color:#F2F7F7;
}


</style>
<CENTER>
<DIV style="margin:10px auto;width:80%;min-height:200px;">
<TABLE width="100%">
	<TR>
		<TD align="right">
		<STRONG>ปีงบประมาณ</STRONG>
                    <SELECT name="YearSelect" id="YearSelect" onChange="ChgYear(this.value);">
                    		<?php foreach($results_years as $rd){
									$year = '';
									if($rd['master_years']!='')
									{
										if($rd['master_years']==2557)
										{	
											echo '<option selected value="'.$rd['master_years'].'">'.$rd['master_years'].'</option>';
										}
										else
										{
											echo '<option value="'.$rd['master_years'].'">'.$rd['master_years'].'</option>';
										}
									}
									else
									{
										echo '<option value="2557">2557</option>';
									}
								}
								?>
						                     </SELECT>
              &nbsp;
			  <STRONG>ครั้งที่</STRONG>
                    <SELECT name="number_action" id="number_action" onChange="ChgNumberAction(this.value);">
                    <?php
						$sql_round = 'SELECT master_round FROM question_master where master_years = 2557 GROUP BY master_round';
						$results_round = $con->select($sql_round);
						foreach($results_round as $rd)
						{
							if($rd['master_round']!='')
							{
								echo '<option value="'.$rd['master_round'].'">'.$rd['master_round'].'</option>';
							}
							else
							{
								echo '<option value="1">1</option>';
							}
						}
					?>
					</SELECT>
              &nbsp;
		</TD>
	</TR>
</TABLE>
<FORM name="DD">
<BR />
<BR />
    <TABLE id="sr_table">
    	<TR>
            <TH id="type">เลือกแบบสำรวจ</TH>
        </TR> 
					</TR>
			<TR onMouseOver="hiLght(this,'#FFCC99');" onMouseOut="hiLght(this,'#FFF')">
				<TD class="sub_type"><LABEL id="rond"><a href="question_form.php?frame=form1&rond=1">แบบฟอร์มแบบสอบถามสถาพครอบครัว</a></LABEL></TD>
			</TR>
		    </TABLE>
    <BR />
</FORM>
</DIV>
</CENTER>
<SCRIPT language="javascript1.2">
	function ChgYear( e ) {
		if ( e ) {
			location.href = "/saiyairak_master/application/survey/keyinform.php?action=ChgYear&YR="+e;
		}
	}
	function ChgNumberAction( e ) {
		if ( e ) {
			CreateXmlHttp();
			XmlHttp.open("get", "main/ajax.chkrond.php?rond="+e, true);
			XmlHttp.onreadystatechange=function() {
				if (XmlHttp.readyState==4) {
					if (XmlHttp.status==200) {
						var res = XmlHttp.responseText; //alert(res);
						document.getElementById("rond").innerHTML = res;
					} else if (XmlHttp.status==404) {
						alert("ไม่สามารถทำการดึงข้อมูลได้");
					} else {
						alert("Error : "+XmlHttp.status);
					}
				}
			};
			XmlHttp.send(null);
		}
		
	}
	
	function dashLink(sr){
		window.location.href = "question_form.php?frame=form1&rond="+sr;
	}
</SCRIPT>