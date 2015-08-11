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
$results=array();
$querysegment ="select \"_Segment-ByteFree\" , \"_Segment-BytesUsed\" from PUB.\"_Segments\"";
$querydbsize ="select \"_DbStatus-FreeBlks\" , \"_DbStatus-RMFreeBlks\" , \"_DbStatus-DbBlkSize\" , \"_DbStatus-TotalBlks\" from PUB.\"_DbStatus\"";
$queryaibisize ="select \"_Logging-AiLogSize\" , \"_Logging-BiLogSize\" from PUB.\"_Logging\"";
$queryaiw ="select \"_AiLog-AIWWrites\" , \"_AiLog-TotWrites\"  , \"_AiLog-BBuffWaits\" from PUB.\"_ActAILog\"";
$queryapw ="select \"_BiLog-BIWWrites\" , \"_BiLog-TotalWrts\" , \"_BiLog-BBuffWaits\" from PUB.\"_ActBILog\"";
$query6 ="select \"_PW-DBWrites\" , \"_PW-TotDBWrites\" from PUB.\"_ActPWs\"";
$bufferhit ="select  \"_Buffer-Id\",\"_Buffer-LogicRds\", \"_Buffer-OSRds\" from PUB.\"_ActBuffer\" ";
$bhit = odbc_exec($conn, $bufferhit);
while (odbc_fetch_row($bhit)) {
							$_bufferid =odbc_result($bhit, 1);
							$_ipaddress =odbc_result($bhit, 2);
							$_osrds =odbc_result($bhit, 3);
							if($_bufferid==1){
							$_bufferhitratio=round(($_ipaddress - $_osrds) * 100) / ($_ipaddress );
							$_bufferhitratio=round($_bufferhitratio,2);
							}
							else if($_bufferid==2)
							{
							$_primaryhit=round(($_ipaddress - $_osrds) * 100) / ($_ipaddress );
							$_primaryhit=round($_primaryhit,2);
							}
							else if($_bufferid==3)
							{
							if($_ipaddress==0)
							{
							$_alternatehit=0;
							}
							else{
							$_alternatehit=round(($_ipaddress - $_osrds) * 100) / ($_ipaddress );
							$_alternatehit=round($_alternatehit,2);
							}
							}
						}
$results['Buffer Hits']=$_bufferhitratio.'%';						
$results['Primary Hits']=$_primaryhit.'%';						
$results['Alternate Hit']=$_alternatehit.'%';	
$result1=odbc_exec($conn, $querysegment);
{
							$_bytefree = odbc_result($result1, 1);
							$_byteused = odbc_result($result1, 2);
							$_totalkbytes =(( $_bytefree+$_byteused)/1024);
}
$results['Shared Memory']=$_totalkbytes.'KB';
$result2= odbc_exec($conn, $querydbsize);
while (odbc_fetch_row($result2)) {
							$_freeblks = odbc_result($result2, 1);
							$_rmblks = odbc_result($result2, 2);
							$_dbblksize = odbc_result($result2, 3);
							$_totalblks = odbc_result($result2, 4);
						}
$results['Free Blocks']=$_freeblks.'Blocks';
$results['Rm Blocks']=$_rmblks.'Blocks';
$results['DB Size']=round($_dbblksize*$_totalblks/1024/1024,2).'MB';						
$result3 = odbc_exec($conn, $queryaibisize);
while (odbc_fetch_row($result3)) {
							$_aisize = odbc_result($result3, 1);
							$_bisize = odbc_result($result3, 2);
						}
$results['Ai Size']=$_aisize.'KB';
$results['Bi Size']=$_bisize.'KB';
$result4 = odbc_exec($conn, $queryaiw);
while (odbc_fetch_row($result4)) {
							$_aiwwrites = odbc_result($result4, 1);
							$_totawrites = odbc_result($result4, 2);
							$_abbuffwaits= odbc_result($result4, 3);
							@$_paiwwrites=($_aiwwrites/$_totawrites)*100;
							@$_aibuffwaits=($_abbuffwaits/$_totawrites)*100;
						}
$results['Writes by AIW']=$_paiwwrites.'%';
$results['AI Buffer Waits']=$_aibuffwaits.'%';
$result5 = odbc_exec($conn, $queryapw);
while (odbc_fetch_row($result5)) {
							$_biwwrites = odbc_result($result5,1);
							$_totbwrites = odbc_result($result5,2);
							$_bbuffwaits = odbc_result($result5, 3);
							$_pbiwwrites=($_biwwrites/$_totbwrites)*100;
							$_bibuffwaits=($_bbuffwaits/$_totbwrites)*100;
						}
$results['Writes by BIW']=$_pbiwwrites.'%';
$results['BI Buffer Waits']=$_bibuffwaits.'%';
$result6 = odbc_exec($conn, $query6);
while (odbc_fetch_row($result6)) {
							$_dbwrites = odbc_result($result6, 1);
							$_totdwrites = odbc_result($result6, 2);
							$_papwwrites=($_dbwrites/$_totdwrites)*100;
							}
$results['Writes by APW']=$_papwwrites.'%';

$json=$results;					
odbc_close($conn);
mysqli_close($connect);
echo json_encode($json);
}
else echo "[]";
}
else echo "[]";
?>