const express = require("express");

const app = express();

// TODO: Move this into some config file
const port = 80;

app.get("/", (req, res) => {
	res.send("Hello World!");
});

app.listen(port, () => {
	console.log(`Server listening on port ${port}`);
});