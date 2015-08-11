<?php

 include('logindba.php');
include('forget.php')
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
 */?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home Page</title>
<link rel="icon" href="images/Magnifying-glass.ico">
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script src="js/formvalidation1.js"></script>
 <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
-->
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/1.11.1_jquery.min.js"></script>
<script type="text/javascript" src="js/1.10.2_jquery.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>

<script src="js/formvalidation1.js"></script>
 <link rel="stylesheet" href="css/bootstrapValidator.min.css"/>
  <script type="text/javascript" src="js/bootstrapValidator.min.js"></script>
<script>
$(document).ready(function(){
    $("#signUp").click(function(){
        $("#regModal").modal();
    });
});
$(document).ready(function(){
    $("#fpwd").click(function(){
        $("#dbafpwdModal").modal();
    });
});
$(document).ready(function(){
    $("#fupwd").click(function(){
        $("#fpwdModal").modal();
    });
});

</script>
</head>
<body  background=./images/clouds.jpg>

 <header>
	<div class="jumbotron" style="height:90px;padding-top:0px; margin-bottom:0;background-color: transparent;">
     <img src="images/Pro.png" style="padding-top:10px;padding-left:20px;">
 </header>
<style>
 body {
    padding-top: 15px;
    font-size: 12px
  }
  .main {
    max-width: 320px;
    margin: 0 auto;
  }
  .login-or {
    position: relative;
    font-size: 18px;
    color: #aaa;
    margin-top: 10px;
            margin-bottom: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
  }
  .span-user {
    display: block;
    position: absolute;
    left: 50%;
    top: -2px;
    margin-left: -65px;
    background-color: #fff;
    width: 150px;
    text-align: center;
  } 
  .span-dba {
    display: block;
    position: absolute;
    left: 50%;
    top: -2px;
    margin-left: -45px;
    background-color: #fff;
    width: 90px;
    text-align: center;
  }
  .hr-or {
    background-color: #cdcdcd;
    height: 1px;
    margin-top: 0px !important;
    margin-bottom: 0px !important;
  }
  h3 {
    text-align: center;
    line-height: 300%;
  }
</style>


<div class="container col-md-6 col-md-offset-3">
<?php if(!$err==""){?>
<div id ="abc" class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 <b> <center style="font-size:15px;"> <?php echo $err;?> </center></b>
</div>
<?php }?>
<?php if(!$message1==""){?>
<div id ="abc" class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 <b> <center style="font-size:15px;"> <?php echo $message;?> </center></b>
</div>
<?php }?>
<center><?php if(!$msg==""){?></center>
	<div id ="abc" class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   <b><center style="font-size:15px;">   <?php echo $msg;?> </center></b>
	</div>
<?php }?>
<?php if(!$error==""){?>
<div id ="abc" class="alert alert-danger alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<b><center  style="font-size:15px;"><?php echo $error; ?></center></b>
</div>
<?php }?>
<div class="col-md-12" style=" margin-top:20px;padding: 0 10px;">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<center><h4 style="margin-top:0px;">Welcome to ProActio</h4></center>
						<center><h5 style="margin-top:0px;margin-bottom:0px;">Please LogIn To Continue</h5></center>						
					</div>
					<div class="panel-body">
						
  <div class="row">

    <div class="main">
		
      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
          <a id="face"href="#" class="btn btn-lg btn-primary btn-block">User Login</a>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
          <a id="dbaLoginBt"href="#" class="btn btn-lg btn-info btn-block">DBA Login</a>
        </div>
      </div>

	
	  <form role="form" id="dbaLogin" action=""  autocomplete="off" method="post">
	 	        <div class="login-or">
				<hr class="hr-or">
				<span class="span-dba">DBA Login</span>
				</div>
		<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			<input type="text" name="dbausername"  autocomplete="off" class="form-control" placeholder="Enter Username" maxlength =20 required>
        </div>
        </div>
		<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-eye-close"></i></span>
			<input type="password"  autocomplete="off" name="dbapassword" class="form-control" placeholder="Enter Password" required>
        </div>
        </div>
			<button name="dbasubmit" type="submit" class="btn btn-lg btn-info btn-block" >Log In</button>
			<a class="pull-right" id="fpwd" href="#">Forgot password?</a>
      </form>
	  <form role="form" id="uLogin" action=""  autocomplete="off" method="post">
	 	        <div class="login-or">
        <hr class="hr-or">
<span class="span-user">Application User</span>
      </div>
