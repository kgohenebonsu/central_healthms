<?php
include_once 'health_action.php';
    session_start();
    ob_start();
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

    <title>Central~HealthMS | Dashboard</title>

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
        <?php
                    $id = null;
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $row = get_health_official_by_id($id);
                    }
                    

                ?>

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
                <a class="navbar-brand" href="dashboard.php"><font size="5" color="#cdbfe3">Central~HealthMS</font></a>

                <a class="navbar-brand" href="dashboard.php"><font size="5" color="gold">
                    <?php 
                                echo $_SESSION['h_name'];
                ?></font></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div style="color:white;"><i class="fa fa-user"></i> Welcome, 
                            <?php 
                                echo $_SESSION['o_fname'] . " " . $_SESSION['o_lname'];
                            ?> 
                            <b class="caret"></b></div></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="health_official_details.php?id=<?php echo $_SESSION['o_id']?> "><i class="fa fa-fw fa-user"></i> User Profile</a>
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
                    <li style="background-color: #663399;">
                        <a href="dashboard.php"><div style="color:white;">
                            <i class="fa fa-fw fa-dashboard"></i> Dashboard</div></a>
                    </li>
                    <li>
                        <a href="register_patient.php"><div style="color:white;"><i class="fa fa-fw fa-edit">
                        </i> Register New Patient</div></a>
                    </li>
                    <li>
                        <a href="manage_patients.php"><div style="color:white;"><i class="fa fa-fw fa-wrench">
                        </i> Manage Patient Details</div></a>
                    </li>
                    <li style="background-color: white;">
                        <a href="admin/"><div style="color:black;"><i class="fa fa-fw fa-desktop">
                        </i> Administrator Login</div></a>
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
                            Dashboard <small>Health Statistics</small>
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        
                        <?php
                            see_all_hospital_cases($_SESSION['h_id']);
                        ?>
                    </div>
                    <div class="col-lg-6">
                        <br><br>
                        <form action='dashboard.php' method='POST' class='form-horizontal'>
                            <div class='input-group'>
                              <span class='input-group-addon' id='basic-addon1'>FROM</span>
                              <input type='date' class='form-control' name='from' id='from' placeholder='' aria-describedby='basic-addon1'>
                            </div><br>
                            <div class='input-group'>
                              <span class='input-group-addon' id='basic-addon1'>TO</span>
                              <input type='date' class='form-control' name='to' id='to' placeholder='' aria-describedby='basic-addon1'>
                            </div><br>
                            <div class="checkbox">
                                <label>
                                  <input name="export" id="export" type="checkbox"> Export to Excel Sheet
                                </label>
                              </div><br>
                            <input type='hidden' class='form-control' name='id' id='id' 
                              value="<?php echo $_SESSION['h_id']; ?>" aria-describedby='basic-addon1'>
                            <button type='submit' name='submit' class='btn btn-info'>Generate Statistics</button>
                        </form>
                        <?php
                            include("health_functions.php");
                                $obj = new health_functions();

                          if(! $obj->connect()){
                              echo"Cannot connect to database";
                             exit();

                        }
                            if(isset($_REQUEST['id'])){
                                $id  = $_REQUEST["id"];
                                $from  = $_REQUEST["from"];
                                $to  = $_REQUEST["to"];
                            $result=$obj->see_some_hospital_cases($id,$from,$to);

                            
                            //$row=$obj->fetch();

                            if ($from == "" || $to == "") {
                                echo "<br><br>";
                                echo "<center>Enter Valid Dates To View Statistics</center>";
                            }

                            else if ($result == null) {
                                echo "<br><br>";
                                echo "<center><h5>No Health Cases Were Recorded Between <b>" . $from . "</b> and <b>" . $to . "</b> </h5></center>";
                            }

                            else {

                                if (isset($_POST['export'])) {
                                    //Export
                                        header("Location: export.php?id=$id&from=$from&to=$to");

                                    }

                                    else {

                                echo "<br><br>";
                                echo "<center><h5>Health Cases That Were Recorded Between <b>" . $from . "</b> and <b>" . $to . "</b> </h5></center>";
                                
                                echo "<br><table class='table table-striped'>";
                                    echo "<thead><tr>";
                                        echo "<th>DISEASE</th>";
                                        echo "<th>NUMBER OF CASES</th>";
                                    echo "</tr></thead>";
                                    echo "<tbody>";

                            while($result){
                                echo "<tr>";
                                echo "<td>$result[d_name]</td>";
                                echo "<td>$result[num_cases]</td>";
                                echo "</tr>";

                            $result=$obj->fetch();
                            }
                            echo "</tbody>
                                </table>";
                                }
                            }
                        }

                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div style="min-height: 100px">
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
