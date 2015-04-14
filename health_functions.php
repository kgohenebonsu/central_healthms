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

		function see_some_hospital_cases($id,$from,$to){
		$query="SELECT hms_diseases.d_id,hms_diseases.d_name, hms_hospitals.h_name, 
				count(hms_patient_visits.disease) as 'num_cases' 
				FROM hms_patient_visits
				INNER JOIN hms_hospitals ON (hms_hospitals.h_id=hms_patient_visits.hospital_id)
				INNER JOIN hms_diseases 
				ON FIND_IN_SET(hms_diseases.d_id, hms_patient_visits.disease) <> 0
				WHERE hms_patient_visits.date_of_input >= '$from' AND hms_patient_visits.date_of_input <= '$to'
				AND hms_patient_visits.hospital_id= '$id'
				GROUP BY hms_diseases.d_name";
					
			if(!$this->query($query)){
				echo "not working";
				return false;
			}
			return $this->fetch();		
		}
		
		
	}
?>