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

require_once ("../sqlconnect.php");
header('Content-type: application/json');
if(isset($_GET['username'],$_GET['type'],$_GET['dbuid'])){
$user=$_GET['username'];
$type=$_GET['type'];
$dbuid=$_GET['dbuid'];
$query = mysqli_query($connect,"SELECT * FROM login_db  where  user_id='$user'");
if(mysqli_num_rows($query)==1){
$query1 = mysqli_query($connect,"select date(alerts.date) as date,time (alerts.date) as time ,alertdesc.alertdisc , alerts.alert_read  from alerts inner join alertdesc  where alerts.desc_id = alertdesc.desc_id  and alertdesc.alerttype = '$type' and alerts.dbid='$dbuid'");
while($array=mysqli_fetch_assoc($query1)){
if($array['alert_read']==0){
$array['alert_read']="Not Fixed";
}
else{
$array['alert_read']="Fixed";
}
        $json[]=$array;
}
if(@json_encode($json)=="null")
{
echo"[]";
}
else 
{
echo @json_encode($json);
}
mysqli_close($connect);
}
else{
echo"[]";
}
}
elseif(isset($_GET['username'],$_GET['read'],$_GET['dbuid']))
{
$user=$_GET['username'];
$read=$_GET['read'];
$dbuid=$_GET['dbuid'];
$query = mysqli_query($connect,"SELECT * FROM login_db  where  user_id='$user'");
if(mysqli_num_rows($query)==1){
$query1 = mysqli_query($connect,"select date(alerts.date) as date,time (alerts.date) as time ,alertdesc.alertdisc ,alerts.enddate, alertdesc.alerttype from alerts inner join alertdesc  where alerts.desc_id = alertdesc.desc_id and  alerts.alert_read = '$read' and  alerts.dbid='$dbuid'");
while($array=mysqli_fetch_assoc($query1)){
        $json[]=$array;
    }
if(@json_encode($json)=="null")
{
echo"[]";
}
else 
{
echo @json_encode($json);
}
mysqli_close($connect);
}
else{
echo"[]";
}
}
elseif(isset($_GET['username'],$_GET['dbuid'])){
$user=$_GET['username'];
$dbuid=$_GET['dbuid'];
$query = mysqli_query($connect,"SELECT * FROM login_db  where  user_id='$user'");
if(mysqli_num_rows($query)==1){
$query1 = mysqli_query($connect,"select date(alerts.date) as date,time (alerts.date) as time ,alertdesc.alertdisc , alerts.alert_read , alertdesc.alerttype from alerts inner join alertdesc  where alerts.desc_id = alertdesc.desc_id and alerts.dbid='$dbuid'");
while($array=mysqli_fetch_assoc($query1)){
if($array['alert_read']==0){
$array['alert_read']="Not Fixed";
}
else{
$array['alert_read']="Fixed";
}
        $json[]=$array;
    }
if(@json_encode($json)=="null")
{
echo"[]";
}
else 
{
echo @json_encode($json);
}
mysqli_close($connect);
}
else{
echo"[]";
}
}
elseif(isset($_GET['username'],$_GET['type'])){
$user=$_GET['username'];
$type=$_GET['type'];
$query = mysqli_query($connect,"SELECT * FROM login_db  where  user_id='$user'");
if(mysqli_num_rows($query)==1){
$query1 = mysqli_query($connect,"select date(alerts.date) as date,time (alerts.date) as time ,configureddb.dbname,alertdesc.alertdisc , alerts.alert_read  from alerts inner join alertdesc inner join configureddb where alerts.desc_id = alertdesc.desc_id and configureddb.dbuid=alerts.dbid  and alertdesc.alerttype = '$type'");
while($array=mysqli_fetch_assoc($query1)){
if($array['alert_read']==0){
$array['alert_read']="Not Fixed";
}
else{
$array['alert_read']="Fixed";
}
        $json[]=$array;
    }
if(@json_encode($json)=="null")
{
echo"[]";
}
else 
{
echo @json_encode($json);
}
mysqli_close($connect);
}
else{
echo"[]";
}
}
elseif(isset($_GET['username'],$_GET['read']))
{
$user=$_GET['username'];
$read=$_GET['read'];
$query = mysqli_query($connect,"SELECT * FROM login_db  where  user_id='$user'");
if(mysqli_num_rows($query)==1){
$query1 = mysqli_query($connect,"select date(alerts.date) as date,time (alerts.date) as time ,configureddb.dbname,alertdesc.alertdisc ,alerts.enddate, alertdesc.alerttype from alerts inner join alertdesc inner join configureddb where alerts.desc_id = alertdesc.desc_id and configureddb.dbuid=alerts.dbid  and alerts.alert_read = '$read'");
while($array=mysqli_fetch_assoc($query1)){
        $json[]=$array;
    }
if(@json_encode($json)=="null")
{
echo"[]";
}
else 
{
echo @json_encode($json);
}
mysqli_close($connect);
}
else{
echo"[]";
}
}
elseif(isset($_GET['username'])){
$user=$_GET['username'];
$query = mysqli_query($connect,"SELECT * FROM login_db  where  user_id='$user'");
if(mysqli_num_rows($query)==1){
$query1 = mysqli_query($connect,"select date(alerts.date) as date,time (alerts.date) as time ,configureddb.dbname,alertdesc.alertdisc , alerts.alert_read , alertdesc.alerttype from alerts inner join alertdesc inner join configureddb where alerts.desc_id = alertdesc.desc_id and configureddb.dbuid=alerts.dbid ");
while($array=mysqli_fetch_assoc($query1)){
if($array['alert_read']==0){
$array['alert_read']="Not Fixed";
}
else{
$array['alert_read']="Fixed";
}
        $json[]=$array;
    }
if(@json_encode($json)=="null")
{
echo"[]";
}
else 
{
echo @json_encode($json);
}
mysqli_close($connect);
}
else{
echo"[]";
}
}
else
{
echo"[]";
}
?>