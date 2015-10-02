/**
 * @comment 	JS windowsFromTableId
 * @projectCode
 * @tor 	   
 * @package    core
 * @author     Phada Woodtikarn (phada@sapphire.co.th)
 * @created    21/06/2014
 * @access     public
 */
function windowsFromTableId(tableId, targetFile, titleData, effect, dateOfData, dataType, readFile) {
	
    var strHTMLTable = $('#'+tableId).html();
    var HTMLTable = strHTMLTable.toString();

    //alert(HTMLTable);
    var form = document.createElement('form');
    form.setAttribute('method','post');
    form.setAttribute('action', targetFile);
    form.setAttribute('target','_blank');

    var hiddenfield = document.createElement('input');
    hiddenfield.setAttribute('type', 'hidden');
    hiddenfield.setAttribute('name', 'data');
    hiddenfield.setAttribute('id', 'data');
    hiddenfield.setAttribute('value', HTMLTable);

    var title = document.createElement('input');
    title.setAttribute('type', 'hidden');
    title.setAttribute('name', 'title');
    title.setAttribute('id', 'title');
    title.setAttribute('value', titleData);

    var fx = document.createElement('input');
    fx.setAttribute('type', 'hidden');
    fx.setAttribute('name', 'effect');
    fx.setAttribute('id', 'effect');
    fx.setAttribute('value', effect);

    var datatype = document.createElement('input');
    datatype.setAttribute('type', 'hidden');
    datatype.setAttribute('name', 'dataType');
    datatype.setAttribute('id', 'dataType');
    datatype.setAttribute('value', dataType);

    var dummyFile = document.createElement('input');
    dummyFile.setAttribute('type', 'hidden');
    dummyFile.setAttribute('name', 'dummyFile');
    dummyFile.setAttribute('id', 'dummyFile');
    dummyFile.setAttribute('value', readFile);
	// @modify Phada Woodtikarn 09/09/2014 เพิ่มข้อมูลณวันที่
	var dataof = $('.'+dateOfData).html();
	if(typeof dataof === "undefined"){
		dataof = '';	
	}
	var dateOfData = document.createElement('input');
    dateOfData.setAttribute('type', 'hidden');
    dateOfData.setAttribute('name', 'dateOfData');
    dateOfData.setAttribute('id', 'dateOfData');
    dateOfData.setAttribute('value', dataof);
	// @end
	
	form.appendChild(dateOfData);
    form.appendChild(hiddenfield);
    form.appendChild(title);
    form.appendChild(fx);
    form.appendChild(datatype);
    form.appendChild(dummyFile);
    document.body.appendChild(form);
    form.submit();

}