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

require('profile.php');
require('sqlconnect.php');
$current_user=$_SESSION['login_username'];
$currentdb=$_SESSION['dbid'];
$queryserver=mysqli_query($connect,"SELECT  configureddb.server FROM configureddb INNER JOIN login_db where login_db.user_id='$current_user' and configureddb.dbuid='$currentdb'");
while($row=mysqli_fetch_assoc($queryserver))
{
$currentserver = $row['server'];
}
$minoral = mysqli_query($connect,"select alerts.date , alertdesc.alertdisc , alerts.alert_read  from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$currentdb' and alertdesc.alerttype = 'Minor' and alerts.alert_read=0 ORDER BY date desc LIMIT 5");
$majoral = mysqli_query($connect,"select alerts.date , alertdesc.alertdisc , alerts.alert_read  from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$currentdb' and alertdesc.alerttype = 'Major' and alerts.alert_read=0 ORDER BY date desc LIMIT 5");
$criticalal = mysqli_query($connect,"select alerts.date , alertdesc.alertdisc , alerts.alert_read  from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$currentdb' and alertdesc.alerttype = 'Critical' and alerts.alert_read=0 ORDER BY date desc LIMIT 5");
?>
<html>
  <head>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
  var currentdb = <?php echo "'$currentdb'" ;?> ;
  var currentserver = <?php echo "'$currentserver'" ;?> ;
      google.load("visualization", "1", {packages:["corechart","bar"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
	  $.ajax({
          url: "ajax/ajaxchartlogic.php",
          dataType:"json",
		  data:"dbuid="+currentdb,
		  beforeSend: function(){
		$("#chart_div").html('<img style="position: absolute;display: block;top: 45%;left: 30%;" src="images/ajax-loader.gif">');
		},
		 success: function (json) {
		   var options = {
           title: 'Data Area Status',
          is3D: 'true',
          width: 300,
          height: 200
        };
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(json);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('1chart_div'));
      chart.draw(data,options);
    }
	});
	$.ajax({
          url: "ajax/ajaxchartlogic1.php",
          dataType:"json",
		  data:"dbuid="+currentserver,
		  beforeSend: function(){
		$("#chart1_div").html('<img style="position: absolute;display: block;top: 45%;left: 30%;" src="images/ajax-loader.gif">');
		},
success: function (jsonp) {
		   var options1 = {
           title: 'CPU status',
          is3D: 'true',
          width: 300,
          height: 200
        };
          
      // Create our data table out of JSON data loaded from server.
      var data1 = new google.visualization.DataTable(jsonp);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart1_div'));
      chart.draw(data1,options1);
    }
	  });
	  $.ajax({
          url: "ajax/ajaxchartlogic3.php",
          dataType:"json",
		  data:"dbuid="+currentserver,
		  beforeSend: function(){
		$("#chart2_div").html('<img style="position: absolute;display: block;top: 45%;left: 30%;" src="images/ajax-loader.gif">');
		},
          success: function (json) {
		   var options = {
           title: 'Memory status',
          is3D: 'true',
          width: 300,
          height: 200
        };
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(json);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart2_div'));
      chart.draw(data,options);
}
	  });  
		}
    </script>

 <script type="text/javascript">
      google.setOnLoadCallback(drawStuff);

    function drawStuff() {
$.ajax({
          url: "ajax/ajaxchartlogic2.php",
          dataType:"json",
		  data:"dbuid="+currentserver,
		  beforeSend: function(){
		$("#chart3_div").html('<img style="position: absolute;display: block;top: 45%;left: 50%;" src="images/ajax-loader.gif">');
		},
             success: function (json) {

        var options3 = {
          title: '',
          width: 300,
		  height: 200,
          legend: { position: 'none' },
          chart: { subtitle: 'percentage' },
          bar: { groupWidth: "30%" }
        };
		var data3 = new google.visualization.DataTable(json);
        var chart = new google.charts.Bar(document.getElementById('chart3_div'));
        // Convert the Classic options to Material options.
        chart.draw(data3, options3);
}     
	 });
	 $.ajax({
          url: "ajax/dataareachart.php",
          dataType:"json",
		  data:"dbuid="+currentdb,
		  beforeSend: function(){
		$("#chart_div").html('<img style="position: absolute;display: block;top: 45%;left: 50%;" src="images/ajax-loader.gif">');
		},
             success: function (json) {

        var options3 = {
          title: '',
          width: 300,
		  height: 200,
          legend: { position: 'none' },
          chart: { subtitle: 'percentage' },
          bar: { groupWidth: "50%" }
        };
		var data3 = new google.visualization.DataTable(json);
        var chart = new google.charts.Bar(document.getElementById('chart_div'));
        // Convert the Classic options to Material options.
        chart.draw(data3,google.charts.Bar.convertOptions(options3));
}     
	 });
	  }

    </script>

  <style>

  nav.sidebar, .main{
    -webkit-transition: margin 200ms ease-out;
      -moz-transition: margin 200ms ease-out;
      -o-transition: margin 200ms ease-out;
      transition: margin 200ms ease-out;
  }

  .main{
    padding: 10px 10px 0 5px;
  }

 @media (min-width: 765px) {

    .main{
      position: absolute;
      width: calc(100% - 40px); 
      margin-left: 40px;
      float: right;
    }

    nav.sidebar:hover + .main{
      margin-left: 200px;
    }

    nav.sidebar.navbar.sidebar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
      margin-left: 0px;
    }

    nav.sidebar .navbar-brand, nav.sidebar .navbar-header{
      text-align: center;
      width: 100%;
      margin-left: 0px;
    }
    
    nav.sidebar a{
      padding-right: 13px;
    }

    nav.sidebar .navbar-nav > li:first-child{
      border-top: 1px #e5e5e5 solid;
    }

    nav.sidebar .navbar-nav > li{
      border-bottom: 1px #e5e5e5 solid;
    }

    nav.sidebar .navbar-nav .open .dropdown-menu {
      position: static;
      float: none;
      width: auto;
      margin-top: 0;
      background-color: transparent;
      border: 0;
      -webkit-box-shadow: none;
      box-shadow: none;
    }

    nav.sidebar .navbar-collapse, nav.sidebar .container-fluid{
      padding: 0 0px 0 0px;
    }

    .navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
      color: #777;
    }

    nav.sidebar{
      width: 200px;
      height: 100%;
      margin-left: -160px;
      float: left;
      margin-bottom: 0px;
    }

    nav.sidebar li {
      width: 100%;
    }

    nav.sidebar:hover{
      margin-left: 0px;
    }

    .forAnimate{
      opacity: 0;
    }
  }
   
  @media (min-width: 1330px) {

    .main{
      width: calc(100% - 200px);
      margin-left: 200px;
    }

    nav.sidebar{
      margin-left: 0px;
      float: left;
    }

    nav.sidebar .forAnimate{
      opacity: 1;
    }
  }

  nav.sidebar .navbar-nav .open .dropdown-menu>li>a:hover, nav.sidebar .navbar-nav .open .dropdown-menu>li>a:focus {
    color: #CCC;
    background-color: transparent;
  }

  nav:hover .forAnimate{
    opacity: 1;
  }
  section{
    padding-left: 15px;
  }
  
 /* Sticky footer styles
-------------------------------------------------- */

