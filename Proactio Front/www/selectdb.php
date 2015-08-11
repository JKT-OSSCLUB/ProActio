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
include('selectdblogic.php');
require_once('session.php');
require('sqlconnect.php');
require_once('reqregisterlogic.php');
$username = $_SESSION['login_username'];
$approved=mysqli_query($connect,"SELECT configureddb.dbuid,configureddb.dbname FROM configureddb INNER JOIN dbparam where dbparam.dbuid=configureddb.dbuid and dbparam.userid ='$username'");
$requested=mysqli_query($connect,"SELECT distinct request.dbuid,configureddb.dbname FROM configureddb INNER JOIN request where request.dbuid=configureddb.dbuid and request.userid ='$username'");
$reqquery=mysqli_query($connect,"SELECT distinct configureddb.dbuid,dbname FROM configureddb WHERE (dbuid) NOT IN ( SELECT dbuid FROM dbparam WHERE userid = '$username') and (dbuid) NOT IN (SELECT dbuid FROM request WHERE userid ='$username')");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="images/Magnifying-glass.ico">
<title>Select/Request Database</title>
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   
<link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">
<script type="text/javascript" src="js/bootstrap-select.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/locale/bootstrap-table-en-US.min.js"></script> -->

<script type="text/javascript" src="js/1.10.1_jquery.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
   
<link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">
<script type="text/javascript" src="js/bootstrap-select.js"></script>

<link rel="stylesheet" href="css/bootstrap-table.min.css">
<script src="js/bootstrap-table.min.js"></script>
<script src="js/bootstrap-table-en-US.min.js"></script>
 <script> 
$(document).ready(function(){
    $("#selDb").click(function(){
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
<style>
  .btn-success {
      width: 100%;
      padding: 10px;
  }
	    	.row{
		    margin-top:40px;
		    padding: 0 10px;
		}
		.clickable{
		    cursor: pointer;   
		}

		.panel-heading div {
			margin-top: -18px;
			font-size: 15px;
		}
		.panel-heading div span{
			margin-left:5px;
		}
		.panel-body{
			display: none;
		}
		z-index:1151 !important;
</style>

  </head>

  <body>
  <header>

<div class="jumbotron" style="height:90px;padding-top:0px; margin-bottom:0;background-color: transparent;">
      <a href="#"><img src="images/logo.png" style="padding-top:10px;padding-left:20px;"></a>
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
				<li><a   style="padding-right:100px;"href='logout.php'><span>Logout</span></a></li>
            </ul>
              
            </div><!-- /.navbar-collapse -->
        </nav>
		</div>
<div class="col-lg-12">

<div class="col-md-9">
 <div class="col-md-12 container">
	<div class="jumbotron" style=" padding: 0 10px;height:390px;">
		<h1 style="padding-top:20px;"><center>Welcome to ProActio</center></h1>   
		<h2><center>OpenEdge Monitor</center></h2><h3><center> Database Monitoring Solution for OpenEdge Databases</center></h3><br>
		<h4><center>Choose an option to get started</center></h4>      
	
		<div class="row col-md-6 col-md-offset-3">
			<a class="btn btn-primary btn-lg pull-left" id ="reqDb" role="button">Request Database</a>  
			<a class="btn btn-primary btn-lg pull-right"  id ="selDb" role="button">Select Database</a>
		</div>	
	</div>
 </div>
 <?php if(!$error==""){?>
<div id ="abc" class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 <b> <center style="font-size:15px;"> <?php echo $error;?> </center></b>
</div>
<?php }?>
</div>

<div class="container col-md-3">
<div class="col-md-12" style=" margin-top:20px;padding: 0 10px;">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Approved Requests</h3>
						<div class="pull-right">
							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
								<i class="glyphicon glyphicon-filter"></i>
							</span>
						</div>
					</div>
					<div class="panel-body">
						<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filter Requested Databases" />
					</div>
					<table data-toggle="table" class="table table-hover" id="dev-table">
						<thead>
							<tr>
								<th data-halign="center" data-align="center">Database Name</th>
							</tr>
						</thead>
						<tbody>
							
								 <?php
									while($row1=mysqli_fetch_assoc($approved))
									{
									echo     "<tr id='". $row1['dbuid']."'><td>" . $row1['dbname'] . "</td></tr>";
									}
								?>
							
						</tbody>
					</table>
				</div>
			</div>
			
			<!-- -->
<div class="col-md-12" style=" margin-top:40px;padding: 0 10px;">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Pending Requests</h3>
						<div class="pull-right">
							<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
								<i class="glyphicon glyphicon-filter"></i>
							</span>
						</div>
					</div>
					<div class="panel-body">
						<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-approve" placeholder="Filter Approved Databases" />
					</div>
					<table data-toggle="table" class="table table-hover" id="dev-approve">
						<thead>
							<tr>
								<th data-halign="center" data-align="center">Database Name</th>
							</tr>
						</thead>
						<tbody>
							<?php
									while($row2=mysqli_fetch_assoc($requested))
									{
									echo     "<tr id='". $row2['dbuid']."'><td>" . $row2['dbname'] . "</td></tr>";
									}
								?>
						</tbody>
					</table>
				</div>
			</div>
</div>
<div class="container">
<!-- Modal -->
<div class="modal fade" id="myModalSelect" role="dialog">
<div class="modal-dialog">
    
    <!-- Modal content-->
	<div class="modal-content">
	    <div class="modal-header" style="padding:20px 35px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Select Database</h4>		  
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
							<span class="input-group-btn "><input name="submit" type="submit" value=" Submit database " class="btn btn-primary">
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
<!--Modal Request DB -->
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
							<span class="input-group-btn "><input name="submitdbase" type="submit" value=" Submit database " class="btn btn-primary">
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
  <script>
	/**
*   I don't recommend using this plugin on large tables, I just wrote it to make the demo useable. It will work fine for smaller tables 
*   but will likely encounter performance issues on larger tables.
*
*		<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filter Developers" />
*		$(input-element).filterTable()
*		
*	The important attributes are 'data-action="filter"' and 'data-filters="#table-selector"'
*/
(function(){
    'use strict';
	var $ = jQuery;
	$.fn.extend({
		filterTable: function(){
			return this.each(function(){
				$(this).on('keyup', function(e){
					$('.filterTable_no_results').remove();
					var $this = $(this), 
                        search = $this.val().toLowerCase(), 
                        target = $this.attr('data-filters'), 
                        $target = $(target), 
                        $rows = $target.find('tbody tr');
                        
					if(search == '') {
						$rows.show(); 
					} else {
						$rows.each(function(){
							var $this = $(this);
							$this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
						})
						if($target.find('tbody tr:visible').size() === 0) {
							var col_count = $target.find('tr').first().find('td').size();
							var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">No results found</td></tr>')
							$target.find('tbody').append(no_results);
						}
					}
				});
			});
		}
	});
	$('[data-action="filter"]').filterTable();
})(jQuery);

$(function(){
    // attach table filter plugin to inputs
	$('[data-action="filter"]').filterTable();
	
	$('.container').on('click', '.panel-heading span.filter', function(e){
		var $this = $(this), 
			$panel = $this.parents('.panel');
		
		$panel.find('.panel-body').slideToggle();
		if($this.css('display') != 'none') {
			$panel.find('.panel-body input').focus();
		}
	});
	$('[data-toggle="tooltip"]').tooltip();
})
	</script>
</body>
</html>

 
