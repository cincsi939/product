/* $Id: functions.js,v 1.34 2003/04/06 19:14:36 garvinhicking Exp $ 
way to include  <script src="../inc/functions.js" type="text/javascript" language="javascript"></script>
*/


/**
 * Displays an confirmation box beforme to submit a "DROP/DELETE/ALTER" query.
 * This function is called while clicking links
 *
 * @param   object   the link
 * @param   object   the sql query to submit
 *
 * @return  boolean  whether to run the query or not
 */
function confirmLink(theLink, theSqlQuery)
{
    // Confirmation is not required in the configuration file
    // or browser is Opera (crappy js implementation)
    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
        return true;
    }

    var is_confirmed = confirm(confirmMsg + ' :\n' + theSqlQuery);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

    return is_confirmed;
} // end of the 'confirmLink()' function

 
/**
 * Ensures a value submitted in a form is numeric and is in a range
 *
 * @param   object   the form
 * @param   string   the name of the form field to check
 * @param   integer  the minimum authorized value
 * @param   integer  the maximum authorized value
 *
 * @return  boolean  whether a valid number has been submitted or not
 */ 
/**
 * This array is used to remember mark status of rows in browse mode
 */
var marked_row = new Array;


/**
 * Sets/unsets the pointer and marker in browse mode
 *
 * @param   object    the table row
 * @param   interger  the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background color
 * @param   string    the color to use for mouseover
 * @param   string    the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 */
function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor)
{
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3

    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == ''
        || currentColor.toLowerCase() == theDefaultColor.toLowerCase()) {
        if (theAction == 'over' && thePointerColor != '') {
            newColor              = thePointerColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.2 Current color is the pointer one
    else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
             && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
        if (theAction == 'out') {
            newColor              = theDefaultColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.3 Current color is the marker one
    else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
        if (theAction == 'click') {
            newColor              = (thePointerColor != '')
                                  ? thePointerColor
                                  : theDefaultColor;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function

/*
 * Sets/unsets the pointer and marker in vertical browse mode
 *
 * @param   object    the table row
 * @param   interger  the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background color
 * @param   string    the color to use for mouseover
 * @param   string    the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 *
 * @author Garvin Hicking <me@supergarv.de> (rewrite of setPointer.)
 */
function setVerticalPointer(theRow, theRowNum, theAction, theDefaultColor1, theDefaultColor2, thePointerColor, theMarkColor) {
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;

    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        domDetect    = false;
    } // end 3

    var c = null;
    // 5.1 ... with DOM compatible browsers except Opera
    for (c = 0; c < rowCellsCnt; c++) {
        if (domDetect) {
            currentColor = theCells[c].getAttribute('bgcolor');
        } else {
            currentColor = theCells[c].style.backgroundColor;
        }

        // 4. Defines the new color
        // 4.1 Current color is the default one
        if (currentColor == ''
            || currentColor.toLowerCase() == theDefaultColor1.toLowerCase() 
            || currentColor.toLowerCase() == theDefaultColor2.toLowerCase()) {
            if (theAction == 'over' && thePointerColor != '') {
                newColor              = thePointerColor;
            } else if (theAction == 'click' && theMarkColor != '') {
                newColor              = theMarkColor;
                marked_row[theRowNum] = true;
            }
        }
        // 4.1.2 Current color is the pointer one
        else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
                 && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
            if (theAction == 'out') {
                if (c % 2) {
                    newColor              = theDefaultColor1;
                } else {
                    newColor              = theDefaultColor2;
                }
            }
            else if (theAction == 'click' && theMarkColor != '') {
                newColor              = theMarkColor;
                marked_row[theRowNum] = true;
            }
        }
        // 4.1.3 Current color is the marker one
        else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
            if (theAction == 'click') {
                newColor              = (thePointerColor != '')
                                      ? thePointerColor
                                      : ((c % 2) ? theDefaultColor1 : theDefaultColor2);
                marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                      ? true
                                      : null;
            }
        } // end 4

        // 5. Sets the new color...
        if (newColor) {
            if (domDetect) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            }
            // 5.2 ... with other browsers
            else {
                theCells[c].style.backgroundColor = newColor;
            }
        } // end 5
    } // end for

     return true;
 } // end of the 'setVerticalPointer()' function
 

/**
  * listbox redirection
  */
function goToUrl(selObj, goToLocation){
    eval("document.location.href = '" + goToLocation + "pos=" + selObj.options[selObj.selectedIndex].value + "'");
}

function show_modify(modify_date){
 	alert("Version " + modify_date );
 	// Way to use   <a href='#' onclick = show_modify(); >version</a>
}
