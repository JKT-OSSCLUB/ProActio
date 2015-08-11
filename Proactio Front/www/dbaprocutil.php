<?php 
/*******************************************************************************
 *******************************************************************************
 **                                                                           **
 **                                                                           **
 **  Copyright 2015-2017 JK Technosoft                  					  **
 **  http://www.jktech.com                                           		  **
 **                                                                           **
 **  ProActio is free software; you can redistribute it and/or modify it      **
 **  under the terms of the GNU General Public License (GPL) as published     **
 **  by the Free Software Foundation; either version 2 of the License, or     **
 **  at your option) any later version.                                       **
 **                                                                           **
 **  ProActio is distributed in the hope that it will be useful, but WITHOUT  **
 **  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or    **
 **  FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License     **
 **  for more details.                                                        **
 **                                                                           **
 **  See TNC.TXT for more information regarding the Terms and Conditions    **
 **  of use and alternative licensing options for this software.              **
 **                                                                           **
 **  A copy of the GPL is in GPL.TXT which was provided with this package.    **
 **                                                                           **
 **  See http://www.fsf.org for more information about the GPL.               **
 **                                                                           **
 **                                                                           **
 *******************************************************************************
 *******************************************************************************
 *
 * {program name}
 *
 * Known Bugs & Issues:
 *
 *
 * Author:
 *
 *	JK Technosoft
 *	http://www.jktech.com
 *	August 11, 2015
 *
 *
 * History:
 *
 */

include('header.php');
include('sqlconnect.php');
$query=mysqli_query($connect,"Select dbuid,server from configureddb where dbuid in(Select Distinct Min(dbuid) from configureddb Group By server)");?>
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
	<div class="form-group col-lg-3 pull-right">
	<select class="form-control col-lg-3" id="sel1" name="sel1">
 <?php while($row=mysqli_fetch_assoc($query))
		{
		echo     "<option value='" . $row['dbuid'] . "'>" . $row['server'] . "</option>";
		}
		?>
        
      </select>  
	  </div><p>Server Processes</p></h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/procutil.php"
	   data-query-params="queryParams"
       data-sort-order="desc"
	   data-show-refresh="true"
	   data-pagination="true"
	   data-show-export="true"
	   data-pagination="true"
	   data-search="true"
	   data-show-columns="true"
	   id="tab1"
      
	>
    <thead>
    <tr>
        <th data-field="pid" 
		
            >
            PID
        </th>
        <th data-field="ppid" 
            >
              PPID
        </th>
		<th data-field="cpu" 
       data-sortable="true">
               CPU (%)
        </th>
		<th data-field="pmem" 
          data-sortable="true">
              Memory (%)
        </th>	
		<th data-field="user" 
            >
              User
        </th>

			<th data-field="group" 
            >
              Group
				</th>

			<th data-field="cmd" 
						>
						  Command
					</th>

		
    </tr>
    </thead>
</table>
</div>
</div>
</div>
</div>
<script>
var selected= $("#sel1 option:selected").val();
$('#sel1').on('change', function() {
 selected = this.value;
 $('#tab1').bootstrapTable('refresh', {silent: false});
});
$('#tab1').bootstrapTable({
    formatNoMatches: function () {
        return '<img src="/images/serverinaccessible.gif"></img>';
    },
	formatLoadingMessage: function () {
          return '<img src="/images/connectingser.gif"></img>';
    }
});
function queryParams() {
    return {
        dbuid: selected
    };
}
</script>