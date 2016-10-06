<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("c_transactions.php");
$inactive = 600;
if(!isset($_SESSION['timeout']) ) {
   header("Location: logout.php");
}
else{
  $session_life = time() - $_SESSION['timeout'];
  if($session_life > $inactive) { 
    header("Location: logout.php"); 
  }
}

$_SESSION['timeout'] = time();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Early Infant Registration</title>
     <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/css/jquery.dataTables.css">
        <!-- jQuery -->
        <script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>
        <script>
            $( document ).ready(function() {
                $('#registration').dataTable({
                    "bProcessing": true,
                    "fixedHeader": true,
                    "sAjaxSource": "registration_response.php",
                     aoColumns: [
                           { mData: 'Mother_StudyID' },
                           { mData: 'HEI_ID' },
                           { mData: 'DOB' },
                           { mData: 'ARV_Prophylaxis' },
                           { mData: 'Enrolled_Date' },
                           { mData: 'Age_Enrolled_In_Weeks'},
                           {
                           "aTargets": [10],    
                           "mData": "Reg_ID",  
                           "mRender": function (data, type, full) {
                             return '<a href=infant_summary.php?&id=' + data +'>More</a> | <a href=registration.php?action=edit&id=' + data +'>Edit</a> | <a href=registration.php?action=delete&id=' + data +'>Delete</a>';
                               }
                           }
                       ]
                                
                });   
            });

        </script> 

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script>
        function enableToggle(){
            if (document.getElementById("arv_pro").value == "5")
            {
                document.getElementById("other").disabled = false;
            }else
            {
                document.getElementById("other").disabled = true;
            }
        }
    </script>
    <script type="text/javascript">
       setTimeout(function() { window.location.href = "logout.php"; }, 6000000);
    </script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right"><?php echo $_SESSION["name"]." is logged in."; ?>
               
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>-->
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="alert alert-success">
                                <a class="alert-link" href="dashboard.php"><?php include('version.php'); ?></a>
                            </div>
                        </li>
                        <li>
                            <a href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <!--<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Menus<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">-->
                     <?php foreach ($_SESSION["access"] as $key => $access) { ?>
                        <li>
                            <?php echo '<a href="#"><i class="fa fa-arrow-circle-right"></i>'. $access["top_menu_name"].'<span class="fa arrow"></span></a>'; ?>
                            <?php
                            echo '<ul class="nav nav-second-level">';
                            foreach ($access as $k => $val) {
                                if ($k != "top_menu_name") {
                                    echo '<li><a href="' . ($val["page_name"]) . '">' . $val["menu_name"] . '</a></li>';
                                    ?>
                                    <?php
                                }
                            }
                            echo '</ul>';
                            ?>
                        </li>
                    <?php
                }
                ?>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Infant Registration form</h1>
                    <div class="panel panel-default">
                            <div class="table-responsive">
                                <a href="registration.php?action=add"  class="fa fa-pencil"> Add new</a>
                                <!--
                                         <button type="button" onclick="window.location.href='import_data.php?form=infant_registration&action=import'" class="btn btn-outline btn-primary btn-xs">Data Import from CSV</button>
                                       <form id="infant_registration" action="import_data.php?form=infant_registration" method="post">
                                            <button type="submit" name="btn_export">Data Export</button> 
                                            <button type="submit" name="btn_import">Data Import from CSV</button>
                                        </form>-->
                                        <form action="import_csv.php?form=infant_registration&action=import" method="post" enctype="multipart/form-data">
                                            Select CSV file for Infant Registrations:
                                            <input name="csv" type="file" />
                                            <input type="submit" value="Import selected CSV file" class="btn btn-outline btn-primary btn-xs" />
                                          </form>
                                        <p> ---- </p>
                                <table id="registration" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Mother_StudyID</th>
                                                    <th>HEI_ID</th>
                                                    <th>DOB</th>
                                                    <th>ARV_Prophylaxis</th>
                                                    <th>Enrolled_Date</th>
                                                    <th>Age_Enrolled_In_Weeks</th>
                                                     <th>Action</th>
                                                </tr>
                                            </thead>
                                             
                                        </table>
                                    </div>
                    </div><!-- chedk here -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

 <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>