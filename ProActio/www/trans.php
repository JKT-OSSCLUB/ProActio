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
 */include('profile.php');
$current=$_SESSION['dbid'];?>
<div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     <p>Database Active Transaction</p></h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/databasetransactions.php"
	    data-show-export="true"
	   data-query-params="queryParams"
       data-sort-order="desc"
	   data-show-refresh="true"
	   data-pagination="true"
	   data-search="true"
	   data-show-columns="true"
	   id="tab1"
	>
    <thead>
    <tr>
        <th data-field="_Trans-Duration" 
            >
              Transaction Duration
        </th>
        <th data-field="_Trans-Num" 
            >
              Transaction Number
        </th>
        <th data-field="_Trans-State" 
            >
              Transaction State
        </th>
        <th data-field="_Trans-txtime" 
            >
               Transaction Time
        </th>
        <th data-field="_Trans-Usrnum" 
            >
               	User Number
        </th>       
		<th data-field="_Connect-Name" 
            >
               	User Name
        </th>
				<th data-field="_Connect-Pid" 
            >
               	PID
        </th>
		
    </tr>
    </thead>
</table>
</div>
</div>
</div>
<script>
$('#tab1').bootstrapTable({
	formatLoadingMessage: function () {
   return '<img src="/images/connecting.gif"></img>';
    }
});
function queryParams() {
    return {
       dbuid:<?php echo "'$current'" ;?>
    };
}
</script>