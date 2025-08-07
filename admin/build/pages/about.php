<?php 
include '../components/connection.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit(); // Important to stop script execution after redirect
}

// Fetch existing data
$para1 = $para2 = $para3 = $mission = $vision = $value = '';
$result = $conn->query("SELECT * FROM about_page ORDER BY id DESC LIMIT 1");

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $para1 = $row['para1'];
    $para2 = $row['para2'];
    $para3 = $row['para3'];
    $mission = $row['mission'];
    $vision = $row['vision'];
    $value = $row['value'];
    $existing_id = $row['id'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $para1 = $_POST['para1'];
    $para2 = $_POST['para2'];
    $para3 = $_POST['para3'];
    $mission = $_POST['mission'];
    $vision = $_POST['vision'];
    $value = $_POST['value'];

    if (isset($existing_id)) {
        // Update if record exists
        $stmt = $conn->prepare("UPDATE about_page SET para1 = ?, para2 = ?, para3 = ?, mission = ?, vision = ?, value = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $para1, $para2, $para3, $mission, $vision, $value, $existing_id);
    } else {
        // Insert new if not
        $stmt = $conn->prepare("INSERT INTO about_page (para1, para2, para3, mission, vision, value) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $para1, $para2, $para3, $mission, $vision, $value);
    }

    if ($stmt->execute()) {
        echo "<script>alert('✅ About Page content saved successfully.'); window.location.href='about.php';</script>";
    } else {
        echo "<script>alert('❌ Failed to save content.'); window.location.href='about.php';</script>";
    }

    $stmt->close();
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
        <h2 class="text-3xl font-bold text-[#E173F2] text-center">Edit About Page Content</h2>

        <!-- Row 1 -->
        <div>
            <label class="block text-[#787F89] font-medium mb-1">Paragraph 01</label>
            <input type="text" name="para1" value="<?= htmlspecialchars($para1) ?>" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" />
        </div>
        <div>
            <label class="block text-[#787F89] font-medium mb-1">Paragraph 02</label>
            <input type="text" name="para2" value="<?= htmlspecialchars($para2) ?>" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" />
        </div>

        <!-- Row 2 -->
        <div>
            <label class="block text-[#787F89] font-medium mb-1">Paragraph 03</label>
            <input type="text" name="para3" value="<?= htmlspecialchars($para3) ?>" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" />
        </div>
        <div>
            <label class="block text-[#787F89] font-medium mb-1">Our Mission</label>
            <input type="text" name="mission" value="<?= htmlspecialchars($mission) ?>" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" />
        </div>

        <!-- Row 3 -->
        <div>
            <label class="block text-[#787F89] font-medium mb-1">Our Vision</label>
            <input type="text" name="vision" value="<?= htmlspecialchars($vision) ?>" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" />
        </div>

        <!-- Row 4 -->
        <div>
            <label class="block text-[#787F89] font-medium mb-1">Our Values</label>
            <input type="text" name="value" value="<?= htmlspecialchars($value) ?>" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-[#E173F2]" />
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 justify-start">
            <button type="submit" class="bg-[#E173F2] hover:bg-[#b94bc1] text-white font-semibold px-6 py-3 rounded transition">Save Changes</button>
            <a href="dashboard.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded transition">Cancel</a>
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