body {
  /* Margin bottom by footer height */
  margin-bottom: 20px;
}
.footer {
  position: relative+30px;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 0px;
  background-color: #f5f5f5;
}
.padtop{padding-top:10px;}
</style>
   <link href="css/agency.css" rel="stylesheet">
   <div class="padtop">
<div class="row">
<div class ="col-md-2">
<nav class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
    </div>
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#" data-toggle="modal" data-target="#myModal">Database Status<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>         
        <li ><a href="#" data-toggle="modal" data-target="#myModal1">Startup Parameters<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>        
        <li ><a href="#"  data-toggle="modal" data-target="#myModal2" >Data Area<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>
        <li ><a href="#"  data-toggle="modal" data-target="#myModal3">Primary Recovery Area<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>
        <li ><a href="#"  data-toggle="modal" data-target="#myModal4">After Image Area<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>
        <li ><a href="#"  data-toggle="modal" data-target="#myModal5">CPU Utilization<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>
        <li ><a href="#"  data-toggle="modal" data-target="#myModal6">Memory Utilization<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>
        <li ><a href="#" data-toggle="modal" data-target="#myModal7">Disk Utilization<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tags"></span></a></li>
      </ul>
    </div>
  </div>
</nav>
</div>
<div class="col-md-10">
<div class="col-md-12">
<div class="col-md-8">
<div class="col-md-12">
<div class="alert alert-info" style="padding: 8px 35px 8px 14px; margin-bottom: 18px;border: 1px solid #fbeed5;-webkit-border-radius: 4px;  -moz-border-radius: 4px;  border-radius: 4px; background-color: #428bca;color:#fdfdfd;">
  <strong>Database Name: <?php echo $currentdb?></strong>
  <strong style="float:right">Host Name: <?php echo $hostname?></strong>
