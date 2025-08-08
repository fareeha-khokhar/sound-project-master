<?php
include '../admin/build/components/connection.php';

$songs = []; // Always initialize array

$search = $_POST['ser'] ?? '';

if (!empty($search)) {
    $searchCheck = "%" . $search . "%"; // ✅ Correct LIKE pattern
    $sql = "SELECT id, title, artist, genre, release_year, media_type, media_path, language, thumbnail_path
            FROM media_library
            WHERE media_type = 'audio' AND title LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchCheck);
    $stmt->execute();
    $stmt->bind_result(
        $id, 
        $song_name, 
        $artist_name, 
        $genre, 
        $release_year, 
        $media_type, 
        $media_path, 
        $language, 
        $thumbnail_path
    );

    while ($stmt->fetch()) {
        $songs[] = [
            'id'            => $id,
            'song_name'     => $song_name,
            'artist_name'   => $artist_name,
            'genre'         => $genre,
            'release_year'  => $release_year,
            'media_type'    => $media_type,
            'media_path'    => $media_path,
            'language'      => $language,
            'thumbnail_path'=> $thumbnail_path
        ];
    }
    $stmt->close();
}

foreach ($songs as $song) {
    echo '<div class="col-12">
            <div class="single-song-area mb-30 d-flex flex-wrap align-items-end">
                <div class="song-thumbnail">
                    <img src="admin/' . htmlspecialchars($song['thumbnail_path']) . '" alt="">
                </div>
                <div class="song-play-area">
                    <div class="song-name d-flex justify-content-between">
                        <p>' . htmlspecialchars($song['id']) . '. ' . htmlspecialchars($song['song_name']) . '</p>
                        <p>By ' . htmlspecialchars($song['artist_name']) . '</p>
                        <p>In ' . htmlspecialchars($song['language']) . '</p>
                    </div>
                    <audio preload="auto" controls>
                        <source src="admin/' . htmlspecialchars($song['media_path']) . '">
                    </audio>
                </div>
            </div>
        </div>';
}
?> 