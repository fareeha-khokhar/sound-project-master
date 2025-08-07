<?php
include "admin/build/components/connection.php";
// if(isset($_SESSION['id'])){
//   header("location:index.php");
// }
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $text = $_POST['text'];
    $check = $conn->prepare("INSERT INTO feedback (email, message) VALUES (?, ?)");
    $check->bind_param("ss", $email, $text);

    if ($check->execute()) {
        echo '<script>
    alert("Your Feedback is Submitted");
    window.location.href = "event.php";
</script>';
        exit(); // always exit after header redirect
    } else {
        echo '<script>alert("Sending Failed! Please try again.")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sound Entertainment - Upcoming Events">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sound Entertainment</title>
    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <!-- favicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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

    <!-- Header -->
    <?php include 'components/nav.php'; ?>

    <!-- Breadcumb Area -->
    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <p>Up Coming</p>
            <h2>Events</h2>
        </div>
    </section>

    <!-- Events Section -->
    <section class="events-area section-padding-100">
        <div class="container">
            <div class="row">
                <?php
                $query = "SELECT * FROM upcoming_events ORDER BY event_date ASC";
                $result = $conn->query($query);

                if ($result->num_rows > 0):
                    while ($event = $result->fetch_assoc()):
                ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="single-event-area mb-30">
                                <div class="event-thumbnail">
                                    <img src="admin/<?= htmlspecialchars($event['image_path']) ?>" alt="Event Image" style="height: 350px !important;" class="img-fluid"> 
                                </div>
                                <div class="event-text">
                                    <h4><?= htmlspecialchars($event['title']) ?></h4>
                                    <div class="event-meta-data">
                                        <a href="#" class="event-place"><?= htmlspecialchars($event['venue']) ?></a>
                                        <a href="#" class="event-date mb-2"><?= date("F j, Y", strtotime($event['event_date'])) ?></a>
                                        <?php if (!empty($event['contact'])): ?>
                                            <br>
                                            <a href="tel:<?= htmlspecialchars($event['contact']) ?>" class="btn see-more-btn mt-2">Call Now</a>
                                        <?php else: ?>
                                            <a href="#" class="btn see-more-btn">See Event</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                else:
                    echo '<p class="text-center text-light">🚫 No upcoming events found.</p>';
                endif;
                ?>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="load-more-btn text-center mt-70">
                        <a href="albums-store.php" class="btn oneMusic-btn">Listen to our music <i class="fa fa-angle-double-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter & Testimonials -->
    <section class="newsletter-testimonials-area" id="feedback">
        <div class="container">
            <div class="row">

                <!-- Newsletter -->
                <div class="col-12 col-lg-6">
                    <div class="newsletter-area mb-100">
                        <div class="section-heading text-left mb-50">
                            <p>Leave your Feedback</p>
                            <h2>Say something you find nice</h2>
                        </div>
                        <div class="newsletter-form">
                            <form method="post">
                                <input type="search" name="email" id="newsletterSearch" placeholder="E-mail" class="p-3">
                                <input type="text" name="text" id="Message" placeholder="Message" class="p-3">
                                <button type="submit" name="submit" class="btn oneMusic-btn text-center">Send <i class="fa fa-angle-double-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- review -->
                <div class="col-12 col-lg-6 ">
                    <div class="testimonials-area mb-100 bg-img bg-overlay" style="background-image: url(img/bg-img/bg-3.jpg);">
                        <div class="section-heading white text-left mb-50 pt-5 pb-3">
                            <span class="h6 text-light">What Our Pookies Say</span>
                            <br>
                            <h2 class="h1">Feedback:</h2>
                        </div>
                        <div class="testimonials-slide owl-carousel pt-2">
                            <?php
                            $feedback_query = "SELECT * FROM feedback ORDER BY id DESC LIMIT 10";
                            $feedback_result = $conn->query($feedback_query);

                            if ($feedback_result && $feedback_result->num_rows > 0):
                                while ($row = $feedback_result->fetch_assoc()):
                                    $email = htmlspecialchars($row['email']);
                                    $message = htmlspecialchars($row['message']);
                                    $name = explode('@', $email)[0]; // Use name from email before '@'
                            ?>
                                    <div class="single-slide pb-5">
                                        <p>“<?= $message ?>”</p>
                                        <div class="testimonial-info d-flex align-items-center">
                                            <p><i class="fas fa-user fa-lg me-2 pb-1"></i></p>
                                            <p> <?= ucfirst($name) ?>, User</p>
                                        </div>
                                    </div>
                            <?php
                                endwhile;
                            else:
                                echo "<p class='text-light text-center'>No reviews yet.</p>";
                            endif;
                            ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- Scripts -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>
</body>

</html>