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
require_once ("../sqlconnect.php");
if(isset($_SESSION['sql'])){
$rows = array();
$table = array();
$count=0;
$queryservers = mysqli_query($connect,"SELECT distinct  server FROM configureddb");
$queryconfservers = mysqli_query($connect,"SELECT distinct  server FROM configureddb");
$numservers=mysqli_num_rows($queryconfservers);
$table['cols'] = array(
    array('label' => 'Date', 'type' => 'date'),
);
while($query_row=mysqli_fetch_assoc($queryservers)){
$server=$query_row['server'];
$table['cols'][] = array('label' => $server, 'type' => 'number'); 
$querycpu = mysqli_query($connect,"SELECT UNIX_TIMESTAMP(date)as date, max(usedmem/totalmem*100)as used FROM memrep where dbid in(SELECT dbuid from configureddb where server ='$server') group by date(date) order by date desc limit 30;");
while ($row=mysqli_fetch_array($querycpu)) {
$temp = array();
$temp[] = array('v' =>  $row[0]); 
for($i=0;$i<$count;$i++)
{
$temp[] = array('v' => "null"); 
}
$temp[] = array('v' => (float) $row[1]); 
for($i=0;$i<$numservers-$count-1;$i++)
{
$temp[] = array('v' => "null"); 
}
$rows[] = array('c' => $temp);
}
$count++;
}
$table['rows'] = $rows;

echo $jsonTable = json_encode($table);

}
?>