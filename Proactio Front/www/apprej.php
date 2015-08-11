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
require('header.php');
require_once('sqlconnect.php');
$msg='';
$query=mysqli_query($connect,"SELECT userid,dbuid from request");
$num_req = mysqli_num_rows($query);
if ($num_req == 0) {
		$msg = "No Requests Exists.";
	} 
?>
<?php
if(isset($_POST['approve']) && !empty($_POST['dbid1'])&& !empty($_POST['userid1']) )
{

$dbid=$_POST['dbid1'];
$uid=$_POST['userid1'];
$query1=mysqli_query($connect,"INSERT INTO dbparam ( userid , dbuid )values('$uid','$dbid')");
if($query1)
{
mysqli_query($connect,"Delete from request where userid='$uid' and dbuid='$dbid'");
header('location: apprej.php');
}
}
elseif(isset($_POST['reject'])&&!empty($_POST['dbid1'])&&!empty($_POST['userid1']))
{
$dbid=$_POST['dbid1'];
$uid=$_POST['userid1'];
$query3=mysqli_query($connect,"delete from request where userid='$uid' and dbuid ='$dbid'");
header('location: apprej.php');
}
?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <title>APPROVE/REJECT</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
 if ($msg <> '')
	{
	echo '<div class="container"><h4>'; 
	echo  $msg;
	echo '</h4></div></div>';
	}else{
	?>
<div class="container col-md-6 col-md-offset-2">        
  <table class="table table-hover">
    <thead>
      <tr>
        <th>USERNAME</th>
		<th>Database Id</th>
        <th>Database Name</th>	
      </tr>
    </thead>
    <tbody>
	
	<?php while( $result=mysqli_fetch_assoc($query) ){?>
	<form action="" method="POST">
      <tr class="default">
        <td><?php echo $userid=$result['userid'];?></td>
		<td><?php echo $dbuid=$result['dbuid'];?></td>
        <td><?php $query2=mysqli_query($connect,"SELECT dbname from configureddb where dbuid='$dbuid'");$result1=mysqli_fetch_row($query2); echo $result1[0]; ?></td>
        
	     <input type ="hidden" name="dbid1" value=<?php echo $dbuid?>>
	     <input type ="hidden" name="userid1" value=<?php echo $userid?>>
	     <td>
				
				<input type="submit" name="approve" value="Approve" class="btn btn-success">
		 </td>
		 <td>	
				<input type ="submit"name ="reject" value ="Reject" class="btn btn-danger">
		 </td>
      </tr>
	</form>
	<?php }?>
    </tbody>
<?php }?>
  </table>
</div>

</body>
</html>
