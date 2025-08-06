<?php
include 'admin/build/components/connection.php';

$para1 = $para2 = $para3 = $mission = $vision = $value = '';
$result = $conn->query("SELECT * FROM about_page ORDER BY id DESC LIMIT 1");

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $para1 = $row['para1'];
    $para2 = $row['para2'];
    $para3 = $row['para3'];
    $mission = $row['mission'];
    $vision = $row['vision'];
    $value  = $row['value'];
}
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

    <style>
        #aboutimg {
            border-radius: 12px;
            position: relative;
            animation: pulseGlow 2s infinite ease-in-out;
            box-shadow: 0 0 10px #ff00ff, 0 0 20px #ff00ff, 0 0 30px #ff00ff;
            transition: 0.3s ease-in-out;
        }

        /* Glowing pulse effect */
        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 5px #ff00ff, 0 0 10px #ff00ff, 0 0 15px #ff00ff;
            }

            50% {
                box-shadow: 0 0 20px #ff00ff, 0 0 30px #ff00ff, 0 0 40px #ff00ff;
            }

            100% {
                box-shadow: 0 0 5px #ff00ff, 0 0 10px #ff00ff, 0 0 15px #ff00ff;
            }
        }

        .about-icon {
            background: linear-gradient(45deg, #B60B68, #41157F);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            font-size: 70px;
        }
    </style>
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
        <div class="bradcumbContent">
            <p>Get to Know Us</p>
            <h2 class="mb-1">About Sound </h2>
            <h2>Entertainment</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->
    <!-- ##### About Area Start ##### -->
<section class="about-area section-padding-100">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 col-lg-5">
                <img src="img/bg-img/a9.jpg" alt="About Sound Entertainment" id="aboutimg" class="img-fluid rounded shadow" width="90%">
            </div>
            <div class="col-12 col-lg-7">
                <p><?= htmlspecialchars($para1) ?></p><br>
                <p><?= htmlspecialchars($para2) ?></p><br>
                <p><?= htmlspecialchars($para3) ?></p>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm h-100">
                    <i class="fa fa-music fa-2x mb-2 about-icon"></i>
                    <h5>Our Mission</h5>
                    <p><?= htmlspecialchars($mission) ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm h-100">
                    <i class="fa fa-bullseye fa-2x mb-2 about-icon"></i>
                    <h5>Our Vision</h5>
                    <p><?= htmlspecialchars($vision) ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm h-100">
                    <i class="fa fa-users fa-2x mb-2 about-icon"></i>
                    <h5>Our Values</h5>
                    <p><?= htmlspecialchars($value) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### About Area End ##### -->


    <!-- ##### Blog Area Start ##### -->
<div class="blog-area section-padding-100">
    <div class="container">
        <div class="row">
            <!-- Main Blog Content -->
            <div class="col-12 col-lg-9">

                <!-- Blog Post -->
                <div class="single-blog-post mb-100 wow fadeInUp" data-wow-delay="100ms">
                    <div class="blog-post-thumb mt-20 position-relative">
                        <a href="#"><img src="img/bg-img/blog1.jpg" alt="Festival Highlights"></a>
                        <div class="post-date text-white bg-danger text-center px-2 py-1 position-absolute top-0 start-0">
                            <span class="d-block fs-4">28</span>
                            <small>July '25</small>
                        </div>
                    </div>
                    <div class="blog-content">
                        <a href="#" class="post-title fs-3 fw-bold text-dark">🎉 Top 5 Summer Music Festivals You Can’t Miss</a>
                        <div class="post-meta d-flex gap-3 mb-3 mt-2">
                            <p class="post-author text-muted">By <a href="#" class="text-decoration-none">Sound Team</a></p>
                            <p class="tags text-muted">in <a href="#" class="text-decoration-none">Festivals</a></p>
                            <p class="tags text-muted"><a href="#" class="text-decoration-none"></a></p>
                        </div>
                        <p>From Coachella vibes to Tomorrowland beats, dive into the biggest and most unforgettable music festivals happening this summer.</p>
                    </div>
                </div>

                <!-- Blog Post -->
                <div class="single-blog-post mb-100 wow fadeInUp" data-wow-delay="200ms">
                    <div class="blog-post-thumb mt-20 position-relative">
                        <a href="#"><img src="img/bg-img/blog2.jpg" alt="New Artist Drop"></a>
                        <div class="post-date text-white bg-danger text-center px-2 py-1 position-absolute top-0 start-0">
                            <span class="d-block fs-4">21</span>
                            <small>July '25</small>
                        </div>
                    </div>
                    <div class="blog-content">
                        <a href="#" class="post-title fs-3 fw-bold text-dark">🎤 Rising Stars: 3 New Artists Dropping Fire Tracks</a>
                        <div class="post-meta d-flex gap-3 mb-3 mt-2">
                            <p class="post-author text-muted">By <a href="#" class="text-decoration-none">Admin</a></p>
                            <p class="tags text-muted">in <a href="#" class="text-decoration-none">New Artists</a></p>
                            <p class="tags text-muted"><a href="#" class="text-decoration-none"></a></p>
                        </div>
                        <p>Get to know the breakthrough performers shaking up the charts and setting the stage on fire this season.</p>
                    </div>
                </div>

            </div>

            <!-- Sidebar Widgets -->
            <div class="col-12 col-lg-3">
                <div class="blog-sidebar-area">

                    <!-- Categories -->
                    <div class="single-widget-area mb-30">
                        <div class="widget-title">
                            <h5>Categories</h5>
                        </div>
                        <div class="widget-content">
                            <ul>
                                <li><a href="#">🎶 Music News</a></li>
                                <li><a href="#">🎤 Artist Spotlights</a></li>
                                <li><a href="#">🎧 New Releases</a></li>
                                <li><a href="#">📅 Events</a></li>
                                <li><a href="#">📰 Press</a></li>
                                <li><a href="#">🎧 Concert</a></li>
                            </ul>
                        </div>
                    </div>


                    <!-- Tags -->
                    <div class="single-widget-area mb-30">
                        <div class="widget-title">
                            <h5>Trending Tags</h5>
                        </div>
                        <div class="widget-content">
                            <ul class="tags">
                                <li><a href="#">#music</a></li>
                                <li><a href="#">#live</a></li>
                                <li><a href="#">#behindthescenes</a></li>
                                <li><a href="#">#artistspotlight</a></li>
                                <li><a href="#">#newdrops</a></li>
                                <li><a href="#">#video</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Ads -->
                    <div class="single-widget-area mb-50">
                        <a href="#"><img src="img/bg-img/add.gif" alt="Ad Banner"></a>
                    </div>
                    <div class="single-widget-area mt-50">
                        <a href="#"><img src="img/bg-img/add2.gif" alt="Ad Banner 2"></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Blog Area End ##### -->


    <!-- ##### Contact Area Start ##### -->
    <section class="contact-area section-padding-100 bg-img bg-overlay bg-fixed has-bg-img" style="background-image: url(img/bg-img/bg-2.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading white">
                        <p>See what’s new</p>
                        <h2>Get In Touch</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <!-- Contact Form Area -->
                    <div class="contact-form-area">
                        <form action="#" method="post">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" placeholder="E-mail">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="subject" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn oneMusic-btn mt-30" type="submit">Send <i class="fa fa-angle-double-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Contact Area End ##### -->

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