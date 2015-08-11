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

$path=getcwd();
chdir('..');
$path=getcwd();
chdir('php/pear');
 $path=getcwd();
 set_include_path($path);
	ob_start();
	session_start();
	require_once("sqlconnect.php");
	$query=mysqli_query($connect,"SELECT * from request");
	$rows=mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DBA DASHBOARD</title>
<link rel="icon" href="images/Magnifying-glass.ico">
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/locale/bootstrap-table-en-US.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script src="js/formvalidation1.js"></script>
<script src="https://rawgit.com/kayalshri/tableExport.jquery.plugin/master/jquery.base64.js"></script>
  <script src="https://rawgit.com/kayalshri/tableExport.jquery.plugin/master/tableExport.js"></script>
  <script src="https://rawgit.com/wenzhixin/bootstrap-table/master/src/extensions/export/bootstrap-table-export.js"></script>
  -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-table.min.css">
<link rel="stylesheet" href="css/datepicker.min.css" />
<link rel="stylesheet" href="css/datepicker3.min.css" />
<script src="js/1.11.1_jquery.min.js"></script>
<script type="text/javascript" src="js/1.10.2_jquery.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-table-en-US.min.js"></script>
<script src="js/bootstrap-table.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/formvalidation1.js"></script>
<script src="js/jquery.base64.js"></script>
  <script src="js/tableExport.js"></script>
  <script src="js/bootstrap-table-export.js"></script>
  <script>
  $(document).ready(function () {
  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();      
    });

    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  }); 
   $(window).scroll(function () {
      //if you hard code, then use console
      //.log to determine when you want the 
      //nav bar to stick.  
      console.log($(window).scrollTop())
    if ($(window).scrollTop() > 90) {
      $('#nav_bar').addClass('navbar-fixed');
    }
    if ($(window).scrollTop() < 90) {
      $('#nav_bar').removeClass('navbar-fixed');
    }
  });
      $('#dateRangePicker')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm').formValidation('revalidateField', 'date');
        });
		      $('#dateRangePicker1')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm1').formValidation('revalidateField', 'date');
        }); $('#dateRangePicker2')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm2').formValidation('revalidateField', 'date');
        }); $('#dateRangePicker3')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm3').formValidation('revalidateField', 'date');
        }); $('#dateRangePicker4')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm4').formValidation('revalidateField', 'date');
        }); $('#dateRangePicker5')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm5').formValidation('revalidateField', 'date');
        });$('#dateRangePicker6')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm6').formValidation('revalidateField', 'date');
        });$('#dateRangePicker7')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm7').formValidation('revalidateField', 'date');
        });$('#dateRangePicker8')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm8').formValidation('revalidateField', 'date');
        });$('#dateRangePicker9')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm9').formValidation('revalidateField', 'date');
        });$('#dateRangePicker10')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm10').formValidation('revalidateField', 'date');
        });$('#dateRangePicker11')
        .datepicker({
            format: 'yyyy/mm/dd',
            startDate: '2015/01/01',
			autoclose:true,
            endDate: '0d'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#dateRangeForm11').formValidation('revalidateField', 'date');
        });
		 $('#dateRangeForm,#dateRangeForm1,#dateRangeForm2,#dateRangeForm3,#dateRangeForm4,#dateRangeForm5,#dateRangeForm6,#dateRangeForm7,#dateRangeForm8,#dateRangeForm9,#dateRangeForm10,#dateRangeForm11').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            date: {
                validators: {
                    notEmpty: {
                        message: 'The date is required'
                    },
                    date: {
                        format: 'YYYY/MM/DD',
                        min: '2010/01/01',
                        max: '2020/01/01',
                        message: 'The date is not a valid'
                    }
                }
            }
        }
    });
});
  </script>
<style>

@import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
body{
min-height:900px;
}
.datepicker{z-index:1151 !important;}
.panel-red {
    border-color: #d9534f;
}
#dateRangeForm .form-control-feedback,
#dateRangeForm1 .form-control-feedback,
#dateRangeForm2 .form-control-feedback,  
#dateRangeForm3 .form-control-feedback, 
#dateRangeForm4 .form-control-feedback,
#dateRangeForm5 .form-control-feedback,
#dateRangeForm6 .form-control-feedback,
#dateRangeForm7 .form-control-feedback,
#dateRangeForm8 .form-control-feedback,
#dateRangeForm9 .form-control-feedback,
#dateRangeForm10 .form-control-feedback,
#dateRangeForm11 .form-control-feedback{
    top: 0;
    right: -15px;
}
.panel-red .panel-heading {
    border-color: #d9534f;
    color: #fff;
    background-color: #d9534f;
}

