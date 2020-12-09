// This script is used to generate test tokens for the API

const fs = require("fs");
const jwt = require("jsonwebtoken");

let config = null;

try{
	// We use the secret set by config.json
	config = require("./config.json");
}
catch(e){
	// config.json probably hasn't been created, show error message
	console.error("\"config.json\" was not found. Please create one and try again.");
	return;
}

// Check that the config actually has what we need
if(config.api_backend.secret === undefined){
	console.error("\"api_backend.secret\" was not found in config.json. Please add one to it and try again.");
	return;
}

// Generate and write to file
const token = jwt.sign({name: "TestToken"}, config.api_backend.secret);
fs.writeFileSync("./api.token", token);