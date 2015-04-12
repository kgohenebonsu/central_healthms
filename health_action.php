<?php
 	// session_start();

	include_once 'adb.php';

	if(isset($_REQUEST["register_patient"])){
		register_patient();
	}
	else if (isset($_REQUEST["login"])) {
		login();
	}
	else if (isset($_REQUEST["display_gender"])) {
		display_gender();
	}
	else if (isset($_REQUEST["display_nationality"])) {
		display_nationality();
	}
	else if (isset($_REQUEST["display_regions"])) {
		display_regions();
	}
	else if (isset($_REQUEST["display_districts"])) {
		display_districts();
	}
	else if (isset($_REQUEST["display_sub_districts"])) {
		display_sub_districts();
	}
	else if (isset($_REQUEST["see_all_patients"])) {
		see_all_patients();
	}
	else if (isset($_REQUEST["get_health_official_by_id"])) {
		get_health_official_by_id();
	}
	else if (isset($_REQUEST["edit_health_official"])) {
		edit_health_official();
	}
	else if (isset($_REQUEST["display_hospitals"])) {
		display_hospitals();
	}
	else if (isset($_REQUEST["get_patient_by_id"])) {
		get_patient_by_id();
	}
	else if (isset($_REQUEST["edit_patient"])) {
		edit_patient();
	}
	else if (isset($_REQUEST["see_patient_visit_by_id"])) {
		see_patient_visit_by_id();
	}
	else if (isset($_REQUEST["add_patient_visit"])) {
		add_patient_visit();
	}
	else if (isset($_REQUEST["display_con_room"])) {
		display_con_room();
	}
	else if (isset($_REQUEST["display_temp"])) {
		display_temp();
	}
	else if (isset($_REQUEST["display_weight"])) {
		display_weight();
	}
	else if (isset($_REQUEST["display_height"])) {
		display_height();
	}
	else if (isset($_REQUEST["display_diseases"])) {
		display_diseases();
	}
	else if (isset($_REQUEST["display_payments"])) {
		display_payments();
	}
	else if (isset($_REQUEST["get_visit_by_id"])) {
		get_visit_by_id();
	}
	else if (isset($_REQUEST["edit_patient_visit"])) {
		edit_patient_visit();
	}
	else if (isset($_REQUEST["admit_patient"])) {
		admit_patient();
	}
	else if (isset($_REQUEST["patient_admit_by_id"])) {
		patient_admit_by_id();
	}
	else if (isset($_REQUEST["display_ward"])) {
		display_ward();
	}
	else if (isset($_REQUEST["enter_patient_admit"])) {
		enter_patient_admit();
	}
	else if (isset($_REQUEST["discharge_patient"])) {
		discharge_patient();
	}
	else if (isset($_REQUEST["discharge_info_by_id"])) {
		discharge_info_by_id();
	}
	else if (isset($_REQUEST["see_all_hospital_cases"])) {
		see_all_hospital_cases();
	}
	else if (isset($_REQUEST["see_some_hospital_cases"])) {
		see_some_hospital_cases();
	}
	
	
	

	function login(){
		$username = $_REQUEST["username"];
		$password = $_REQUEST["password"];

		$db = new adb();
		$db -> connect();


		$query = "select o_id, o_username, o_fname, o_lname, o_password, hms_hospitals.h_name, hms_hospitals.h_id  from hms_officials, hms_hospitals
				where hms_officials.o_health_center=hms_hospitals.h_id and o_username='$username' and o_password=MD5('$password')";

		$result = mysql_query($query) or die(mysql_error());
		$num_rows = mysql_num_rows($result);
		$info = mysql_fetch_assoc($result);

		//echo "Got result";
		if($result){
			if($num_rows > 0){
				//echo "session_stuuf";
				session_start();
				$_SESSION['login'] = "1";
				$_SESSION['o_id'] = $info["o_id"];
				$_SESSION['o_fname'] = $info["o_fname"];
				$_SESSION['o_lname'] = $info["o_lname"];
				$_SESSION['o_username'] = $info["o_username"];
				$_SESSION['o_email'] = $info["o_email"];
				$_SESSION['h_name'] = $info["h_name"];
				$_SESSION['h_id'] = $info["h_id"];

				header("Location: dashboard.php");
			}
			else{
				?>
				<script>
					alert("username or password is incorrect");
			      window.history.back();
				</script>
				<?php
				// $msg="username or password is incorrect";

			}
		}

	}

	function see_all_hospital_cases($id){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT hms_diseases.d_name, hms_hospitals.h_name, count(hms_diseases.d_name) as 'num_cases' 
								FROM hms_patient_visits
								INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_visits.hospital_id)
								INNER JOIN hms_diseases ON (hms_diseases.d_id=hms_patient_visits.disease)
								WHERE date_of_input=CURDATE() AND hms_patient_visits.hospital_id= '$id'
								GROUP BY hms_diseases.d_name AND hms_hospitals.h_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>DISEASE</th>";
                echo "<th>NUMBER OF CASES</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['d_name'] . "</td>";
			echo "<td>" . $row['num_cases'] . "</td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "<center><h4>No Health Cases Have Been Recorded At This Health Center Today!</h4></center>";
    	}

	}

	function see_some_hospital_cases(){
		if (isset($_POST['submit'])) {
		$id  = $_REQUEST["id"];
		$from  = $_REQUEST["from"];
		$to  = $_REQUEST["to"];

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT hms_diseases.d_name, hms_hospitals.h_name, hms_patient_visits.date_of_input, count(hms_diseases.d_name) as 'num_cases' 
								FROM hms_patient_visits
								INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_visits.hospital_id)
								INNER JOIN hms_diseases ON (hms_diseases.d_id=hms_patient_visits.disease)
								WHERE hms_patient_visits.date_of_input >= '$from' AND hms_patient_visits.date_of_input <= '$to'
								AND hms_patient_visits.hospital_id= '$id'
								GROUP BY hms_diseases.d_name AND hms_hospitals.h_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>DISEASE</th>";
                echo "<th>NUMBER OF CASES</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['d_name'] . "</td>";
			echo "<td>" . $row['num_cases'] . "</td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

			else{
        	echo "<center><h4>No Health Cases Were Recorded Between <b>" . $from . "</b> and <b>" . $to . "</b> </h4></center>";
    		}
    	}
	}

	//Function to register new patient
	function register_patient(){
		$fname  = $_REQUEST["fname"];
		$lname  = $_REQUEST["lname"];
		$gender  = $_REQUEST["gender"];
		$birthDate  = $_REQUEST["birthDate"];
		$address  = $_REQUEST["address"];
		$nationality  = $_REQUEST["nationality"];
		$region  = $_REQUEST["region_ref"];
		$district  = $_REQUEST["district_ref"];
		$sub_district  = $_REQUEST["sub_district_ref"];
		$contact  = $_REQUEST["contact"];
		$email  = $_REQUEST["email"];

		$pin = mt_rand(100000,999999);
		$thefname = strtolower($fname);
		$onefname = $thefname[0];
		$thelname = strtolower($lname);
		$patient_system_id = $onefname."".$thelname."".$pin;

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "INSERT INTO hms_local_patient_registration (fname, lname, gender, date_of_birth, address, nationality, region, district, sub_district, contact, email, patient_system_id, date_of_registration, last_date_updated) 
		VALUES('$fname','$lname','$gender', '$birthDate', '$address', '$nationality', '$region', '$district', '$sub_district', '$contact', '$email', '$patient_system_id', CURDATE(), CURDATE())";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Patient Registered!");
					window.location.href="register_patient.php";
				</script>
				<?php
		}
		else {
			?>
				<script>
					alert("ERROR: Make sure all fields are filled!");
					window.history.back();
				</script>
				<?php
		}
	}

	function see_all_patients(){

		$db = new adb();
		$db -> connect();

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT * FROM hms_local_patient_registration ORDER BY lname LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>PIN</th>";
                echo "<th>FULL NAME</th>";
                echo "<th>DATE OF BIRTH</th>";
                echo "<th>VIEW_DETAILS</th>";
                echo "<th>MEDICAL VISIT</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['patient_system_id'] . "</td>";
			echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
			echo "<td>" . $row['date_of_birth'] . "</td>";
			echo "<td><a href='patient_details.php?id=$row[local_p_id]'>Details</a></td>";
			echo "<td><a href='patient_visits.php?id=$row[local_p_id]'>Visit_Info</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "No Registered Patients were found.";
    	}

    	$sql = "SELECT * FROM hms_local_patient_registration"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='manage_patients.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='manage_patients.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='manage_patients.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

	}

	// Function to display list of patient hospital visits
	function see_patient_visits_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT pv_id, hms_local_patient_registration.fname, hms_local_patient_registration.lname, hms_hospitals.h_name, hms_consulting_rooms.room_name, temperature, blood_pressure,
								weight, height, symptoms, lab_tests, test_results, diagnosis, hms_diseases.d_name, prescription, hms_payment_mode.pm_name, amount_paid,
								date_of_input, last_update
								FROM hms_patient_visits 
								INNER JOIN hms_local_patient_registration ON (hms_local_patient_registration.local_p_id=hms_patient_visits.patient_id)
								INNER JOIN hms_consulting_rooms ON (hms_consulting_rooms.room_id=hms_patient_visits.consulting_room)
								INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_visits.hospital_id)
								INNER JOIN hms_diseases ON (hms_diseases.d_id=hms_patient_visits.disease)
								INNER JOIN hms_payment_mode ON (hms_payment_mode.pm_id=hms_patient_visits.mode_of_payment)
								WHERE hms_patient_visits.patient_id='$id' ORDER BY last_update DESC");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>HOSPITAL</th>";
                echo "<th>FULL NAME</th>";
                echo "<th>DATE OF VISIT</th>";
                echo "<th>VIEW_DETAILS</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['h_name'] . "</td>";
			echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
			echo "<td>" . $row['date_of_input'] . "</td>";
			echo "<td><a href='patient_unit_visit_detail.php?id=$row[pv_id]'>Details</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "No Registered Patient Visits were found.";
    	}
	}

	function add_patient_visit(){
		$id  = $_REQUEST["id"];
		$h_id  = $_REQUEST["h_id"];
		$room_ref  = $_REQUEST["room_ref"];
		$temp  = $_REQUEST["temp"];
		$temperature  = $_REQUEST["temperature"];
		$theTemp = $temperature. " " . $temp;
		$blood_pressure  = $_REQUEST["blood_pressure"];
		$weight_value  = $_REQUEST["weight_value"];
		$weight  = $_REQUEST["weight"];
		$theWeight = $weight_value. " " . $weight;
		$height_value  = $_REQUEST["height_value"];
		$height  = $_REQUEST["height"];
		$theHeight = $height_value. " " . $height;
		$symptoms  = $_REQUEST["symptoms"];
		$lab_tests  = $_REQUEST["lab_tests"];
		$test_results  = $_REQUEST["test_results"];
		$diagnosis  = $_REQUEST["diagnosis"];
		$disease  = $_REQUEST["disease"];
		$prescription  = $_REQUEST["prescription"];
		$payment  = $_REQUEST["payment"];
		$amount_paid  = $_REQUEST["amount_paid"];

		$db = new adb();
		$db -> connect();
		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "INSERT INTO hms_patient_visits (patient_id, hospital_id, consulting_room, temperature, blood_pressure, weight, height, symptoms, lab_tests, test_results, diagnosis, disease, prescription, mode_of_payment, amount_paid, date_of_input, last_update) 
		VALUES('$id','$h_id','$room_ref', '$theTemp', '$blood_pressure', '$theWeight', '$theHeight', '$symptoms', '$lab_tests', '$test_results', '$diagnosis', '$disease', '$prescription', '$payment', '$amount_paid', CURDATE(), CURDATE())";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Patient Visit Registered!");
					window.location.href="manage_patients.php";
				</script>
				<?php
		} else {
			?>
				<script>
					alert("ERROR: Make sure all fields are filled!");
					window.history.back();
				</script>
				<?php
		}
	}

	function edit_patient_visit(){
		$id  = $_REQUEST["id"];
		$room_ref  = $_REQUEST["room_ref"];
		$temp  = $_REQUEST["temp"];
		$temperature  = $_REQUEST["temperature"];
		$theTemp = $temperature. " " . $temp;
		$blood_pressure  = $_REQUEST["blood_pressure"];

		$weight_value  = $_REQUEST["weight_value"];
		$weight  = $_REQUEST["weight"];
		$theWeight = $weight_value. " " . $weight;

		$height_value  = $_REQUEST["height_value"];
		$height  = $_REQUEST["height"];
		$theHeight = $height_value. " " . $height;

		$symptoms  = $_REQUEST["symptoms"];
		$lab_tests  = $_REQUEST["lab_tests"];
		$test_results  = $_REQUEST["test_results"];
		$diagnosis  = $_REQUEST["diagnosis"];
		$disease  = $_REQUEST["disease"];
		$prescription  = $_REQUEST["prescription"];
		$payment  = $_REQUEST["payment"];
		$amount_paid  = $_REQUEST["amount_paid"];

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "UPDATE hms_patient_visits SET consulting_room='$room_ref', temperature='$theTemp', blood_pressure='$blood_pressure', 
				weight='$theWeight', height='$theHeight', symptoms='$symptoms', lab_tests='$lab_tests', test_results='$test_results', 
				diagnosis='$diagnosis', disease='$disease', prescription='$prescription', mode_of_payment='$payment', 
				amount_paid='$amount_paid', last_update=CURDATE()
		WHERE hms_patient_visits.pv_id = '$id'";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Patient Visit Updated!");
					window.location.href="manage_patients.php";
				</script>
				<?php
		}
		else {
			?>
				<script>
					alert("ERROR: Make sure all fields are filled!");
					window.history.back();
				</script>
				<?php
		}
	}

	function get_visit_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT pv_id, patient_id, hospital_id, hms_local_patient_registration.fname, hms_local_patient_registration.lname, hms_hospitals.h_name, hms_consulting_rooms.room_name, temperature, blood_pressure,
								weight, height, symptoms, lab_tests, test_results, diagnosis, hms_diseases.d_name, prescription, hms_payment_mode.pm_name, amount_paid,
								date_of_input, last_update
								FROM hms_patient_visits 
								INNER JOIN hms_local_patient_registration ON (hms_local_patient_registration.local_p_id=hms_patient_visits.patient_id)
								INNER JOIN hms_consulting_rooms ON (hms_consulting_rooms.room_id=hms_patient_visits.consulting_room)
								INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_visits.hospital_id)
								INNER JOIN hms_diseases ON (hms_diseases.d_id=hms_patient_visits.disease)
								INNER JOIN hms_payment_mode ON (hms_payment_mode.pm_id=hms_patient_visits.mode_of_payment)
								WHERE pv_id='$id'";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	//Function to display patient registration information
	function get_patient_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT local_p_id, fname, lname, hms_gender.gender, date_of_birth, address, hms_nationality_status.nationality_status, 
		hms_sub_districts.sub_district_name , hms_districts.district_name, hms_regions.region_name, contact, email, patient_system_id, last_date_updated 
		FROM hms_local_patient_registration, hms_nationality_status, hms_gender, hms_sub_districts, hms_districts, hms_regions 
		WHERE hms_local_patient_registration.nationality = hms_nationality_status.nation_id
		AND hms_local_patient_registration.sub_district = hms_sub_districts.sub_district_id 
		AND hms_local_patient_registration.district = hms_districts.district_id
		AND hms_local_patient_registration.region = hms_regions.region_id
		AND hms_local_patient_registration.gender = hms_gender.gender_id
		AND local_p_id='$id'";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function edit_patient(){
		if (isset($_POST['submit'])) {
		$id = $_REQUEST['id'];
		$fname  = $_REQUEST["fname"];
		$lname  = $_REQUEST["lname"];
		$gender  = $_REQUEST["gender"];
		$birthDate  = $_REQUEST["date_of_birth"];
		$address  = $_REQUEST["address"];
		$nationality  = $_REQUEST["nationality"];
		$region  = $_REQUEST["region_ref"];
		$district  = $_REQUEST["district_ref"];
		$sub_district  = $_REQUEST["sub_district_ref"];
		$contact  = $_REQUEST["contact"];
		$email  = $_REQUEST["email"];

		$pin = mt_rand(100000,999999);
		$thefname = strtolower($fname);
		$onefname = $thefname[0];
		$thelname = strtolower($lname);
		$o_username = $onefname."".$thelname;
		$patient_system_id = $onefname."".$thelname."".$pin;

		if ($sub_district == "" || $sub_district == 0 || $gender == "" || $gender == 0){
			?>
				<script>
					alert("ERROR: Make Sure All Fields Are Filled!");
					window.history.back();

				</script>
				<?php
		}
		else if ($district == "" || $district == 0 || $nationality == "" || $nationality == 0) {
			?>
				<script>
					alert("ERROR: Make Sure All Fields Are Filled!");
					window.history.back();

				</script>
				<?php
		}
		else if ($region == "" || $region == 0) {
			?>
				<script>
					alert("ERROR: Make Sure All Fields Are Filled!");
					window.history.back();

				</script>
				<?php
		}
		else {

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "UPDATE hms_local_patient_registration 
					SET fname='$fname', lname='$lname', gender='$gender', date_of_birth='$birthDate', address='$address', nationality='$nationality', sub_district='$sub_district', district='$district', region='$region', contact='$contact', email='$email', patient_system_id='$patient_system_id', last_date_updated=CURDATE() 
					WHERE hms_local_patient_registration.local_p_id='$id'";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());

        if ($result == 1) {
            ?>
                <script>
                    alert("Patient Updated!");
                    window.location.href="manage_patients.php";
                </script>
            <?php
        		}
    		}
    	}
	}

	function admit_patient(){
		$id  = $_REQUEST["id"];
		$hospital_id  = $_REQUEST["hospital_id"];
		$patient_id  = $_REQUEST["patient_id"];
		$ward = 1;
		$health_progress = ``;
		$prescriptions = ``;
		$amount_paid = ``;
		$date_of_discharge = `0`;

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT pa_id, hms_local_patient_registration.fname, hms_local_patient_registration.lname, hms_hospitals.h_name, patient_visit_id, hms_wards.ward_name,
										health_progress, prescriptions, hms_patient_admit.amount_paid, date_of_admit, date_of_discharge
								FROM hms_patient_admit
								INNER JOIN hms_local_patient_registration ON (hms_local_patient_registration.local_p_id=hms_patient_admit.patient_id)
								INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_admit.hospital_id)
								INNER JOIN hms_patient_visits ON (hms_patient_visits.pv_id=hms_patient_admit.patient_visit_id)
								INNER JOIN hms_wards ON (hms_wards.ward_id=hms_patient_admit.ward)
								WHERE hms_patient_admit.patient_visit_id= '$id'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		
		if(mysql_num_rows($result) > 0){
			?>
				<script>
					alert("Patient Already Admitted During This Visit!");
					window.history.back();
				</script>
				<?php
		}

		else {

		// $query1 = "SET FOREIGN_KEY_CHECKS=0";
		// mysql_query($query1);

		$query = "INSERT INTO hms_patient_admit (patient_id, hospital_id, patient_visit_id, ward, health_progress, prescriptions, amount_paid, date_of_admit, date_of_discharge) 
		VALUES('$patient_id','$hospital_id', '$id', '$ward', '$health_progress', '$prescriptions', '$amount_paid', CURDATE(), '$date_of_discharge')";
		// $query2 = "SET FOREIGN_KEY_CHECKS=1";
		// mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Patient Admited!");
					window.history.back();
				</script>
				<?php
		}
		else {
			?>
				<script>
					alert("ERROR: Patient was not admited!");
					window.history.back();
				</script>
				<?php
			}
		}
	}

	function patient_admit_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT pa_id, hms_local_patient_registration.fname, hms_local_patient_registration.lname, hms_hospitals.h_name, patient_visit_id, hms_wards.ward_name,
										health_progress, prescriptions, hms_patient_admit.amount_paid, date_of_admit, date_of_discharge
								FROM hms_patient_admit
								INNER JOIN hms_local_patient_registration ON (hms_local_patient_registration.local_p_id=hms_patient_admit.patient_id)
								INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_admit.hospital_id)
								INNER JOIN hms_patient_visits ON (hms_patient_visits.pv_id=hms_patient_admit.patient_visit_id)
								INNER JOIN hms_wards ON (hms_wards.ward_id=hms_patient_admit.ward)
								WHERE hms_patient_admit.patient_visit_id= '$id'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_num_rows($result) > 0){
        		echo "<div class='row'>
                    	<div class='col-lg-3'>
                        </div>";
                while($row = mysql_fetch_array($result)){
                	echo "<div class='col-lg-5'>";
                	echo "<br><br><b>";
                	echo $row['fname'] . " " . $row['lname'] . " Admitted on: " . $row['date_of_admit'];

                	echo "</b><form action='health_action.php?enter_patient_admit' method='POST' class='form-horizontal'>";
                	echo "<br><br>";
                	echo "Current Ward: <b>$row[ward_name]</b><br>";
                	display_ward();
                	echo "<br>
                		<div class='input-group'>
                              <span class='input-group-addon' id='basic-addon1'>Health Progress</span>
                              <textarea type='text' 
                              class='form-control' name='health_progress' id='health_progress' aria-describedby='basic-addon1'>$row[health_progress]</textarea>
                            </div><br>";
                    echo "<div class='input-group'>
                              <span class='input-group-addon' id='basic-addon1'>Prescriptions</span>
                              <textarea type='text' 
                              class='form-control' name='prescriptions' id='prescriptions' aria-describedby='basic-addon1'>$row[prescriptions]</textarea>
                            </div><br>";

                    echo "<div class='input-group'>
                              <span class='input-group-addon' id='basic-addon1'>Amount Paid (GHc)</span>
                              <input type='text' class='form-control' value='$row[amount_paid]' name='amount_paid' id='amount_paid' placeholder='' aria-describedby='basic-addon1'>
                            </div><br>";

                	echo "<input type='hidden' class='form-control' name='id' id='id' 
                             value='$id' aria-describedby='basic-addon1'>

                            <button type='submit' name='submit' class='btn btn-success'>Submit Details</button>
                        </form>";

                    echo "</div>";
                }
                
                        

                    echo "<div class='col-lg-4'>";
                       echo "<form action='health_action.php?discharge_patient' method='POST' class='form-horizontal'>";
                	echo "<br><br><input type='hidden' class='form-control' name='id' id='id' 
                            value='$id' aria-describedby='basic-addon1'>

                            <button type='submit' name='submit' class='btn btn-danger'>Discharge Patient</button>
                        <br><br>";
                    	discharge_info_by_id($id);
                        echo "</form><br><br>";
                    echo "</div>
                    </div>";
		}

		else{
			echo "<div class='row'>
                    	<div class='col-lg-3'>
                        </div>";
            echo "<div class='col-lg-5'>";
                	echo "<br><br><b>";
        	echo "Patient was not admitted during this visit";
        	echo "</b></div>";
    	}
	}

	function enter_patient_admit(){
		$id  = $_REQUEST["id"];
		$ward = $_REQUEST["ward"];
		$health_progress = $_REQUEST["health_progress"];
		$prescriptions = $_REQUEST["prescriptions"];
		$amount_paid = $_REQUEST["amount_paid"];
		$date_of_discharge = "";

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "UPDATE hms_patient_admit SET ward='$ward', health_progress='$health_progress', prescriptions='$prescriptions', 
				amount_paid='$amount_paid', date_of_discharge='$date_of_discharge'
				WHERE hms_patient_admit.patient_visit_id = '$id'";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Patient Admit Details Entered!");
					window.location.href="manage_patients.php";
				</script>
				<?php
		}
		else {
			?>
				<script>
					alert("ERROR: Make sure all fields are filled!");
					window.history.back();
				</script>
				<?php
		}
	}

	function discharge_patient(){
		$id  = $_REQUEST["id"];

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT pa_id, hms_local_patient_registration.fname, hms_local_patient_registration.lname, hms_hospitals.h_name, patient_visit_id, hms_wards.ward_name,
										health_progress, prescriptions, hms_patient_admit.amount_paid, date_of_admit, date_of_discharge
								FROM hms_patient_admit
								INNER JOIN hms_local_patient_registration ON (hms_local_patient_registration.local_p_id=hms_patient_admit.patient_id)
								INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_admit.hospital_id)
								INNER JOIN hms_patient_visits ON (hms_patient_visits.pv_id=hms_patient_admit.patient_visit_id)
								INNER JOIN hms_wards ON (hms_wards.ward_id=hms_patient_admit.ward)
								WHERE hms_patient_admit.patient_visit_id= '$id'
								AND date_of_discharge='0'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(!mysql_num_rows($result) > 0){

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "UPDATE hms_patient_admit SET date_of_discharge = CURDATE() WHERE hms_patient_admit.patient_visit_id = '$id'";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Patient Is Discharged!");
					window.location.href="manage_patients.php";
				</script>
				<?php
		}
		else {
			?>
				<script>
					alert("ERROR: Patient Discharge Unsuccessful!");
					window.history.back();
				</script>
				<?php
			}
		}

		else {
			?>
				<script>
					alert("Patient Already Discharged!");
					window.history.back();
				</script>
				<?php
		}
	}

	function discharge_info_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT pa_id, hms_local_patient_registration.fname, hms_local_patient_registration.lname, hms_hospitals.h_name, patient_visit_id, hms_wards.ward_name,
										health_progress, prescriptions, hms_patient_admit.amount_paid, date_of_admit, date_of_discharge
								FROM hms_patient_admit
								INNER JOIN hms_local_patient_registration ON (hms_local_patient_registration.local_p_id=hms_patient_admit.patient_id)
								INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_admit.hospital_id)
								INNER JOIN hms_patient_visits ON (hms_patient_visits.pv_id=hms_patient_admit.patient_visit_id)
								INNER JOIN hms_wards ON (hms_wards.ward_id=hms_patient_admit.ward)
								WHERE hms_patient_admit.patient_visit_id= '$id'
								AND date_of_discharge=0");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_fetch_assoc($result)){
			echo "<br><br><b>";
        	echo "Patient is still admitted!";
        	echo "</b>";
			

		}

		else{
			$result = mysql_query("SELECT pa_id, hms_local_patient_registration.fname, hms_local_patient_registration.lname, hms_hospitals.h_name, patient_visit_id, hms_wards.ward_name,
										health_progress, prescriptions, hms_patient_admit.amount_paid, date_of_admit, date_of_discharge
								FROM hms_patient_admit
								INNER JOIN hms_local_patient_registration ON (hms_local_patient_registration.local_p_id=hms_patient_admit.patient_id)
								INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_admit.hospital_id)
								INNER JOIN hms_patient_visits ON (hms_patient_visits.pv_id=hms_patient_admit.patient_visit_id)
								INNER JOIN hms_wards ON (hms_wards.ward_id=hms_patient_admit.ward)
								WHERE hms_patient_admit.patient_visit_id= '$id'
								AND date_of_discharge!=0");
            $row = mysql_fetch_array($result);
		    while($row){
		    	
                	echo "<b>";
                	echo $row['fname'] . " " . $row['lname'] . " was Discharged on: " . $row['date_of_discharge'];

                    echo "</b>";
                    $row = mysql_fetch_array($result);
                }
    	}
	}

	function display_nationality(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT * FROM hms_nationality_status");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='nationality' id='nationality' class='form-control'>";
		echo "<option>Nationality</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[nation_id]>$row[nationality_status]</option>";
		}
		echo "</select>";
	}

	function display_regions(){
		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT region_id, region_name FROM hms_regions ORDER BY region_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='region_ref' id='region_ref' class='form-control'>";
		echo "<option>Region</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[region_id]>$row[region_name]</option>";
		}
		echo "</select>";
	}

	function display_districts(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT district_id, district_name FROM hms_districts ORDER BY district_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='district_ref' id='district_ref' class='form-control'>";
		echo "<option>District</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[district_id]>$row[district_name]</option>";
		}
		echo "</select>";
	}

	function display_sub_districts(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT sub_district_id, sub_district_name FROM hms_sub_districts ORDER BY sub_district_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='sub_district_ref' id='sub_district_ref' class='form-control'>";
		echo "<option>Sub-District</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[sub_district_id]>$row[sub_district_name]</option>";
		}
		echo "</select>";
	}

	function display_gender(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT * FROM hms_gender");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='gender' id='gender' class='form-control'>";
		echo "<option>Gender</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[gender_id]>$row[gender]</option>";
		}
		echo "</select>";
	}

	function get_health_official_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT o_fname, o_lname, o_username, o_password, o_position, o_contact,  o_email, o_system_id, last_date_updated, hms_hospitals.h_name 
		FROM hms_officials, hms_hospitals WHERE hms_officials.o_health_center = hms_hospitals.h_id and o_id='$id'";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function edit_health_official(){
		if (isset($_POST['submit'])) {
		$id = $_REQUEST['id'];
		$o_fname  = $_REQUEST["o_fname"];
		$o_lname  = $_REQUEST["o_lname"];
		$o_password1  = $_REQUEST["o_password1"];
		$o_password2  = $_REQUEST["o_password2"];
		$o_contact  = $_REQUEST["o_contact"];
		$o_email  = $_REQUEST["o_email"];

		$pin = mt_rand(1000,9999);
		$thefname = strtolower($o_fname);
		$onefname = $thefname[0];
		$thelname = strtolower($o_lname);
		$o_username = $onefname."".$thelname;
		$o_system_id = $onefname."".$thelname."".$pin;

		if ($o_password1 != $o_password2){
			?>
				<script>
					alert("ERROR: Passwords Do Not Match!");
					window.location.href="dashboard.php";

				</script>
				<?php
		}
		else if ($o_password1 == "") {
			?>
				<script>
					alert("ERROR: Be Sure To Enter Your Password!");
					window.history.back();

				</script>
				<?php
		}
		else {

		$db = new adb();
		$db -> connect();

		$thepassword = $o_password2;

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "UPDATE hms_officials SET o_fname='$o_fname', o_lname='$o_lname', o_username='$o_username', o_password=MD5('$thepassword'), o_contact='$o_contact', o_email='$o_email', o_system_id='$o_system_id', last_date_updated=CURDATE() WHERE hms_officials.o_id='$id'";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());

        if ($result == 1) {
            ?>
                <script>
                    alert("Health Official Updated!");
                    window.location.href="dashboard.php";
                </script>
            <?php
        	}
    	}
    }
	}

	function display_hospitals(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT h_id, h_name FROM hms_hospitals ORDER BY h_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='o_health_center' id='o_health_center' class='form-control'>";
		echo "<option>Hospital</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[h_id]>$row[h_name]</option>";
		}
		echo "</select>";
	}

	function display_con_room(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT room_id, room_name FROM hms_consulting_rooms ORDER BY room_id");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='room_ref' id='room_ref' class='form-control'>";
		echo "<option>Consulting Room</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[room_id]>$row[room_name]</option>";
		}
		echo "</select>";
	}

	function display_temp(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT temp_id, temp_unit FROM hms_temp_units ORDER BY temp_id");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='temp' id='temp' class='form-control'>";
		echo "<option>Unit</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[temp_unit]>$row[temp_unit]</option>";
		}
		echo "</select>";
	}
	
	function display_weight(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT w_id, weight_unit FROM hms_weight_units ORDER BY w_id");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='weight' id='weight' class='form-control'>";
		echo "<option>Unit</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[weight_unit]>$row[weight_unit]</option>";
		}
		echo "</select>";
	}

	function display_height(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT height_id, height_unit FROM hms_height_units ORDER BY height_id");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='height' id='height' class='form-control'>";
		echo "<option>Unit</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[height_unit]>$row[height_unit]</option>";
		}
		echo "</select>";
	}

	function display_diseases(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT d_id, d_name FROM hms_diseases ORDER BY d_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='disease' id='disease' class='form-control'>";
		echo "<option>Disease</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[d_id]>$row[d_name]</option>";
		}
		echo "</select>";
	}

	function display_payments(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT pm_id, pm_name FROM hms_payment_mode ORDER BY pm_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='payment' id='payment' class='form-control'>";
		echo "<option>Mode Of Payment</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[pm_id]>$row[pm_name]</option>";
		}
		echo "</select>";
	}

	function display_ward(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT ward_id, ward_name FROM hms_wards ORDER BY ward_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='ward' id='ward' class='form-control'>";
		echo "<option>Ward</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[ward_id]>$row[ward_name]</option>";
		}
		echo "</select>";
	}
	
	
?>