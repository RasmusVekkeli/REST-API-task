const express = require("express");
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
				name: err.name,
				message: err.message
			}
		);
		
		return;
	}

	next();
});

app.get("/", (req, res) => {
	res.send("Hello World!");
});

app.listen(config.port, () => {
	console.log(`Server listening on port ${config.port}`);
});