.panel-red a {
    color: #d9534f;
}

.panel-red a:hover {
    color: #b52b27;
}
.huge {
    font-size: 40px;
}
.panel-green {
    border-color: #5cb85c;
}

.panel-green .panel-heading {
    border-color: #5cb85c;
    color: #fff;
    background-color: #5cb85c;
}

.panel-green a {
    color: #5cb85c;
}

.panel-green a:hover {
    color: #3d8b3d;
}
.panel-yellow {
    border-color: #f0ad4e;
}

.panel-yellow .panel-heading {
    border-color: #f0ad4e;
    color: #fff;
    background-color: #f0ad4e;
}

.panel-yellow a {
    color: #f0ad4e;
}

.panel-yellow a:hover {
    color: #df8a13;
}
body {
    position: relative;
    overflow-x: hidden;
}
body,
html { height: 100%;}
.nav .open > a, 
.nav .open > a:hover, 
.nav .open > a:focus {background-color: transparent;}

/*-------------------------------*/
/*           Wrappers            */
/*-------------------------------*/

#wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#wrapper.toggled {
    padding-left: 220px;
}

#sidebar-wrapper {
    z-index: 1000;
    left: 220px;
    width: 0;
    height: 100%;
    margin-left: -220px;
    overflow-y: auto;
    overflow-x: hidden;
    background: #1a1a1a;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#sidebar-wrapper::-webkit-scrollbar {
  display: none;
}

#wrapper.toggled #sidebar-wrapper {
    width: 220px;
}

#page-content-wrapper {
    width: 100%;
    padding-top: 0px;
}

#wrapper.toggled #page-content-wrapper {
    position: absolute;
    margin-right: -220px;
}

/*-------------------------------*/
/*     Sidebar nav styles        */
/*-------------------------------*/

.sidebar-nav {
    position: absolute;
    top: 0;
    width: 220px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.sidebar-nav li {
    position: relative; 
    line-height: 20px;
    display: inline-block;
    width: 100%;
}

.sidebar-nav li:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    z-index: -1;
    height: 100%;
    width: 3px;
    background-color: #1c1c1c;
    -webkit-transition: width .2s ease-in;
      -moz-transition:  width .2s ease-in;
       -ms-transition:  width .2s ease-in;
            transition: width .2s ease-in;

}
.sidebar-nav li:first-child a {
    color: #fff;
    background-color: #1a1a1a;
}
.sidebar-nav li:nth-child(2):before {
    background-color: #ec1b5a;   
}
.sidebar-nav li:nth-child(3):before {
    background-color: #79aefe;   
}
.sidebar-nav li:nth-child(4):before {
    background-color: #314190;   
}
.sidebar-nav li:nth-child(5):before {
    background-color: #279636;   
}
.sidebar-nav li:nth-child(6):before {
    background-color: #7d5d81;   
}
.sidebar-nav li:nth-child(7):before {
    background-color: #ead24c;   
}
.sidebar-nav li:nth-child(8):before {
    background-color: #2d2366;   
}
.sidebar-nav li:nth-child(9):before {
    background-color: #35acdf;   
}
.sidebar-nav li:nth-child(10):before {
    background-color: #314190;  
}
.sidebar-nav li:nth-child(11):before {
    background-color: #ec1b5a;   
}
.sidebar-nav li:nth-child(12):before {
     background-color: #314190;     
}
.sidebar-nav li:hover:before,
.sidebar-nav li.open:hover:before {
    width: 100%;
    -webkit-transition: width .2s ease-in;
      -moz-transition:  width .2s ease-in;
       -ms-transition:  width .2s ease-in;
            transition: width .2s ease-in;

}

.sidebar-nav li a {
    display: block;
    color: #ddd;
    text-decoration: none;
    padding: 10px 15px 10px 30px;    
}

.sidebar-nav li a:hover,
.sidebar-nav li a:active,
.sidebar-nav li a:focus,
.sidebar-nav li.open a:hover,
.sidebar-nav li.open a:active,
.sidebar-nav li.open a:focus{
    color: #fff;
    text-decoration: none;
    background-color: transparent;
}

