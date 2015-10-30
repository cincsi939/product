
<!-- TWO STEPS TO INSTALL SELECT AND AUTO COPY:

  1.  Copy the coding into the HEAD of your HTML document
  2.  Add the last code into the BODY of your HTML document  -->

<!-- STEP ONE: Paste this code into the HEAD of your HTML document  -->

<HEAD>

<SCRIPT LANGUAGE="JavaScript">

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->
<!-- Original:  Russ (NewXS3@aol.com) -->
<!-- Web Site:  http://dblast.cjb.net -->

<!-- Begin
function copyit(theField) {
var tempval=eval("document."+theField)
tempval.focus()
tempval.select()
therange=tempval.createTextRange()
therange.execCommand("Copy")
}
//  End -->
</script>

</HEAD>

<!-- STEP TWO: Copy this code into the BODY of your HTML document  -->

<BODY>

<form name="it">
<div align="center">
<input onclick="copyit('it.select1')" type="button" value="Press to Copy the Text" name="cpy">
<p>
<textarea name="select1" rows="3" cols="25">
If this is highlighted, then it has been copied.
</textarea>
</div>
</form>
