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
require_once('change.php');
if(!isset($_SESSION['login_username'])){
header("location: index.php");
}
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
<!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
-->

<link rel="stylesheet" href="css/bootstrapValidator.min.css"/>
<script type="text/javascript" src="js/bootstrapValidator.min.js"></script>

<div class="container col-md-6">
	<div role="tabpanel">
		<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">User Details</a></li>
		<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Change Password</a></li>
		</ul>
 
   <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home">
		<div class="container-fluid">
		<section class="container">
		<div class="container-page">				
		<div class="col-md-6">
		<h3 class="dark-grey">User Details</h3>
		<form action=""method ="post" name="change" id="change" class="form-horizontal">
		
		<div class="form-group col-lg-12">
					<label>Current Password</label>
					<input type ="Password" name = "currentpassw" class="form-control" id="" value="">
		</div>
		<div class="form-group col-lg-12">
					<label>New Name</label>
					<input type ="text" name = "newname" class="form-control" id="" value="">
		</div>
        <div class="form-group col-lg-12">
					<label>New Email</label>
					<input type ="text" name = "newemail" class="form-control" id="" value="">
		</div>
		<div class="form-group col-lg-12" >
					<button type ="submit" name = "changepi" class="btn btn-large btn-block btn-primary">Update</button>
		</div>
		</form>
		
		</div>
		</div>
		</section>
		</div>
	  </div>
      
	 
		
              
      <div role="tabpanel" class="tab-pane" id="profile">
		<div class="container-fluid">
		<section class="container">
		<div class="container-page">				
		<div class="col-md-6">
		<h3 class="dark-grey">Change Password</h3>
		<form action=""method ="post" id="changepassword">
		<div class="form-group col-lg-12">
					<label>Current Password</label>
					<input type ="Password" name = "currentpass" class="form-control" id="" value="">
		</div>
		<div class="form-group col-lg-12">
					<label>New Password</label>
					<input type ="Password" name = "newpass" class="form-control" id="" value="">
		</div>
		<div class="form-group col-lg-12">
					<label>Confirm New Password</label>
					<input type ="Password" name = "confirmpass" class="form-control" id="" value="">
		</div>
		<div class="form-group col-lg-12"" >
					<button type ="submit" name = "changepass" class="btn btn-large btn-block btn-primary">Update</button>
					</div>
		</form>
        </div>
		</div>
		</section>
		</div>
	  </div>

 

    </div>
</div>
</div>
<?php if(!$msg==""){?>
<div id ="abc" class=" col-md-4 pull-right alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   <?php echo $msg;?>
</div>
<?php }?>

<script>
$(document).ready(function() {
	$('#change').bootstrapValidator({
		live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
		currentpassw: {
            validators: {
				notEmpty: {
                        message: 'The password  is required'
                    },
					different: {
                    field: 'newname',
                    message: 'The username and password cannot be the same as each other'
                },
				stringLength: {
                        max: 15,
						min: 8,
                        message: 'The password must be more then 8 characters less than 15 characters'
                }
            }
        },
           newname: {
                validators: {
                    notEmpty: {
                        message: 'The Username is required and cannot be empty'
                    },
					stringLength: {
                        max: 15,
						min: 7,
                        message: 'The Username must be more then 7 characters less than 15 characters'
                    }
                }
            },        	
			newemail: {
                validators: {
                    notEmpty: {
                        message: 'The Email is required and cannot be empty'
                    },
                    regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'The value is not a valid email address'
                      }
                }
            }
			
            
       }
    });
	$('#changepassword').bootstrapValidator({
	live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
		currentpass: {
            validators: {
				notEmpty: {
                        message: 'The password  is required'
                    },
				stringLength: {
                        max: 15,
						min: 8,
                        message: 'The password must be more then 8 characters less than 15 characters'
                }
            }
        },
		newpass: {
            validators: {
				notEmpty: {
                        message: 'The password  is required'
                    },
				stringLength: {
                        max: 15,
						min: 8,
                        message: 'The password must be more then 8 characters less than 15 characters'
          }
		  }
        },
		confirmpass: {
            validators: {
				notEmpty: {
                        message: 'The password  is required'
                    },
				stringLength: {
                        max: 15,
						min: 8,
                        message: 'The password must be more then 8 characters less than 15 characters'
                },
				identical: {
                    field: 'newpass',
                    message: 'The password and its confirm are not the same'
            }
			}
        }      
       }
    });
	});
</script>
</body>
</html>