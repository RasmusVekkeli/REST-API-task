<?php
	require "utility.php";

	// TODO: Move this into the config.json
	$baseUrl = "http://localhost/";

	// Helper function to setup authorization and encoding query parameters into the url
	// $endpoint is the wanted API endpoint as string
	// $queryArr is an array of query keys and values
	// Returns the response body as string
	function apiRequest($endpoint, $queryArr){
		global $baseUrl;
		$url = $baseUrl;

		// Add specific endpoint to the URL
		$url .= $endpoint;

		// Get the final encoded url
		$url = compileQueryURL($url, $queryArr);

		// TODO: check for false token
		$token = getToken();

		// Set up the JWT token
		$httpOpts = [
			"header" => "Authorization: Bearer " . $token . "\r\n"
		];

		return sendHttpRequest($url, $httpOpts);
	}

	// Function which calls the APIs getMovie endpoint with the proper parameters
	// Returns the raw response body as string
	function getMovie($title, $year, $plot){
		// Set up the query parameters
		$queryArr = ["title" => $title];
		
		if(isset($year)){
			$queryArr["year"] = $year;
		}
		
		if(isset($plot)){
			$queryArr["plot"] = $plot;
		}

		return apiRequest("getMovie", $queryArr);
	}

	// Same as getMovie but for the getBook API endpoint
	function getBook($isbn){
		$queryArr = ["isbn" => $isbn];

		return apiRequest("getBook", $queryArr);
	}
?>