</div>
<div class="col-md-12">
<div class="col-md-12">
<div class="col-md-6">
<div id="chart2_div"></div>
</div>
<div class="col-md-6">
<div id="chart1_div" ></div>
</div>
</div>
<div class="col-md-12">
<div class="col-md-6">
<div id="chart3_div" ></div>
</div>
<div class="col-md-6">
 <div id="chart_div"></div>
 </div>
 </div>
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="panel-group " id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default" style="background-color:#428bca;">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title" style="font-size:100%;">
        <a style ="color:#b94a48; " data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Critical Alerts  <span style="background-color:#b94a48;"class="badge"><?php echo $numcritical ?></span>  <span style="float:right;" class="glyphicon glyphicon-bell" aria-hidden="true"></span>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
                     <?php while($criticalalert = mysqli_fetch_assoc($criticalal)){
						$criticalalertdisc = $criticalalert["alertdisc"];
						echo'  <div class="alert alert-danger">';
					echo	'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
								echo"<strong>Critical!</strong>"." ".$criticalalertdisc.".";
								echo'</div>';
						} ?>
      </div>
    </div>
  </div>
  <div class="panel panel-default"style="background-color:#428bca;">
    <div class="panel-heading" style="color:#febe29;"role="tab" id="headingTwo">
      <h4 class="panel-title" style="font-size:100%;">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         Major Alerts <span style="background-color:#febe29"class="badge"><?php echo $nummajor?></span><span style="float:right;" class="glyphicon glyphicon-bell " aria-hidden="true"></span>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
                <?php while($majoralert = mysqli_fetch_assoc($majoral)){
						$majoralertdisc = $majoralert["alertdisc"];
						echo'  <div class="alert alert-warning">';
						echo	'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
								echo"<strong>Major!</strong>"." ".$majoralertdisc.".";
								echo'</div>';
						} ?>
      </div>
    </div>
  </div>
  <div class="panel panel-default" style="background-color:#428bca;">
    <div class="panel-heading" style ="color:#3e5e9a;" role="tab" id="headingThree">
	
      <h4 class="panel-title"style="font-size:100%;">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
         Minor Alerts <span style="background-color:#3e5e9a" class="badge"><?php echo $numminor?></span><span style="float:right;" class="glyphicon glyphicon-bell" aria-hidden="true"></span>
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
         <?php while($minoralert = mysqli_fetch_assoc($minoral)){
						$minoralertdisc = $minoralert["alertdisc"];
						echo'  <div class="alert alert-info">';
						echo	'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
								echo"<strong>Minor!</strong>".$minoralertdisc.".";
								echo'</div>';
						} ?>
      </div>
    </div>
  </div>

