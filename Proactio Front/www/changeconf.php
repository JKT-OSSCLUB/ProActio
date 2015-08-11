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
require_once('sqlconnect.php');
$query=mysqli_query($connect,"SELECT dbuid,dbname from configureddb ");
  ?>
  <html>
  <head>
  <link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">
<script type="text/javascript" src="js/bootstrap-select.js"></script>
<script>
	$(document).ready( function ()
{
  /* we are assigning change event handler for select box */
	/* it will run when selectbox options are changed */
	$('#dbname1').change(function()
	{
		
		/* setting currently changed option value to option variable */
		var option = $(this).find('option:selected').val();
		$.ajax({
        url: "db.php",
        data:"option="+option,
        method: "POST",
		dataType: "json",
        success: function(html) {
        $('#dbname').val(html.dbname);
        $('#dbuser').val(html.dbuser);
        $('#dbpass').val(html.dbpass);
        $('#serv').val(html.server);
        $('#port').val(html.port);
        $('#sslusername').val(html.sslusername);
        $('#sslpassword').val(html.sslpassword);
        $('#environ').val(html.environ);
		$('#dbloc').val(html.dblocation);
        }
		

    });
	});

	$('#changec').bootstrapValidator({
	live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {       
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
                    },

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
                    },
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
                        message: 'The databse location is required'
                    }
            }
        }
       }
    });
		$(function() {
            $('#changec').submit(function (event) {
                event.preventDefault();
                event.returnValue = false;
                $.ajax({
                    type: 'POST',
                    url: 'ajax/changeconf.php',
                    data: $('#changec').serialize(),
                    success: function(res) {
					//alert(res);
                        if (res == 'Success') {
                           $('#modal-content').modal({
								show: true
							});
							document.getElementById("configure").reset();
						   }
                        else {
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
<form  method ="post" id="changec" class="form-horizontal">
<div class="container-fluid">
    <section class="container">
		<div class="container">
			
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
				<div class="form-group">
				<h3 class="dark-grey">Database Configuration Settings</h3>
				</div>
			<div class="row">
				<div class="controls form-group col-xs-12 col-sm-6 col-md-6">
				<div class="input-group">					
				<select name ="dbname1" class="selectpicker" id="dbname1" data-live-search="true" data-size="auto" title='Choose Databases'>
				<option data-hidden="true">Select Database</option>
				<?php while($row=mysqli_fetch_assoc($query))
				{
					echo     "<option value='" . $row['dbuid'] . "'>" . $row['dbname'] . "</option>";
				} ?>
				</select>
				</div>
				</div>
				<h5><a id="face" href="configuredb.php" class="pull-right"><u><b>Configure New Database</u></b></a></h5>
			</div>
				
					<div class="form-group">
					<label>Database Name</label>
					<input type="text" name="dbname" class="form-control " id="dbname" value="">
					</div>
			<div class="row">				
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
					<label>Database Username</label>
					<input type="text" name="dbuser" class="form-control " id="dbuser" value="">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
					<label>Database Password</label>
					<input type="password" name="dbpass" class="form-control " id="dbpass" value="">
				</div>
			</div>
			</div>
			<div class="row">				
				
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
					<label>Server</label>
					<input type="text" name="serv" class="form-control " id="serv" value="">
				</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
					<label>Port</label>
					<input type="text" name="port" class="form-control " id="port" value="">
				</div>
				</div>
			</div>
			<div class="row">				
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
					<label>Server Username</label>
					<input type="text" name="sslusername" class="form-control " id="sslusername" value="">
				</div>			
				</div>	
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
					<label>Server Password</label>
					<input type="password" name="sslpassword" class="form-control " id="sslpassword" value="">
				</div>
				</div>
			</div>			
			<div class="row">				
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
					<label>Environment</label>
					<input type="Text" name="environ" class="form-control " id="environ">
				</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
					<label>Database Path</label>
					<input type="Text" name="dbloc" class="form-control " id="dbloc">
				</div>
				</div>
			</div>
			<div class="row" >
				<div class="col-lg-6 form-group">
				<button type="submit" name = "submitupdate"class="btn btn-block btn-lg btn-primary">Update</button>
				</div>
				<div class="col-lg-6 pull-right form-group">
				<button class="btn btn-block btn-primary btn-lg" type="reset">Reset</button>
				
				</div>
				
			</div>
				
				
			</div>
				
			</div>
			
		</div>
	</section>
</div>
</form>
<div id="modal-content" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#5cb85c;">
                <button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Success</h3>
            </div>
			
            <div class="modal-body">
			Your Update is Successful 
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
			An error Occurred while Updating Your Database Configuration
            </div>
        </div>
    </div>
</div>
</body>
</head>