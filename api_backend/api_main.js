const express = require("express");
const jwt = require("express-jwt");

const app = express();

// TODO: Move these into some config file
const port = 80;
const secret = "Cool Beans";

// Middleware for authenticating JWTs 
app.use(jwt({ secret: secret, algorithms: ["HS256"] }));

app.use(function (err, req, res, next) {
	// Handle invalid tokens
	if (err.name === "UnauthorizedError") {
		// Send back error info as JSON
		res.status(401).json(
			{
				status: 401,
				error: "Invalid token"
			}
		);
		
		return;
	}

	next();
});

app.get("/", (req, res) => {
	res.send("Hello World!");
});

app.listen(port, () => {
	console.log(`Server listening on port ${port}`);
});