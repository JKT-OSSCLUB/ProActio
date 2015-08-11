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
$count=0;
$error="";
$path=getcwd();
chdir('..');
$path=getcwd();
chdir('php/pear');
 $path=getcwd();
 set_include_path($path);
 set_include_path(get_include_path() .'/'. 'phpsec');
 include('Net/SSH2.php');
include('File/ANSI.php');
require_once('sqlconnect.php');
require_once('session.php');
if(isset($_SESSION['login_username'])){
$currentuser=$_SESSION['login_username'];
$selquery=mysqli_query($connect,"SELECT configureddb.dbuid,configureddb.dbname FROM configureddb INNER JOIN dbparam where dbparam.dbuid=configureddb.dbuid and dbparam.userid ='$currentuser'");
if (isset($_POST['submit']) && !empty($_POST['dbname'])){
$selected_db=$_POST['dbname'];
$result = mysqli_query($connect,"SELECT dbname FROM configureddb INNER JOIN dbparam where dbparam.dbuid=configureddb.dbuid and dbparam.userid ='$currentuser'and configureddb.dbuid='$selected_db'");
$rows = mysqli_num_rows($result);
if($rows == 1){
$query1=mysqli_query($connect,"SELECT configureddb.dbuid FROM configureddb INNER JOIN dbparam where  dbparam.dbuid=configureddb.dbuid and dbparam.userid ='$currentuser' and configureddb.dbuid ='$selected_db'");
$row1 = mysqli_fetch_row($query1);
// $_SESSION['dbid']=$row1[0];
$dbuid=$row1[0];
$querycheck = mysqli_query($connect,"SELECT * FROM configureddb where dbuid='$dbuid'");
while($query_row=mysqli_fetch_assoc($querycheck)){
$hostname =$query_row['server'];
$sslusername =$query_row['sslusername'];
$sslpassword =$query_row['sslpassword'];
$username=$query_row['dbuser'];
$password =$query_row['dbpass'];
$portnumber =$query_row['port'];
$databaseName =$query_row['dbname'];
$ssh = new Net_SSH2($hostname);
if (@$ssh->login($sslusername,$sslpassword)) {
$count++;
}
$conn_string = "Driver={Progress OpenEdge 11.3 driver}; 
    HostName=" . @$hostname . "; 
    PortNumber=". @$portnumber ."; 
    DatabaseName=" .@$databaseName . "; 
    DefaultIsolationLevel=READ COMMITTED;";
	
if(@$conn = odbc_connect($conn_string, $username, $password, SQL_CUR_USE_ODBC)){
$count++;
}
}
if($count==2)
{
$_SESSION['dbid']=$dbuid;
if(isset($_SESSION['login_username'])&&isset($_SESSION['dbid']))
{
header("location: charts.php");
}
}
else
{
$error="Database Or Server Down. Please Select Another Database Or Contact DBA Support";
}
}
}
}
else{
 header("location: index.php");
}
?>