<div class="form-group">
	   <div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		<input type="text" name="username"  autocomplete="off" class="form-control" placeholder="Enter Username" maxlength =20 required>
        </div>
        </div>
      <div class="form-group">
		 <div class="input-group">
		 <span class="input-group-addon"><i class="glyphicon glyphicon-eye-close"></i></span>
          <input type="password"  autocomplete="off" name="password" class="form-control" placeholder="Enter Password" required>
        </div>
        </div>
			<button name="submit"  type="submit" class="btn btn-lg btn-primary btn-block">Log In</button>
			<a class="pull-right" id="fupwd" href="#">Forgot password?</a>
			<a class="pull-left" id="signUp">Register</a>
      </form>
    
    </div>
    
  </div>

<!--panel body--></div>
					
				</div>			
</div>

</div>


<script>
$(document).ready(function(){
$('#uLogin').hide();	
	$('#dbaLoginBt').on('click',function(){
$('#uLogin').hide();
$('#dbaLogin').fadeIn( "fast");		
});
$('#face').on('click',function(){
$('#dbaLogin').hide();		
$('#uLogin').fadeIn( "fast");		
});
});

</script>



<div class="container">

  <!-- Register User Modal -->
  <div class="modal fade" id="regModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:20px 35px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Register</h4>
        </div>
        <div class="modal-body" style="padding:40px 30px;">
           <form action="" method ="POST"  autocomplete="off" name="registerform" id="registerform">
             <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
             <input type="text" name="user" class="form-control" id="usrname" placeholder="Enter Username" maxlength=15>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-close"></span> Password</label>
               <input type="Password" name="pass" class="form-control" id="pass" placeholder="Enter password" maxlength=15>
            </div>
 <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-asterisk"></span> Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name"maxlength=15>
            </div>
			<div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-earphone"></span> Mobile No.</label>
               <input type="Text" name="cpass" class="form-control" id="mob" placeholder="Enter Mobile Number">
            </div>
			<div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-asterisk"></span> Email</label>
              <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email">
            </div>

          
               <button type="submit" name="register" class="btn btn-success"><span class="glyphicon glyphicon-off"></span> Register</button>
          </form>
        </div>
			<div class="modal-footer">
          
			</div>
      </div>
      
    </div>
  </div> 
</div>
<!--Forget password-->
<!--modal-->
<div id="fpwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>          
		  <h4><span class="glyphicon glyphicon-eye-open"></span> Forgot Password?</h4>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                          <h5><span class="glyphicon"></span>                      
                          If you have forgotten your password you can reset it here.</h5>
                            <div class="panel-body">
								<form method="post" action="">
							   <fieldset>                                    
									<div class="form-group">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                     
                                      <input id="userid" placeholder="Enter username" name ="username"class="form-control" type="text" required="">
                                    </div>
									</div>
									
                                  <input class="btn btn-lg btn-primary btn-block" name="submitresetuser" data-toggle="tooltip" title="Please enter your user name. Password Reset instructions will be sent to your registered Email address." value="Send Reset Link" type="submit">
                                </fieldset>
								</form>
                            
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
          	
      </div>
  </div>
  </div>
</div>
<!-- Forget dba password -->
<div id="dbafpwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>          
		  <h4><span class="glyphicon glyphicon-eye-open"></span> Forgot Password?</h4>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                          <h5><span class="glyphicon"></span>                      
                          If you have forgotten your password you can reset it here.</h5>
                            <div class="panel-body">
							<form action="" method ="POST">
                                <fieldset>                                    
									<div class="form-group">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                      
                                      <input id="userid" placeholder="Enter username" name ="username"class="form-control" type="text" required="">
                                    </div>
									</div>
									
                                  <input class="btn btn-lg btn-primary btn-block" name="submitresetdba" data-toggle="tooltip" title="Please enter your user name. Password Reset instructions will be sent to your registered Email address." value="Send Reset Code" type="submit">
                                </fieldset>
								</form>
                            
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
          	
      </div>
  </div>
  </div>
</div>
<script>
$(document).ready(function() {
	$('#registerform').bootstrapValidator({
	live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
           user: {
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
			name: {
                validators: {
                    notEmpty: {
                        message: 'The Name is required and cannot be empty'
                    }
                }
            },
			cpass: {
                validators: {
                    notEmpty: {
                        message: 'The Mobile No is required and cannot be empty'
                    },
					digits: {
                        message: 'The phone number can contain digits only'
                    },
					
                }
            },	
			email: {
                validators: {
                    notEmpty: {
                        message: 'The Email is required and cannot be empty'
                    },
                    regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'The value is not a valid email address'
                      }
                }
            },
			
            pass: {
            validators: {
				notEmpty: {
                        message: 'The password  is required'
                    },
					different: {
                    field: 'user',
                    message: 'The username and password cannot be the same as each other'
                },
				stringLength: {
                        max: 15,
						min: 8,
                        message: 'The password must be more then 8 characters less than 15 characters'
                }
            }
        }
       }
    });
	});
</script>


</body>