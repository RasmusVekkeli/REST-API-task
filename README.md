# REST-API-task
Simple demo of a REST API  
Requires NodeJS and NPM

# Setting up
Run the following command to install the required packages:
```
npm install
```

## Configuring
Create file `config.json` by copying and renaming `config_default.json`.  
File contents:
```js
{
	"api_backend":                          // Configurations for the API backend server
	{
		"port": 80,                         // Port the server binds to
		"secret": "",                       // JWT secret used
		"omdbKey": ""                       // The OMDb API key
	},
	"client":                               // Configurations of the php client which calls the API
	{
		"tokenPath": "api.token"            // Path to file containing the token string. Relative paths are relative to current working directory.
		"apiEndpoint": "http://localhost/"  // URL used to call the API. Note: Only affects the address used by the client; has no effect on the API server.
	}
}
```

# Running
Run command:
```
npm start
```

Now you can send your API requests to `http://localhost`

# Generating a test token
First follow the instructions in **Setting up** and **Configuring** sections.  

Next run the following command:
```
node generate_jwt.js
```

The file `api.token` should have been created in the project root directory.

# Using the PHP client to get data from the API
Command line flags:  
```
Options:
-m, --movie					Set search for movie
-b, --book					Set search for book
-t, --title <titleString> 	Search with a specific title (required for movies)
-y, --year <year>			Search with a specific year (only for movies)
-l, --longPlot				Set plot description to long description (only for movies)
-i, --isbn					Search with an ISBN (required for books)
```

At least one of the `-m, --movie` or `-b, --book` flags must be set.

Run the `client_cli.php` script from the same directory which contains the `config.json` file.

Example movie search:
```
php ./php_client/client_cli.php -m -t "Forrest Gump" -l
```
This command searches a movie with a title `Forrest Gump` and enables the longer plot synopsis.

Example book search:
```
php ./php_client/client_cli.php -b -i 9780151660346
```
This command searches for a book with ISBN-number of `9780151660346`.