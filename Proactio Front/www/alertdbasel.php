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
 include('header.php');
$user=$_SESSION['username'];
$query=mysqli_query($connect,"select dbuid,dbname from configureddb");
?>
<style>
.board {
width:100%;
height:100%;
background:#fff;
margin:0px auto;
}

.board .nav-tabs {
position:relative;
box-sizing:border-box;
margin:0px auto 0;
}

.board > div.board-inner {
background-size:50%;
}

p.narrow {
width:60%;
margin:10px auto;
}



.nav-tabs > li.active > a,.nav-tabs > li.active > a:hover,.nav-tabs > li.active > a:focus {
color:#555;
cursor:default;
border:0;
border-bottom-color:transparent;
}

span.round-tabs {
width:70px;
height:70px;
line-height:35px;
display:inline-block;
border-radius:100px;
background:#FFF;
z-index:2;
position:absolute;
left:0;
text-align:center;
font-size:25px;
}

span.round-tabs i {
line-height:60px;
text-align:center;
}

span.round-tabs.one {
color:#22c222;
border:2px solid #22c222;
}

li.active span.round-tabs.one {
background:#fff!important;
border:2px solid #ddd;
color:#22c222;
}

span.round-tabs.two {
color:#febe29;
border:2px solid #febe29;
}
span.round-tabs.six {
color:#3ea5c3;
border:2px solid #3ea5c3;
}

li.active span.round-tabs.six {
background:#fff!important;
border:2px solid #ddd;
color:#3ea5c3;
}

li.active span.round-tabs.two {
background:#fff!important;
border:2px solid #ddd;
color:#febe29;
}

span.round-tabs.three {
color:#3e5e9a;
border:2px solid #3e5e9a;
}

li.active span.round-tabs.three {
background:#fff!important;
border:2px solid #ddd;
color:#3e5e9a;
}

span.round-tabs.four {
color:#f1685e;
border:2px solid #f1685e;
}

li.active span.round-tabs.four {
background:#fff!important;
border:2px solid #ddd;
color:#f1685e;
}

span.round-tabs.five {
color:#999;
border:2px solid #999;
}

li.active span.round-tabs.five {
background:#fff!important;
border:2px solid #ddd;
color:#999;
}

.nav-tabs > li.active > a span.round-tabs {
background:#fafafa;
}

.nav-tabs > li {
width:16%;
}

li:after {
content:" ";
position:absolute;
left:45%;
opacity:0;
bottom:0;
border:5px solid transparent;
border-bottom-color:#ddd;
transition:.1s ease-in-out;
margin:0 auto;
}



.nav-tabs > li a {
width:70px;
height:70px;
border-radius:100%;
margin:20px auto;
padding:0;
}

.nav-tabs > li a:hover {
background:transparent;
}

.tab-pane {
position:relative;
padding-top:50px;
}

.tab-content .head {
font-family:'Roboto Condensed', sans-serif;
font-size:25px;
text-transform:uppercase;
padding-bottom:10px;
}



@media max-width 585px{
.board {
width:100%;
height:100%;
}

span.round-tabs {
font-size:16px;
width:50px;
height:50px;
line-height:50px;
}

.tab-content .head {
font-size:20px;
}

.nav-tabs > li a {
width:50px;
height:50px;
line-height:50px;
}

li.active:after {
content:" ";
position:absolute;
left:35%;
}


}

    </style>
</style>
	<section >
	 <div class="container">
