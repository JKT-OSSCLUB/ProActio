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
if(!empty($_GET['uid']))
{
$uid=$_GET['uid'];
$query=mysqli_query($connect,"SELECT userid,dbuid from dbparam Where userid ='$uid'");
$num_req = mysqli_num_rows($query);
if ($num_req == 0) {
		$msg = "No Databases Alloted to this User.";
	} 
	
}
?>
<?php
if(isset($_POST['revokedb'])&&!empty($_POST['dbid1'])&&!empty($_POST['userid1']))
{
$dbid=$_POST['dbid1'];
$uid=$_POST['userid1'];
$query3=mysqli_query($connect,"delete from dbparam where userid='$uid' and dbuid ='$dbid'");
header('location: prousers.php');
}
?>
<body>
<div class="container col-md-6"><h4>
<?php
 if ($msg <> '')
	{	
	echo  $msg;
	}else{
	echo "<center>User Id : ", $uid,"</center>";
?>
</h4></div></div>
<div class="container col-md-6 col-md-offset-2">        
  <table class="table table-hover">
    <thead>
      <tr>        
		<th>Database Id</th>
        <th>Database Name</th>
      </tr>
    </thead>
    <tbody>
	<?php while( $result=mysqli_fetch_assoc($query) ){?>
	<form action="" method="POST">
	  <tr class="default">
        
		<td><?php echo $dbuid=$result['dbuid'];?></td>
        <td><?php $query2=mysqli_query($connect,"SELECT dbname from configureddb where dbuid='$dbuid'");$result1=mysqli_fetch_row($query2); echo $result1[0]; ?></td>        
			<input type ="hidden" name="dbid1" value=<?php echo $dbuid?>>
			<input type ="hidden" name="userid1" value=<?php echo $uid?>>
		<td>
			
			<button type="button" data-toggle="modal" data-target="#ConfirmModal"name ="reject" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Revoke
			</button>
		</td>
      </tr>
	
	
	
<!--confirm revoke modal-->
<div class="modal fade" id="ConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>          
				<h4><span class="glyphicon glyphicon-question-sign"></span> Confirm Revoke?</h4>
            </div>
            <div class="modal-body">
			<h5><span class="glyphicon"></span>				
                Are you sure you want to continue?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>				
            <button type="submit" name="revokedb" class="btn btn-danger">Revoke</button>
            </div>
        </div>
    </div>
</div>
<!---->
<?php }?>
</form>
    </tbody>
  </table>
</div>
<?php }?>
</body>
</html>
