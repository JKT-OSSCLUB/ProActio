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

include('profile.php');
$current=$_SESSION['dbid'];?>
<div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
<p>Disk Utilization</p></h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/diskutil.php"
	   data-query-params="queryParams"
     	data-show-export="true"
       data-sort-order="desc"
	   data-show-refresh="true"
	   data-pagination="true"
	   data-search="true"
	   data-show-columns="true"
	    id="tab1"
	>
    <thead>
    <tr>
        <th data-field="FILESYSTEM" 
            >
              FILESYSTEM
        </th>
        <th data-field="1KBLOCKS" 
            >
               	SIZE (KB)
        </th>
		<th data-field="USED" 
            >
              USED (KB)
        </th>
		<th data-field="AVAILABLE" 
            >
             AVAILABLE (KB)
        </th>
			<th data-field="USED%" 
						>
						 USED %
					</th>
			<th data-field="MOUNTED" 
						>
				 MOUNTED ON
					</th>

		
    </tr>
    </thead>
</table>
</div>
</div>
</div>
</div>
</div>
<script>
$('#tab1').bootstrapTable({
    formatNoMatches: function () {
        return '<img src="images/serverinaccessible.gif"></img>';
    },
	formatLoadingMessage: function () {
   return '<img src="/images/connectingser.gif"></img>';
    }
});
function queryParams() {
    return {
       dbuid:<?php echo "'$current'" ;?>
    };
}

</script>