.sidebar-nav > .sidebar-brand {
    height: 65px;
    font-size: 20px;
    line-height: 44px;
}
.sidebar-nav .dropdown-menu {
    position: relative;
    width: 100%;
    padding: 0;
    margin: 0;
    border-radius: 0;
    border: none;
    background-color: #222;
    box-shadow: none;
}

/*-------------------------------*/
/*       Hamburger-Cross         */
/*-------------------------------*/

.hamburger {
  position: fixed;
  top: 150px;  
  z-index: 999;
  display: block;
  width: 32px;
  height: 32px;
  margin-left: 15px;
  background: transparent;
  border: none;
}
.hamburger:hover,
.hamburger:focus,
.hamburger:active {
  outline: none;
}
.hamburger.is-closed:before {
  content: '';
  display: block;
  width: 100px;
  font-size: 14px;
  color: #fff;
  line-height: 32px;
  text-align: center;
  opacity: 0;
  -webkit-transform: translate3d(0,0,0);
  -webkit-transition: all .35s ease-in-out;
}
.hamburger.is-closed:hover:before {
  opacity: 1;
  display: block;
  -webkit-transform: translate3d(-100px,0,0);
  -webkit-transition: all .35s ease-in-out;
}

.hamburger.is-closed .hamb-top,
.hamburger.is-closed .hamb-middle,
.hamburger.is-closed .hamb-bottom,
.hamburger.is-open .hamb-top,
.hamburger.is-open .hamb-middle,
.hamburger.is-open .hamb-bottom {
  position: absolute;
  left: 0;
  height: 4px;
  width: 100%;
}
.hamburger.is-closed .hamb-top,
.hamburger.is-closed .hamb-middle,
.hamburger.is-closed .hamb-bottom {
  background-color: #1a1a1a;
}
.hamburger.is-closed .hamb-top { 
  top: 5px; 
  -webkit-transition: all .35s ease-in-out;
}
.hamburger.is-closed .hamb-middle {
  top: 50%;
  margin-top: -2px;
}
.hamburger.is-closed .hamb-bottom {
  bottom: 5px;  
  -webkit-transition: all .35s ease-in-out;
}

.hamburger.is-closed:hover .hamb-top {
  top: 0;
  -webkit-transition: all .35s ease-in-out;
}
.hamburger.is-closed:hover .hamb-bottom {
  bottom: 0;
  -webkit-transition: all .35s ease-in-out;
}
.hamburger.is-open .hamb-top,
.hamburger.is-open .hamb-middle,
.hamburger.is-open .hamb-bottom {
  background-color: #1a1a1a;
}
.hamburger.is-open .hamb-top,
.hamburger.is-open .hamb-bottom {
  top: 50%;
  margin-top: -2px;  
}
.hamburger.is-open .hamb-top { 
  -webkit-transform: rotate(45deg);
  -webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
}
.hamburger.is-open .hamb-middle { display: none; }
.hamburger.is-open .hamb-bottom {
  -webkit-transform: rotate(-45deg);
  -webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
}
.hamburger.is-open:before {
  content: '';
  display: block;
  width: 100px;
  font-size: 14px;
  color: #fff;
  line-height: 32px;
  text-align: center;
  opacity: 0;
  -webkit-transform: translate3d(0,0,0);
  -webkit-transition: all .35s ease-in-out;
}
.hamburger.is-open:hover:before {
  opacity: 1;
  display: block;
  -webkit-transform: translate3d(-100px,0,0);
  -webkit-transition: all .35s ease-in-out;
}

/*-------------------------------*/
/*            Overlay            */
/*-------------------------------*/

.overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(250,250,250,.8);
    z-index: 1;
}
.navbar-fixed {
  top: 0;
  z-index: 100;
  position: fixed;
  width: 100%;
}
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
</style>

   <div id="wrapper">
   <header>
