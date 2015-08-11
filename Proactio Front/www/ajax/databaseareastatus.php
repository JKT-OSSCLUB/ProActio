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

header('Content-type: application/json');
@$option=$_GET['dbuid'];
require_once ("../sqlconnect.php");
if(isset($_SESSION['sql'])){
@$query = mysqli_query($connect,"SELECT * FROM configureddb where dbuid='$option'");
while($query_row=mysqli_fetch_assoc($query)){
$username=$query_row['dbuser'];
$password =$query_row['dbpass'];
$hostname =$query_row['server'];
$portnumber =$query_row['port'];
$databaseName =$query_row['dbname'];
}
$conn_string = "Driver={Progress OpenEdge 11.3 driver}; 
    HostName=" . @$hostname . "; 
    PortNumber=". @$portnumber ."; 
    DatabaseName=" . @$databaseName . "; 
    DefaultIsolationLevel=READ COMMITTED;";
	
if(@$conn = odbc_connect($conn_string, $username, $password, SQL_CUR_USE_ODBC)){
$queryblksize ="select \"_DbStatus-DbBlkSize\" from PUB.\"_DbStatus\" ";
$result=odbc_exec($conn, $queryblksize);
while(odbc_fetch_row($result))
{
$_blocksize = odbc_result($result, 1);
}
$query1 ="select \"_DbStatus-DbBlkSize\" from PUB.\"_DbStatus\" ";
$res=odbc_exec($conn, $query1);
while(odbc_fetch_row($res))
{
$_blocksize = odbc_result($res, 1);
}
$query ="select \"_AreaStatus-Areaname\" , \"_AreaStatus-Areanum\" , \"_AreaStatus-Extents\" , \"_AreaStatus-Freenum\" , \"_AreaStatus-Hiwater\"  , \"_AreaStatus-Totblocks\"  from PUB.\"_AreaStatus\" where (\"_AreaStatus-Areaname\" != 'Control Area') AND (\"_AreaStatus-Areaname\" NOT LIKE 'Primary Recovery Area%') AND (\"_AreaStatus-Areaname\" != 'Schema Area') AND (\"_AreaStatus-Areaname\"  NOT LIKE  'After Image Area%') ";
$result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
	$row['_AreaStatus-Hiwater']=round($row['_AreaStatus-Hiwater']/$row['_AreaStatus-Totblocks']*100,2).'%';
	$row['_AreaStatus-Totblocks']=round(($row['_AreaStatus-Totblocks']*$_blocksize)/1024/1024,2).'MB';
	$row['_AreaStatus-Freenum']=round($row['_AreaStatus-Hiwater']*$row['_AreaStatus-Totblocks']/100,2).'MB';
	        $json[]=$row;
    }
odbc_close($conn);
mysqli_close($connect);
echo json_encode($json);
}
else
echo "[]";
}
else
echo "[]";
?>