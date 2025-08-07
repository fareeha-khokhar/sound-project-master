<?php
include "admin/build/components/connection.php";
if (isset($_SESSION['id'])) {
    echo "<script>
        alert('You\'re already logged in.');
        window.location.href = 'index.php';
    </script>";
    exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $check = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    $check->bind_param("sss", $email, $username, $hashedPassword);

    if ($check->execute()) {
        echo '<script>alert("Registration Successful! You can now log in.")</script>';
        header("Location: login.php");
        exit(); // always exit after header redirect
    } else {
        echo '<script>alert("Registration Failed! Please try again.")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sound Entertainment - Register</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>

    <!-- Header Area -->
    <?php include 'components/nav.php'; ?>

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <p>Join the music world</p>
            <h2>Register</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Register Area Start ##### -->
    <section class="login-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="login-content">
                        <h3>Create Your Account</h3>
                        <div class="login-form">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" name="email" id="email" required placeholder="Enter E-mail">
                                    <small id="emailHelp" class="form-text text-muted"><i class="fa fa-lock mr-2"></i>We'll never share your email with anyone else.</small>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" required placeholder="Enter Username">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" required placeholder="Password">
                                </div>
                                <button type="submit" name="submit" class="btn oneMusic-btn mt-30 border border-dark w-100">
                                    Register <i class="fa fa-angle-double-right"></i>
                                </button>
                                <p class="mt-1 text-center">
                                    Already have an account?
                                    <a href="login.php" class="text-danger font-weight-bold">Login</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Register Area End ##### -->


    <!-- ##### Footer Area Start ##### -->
    <?php include '<components/footer.php'; ?>
    <!-- ##### Footer Area Start ##### -->


    <!-- Scripts -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>
</body>

</html>