<div class="jumbotron" style="height:90px;padding-top:0px; margin-bottom:0;background-color: transparent;">
      <a href="dbahome.php"><img src="images/logo.png" style="padding-top:10px;padding-left:20px;"></a>
 </div>
 </header>
   <nav class="navbar navbar-default" id='nav_bar'>
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
<li>  <a href="dbahome.php">Dashboard</a>
</li>
	  	  	        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Database <b class="caret"></b></a>
        <ul class="dropdown-menu">
                    <li><a href="dbastatus.php"><i class="fa fa-database fa-fw"></i>Database Status</a></li>
                    <li><a href="activity.php"><i class="fa fa-database fa-fw"></i>Database I/O Activity I</a></li>
					<li><a href="activity2.php"><i class="fa fa-database fa-fw"></i>Database I/O Activity II</a></li>
                    <li><a href="dbaareastatus.php"><i class="fa fa-database fa-fw"></i>Area Growth Status</a></li>
                    <li><a href="dbatrans.php"><i class="fa fa-database fa-fw"></i>Active Transactions</a></li>
                    <li><a href="dbareclock.php"><i class="fa fa-database fa-fw"></i>Database Locking</a></li>
                    <li><a href="dbaprimaryrecovery.php"><i class="fa fa-database fa-fw"></i>Primary Recovery Area</a></li>
                    <li><a href="dbausers.php"><i class="fa fa-database fa-fw"></i>Database Users</a></li>
                    <li><a href="dbconnectedusers.php"><i class="fa fa-database fa-fw"></i>User Connection</a></li>
                    <li><a href="dbaafterimage.php"><i class="fa fa-database fa-fw"></i>After Image Area</a></li>
                    <li><a href="dbafiles.php"><i class="fa fa-database fa-fw"></i>Database Extents Info.</a></li>
                    <li><a href="dbfeatures.php"><i class="fa fa-database fa-fw"></i>Database Features</a></li>
                    <li><a href="dbastartupparams.php"><i class="fa fa-database fa-fw"></i>Start Up Parameters</a></li>
                    <li><a href="dbaserverstatus.php"><i class="fa fa-database fa-fw"></i>Server Status</a></li>
                    
        </ul>
      </li>
	        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Server <b class="caret"></b></a>
        <ul class="dropdown-menu">
                    <li><a href="dbacpuutil.php"><i class="fa fa-server fa-fw"></i>CPU</a></li>
                    <li><a href="dbamemutil.php"><i class="fa fa-server fa-fw"></i>Memory</a></li>
                    <li><a href="dbadiskutil.php"><i class="fa fa-server fa-fw"></i>Disk</a></li>
                    <li><a href="dbaprocutil.php"><i class="fa fa-server fa-fw"></i>Processes</a></li>
        </ul>
      </li>
	        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Alerts <b class="caret"></b></a>
        <ul class="dropdown-menu">
                    <li><a href="alertdbasel.php"><i class="fa fa-bell fa-fw "></i>Selected Database</a></li>
                    <li><a href="alertdbaall.php"><i class="fa fa-bell fa-fw "></i>All Databases</a></li>
        </ul>
      </li>
	        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Graphs <b class="caret"></b></a>
        <ul class="dropdown-menu">
                    <li><a href="dataareachart.php"><i class="fa fa-bar-chart-o fa-fw"></i>Data Area</a></li>
                    <li><a href="cpuchart.php"><i class="fa fa-bar-chart-o fa-fw"></i>CPU</a></li>
                    <li><a href="memorychart.php"><i class="fa fa-bar-chart-o fa-fw"></i>Memory Utilization</a></li>
                    <li><a href="diskchart.php"><i class="fa fa-bar-chart-o fa-fw"></i>Disk Utilization</a></li>
        </ul>
      </li>
	   <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">

				                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Database</a>
                            <ul class="dropdown-menu">
                               	<li><a href='#'data-toggle="modal" data-target="#myDbinfo"><span> <i class="fa fa-file-pdf-o fa-fw"></i>AREA GROWTH REPORT</span></a></li>
							   <li class='last'><a href='#'data-toggle="modal" data-target="#mybir"><span> <i class="fa fa-file-pdf-o fa-fw"></i>BI SIZE REPORT</span></a></li>
							   <li class='last'><a href='#'data-toggle="modal" data-target="#mylts"><span> <i class="fa fa-file-pdf-o fa-fw"></i>LONG TRANSACTION</span></a></li>
							   <li class='last'><a href='#'data-toggle="modal" data-target="#mydior"><span> <i class="fa fa-file-pdf-o fa-fw"></i>DATABASE I/O REPORT</span></a></li>
							   <li class='last'><a href='#'data-toggle="modal" data-target="#mytior"><span> <i class="fa fa-file-pdf-o fa-fw"></i>TABLE I/O REPORT</span></a></li>
							   <li class='last'><a href='#'data-toggle="modal" data-target="#myir"><span> <i class="fa fa-file-pdf-o fa-fw"></i>INDEX REPORTS</span></a></li>
							   <li class='last'><a href='#'data-toggle="modal" data-target="#myuior"><span> <i class="fa fa-file-pdf-o fa-fw"></i>USER I/O REPORT</span></a></li>
							   <li class='last'><a href='#'data-toggle="modal" data-target="#mydbcs"><span> <i class="fa fa-file-pdf-o fa-fw"></i>DATABASE CONNECTION </span></a></li>
                            </ul>
                        </li>
						   <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Server</a>
							<ul class="dropdown-menu">
								<li class='last'><a href='#'data-toggle="modal" data-target="#mycpu"><span> <i class="fa fa-file-pdf-o fa-fw"></i>CPU REPORT</span></a></li>
							   <li class='last'><a href='#'data-toggle="modal" data-target="#mymem"><span> <i class="fa fa-file-pdf-o fa-fw"></i>MEMORY REPORT</span></a></li>
							   <li class='last'><a href='#'data-toggle="modal" data-target="#mydsk"><span> <i class="fa fa-file-pdf-o fa-fw"></i>DISK REPORT</span></a></li>
							</ul>
                        </li>
                        <li class="divider"></li>
						 <li>
                    <a href='genpdf.php' target="_blank"> <i class="fa fa-file-pdf-o fa-fw"></i> WEEKLY REPORT</a>
                </li>
				 <li>
                    <a href='reportsmonth.php' target="_blank"> <i class="fa fa-file-pdf-o fa-fw"></i> MONTHLY REPORT</a>
                </li>
				 <li>
                    <a href='alertdbapdf.php' target="_blank"> <i class="fa fa-file-pdf-o fa-fw"></i> ALERTS REPORT</a>
                </li>                </ul>
                </li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
      <li> <?php
     if(isset($_SESSION['username'])){
        echo '<a class="nav navbar-nav" >' 
        ."Welcome:". $_SESSION['username'] . '</a>';
       }
    else {
     	header('Location: index.php');
    }
    
    ?></li>
       <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
  </div><!-- /.container-fluid -->
