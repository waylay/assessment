<?php
// All logic goes in this class
class FranchiseSearch
{
	private $franchises;
	private $region_mappings;

	// Receives string in CSV format
	function initialize($franchises_string, $region_mappings_string)
	{
		// Assign $region_mappings
		// Assign $franchises
		$this->franchises = $this->parse_csv_string($franchises_string);
		$this->region_mappings = $this->parse_csv_string($region_mappings_string);
	}

	// Should return an ordered array (by name) of franchises for this postal code with all their information
	function search($postal_code)
	{
		$results = array();
		// Postal code 14410 should find 3 locations.
		// If sorted alphabetically, second location name is "Prohaska, Gibson and Rolfson"
		// website: auto-service.co/yw-159-d
		// city: Adams Basin
		// state: NY

		$region = $this->get_region($postal_code);
		if(!$region){
			throw new Exception('No Region Found');
		}
		$franchises = $this->get_franchises_by_region_code($region['region_code']);


		// add the region details to each francise
		if(!empty($franchises)){
			foreach ($franchises as $franchise) {
				$results[] = array_merge($franchise, $region);
			}
		}

		// Should return array of arrays
		return $results;
	}

	// Returns the actual region code from the region_mappings (first one if there are multiple)
	function get_region($postal_code){

		//'region' keys:  "postal_code,region_code,city,state,region"
		foreach ($this->region_mappings as $region) {
			if($region['postal_code'] == $postal_code){
				return $region;
			}
		}
		return false;
	}

	// Find all franchises by region code
	function get_franchises_by_region_code($region_code) {

		$results = array();
		foreach ( $this->franchises as $franchise ) {
			$franchise_region_codes = explode(',',$franchise['region_codes']);
			if ( in_array( $region_code, $franchise_region_codes ) ) {
				$results[] = $franchise;
			}
		}

		if(!empty($results)){
			// sort results alphabetically by franchise name
			usort($results, function($a, $b){
				return strcmp($a["franchise_name"], $b["franchise_name"]);
			});
		}

		return $results;
	}


	// Transform the csv string into a multidimensional assoc array
	function parse_csv_string($csv_string){

		$csv_rows = str_getcsv($csv_string, ";"); //parse the whole string
		$csv = array_map('str_getcsv', $csv_rows); //parse the rows
		array_walk($csv, function(&$a) use ($csv) {
			$a = array_combine($csv[0], $a); //use headers as keys
		});
		array_shift($csv); //remove column header
		return $csv;

	}
}
?>
