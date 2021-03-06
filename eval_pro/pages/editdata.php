<!DOCTYPE html>
<html lang="en">
<head>

	<!--<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />-->
    <link rel="stylesheet" href="jqwidgets-ver3.9.0/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="jqwidgets-ver3.9.0/jqwidgets/styles/jqx.classic.css" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.0/jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
			

            // prepare the data
            var data = {};
            var theme = 'classic';
            var source =
            {
                datatype: "json",
                datafields: [
					 { name: 'id' },
					 { name: 'Working_log_id'},
					 { name: 'WorkingDate'},
					 { name: 'IdCard'},
					 { name: 'WorkingPeple'},
					 { name: 'ProjectCode'},
					 { name: 'WorkingPercent'},
					 { name: 'WorkingTime'},
					 { name: 'CostId'},
					 { name: 'TaskId'},
					 { name: 'phase_code'},
					 { name: 'assign_staffid'},
					 { name: 'JobAssignment'},
					 { name: 'workname'},
					 { name: 'WorkingDetail'},
					 { name: 'staffid'},
					 { name: 'UpdateTime'},
					 { name: 'Department'},
					 { name: 'tor' },
					 { name: 'facebook_url' },
					 { name: 'daily_type' },
					 { name: 'Job_Des' },
					 { name: 'Diff_Level' },
					 { name: 'ABS_result' }
					     ],
                id: 'id,IdCard',
                url: 'data.php',
                updaterow: function (rowid, rowdata,commit) {
					//console.log(datafields);
                    // synchronize with the server - send update command
					commit(true);
                    var data = "update=true&id=" + rowdata.id + 
							   "&Working_log_id=" + rowdata.Working_log_id + 
							   "&WorkingDate=" + rowdata.WorkingDate + 
							   "&IdCard=" + rowdata.IdCard + 
							   "&WorkingPeple=" + rowdata.WorkingPeple + 
							   "&ProjectCode=" + rowdata.ProjectCode + 
							   "&WorkingPercent=" + rowdata.WorkingPercent + 
							   "&WorkingTime=" + rowdata.WorkingTime + 
							   "&CostId=" + rowdata.CostId + 
							   "&TaskId=" + rowdata.TaskId + 
							   "&phase_code=" + rowdata.phase_code + 
							   "&assign_staffid=" + rowdata.assign_staffid + 
							   "&JobAssignment=" + rowdata.JobAssignment + 
							   "&workname=" + rowdata.workname + 
							   "&WorkingDetail=" + rowdata.WorkingDetail + 
							   "&staffid=" + rowdata.staffid + 
							   "&UpdateTime=" + rowdata.UpdateTime + 
							   "&Department=" + rowdata.Department + 
							   "&tor=" + rowdata.tor + 
							   "&facebook_url=" + rowdata.facebook_url + 
							   "&daily_type=" + rowdata.daily_type + 
							   "&Job_Des=" + rowdata.Job_Des + 
							   "&Diff_Level=" + rowdata.Diff_Level + 
							   "&ABS_result=" + rowdata.ABS_result; 
                    $.ajax({
                        dataType: 'json',
                        url: 'data.php',
                        data: data,
                        success: function (data, status, xhr) {
							//console.log('data');
                            // update command is executed.
                        }
                    });
                }
            };
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {
                width: 1300,
               height: 500,
                selectionmode: 'singlecell',
                source: source,
                theme: theme,
                editable: true,
				 
                
                
                columns: [
                      { text: 'id', editable: false, datafield: 'id', width: 100 },
                      { text: 'Working_log_id', columntype: 'dropdownlist', datafield: 'Working_log_id', width: 100 },
                      { text: 'WorkingDate', columntype: 'dropdownlist', datafield: 'WorkingDate', width: 100 },
					  { text: 'IdCard', editable: false, datafield: 'IdCard', width: 140 },
                      { text: 'WorkingPeple', datafield: 'WorkingPeple', width: 180 },
                      { text: 'ProjectCode', datafield: 'ProjectCode', width: 180 },
                      { text: 'WorkingPercent', datafield: 'WorkingPercent', width: 100 },
                      { text: 'WorkingTime', datafield: 'WorkingTime', width: 140 },
					  { text: 'CostId', datafield: 'CostId', width: 140 },
					  { text: 'TaskId', datafield: 'TaskId', width: 140 },
					  { text: 'phase_code', datafield: 'phase_code', width: 140 },
					  { text: 'assign_staffid', datafield: 'assign_staffid', width: 140 },
					  { text: 'JobAssignment', datafield: 'JobAssignment', width: 140 },
					  { text: 'workname', datafield: 'workname', width: 140 },
					  { text: 'WorkingDetail', datafield: 'WorkingDetail', width: 140 },
					  { text: 'staffid', datafield: 'staffid', width: 140 },
					  { text: 'UpdateTime', datafield: 'UpdateTime', width: 140 },
					  { text: 'Department', datafield: 'Department', width: 140 },
					  { text: 'tor', datafield: 'tor', width: 140 },
					  { text: 'facebook_url', datafield: 'facebook_url', width: 140 },
					  { text: 'daily_type', datafield: 'daily_type', width: 140 },
					  { text: 'Job_Des', datafield: 'Job_Des', width: 140 },
					  { text: 'Diff_Level', datafield: 'Diff_Level', width: 140 },
					  { text: 'ABS_result', datafield: 'ABS_result', width: 140 }		 
                  ]
            });
        });
    </script>
</head>
<body class='default'>
	<div id="jqxgrid">
	</div>
</body>
</html>