<?php
if (isset($_POST['query'])) {
    $query = strtolower(trim($_POST['query']));
    $songs = [
        ["title" => "Midnight City", "artist" => "M83", "album" => "Hurry Up...", "duration" => "4:04"],
        ["title" => "See You Again", "artist" => "Charlie Puth", "album" => "Furious 7", "duration" => "3:49"],
        ["title" => "On Melancholy Hill", "artist" => "Gorillaz", "album" => "Plastic Beach", "duration" => "3:53"],
    ];

    $results = "";
    foreach ($songs as $index => $song) {
        if (strpos(strtolower($song['title']), $query) !== false || strpos(strtolower($song['artist']), $query) !== false) {
            $results .= "
            <div class='d-flex align-items-center mb-3'>
              <img src='img/cover/see you again.jpg' width='50' class='me-2'>
              <div>
                <strong>{$song['title']}</strong><br>
                <small>{$song['artist']}</small>
              </div>
            </div>";
        }
    }
    echo $results ?: "<p>No results found.</p>";
}
?>
