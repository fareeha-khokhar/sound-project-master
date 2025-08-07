 <?php
 include '../components/connection.php';
 if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit(); // Important to stop script execution after redirect
}
$songCountQuery = "SELECT COUNT(*) FROM media_library WHERE media_type = 'audio'";
$songCountResult = $conn->query($songCountQuery);
$totalSongs = 0;

if ($songCountResult && $row = $songCountResult->fetch_row()) {
    $totalSongs = $row[0];
}
?>
<?php
$video_count = 0;

$query = "SELECT COUNT(*) FROM media_library WHERE media_type = 'video'";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_array($result);
    $video_count = $row[0];
}
?>
<?php
$feedbackCount = 0;
$feedbackQuery = $conn->query("SELECT COUNT(*) AS total FROM feedback");
if ($feedbackQuery && $row = $feedbackQuery->fetch_assoc()) {
    $feedbackCount = $row['total'];
}
?>
<?php
$totalUsers = 0;
$userCountQuery = $conn->query("SELECT COUNT(*) AS total FROM users");
if ($userCountQuery && $row = $userCountQuery->fetch_assoc()) {
    $totalUsers = $row['total'];
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="apple-touch-icon"
    sizes="76x76"
    href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../../../img/core-img/favicon.ico" />
  <title>Soft UI Dashboard Tailwind</title>
  <!--     Fonts and icons     -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
    rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script
    src="https://kit.fontawesome.com/42d5adcbca.js"
    crossorigin="anonymous"></script>
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Popper -->
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <!-- Main Styling -->
  <link
    href="../assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5"
    rel="stylesheet" />

  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script
    defer
    data-site="YOUR_DOMAIN_HERE"
    src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body
  class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
  <!-- sidebar start -->
  <?php include '../components/sidebar.php' ?>
  <!-- sidebar end -->

  <main
    class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
    <!-- navbar start -->
    <?php include '../components/navbar.php' ?>
    <!-- navbar end -->

    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
      <!-- row 1 -->
      <div class="flex flex-wrap -mx-3">
       <!-- card1: Total Songs Uploaded -->
<div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="flex-auto p-4">
      <div class="flex flex-row -mx-3">
        <div class="flex-none w-2/3 max-w-full px-3">
          <div>
            <p class="mb-0 font-sans font-semibold leading-normal text-sm">
              Total Songs
            </p>
            <h5 class="mb-0 font-bold">
              <?= $totalSongs ?>
              <span class="leading-normal text-sm font-weight-bolder text-lime-500">+12 Today</span>
            </h5>
          </div>
        </div>
        <div class="px-3 text-right basis-1/3">
          <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
            <i class="ni ni-note-03 leading-none text-lg relative top-3.5 text-white"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Card 2: Registered Users -->
<div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="flex-auto p-4">
      <div class="flex flex-row -mx-3">
        <div class="flex-none w-2/3 max-w-full px-3">
          <p class="mb-0 font-sans font-semibold leading-normal text-sm">Registered Users</p>
          <h5 class="mb-0 font-bold">
            <?= $totalUsers ?>
            <span class="leading-normal text-sm font-weight-bolder text-lime-500">+12%</span>
          </h5>
        </div>
        <div class="px-3 text-right basis-1/3">
          <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
            <i class="ni ni-single-02 leading-none text-lg relative top-3.5 text-white"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Card 3: Reviews Submitted -->
<div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="flex-auto p-4">
      <div class="flex flex-row -mx-3">
        <div class="flex-none w-2/3 max-w-full px-3">
          <p class="mb-0 font-sans font-semibold leading-normal text-sm">Reviews Submitted</p>
          <h5 class="mb-0 font-bold">
            <?= $feedbackCount ?>
            <span class="leading-normal text-red-600 text-sm font-weight-bolder">-4%</span>
          </h5>
        </div>
        <div class="px-3 text-right basis-1/3">
          <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
            <i class="ni ni-chat-round leading-none text-lg relative top-3.5 text-white"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Card 4: Total Videos -->
<div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="flex-auto p-4">
      <div class="flex flex-row -mx-3">
        <div class="flex-none w-2/3 max-w-full px-3">
          <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Videos</p>
          <h5 class="mb-0 font-bold">
            <?= $video_count ?>
            <span class="leading-normal text-sm font-weight-bolder text-lime-500">+6%</span>
          </h5>
        </div>
        <div class="px-3 text-right basis-1/3">
          <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
            <i class="ni ni-button-play leading-none text-lg relative top-3.5 text-white"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


     <!-- cards row 2 -->
<div class="flex flex-wrap mt-6 -mx-3">
  <div class="w-full px-3 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="flex-auto p-4">
        <div class="flex flex-wrap -mx-3">
          <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
            <div class="flex flex-col h-full">
              <p class="pt-2 mb-1 font-semibold">Designed for creators</p>
              <h5 class="font-bold">Sound Entertainment Dashboard</h5>
              <p class="mb-12">
                Manage your tracks, upload new media, explore user feedback, and monitor performance — all in one place built for music and video professionals.
              </p>
              <a class="mt-auto mb-0 font-semibold leading-normal text-sm group text-slate-500" href="addmv.php">
                Explore Features
                <i class="fas fa-arrow-right ease-bounce text-sm group-hover:translate-x-1.25 ml-1 leading-normal transition-all duration-200"></i>
              </a>
            </div>
          </div>
          <div class="max-w-full px-3 mt-12 ml-auto text-center lg:mt-0 lg:w-5/12 lg:flex-none">
            <div class="h-full bg-gradient-to-tl from-purple-700 to-pink-500 rounded-xl">
              <img src="../assets/img/shapes/waves-white.svg" class="absolute top-0 hidden w-1/2 h-full lg:block" alt="waves" />
              <div class="relative flex items-center justify-center h-full">
                <img class="relative z-20 w-full pt-6" src="../assets/img/illustrations/rocket-white.png" alt="rocket" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
    <div class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border p-4">
      <div class="relative h-full overflow-hidden bg-cover rounded-xl" style="background-image: url('../assets/img/ivancik.jpg')">
        <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 opacity-80"></span>
        <div class="relative z-10 flex flex-col flex-auto h-full p-4">
          <h5 class="pt-2 mb-6 font-bold text-white">
            Power Your Creative Journey
          </h5>
          <p class="text-white">
            Take control of your content — publish music, manage videos, and connect with your audience on a platform made for entertainment professionals.
          </p>
          <a class="mt-auto mb-0 font-semibold leading-normal text-white group text-sm" href="media-library.php">
            Learn More
            <i class="fas fa-arrow-right ease-bounce text-sm group-hover:translate-x-1.25 ml-1 leading-normal transition-all duration-200"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

     


      
      <!-- footer start -->
     <?php include '../components/footer.php' ?>
    <!-- footer end -->
      
    </div>
    <!-- end cards -->
  </main>

</body>
<!-- plugin for charts  -->
<script src="../assets/js/plugins/chartjs.min.js" async></script>
<!-- plugin for scrollbar  -->
<script src="../assets/js/plugins/perfect-scrollbar.min.js" async></script>
<!-- github button -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- main script file  -->
<script
  src="../assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5"
  async></script>

</html>