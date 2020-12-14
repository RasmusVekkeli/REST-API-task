<?php
	require "utility.php";

	// TODO: Move this into the config.json
	$baseUrl = "http://localhost/";

	// Function which calls the APIs getMovie endpoint with the proper parameters
	// Returns the raw response body as string
	function getMovie($title, $year, $plot){
		global $baseUrl;
		$url = $baseUrl;

		// Add specific endpoint to the URL
		$url .= "getMovie";

		// Set up the query parameters
		$pArr = ["title" => $title];
		
		if(isset($year)){
			$pArr["year"] = $year;
		}
		
		if(isset($plot)){
			$pArr["plot"] = $plot;
		}

		// Get the final encoded url
		$url = compileQueryURL($url, $pArr);

		// TODO: check for false token
		$token = getToken();

		// Set up the JWT token
		$httpOpts = [
			"header" => "Authorization: Bearer " . $token . "\r\n"
		];

		return sendHttpRequest($url, $httpOpts);
	}
?>