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

include('sqlconnect.php');
$error='';
$msg='';
if (isset($_POST['changepi'])) {
if (empty($_POST['currentpassw']) || empty($_POST['newname']) || empty($_POST['newemail']))
{
$error = "Enter all Fields";
}
else
{
$username=$_SESSION['login_username'];
$currentdb=$_SESSION['dbid'];
$currentpassword=$_POST['currentpassw'];
$newname=$_POST['newname'];
$newemail=$_POST['newemail'];
$currentpassword = stripslashes($currentpassword);
$newname = stripslashes($newname);
$newemail = stripslashes($newemail);
$newname = mysqli_real_escape_string($connect,$newname);
$currentpassword = md5(mysqli_real_escape_string($connect,$currentpassword));
$newemail = mysqli_real_escape_string($connect,$newemail);
$query = mysqli_query($connect,"select * from login_db where user_id='$username' AND password = '$currentpassword'");
$rows = mysqli_num_rows($query);
if ($rows == 1) {
$query1 = mysqli_query($connect,"UPDATE login_db SET name = '$newname', email_id = '$newemail' WHERE user_id = '$username'"); 
$query_upd = mysqli_query($connect,$query1);
$msg='Updated successfully.';
}
else
{
$error="Wrong Password.";
}
mysqli_close($connect); // Closing Connection
}
}
elseif(isset($_POST['changepass']))
{
if (empty($_POST['currentpass']) || empty($_POST['newpass']) || empty($_POST['confirmpass']))
{
$error = "Enter all Fields";
}
else
{
$username=$_SESSION['login_username'];
$currentdb=$_SESSION['dbid'];
$currentpass=$_POST['currentpass'];
$newpass=$_POST['newpass'];
$confirmpass=$_POST['confirmpass'];
$currentpass = stripslashes($currentpass);
$newpass = stripslashes($newpass);
$confirmpass = stripslashes($confirmpass);
$newpass = md5(mysqli_real_escape_string($connect,$newpass));
$currentpass = md5(mysqli_real_escape_string($connect,$currentpass));
$confirmpass = md5(mysqli_real_escape_string($connect,$confirmpass));
$query = mysqli_query($connect,"select * from login_db where user_id='$username' AND password = '$currentpass'");
$rows = mysqli_num_rows($query);
if ($rows == 1) {
$query1 = mysqli_query($connect,"UPDATE login_db SET password = '$newpass' WHERE user_id = '$username'"); 
$query_upd = mysqli_query($connect,$query1);
$msg='Password Changed.';
}
else
{
$error="Wrong Password.";
}
mysqli_close($connect); // Closing Connection
}
}

elseif(isset($_POST['changedbi']))
{
if (empty($_POST['currentpas']) || empty($_POST['newduser']) || empty($_POST['newdpass']) || empty($_POST['newdbname']) || empty($_POST['newserv']))
{
$error = "Enter all Fields";
}
else
{
$username=$_SESSION['login_username'];
$currentpas=$_POST['currentpas'];
$newduser=$_POST['newduser'];
$newdpass=$_POST['newdpass'];
$newdbname=$_POST['newdbname'];
$newserv=$_POST['newserv'];
$newport=$_POST['newport'];
$currentpas = stripslashes($currentpas);
$newduser = stripslashes($newduser);
$newdpass = stripslashes($newdpass);
$newdbname = stripslashes($newdbname);
$newserv = stripslashes($newserv);
$newport = stripslashes($newport);
$currentpas = md5(mysqli_real_escape_string($connect,$currentpas));
$newduser = mysqli_real_escape_string($connect,$newduser);
$newdpass = mysqli_real_escape_string($connect,$newdpass);
$newdbname = mysqli_real_escape_string($connect,$newdbname);
$newserv = mysqli_real_escape_string($connect,$newserv);
$newport = mysqli_real_escape_string($connect,$newport);
$query = mysqli_query($connect,"select * from login_db where user_id='$username' AND password = '$currentpas'");
$rows = mysqli_num_rows($query);
if ($rows == 1) {
$query2 = mysqli_query($connect,"UPDATE login_db SET s_user_id = '$newduser' , s_password = '$newdpass' , dbname = '$newdbname' , server = '$newserv' , port = '$newport' WHERE user_id = '$username'"); 
$query_upd1 = mysqli_query($connect, $query2 );
}
else
{
$error="Wrong Password.";
}
mysqli_close($connect); // Closing Connection
}
}
?>