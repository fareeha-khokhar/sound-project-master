<?php
include 'admin/build/components/connection.php'; // Your DB connection
?>

<?php

// Fetch all songs
$stmt = $conn->prepare("SELECT id, title, artist, genre, release_year, media_type, created_at, description, thumbnail_path FROM media_library WHERE media_type = 'video' ORDER BY id DESC");
$stmt->execute();
$stmt->bind_result($id, $song_name, $artist_name, $genre, $release_year, $media_type, $time, $lyrics, $thumbnail_path);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sound Entertainment - MV</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        body {
            margin: 0;
            background-color: #0f0f0f;
            font-family: 'Roboto', sans-serif;
            color: white;
        }

        .navbar-custom {
            background-color: #0f0f0f;
            border-bottom: 1px solid #222;
        }

        .search-container {
            display: flex;
            border: 1px solid #333;
            border-radius: 20px;
            overflow: hidden;
            background-color: #121212;
            height: 40px;
            flex: 1;
        }

        .search-container input {
            flex: 1;
            padding: 0 12px;
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

        .categories {
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            background-color: #0f0f0f;
            border-bottom: 1px solid #222;
        }

        .categories button {
            background-color: #272727;
            color: white;
            border: none;
            padding: 8px 16px;
            margin-right: 8px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .categories button.active {
            background-color: white;
            color: black;
        }

        .video-card {
            background-color: #0f0f0f;
        }

        .video-card img {
            width: 100%;
            border-radius: 10px;
            background-color: #333;
        }

        .video-info {
            display: flex;
            margin-top: 10px;
        }

        .channel-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #444;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .channel-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-details h4 {
            margin: 0;
            font-size: 15px;
            color: white;
        }

        .video-details p {
            margin: 2px 0;
            font-size: 13px;
            color: #aaa;
        }

        ::-webkit-scrollbar {
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0f0f0f;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <?php include 'components/nav.php'; ?>

    <div class="mt-5 mb-5 pt-1"></div>

    <!-- Custom Navbar -->
    <div class="navbar-custom py-2 px-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 d-flex align-items-center">
                    <div class="search-container w-100">
                        <input type="text" placeholder="Search" />
                        <button class="search-btn"><i class="fas fa-search"></i></button>
                    </div>
                    <button class="mic-btn"><i class="fas fa-microphone"></i></button>
                </div>

                <div class="col-md-4 d-flex justify-content-end align-items-center mt-2 mt-md-0">
                    <i class="fas fa-bell me-3"></i>
                    <div class="profile">F</div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid pt-3">
        <div class="row">
            <?php while ($stmt->fetch()): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="mvplayer.php?id=<?= $id ?>" style="text-decoration: none; color: inherit;">
                        <div class="video-card">
                            <img src="admin/<?= htmlspecialchars($thumbnail_path) ?>" alt="Video Thumbnail" style="height: 230px !important;" />
                            <div class="video-info">
                                <div class="channel-icon">
                                    <img src="admin/<?= htmlspecialchars($thumbnail_path) ?>" alt="Channel Icon">
                                </div>
                                <div class="video-details">
                                    <h4><?= htmlspecialchars($song_name) ?> | <?= htmlspecialchars($artist_name) ?></h4>
                                    <p><?= htmlspecialchars($genre) ?> • <?= htmlspecialchars($release_year) ?> • <?= htmlspecialchars($time) ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- ##### Footer Area Start ##### -->
    <?php include '<components/footer.php'; ?>
    <!-- ##### Footer Area Start ##### -->

    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
</body>

</html>