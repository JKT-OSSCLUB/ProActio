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
$query=mysqli_query($connect,"SELECT user_id,name,email_id,mobile from login_db");

?>
 <?php
 if(isset($_POST['viewDetails'])&&!empty($_POST['uid']))
{
$uid=mysqli_real_escape_string($connect,stripslashes($_POST['uid']));
header("location:revoke.php?uid=$uid");
}
elseif(isset($_POST['deluser'])&&!empty($_POST['uid']))
{
$uid=mysqli_real_escape_string($connect,stripslashes($_POST['uid']));
$querysel=mysqli_query($connect,"Select * from login_db where user_id ='$uid'");
if(mysqli_num_rows($querysel))
{
 $querydel=mysqli_query($connect,"DELETE from login_db where user_id='$uid'");
 if($querydel)
 {
 header("location:prousers.php");
 }
}
}
?>
 <div class="container col-md-8 col-md-offset-2">        
  <table class="table table-hover">
    <thead>
      <tr>
        <th>User Id</th>
		<th>Username</th>
        <th>Email-Id</th>
        <th>Contact Number</th>
		<th></th>
		<th></th>
      </tr>
    </thead>
    <tbody>
	<?php while( $result = mysqli_fetch_assoc($query) ){?>
	<form action="" method="POST">
      <tr class="default">
        <td><?php echo $userid=$result['user_id'];?></td>
		<td><?php echo $username=$result['name'];?></td>
        <td><?php echo $email=$result['email_id'];?></td>
       	<td><?php echo $mobile=$result['mobile'];?></td>
		<input type="hidden" name="uid"  value= <?php echo $result['user_id'];?>>
		<td>						
				<button type ="submit" name ="viewDetails" class="btn btn-info">
					<i class="glyphicon glyphicon-eye-open "></i> View
				</button>			
		</td>
		<td>	
	<button  type ="button" data-toggle="modal" data-target="#deleteConfirmModal<?php echo $result['user_id'];?>" class="btn btn-danger">
					<i class="glyphicon glyphicon-trash"></i> Delete User
				</button>										
		</td>
      </tr>
	  <div class="modal fade" id="deleteConfirmModal<?php echo $result['user_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>          
				<h4><span class="glyphicon glyphicon-question-sign"></span> Confirm Delete</h4>
            </div>
            <div class="modal-body">
			<h5><span class="glyphicon"></span>
				You have selected to permanently delete this user.
                Are you sure you want to continue?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>				
            <button type="submit" name="deluser" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
	</form>
<?php }?>
    </tbody>
  </table>
</div>


</body>
</html>
