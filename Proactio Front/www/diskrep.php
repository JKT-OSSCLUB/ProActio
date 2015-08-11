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
$pdf->SetFont('Times','',32);
$pdf->Ln(70);
$pdf->Cell(0,1,'Disk Space Utilization Report',0,1,'C');
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
$diskquerytot=mysql_query("SELECT distinct date(date)as date,time(date) as time,totalsize,usedsize,freesize from diskrep where date(date) = '$dt'");
    if(mysql_num_rows($diskquerytot))
	{
    $pdf->SetFont('Arial','',20);
    $pdf->Ln(10);
	$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
	$pdf->Cell(0,10,'Disk Utilization',1,1,'C',1);
	$pdf->TOC_Entry('Disk Utilization', 0);
		$pdf->SetTextColor(0,0,0);
	$pdf->ln(1);
	if($querydisk = mysql_query("SELECT distinct server FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user' group by server")){
while($query_rowdisk=mysql_fetch_assoc($querydisk)){
$hostname =$query_rowdisk['server'];
$disknumquery=mysql_query("SELECT distinct date(diskrep.date)as date,time(diskrep.date) as time,diskrep.totalsize,diskrep.usedsize,diskrep.freesize from diskrep , configureddb  WHERE diskrep.dbid=configureddb.dbuid and server='$hostname' and date(date) = '$dt' ORDER BY date desc");
if(mysql_num_rows($disknumquery)){
$pdf->TOC_Entry($hostname, 1);
$pdf->SetFont('Arial','',14);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
$pdf->Cell(0,7,'Server: '.$hostname,1,1,'C',1); 
$pdf->SetTextColor(0,0,0);
				$pdf->AddCol('time',25,'Time ','C');
				$pdf->AddCol('date',25,'Date ','C');
				$pdf->AddCol('totalsize',60,'Total Size (in KB)','C');
				$pdf->AddCol('usedsize',57,'Used Size (in KB)','C');
				$pdf->AddCol('freesize',60,'Free Size (in KB)','C');
				$pdf->AddCol('mounted',50,'Mount Name','C');
				$prop=array('HeaderColor'=>array(66,139,202),
            'color1'=>array(255,255,255),
            'color2'=>array(255,255,255));
		$pdf->Table("SELECT distinct date(diskrep.date)as date,time(diskrep.date) as time,mounted,diskrep.totalsize,diskrep.usedsize,diskrep.freesize from diskrep ,configureddb  WHERE diskrep.dbid=configureddb.dbuid and server='$hostname' and date(date) = '$dt' ORDER BY date desc",$prop);
		$pdf->Ln(5);
		}
		else
		{
		$pdf->SetFont('Times','',26);
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