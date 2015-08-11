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
include('sqlconnect.php');
  $configured =  mysqli_query($connect , "SELECT dbuid,dbname from configureddb");
  ?>
  <head>
  	<style>
tr{
cursor:pointer
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
.form-control-feedback {
    pointer-events: auto;
}
	</style>
	<script>
$(document).ready(function() {
	$('#configure').bootstrapValidator({
	live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
           dbuid: {
                validators: {
                    notEmpty: {
                        message: 'The Database Id  cannot be empty'
                    },
					stringLength: {
                        max: 15,
						min: 7,
                        message: 'The Database Id must be more then 7 characters less than 15 characters'
                    }
                }
            },        
			dbname: {
                validators: {
                    notEmpty: {
                        message: 'The Database Name  cannot be empty'
                    }
                }
            },
			dbuser: {
                validators: {
                    notEmpty: {
                        message: 'The Username  cannot be empty'
                    }
			 }
            },	
			dbpass: {
                validators: {
                    notEmpty: {
                        message: 'The Password cannot be empty'
                    }
                }
            },
			
            serv: {
            validators: {
				notEmpty: {
                        message: 'The Server IP  is required'
                    }
            }
        },
		port: {
            validators: {
				notEmpty: {
                        message: 'The port Number  is required'
                    },
				stringLength: {
                        max: 5,
                        message: 'The Port Number must be less than 5 characters'
                },
				digits: {
                        message: 'The Port Number can contain digits only'
                    }
            }
        },
		sslusername: {
            validators: {
				notEmpty: {
                        message: 'The ssh username  is required'
                    }
            }
        },
		sslpassword: {
            validators: {
				notEmpty: {
                        message: 'The ssh password  is required'
                    }
            }
        },
		environ: {
            validators: {
				notEmpty: {
                        message: 'The Environment  is required'
                    },
				stringLength: {
                        max: 15,
						min: 3,
                        message: 'The Environment must be more then 3 characters less than 15 characters'
                }
            }
        },
		dbloc: {
            validators: {
				notEmpty: {
                        message: 'The database location is required'
                    }
            }
        }
       }
    });
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
});

$('td').on('click', function() {
		$('#Modal').modal('show');
          var option = $(this).attr("data-id");
		   $.ajax({
        url: "dbconfigdetails.php",
        data:"option="+option,
        method: "POST",
		dataType: "json",
        success: function(html) {
        $('#dbuid').html($('<center> <b>Database ID: </b>' + html.dbuid + '</center>'));
        $('#dbname').html($('<center> <b>Database Name: </b>' + html.dbname + '</center>'));
        $('#server').html($('<center><b> Server IP: </b>' + html.server + '</center>'));
        $('#port').html($('<center> <b>Port:</b> ' + html.port + '</center>'));
        $('#dbuser').html($('<center> <b>Database Username: </b>' + html.dbuser + '</center>'));
        $('#dbpass').html($('<center> <b>Database Password: </b>' + html.dbpass + '</center>'));
        $('#sslusername').html($('<center> <b>Server Username:</b> ' + html.sslusername + '</center>'));
        $('#sslpassword').html($('<center> <b>Server Password: </b>' + html.sslpassword + '</center>'));
        $('#environ').html($('<center> <b>Environment:</b> ' + html.environ + '</center>'));
        $('#dblocation').html($('<center><b>Path: </b>' + html.dblocation + '</center>'));
        }

    });
	});
	$(function() {
            $('#configure').submit(function (event) {
                event.preventDefault();
                event.returnValue = false;
                $.ajax({
                    type: 'POST',
                    url: 'ajax/configuredb.php',
                    data: $('#configure').serialize(),
                    success: function(res) {
					//alert(res);
                        if (res == 'Success') {
                           $('#modal-content').modal({
								show: true
							});
							document.getElementById("configure").reset();
						   }
                        else if(res == 'Error'){
                          $('#modal-content1').modal({
								show: true
							});
                        } 
                    },
                    error: function () {
                           $('#modal-content1').modal({
								show: true
							});
                    }
                });
            });
        });
	});
	 
