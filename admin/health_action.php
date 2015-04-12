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
	else if (isset($_REQUEST["see_all_diseases"])) {
		see_all_diseases();
	}
	else if (isset($_REQUEST["add_disease"])) {
		add_disease();
	}
	else if (isset($_REQUEST["get_disease_by_id"])) {
		get_disease_by_id();
	}
	else if (isset($_REQUEST["edit_disease"])) {
		edit_disease();
	}
	else if (isset($_REQUEST["see_all_rooms"])) {
		see_all_rooms();
	}
	else if (isset($_REQUEST["add_room"])) {
		add_room();
	}
	else if (isset($_REQUEST["get_room_by_id"])) {
		get_room_by_id();
	}
	else if (isset($_REQUEST["edit_room"])) {
		edit_room();
	}
	else if (isset($_REQUEST["see_all_medicines"])) {
		see_all_medicines();
	}
	else if (isset($_REQUEST["add_medicine"])) {
		add_medicine();
	}
	else if (isset($_REQUEST["get_medicine_by_id"])) {
		get_medicine_by_id();
	}
	else if (isset($_REQUEST["edit_medicine"])) {
		edit_medicine();
	}
	else if (isset($_REQUEST["see_all_payment_modes"])) {
		see_all_payment_modes();
	}
	else if (isset($_REQUEST["add_payment_mode"])) {
		add_payment_mode();
	}
	else if (isset($_REQUEST["get_payment_mode_by_id"])) {
		get_payment_mode_by_id();
	}
	else if (isset($_REQUEST["edit_payment_mode"])) {
		edit_payment_mode();
	}
	else if (isset($_REQUEST["see_all_wards"])) {
		see_all_wards();
	}
	else if (isset($_REQUEST["add_ward"])) {
		add_ward();
	}
	else if (isset($_REQUEST["get_ward_by_id"])) {
		get_ward_by_id();
	}
	else if (isset($_REQUEST["edit_ward"])) {
		edit_ward();
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

	function see_all_medicines(){

		$db = new adb();
		$db -> connect();

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT * FROM hms_medicine ORDER BY med_name LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>MEDICINE</th>";
                echo "<th>DESCRIPTION</th>";
                echo "<th>UPDATE</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['med_name'] . "</td>";
			echo "<td>" . $row['med_description'] . "</td>";
			echo "<td><a href='update_medicine.php?id=$row[m_id]'>Click To Update</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "<center><h4>No Medicines were found in the system database!</h4></center>";
    	}

    	$sql = "SELECT * FROM hms_medicine"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='medicines.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='medicines.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='medicines.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

	}

	function add_medicine(){
		$medicine  = $_REQUEST["medicine"];
		$description  = $_REQUEST["description"];

		if ($medicine == "" || $description == "") {
			?>
				<script>
					alert("ERROR: Enter Name And Description of Medicine!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "INSERT INTO hms_medicine (med_name, med_description) VALUES('$medicine', '$description')";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Medicine Added!");
					window.location.href="medicines.php";
				</script>
				<?php
			}
		}
	}

	function get_medicine_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT * FROM hms_medicine WHERE m_id=$id";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function edit_medicine(){
		$med_name = $_REQUEST['med_name'];
		$description = $_REQUEST['description'];
        $id = $_REQUEST['m_id'];

        if ($med_name == "" || $description == "") {
			?>
				<script>
					alert("ERROR: Enter Name and Description Of Medicine!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$result = mysql_query("UPDATE hms_medicine SET med_name = '$med_name', med_description = '$description' WHERE m_id='$id'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

        if ($result == 1) {
            ?>
                <script>
                    alert("Medicine Updated!");
                    window.location.href="medicines.php";
                </script>
            <?php
        	}
        }
	}

	function see_all_payment_modes(){

		$db = new adb();
		$db -> connect();

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT * FROM hms_payment_mode ORDER BY pm_name LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>PAYMENT MODE</th>";
                echo "<th>UPDATE</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['pm_name'] . "</td>";
			echo "<td><a href='update_payment_mode.php?id=$row[pm_id]'>Click To Update</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "<center><h4>No Payment Modes were found in the system database!</h4></center>";
    	}

    	$sql = "SELECT * FROM hms_payment_mode"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='payment_modes.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='payment_modes.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='payment_modes.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

	}

	function add_payment_mode(){
		$pm_name  = $_REQUEST["pm_name"];

		if ($pm_name == "") {
			?>
				<script>
					alert("ERROR: Enter a Payment Mode!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "INSERT INTO hms_payment_mode (pm_name) VALUES('$pm_name')";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Payment Mode Added!");
					window.location.href="payment_modes.php";
				</script>
				<?php
			}
		}
	}

	function get_payment_mode_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT * FROM hms_payment_mode WHERE pm_id=$id";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function edit_payment_mode(){
		$pm_name = $_REQUEST['pm_name'];
        $id = $_REQUEST['pm_id'];

        if ($pm_name == "") {
			?>
				<script>
					alert("ERROR: Enter Name Of Payment Mode!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$result = mysql_query("UPDATE hms_payment_mode SET pm_name = '$pm_name' WHERE pm_id='$id'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

        if ($result == 1) {
            ?>
                <script>
                    alert("Payment Mode Updated!");
                    window.location.href="payment_modes.php";
                </script>
            <?php
        	}
        }
	}

	function see_all_wards(){

		$db = new adb();
		$db -> connect();

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT * FROM hms_wards ORDER BY ward_name LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>WARD</th>";
                echo "<th>UPDATE</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['ward_name'] . "</td>";
			echo "<td><a href='update_ward.php?id=$row[ward_id]'>Click To Update</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "<center><h4>No Wards were found in the system database!</h4></center>";
    	}

    	$sql = "SELECT * FROM hms_wards"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='wards.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='wards.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='wards.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

	}

	function add_ward(){
		$ward_name  = $_REQUEST["ward_name"];

		if ($ward_name == "") {
			?>
				<script>
					alert("ERROR: Enter a Ward!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "INSERT INTO hms_wards (ward_name) VALUES('$ward_name')";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Ward Added!");
					window.location.href="wards.php";
				</script>
				<?php
			}
		}
	}

	function get_ward_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT * FROM hms_wards WHERE ward_id=$id";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function edit_ward(){
		$ward_name = $_REQUEST['ward_name'];
        $id = $_REQUEST['ward_id'];

        if ($ward_name == "") {
			?>
				<script>
					alert("ERROR: Enter Name Of Ward!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$result = mysql_query("UPDATE hms_wards SET ward_name = '$ward_name' WHERE ward_id='$id'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

        if ($result == 1) {
            ?>
                <script>
                    alert("Ward Updated!");
                    window.location.href="wards.php";
                </script>
            <?php
        	}
        }
	}

	function see_all_rooms(){

		$db = new adb();
		$db -> connect();

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT * FROM hms_consulting_rooms ORDER BY room_name LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>ROOM</th>";
                echo "<th>UPDATE</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['room_name'] . "</td>";
			echo "<td><a href='update_room.php?id=$row[room_id]'>Click To Update</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "<center><h4>No Rooms were found in the system database!</h4></center>";
    	}

    	$sql = "SELECT * FROM hms_consulting_rooms"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='consulting_rooms.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='consulting_rooms.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='consulting_rooms.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

	}

	function add_room(){
		$room  = $_REQUEST["room"];

		if ($room == "") {
			?>
				<script>
					alert("ERROR: Enter a Room!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "INSERT INTO hms_consulting_rooms (room_name) VALUES('$room')";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Room Added!");
					window.location.href="consulting_rooms.php";
				</script>
				<?php
			}
		}
	}

	function get_room_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT * FROM hms_consulting_rooms WHERE room_id=$id";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function edit_room(){
		$room_name = $_REQUEST['room_name'];
        $id = $_REQUEST['room_id'];

        if ($room_name == "") {
			?>
				<script>
					alert("ERROR: Enter Name Of Room!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$result = mysql_query("UPDATE hms_consulting_rooms SET room_name = '$room_name' WHERE room_id='$id'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

        if ($result == 1) {
            ?>
                <script>
                    alert("Consulting Room Updated!");
                    window.location.href="consulting_rooms.php";
                </script>
            <?php
        	}
        }
	}

	function see_all_diseases(){

		$db = new adb();
		$db -> connect();

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT * FROM hms_diseases ORDER BY d_name LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query

		if(mysql_num_rows($result) > 0){
        echo "<table class='table table-striped'>";
            echo "<thead><tr>";
                echo "<th>DISEASE</th>";
                echo "<th>UPDATE</th>";
            echo "</tr></thead>";
		    echo "<tbody>";
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['d_name'] . "</td>";
			echo "<td><a href='update_disease.php?id=$row[d_id]'>Click To Update</a></td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
			mysql_free_result($result);
		}

		else{
        	echo "<center><h4>No Diseases were found in the system database!</h4></center>";
    	}

    	$sql = "SELECT * FROM hms_diseases"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='diseases.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='diseases.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='diseases.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

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

	function add_disease(){
		$disease  = $_REQUEST["disease"];

		if ($disease == "") {
			?>
				<script>
					alert("ERROR: Enter a Disease!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$query1 = "SET FOREIGN_KEY_CHECKS=0";
		mysql_query($query1);

		$query = "INSERT INTO hms_diseases (d_name) VALUES('$disease')";
		$query2 = "SET FOREIGN_KEY_CHECKS=1";
		mysql_query($query2);
		$result = mysql_query($query) or die(mysql_error());
		
		if($result == 1){
			?>
				<script>
					alert("Disease Added!");
					window.location.href="diseases.php";
				</script>
				<?php
			}
		}
	}

	function get_disease_by_id($id){

		$db = new adb();
		$db -> connect();

		$result = "SELECT * FROM hms_diseases WHERE d_id=$id";

		if(!$db->query($result)){
				return false;
			}

		return $db -> fetch();
	}

	function edit_disease(){
		$d_name = $_REQUEST['d_name'];
        $id = $_REQUEST['d_id'];

        if ($d_name == "") {
			?>
				<script>
					alert("ERROR: Enter Name Of Disease!");
					window.history.back();
				</script>
				<?php
		}

		else {

		$db = new adb();
		$db -> connect();

		$result = mysql_query("UPDATE hms_diseases SET d_name = '$d_name' WHERE d_id='$id'");
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}

        if ($result == 1) {
            ?>
                <script>
                    alert("Disease Updated!");
                    window.location.href="diseases.php";
                </script>
            <?php
        	}
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

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT district_id, district_name, hms_regions.region_name 
								FROM hms_districts, hms_regions 
								WHERE hms_districts.region_ref = hms_regions.region_id ORDER BY district_name LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query

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

    	$sql = "SELECT * FROM hms_districts"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='districts.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='districts.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='districts.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

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

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT sub_district_id, sub_district_name, hms_districts.district_name 
								FROM hms_sub_districts, hms_districts 
								WHERE hms_sub_districts.district_ref = hms_districts.district_id ORDER BY sub_district_name LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query
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

    	$sql = "SELECT * FROM hms_sub_districts"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='sub_districts.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='sub_districts.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='sub_districts.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

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

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT o_id, o_system_id, o_fname, o_lname, hms_hospitals.h_name, o_contact 
			FROM hms_officials, hms_hospitals 
			WHERE hms_officials.o_health_center = hms_hospitals.h_id ORDER BY o_fname LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query

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

    	$sql = "SELECT * FROM hms_officials"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='health_officials.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='health_officials.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='health_officials.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

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

	//Function to register a new hospital
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

		$num_rec_per_page=10;
                
                if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
                $start_from = ($page-1) * $num_rec_per_page;

                $sql = "SELECT h_id, h_name, h_location, h_contact FROM hms_hospitals ORDER BY h_name LIMIT $start_from, $num_rec_per_page"; 
                $result = mysql_query ($sql); //run the query
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

    	$sql = "SELECT * FROM hms_hospitals"; 
                    $rs_result = mysql_query($sql); //run the query
                    $total_records = mysql_num_rows($rs_result);  //count number of records
                    $total_pages = ceil($total_records / $num_rec_per_page); 

                    echo "<center><nav><ul class='pagination pagination'>";
                    echo "<li><a href='manage_hospitals.php?page=1' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo; First</span></a></li>"; // Goto 1st page  

                    for ($i=1; $i<=$total_pages; $i++) { 
                                echo "<li><a href='manage_hospitals.php?page=".$i."'>".$i."</a></li>"; 
                    }; 
                    echo "<li><a href='manage_hospitals.php?page=$total_pages' aria-label='Next'>
                    <span aria-hidden='true'>Last &raquo;</span></a></li>   "; // Goto last page
                    echo "</ul></nav></center>";

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