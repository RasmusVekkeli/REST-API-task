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

	// Prints horizontal rule
	function hr(){
		echo("===================================================================\n");
	}

	// Generates and prints pretty output for movie data
	function printMovie($movieDataStr){
		$movieData = json_decode($movieDataStr, true);

		// Print movie info in a neat format
		printf("%s (%u)\n", $movieData["Title"], $movieData["Year"]);
		hr();

		printf("Release Date: %s\n", $movieData["Released"]);
		printf("Runtime Length: %s\n", $movieData["Runtime"]);
		printf("Genre: %s\n", $movieData["Genre"]);
		hr();

		printf("%s\n", $movieData["Plot"]);
		hr();

		printf("Actors: %s\n", $movieData["Actors"]);
		printf("Director: %s\n", $movieData["Director"]);
		printf("Writer: %s\n", $movieData["Writer"]);
		printf("Production: %s\n", $movieData["Production"]);
		printf("Country: %s\n", $movieData["Country"]);
		hr();

		printf("Awards: %s\n", $movieData["Awards"]);
		printf("Metascore: %s\n", $movieData["Metascore"]);
		printf("imdbRating: %s\n", $movieData["imdbRating"]);
	}

	function printBook($bookDataStr){
		$bookData = json_decode($bookDataStr, true);

		// Print book data in a neat format
		printf("%s (%u)\n", $bookData["title"], $bookData["publish_date"]);
		printf("By %s\n", implode(", ", $bookData["authors"]));
		hr();

		printf("Release Year: %s\n", $bookData["publish_date"]);
		printf("Length: %u pages\n", $bookData["number_of_pages"]);
		printf("Genre: %s\n", implode(", ", $bookData["genres"]));
		hr();

		printf("Subjects:\n%s\n", implode("\n", $bookData["subjects"]));
		hr();

		printf("Authors: %s\n", implode(", ", $bookData["authors"]));
		printf("Contributors: %s\n", implode(", ", $bookData["contributions"]));
		printf("Publishers: %s\n", implode(", ", $bookData["publishers"]));
	}
?>