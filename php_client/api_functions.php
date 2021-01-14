<?php
	require_once "utility.php";

	// TODO: Move this into the config.json
	$baseUrl = "http://localhost/";

	// Helper function to setup authorization and encoding query parameters into the url
	// $endpoint is the wanted API endpoint as string
	// $queryArr is an array of query keys and values
	// $token a JWT token string to be used for authentication
	// Returns the response body as string
	function apiRequest($endpoint, $queryArr, $token){
		global $baseUrl;
		$url = $baseUrl;

		// Add specific endpoint to the URL
		$url .= $endpoint;

		// Get the final encoded url
		$url = compileQueryURL($url, $queryArr);

		if(!$token){
			throw new UnexpectedValueException("Failed to get token: getToken() returned false!");
		}

		// Set up the JWT token
		$httpOpts = [
			"header" => "Authorization: Bearer " . $token . "\r\n"
		];

		return sendHttpRequest($url, $httpOpts);
	}

	// Function which calls the APIs getMovie endpoint with the proper parameters
	// Returns the raw response body as string
	function getMovie($title, $year, $longPlot, $token){
		// Set up the query parameters
		$queryArr = ["title" => $title];
		
		if(isset($year)){
			$queryArr["year"] = $year;
		}
		
		// Convert $longPlot to something that could be used in a query
		$queryArr["plot"] = isset($longPlot) ? "long" : null;

		return apiRequest("getMovie", $queryArr, $token);
	}

	// Same as getMovie but for the getBook API endpoint
	function getBook($isbn, $token){
		$queryArr = ["isbn" => $isbn];

		return apiRequest("getBook", $queryArr, $token);
	}
?>