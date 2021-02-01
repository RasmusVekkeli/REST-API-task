<?php
	require_once "utility.php";

	// Used as the API base url
	$baseUrl = getConfig()["apiEndpoint"];

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

	// Used for horizontal rule in pretty printing
	$hr = "===================================================================";

	// Generates and prints pretty output for movie data
	function printMovie($movieDataStr){
		$movieData = json_decode($movieDataStr, true);

		global $hr;

		// Print movie info in a neat format
		print <<<END
		{$movieData["Title"]} ({$movieData["Year"]})
		$hr
		Release Date: {$movieData["Released"]}
		Runtime Length: {$movieData["Runtime"]}
		Genre: {$movieData["Genre"]}
		$hr
		{$movieData["Plot"]}
		$hr
		Actors: {$movieData["Actors"]}
		Director: {$movieData["Director"]}
		Writer: {$movieData["Writer"]}
		Production: {$movieData["Production"]}
		Country: {$movieData["Country"]}
		$hr
		Awards: {$movieData["Awards"]}
		Metascore: {$movieData["Metascore"]}
		imdbRating: {$movieData["imdbRating"]}
		END;
	}

	function printBook($bookDataStr){
		$bookData = json_decode($bookDataStr, true);

		global $hr;

		// Pre-generate strings from arrays
		$auhtorsStr = implode(", ", $bookData["authors"]);
		$genreStr = implode(", ", $bookData["genres"]);
		$subjectStr = implode("\n", $bookData["subjects"]);
		$contributionsStr = implode(", ", $bookData["contributions"]);
		$publisherStr = implode(", ", $bookData["publishers"]);

		// Print book data in a neat format
		print <<<END
		{$bookData["title"]} ({$bookData["publish_date"]})
		By $auhtorsStr
		$hr
		Release Year: {$bookData["publish_date"]}
		Length: {$bookData["number_of_pages"]} pages
		Genre: $genreStr
		$hr
		Subjects:
		$subjectStr
		$hr
		Authors: $auhtorsStr
		Contributions: $contributionsStr
		Publishers: $publisherStr
		END;
	}
?>