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

require_once('login.php'); // Includes Login Script
require_once('register.php');
require_once('sqlconnect.php');
if(isset($_SESSION['login_username'])&&isset($_SESSION['selected_db'])){
header("location: charts.php");
}
elseif(isset($_SESSION['login_username'])){
header("location: selectdb.php");
}
elseif(isset($_SESSION['username'])){
header("location: dbahome.php");
}
$msg = '';
if(isset($_SESSION['sql'])){
	if (isset($_POST['dbasubmit']) && !empty($_POST['dbausername']) && !empty($_POST['dbapassword'])) {
	$uname=$_POST['dbausername'];
	$pass=$_POST['dbapassword'];
	$uname=stripslashes($uname);
	$pass=stripslashes($pass);
	$uname=mysqli_real_escape_string($connect,$uname);
	$pass=md5(mysqli_real_escape_string($connect,$pass));
	$query=mysqli_query($connect,"SELECT * from dbalogin where username='$uname' and password ='$pass'");
	if(mysqli_num_rows($query)==1)
	{
	$_SESSION['username'] = $uname;
	header('Location: dbahome.php');
	} else {
	$msg = 'DBA Login Failed. Invalid User name or password.';	
	}
	}
}	
?>