</div>
</div>
</div>
</div>
<div class="col-md-12">
<div class="col-md-8">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
	Database I/O Activity</h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/databaseactivity.php"
	   data-query-params="activityQuery"
	    data-response-handler="responseHanlder"
       data-sort-order="desc"
	    data-show-export="true"
	   data-show-refresh="true"
	   data-show-columns="true"
		id="tab1"
	>
<thead>
     <tr>
        <th data-field="key" class="key">Key</th>
        <th data-field="value">Value</th>
    </tr>
    </thead>
</table>
  </div>
</div>
</div>

<div class="col-md-4">
	  <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
	Database Features</h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/databasefeature.php"
	   data-query-params="efQuery"
       data-sort-order="desc"
	   data-show-refresh="true"
	    data-show-export="true"
	   data-search="true"
	   data-show-columns="true"
		id="tab1">
    <thead>
    <tr>
        <th data-field="FEAT" 
            data-sortable="true">
                Feature Name
        </th>
        <th data-field="ENA" 
            data-sortable="true">
                Active
        </th>
        <th data-field="ACT" 
            data-sortable="true">
                Enabled
        </th>
    </tr>
    </thead>
</table>
  </div>
</div>
</div>
</div>
	  <!-- Modal -->
<div class="portfolio-modal modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
		<img src="images/logo.png" style="margin-top:-80px;padding-left:20px;"class="pull-left">
<div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
Database Status</h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/databaseinfo.php"
	   data-query-params="dbiQuery"
       data-sort-order="desc"
	    data-show-export="true"
	   data-show-refresh="true"
	   data-search="true"
	   data-show-columns="true"
	     id="tab1"
	>
    <thead>
    <tr>
        <th data-field="_DbStatus-DbBlkSize" 
data-halign="center"
            >
			Block Size
        </th>

  

        <th data-field="_DbStatus-TotalBlks" 
data-halign="center"
            >
          Total Size (MB)
        </th>

<th data-field="_DbStatus-EmptyBlks" 
data-halign="center"
          >
           Used Space (MB)
        </th> 
        
		    
		<th data-field="_DbStatus-RMFreeBlks" 
data-halign="center"
          >
            Free Space (MB)
        </th>   
		<th data-field="_DbStatus-CreateDate" 
data-halign="center"
          >
          Created On
        </th>       
		<th data-field="_DbStatus-starttime" 
data-halign="center"
          >
              Started On
        </th>       
			<th data-field="_DbStatus-fbDate" 
data-halign="center"
          >
        Last Full Backup
        </th>          
		<th data-field="_DbStatus-ibDate"
data-halign="center" 
          >
         Last Incremental Backup
        </th>          
		
    </tr>
    </thead>
</table>
</div>
</div>
</div></div>
</div>
<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
        </div>
    </div>

    <div class="portfolio-modal modal fade" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
		<img src="images/logo.png" style="margin-top:-80px;padding-left:20px;"class="pull-left">
           <div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Database Startup Parameters</h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/databasestartupparams.php"
	   data-query-params="startupQuery"
       data-sort-order="desc"
	   data-show-refresh="true"
	    data-show-export="true"
	    data-response-handler="responseHanlder1"
	   data-pagination="true"
	   data-search="true"
	   data-show-columns="true"
	     id="tab1"
	>
    <thead>
    <tr>
        <th data-halign="center" data-field="key" class="key">Key</th>
        <th data-halign="center" data-field="value">Value</th>
    </tr>
    </thead>
</table>
</div>
</div>
</div></div>
</div>
  <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
        </div>
    </div>
 <!-- Portfolio Modal 2 -->
    <div class="portfolio-modal modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
		<img src="images/logo.png" style="margin-top:-80px;padding-left:20px;"class="pull-left">
<div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
Data Area </h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/databaseareastatus.php"
	   data-query-params="areastatQuery"
       data-sort-order="desc"
	    data-show-export="true"
	   data-show-refresh="true"
	   data-pagination="true"
	   data-search="true"
	   data-show-columns="true"
	     id="tab1"
	>
    <thead>
    <tr>
        <th data-field="_AreaStatus-Areaname" 
