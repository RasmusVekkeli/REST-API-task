<?php
	// A function to help send http requests to save my sanity.
	// Url should not contain any characters that should have been escaped already
	function sendHttpRequest($url, $httpOptions){
		// Stream context
		$ctx = stream_context_create(["http" => $httpOptions]);

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

	// Returns token as string if the token file exists
	// Returns false if the token wasn't found
	// The path is seems to be relative to the current working directory instead of the script file directory
	// TODO: Figure out a better way to deal with the path than this
	function getToken(){
		if(!file_exists("api.token")){
			return false;
		}

		return file_get_contents("api.token");
	}
?>