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
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $check = $conn->prepare("select user_id, username, password, role from users where username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();
    if ($check->num_rows == 1) {
        $check->bind_result($id, $uname, $storedPassword, $role);
        $check->fetch();
        if (password_verify($password, $storedPassword)) {
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $uname;
            $_SESSION['role'] = $role;
            if ($role === "admin") {
                header("location: admin/build/pages/dashboard.php");
                exit;
            } else {
                header("location: index.php");
                exit;
            }
            header("location: admin/build/index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Invalid password</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>User not found </div>";
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
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Sound Entertainment- Login</title>

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
        <div class="bradcumbContent">
            <p>See what’s new</p>
            <h2>Login</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Login Area Start ##### -->
    <section class="login-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="login-content">
                        <h3>Welcome Back</h3>
                        <!-- Login Form -->
                        <div class="login-form">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input type="username" class="form-control" id="exampleInputEmail1" name="username" aria-describedby="emailHelp" placeholder="Enter username" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" required>
                                    <small id="emailHelp" class="form-text text-muted">
                                        <i class="fa fa-lock mr-2"></i>We'll never share your password with anyone else.
                                    </small>
                                </div>
                                <button type="submit" name="submit" class="btn oneMusic-btn mt-30 border border-dark w-100">
                                    Login <i class="fa fa-angle-double-right"></i>
                                </button>
                                <!-- Register Link -->
                                <p class="mt-1 text-center">
                                    Don't have an account?
                                    <a href="register.php" class="text-danger font-weight-bold">Register now</a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Login Area End ##### -->
    <?php
    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Collect form data safely
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Validate inputs (basic)
        if (!empty($email) && !empty($password)) {
            // Prepare SQL to prevent SQL injection
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Password matches
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "All fields are required.";
        }
    }
    ?>
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