<?php 
include '../components/connection.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit(); // Important to stop script execution after redirect
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $venue = $_POST['venue'];
    $event_date = $_POST['event_date'];
    $contact = $_POST['contact'];
    $description = $_POST['description'] ?? '';

    $image = $_FILES['event_image'];

    // Validate image extension
    $imageExt = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageExt, $allowedExts)) {
        echo "<script>alert('❌ Invalid image format. Only JPG, PNG, or GIF allowed.'); window.location.href='add_event.php';</script>";
        exit;
    }

    // Unique file name and target path
    $imageName = uniqid('event_', true) . '.' . $imageExt;
    $uploadDir = '../../uploads/eventPictures/';
    $imagePath = $uploadDir . $imageName;
    $dbPath = 'uploads/eventPictures/' . $imageName;

    // Create folder if not exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move uploaded file
    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
        $stmt = $conn->prepare("INSERT INTO upcoming_events (title, venue, event_date, contact, image_path, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $venue, $event_date, $contact, $dbPath, $description);
        $stmt->execute();

        echo "<script>alert('🎉 Event added successfully!'); window.location.href='addevent.php';</script>";
    } else {
        echo "<script>alert('❌ Image upload failed.'); window.location.href='addevent.php';</script>";
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
        <div class="max-w-6xl mx-auto mt-10">
            <form method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-8 space-y-6">
                <h2 class="text-3xl font-bold text-[#E173F2] text-center">Add Upcoming Event</h2>

                <!-- Row 1 -->
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="w-full md:w-1/2">
                        <label class="block text-[#787F89] font-medium mb-1">Event Title</label>
                        <input type="text" name="title" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" />
                    </div>
                    <div class="w-full md:w-1/2">
                        <label class="block text-[#787F89] font-medium mb-1">Venue</label>
                        <input type="text" name="venue" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" />
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="w-full md:w-1/2">
                        <label class="block text-[#787F89] font-medium mb-1">Event Date</label>
                        <input type="date" name="event_date" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" />
                    </div>
                    <div class="w-full md:w-1/2">
                        <label class="block text-[#787F89] font-medium mb-1">Contact Number</label>
                        <input type="tel" name="contact" pattern="[0-9+]{10,15}" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" placeholder="+92XXXXXXXXXX" />
                    </div>
                </div>

                <!-- Row 3 -->
                <div>
                    <label class="block text-[#787F89] font-medium mb-1">Event Image</label>
                    <input type="file" name="event_image" accept="image/*" required class="w-full p-2 border rounded-md file:bg-[#E173F2] file:text-white file:border-none file:px-4 file:py-2 file:rounded-md file:cursor-pointer file:hover:bg-[#b94bc1]" />
                </div>

                <!-- Row 4 -->
                <div>
                    <label class="block text-[#787F89] font-medium mb-1">Event Description (optional)</label>
                    <textarea name="description" rows="4" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 justify-start">
                    <button type="submit" class="bg-[#E173F2] hover:bg-[#b94bc1] text-white font-semibold px-6 py-3 rounded transition">Add Event</button>
                    <a href="eventlist.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded transition">Cancel</a>
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