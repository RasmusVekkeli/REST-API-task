<?php
	// A function to help send http requests to save my sanity.
	// Url should not contain any characters that should be escaped already
	function sendHttpRequest($url, $httpOptions){
		// Stream context
		$ctx = ["http" => $httpOptions];

		return file_get_contents($url, false, $ctx);
	}

	// Encodes url query parameters and appends them to the $baseURL string
	// $queryArr should be key->value pair array
	function compileQueryURL($baseURL, $queryArr){
		if(count($queryArr) < 1){
			return $baseURL;
		}

		$baseURL .= "?";

		// Add each query key and value to url
		foreach($queryArr as $key => $value){
			$baseURL .= urlencode($key) . "=" . urlencode($value) . "&";
		}

		return $baseURL;
	}
?>