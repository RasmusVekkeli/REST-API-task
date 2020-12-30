<?
	// Value Or Null
	// Returns $primaryValue or $secondaryValue if they are set. Prioritises $primaryValue.
	// Returns null if not set
	function von($primaryValue, $secondaryValue){
		if(isset($primaryValue)){
			return $primaryValue;
		}

		if(isset($secondaryValue)){
			return $secondaryValue;
		}

		return null;
	}

	// Options:
	// -m, --movie					Set search for movie
	// -b, --book					Set search for book
	// -t, --title <titleString> 	Search with a specific title (only for movies)
	// -y, --year <year>			Search with a specific year (only for movies)
	// -s, --shortPlot				Set plot description to short description (only for movies)
	// -l, --longPlot				Set plot description to long description (only for movies)
	// -i, --isbn					Search with an ISBN (only for books)

	$opts = getopt(
		"mbslpt:y:i:", 
		[
			"movie",
			"book",
			"title:",
			"year:",
			"shortplot",
			"longplot",
			"isbn:"
		]
	);

	// Set command line arguments
	$movie = von($opts["m"], $opts["movie"]);
	$title = von($opts["t"], $opts["title"]);
	$year = von($opts["y"], $opts["year"]);
	$shortPlot = von($opts["s"], $opts["shortPlot"]);
	$longPlot = von($opts["l"], $opts["longPlot"]);
	$book = von($opts["b"], $opts["book"]);
	$isbn = von($opts["i"], $opts["isbn"]);

	var_dump($movie);
	var_dump($title);
	var_dump($book);
	?>