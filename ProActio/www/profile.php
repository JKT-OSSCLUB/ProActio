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
 include('session.php');
 ob_start();
 include('sqlconnect.php');
 if(isset($_SESSION['sql'])){
  include('selectdblogic.php');
 require_once('reqregisterlogic.php');
if(!isset($_SESSION['dbid'])){
header("location: selectdb.php");
}

$username=$_SESSION['login_username'];
$currentdb=$_SESSION['dbid'];
$reqquery=mysqli_query($connect,"SELECT distinct configureddb.dbuid,dbname FROM configureddb WHERE (dbuid) NOT IN ( SELECT dbuid FROM dbparam WHERE userid = '$username') and (dbuid) NOT IN (SELECT dbuid FROM request WHERE userid ='$username')");

$query = mysqli_query($connect,"SELECT dbname FROM configureddb INNER JOIN dbparam where dbparam.dbuid=configureddb.dbuid and dbparam.userid ='$username' and dbparam.dbuid='$currentdb'");
$row = mysqli_fetch_row($query);
$dbname=$row[0];
$query1 = mysqli_query($connect,"select alerts.alertid, alertdesc.alertdisc from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$currentdb' and alertdesc.alerttype = 'Minor' and alerts.alert_read = 0");
$query2 = mysqli_query($connect,"select alerts.alertid, alertdesc.alertdisc from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$currentdb' and alertdesc.alerttype = 'Major' and alerts.alert_read = 0");
$query3 = mysqli_query($connect,"select alerts.alertid, alertdesc.alertdisc from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$currentdb' and alertdesc.alerttype = 'Critical' and alerts.alert_read = 0");
$query4 = mysqli_query($connect,"SELECT name from login_db where user_id = '$username'");
$row1 = mysqli_fetch_row($query4);
$nameuser=$row1[0];

$numcritical=mysqli_num_rows($query3); 
$numminor=mysqli_num_rows($query1);
$nummajor=mysqli_num_rows($query2);
$total=$numcritical+$nummajor+$numminor;
mysqli_close($connect);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/Magnifying-glass.ico">
<title>Application User</title>
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/locale/bootstrap-table-en-US.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sprintf/1.0.3/sprintf.min.js"></script>
  <script src="https://rawgit.com/kayalshri/tableExport.jquery.plugin/master/tableExport.js"></script>
  <script src="https://rawgit.com/wenzhixin/bootstrap-table/master/src/extensions/export/bootstrap-table-export.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://rawgit.com/kayalshri/tableExport.jquery.plugin/master/jquery.base64.js"></script>
-->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-table.min.css">
<link rel="stylesheet" href="css/datepicker.min.css" />
<link rel="stylesheet" href="css/datepicker3.min.css" />
  <script src="js/1.11.1_jquery.min.js"></script>
	<script type="text/javascript" src="js/1.10.2_jquery.min.js"></script>
	    <script src="js/jquery-ui.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-table-en-US.min.js"></script>
  <script src="js/sprintf.min.js"></script>
  <script src="js/tableExport.js"></script>
  <script src="js/bootstrap-table-export.js"></script>
<script src="js/bootstrap-table.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/jquery.base64.js"></script>

<script src="js/formvalidation1.js"></script>
<script src="js/bootstrap-table-export.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">
<script type="text/javascript" src="js/bootstrap-select.js"></script>
 <style>
.ui-datepicker{ z-index:1151 !important; }
</style>
  <script>
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault(); 
			event.stopPropagation(); 
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
		

	});
  </script>
  <style>
/* bootstrap 3 helpers */
body{
min-height:900px;
}
.navbar-form input, .form-inline input {
	width:auto;
}



header {
	height:90px;
}

#nav.affix {
    position: fixed;
    top: 0;
    width: 100%;
    z-index:10;
}

#sidebar.affix-top {
    position: static;
}

#sidebar.affix {
    position: fixed;
    top: 80px;
}
</style>
<style>
body{
 overflow-x: hidden;
}
.marginBottom-0 {margin-bottom:0;}

.dropdown-submenu{position:relative;}
.dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
.dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
.dropdown-submenu:hover>a:after{border-left-color:#555;}
.dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}

</style>
<style>
.pad{padding-top:30px;}
</style>
<title>Home Page</title>
</head>
<body>
   <header>
<div class="jumbotron" style="height:90px;padding-top:0px; margin-bottom:0;background-color: transparent;">
      <a href="charts.php"><img src="images/logo.png" style="padding-top:10px;padding-left:20px;"></a>
 </div>
 </header>