data-halign="center"
            >
              Area Name
        </th>
        <th data-field="_AreaStatus-Areanum" 
data-halign="center"
            >
              Area Number
        </th>
        
		 <th data-field="_AreaStatus-Extents" 
data-halign="center"
          >
               Total Extents
        </th>   
		<th data-field="_AreaStatus-Totblocks" 
data-halign="center"
          >
               Area Size 
        </th>   
		<th data-field="_AreaStatus-Hiwater" 
data-halign="center"
          >
             Used (%)
        </th>   
		<th data-field="_AreaStatus-Freenum"
data-halign="center" 
          >
               Used Space 
        </th>       
		
    </tr>
    </thead>
</table>
</div>
</div>
</div></div>
</div>
 <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
        </div>
    </div>
<!-- Modal -->
  <div class="portfolio-modal modal fade" id="myModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">    
<img src="images/logo.png" style="margin-top:-80px;padding-left:20px;"class="pull-left">		
<div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
Primary Recovery Area</h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/databaseprimaryrecovery.php"
	   data-query-params="prQuery"
       data-sort-order="desc"
	   data-show-refresh="true"
	    data-show-export="true"
	   data-search="true"
	   data-show-columns="true"
	     id="tab1"
	>
    <thead>
    <tr>
       
   
        
		 <th data-field="_Logging-BiBlkSize"
data-halign="center" 
          >
              BI Block Size
        </th>   
		<th data-field="_Logging-BiClSize" 
data-halign="center"
          >
              BI Cluster Size
        </th>   
		<th data-field="_Logging-BiExtents"
data-halign="center" 
          >
             Number of Extents
        </th>   
		<th data-field="_Logging-BiLogSize" 
data-halign="center"
          >
              BI File Size
        </th>       
	      
			<th data-field="_Logging-BiBuffs"
data-halign="center" 
          >
               Total BI buffers
        </th>       
			<th data-field="_Logging-BiFullBuffs"
data-halign="center" 
          >
Full BI buffers
        </th>    

     <th data-field="_Logging-LastCkp" 
data-halign="center"
            >
            Last Checkpoint
        </th>   
		
    </tr>
    </thead>
</table>
</div>
</div>
</div></div>
</div>
 <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
        </div>
    </div>
<!-- Modal -->
 <div class="portfolio-modal modal fade" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
		<img src="images/logo.png" style="margin-top:-80px;padding-left:20px;"class="pull-left">
            <div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">  
After Image Area</h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/databaseafterimage.php"
	   data-query-params="startupQuery"
       data-sort-order="desc"
	    data-show-export="true"
	   data-show-refresh="true"
	   data-pagination="true"
	   data-search="true"
	   data-show-columns="true"
	     id="tab1"
	>
    <thead>
    <tr>
        <th data-field="_Logging-AiOpen"
data-halign="center"
            >
          Last AI File View
        </th>
        <th data-field="_Logging-AiBegin"
data-halign="center" 
            >
           After Image Begin
        </th>
        
		 <th data-field="_Logging-AiNew"
data-halign="center" 
          >
            AI extent switch
        </th>   
		<th data-field="_Logging-AiGenNum" 
data-halign="center"
          >
             Extent in use
        </th>   
		<th data-field="_Logging-AiExtents" 
data-halign="center"
          >
             Total Extents
        </th>   
		<th data-field="_Logging-AiBuffs" 
data-halign="center"
          >
             AI Buffers
        </th>       
		<th data-field="_Logging-AiBlkSize" 
data-halign="center"
          >
             AI Block Size
        </th>
    </tr>
    </thead>
</table>
</div>
</div>
</div></div>
</div>
<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
        </div>
    </div>

<!-- Modal -->
    <div class="portfolio-modal modal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
		<img src="images/logo.png" style="margin-top:-80px;padding-left:20px;"class="pull-left">
