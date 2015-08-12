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
$message="";
$database = "";
$usera="";
$passa="";
$connect = mysql_connect($database,$usera,$passa);
$dbase= mysql_select_db("oemon", $connect);
if(!$connect = mysql_connect($database,$usera,$passa))
{
$message="MYSQL database not Accessible Please Check The Database Configuration";
if(isset($_SESSION['username'])||isset($_SESSION['login_username'])||isset($_SESSION['dbid'])){
if(session_destroy()) // Destroying All Sessions
{
header("Location: index.php"); // Redirecting To Home Page
}
}
}
else
{
$dbase= mysql_select_db("oemon", $connect);
$_SESSION['sql']='running';
}
?>
