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
?> 

<style>
.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #029f5b;
	font-size: 18px;
}
.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}


</style>
<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Change Email</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Change Password</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12 ">
								<form id="login-form" method="post" role="form" style="display: block;" autocomplete="false" class="form-horizontal">
									<div class="form-group">
										<input type="email" name="oldemail" id="oldemail" tabindex="1" autocomplete="false" class="form-control" placeholder="Existing Email ID" value="">
									</div>
									<div class="form-group">
										<input type="email" name="newemail" id="newemail" tabindex="2"  autocomplete="false" class="form-control" placeholder=" New Email ID" value="">
									</div>
										
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="3" autocomplete="false"  class="form-control" placeholder="Password">
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3 text-center">
												<input type="submit" name="email-change" tabindex="4" class="form-control btn btn-primary" value="Update">
												
											</div>
										</div>
										
									</div>
								</form>
								<form id="register-form"  method="post" role="form" style="display: none;" class="form-horizontal">
									<div class="form-group">
										<input type="password" name="oldpass" id="password" tabindex="1" class="form-control" placeholder="Old Password">
									</div>									
									<div class="form-group">
										<input type="password" name="newpass" id="password" tabindex="2" class="form-control" placeholder="New Password">
									</div>
									<div class="form-group">
										<input type="password" name="confirmpass" id="confirm-password" tabindex="3" class="form-control" placeholder="Confirm Password">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="passchange" id="register-submit" tabindex="4" class="form-control btn btn-primary" value="Update">
											<h4 style="color:red;"class="form-signin-heading"></h4>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-content" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#5cb85c;">
                <button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Success</h3>
            </div>
			
            <div class="modal-body">
			Update Successful 
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
	<script>
$(function() {

    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});

</script>
<script>
$(document).ready(function() {
	$('#login-form').bootstrapValidator({
	live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
           oldemail: {
                validators: {
		              regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'The value is not a valid email address'
                        },
                    notEmpty: {
                        message: 'The old email is required and cannot be empty'
                    }
                }
            },        
			newemail: {
                validators: {
				     regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'The value is not a valid email address'
                        },
                    notEmpty: {
                        message: 'The New Email is required and cannot be empty'
                    }
                }
            },
			password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required and cannot be empty'
                    }
                }
            }
       }
    });
		$('#register-form').bootstrapValidator({
	live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
           oldpass: {
                validators: {
                    notEmpty: {
                        message: 'The Old Password is required and cannot be empty'
                    }
                }
            },        
			newpass: {
                validators: {
                    notEmpty: {
                        message: 'The New Password is required and cannot be empty'
                    },
					stringLength: {
					min: 8,
					 max: 30,
                        message: 'The Password Must Be between 8-30 Characters'
                    },
					identical: {
                    field: 'confirmpass',
                    message: 'The password and its confirm are not the same'
                }
                }
            },
			confirmpass: {
                validators: {
                    notEmpty: {
                        message: 'The Confirm Password is required and cannot be empty'
                    },
					stringLength: {
					min: 8,
					 max: 30,
                        message: 'The Password Must Be between 8-30 Characters'
                    },
					identical: {
                    field: 'newpass',
                    message: 'The password and its confirm are not the same'
                }
                }
            }
       }
    });
	$(function() {
            $('#login-form,#register-form').submit(function (event) {
                event.preventDefault();
                event.returnValue = false;
                $.ajax({
                    type: 'POST',
                    url: 'ajax/changeemailpass.php',
                    data: $('#login-form,#register-form').serialize(),
                    success: function(res) {
					//alert(res);
                        if (res == 'Success') {
                           $('#modal-content').modal({
								show: true
							});
						//	document.getElementById("login-form").reset();
						//	document.getElementById("register-form").reset();
						   }
                        else if(res=='Error') {
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