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

        .dropdown-menu {
            background-color: #411b1bff;
            color: white;
        }

        .dropdown-item:hover {
            background-color: #333;
        }

        .comment-box {
            background: #202020;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .sidebar-video img {
            border-radius: 8px;
            width: 30%;
            height: 100px;
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

        #commentInput {
            background: #202020;
            border: none;
            color: #fff;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
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
                    <video id="mainVideo" poster="https://via.placeholder.com/800x400" controls>
                        <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                    </video>
                    <!-- <div class="controls">
                        <button class="control-btn" id="playPause"><i class="fa fa-play"></i></button>
                        <div class="dropdown">

                        </div>
                    </div> -->
                </div>

                <span class="mt-2 h1">THIS WAS MY WORST IDEA EVER 😭</span><br>
                <span>17,303 views • 1 hour ago</span>

                <!-- Channel Info -->
                <div class="channel-info mb-3">
                    <img src="img/bg-img/a2.jpg" alt="Channel Icon">
                    <div>
                        <strong>Denitslava </strong><br>
                        <small>8.09M subscribers</small>
                    </div>
                    <button class="btn btn-danger btn-sm ms-auto me-5">Subscribe</button>
                </div>

                <!-- Short Description -->
                <div id="shortDesc">
                    😀 Subscribe to my channel! <br>
                    🎮 DO MY MAKEUP video/game: link <br>
                    <span style="cursor:pointer;color:#3ea6ff;" onclick="showFullDesc()">...more</span>
                </div>
                <div id="fullDesc">
                    😀 Subscribe to my channel! http://bit.ly/2hjbrRN<br>
                    🎮 DO MY MAKEUP video/game: https://goo.gl/Okennf<br>
                    📌 Check out my SECOND Channel: https://goo.gl/WJCHNy
                </div>

            </div>
            <div class="col-lg-8">
                <!-- Comment Input -->
                <div class="mt-3 mb-3">
                    <input type="text" id="commentInput" placeholder="Add a comment...">

                </div>

                <!-- Comments -->
                <span class="mt-3 h2">Comments</span>
                <div class="comment-box mt-3"><strong>User1:</strong> Finally, Deni is BACKKK ❤️</div>
                <div class="comment-box"><strong>User2:</strong> HOW DARE YOUTUBE HIDE THIS FROM ME! ❤️</div>
                <div class="comment-box"><strong>User3:</strong> Your humor is always the best, Deni!</div>
            </div>

            <!-- Sidebar Videos -->
            <div class="col-lg-4">
                <span class="h2 mb-5">Vibe ON Hit MV's</span>
                <div class="sidebar-video d-flex mb-3 mt-3">
                    <img src="img/cover/images.jpg" alt="thumbnail">
                    <div class="ms-2 flex-grow-1">
                        <div class="sidebar-video-title">Video 1</div>
                        <small class="text-muted">6.5M views</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm text-white" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-vertical"></i></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Add to queue</a></li>
                            <li><a class="dropdown-item" href="#">Save to playlist</a></li>
                            <li><a class="dropdown-item" href="#">Download</a></li>
                        </ul>
                    </div>
                </div>

                <div class="sidebar-video d-flex mb-3">
                    <img src="img/cover/images.jpg" alt="thumbnail">
                    <div class="ms-2 flex-grow-1">
                        <div class="sidebar-video-title">Video 2</div>
                        <small class="text-muted">3.2M views</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm text-white" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-vertical"></i></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Add to queue</a></li>
                            <li><a class="dropdown-item" href="#">Save to playlist</a></li>
                            <li><a class="dropdown-item" href="#">Download</a></li>
                        </ul>
                    </div>
                </div>

                <div class="sidebar-video d-flex mb-3">
                    <img src="img/cover/images.jpg" alt="thumbnail">
                    <div class="ms-2 flex-grow-1">
                        <div class="sidebar-video-title">Video 3</div>
                        <small class="text-muted">1.1M views</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm text-white" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-vertical"></i></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Add to queue</a></li>
                            <li><a class="dropdown-item" href="#">Save to playlist</a></li>
                            <li><a class="dropdown-item" href="#">Download</a></li>
                        </ul>
                    </div>
                </div>
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