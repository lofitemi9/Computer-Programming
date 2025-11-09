<?php
    /**
     * Movie APP class
     * This controls the main logic of our app
     */
    class MovieApp{
        private $api;

        public function __construct(TMDBApi $api){
            $this->api = $api;
        }
        /**
         * display a list of popular movies with pagination
         */
        public function showPopularMovies($page = 1){
            $movies = $this->api->getPopularMovies($page);
            if (empty($movies)){
                echo "<p> No movie title found </p>";
                return;
            }
            ?>
            <section class="row">
                <?php "<h2> Popular Movie List </h2>"; ?>
            </section>
            <section class="row">
                <?php
                    foreach ($movies as $movie){
                        $title = htmlspecialchars($movie['title'] ?? "Unknown Title");
                        $releaseDate = htmlspecialchars($movie['release_date'] ?? "N/A");
                        $posterPath = $movie['poster_path'] ?? null;
                        $imageURL = $posterPath ? "https://image.tmdb.org/t/p/w500" .
                         htmlspecialchars($posterPath) : "https://via.placeholder.com/100x500.png?text=No+Image";
                ?>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                    <?php
                        echo "<img class='movie-img' src='{$imageURL}' alt='{$title}'>'";
                        echo "<h3>{$title}</h3>";
                        echo "<p>{$releaseDate}</p>"
                    ?>
                    </div>
                        <?php
                    }
                        ?>
            </section>
            <?php
            // pagination links
            $prevPage = max(1, $page - 1);
            $nextpage = $page + 1;
            echo "<div>";
            if($page > 1){
                echo "<a href='?page={$prevPage}'>Previous</a>";
            }
            echo "<a href='?page={$nextpage}'>Next Page</a>";
            echo "</div>";
        }
    }
?>