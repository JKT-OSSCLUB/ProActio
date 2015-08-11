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
if(isset($_POST['submitbutton'])&&!empty($_POST['dbuid'])&&!empty($_POST['dbname'])&&!empty($_POST['dbuser'])&&!empty($_POST['dbpass'])&&!empty($_POST['serv'])&&!empty($_POST['port'])&&!empty($_POST['sslusername'])&&!empty($_POST['sslpassword'])&&!empty($_POST['environ'])){
  $dbuid=$_POST['dbuid'];
  $dbname=$_POST['dbname'];
  $dbuser=$_POST['dbuser'];
  $dbpass=$_POST['dbpass'];
  $serv=$_POST['serv'];
  $port=$_POST['port'];
  $sslusername=$_POST['sslusername'];
  $sslpassword=$_POST['sslpassword'];
  $environ=$_POST['environ'];
  $dbloc=$_POST['dbloc'];
$myquery=  mysqli_query($connect,"INSERT INTO configureddb (dbuid,dbname,server,port,dbuser,dbpass,sslusername,sslpassword,environ,dblocation) VALUES('$dbuid','$dbname','$serv','$port','$dbuser','$dbpass','$sslusername','$sslpassword','$environ','$dbloc')"); 
$ret='';
if(!$myquery)
{
$ret = "Error";
}
else
{
$ret = "Success";
}
echo $ret;
  } ?>