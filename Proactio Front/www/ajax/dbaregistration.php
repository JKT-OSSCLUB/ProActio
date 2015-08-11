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
if(isset($_POST['Register'])&&!empty($_POST['name'])&&!empty($_POST['username'])&&!empty($_POST['email'])&&!empty($_POST['password'])&&!empty($_POST['password_confirmation'])) {
	$name=mysqli_real_escape_string($connect,stripslashes($_POST['name']));
	$username=mysqli_real_escape_string($connect,stripslashes($_POST['username']));
	$email=mysqli_real_escape_string($connect,stripslashes($_POST['email']));
	$password_confirmation=md5(mysqli_real_escape_string($connect,stripslashes($_POST['password_confirmation'])));
	$pass=md5(mysqli_real_escape_string($connect,stripslashes($_POST['password'])));
	$query=mysqli_query($connect,"SELECT * from dbalogin where username='$username' or  email ='$email'");
	if(mysqli_num_rows($query)==0)
	{
	$queryinsert=mysqli_query($connect,"Insert Into dbalogin(Name,username,password,email) Values('$name','$username','$pass','$email')");
	if(!$queryinsert)
{
echo "Error".mysqli_error($connect);
}
else
{
echo "Success";
}
	} 	
	}
	
	
	?>