<div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">CPU utilization</h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/cpuutil.php"
	   data-query-params="cpuQuery"
	    data-show-export="true"
       data-sort-order="desc"
	   data-show-refresh="true"
	   id="tab1"
	>
    <thead>
    <tr>
        <th data-field="user" 
         data-halign="center"
            >
              User Utilization ( % )
        </th>
		<th data-field="sys" 
               data-halign="center"
            >
               System Utilization ( % )
        </th>
		<th data-field="idle" 
               data-halign="center"
            >
              IDLE ( % )
        </th>

		
    </tr>
    </thead>
</table>
</div>
</div>
</div>
</div>
</div>
 <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
        </div>
    </div>

<!-- Modal -->
    <div class="portfolio-modal modal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
		<img src="images/logo.png" style="margin-top:-80px;padding-left:20px;"class="pull-left">
<div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
Memory Utilization</h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/memutil.php"
	   data-query-params="memQuery"
	    data-show-export="true"
       data-sort-order="desc"
	   data-show-refresh="true"
	   	   id="tab1"
	>
   <thead>
    <tr>
        <th data-field="MemTotal" data-halign="center">Total Memory</th>
        <th data-field="MemFree" data-halign="center">Free Memory</th>
        <th data-field="SwapTotal" data-halign="center">Swap Total</th>
        <th data-field="SwapFree" data-halign="center">Swap Free</th>
    </tr>
    </thead>
</table>
</div>
</div>
</div>
</div>
        </div>
 <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
    </div>
    </div>

<!-- Modal -->
    <div class="portfolio-modal modal fade" id="myModal7" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
		<img src="images/logo.png" style="margin-top:-80px;padding-left:20px;"class="pull-left">
<div class="pad">
<div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
Disk Utilization</h3>
  </div>
  <div class="panel-body">
<table data-toggle="table"
       data-url="ajax/diskutil.php"
	   data-query-params="dbInfo"
       data-sort-order="desc"
	    data-show-export="true"
	   data-show-refresh="true"
	   data-show-export="true"
	   data-pagination="true"
	   data-search="true"
	   data-show-columns="true"
	    id="tab1"
	>
    <thead>
    <tr>
        <th data-field="FILESYSTEM" 
        data-halign="center"
            >
              Filesystem
        </th>
        <th data-field="1KBLOCKS" 
        data-halign="center"
            >
               	Size (KB)
        </th>
		<th data-field="USED" 
         data-halign="center"
            >
              Used (KB)
        </th>
		<th data-field="AVAILABLE" 
        data-halign="center"
            >
             Available (KB)
        </th>
			<th data-field="USED%" 
                        data-halign="center"
						>
						 Used %
					</th>
			<th data-field="MOUNTED" 
                        data-halign="center"
						>
				 Mounted On
					</th>

		
    </tr>
    </thead>
</table>
</div>
</div>
</div>
</div>
</div>
  <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
        </div>
    </div>
    </div>
<script>
function dbInfo() {
    return {
       dbuid:<?php echo "'$currentdb'" ;?>
    };
}
function memQuery() {
    return {
       dbuid:<?php echo "'$currentdb'" ;?>
    };
}
function cpuQuery() {
    return {
       dbuid:<?php echo "'$currentdb'" ;?>
    };
}
function areastatQuery() {
    return {
       dbuid:<?php echo "'$currentdb'" ;?>
    };
}
function prQuery() {
    return {
       dbuid:<?php echo "'$currentdb'" ;?>
    };
}function startupQuery() {
    return {
       dbuid:<?php echo "'$currentdb'" ;?>
    };
}
function dbiQuery() {
    return {
       dbuid:<?php echo "'$currentdb'" ;?>
    };
}
function activityQuery() {
    return {
     dbuid:<?php echo "'$currentdb'" ;?>
    };
}
function efQuery() {
    return {
     dbuid:<?php echo "'$currentdb'" ;?>
    };
}
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
function responseHanlder1(res) {
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
  </body>
</html>
