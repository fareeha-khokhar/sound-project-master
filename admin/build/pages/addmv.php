<?php
include '../components/connection.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit(); // Important to stop script execution after redirect
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $artist = $_POST['artist'];
  $genre = $_POST['genre'] ?? '';  // 🟢 FIX 1: avoid "undefined array key" warning
  $language = $_POST['language'];
  $description = $_POST['description'];
  $media_type = $_POST['media_type'];
  $release_year = $_POST['release_year'];

  $thumbnail = $_FILES['thumbnail'];
  $mediaFile = $_FILES['media_file'];

  // ===== 1. Validate Release Year =====
  if ($release_year < 1900 || $release_year > date('Y')) {
    echo "<script>alert('❌ Invalid release year.'); window.location.href='addmv.php';</script>";
    exit;
  }

  // ===== 2. Validate File Sizes (max 20MB) =====
  if ($thumbnail['size'] > 20 * 1024 * 1024 || $mediaFile['size'] > 20 * 1024 * 1024) {
    echo "<script>alert('❌ File too large. Max 20MB allowed.'); window.location.href='addmv.php';</script>";
    exit;
  }

  // ===== 3. Validate File Types =====
  $allowedThumbTypes = ['jpg', 'jpeg', 'png', 'gif'];
  $allowedAudio = ['mp3', 'wav', 'aac'];
  $allowedVideo = ['mp4', 'mkv', 'mov'];

  $thumbExt = strtolower(pathinfo($thumbnail['name'], PATHINFO_EXTENSION));
  $mediaExt = strtolower(pathinfo($mediaFile['name'], PATHINFO_EXTENSION));

  if (!in_array($thumbExt, $allowedThumbTypes)) {
    echo "<script>alert('❌ Invalid thumbnail type. JPG, PNG, GIF allowed.'); window.location.href='addmv.php';</script>";
    exit;
  }

  if ($media_type === 'audio' && !in_array($mediaExt, $allowedAudio)) {
    echo "<script>alert('❌ Invalid audio format. MP3, WAV, AAC only.'); window.location.href='addmv.php';</script>";
    exit;
  }

  if ($media_type === 'video' && !in_array($mediaExt, $allowedVideo)) {
    echo "<script>alert('❌ Invalid video format. MP4, MKV, MOV only.'); window.location.href='addmv.php';</script>";
    exit;
  }

  // ===== 4. Check Duplicate Title (mysqli-compatible) =====
  $check = $conn->prepare("SELECT id FROM media_library WHERE title = ?");
  $check->bind_param("s", $title);
  $check->execute();
  $result = $check->get_result();
  if ($result->num_rows > 0) {
    echo "<script>alert('❌ Title already exists. Please use a different title.'); window.location.href='addmv.php';</script>";
    exit;
  }

  // ===== 5. Create Unique Filenames =====
  $mediaFolder = ($media_type === 'audio') ? 'audio' : 'videos';

  $thumbUnique = uniqid('thumb_', true) . '.' . $thumbExt;
  $mediaUnique = uniqid('media_', true) . '.' . $mediaExt;

  $thumbPath = '../../uploads/thumbs/' . $thumbUnique;
  $mediaPath = '../../uploads/' . $mediaFolder . '/' . $mediaUnique;

  // ===== 6. Move Files =====
  if (move_uploaded_file($thumbnail['tmp_name'], $thumbPath) && move_uploaded_file($mediaFile['tmp_name'], $mediaPath)) {
    // ✅ Define these variables first
    $thumbDB = 'uploads/thumbs/' . $thumbUnique;
    $mediaDB = 'uploads/' . $mediaFolder . '/' . $mediaUnique;

    // ===== 7. Insert to DB =====
    $stmt = $conn->prepare("INSERT INTO media_library 
            (title, artist, genre, language, description, media_type, thumbnail_path, media_path, release_year)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssi", $title, $artist, $genre, $language, $description, $media_type, $thumbDB, $mediaDB, $release_year);

    $stmt->execute();

    echo "<script>alert('🎵 Media uploaded successfully!'); window.location.href='addmv.php';</script>";
  } else {
    echo "<script>alert('❌ File upload failed. Try again.'); window.location.href='addmv.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../../../img/core-img/favicon.ico" />
  <title>Sound Admin</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Main Styling -->
  <script src="https://cdn.tailwindcss.com"></script>

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
    <!-- Main Content -->
    <div class="max-w-6xl mx-auto">
      <form method="POST" enctype="multipart/form-data" class="w-full bg-white rounded-lg shadow-md p-8 space-y-6">
        <h2 class="text-3xl font-bold text-[#E173F2] text-center">Upload New MV</h2>

        <!-- Row 1: Title + Artist -->
        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/2">
            <label class="block text-[#787F89] mb-1 font-medium">MV Title</label>
            <input type="text" name="title" class="w-full p-3 focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" required />
          </div>
          <div class="w-full md:w-1/2">
            <label class="block text-[#787F89] mb-1 font-medium">Artist Name</label>
            <input type="text" name="artist" class="w-full p-3 focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" required />
          </div>
        </div>

        <!-- Row 2: Genre + Release Year -->
        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/2">
            <label class="block text-[#787F89] mb-1 font-medium">Album</label>
            <input type="text" name="genre" class="w-full p-3 focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
          </div>
          <div class="w-full md:w-1/2">
            <label class="block text-[#787F89] mb-1 font-medium">Release Year</label>
            <input type="number" name="release_year" min="1900" max="<?php echo date('Y'); ?>" class="w-full p-3 focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" required />
          </div>
        </div>

        <!-- Row 3: Language + Media Type -->
        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/2">
            <label class="block text-[#787F89] mb-1 font-medium">Language</label>
            <input type="text" name="language" class="w-full p-3 focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" required />
          </div>
          <div class="w-full md:w-1/2">
            <label class="block text-[#787F89] mb-1 font-medium">Media Type</label>
            <select name="media_type" class="w-full p-3 focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" required>
              <option value="">Select Type</option>
              <option value="audio">Audio</option>
              <option value="video">Video</option>
            </select>
          </div>
        </div>

        <!-- Row 4: Thumbnail + Media File -->
        <div class="flex flex-col md:flex-row gap-4">
          <div class="w-full md:w-1/2">
            <label class="block text-[#787F89] mb-1 font-medium">Thumbnail Image</label>
            <input type="file" name="thumbnail" accept="image/*" class="w-full p-2 border rounded-md file:bg-[#E173F2] file:text-white file:border-none file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:transition file:hover:bg-[#b94bc1]" required />
          </div>
          <div class="w-full md:w-1/2">
            <label class="block text-[#787F89] mb-1 font-medium">Upload Media File</label>
            <input type="file" name="media_file" accept="audio/*,video/*" class="w-full p-2 border rounded-md file:bg-[#E173F2] file:text-white file:border-none file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:transition file:hover:bg-[#b94bc1]" required />
          </div>
        </div>

        <!-- Description -->
        <div>
          <label class="block text-[#787F89] mb-1 font-medium">lyrics</label>
          <textarea name="description" rows="4" class="w-full p-3 focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" required></textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-start gap-4">
          <button type="submit" class="bg-[#E173F2] hover:bg-[#b94bc1] text-white font-semibold px-6 py-3 rounded-md transition">Upload</button>
          <a href="adminmv.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-md transition">Cancel</a>
        </div>
      </form>
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