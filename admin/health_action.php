<?php
 	// session_start();

	include_once 'adb.php';

	if(isset($_REQUEST["adminLogin"])){
		admin_login();
	}
	else if (isset($_REQUEST["login"])) {
		login();
	}
	else if (isset($_REQUEST["add_district"])) {
		add_district();
	}
	else if (isset($_REQUEST["display_regions"])) {
		display_regions();
	}
	else if (isset($_REQUEST["display_districts"])) {
		display_districts();
	}
	else if (isset($_REQUEST["add_sub_district"])) {
		add_sub_district();
	}
	else if (isset($_REQUEST["register_official"])) {
		register_official();
	}
	else if (isset($_REQUEST["register_hospital"])) {
		register_hospital();
	}
	else if (isset($_REQUEST["display_hospitals"])) {
		display_hospitals();
	}
	else if (isset($_REQUEST["display_sub_districts"])) {
		display_sub_districts();
	}
	else if (isset($_REQUEST["see_all_districts"])) {
		see_all_districts();
	}
	else if (isset($_REQUEST["see_all_sub_districts"])) {
		see_all_sub_districts();
	}
	else if (isset($_REQUEST["see_all_health_officials"])) {
		see_all_health_officials();
	}
	else if (isset($_REQUEST["edit_districts"])) {
		edit_districts();
	}
	else if (isset($_REQUEST["get_district_by_id"])) {
		get_district_by_id();
	}
	else if (isset($_REQUEST["edit_sub_districts"])) {
		edit_sub_districts();
	}
	else if (isset($_REQUEST["get_sub_district_by_id"])) {
		get_sub_district_by_id();
	}
	else if (isset($_REQUEST["edit_health_official"])) {
		edit_health_official();
	}
	else if (isset($_REQUEST["get_health_official_by_id"])) {
		get_health_official_by_id();
	}
	else if (isset($_REQUEST["see_all_hospitals"])) {
		see_all_hospitals();
	}
	else if (isset($_REQUEST["get_hospital_by_id"])) {
		get_hospital_by_id();
	}
	else if (isset($_REQUEST["edit_hospital"])) {
		edit_hospital();
	}
	else if (isset($_REQUEST["see_all_cases"])) {
		see_all_cases();
	}
	else if (isset($_REQUEST["display_region_names"])) {
		display_region_names();
	}
	


	function login(){
		$username = $_REQUEST["username"];
		$password = $_REQUEST["password"];

		$db = new adb();
		$db -> connect();


		$query = "select o_username,o_fullname, o_password from hms_officials where o_username='$username' and o_password=MD5('$password')";

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
				$_SESSION['o_fullname'] = $info["o_fullname"];
				$_SESSION['o_username'] = $info["o_username"];
				$_SESSION['o_email'] = $info["o_email"];

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

	function admin_login(){
		$username = $_REQUEST["username"];
		$password = $_REQUEST["password"];

		$db = new adb();
		$db -> connect();


		$query = "select a_name,a_fullname, a_password from hms_admins where a_name='$username' and a_password=MD5('$password')";

		$result = mysql_query($query) or die(mysql_error());
		$num_rows = mysql_num_rows($result);
		$info = mysql_fetch_assoc($result);

		//echo "Got result";
		if($result){
			if($num_rows > 0){
				//echo "session_stuuf";
				session_start();
				$_SESSION['login'] = "1";
				$_SESSION['a_id'] = $info["a_id"];
				$_SESSION['a_fullname'] = $info["a_fullname"];
				$_SESSION['a_name'] = $info["a_name"];
				$_SESSION['a_email'] = $info["a_email"];

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

	function see_all_cases(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT hms_diseases.d_name, count(hms_diseases.d_name) as `num_cases` FROM hms_patient_visits
								INNER JOIN hms_diseases ON (hms_diseases.d_id=hms_patient_visits.disease)
								WHERE date_of_input=CURDATE()
								GROUP BY hms_diseases.d_name");
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
        	echo "<center><h4>No Health Cases Have Been Recorded Today!</h4></center>";
    	}

	}

	function add_district(){
		$district_name  = $_REQUEST["district_name"];
		$region_ref  = $_REQUEST["region_ref"];

		if ($region_ref == "" || $region_ref == 0) {
			?>
				<script>
					alert("ERROR: Select The Region!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "INSERT INTO hms_districts (district_name, region_ref) VALUES('$district_name','$region_ref')";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("District Added!");
					window.location.href="districts.php";
				</script>
				<?php
			}
		}
	}

	function display_regions(){
		// $region_id = intval($_REQUEST["region_id"]);
		// $region_name  = $_REQUEST["region_name"];

		$db = new adb();
		$db -> connect();

		// $query = "SELECT region_id, region_name FROM regions";
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

	function display_region_names(){
		// $region_id = intval($_REQUEST["region_id"]);
		// $region_name  = $_REQUEST["region_name"];

		$db = new adb();
		$db -> connect();

		// $query = "SELECT region_id, region_name FROM regions";
		$result = mysql_query("SELECT region_id, region_name FROM hms_regions ORDER BY region_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		echo "<select name='region_ref' id='region_ref' class='form-control'>";
		echo "<option>Region</option>";
		while($row = mysql_fetch_array($result)){
			echo "<option value=$row[region_name]>$row[region_name]</option>";
		}
		echo "</select>";
	}

	function add_sub_district(){
		$sub_district_name  = $_REQUEST["sub_district_name"];
		$district_ref  = $_REQUEST["district_ref"];

		if ($district_ref == "" || $district_ref == 0) {
			?>
				<script>
					alert("ERROR: Select The District!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "INSERT INTO hms_sub_districts (sub_district_name, district_ref) VALUES('$sub_district_name','$district_ref')";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Sub_District Added!");
					window.location.href="sub_districts.php";
				</script>
				<?php
			}
		}
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

	function edit_districts(){
		$d_name = $_REQUEST['district_name'];
        $reg_ref = $_REQUEST['region_ref'];
        $id = $_REQUEST['district_id'];

        if ($reg_ref == "" || $reg_ref == 0) {
			?>
				<script>
					alert("ERROR: Select The Region!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$result = mysql_query("UPDATE hms_districts SET district_name = '$d_name', region_ref = '$reg_ref' WHERE district_id='$id'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

        if ($result == 1) {
            ?>
                <script>
                    alert("District Updated!");
                    window.location.href="districts.php";
                </script>
            <?php
        	}
        }
	}

	function get_district_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT district_id, district_name, hms_regions.region_name FROM hms_districts, hms_regions WHERE hms_districts.region_ref = hms_regions.region_id and district_id=$id";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function see_all_districts(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT district_id, district_name, hms_regions.region_name 
								FROM hms_districts, hms_regions 
								WHERE hms_districts.region_ref = hms_regions.region_id ORDER BY district_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>DISTRICT</th>";
                echo "<th>REGION</th>";
                echo "<th>UPDATE_INFO</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['district_name'] . "</td>";
			echo "<td>" . $row['region_name'] . "</td>";
			echo "<td><a href='update_district.php?id=$row[district_id]'>Click To Update</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "No Registered Districts were found.";
    	}

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

	function edit_sub_districts(){
		$sub_name = $_REQUEST['sub_district_name'];
        $dis_ref = $_REQUEST['district_ref'];
        $id = $_REQUEST['sub_district_id'];

        if ($dis_ref == "" || $dis_ref == 0) {
			?>
				<script>
					alert("ERROR: Select The District!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$result = mysql_query("UPDATE hms_sub_districts SET sub_district_name = '$sub_name', district_ref = '$dis_ref' WHERE sub_district_id='$id'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

        if ($result == 1) {
            ?>
                <script>
                    alert("Sub-District Updated!");
                    window.location.href="sub_districts.php";
                </script>
            <?php
        	}
        }
	}

	function get_sub_district_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT sub_district_id, sub_district_name, hms_districts.district_name FROM hms_sub_districts, hms_districts WHERE hms_sub_districts.district_ref = hms_districts.district_id and sub_district_id=$id";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function see_all_sub_districts(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT sub_district_id, sub_district_name, hms_districts.district_name 
								FROM hms_sub_districts, hms_districts 
								WHERE hms_sub_districts.district_ref = hms_districts.district_id ORDER BY sub_district_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>SUB-DISTRICT</th>";
                echo "<th>DISTRICT</th>";
                echo "<th>UPDATE_INFO</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['sub_district_name'] . "</td>";
			echo "<td>" . $row['district_name'] . "</td>";
			echo "<td><a href='update_sub_district.php?id=$row[sub_district_id]'>Click To Update</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "No Registered Sub-Districts were found.";
    	}

	}

	function register_official(){
		$o_fname  = $_REQUEST["o_fname"];
		$o_lname  = $_REQUEST["o_lname"];
		$o_password1  = $_REQUEST["o_password1"];
		$o_password2  = $_REQUEST["o_password2"];
		$o_position  = $_REQUEST["o_position"];
		$o_health_center  = $_REQUEST["o_health_center"];
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
					window.history.back();

				</script>
				<?php
		}
		else if ($o_health_center == "" || $o_health_center == 0){
			?>
				<script>
					alert("ERROR: Make Sure All Fields are filled!");
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

		$query = "INSERT INTO hms_officials (o_fname, o_lname, o_username, o_password, o_position, o_health_center, o_contact, o_email, o_system_id, date_of_registration, last_date_updated) 
		VALUES('$o_fname', '$o_lname', '$o_username', MD5('$thepassword'), '$o_position', '$o_health_center', '$o_contact', '$o_email', '$o_system_id', CURDATE(), CURDATE())";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Health Official Registered!");
					window.location.href="health_officials.php";
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
	}

	function see_all_health_officials(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT o_id, o_system_id, o_fname, o_lname, hms_hospitals.h_name, o_contact 
			FROM hms_officials, hms_hospitals 
			WHERE hms_officials.o_health_center = hms_hospitals.h_id ORDER BY o_fname");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>PIN</th>";
                echo "<th>FULL NAME</th>";
                echo "<th>HEALTH CENTER</th>";
                echo "<th>CONTACT</th>";
                echo "<th>VIEW_DETAILS</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['o_system_id'] . "</td>";
			echo "<td>" . $row['o_fname'] . " " . $row['o_lname'] . "</td>";
			echo "<td>" . $row['h_name'] . "</td>";
			echo "<td>" . $row['o_contact'] . "</td>";
			echo "<td><a href='health_official_details.php?id=$row[o_id]'>View Details</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "No Registered Health Officials were found.";
    	}

	}

	function edit_health_official(){
		if (isset($_POST['submit'])) {
		$id = $_REQUEST['id'];
		$o_fname  = $_REQUEST["o_fname"];
		$o_lname  = $_REQUEST["o_lname"];
		$o_password1  = $_REQUEST["o_password1"];
		$o_password2  = $_REQUEST["o_password2"];
		$o_position  = $_REQUEST["o_position"];
		$o_health_center  = $_REQUEST["o_health_center"];
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
					window.history.back();

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
		else if ($o_health_center == "" || $o_health_center == 0){
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

		$thepassword = $o_password2;

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "UPDATE hms_officials SET o_fname='$o_fname', o_lname='$o_lname', o_username='$o_username', o_password=MD5('$thepassword'), o_position='$o_position', o_health_center='$o_health_center', o_contact='$o_contact', o_email='$o_email', o_system_id='$o_system_id', last_date_updated=CURDATE() WHERE hms_officials.o_id='$id'";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());

        if ($result == 1) {
            ?>
                <script>
                    alert("Health Official Updated!");
                    window.location.href="health_officials.php";
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
    }
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

	function register_hospital(){
		$h_name  = $_REQUEST["h_name"];
		$h_location  = $_REQUEST["h_location"];
		$h_sub_district  = $_REQUEST["sub_district_ref"];
		$h_district  = $_REQUEST["district_ref"];
		$h_region  = $_REQUEST["region_ref"];
		$h_address  = $_REQUEST["h_address"];
		$h_contact  = $_REQUEST["h_contact"];
		$h_email  = $_REQUEST["h_email"];

		if ($h_sub_district == "" || $h_sub_district == 0){
			?>
				<script>
					alert("ERROR: Make Sure All Fields Are Filled!");
					window.history.back();

				</script>
				<?php
		}
		else if ($h_district == "" || $h_district == 0){
			?>
				<script>
					alert("ERROR: Make Sure All Fields Are Filled!");
					window.history.back();

				</script>
				<?php
		}
		else if ($h_region == "" || $h_region == 0){
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

		$query = "INSERT INTO hms_hospitals (h_name, h_location, h_sub_district, h_district, h_region, h_address, h_contact, h_email, date_of_registration) 
		VALUES('$h_name','$h_location','$h_sub_district', '$h_district', '$h_region', '$h_address', '$h_contact', '$h_email', CURDATE())";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Hospital Registered!");
					window.location.href="manage_hospitals.php";
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

	function see_all_hospitals(){

		$db = new adb();
		$db -> connect();

		$result = mysql_query("SELECT h_id, h_name, h_location, h_contact FROM hms_hospitals ORDER BY h_name");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>HOSPITAL</th>";
                echo "<th>LOCATION</th>";
                echo "<th>HOT-LINE</th>";
                echo "<th>VIEW_DETAILS</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['h_name'] . "</td>";
			echo "<td>" . $row['h_location'] . "</td>";
			echo "<td>" . $row['h_contact'] . "</td>";
			echo "<td><a href='hospital_details.php?id=$row[h_id]'>View Details</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "No Registered Hospitals were found.";
    	}

	}

	function get_hospital_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT h_id, h_name, h_location, hms_sub_districts.sub_district_name , hms_districts.district_name, hms_regions.region_name, h_address,  h_contact, h_email, date_of_registration 
		FROM hms_hospitals, hms_sub_districts, hms_districts, hms_regions 
		WHERE hms_hospitals.h_sub_district = hms_sub_districts.sub_district_id 
		AND hms_hospitals.h_district = hms_districts.district_id
		AND hms_hospitals.h_region = hms_regions.region_id
		AND h_id='$id'";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function edit_hospital(){
		if (isset($_POST['submit'])) {
			$id = $_REQUEST['id'];
		$h_name  = $_REQUEST["h_name"];
		$h_location  = $_REQUEST["h_location"];
		$h_sub_district  = $_REQUEST["sub_district_ref"];
		$h_district  = $_REQUEST["district_ref"];
		$h_region  = $_REQUEST["region_ref"];
		$h_address  = $_REQUEST["h_address"];
		$h_contact  = $_REQUEST["h_contact"];
		$h_email  = $_REQUEST["h_email"];

		if ($h_sub_district == "" || $h_sub_district == 0){
			?>
				<script>
					alert("ERROR: Make Sure All Fields Are Filled!");
					window.history.back();

				</script>
				<?php
		}
		else if ($h_district == "" || $h_district == 0){
			?>
				<script>
					alert("ERROR: Make Sure All Fields Are Filled!");
					window.history.back();

				</script>
				<?php
		}
		else if ($h_region == "" || $h_region == 0){
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

		$query = "UPDATE hms_hospitals SET h_name='$h_name', h_location='$h_location', h_sub_district='$h_sub_district', h_district='$h_district', h_region='$h_region', h_address='$h_address', h_contact='$h_contact', h_email='$h_email' WHERE hms_hospitals.h_id='$id'";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());

        if ($result == 1) {
            ?>
                <script>
                    alert("Hospital Updated!");
                    window.location.href="manage_hospitals.php";
                </script>
            <?php
        	}
    	}
    }
	}

?>