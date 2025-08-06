<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $songName = $_POST['song_name'];
    $artistName = $_POST['artist_name'];
    $genre = $_POST['genre'];
    $releaseDate = $_POST['release_date'];
    $type = $_POST['type'];
    $lyrics = $_POST['lyrics'];

    $thumbnail = $_FILES['thumbnail'];
    $musicFile = $_FILES['music_file'];

    // Save files
    move_uploaded_file($thumbnail['tmp_name'], "../uploads/thumbs/" . $thumbnail['name']);
    move_uploaded_file($musicFile['tmp_name'], "../uploads/audio/" . $musicFile['name']);

    // Now insert into database (example)
    // You'll need to connect to MySQL and insert accordingly

    echo "Song uploaded successfully!";
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
        <div class="w-full px-6 py-6 mx-auto">

            <form method="POST" enctype="multipart/form-data" class="w-full bg-white rounded-lg shadow-md p-8 space-y-6">
                <h2 class="text-3xl font-bold text-[#E173F2] text-center">Upload New Song</h2>

                <!-- Row 1: Title + Artist -->
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="w-full md:w-1/2">
                        <label class="block text-[#787F89] mb-1 font-medium">Song Title</label>
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