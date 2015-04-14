<?php
	include_once("adb.php");
	
	class health_functions extends adb{
		function health_functions(){
			adb::adb();
		}
		/**
		*query all sellers in the table and store the dataset in $this->result	
		*@return if successful true else false
		*/

		function search_patient($name){
		$query="SELECT * FROM hms_local_patient_registration 
			WHERE fname LIKE '%$name%'
			OR lname LIKE '%$name%'
			OR patient_system_id LIKE '%$name%'";
					
			if(!$this->query($query)){
				echo "not working";
				return false;
			}
			return $this->fetch();		
		}

		function search_health_official($name){
		$query="SELECT o_id, o_system_id, o_fname, o_lname, hms_hospitals.h_name, o_contact FROM hms_officials, hms_hospitals
			WHERE hms_officials.o_health_center = hms_hospitals.h_id 
			AND (o_fname LIKE '%$name%' OR o_lname LIKE '%$name%' OR o_system_id LIKE '%$name%')";
					
			if(!$this->query($query)){
				echo "not working";
				return false;
			}
			return $this->fetch();		
		}

		function search_hospital($name){
		$query="SELECT * FROM hms_hospitals 
			WHERE h_name LIKE '%$name%'";
					
			if(!$this->query($query)){
				echo "not working";
				return false;
			}
			return $this->fetch();		
		}

		function search_district($name){
		$query="SELECT district_id, district_name, hms_regions.region_name FROM hms_districts, hms_regions 
			WHERE hms_districts.region_ref = hms_regions.region_id AND district_name LIKE '%$name%'";
					
			if(!$this->query($query)){
				echo "not working";
				return false;
			}
			return $this->fetch();		
		}

		function search_sub_district($name){
		$query="SELECT sub_district_id, sub_district_name, hms_districts.district_name FROM hms_sub_districts, hms_districts 
			WHERE hms_sub_districts.district_ref = hms_districts.district_id AND sub_district_name LIKE '%$name%'";
					
			if(!$this->query($query)){
				echo "not working";
				return false;
			}
			return $this->fetch();		
		}

		function see_some_cases($region,$from,$to){
		$query="SELECT hms_diseases.d_id, hms_diseases.d_name, hms_hospitals.h_name, hms_hospitals.h_region, 
					hms_patient_visits.date_of_input, hms_regions.region_name as 'regions', count(hms_diseases.d_name) as 'num_cases' 
					FROM hms_patient_visits
					INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_visits.hospital_id)
					INNER JOIN hms_diseases ON FIND_IN_SET(hms_diseases.d_id, hms_patient_visits.disease) <> 0
					INNER JOIN hms_regions ON (hms_regions.region_id=hms_hospitals.h_region)
					WHERE hms_hospitals.h_region='$region'
					AND hms_patient_visits.date_of_input >= '$from' AND hms_patient_visits.date_of_input <= '$to'
					GROUP BY hms_diseases.d_name";
					
			if(!$this->query($query)){
				echo "not working";
				return false;
			}
			return $this->fetch();		
		}
		
		
	}
?>