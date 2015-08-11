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
	include("sqlconnect.php");
	$query=mysqli_query($connect,"SELECT dbuid from request");
	$number_of_requests=mysqli_num_rows($query);
	$query1=mysqli_query($connect,"SELECT dbuid from configureddb");
	$number_of_configured=mysqli_num_rows($query1);
	$query2=mysqli_query($connect,"SELECT dbid from alerts");
	$number_of_alerts=mysqli_num_rows($query2);
	$query2=mysqli_query($connect,"SELECT configureddb.dbname,alerts.date as time , alertdesc.alertdisc from alerts inner join configureddb inner join alertdesc where configureddb.dbuid = alerts.dbid and alerts.desc_id = alertdesc.desc_id order by alerts.date desc limit 5");
?>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
     <script type="text/javascript">
	google.load('visualization', '1', {'packages':['corechart','bar']});    
      google.setOnLoadCallback(drawStuff);
	  
  function drawStuff() {
 $.ajax({
          url: "ajax/cpumonthchart.php",
          dataType:"json",
		  beforeSend: function(){
		$("#cpu-mon-chart").html('<img style="position: absolute;display: block;top: 45%;left: 42%;" src="images/connecting.gif">');
		},
			  cache: false,
             success: function (json) {
			for ( var i = 0; i < json.rows.length; i++ ) { 
				json.rows[i].c[0].v = new Date( json.rows[i].c[0].v * 1000 );
				}
   var options = {
       hAxis: {
          title: 'Date'
        },
        series: {
          1: {curveType: 'function'}
        },
		vAxis: { 
              title: "% Used", 
              viewWindowMode:'explicit',
              viewWindow:{
                max:101,
                min:0
              }
            }
      };
		var data = new google.visualization.DataTable(json);
      var chart = new google.visualization.LineChart(document.getElementById('cpu-mon-chart'));
        chart.draw(data,options);
}     
	 });
	  };

    </script>
	   <script type="text/javascript">
	google.load('visualization', '1', {'packages':['corechart']});    
      google.setOnLoadCallback(drawmon);
	  
  function drawmon() {
 $.ajax({
          url: "ajax/monthchartmemory.php",
          dataType:"json",
		  beforeSend: function(){
		$("#mem-mon-chart").html('<img style="position: absolute;display: block;top: 45%;left: 47%;" src="images/connecting.gif">');
		},
			  cache: false,
             success: function (json) {
			for ( var i = 0; i < json.rows.length; i++ ) { 
				json.rows[i].c[0].v = new Date( json.rows[i].c[0].v * 1000 );
				}
   var options = {
       hAxis: {
          title: 'Date'
        },
        series: {
          1: {curveType: 'function'}
        },
		vAxis: { 
              title: "% Used ", 
              viewWindowMode:'explicit',
              viewWindow:{
                max:101,
                min:0
              }
            }
      };
		var data = new google.visualization.DataTable(json);
      var chart = new google.visualization.LineChart(document.getElementById('mem-mon-chart'));
        chart.draw(data,options);
}     
	 });
	  };

    </script>
	<script type="text/javascript">
   // google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawStuff);

    function drawStuff() {
	$.ajax({
          url: "ajax/ajaxchartdataarea.php",
          dataType:"json",
		  beforeSend: function(){
		$("#top_x_div").html('<img style="position: absolute;display: block;top: 50%;left: 30%;" src="images/connecting.gif">');
		},
         success: function (json) {

        var options = {
          title: 'Databases Usage',
          width: 450,
          legend: { position: 'none' },
          chart: { subtitle: '% Used' },
          bar: { groupWidth: "50%" }
        };
		var data = new google.visualization.DataTable(json);
        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
 } 
  });  
	 };
    </script>
    <script type="text/javascript">
   // google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawStuff1);

    function drawStuff1() {
$.ajax({
          url: "ajax/ajaxchartcpumain.php",
          dataType:"json",
		  beforeSend: function(){
		$("#top_x1_div").html('<img style="position: absolute;display: block;top: 50%;left: 30%;" src="images/connectingser.GIF">');
		},
 success: function (json) {
        var options = {
          title: 'CPU Usage',
          width: 450,
          legend: { position: 'none' },
          chart: { subtitle: '% Free' },
          bar: { groupWidth: "10%" }
        };
		var data = new google.visualization.DataTable(json);
        var chart = new google.charts.Bar(document.getElementById('top_x1_div'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
}
		});     
	 };

    </script>
	<script type="text/javascript">
  //  google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawStuff2);

    function drawStuff2() {
$.ajax({
          url: "ajax/ajaxchartmemorymain.php",
          dataType:"json",
          async: false,
		  beforeSend: function(){
		$("#top_x2_div").html('<img style="position: absolute;display: block;top: 45%;left: 45%;" src="images/connectingser.GIF">');
		},

  success: function (json) {
        var options = {
          title: 'Memory Usage',
          width: 450,
          legend: { position: 'none' },
          chart: { subtitle: '% Free' },
          bar: { groupWidth: "10%" }
        };
		var data = new google.visualization.DataTable(json);
        var chart = new google.charts.Bar(document.getElementById('top_x2_div'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
}
		});    
	};

    </script>
  <div class="container">
  <div class="row col-lg-12">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-database fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $number_of_requests; ?></div>
                                    <div>User Requests </div>
                                </div>
                            </div>
                        </div>
                        <a href="apprej.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-database fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $number_of_configured; ?></div>
                                    <div>Database Configuration </div>
                                </div>
                            </div>
                        </div>
                        <a href="configuredb.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bell fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $number_of_alerts; ?></div>
                                    <div>Alerts</div>
                                </div>
                            </div>
                        </div>
                        <a href="alertdbaall.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            </div>
								<div class="col-lg-12">
					<div class="col-lg-6">
			<div class="  panel panel-primary">
					<div class="panel-heading">CPU Utilization(%) : Last Month</div>
					  <div class="panel-body">
					  <div class="container">
						    <div id="cpu-mon-chart" style="width: 450px; height: 250px;"></div>
					  </div>
					  </div>
					</div>
					</div>
					<div class="col-lg-6">
			<div class="  panel panel-primary">
					<div class="panel-heading">Memory Utilization(%) : Last Month</div>
					  <div class="panel-body">
					  <div class="container">

						  <div id="mem-mon-chart" style="width: 450px; height: 250px;"></div>
					  </div>
					  </div>
					</div>
					</div>
					</div>	
			<div class="col-lg-12">
			
			<div class="col-lg-6 pull-right">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Recent Alerts 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php while($alertgen=mysqli_fetch_assoc($query2)){
                           echo ' <div class="list-group">';
                           echo ' <a  style="cursor:default" class="list-group-item">';
                           echo'         <i class="fa fa-bell fa-fw"></i>';
						   echo  "<strong>".$alertgen['dbname']."</strong>"."        ".$alertgen['alertdisc'];
                           echo'         <span class="pull-right text-muted small"><em>';
						   echo $alertgen['time'];
						   echo ' </em>';
                           echo'         </span>';
                           echo '     </a>';
                           echo' </div>';
							}?>
                            <!-- /.list-group -->
                            <input type="button" value="View All Alerts" class="btn-block btn btn-primary" onclick="location.href='alertdbaall.php';">
							<!-- ez <a href="alertdbaall.php" class="btn btn-default btn-block">View All Alerts</a> -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    </div>
					
					<div class="col-lg-6">
			<div class="  panel panel-primary">
					<div class="panel-heading">Databases Utilization : Current</div>
					  <div class="panel-body">
					 
						    <div id="top_x_div" style="width: 100px; height: 350px;"></div>

					  </div>
					</div>
					</div>
					</div>
	

					<div class="col-lg-12">
					<div class="col-lg-6">
			<div class="  panel panel-primary">
					<div class="panel-heading">CPU Utilization : Current</div>
					  <div class="panel-body">
					  <div class="container">
						    <div id="top_x1_div" style="width: 100px; height: 350px;"></div>
					  </div>
					  </div>
					</div>
					</div>
					<div class="col-lg-6">
			<div class="  panel panel-primary">
					<div class="panel-heading">Memory Utilization : Current</div>
					  <div class="panel-body">
					  <div class="container">

						    <div id="top_x2_div" style="width: 100px; height: 350px;"></div>
					  </div>
					  </div>
					</div>
					</div>
					</div>
					
              