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

require_once('sqlconnect.php');
require_once 'lib/swift_required.php';
  $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('noidajktech')
  ->setPassword('jktech12345');
 $mailer = Swift_Mailer::newInstance($transport);
 
 
 if(isset($_POST['submitresetuser'])&&!empty($_POST['username']))
{
 $resetusername=mysqli_real_escape_string($connect,stripslashes($_POST['username']));
$query=mysqli_query($connect,"select * from login_db where user_id ='$resetusername'");
if(mysqli_num_rows($query)==1){
 $hash = md5($resetusername.time());
 $newhash=md5($hash);
	$query=mysqli_query($connect,"insert into forgottenpassword (datetime,username,passwordhash,reqby) values (CURRENT_TIMESTAMP,'$resetusername','$newhash',2)");
	$toquery=mysqli_query($connect,"Select email_id from login_db where user_id = '$resetusername'");
 	while($to=mysqli_fetch_assoc($toquery)){
	$toaddr=$to['email_id'];
	}
$link=curPageURL()."/forgetpassword.php?pass=".$hash."&reqby=2";
	$message = Swift_Message::newInstance('Reset Username')
  ->setFrom(array('noreply@proactio.com' => 'PROACTIO'))
  ->setTo(array($toaddr))
  ->setBody("Please Click On The Link given $link");
	$result = $mailer->send($message);
   }
}
elseif(isset($_POST['submitresetdba']) &&! empty($_POST['username']))
  {
   $email = $_POST['username'];
   $email=mysqli_real_escape_string($connect,stripslashes($email));
   $querydbalo=mysqli_query($connect,"select * from dbalogin where username = '$email'");
   if(mysqli_num_rows($querydbalo)==1)
   {
   $hash = md5($email.time());
   $newhash=md5($hash);
	$query=mysqli_query($connect,"insert into forgottenpassword (datetime,username,passwordhash,reqby) values (CURRENT_TIMESTAMP,'$email','$newhash',1)");
	$toquery=mysqli_query($connect,"Select email from dbalogin where username = '$email'");
 	while($to=mysqli_fetch_assoc($toquery)){
	$toaddr=$to['email'];
	}
	$link=curPageURL()."/forgetpassword.php?pass=".$hash."&reqby=1";
	$message = Swift_Message::newInstance('Reset Username')
  ->setFrom(array('noreply@proactio.com' => 'PROACTIO'))
  ->setTo(array($toaddr))
  ->setBody("Please Click On The Link given $link");

$result = $mailer->send($message);
   }
  }
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"];
 }
 return $pageURL;
}
?>