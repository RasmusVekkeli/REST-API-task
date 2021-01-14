<?
	require_once "api_functions.php";
	require_once "utility.php";

	// Options:
	// -m, --movie					Set search for movie
	// -b, --book					Set search for book
	// -t, --title <titleString> 	Search with a specific title (only for movies)
	// -y, --year <year>			Search with a specific year (only for movies)
	// -l, --longPlot				Set plot description to long description (only for movies)
	// -i, --isbn					Search with an ISBN (only for books)

	$opts = getopt(
		"mbslpt:y:i:", 
		[
			"movie",
			"book",
			"title:",
			"year:",
			"longplot",
			"isbn:"
		]
	);

	// Set command line arguments
	$movie = von($opts["m"], $opts["movie"]);
	$title = von($opts["t"], $opts["title"]);
	$year = von($opts["y"], $opts["year"]);
	$longPlot = von($opts["l"], $opts["longPlot"]);
	$book = von($opts["b"], $opts["book"]);
	$isbn = von($opts["i"], $opts["isbn"]);

	// Check if both book and movie search is set, since we can't do a search for both of them, show error message and abort
	if(isset($movie) && isset($book)){
		echo("Error: Cannot search for both a movie and a book at the same time. Use only one of \"-m\" or \"-b\"");
		return;
	}

	// Get token
	// TODO: Make path not hardcoded
	$token = getToken("api.token");

	// Search for book
	if(isset($book)){
		// Make sure that $isbn exists
		if(!isset($isbn)){
			echo("Error: ISBN must be set to search a book! Use flag -i <isbn> or --isbn <isbn>.");
			return;
		}

		// Make sure that $isbn is set to a number
		if(!is_numeric($isbn)){
			echo("Error: ISBN is not a numeric value!");
			return;
		}

		// Show result to user
		// TODO: Make a proper showing
		echo(getBook($isbn));
		return;
	}

	if(isset($movie)){
		// Make sure that $title exists
		if(!isset($title)){
			echo("Error: Title must be set to search a movie! Use flag -t <title> or --title <title>.");
			return;
		}

		// Check that the year is a numeric value if it exists
		if(!is_numeric($year) && $year !== null){
			echo("Error: Year is not a numeric value!");
			return;
		}

		echo(getMovie($title, $year, $longPlot, $token));
		return;
	}
	?>