</nav>
<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                       Administrator
                    </a>
                </li>
				<li><a href="apprej.php">User Requests <span class="badge"><?php echo $rows;?></span></a></li>
				<li><a href="changeconf.php">Database Configuration</a></li>
				<li><a href="prousers.php">ProActio Users</a></li>
				<li><a href="changepwem.php">Account Settings</a></li>
				
            </ul>
        </nav>
		<div id="page-content-wrapper">
            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
    			<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
            </button>
		 </div>
<div class="modal fade" id="myDbinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">AREA GROWTH REPORT</h4>
      </div>
      <div class="modal-body">
<form id="dateRangeForm"  action="areastatrep.php" method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mybir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">BI SIZE REPORT</h4>
      </div>
      <div class="modal-body">
 <form id="dateRangeForm2" action="birep.php" method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker2">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mylts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">LONG TRANSACTION SUMMARY</h4>
      </div>
      <div class="modal-body">
<form id="dateRangeForm3" action="ltsrep.php" method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker3">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mydior" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">DATABASE I/O REPORT</h4>
      </div>
      <div class="modal-body">
<form id="dateRangeForm4"action="diorep.php"method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker4">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mytior" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">TABLE I/O REPORT</h4>
      </div>
      <div class="modal-body">
 <form id="dateRangeForm5"action="tiorep.php"method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker5">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">INDEX REPORTS</h4>
      </div>
      <div class="modal-body">
 <form id="dateRangeForm6"action="idxrep.php"method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker6">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myuior" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">USER I/O REPORT</h4>
      </div>
      <div class="modal-body">
 <form id="dateRangeForm7"action="uiorep.php"method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker7">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mydbcs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">DATABASE CONNECTION SUMMARY</h4>
      </div>
      <div class="modal-body">
 <form id="dateRangeForm8"action="dbconnrep.php"method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker8">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mycpu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CPU REPORT</h4>
      </div>
      <div class="modal-body">
 <form id="dateRangeForm9"action="cpurep.php"method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker9">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mymem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">MEMORY REPORT</h4>
      </div>
      <div class="modal-body">
 <form id="dateRangeForm10"action="memrep.php"method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker10">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mydsk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">DISK SPACE</h4>
      </div>
      <div class="modal-body">
 <form id="dateRangeForm11"action="diskrep.php"method="post" target="_blank" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Select Date</label>
        <div class="col-xs-5 date">
            <div class="input-group input-append date" id="dateRangePicker11">
                <input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Generate PDF</button>
        </div>
    </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>