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
require('header.php'); 
require('sqlconnect.php');
$currentuser=$_SESSION['username'];
$query=mysqli_query($connect,"SELECT distinct  configureddb.server FROM configureddb INNER JOIN dbalogin where dbalogin.username='$currentuser'");
?>

<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
     var ajax;  
    google.load('visualization', '1', {'packages':['corechart']});
   google.setOnLoadCallback(drawChart);
      
    function drawChart() {
	    if (ajax) {
       ajax.abort();
   }
ajax=$.ajax({
          url: "ajax/ajaxchartlogic3.php",
          dataType:"json",
		  data:"dbuid="+$("#select option:selected").attr("value"),
		  beforeSend: function(){
		$("#chart_div").html('<img style="position: absolute;display: block;top: 45%;left: 23%;" src="images/connectingser.GIF">');
		},
		error: function () {
                  $("#chart_div").html('<img style="position: absolute;display: block;top: 45%;left: 23%;" src="images/serverinaccessible.gif">');
				   ajax = undefined;
              },
          success: function (json) {
		   var options = {
           title: 'Memory status',
          is3D: 'true',
          width: 800,
        };
      var data = new google.visualization.DataTable(json);
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data,options);
	   ajax = undefined;
}
	  });  
  }

    </script>
  </head>

  <body>
 <div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
	<div class="form-group col-lg-3 pull-right">
  <select class="form-control " id="select" name ="dbname" data-live-search="true">
         <?php
		while($row=mysqli_fetch_assoc($query))
		{
		echo     "<option value='" . $row['server'] . "'>" . $row['server'] . "</option>";
		}
		?>
        </select>
					  </div><p>Memory Utilization </p></h3>
  </div>	
    <div class="panel-body">
    <div class="col-lg-12 col-lg-offset-2"id="chart_div"style="height: 400px;"></div>
	</div>
	</div>	</div>
	</div>
	  <script>
  $('#select').change(function() {
    drawChart();
  });
  </script>
  </body>
</html>