<div id="nav">
<nav style=" margin-bottom:10;"class="navbar navbar-default navbar-static-top marginBottom-0" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>              
            </div>
            
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
			<li><a>Welcome : <?php echo $username; ?></a></li>
              <li><a   style="padding-right:60px;"href='logout.php'><span>Logout</span></a></li>
            </ul>
                <ul class="nav navbar-nav">
				<li><a href="charts.php">Dashboard</a></li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Services <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Database</a>
								<ul class="dropdown-menu">
									<li><a href='dbstatus.php'><span>Database Status</span></a></li>             						
								   <li><a href='dbactivity1.php'><span>Database I/O Activity I</span></a></li>
					               <li><a href='dbactivity2.php'><span>Database I/O Activity II</span></a></li>
					               <li><a href='areastatus.php'><span>Area Growth Status</span></a></li>	
		                           <li><a href='trans.php'><span>Active Transactions</span></a></li>
	                               <li><a href='recordlock.php'><span>Database Locking</span></a></li>	
	                               <li><a href='userprog.php'><span>Database Users</span></a></li>          	
	                               <li><a href='connectedinfo.php'><span>User Connection</span></a></li>				
	                        	   <li><a href='databasefeatures.php'><span>Database Features</span></a></li>
		                           <li><a href='dbfiles.php'><span>Database Extent Info.</span></a></li>	
		                           <li><a href='servstatus.php'><span>Database Server Status</span></a></li>
								</ul>
							</li>
                            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Server</a>
								<ul class="dropdown-menu">
								
							   <li class='last'><a href='cpuutil.php'><span>CPU Utilization</span></a></li>
							   <li class='last'><a href='memutil.php'><span>Memory Utilization</span></a></li>
							   <li class='last'><a href='diskutil.php'><span>Disk Utilization</span></a></li>
							   <li class='last'><a href='procutil.php'><span>Server Processes </span></a></li>
								</ul>
							</li>
                        </ul>
                    </li>
    
					<li class='last'><a href='alertr.php' target="_blank"><span>Alert Reports</span></a></li>
                    
                    </li>
					<li><a href='alerts.php'><span>Alerts  <span  style="background-color:#b94a48;" class="badge"><?php echo $total?></span></span></a></li>
					 <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Setting <b class="caret"></b></a>
                        <ul class="dropdown-menu">
							<li class='last'><a id ="changeDb" href="#"><span>Change Database</span></a></li>
							<li class='last'><a id ="reqDb" href="#"><span>Request Database</span></a></li>
							<li><a href='changeacc.php'><span>Account Settings</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
		</div>

<script> $('#nav').affix({
      offset: {
        top: $('header').height()
      }
});	

$('#sidebar').affix({
      offset: {
        top: 200
      }
});	

$(document).ready(function(){
    $("#changeDb").click(function(){
        $("#myModalSelect").modal();
    });
});
$(document).ready(function(){
    $("#reqDb").click(function(){
        $("#myModalRequest").modal();
    });
	        $('#dbList').multiselect({
            inheritClass: true
        });
});
</script>
</body>
<div class="container">
<!-- Modal -->
<div class="modal fade" id="myModalSelect" role="dialog">
<div class="modal-dialog">
    
    <!-- Modal content-->
	<div class="modal-content">
	    <div class="modal-header" style="padding:20px 35px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Change Database</h4>		  
        </div>
		<div class="modal-body" style="padding:40px 30px;">
		
			<form action = "" method = "POST" role="search">
				
				<div class="controls">
					<div class="input-group">
					<select  class="selectpicker" id="dbList1" name ="dbname" data-live-search="true" data-size="auto" data-header="Select Database To Monitor " >
					<?php
						while($row=mysqli_fetch_assoc($selquery))
						{
						echo     "<option value='" . $row['dbuid'] . "'>" . $row['dbname'] . "</option>";
						}
					?>
					</select>
							<span class="input-group-btn "><input name="submit" type="submit" value=" Submit  " class="btn btn-primary">
							</span>										
					</div>				
				</div>		
			</form>			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
	<!-- Modal content -->
</div>

</div>
</div>

<!--request modal-->
<div class="container">
<!-- Modal -->
<div class="modal fade" id="myModalRequest" role="dialog">
<div class="modal-dialog">
    
    <!-- Modal content-->
	<div class="modal-content">
	    <div class="modal-header" style="padding:20px 35px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Request Database</h4>		  
        </div>
		<div class="modal-body" style="padding:40px 30px;">
		
			<form action = "" method = "POST" role="search">
				
				<div class="controls">
					<div class="input-group">
					<select  class="selectpicker" id="dbList" name ="dbname[]" multiple data-live-search="true" data-size="auto" data-header="Select a Database" title='Choose Databases'>
					<?php
						while($row=mysqli_fetch_assoc($reqquery))
						{
						echo     "<option value='" . $row['dbuid'] . "'>" . $row['dbname'] . "</option>";
						}
					?>
					</select>
							<span class="input-group-btn "><input name="submitdbase" type="submit" value=" Submit " class="btn btn-primary">
							</span>										
					</div>				
				</div>		
			</form>			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
	<!-- Modal content -->
</div>
</div>
</div>
<html>
