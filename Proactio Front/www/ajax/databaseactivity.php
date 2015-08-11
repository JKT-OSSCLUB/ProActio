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
$query ="select \"_Summary-RecReads\" as \"Record Reads\" ,\"_Summary-RecUpd\" as \"Record Updates\" ,  \"_Summary-RecCreat\" as \"Record Creates\" , \"_Summary-RecDel\" as \"Record Deletes\" , \"_Summary-DbReads\" as \"Database Reads\", \"_Summary-DbWrites\" as \"Database Writes\", \"_Summary-Commits\" as \"Commits\",\"_Summary-RecLock\" as \"Record Locks\" , \"_Summary-RecWait\" as \"Record Waits\" , \"_Summary-BiWrites\" as \"Before Image Writes\", \"_Summary-BiReads\" as \"Before Image Reads\" , \"_Summary-AiWrites\" as \"After Image Writes\",  \"_Summary-Undos\" as \"Undos\" , \"_Summary-Chkpts\" as \"Checkpoints\" , \"_Summary-Flushed\" as \"Flushed\"  from PUB.\"_ActSummary\"";
$result = odbc_exec($conn, $query);
  $row = odbc_fetch_array($result);
odbc_close($conn);
mysqli_close($connect);
//$json[]=$row;
echo json_encode($row);
}
else
echo "[]";
}
else echo "[]";
?>