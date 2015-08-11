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

require('pdffunc.php');
require('session.php');
$pdf= new PDF_TOC('L','mm','A4'); 
$pdf->startPageNums();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Ln(70);
$pdf->SetFont('Times','',32);
$pdf->Cell(0,1,'ALERTS REPORT',0,1,'C');
$pdf->SetFont('Times','',19);
$pdf->SetFont('Times','',12);
include('sqlconnectver2.php');
$current_user=$_SESSION['login_username'];
$currentdb=$_SESSION['dbid'];
if($query = mysql_query("SELECT * FROM configureddb INNER JOIN dbparam where  dbparam.dbuid=configureddb.dbuid and dbparam.userid ='$current_user' and dbparam.dbuid='$currentdb' ")){

while($query_row=mysql_fetch_assoc($query)){
$username=$query_row['dbuser'];
$password =$query_row['dbpass'];
$hostname =$query_row['server'];
$portnumber =$query_row['port'];
$databaseName =$query_row['dbname'];
}
$query=mysql_query("select * from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$currentdb' and date(alerts.date)>DATE_SUB(NOW(), INTERVAL 1 MONTH)");
if(mysql_num_rows($query)){
    $pdf->AddPage();
	$pdf->Ln(3);
$pdf->SetFont('Arial','',20);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
	  $pdf->Cell(0,10,'Monitored database',1,1,'C',1);
	  $pdf->TOC_Entry('Monitored Database', 0);
	  $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Times','',14);	
	$pdf->Cell(0,10,'Database Name:- '.$databaseName,0,1,'L'); 
    $pdf->Ln(10);
	$pdf->SetFont('Times','B',20);
	$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
	$pdf->Cell(0,10,'Alerts Summary',1,1,'C',1);
	$pdf->TOC_Entry('Alerts Summary', 0);
		  $pdf->SetTextColor(0,0,0);
	$pdf->ln(1);
				$pdf->AddCol('date',35,'Date','C');
				$pdf->AddCol('time',35,'Time','C');
				$pdf->AddCol('alerttype',37,'Type','C');
				$pdf->AddCol('alertdisc',170,'Description');
				$prop=array('HeaderColor'=>array(66,139,202),
            'color1'=>array(255,255,255),
            'color2'=>array(255,255,255));
$pdf->Table("select date(alerts.date) as date,time(alerts.date) as time, alertdesc.alertdisc , alertdesc.alerttype from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$currentdb' and date(alerts.date)>DATE_SUB(NOW(), INTERVAL 1 MONTH)",$prop);

	$pdf->stopPageNums();
	$pdf->insertTOC(2);
		}
	else
	{ 
	
	$pdf->SetFont('Times','',26);
	 $pdf->AddPage();
	 $pdf->Ln(60);
	$pdf->Cell(0,10,'No Matching Records Found For Selected Database '.$databaseName,0,1,'C');
	$pdf->SetFont('Times','',20);
	$pdf->Cell(0,10,'Please Select Another Database ',0,1,'C');
	
	}
$pdf->Output();
}
?>