<?
include ("../../common/common_competency.inc.php")  ;
include("checklist2.inc.php");
?>
<center>
<form name="fm1" action="import_excel/processxls_sendreport.php?process=execute&xsiteid=<?=$xsiteid?>" method="post" enctype="multipart/form-data">


    <table width="500" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td><strong>แบบฟอร์มส่งผลการทำงาน</strong></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><table width="600" border="0" align="center">
          <tr>
            <td><strong>SITE</strong></td>
            <td><?=show_area($xsiteid);?></td>
          </tr>
          <tr>
            <td width="18%"><strong>Username</strong></td>
            <td width="82%"><input name="username" id="uname" type="text" class="epm_inputbox" value="" size="20" maxlength="20" onfocus="this.select();" /></td>
          </tr>
          <tr>
            <td><strong>Password</strong></td>
            <td><input name="password" type="password" class="epm_inputbox" value="" size="20" maxlength="20" onfocus="this.select();" id="password" /></td>
          </tr>
          <tr>
            <td align="left" valign="top"><strong>Profile</strong></td>
            <td align="left">
            <select name="profile_id" id="profile_id">
            	<?
					$sql = mysql_db_query(DB_CHECKLIST,"SELECT profile_id,profilename FROM tbl_checklist_profile ORDER BY profile_id");
					while( $row = mysql_fetch_assoc($sql)){
				?>
              <option value="<?=$row['profile_id']?>"><?=$row['profilename']?></option>
              	<?
					}
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top"><strong>Checklist</strong></td>
            <td align="left"><input type="file" name="name" id="name" value="" /></td>
          </tr>
          <tr>
            <td align="left" valign="top"><strong>Comment</strong>
              </td>
            <td align="left"><textarea name="comment" cols="75" rows="7" /></textarea></td>
          </tr>
          <tr>
            <td align="left">              
            <td align="left"><input type="submit" value="ส่งผลการทำงาน" name="submit_login" />                        
          </tr>
        </table></td>
      </tr>
    </table>

  </form>
</center> 
