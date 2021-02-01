const express = require("express");
const fetchAsJSON = require("./fetch_as_json");
const jwt = require("express-jwt");

// Load config for the backend
const config = require("../config.json").api_backend;

const app = express();

// Middleware for authenticating JWTs 
app.use(jwt({ secret: config.secret, algorithms: ["HS256"] }));

// Error handling middleware
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
	
	const apiRes = await fetchAsJSON(apiQuery);

	console.log(apiRes);

	// Send resulting information back as JSON
	res.json(apiRes);
});

// Gets book from OpenLibrary
app.get("/getBook", async (req, res) => {
	// Check if the ISBN is provided, send error message if it's not
	if (req.query.isbn === undefined) {
		res.json(
			{
				status: res.statusCode,
				message: "Query parameter \"isbn\" must be set!"
			}
		);

		return;
	}

	const apiQuery = `https://openlibrary.org/isbn/${req.query.isbn}.json`;

	const apiRes = await fetchAsJSON(apiQuery);

	const authorsArr = [];

	// Retrieve author names using keys from the original request
	for(const authorKey of apiRes.authors){
		const authorQuery = `https://openlibrary.org/${authorKey.key}.json`;
		
		const authorRes = await fetchAsJSON(authorQuery);

		authorsArr.push(authorRes.name);
	}

	// Replace the author keys with the author names
	apiRes.authors = authorsArr;

	console.log(apiRes);

	// Send resulting information back as JSON
	res.json(apiRes);
});

app.listen(config.port, () => {
	console.log(`Server listening on port ${config.port}`);
});