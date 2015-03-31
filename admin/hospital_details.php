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
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
            <?php
                    $id = null;
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $row = get_hospital_by_id($id);
                    }
                    

                ?>

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $row['h_name'] ?> <small>Details</small>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <h4><a href="manage_hospitals.php">Return To List</a></h4>
                    </div>
                    <div class="col-lg-6">
                        <br><br>
                        <?php
                            echo "<h4>Hospital Name: " . $row['h_name'];
                            echo "<br>";
                            echo "<br>";
                            echo "Location: " . $row['h_location'];
                            echo "<br>";
                            echo "<br>";
                            echo "Region: " . $row['region_name'];
                            echo "<br>";
                            echo "<br>";
                            echo "District: " . $row['district_name'];
                            echo "<br>";
                            echo "<br>";
                            echo "Sub-District: " . $row['sub_district_name'];
                            echo "<br>";
                            echo "<br>";
                            echo "Address: " . $row['h_address'];
                            echo "<br>";
                            echo "<br>";
                            echo "Hot-Line: " . $row['h_contact'];
                            echo "<br>";
                            echo "<br>";
                            echo "Email: " . $row['h_email'];
                            echo "<br><br></h4>";
                        ?>
                    </div>
                    <div class="col-lg-4">
                            <?php 
                            echo "<h4><a href='hospital_update.php?id=" . $id . "'>";
                            echo "Update Hospital Details";
                            echo "</a></h4>";
                            ?>
                    </div>
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
