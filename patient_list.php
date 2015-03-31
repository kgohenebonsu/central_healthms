<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Health Management System</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/healthms.css" rel="stylesheet">

        <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Custom Fonts -->
    <!-- <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'> -->

</head>

<body>
    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">healthMS</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <!-- <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
      </ul> -->
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php">LogOut</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    <div class="container">
        <div class="row"></div>
        <div class="theLoginWidth">
        <div class="row">
            <div class="col-md-3"></div>


            <div class="col-md-6">
                <!-- <div class="well well-lg">Home Page
            </div> -->

            </div>

            <div class="col-md-3"></div>
        </div>

        <div class="row">
            <div class="col-mod-3"></div>
            <div class="col-mod-6">
                <div class="jumbotron">
                  <!-- <h1>Hello, world!</h1> -->
                  <p>List of Registered Patients</p>
                  <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p> -->
                      <div class="row">
                        <table class="table table-striped">
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Birth Date</th>

                          

<?php

                          include("health_functions.php");
                    $obj = new health_functions();

              if(! $obj->connect()){
                  echo"Error! Sorry we are unable to get any information for you";
                 exit();

            }
                 if($obj->get_local_patients()){
                 $result=$obj->get_local_patients();

                 $row=$obj->fetch();
                 if ($row==null){
                  echo "<font size='6' color='red'>No Patient found</font>";
                                }
                            $id=$row['local_p_id'];
                            while ($row) {
                                            echo" <a href='#'>";
                                            echo'';
                            echo"<tr><td>$row[patient_system_id]</td>";
                            echo"<td>$row[lname], $row[fname]</td>";
                            echo"<td>$row[gender]</td>";
                            echo "<td>";
                            echo"$row[date_of_birth]</td>";
                            echo "";
                            echo"</tr></a></table>";

                            $row=$obj->fetch();
                             }
                           }
?>
                        </div>
                </div>
            </div>
            <div class="col-mod-3"></div>
        </div>

        <!-- <div class="row">
            <div class="col-mod-3"></div>
            <div class="col-mod-6">
                
            </div>
            <div class="col-mod-3"></div>
        </div> -->

        </div>
    </div>
    

</body>
</html>