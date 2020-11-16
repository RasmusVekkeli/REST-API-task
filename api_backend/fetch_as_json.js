const fetch = require("node-fetch");

async function fetchAsJSON(apiQuery) {
	// This "await" waits for the Response.json() function because for some reason the function which parses the response body as JSON has to be asynchronous
	return await (
		// Query the OMDb API
		await fetch(apiQuery)
	).json()
}

module.exports = fetchAsJSON;