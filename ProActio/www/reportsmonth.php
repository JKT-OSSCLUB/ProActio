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
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(70);
$pdf->SetFont('Arial','',32);
$pdf->Cell(0,10,'Monthly Report',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',20);
$pdf->Cell(0,1,'FOR  '.date("F o"),0,1,'C');
include('sqlconnectver2.php');
if($query = mysql_query("SELECT dbuid,dbname,environ FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user'")){
$pdf->AddPage();
	$pdf->Ln(3);
		$pdf->SetFont('Arial','',20);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
	  $pdf->Cell(0,10,'List of Databases',1,1,'C',1);
	  $pdf->TOC_Entry('List of Database', 0);
	  	  $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Times','',14);	
	while($query_row=mysql_fetch_assoc($query)){
	$dbuid=$query_row['dbuid'];
	$environ =$query_row['environ'];
	$databaseName =$query_row['dbname'];
	$pdf->Cell(0,10,'Database: '.$databaseName.'   ['.$environ.']',0,1,'L'); 
	}
$pdf->SetFont('Arial','',20);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
$pdf->Cell(0,10,'Alerts Generated',1,1,'C',1);
$pdf->TOC_Entry('Alerts Generated', 0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','',14);	
$pdf->Ln(5);
if($query = mysql_query("SELECT dbuid,dbname FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user'")){
while($query_row=mysql_fetch_assoc($query)){
$dbuid=$query_row['dbuid'];
$databaseName =$query_row['dbname'];
$queryalerts=mysql_query("select date(alerts.date) as date,time(alerts.date) as time, alertdesc.alertdisc , alertdesc.alerttype from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$dbuid' and alerts.date>date(date_sub(now(), interval 1 month))");
if(mysql_num_rows($queryalerts)){
$pdf->TOC_Entry($databaseName, 1);
$pdf->SetFont('Arial','B',14);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
$pdf->Cell(0,7,'Database: '.$databaseName,1,1,'C',1); 
$pdf->SetTextColor(0,0,0);
				$pdf->AddCol('date',35,'Date','C');
				$pdf->AddCol('time',35,'Time','C');
				$pdf->AddCol('alerttype',37,'Type','C');
				$pdf->AddCol('alertdisc',170,'Discription');
				$prop=array('HeaderColor'=>array(66,139,202),
            'color1'=>array(255,255,255),
            'color2'=>array(255,255,255));
$pdf->Table("select date(alerts.date) as date,time(alerts.date) as time, alertdesc.alertdisc , alertdesc.alerttype from alerts inner join alertdesc where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$dbuid'",$prop);
$pdf->Ln(5);
}
}
}
$pdf->ln(1);
$pdf->SetFont('Arial','',20);
$pdf->AddPage();
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
$pdf->Cell(0,10,'CPU Utilization',1,1,'C',1);
$pdf->TOC_Entry('CPU Utilization',0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','',14);
$pdf->SetFont('Arial','B',11);
if($query = mysql_query("SELECT  distinct server FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user' group by server")){
$pdf->Cell(0,10,'CPU Usage',0,1,'L');
$pdf->TOC_Entry('CPU Usage',2);
while($query_row=mysql_fetch_assoc($query)){
$hostname =$query_row['server'];
$cpuquery=mysql_query("select distinct  date(cpurep.date)as date, max(100-(cpurep.idle))as used from cpurep,configureddb WHERE cpurep.dbid=configureddb.dbuid and server='$hostname' and date(date)>date(date_sub(now(), interval 1 month)) group by date(cpurep.date)order by date(cpurep.date) desc limit 31");
if(mysql_num_rows($cpuquery)){
$pdf->TOC_Entry($hostname, 3);
$querycpu = mysql_query("select distinct   DATE_FORMAT(date(cpurep.date),'%e-%m') as date, max(100-(cpurep.idle))as used from cpurep,configureddb WHERE cpurep.dbid=configureddb.dbuid and server='$hostname' and date(date)>date(date_sub(now(), interval 1 month)) group by date(cpurep.date)order by date(cpurep.date) desc limit 31");
$chd="";
$ch1="";
while($querycpu_row=mysql_fetch_assoc($querycpu)){
$date=$querycpu_row['date'];
$used=$querycpu_row['used'];
if($chd!="")
$chd=$chd.",".$used;
else
$chd=$chd.$used;
if($ch1!="")
$ch1=$ch1."|".$date;
else
$ch1=$ch1.$date;
}
$pdf->Cell( 40, 40, $pdf->Image("http://chart.googleapis.com/chart?cht=lc&chd=t:$chd&chs=1000x300&chl=$ch1&chco=FF0000&chxt=x,y",$pdf->GetX(),$pdf->GetY(),280,100,'PNG'), 0, 0, 'L', false );
$pdf->Ln(100);
$pdf->SetFont('Times','',11);	
$pdf->Cell(0,10,'Server: '.$hostname,0,1,'C'); 
$pdf->AddPage();
}
}
}
if($query = mysql_query("SELECT  distinct server FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user' group by server")){
$pdf->Cell(0,10,'CPU wait time',0,1,'L');
$pdf->TOC_Entry('CPU wait time',2);
while($query_row=mysql_fetch_assoc($query)){
$hostname=$query_row['server'];
$cpuquery=mysql_query("select distinct  date(cpurep.date)as date, max(cpurep.iowait) as used from cpurep,configureddb WHERE cpurep.dbid=configureddb.dbuid and server='$hostname' and date(date)>date(date_sub(now(), interval 1 month)) group by date(cpurep.date)order by date(cpurep.date) desc limit 31");
if(mysql_num_rows($cpuquery)){
$pdf->TOC_Entry($hostname, 3);
$pdf->SetFont('Arial','i',18);
$pdf->SetFont('Arial','',11);
$queryiowait = mysql_query("select distinct  DATE_FORMAT(date(cpurep.date),'%e-%m')as date, max(cpurep.iowait)as used from cpurep,configureddb WHERE cpurep.dbid=configureddb.dbuid and server='$hostname' and date(date)>date(date_sub(now(), interval 1 month)) group by date(cpurep.date)order by date(cpurep.date) desc limit 31");
$chd="";
$ch1="";
while($querycpu_row=mysql_fetch_assoc($queryiowait)){
$date=$querycpu_row['date'];
$used=$querycpu_row['used'];
if($chd!="")
$chd=$chd.",".$used;
else
$chd=$chd.$used;
if($ch1!="")
$ch1=$ch1."|".$date;
else
$ch1=$ch1.$date;
}
$pdf->Cell( 40, 40, $pdf->Image("http://chart.googleapis.com/chart?cht=lc&chd=t:$chd&chs=1000x300&chl=$ch1&chco=FF0000&chxt=x,y",$pdf->GetX(),$pdf->GetY(),280,100,'PNG'), 0, 0, 'L', false );
$pdf->Ln(100);
$pdf->SetFont('Times','',11);	
$pdf->Cell(0,10,'Server:- '.$hostname,0,1,'C'); 
$pdf->AddPage();
}
}
}
$pdf->SetFont('Arial','',20);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
$pdf->Cell(0,10,'Disk Performance',1,1,'C',1);
$pdf->TOC_Entry('Disk Performance',0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','',14);	
if($query = mysql_query("SELECT  distinct server FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user' group by server")){
while($query_row=mysql_fetch_assoc($query)){
$diskquery = mysql_query("SELECT date(diskrep.date)as date,max(diskrep.usedsize/diskrep.totalsize*100) as used from diskrep,configureddb WHERE diskrep.dbid=configureddb.dbuid and server='$hostname' and date(date)>date(date_sub(now(), interval 1 month)) group by date(diskrep.date)order by date(diskrep.date) desc limit 31");
if(mysql_num_rows($diskquery)){
$hostname=$query_row['server'];
$pdf->TOC_Entry($hostname, 1);
$querydiskutil = mysql_query("SELECT  DATE_FORMAT(date(diskrep.date),'%e-%m')as date,max(diskrep.usedsize/diskrep.totalsize*100) as used from diskrep,configureddb WHERE diskrep.dbid=configureddb.dbuid and server='$hostname' and date(date)>date(date_sub(now(), interval 1 month)) group by date(diskrep.date)order by date(diskrep.date) desc limit 31");
$chd="";
$ch1="";
while($querycpu_row=mysql_fetch_assoc($querydiskutil)){
$date=$querycpu_row['date'];
round($used=$querycpu_row['used'],2);
if($chd!="")
$chd=$chd.",".$used;
else
$chd=$chd.$used;
if($ch1!="")
$ch1=$ch1."|".$date;
else
$ch1=$ch1.$date;
}
$pdf->Cell( 40, 40, $pdf->Image("http://chart.googleapis.com/chart?cht=lc&chd=t:$chd&chs=1000x300&chl=$ch1&chco=FF0000&chxt=x,y",$pdf->GetX(),$pdf->GetY(),280,100,'PNG'), 0, 0, 'L', false );
$pdf->Ln(100);
$pdf->SetFont('Times','',11);	
$pdf->Cell(0,10,'Server:- '.$hostname,0,1,'C');
$pdf->AddPage();
}
}
}
$pdf->SetFont('Arial','',20);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
$pdf->Cell(0,10,'Memory Performance',1,1,'C',1);
$pdf->TOC_Entry('Memory Performance',0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',15);
if($query = mysql_query("SELECT  distinct server FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user' group by server")){
while($query_row=mysql_fetch_assoc($query)){
$hostname=$query_row['server'];
$memquery = mysql_query("SELECT date(memrep.date)as date,max(memrep.usedmem/memrep.totalmem*100) as used from memrep ,configureddb WHERE memrep.dbid=configureddb.dbuid and server='$hostname' and date(date)>date(date_sub(now(), interval 1 month)) group by date(memrep.date)order by date(memrep.date) desc limit 31");
if(mysql_num_rows($memquery)){
$pdf->TOC_Entry($hostname, 1);
$querymemutil = mysql_query("SELECT  DATE_FORMAT(date(memrep.date),'%e-%m')as date,max(memrep.usedmem/memrep.totalmem*100) as used from memrep ,configureddb WHERE memrep.dbid=configureddb.dbuid and server='$hostname' and date(date)>date(date_sub(now(), interval 1 month)) group by date(memrep.date)order by date(memrep.date) desc limit 31");
$chd="";
$ch1="";
while($querycpu_row=mysql_fetch_assoc($querymemutil)){
$date=$querycpu_row['date'];
round($used=$querycpu_row['used'],2);
if($chd!="")
$chd=$chd.",".$used;
else
$chd=$chd.$used;
if($ch1!="")
$ch1=$ch1."|".$date;
else
$ch1=$ch1.$date;
}
$pdf->Cell( 40, 40, $pdf->Image("http://chart.googleapis.com/chart?cht=lc&chd=t:$chd&chs=1000x300&chl=$ch1&chco=FF0000&chxt=x,y",$pdf->GetX(),$pdf->GetY(),280,100,'PNG'), 0, 0, 'L', false );
$pdf->Ln(100);
$pdf->SetFont('Times','',11);	
$pdf->Cell(0,10,'Server:- '.$hostname,0,1,'C');
$pdf->AddPage();
}
}
}
$pdf->SetFont('Arial','',20);
$pdf->setFillColor(63,139,202); 
$pdf->SetTextColor(253,253,253);
$pdf->Cell(0,10,'Database growth/size',1,1,'C',1);
$pdf->TOC_Entry('Database growth/size',0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',15);
if($query = mysql_query("SELECT dbuid,dbname FROM configureddb INNER JOIN dbalogin where  dbalogin.username ='$current_user'")){
$chd1="";
$chd2="";
$ch1="";
while($query_row=mysql_fetch_assoc($query)){
$dbuid=$query_row['dbuid'];
$databaseName =$query_row['dbname'];
$querygrowth=mysql_query("select max(size)as size from dbsizerep where dbuid='$dbuid' and date(date)>DATE_SUB(NOW(), INTERVAL 1 MONTH) order by date desc ");
$queryprevgrowth=mysql_query("select date, max(size)as size from dbsizerep where dbuid='$dbuid' AND date(date)> (DATE_SUB(CURDATE(), INTERVAL 2 MONTH)) AND date(date) < (DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) order by date desc ");
while($querygrowth_row=mysql_fetch_assoc($querygrowth)){
$newsize=$querygrowth_row['size'];
}
while($queryprevgrowth_row=mysql_fetch_assoc($queryprevgrowth)){
$oldsize=$queryprevgrowth_row['size'];
}
if($chd2!=""&&$oldsize!=null)
$chd2=$chd2.",".$oldsize;
else
$chd2=$chd2.$oldsize;
if($chd1!=""&&$newsize!=null)
$chd1=$chd1.",".$newsize;
else
$chd1=$chd1.$newsize;
if($ch1!="")
$ch1=$ch1."|".$databaseName;
else
$ch1=$ch1.$databaseName;
}
if($chd2=="")
{
$chd2=0;
}
$pdf->SetFont('Times','',8);
//$pdf->Cell(0,10,"http://chart.googleapis.com/chart?cht=bvg&chd=t:$chd1|$chd2&chs=1000x300&chl=$ch1&chco=FF0000,00FF00&chxt=x,y&chbh=30,15,25",1,1,'C');
$pdf->Cell( 40, 140, $pdf->Image("http://chart.googleapis.com/chart?cht=bvg&chd=t:$chd1|$chd2&chs=1000x300&chl=$ch1&chco=D9534F,428BCA&chxt=x,y&chbh=30,15,25",$pdf->GetX(),$pdf->GetY(),280,100,'PNG'), 0, 0, 'L', false );
$pdf->Cell( 60, 140, $pdf->Image("images/current-month.jpg",$pdf->GetX(),$pdf->GetY(),160,15,'JPG'), 0, 0, 'L', false );
}
  $pdf->stopPageNums();
	$pdf->insertTOC(2);
$pdf->Output();
mysql_close($connect);

}
?> 
