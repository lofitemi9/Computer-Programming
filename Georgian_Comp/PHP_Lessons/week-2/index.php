<?php
// ====================================================================================
// STEP 1: SET YOUR API KEY
// ====================================================================================
// To run this code, you need a TMDB API key.
// 1. Go to https://www.themoviedb.org/ and create a free account.
// 2. Go to your account settings and click on the 'API' tab.
// 3. Request a new API key (select 'Developer').
// 4. Paste your API key in the variable below.
//
// Your API key is like a password, so keep it private.


// ====================================================================================
// STEP 2: THE API CLIENT CLASS (OOP)
// ====================================================================================
// This class, `TmdbApiClient`, represents our API interaction. It's a key principle of
// OOP to group related functionality (like all the methods for talking to the TMDB API)
// into a single, reusable object. This makes our code cleaner and easier to manage.

// You can think of this class as a "service" that provides data. In a real application,
// you might have a similar class for your database interactions, often called a
// "data access object" (DAO) or "repository" that would use PDO.


// ====================================================================================
// STEP 4: USING THE CLASS
// ====================================================================================

/*
 * Entry point of the app
 */
require_once "config.php";
require_once "TMDBApi.php";
require_once "MovieApp.php";

// create my API Handler
$api = new TMDBApi(TMDB_BASE_URL, TMDB_API_KEY);
// create our movie app objetc
$app = new MovieApp($api);
// get the current page from the url
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- add al your metadata stuff or else! -->
    </head>
    <body>
        <?php
            $app ->showPopularMovies($currentPage);
        ?>    
    </body>
</html>