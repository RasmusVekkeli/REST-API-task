# REST-API-task
Simple demo of a REST API  
Requires NodeJS and NPM

# Setting up
Run the following command to install the required packages:
```
npm install
```

## Configuring
Create file `config.json`.  
File contents:
```js
{
	"api_backend": 					// Configurations for the API backend server
	{
		"port": 80,					// Port the server binds to
		"secret": "",				// JWT secret used
		"omdbKey": ""				// The OMDb API key
	}
}
```

# Running
Run command:
```
npm start
```

Now you can send your API requests to `localhost`