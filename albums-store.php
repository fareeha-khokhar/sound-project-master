<?php
include 'admin/build/components/connection.php'; // Your DB connection
?>

<?php

// Fetch all songs
$stmt = $conn->prepare("SELECT id, title, artist, genre, release_year, media_type,media_path, language, description, thumbnail_path FROM media_library WHERE media_type = 'audio' ORDER BY id DESC");
$stmt->execute();
$stmt->bind_result($id, $song_name, $artist_name, $genre, $release_year, $media_type, $media_path, $language, $lyrics, $thumbnail_path);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Sound Entertainment</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- Header Area -->
    <?php include 'components/nav.php'; ?>
    <!-- Header Area End -->


    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent pb-5">
            <p>See what’s new</p>
            <h2>Latest Songs</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    
    <!-- ##### Song Area Start ##### -->
    <div class="one-music-songs-area mb-70 mt-100">
        <div class="container">
            <div class="row">
                
                <!-- Single Song Area -->
                <?php while ($stmt->fetch()): ?>
                    <div class="col-12">
                        <div class="single-song-area mb-30 d-flex flex-wrap align-items-end">
                        <div class="song-thumbnail">
                            <img src="admin/<?= htmlspecialchars($thumbnail_path) ?>" alt="">
                        </div>
                        <div class="song-play-area">
                            <div class="song-name d-flex justify-content-between">
                                <p><?= htmlspecialchars($id) ?>. <?= htmlspecialchars($song_name) ?></p>
                                <p>By <?= htmlspecialchars($artist_name) ?></p>
                                <p>In <?= htmlspecialchars($language) ?></p>
                            </div>
                            <audio preload="auto" controls>
                                <source src="admin/<?= htmlspecialchars($media_path) ?>">
                            </audio>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                
                
            </div>
        </div>
    </div>
    <!-- ##### Song Area End ##### -->
    
    
    <!-- ##### Add Area Start ##### -->
    <div class="add-area mb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="adds">
                        <a href="#"><img src="img/bg-img/add3.gif" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Add Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <?php include '<components/footer.php'; ?>
    <!-- ##### Footer Area Start ##### -->


    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
</body>

</html>