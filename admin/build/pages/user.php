<?php
include '../components/connection.php'; // Your DB connection
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit(); // Important to stop script execution after redirect
}
?>

<?php

// Fetch all songs
$stmt = $conn->prepare("SELECT user_id, username, email, role, created_at FROM users ORDER BY user_id DESC");
$stmt->execute();
$stmt->bind_result($id, $username, $email, $role, $signup_date );

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../../../img/core-img/favicon.ico" />
  <title>Soft UI Dashboard Tailwind</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Main Styling -->
  <link href="../assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5" rel="stylesheet" />

  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">

  <!-- sidebar start -->
  <?php include '../components/sidebar.php' ?>
  <!-- sidebar end -->

  <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
    <!-- navbar start -->
    <?php include '../components/navbar.php' ?>
    <!-- navbar end -->


    <div class="w-full px-6 py-6 mx-auto">
      <!-- table 1 -->



      <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
          <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
              <div class="p-0 overflow-x-auto">
                <!-- Table UI -->
                <h6 class="text-xl font-bold mb-4 px-6 pt-6">All Users</h6>
                <div class="overflow-x-auto px-6 pb-6">
                  <table class="w-full text-sm text-left text-slate-500 border border-slate-200 rounded-xl">
                    <thead class="text-xs uppercase bg-slate-100 text-slate-600">
                      <tr>
                        <th class="px-4 py-3">Id</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Signup Date | Time </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($stmt->fetch()): ?>
                        <tr class="border-t">
                            
                          <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($id) ?></td>
                          <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($username) ?></td>
                          <td class="px-4 py-3"><?= htmlspecialchars($email) ?></td>
                          <td class="px-4 py-3"><?= htmlspecialchars($role) ?></td>
                          <td class="px-4 py-3"><?= htmlspecialchars($signup_date) ?></td>
                          
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>

                <?php
                $stmt->close();
                $conn->close();
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- footer start -->
      <?php include '../components/footer.php' ?>
      <!-- footer end -->
    </div>
  </main>

</body>
<!-- plugin for scrollbar  -->
<script src="../assets/js/plugins/perfect-scrollbar.min.js" async></script>
<!-- github button -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- main script file  -->
<script src="../assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5" async></script>

</html>