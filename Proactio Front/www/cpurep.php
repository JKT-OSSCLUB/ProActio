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

session_start();
require('pdffunc.php');
@$current_user=$_SESSION['username'];
$dt=$_POST['date'];
$pdf= new PDF_TOC('L','mm','A4'); 
$pdf->startPageNums();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(70);
$pdf->SetFont('Times','',32);
$pdf->Cell(0,1,'CPU Utilization Report',0,1,'C');
include('sqlconnectver2.php');
if($query = mysql_query("SELECT distinct server,environ FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user' group by server")){
$pdf->AddPage();
$pdf->Ln(3);
$pdf->SetFont('Arial','',20);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
$pdf->Cell(0,10,'List of Servers',1,1,'C',1);
$pdf->TOC_Entry('List of Servers', 0);
$pdf->SetFont('Times','',14);	
$pdf->SetTextColor(0,0,0);
while($query_row=mysql_fetch_assoc($query)){
$hostname =$query_row['server'];
$environ =$query_row['environ'];
	$pdf->Cell(0,10,'Server: '.$hostname.'   ['.$environ.']',0,1,'L'); 
}
$cpuquerytot=mysql_query("SELECT date(date)as date,time(date) as time,user,nice,system,iowait,steal,idle from cpurep where date(date) = '$dt'");
    if(mysql_num_rows($cpuquerytot))
	{
	$pdf->SetFont('Arial','',20);
    $pdf->Ln(10);
	$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
	$pdf->Cell(0,10,'CPU Utilization',1,1,'C',1);
	$pdf->TOC_Entry('CPU  Utilization', 0);
	$pdf->SetTextColor(0,0,0);
	$pdf->ln(1);
	if($querycpu = mysql_query("SELECT distinct server FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user' group by server")){
while($query_rowcpu=mysql_fetch_assoc($querycpu)){
$hostname =$query_rowcpu['server'];
$cpunumquery=mysql_query("SELECT distinct dbuid,date(cpurep.date)as date,time(cpurep.date) as time,cpurep.user,cpurep.system,cpurep.iowait,cpurep.idle from cpurep,configureddb   WHERE cpurep.dbid=configureddb.dbuid and server='$hostname' and date(date) = '$dt' ORDER BY date desc");
if(mysql_num_rows($cpunumquery)){
$pdf->TOC_Entry($hostname, 1);
$pdf->SetFont('Arial','B',14);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
$pdf->Cell(0,7,'Server: '.$hostname,1,1,'C',1); 
$pdf->SetTextColor(0,0,0);
				$pdf->AddCol('time',55,'Time ','C');
				$pdf->AddCol('date',55,'Date ','C');
				$pdf->AddCol('user',55,'% User','C');
				$pdf->AddCol('system',57,'% System ','C');
				$pdf->AddCol('idle',55,'% Idle ','C');
				$prop=array('HeaderColor'=>array(66,139,202),
            'color1'=>array(255,255,255),
            'color2'=>array(255,255,255));
		$pdf->Table("SELECT distinct dbuid,date(cpurep.date)as date,time(cpurep.date) as time,cpurep.user,cpurep.system,cpurep.idle from cpurep,configureddb   WHERE cpurep.dbid=configureddb.dbuid and server='$hostname' and date(date) = '$dt' ORDER BY date(date) desc",$prop);
$pdf->Ln(5);	
	}
		else
		{
		$pdf->SetFont('Times','',20);
	 $pdf->Ln(20);
	$pdf->Cell(0,10,'No Matching Records Found For Server '.$hostname,0,1,'C');
		 $pdf->Ln(20);
		}
		}
		}
		}
		else
		{
		$pdf->SetFont('Times','',26);
		$pdf->Ln(30);
		$pdf->Cell(0,10,'No Matching Records Found For Any Database ',0,1,'C');
		$pdf->SetFont('Times','',20);
		}
		$pdf->stopPageNums();
	$pdf->insertTOC(2);
	$pdf->AutoPrint(true);
$pdf->Output();
}
?>