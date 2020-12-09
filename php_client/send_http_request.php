<?php
	// A function to help send http requests to save my sanity.
	// Url should not contain any characters that should be escaped already
	function sendHttpRequest($url, $httpOptions){
		// Stream context
		$ctx = ["http" => $httpOptions];

		$body = file_get_contents($url, false, $ctx);

		return $body;
	}
?>