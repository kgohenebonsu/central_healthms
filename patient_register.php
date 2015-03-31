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
        <div class="theRegisterWidth">

        <div class="row">
            <div class="col-mod-3"></div>
            <div class="col-mod-6">
                <div class="jumbotron">

                  <?php
        include("health_functions.php");
        $obj = new health_functions();


  if(! $obj->connect()){
      echo"Cannot connect to database";
     exit();
  }         if(isset($_REQUEST['lname'])){
         $lname = $_REQUEST['lname'];
         $fname = $_REQUEST['fname'];
          $gender = $_REQUEST['gender'];
          $date_of_birth =$_REQUEST['date_of_birth'];
          $address= $_REQUEST['address'];
            $email = $_REQUEST['email'];
          // $productImage= $_GET['productImage'];
     $region = $_REQUEST['region'];
      $district = $_REQUEST['district'];
      $sub_district = $_REQUEST['sub_district'];
       $contact = $_REQUEST['contact'];
     
       // $email = 'examlmd@fs';

        if(isset($_REQUEST['submit'])){

    $obj->add_local_patient($fname,$lname,$gender,$date_of_birth,$address,
                $region,$district,$sub_district,$contact,$email);
      //  $query="insert into seller set seller_name='$sellerName',seller_location='$sellerLocation',seller_email='$sellerEmail', seller_phone='$sellerPhone',product_name='$productName',
      //  product_details='$productDetails',product_image='$productImage',price='$productPrice',product_category='$productCategory',price-Type=' $priceType'";
      // echo $query";
    }
    echo mysql_error();
  }

              echo "<p>Fill the details below to Register the Patient</p>
                  <form action='patient_register.php' method='GET' class='form-horizontal'>";
                  
                  echo  "<div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>First Name</span>
                      <input type='text' class='form-control' name='fname' id='fname' placeholder='first name' aria-describedby='basic-addon1'>
                    </div><br>
                    <div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>Last Name</span>
                      <input type='text' class='form-control' name='lname' id='lname' placeholder='last name' aria-describedby='basic-addon1'>
                    </div><br>
                    <div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>Gender</span>
                      <input type='text' class='form-control' name='gender' id='gender' placeholder='' aria-describedby='basic-addon1'>
                    </div><br>
                    <div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>Date of Birth</span>
                      <input type='date' class='form-control' name='date_of_birth' id='date_of_birth' placeholder='' aria-describedby='basic-addon1'>
                    </div><br>
                    <div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>Address</span>
                      <textarea type='text' class='form-control' name='address' id='address' aria-describedby='basic-addon1'></textarea>
                    </div><br>
                    <div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>Region</span>
                      <input type='text' class='form-control' name='region' id='region' placeholder='' aria-describedby='basic-addon1'>
                    </div><br>
                    <div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>District</span>
                      <input type='text' class='form-control' name='district' id='district' placeholder='' aria-describedby='basic-addon1'>
                    </div><br>
                    <div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>Subdistrict</span>
                      <input type='text' class='form-control' name='sub_district' id='sub_district' placeholder='' aria-describedby='basic-addon1'>
                    </div><br>
                    <div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>Contact</span>
                      <input type='text' class='form-control' name='contact' id='contact' placeholder='' aria-describedby='basic-addon1'>
                    </div><br>
                    <div class='input-group'>
                      <span class='input-group-addon' id='basic-addon1'>Email</span>
                      <input type='text' class='form-control' name='email' id='email' placeholder='example@gmail.com' aria-describedby='basic-addon1'/>
                    </div><br>


                    <button type='submit' name='submit' class='btn btn-default'>Save Details</button>
                  </form>";

?>
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