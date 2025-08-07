<?php
include 'admin/build/components/connection.php'; // Your DB connection

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID

    $stmt = $conn->prepare("SELECT title, artist, genre, release_year, media_type, media_path, created_at, description, thumbnail_path FROM media_library WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($title, $artist, $genre, $release_year, $media_type, $media_path, $created_at, $description, $thumbnail_path);
        $stmt->fetch();
    } else {
        echo "<div class='alert alert-danger'>Video not found.</div>";
        exit;
    }

    $stmt->close();
} else {
    echo "<div class='alert alert-warning'>No video ID specified.</div>";
    exit;
}

?>
<?php
// Fetch latest videos excluding current one
$side_stmt = $conn->prepare("SELECT id, title, artist, thumbnail_path FROM media_library WHERE media_type = 'video' AND id != ? ORDER BY id DESC LIMIT 5");
$side_stmt->bind_param("i", $id); // $id is already available from above
$side_stmt->execute();
$side_stmt->bind_result($sid, $stitle, $sartist, $sthumb);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sound Entertainment - MV player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background-color: #181818;
            color: #fff;
        }

        .video-container {
            position: relative;

        }

        video {
            width: 100%;
            border-radius: 10px;
            height: 80vh;
        }

        .controls {
            position: absolute;
            bottom: 10px;
            left: 10px;
            display: flex;
            gap: 10px;
        }

        .control-btn {
            background: rgba(0, 0, 0, 0.6);
            border: none;
            color: white;
            padding: 6px 10px;
            border-radius: 50%;
            cursor: pointer;
        }

        .comment-box {
            background: #202020;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
        }


        .sidebar-video-title {
            font-size: 14px;
            color: #fff;
            margin-top: 5px;
        }

        .channel-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .channel-info img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        #fullDesc {
            display: none;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <!-- Header Area -->
    <?php include 'components/nav.php'; ?>
    <!-- Header Area End -->
    <div class="mt-5 mb-5 pt-1">

    </div>

    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Main Video Section -->
            <div class="col-lg-12 ">
                <div class="video-container p-3">
                    <video id="mainVideo" poster="admin/<?= htmlspecialchars($thumbnail_path) ?>" controls>
                        <source src="admin/<?= htmlspecialchars($media_path) ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <span class="mt-2 h1"><?= htmlspecialchars($title) ?> | <?= htmlspecialchars($artist) ?></span><br>
                <span><?= htmlspecialchars($genre) ?> • <?= htmlspecialchars($release_year) ?> • <?= date("F j, Y", strtotime($created_at)) ?></span>


                <!-- Channel Info -->
                <div class="channel-info mb-3">
                    <img src="admin/<?= htmlspecialchars($thumbnail_path) ?>" alt="Channel Icon">
                    <div>
                        <strong><?= htmlspecialchars($artist) ?></strong><br>
                        <small>Music Video</small>
                    </div>

                    <button class="btn btn-danger btn-sm ms-auto me-5"><a href="event.php#feedback">Leave Feedback</a></button>
                </div>

                <!-- Short Description -->
                <div id="shortDesc">
                    <p class="text-white">
                        😀 Must Leave a Feedback! <br>
                    Name your Fav Track if it isn't avaible on Sound Entertainment. <br>
                    </p>
                    <span style="cursor:pointer;color:#3ea6ff;" onclick="showFullDesc()">...more</span>
                </div>
                <div id="fullDesc">
                    <p>
                        <a href="login.php" class="text-white text-decoration-none">😀 Login TO Stay Vibin' </a><br>
                    <a href="event.php" class="text-white text-decoration-none">📌 WE Also Host Event Grab Your Tickets For Upcoming Event.</a>
                    </p>
                </div>

            </div>


            <!-- more Videos -->
            <div class="col-lg-12 p-5">
                <span class="h2 mb-4">Vibe ON Hit MV's</span>

                <?php while ($side_stmt->fetch()): ?>
                    <div class="sidebar-video d-flex mb-3 mt-4">
                        <a href="mvplayer.php?id=<?= $sid ?>">
                            <img src="admin/<?= htmlspecialchars($sthumb) ?>" alt="thumbnail" style="width: 200px !important;">
                        </a>
                        <div class="ms-2 flex-grow-1">
                            <a href="mvplayer.php?id=<?= $sid ?>" class="text-decoration-none text-white">
                                <div class="sidebar-video-title pe-5">
                                    <h4 class="text-light"><?= htmlspecialchars($stitle) ?></h4>
                                </div>
                                <p class="text-muted"><?= htmlspecialchars($sartist) ?></p>
                            </a>
                        </div>
                        <div class="dropdown">
                            <a href="event.php#feedback" class="btn btn-sm text-white">
                                <i class="fa fa-ellipsis-vertical"></i>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>

            </div>

        </div>
    </div>
    <!-- ##### Footer Area Start ##### -->
    <?php include '<components/footer.php'; ?>
    <!-- ##### Footer Area Start ##### -->

    <script>
        // Play/Pause button
        const video = document.getElementById("mainVideo");
        const playBtn = document.getElementById("playPause");
        playBtn.addEventListener("click", () => {
            if (video.paused) {
                video.play();
                playBtn.innerHTML = '<i class="fa fa-pause"></i>';
            } else {
                video.pause();
                playBtn.innerHTML = '<i class="fa fa-play"></i>';
            }
        });

        function showFullDesc() {
            document.getElementById("fullDesc").style.display = "block";
            document.getElementById("shortDesc").style.display = "none";
        }
    </script>

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