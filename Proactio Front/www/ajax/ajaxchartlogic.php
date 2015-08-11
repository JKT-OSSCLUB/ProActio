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
$query = mysqli_query($connect,"SELECT * FROM configureddb where dbuid='$option'");
while($query_row=mysqli_fetch_assoc($query)){
$username=$query_row['dbuser'];
$password =$query_row['dbpass'];
$hostname =$query_row['server'];
$portnumber =$query_row['port'];
$databaseName =$query_row['dbname'];
}
$conn_string = "Driver={Progress OpenEdge 11.3 driver}; 
    HostName=" .@ $hostname . "; 
    PortNumber=".@ $portnumber ."; 
    DatabaseName=" .@ $databaseName . "; 
    DefaultIsolationLevel=READ COMMITTED;";
	if(@$conn = odbc_connect($conn_string, $username, $password, SQL_CUR_USE_ODBC)){
$query7="select \"_AreaStatus-Areaname\" , \"_AreaStatus-Hiwater\", \"_AreaStatus-Totblocks\" , \"_AreaStatus-Lastextent\" from PUB.\"_AreaStatus\" where \"_AreaStatus-Lastextent\" LIKE '%.d%'";
$result7 = odbc_exec($conn, $query7);
if (!$result7) {
    echo "Problem with query " . $query7 . "<br/>";
    exit();
}
$_areaname="";
$_hiwater=0;
$_totalblks=0;
while (odbc_fetch_row($result7)) {
    $_areaname += odbc_result($result7,1);
	$_hiwater += odbc_result($result7,2);
	$_totalblks += odbc_result($result7,3);
	}
 $_hiwater=$_hiwater;
 $_totalblks=$_totalblks;
 $perc=round($_hiwater/$_totalblks*100,2);
 $result=array(array("USED",$perc),array('FREE',100-$perc));
  $rows = array();
  $table = array();
  $table['cols'] = array(
    array('label' => 'BLKSIZE', 'type' => 'string'),
    array('label' => 'total blks', 'type' => 'number')

);
    foreach($result as $r) {
      $temp = array();
      $temp[] = array('v' => (string) $r[0]); 
      $temp[] = array('v' => (float) $r[1]); 
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

echo $jsonTable = json_encode($table);
}
}else
echo false;
?>