<div class="row">
	    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">     
	<div class="form-group col-lg-3 pull-right">
	<select class="form-control col-lg-3" id="sel1">
 <?php while($row=mysqli_fetch_assoc($query))
		{
		echo     "<option value='" . $row['dbuid'] . "'>" . $row['dbname'] . "</option>";
		}
		?>
        
      </select>	
	    </div><p>Selected Database Alerts</p></h3>
  </div>		
   <div class="panel-body">
                <div class="board" id="bappu" >
                    <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                    <div class="board-inner" >
					<ul class="nav nav-tabs" id="myTab">
                     <li class="active">
                     <a href="#all" data-toggle="tab" title="ALL ALERTS">
                      <span class="round-tabs five"> 
                              <i class="glyphicon glyphicon-bell"></i><h5>All Alerts</h5>
                      </span> 
                  </a></li>

                  <li><a href="#critical" data-toggle="tab" title="Critical Alert">
                     <span class="round-tabs four">
                         <i class="glyphicon glyphicon-bell"></i><h5>Critical</h5>
                     </span> 
           </a>
                 </li>
                 <li><a href="#major" data-toggle="tab" title="Major Alerts">
                     <span class="round-tabs two">
                          <i class="glyphicon glyphicon-bell"></i><h5>Major</h5>
                     </span> </a>
                     </li>

                     <li><a href="#minor" data-toggle="tab" title="Minor Alerts">
                         <span class="round-tabs three">
                              <i class="glyphicon glyphicon-bell"></i><h5>Minor</h5>
                         </span> 
                     </a></li>
						<li><a href="#unfixed" data-toggle="tab" title="Fixed Alert">
                         <span class="round-tabs six">
                              <i class="glyphicon glyphicon-bell"></i><h5>Unfixed</h5>
                         </span> 
                     </a></li>
                     <li><a href="#fixed" data-toggle="tab" title="unfixed alerts">
                         <span class="round-tabs one">
                              <i class="glyphicon glyphicon-ok"></i><h5>Fixed</h5>
                         </span> </a>
                     </li>
                     
                     </ul>
					

                     <div class="tab-content">
                      <div style = "height: 560px;overflow: scroll; overflow-x: hidden;overflow:auto;"class="tab-pane fade in active" id="all">
					
					  
						<table data-toggle="table"
						   data-url="ajax/allalerts.php"
						   data-query-params="queryParams"
							   data-pagination="true"
							   	   data-show-export="true"
							   data-search="true"
							   data-height="500"
							   id="tab1">
							<thead>
							<tr>
								<th data-field="date">Date</th>
								<th data-field="time">Time</th>
								<th data-field="alerttype">Type</th>
								<th data-field="alertdisc">Description</th>
								<th data-field="alert_read">Fixed/Unfixed</th>
								
							</tr>
							</thead>
						</table>
                      
					  </div>
                      <div style = "height: 560px;overflow: scroll; overflow-x: hidden;overflow:auto;"class="tab-pane fade" id="critical">
					   
					  <table data-toggle="table"
						   data-url="ajax/allalerts.php"
						   data-query-params="queryParams1"
						   data-pagination="true"
						   	   data-show-export="true"
						   data-search="true"
							data-height="400"
							id="tab2">
						<thead>
						<tr>
								<th data-field="date">Date</th>
								<th data-field="time">Time</th>
								<th data-field="alertdisc">Description</th>
								<th data-field="alert_read">Fixed/Unfixed</th>
						</tr>
						</thead>
					</table>
				
					  </div>
                      <div style = "height: 560px;overflow: scroll; overflow-x: hidden;overflow:auto;"class="tab-pane fade" id="minor">
				
                       <table data-toggle="table"
							  data-url="ajax/allalerts.php"
						   data-query-params="queryParams2"
							   data-pagination="true"
							   	   data-show-export="true"
							   data-search="true"
						 data-height="400"
						 id="tab3">
							<thead>
							<tr>
								<th data-field="date">Date</th>
								<th data-field="time">Time</th>
								<th data-field="alertdisc">Description</th>
								<th data-field="alert_read">Fixed/Unfixed</th>
							</tr>
							</thead>
						</table>
                
					  </div>
                      <div style = "height: 560px;overflow: scroll; overflow-x: hidden;overflow:auto;"class="tab-pane fade" id="major">
					
                   <table data-toggle="table"
						 data-url="ajax/allalerts.php"
						   data-query-params="queryParams3"
						   	   data-show-export="true"
						   data-pagination="true"
						   data-search="true"
					 data-height="400"
					 id="tab4">
						<thead>
						<tr>
								<th data-field="date">Date</th>
								<th data-field="time">Time</th>
								<th data-field="alertdisc">Description</th>
								<th data-field="alert_read">Fixed/Unfixed</th>
						</tr>
						</thead>
					</table>
	              
					  </div>
                      <div style = "height: 560px;overflow: scroll; overflow-x: hidden;overflow:auto;"class="tab-pane fade" id="unfixed">
					  
					<table data-toggle="table"
						   data-url="ajax/allalerts.php"
						   data-query-params="queryParams4"
						   data-pagination="true"
						   data-search="true"
						   	   data-show-export="true"
						  data-height="400"
						id="tab5" >
						<thead>
						<tr>
								<th data-field="date">Date</th>
								<th data-field="time">Time</th>
								<th data-field="alertdisc">Description</th>
								<th data-field="alerttype">Type</th>


						</tr>
						</thead>
					</table>

					  </div>
					 <div style = "height: 560px;overflow: scroll; overflow-x: hidden;overflow:auto;"class="tab-pane fade" id="fixed">
			
					<table data-toggle="table"
						   data-url="ajax/allalerts.php"
						   data-query-params="queryParams5"
						   data-pagination="true"
						   	   data-show-export="true"
						   data-search="true"
						   data-height="400"
						   id="tab6">
						<thead>
						<tr>
								<th data-field="date">Date</th>
								<th data-field="time">Time</th>
								<th data-field="alertdisc">Description</th>
								<th data-field="alerttype">Type</th>
								<th data-field="enddate">End Date</th>
						</tr>
						</thead>
					</table>
					
					  </div> </div>

</div>
</div>
</div>
</div>
</div>
</div>
</section>
<script>
var selected= $("#sel1 option:selected").val();
$('#sel1').on('change', function() {
 selected = this.value;
 $("#tab1,#tab2,#tab3,#tab4,#tab5,#tab6").bootstrapTable('refresh', {silent: false});
// $('#tab2').bootstrapTable('refresh', {silent: true});
});
function queryParams() {
    return {
        username: '<?php echo $user;?>',
		dbuid: selected
    };
}function queryParams1() {
    return {
        username: '<?php echo $user;?>',
		type:'critical' ,
		dbuid: selected
    };
}
function queryParams2() {
    return {
        username: '<?php echo $user;?>',
		type:'minor' ,
		dbuid: selected
    };
}
function queryParams3() {
    return {
        username: '<?php echo $user;?>',
		type:'major' ,
		dbuid: selected
    };
}function queryParams4() {
    return {
        username: '<?php echo $user;?>',
		read:0 ,
		dbuid: selected
    };
}function queryParams5() {
    return {
        username: '<?php echo $user;?>',
		read:1 ,
		dbuid: selected
    };
}
$("#tab1,#tab2,#tab3,#tab4,#tab5,#tab6").bootstrapTable({
    formatNoMatches: function () {
        return '<img src="images/noalerts.gif"></img>';
    },
	formatLoadingMessage: function () {
   return '<img src="/images/loadingalerts.gif"></img>';
    }
});
</script>