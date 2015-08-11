<?php
/*******************************************************************************
 *******************************************************************************
 **                                                                           **
 **                                                                           **
 **  Copyright 2015-2017 J K Technosoft                  					  **
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
 * Author:Ezaz Ul Shafi War
 *
 *	J K Technosoft
 *	http://www.jktech.com
 *	August 11, 2015
 *
 *
 * History:
 *
 */

include('../sqlconnect.php');
session_start();
$username=@$_SESSION['username'];
if(isset($_POST['email-change'])&&!empty($_POST['oldemail'])&&!empty($_POST['newemail'])&&!empty($_POST['password']))
{
$oldemail=mysqli_real_escape_string($connect,stripslashes($_POST['oldemail']));
$newemail=mysqli_real_escape_string($connect,stripslashes($_POST['newemail']));
$password=md5(mysqli_real_escape_string($connect,stripslashes($_POST['password'])));
$query=mysqli_query($connect,"SELECT * FROM dbalogin where username = '$username' and password= '$password' and email='$oldemail'");
if(mysqli_num_rows($query)==1)
{
$query=mysqli_query($connect,"UPDATE dbalogin SET email = '$newemail' where username='$username'");
if($query)
{
echo "Success";
}
else
{
echo "failed";
}
}
else{
$msg="Wrong Email or Password Entered";
}
}
if(isset($_POST['passchange'])&&!empty($_POST['oldpass'])&&!empty($_POST['newpass'])&&!empty($_POST['confirmpass']))
{
$oldpass=md5(mysqli_real_escape_string($connect,stripslashes($_POST['oldpass'])));
$newpass=md5(mysqli_real_escape_string($connect,stripslashes($_POST['newpass'])));
$query=mysqli_query($connect,"SELECT * FROM dbalogin where username = '$username' and password= '$oldpass'");
if(mysqli_num_rows($query)==1)
{
$query=mysqli_query($connect,"UPDATE dbalogin SET password = '$newpass'where username='$username'");
if($query)
{
echo "Success";
}
else
{
echo "failed";
}
}
else{
$msg1="Wrong Password Entered";
}
} ?>