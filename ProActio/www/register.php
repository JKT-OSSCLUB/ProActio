<?php
//                                                     register.php
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
include('sqlconnect.php');
$error='';
if (isset($_POST['register'])) {
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['user']) || empty($_POST['pass']) || empty($_POST['cpass']))
{
$error = "Enter all Fields";
}
else
{
// Define $username and $password
$name=$_POST['name'];
$email=$_POST['email'];
$user=$_POST['user'];
$pass=$_POST['pass'];
$mobile=$_POST['cpass'];

$name = stripslashes($name);
$pass = stripslashes($pass);
$email = stripslashes($email);
$user = stripslashes($user);
$mobile = stripslashes($mobile);
$name = mysqli_real_escape_string($connect,$name);
$pass = md5(mysqli_real_escape_string($connect,$pass));
$email = mysqli_real_escape_string($connect,$email);
$user = mysqli_real_escape_string($connect,$user);
$mobile = mysqli_real_escape_string($connect,$mobile);

// Selecting Database
// SQL query to fetch information of registerd users and finds user match.
$query = mysqli_query($connect,"select * from login_db where user_id='$user' OR email_id = '$email' ");
$rows = mysqli_num_rows($query);
if ($rows == 1) {
$error ="Registration Failed. User Details already Exists.";
}
else{
$query1="INSERT INTO `oemon`.`login_db` (`user_id`,`name`, `email_id`, `password`, `mobile`) VALUES ( '$user', '$name' , '$email' , '$pass' , '$mobile');";
$query_ins = mysqli_query($connect,$query1);
If (!$query_ins){
$error = "Could Not Insert value";
}else
$error="PLEASE LOGIN";
}
mysqli_close($connect); // Closing Connection
}
}
elseif(isset($_POST['cancel'])){
header("location: index.php");
}
?>




