</script>

  </head>
  <body>
   <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
			 <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h4>Database Configuration</h4>

    </div>
                <div id="modalbody" class="modal-body">
                  <h5 id="dbuid"></h5>
                  <h5 id="dbname"></h5>
                  <h5 id="server"></h5>
                  <h5 id="port"></h5>
                  <h5 id="dbuser"></h5>
                  <h5 id="dbpass"></h5>
                  <h5 id="sslusername"></h5>
                  <h5 id="sslpassword"></h5>
                  <h5 id="environ"></h5>
                  <h5 id="dblocation"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

 
				  <div class="container col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-2">
				  <form id="configure" class="form-horizontal" method="post" >
					<div class="form-group">
					<h3 class="dark-grey ">Configure New Database</h3>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<label>Database Id</label>
							<input type="text" name="dbuid" class="form-control " id="" value="">
						</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<label>Database Name</label>
							<input type="text" name="dbname" class="form-control " id="" value="">
						</div>
						</div>
					</div>
					<div class="row">					
					 <div class="col-xs-12 col-sm-6 col-md-6">
					 <div class="form-group">
						<label>Database Username</label>
						<input type="text" name="dbuser" class="form-control " id="" value="">
					 </div>
					 </div>
						<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<label>Database Password</label>
							<input type="password" name="dbpass" class="form-control " id="" value="">
						</div>
						</div>
					</div>
					<div class="row">					 
						<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<label>Server</label>
							<input type="text" name="serv" class="form-control " id="" value="">
						</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<label>Port</label>
							<input type="text" name="port" class="form-control " id="" value="">
						</div>
						</div>
					</div>
					<div class="row">
					 
					 <div class="col-xs-12 col-sm-6 col-md-6">
					 <div class="form-group">
						<label>Server Username</label>
						<input type="text" name="sslusername" class="form-control " id="" value="">
					 </div>			
					 </div>	
						<div class="col-xs-12 col-sm-6 col-md-6">
					 <div class="form-group">
						<label>Server Password</label>
						<input type="password" name="sslpassword"class="form-control " id="" value="">
					 </div>
					 </div>
					</div>			
					<div class="row">
					 
					 <div class="col-xs-12 col-sm-6 col-md-6">
					 <div class="form-group">
						<label>Environment</label>
						<input type="Text" name="environ" class="form-control " id="" value="">
					 </div>
					 </div>
					 <div class="col-xs-12 col-sm-6 col-md-6">
					 <div class="form-group">
						<label>Database Path</label>
						<input type="Text" name="dbloc" class="form-control " id="" value="">
					 </div>
					 </div>
					</div>
					<div class="row">
					 <div class="col-lg-6 form-group">
						<button type="submit" name = "submitbutton"class="btn btn-block btn-primary btn-lg pull-left">Register</button>
					 </div>
					 <div class="col-lg-6 form-group pull-right">
						<button class="btn btn-block btn-primary btn-lg pull-right" type="reset">Reset</button>
					 </div>
					</div>
				</form>
				</div>
			</div>
			
	

<div class="col-md-3 container pull-right">
<div class="col-md-12" style=" margin-top:40px;padding: 0 10px;">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Configured Databases</h3>
						<div class="pull-right">
							<span class="clickable filter" data-toggle="tooltip" title="Database filter" data-container="body">
								<i class="glyphicon glyphicon-filter"></i>
							</span>
						</div>
					</div>
					<div class="panel-body">
						<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-approve" placeholder="Filter Approved Databases" />					
					</div>
					<table  data-toggle="table" class="table table-hover" id="dev-approve">
						<thead>
							
								<th  data-halign="center"  data-align="center">All Databases</th>
							
						</thead>
						<tbody>
							<?php
									while($row2=mysqli_fetch_assoc($configured))
									{
									echo     "<tr><td data-id='". $row2['dbuid']."'>" . $row2['dbname'] . "</td></tr>";
									}
								?>
						</tbody>
					</table>
				</div>
			</div>
</div>
</div>
</section>
<div id="modal-content" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#5cb85c;">
                <button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Success</h3>
            </div>
			
            <div class="modal-body">
			Your Registration is Successful 
            </div>
        </div>
    </div>
</div>

<div id="modal-content1" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#d9534f;">
                <button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Error</h3>
            </div>
			
            <div class="modal-body">
			An error Occurred while Processing Your Request
            </div>
        </div>
    </div>
</div>

</body>
</html>