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

include("profile.php");
$current=$_SESSION['dbid'];
?>
<div class="pad">
<div class="container">
<div class="row">
   	  <div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">     
Database Feature</h4>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/dbapercentage.php"
	   data-query-params="queryParams"
       data-sort-order="desc"
	     data-response-handler="responseHanlder"
	   data-show-refresh="true"
   	   data-show-export="true"
		data-show-columns="true"
		id="tab1"
	>
<thead>
    <tr>
        <th data-field="key" class="key">Key</th>
        <th data-field="value">Value/Percentage</th>
    </tr>
    </thead>
</table>
  </div>
</div>
</div>
</div>
</div>
<script>
function queryParams() {
    return {
        dbuid:<?php echo "'$current'" ;?>
    };
}
$('#tab1').bootstrapTable({
    formatNoMatches: function () {
        return 'Connection Error....!...Please check database for any error messages';
    },
	formatLoadingMessage: function () {
        return '<img src="/images/connecting.gif"></img>';
    }
});
function responseHanlder(res) {
    var data = [];

    for (var key in res) {
        data.push({
            key: key,
            value: res[key]
        });
    }
    return data;
}
</script>
