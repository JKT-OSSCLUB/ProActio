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
$pdf= new PDF_TOC('L','mm','A4'); 
$pdf->startPageNums();
// Instanciation of inherited class
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',32);
$pdf->Ln(70);
$pdf->Cell(0,1,'ALERTS REPORT',0,1,'C');
$pdf->SetFont('Times','',19);
include('sqlconnectver2.php');
$query = mysql_query("SELECT dbuid,dbname FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user'");
$pdf->AddPage();
	$pdf->Ln(3);
	$pdf->SetFont('Arial','',20);
	  $pdf->Cell(0,10,'Monitored Database Name',1,1,'C');
	  $pdf->TOC_Entry('Monitored Database Name', 0);
    $pdf->SetFont('Times','',14);	
	while($query_row=mysql_fetch_assoc($query)){
$dbuid=$query_row['dbuid'];
$databaseName =$query_row['dbname'];
	$pdf->Cell(0,10,'Database Name:- '.$databaseName,0,1,'L'); 
	}
if($query = mysql_query("SELECT dbuid,dbuser,dbpass,server,port,dbname FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user'")){

while($query_row=mysql_fetch_assoc($query)){
$username=$query_row['dbuser'];
$password =$query_row['dbpass'];
$hostname =$query_row['server'];
$portnumber =$query_row['port'];
$databaseName =$query_row['dbname'];
$dbuid=$query_row['dbuid'];
$num=mysql_query("select date(alerts.date) as date,time(alerts.date) as time, alertdesc.alertdisc , alertdesc.alerttype from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$dbuid'");
if(mysql_num_rows($num)){
    $pdf->SetFont('Arial','B',15);
    $pdf->Ln(10);
	$pdf->Cell(0,10,'Alerts Generated',1,1,'C');
	$pdf->TOC_Entry('Alerts Generated', 0);
	$pdf->ln(1);
	$pdf->SetFont('Arial','',15);
		$pdf->Cell(0,10,'Database Name:- '.$databaseName,0,1,'L'); 
				$pdf->AddCol('date',35,'DATE','C');
				$pdf->AddCol('time',35,'TIME','C');
				$pdf->AddCol('alerttype',37,'TYPE','C');
				$pdf->AddCol('alertdisc',170,'DISCRIPTION');
				$prop=array('HeaderColor'=>array(66,139,202),
            'color1'=>array(255,255,255),
            'color2'=>array(255,255,255));
$pdf->Table("select date(alerts.date) as date,time(alerts.date) as time, alertdesc.alertdisc , alertdesc.alerttype from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$dbuid'",$prop);
}}
	$pdf->stopPageNums();
	$pdf->insertTOC(2);
	$pdf->Output();
}
?>