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
$query = mysqli_query($connect,"SELECT * FROM configureddb where server='$option'");
while($query_row=mysqli_fetch_assoc($query)){
$hostname =$query_row['server'];
$sslusername =$query_row['sslusername'];
$sslpassword =$query_row['sslpassword'];
}
$path=getcwd();
chdir('..');
chdir('..');
$path=getcwd();
chdir('php/pear');
 $path=getcwd();
 set_include_path($path);
set_include_path(get_include_path() .'/'. 'phpsec');
include('Net/SSH2.php');
include('File/ANSI.php');
$ssh = new Net_SSH2(@$hostname);
if (@$ssh->login(@$sslusername,@$sslpassword)) {
$ansi = new File_ANSI();
$ssh->enablePTY();
$ssh->exec('df -P');
$ssh->setTimeout(2);
$hello = $ssh->read();
$ps = explode("\n", trim($hello));
foreach($ps AS $process){
$processes[]=preg_split('@\s+@', trim($process), 6 );
}
unset($processes[0]);
foreach($processes as $pro){
$result[]= @array(
				'FILESYSTEM' => $pro[5],
				'USED%' => $pro[4],
			);
}
  $rows = array();
  $table = array();
  $table['cols'] = array(
    array('label' => 'FILESYSTEM', 'type' => 'string'),
    array('label' => 'Used %', 'type' => 'number')
);
    foreach($result as $r) {
      $temp = array();
      $temp[] = array('v' => (string) $r['FILESYSTEM']); 
      $temp[] = array('v' => (float) $r['USED%']); 
      $rows[] = array('c' => $temp);
    }
$table['rows'] = $rows;
echo $jsonTable = json_encode($table);

}
else
echo false;
}
else echo false;

?>
