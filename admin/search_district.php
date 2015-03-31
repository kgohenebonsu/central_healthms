<?php
    include 'health_action.php';
    session_start();
    if(!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Central~HealthMS | Districts</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">


    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php"><font size="5" color="#cdbfe3">Central~HealthMS Administrator</font></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li>
                    <div align="right">
                            <form align="right" action='search_district.php' method="POST" enctype="multipart/form-data" class="navbar-form" role="search">
                            <div class="input-group add-on">
                              <input style="min-width:300px; max-width:300px;" type="text" class="form-control" placeholder="Search by District name..." name="search" id="search">
                              <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                              </div>
                            </div>
                          </form>
                </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div style="color:white;"><i class="fa fa-user"></i> Welcome, 
                            <?php 
                                echo $_SESSION['a_fullname'];
                            ?> 
                            <b class="caret"></b></div></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dashboard.php"><div style="color:white;">
                            <i class="fa fa-fw fa-dashboard"></i> Dashboard</div></a>
                    </li>
                    <li>
                        <a href="manage_hospitals.php"><div style="color:white;"><i class="fa fa-fw fa-edit">
                        </i> Manage Hospitals</div></a>
                    </li>
                    <li>
                        <a href="health_officials.php"><div style="color:white;"><i class="fa fa-fw fa-edit">
                        </i> Manage Health Officials</div></a>
                    </li>
                    <li style="background-color: #663399;">
                        <a href="districts.php"><div style="color:white;"><i class="fa fa-fw fa-desktop">
                        </i> Districts</div></a>
                    </li>
                    <li>
                        <a href="sub_districts.php"><div style="color:white;"><i class="fa fa-fw fa-desktop">
                        </i> Sub-Districts</div></a>
                    </li>
                    <!-- <li>
                        <a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                    </li> -->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Districts <small></small>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <?php
                        include("health_functions.php");
                                $obj = new health_functions();

                          if(! $obj->connect()){
                              echo"Cannot connect to database";
                             exit();

                        }
                            if(isset($_REQUEST['search'])){
                                $search = $_REQUEST['search'];
                            $result=$obj->search_district($search);

                            
                            //$row=$obj->fetch();

                            if ($result == null) {
                                echo "<br><center><h4>No Registered Districts were found with name... 
                            <b>" . $search . "</b></h4></center><br><br><br>";
                            }

                            else {
                                
                                echo "<table class='table table-striped'>";
                                echo "<thead><tr>";
                                    echo "<th>DISTRICT</th>";
                                    echo "<th>REGION</th>";
                                    echo "<th>UPDATE_INFO</th>";
                                echo "</tr></thead>";
                                echo "<tbody>";

                            while($result){
                                echo "<tr>";
                                echo "<td>$result[district_name]</td>";
                                echo "<td>$result[region_name]</td>";
                                echo "<td><a href='update_district.php?id=$result[district_id]'>Click To Update</a></td>";
                                echo "</tr>";

                            $result=$obj->fetch();
                            }
                            echo "</tbody>
                                </table>";
                        }

                    }
                        ?>
                    </div>
                    <div class="col-lg-3">
                        
                    </div>
                    <!-- <div class="col-lg-4">
                    </div> -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div style="min-height: 50px">
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
