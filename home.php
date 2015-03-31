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
                <div class="well well-lg">Home Page
            </div>

            </div>

            <div class="col-md-3"></div>
        </div>

        <div class="row">
            <div class="col-mod-3"></div>
            <div class="col-mod-6">
                <div class="jumbotron">
                  <!-- <h1>Hello, world!</h1> -->
                  <p>Welcome</p>
                  <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p> -->
                      <div class="row">
                          <div class="col-xs-6 col-md-3">
                            <a href="patient_register.php" class="thumbnail">
                              <!-- <img src="..." alt="..."> -->
                              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                              <p>Register New Patient</p>
                            </a>
                          </div>
                          <div class="col-xs-6 col-md-3">
                            <a href="patient_list.php" class="thumbnail">
                              <!-- <img src="..." alt="..."> -->
                              <span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span>
                              <p>View Patients</p>
                            </a>
                          </div>
                          <div class="col-xs-6 col-md-3">
                            <a href="#" class="thumbnail">
                              <!-- <img src="..." alt="..."> -->
                              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                              <p>Capture Patient Details</p>
                            </a>
                          </div>
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