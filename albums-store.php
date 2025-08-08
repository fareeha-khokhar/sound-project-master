<?php
include 'admin/build/components/connection.php'; // Your DB connection
?>

<?php
// Initialize array
$songs = [];

// Fetch all songs
$stmt = $conn->prepare("
    SELECT id, title, artist, genre, release_year, media_type, media_path, language, description, thumbnail_path
    FROM media_library
    WHERE media_type = 'audio'
    ORDER BY id DESC
");
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
    $lyrics, 
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
        'lyrics'        => $lyrics,
        'thumbnail_path'=> $thumbnail_path
    ];
}

$stmt->close();
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

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<style>
    .navbar-custom {
        background: linear-gradient(to right, #010809, #000809, #060517, #2E1531);
        border-bottom: 1px solid #222;
    }

    .search-container {
        display: flex;
        border: 1px solid #b1b1b133;
        border-radius: 20px;
        overflow: hidden;
        background-color: #262626;
        height: 40px;
        flex: 1;
    }

    .search-container input {
        flex: 1;
        padding: 0 25px;
        background: transparent;
        border: none;
        color: white;
        font-size: 14px;
        outline: none;
    }

    .search-btn {
        background-color: #222;
        border: none;
        padding: 0 16px;
        color: white;
        cursor: pointer;
    }

    .search-btn i {
        font-size: 16px;
    }

    .mic-btn {
        margin-left: 12px;
        background-color: #222;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .profile {
        background-color: purple;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-left: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
</style>

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
        <!-- <div class="bradcumbContent pb-5">
            <p>See what’s new</p>
            <h2>Latest Songs</h2>
        </div> -->
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Search Area Start ##### -->
    <div class="navbar-custom py-2 px-5 ">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 d-flex align-items-center">
                    <div class="search-container w-100">
                        <input type="text" id="search" name="search" placeholder="Search..." />
                        <button class="search-btn"><i class="fas fa-search"></i></button>
                    </div>
                    <a class="mic-btn btn" href="event.php#feedback"><i class="fas fa-heart-o"></i></a>
                </div>

                <div class="col-md-4 d-flex justify-content-end align-items-center mt-2 mt-md-0">
                    <div class="profile  me-2">F</div>
                    <i class="fas fa-user text-white"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Search Area end ##### -->

    <!-- ##### Song Area Start ##### -->
    <div class="one-music-songs-area mb-70 mt-30">
        <div class="container">
            <div class="text-center mb-30">
                <p>See what’s new</p>
                <h1>Latest Songs</h1>
            </div>
            <div class="row" id="videoContainer">
                <!-- Single Song Area -->
                <?php foreach ($songs as $song) { ?>
                    <div class="col-12">
                        <div class="single-song-area mb-30 d-flex flex-wrap align-items-end">
                            <div class="song-thumbnail">
                                <img src="admin/<?php echo htmlspecialchars($song['thumbnail_path']); ?>" alt="">
                            </div>
                            <div class="song-play-area">
                                <div class="song-name d-flex justify-content-between">
                                    <p><?php echo htmlspecialchars($song['id']); ?>. <?php echo htmlspecialchars($song['song_name']); ?></p>
                                    <p>By <?php echo htmlspecialchars($song['artist_name']); ?></p>
                                    <p>In <?php echo htmlspecialchars($song['language']); ?></p>
                                </div>
                                <audio preload="auto" controls>
                                    <source src="admin/<?php echo htmlspecialchars($song['media_path']); ?>">
                                </audio>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var search = $("#search").val();
                $.ajax({
                    url: 'ajax/searchByName.php',
                    type: 'post',
                    data: {
                        "ser": search
                    },
                    success: function(data) {
                        $('#videoContainer').html(data);
                    }
                });
            });
        });
    </script>
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
    <!-- AJAX Script -->
</body>

</html>