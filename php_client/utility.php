<?php
	$config;

	// Loads config.json into $config as an array. Only uses the config.client part.
	function loadConfig(){
		if(!file_exists("config.json")){
			throw new RuntimeException("No config.json file found. Make sure that your current working directory contains config.json.");
		}

		$file = file_get_contents("config.json");

		global $config;

		$fullConfig = json_decode($file, true);

		$config = $fullConfig["client"];
	}

	// Returns config array
	function getConfig(){
		global $config;

		// Load config if it's not already loaded
		if(!isset($config)){
			loadConfig();
		}

		return $config;
	}

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
	function getToken(){
		$path = getConfig()["tokenPath"];

		if(!file_exists($path)){
			return false;
		}

		return file_get_contents($path);
	}

	// Value Or Null
	// Returns $primaryValue or $secondaryValue if they are set. Prioritises $primaryValue.
	// Returns null if not set
	function von($primaryValue, $secondaryValue)
	{
		if (isset($primaryValue)) {
			return $primaryValue;
		}

		if (isset($secondaryValue)) {
			return $secondaryValue;
		}

		return null;
	}
?>