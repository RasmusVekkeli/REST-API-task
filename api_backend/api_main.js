const express = require("express");
const fetch = require("node-fetch");
const jwt = require("express-jwt");

// Load config for the backend
const config = require("../config.json").api_backend;

const app = express();

// Middleware for authenticating JWTs 
app.use(jwt({ secret: config.secret, algorithms: ["HS256"] }));

app.use(function (err, req, res, next) {
	// Handle invalid tokens
	if (err.name === "UnauthorizedError") {
		// Send back error info as JSON
		res.status(err.status).json(
			{
				status: err.status,
				message: err.message
			}
		);
		
		return;
	}

	next();
});

// Gets movie from OMDb API
app.get("/getMovie", async (req, res) => {
	// Check if title is set, send error message if it's not
	if (req.query.title === undefined) {
		res.json(
			{
				status: res.statusCode,
				message: "Query parameter \"title\" must be set!"
			}
		);

		return;
	}

	let apiQuery = `http://www.omdbapi.com/?apikey=${config.omdbKey}&t=${req.query.title}&`;

	// Add year to query if it's provided
	if (req.query.year !== undefined) {
		apiQuery += `y=${req.query.year}&`;
	}

	// Add plot type to query if it's provided
	if (req.query.plot !== undefined) {
		apiQuery += `plot=${req.query.plot}&`;
	}

	// Send resulting information back as JSON
	res.json(
		// This "await" waits for the Response.json() function because for some reason the function which parses the response body as JSON has to be asynchronous
		await (
			// Query the OMDb API
			await fetch(apiQuery)
		).json()
	);
});

app.listen(config.port, () => {
	console.log(`Server listening on port ${config.port}`);
});