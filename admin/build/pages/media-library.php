  <?php
  include '../components/connection.php';

  // --- Handle Update Request ---
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $language = $_POST['language'];
    $release_year = $_POST['release_year'];
    $description = $_POST['description'];

    // Fetch existing paths
    $getOld = $conn->prepare("SELECT thumbnail_path, media_path, media_type FROM media_library WHERE id = ?");
    $getOld->bind_param("i", $id);
    $getOld->execute();
    $oldResult = $getOld->get_result()->fetch_assoc();

    $thumbPath = $oldResult['thumbnail_path'];
    $mediaPath = $oldResult['media_path'];
    $mediaType = $oldResult['media_type'];

    // Thumbnail update
    if (!empty($_FILES['thumbnail']['name'])) {
      $thumbExt = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
      $thumbUnique = uniqid('thumb_', true) . '.' . $thumbExt;
      $thumbPath = 'uploads/thumbs/' . $thumbUnique;
      move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../../' . $thumbPath);
    }

    // Media file update
    if (!empty($_FILES['media_file']['name'])) {
      $mediaExt = pathinfo($_FILES['media_file']['name'], PATHINFO_EXTENSION);
      $mediaUnique = uniqid('media_', true) . '.' . $mediaExt;
      $mediaFolder = ($mediaType === 'audio') ? 'audio' : 'videos';
      $mediaPath = 'uploads/' . $mediaFolder . '/' . $mediaUnique;
      move_uploaded_file($_FILES['media_file']['tmp_name'], '../../' . $mediaPath);
    }

    // Update DB
    $update = $conn->prepare("UPDATE media_library SET title=?, artist=?, language=?, release_year=?, description=?, thumbnail_path=?, media_path=? WHERE id=?");
    $update->bind_param("sssssssi", $title, $artist, $language, $release_year, $description, $thumbPath, $mediaPath, $id);
    $update->execute();

    echo "<script>alert('✅ Media Updated!'); window.location='media-library.php';</script>";
    exit;
  }

  // --- Handle Delete Request ---
  if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("SELECT thumbnail_path, media_path FROM media_library WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
      @unlink('../../' . $result['thumbnail_path']);
      @unlink('../../' . $result['media_path']);
      $del = $conn->prepare("DELETE FROM media_library WHERE id = ?");
      $del->bind_param("i", $id);
      $del->execute();
    }
    echo "<script>alert('❌ Deleted'); window.location='media-library.php';</script>";
    exit;
  }

  // --- Search/Filter ---
  $where = [];
  $params = [];
  $types = '';

  if (!empty($_GET['title'])) {
    $where[] = "title LIKE ?";
    $params[] = "%" . $_GET['title'] . "%";
    $types .= 's';
  }
  if (!empty($_GET['media_type'])) {
    $where[] = "media_type = ?";
    $params[] = $_GET['media_type'];
    $types .= 's';
  }
  if (!empty($_GET['release_year'])) {
    $where[] = "release_year = ?";
    $params[] = $_GET['release_year'];
    $types .= 's';
  }

  $sql = "SELECT * FROM media_library";
  if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
  }
  $sql .= " ORDER BY id DESC";

  $stmt = $conn->prepare($sql);
  if ($params) {
    $stmt->bind_param($types, ...$params);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  $mediaList = [];
  while ($row = $result->fetch_assoc()) {
    $mediaList[] = $row;
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../../../img/core-img/favicon.ico" />
  <title>Sound Dashboard </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="../assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5" rel="stylesheet" />
  </head>

  <body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">


    <!-- sidebar start -->
    <?php include '../components/sidebar.php' ?>
    <!-- sidebar end -->

    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all      duration-200">   
            <!-- navbar start -->
            <?php include '../components/navbar.php' ?>
            <!-- navbar end -->
      <h2 class="text-3xl font-bold text-fuchsia-500 mb-6 text-center"> Media Library</h2>

      <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8 px-4">
  <input
    type="text"
    name="title"
    placeholder="Search Title"
    value="<?= htmlspecialchars($_GET['title'] ?? '') ?>"
    class="w-full p-3 rounded-lg border border-gray-300 bg-white text-gray-700 placeholder-gray-500 focus:outline-none focus:border-fuchsia-300"
  />

  <select
    name="media_type"
    class="w-full p-3 rounded-lg border border-gray-300 bg-white text-gray-700 placeholder-gray-500 focus:outline-none focus:border-fuchsia-300"
  >
    <option value="">All Types</option>
    <option value="audio" <?= (@$_GET['media_type'] == 'audio') ? 'selected' : '' ?>>Audio</option>
    <option value="video" <?= (@$_GET['media_type'] == 'video') ? 'selected' : '' ?>>Video</option>
  </select>

  <input
    type="number"
    name="release_year"
    placeholder="Year"
    value="<?= htmlspecialchars($_GET['release_year'] ?? '') ?>"
    class="w-full p-3 rounded-lg border border-gray-300 bg-white text-gray-700 placeholder-gray-500 focus:outline-none focus:border-fuchsia-300"
  />

  <button
    class="w-full bg-fuchsia-500 text-white px-4 py-3 rounded-lg hover:bg-fuchsia-600 transition-all"
  >
    Search
  </button>
</form>

      <section class="px-4 pb-8">
        <?php if (count($mediaList) === 0): ?>
          <div class="text-center text-gray-500">No media found.</div>
        <?php else: ?>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($mediaList as $media): ?>
              <div class="bg-white rounded-xl shadow-md p-4 border border-gray-200">
                <img src="../../<?= $media['thumbnail_path'] ?>" class="w-full h-40 object-cover rounded mb-3">
                <h3 class="font-bold text-lg"><?= htmlspecialchars($media['title']) ?></h3>
                <p class="text-sm text-gray-600"> <?= $media['artist'] ?> |  <?= $media['language'] ?> |  <?= $media['release_year'] ?></p>
                <p class="text-sm text-gray-600 mb-2"> <?= strtoupper($media['media_type']) ?></p>

                <?php if ($media['media_type'] === 'audio'): ?>
                  <audio controls class="w-full mt-2">
                    <source src="../../<?= $media['media_path'] ?>" type="audio/mpeg">
                  </audio>
                <?php else: ?>
                  <video controls class="w-full mt-2 h-40">
                    <source src="../../<?= $media['media_path'] ?>" type="video/mp4">
                  </video>
                <?php endif; ?>

                <div class="flex justify-between mt-4 text-sm">
                  <a href="../../<?= $media['media_path'] ?>" download class="text-blue-600 hover:underline">⬇ Download</a>
                  <button onclick='openEditModal(<?= json_encode($media) ?>)' class="text-yellow-600 hover:underline">✏ Edit</button>
                  <a href="?delete=<?= $media['id'] ?>" onclick="return confirm('Delete this?')" class="text-red-600 hover:underline">🗑 Delete</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </section>

      <!-- ✅ Modal -->
      <main id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded w-full max-w-xl relative">
          <button onclick="closeModal()" class="absolute top-2 right-3 text-xl">&times;</button>
          <h2 class="text-xl font-semibold mb-4">Edit Media</h2>
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="title" id="edit_title" required class="w-full mb-2 p-2 border rounded" placeholder="Title">
            <input type="text" name="artist" id="edit_artist" required class="w-full mb-2 p-2 border rounded" placeholder="Artist">
            <input type="text" name="language" id="edit_language" class="w-full mb-2 p-2 border rounded" placeholder="Language">
            <input type="number" name="release_year" id="edit_release_year" class="w-full mb-2 p-2 border rounded" placeholder="Year">
            <textarea name="description" id="edit_description" rows="3" class="w-full mb-2 p-2 border rounded" placeholder="Description"></textarea>
            <div class="mb-2">
              <label class="text-sm">Replace Thumbnail:</label>
              <input type="file" name="thumbnail" class="w-full">
            </div>
            <div class="mb-4">
              <label class="text-sm">Replace Media File:</label>
              <input type="file" name="media_file" class="w-full">
            </div>
            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Update</button>
          </form>
        </div>
      </main>

    </main>
      <!-- main script file  -->
<script src="../assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5" async></script>
    <script>
      function openEditModal(data) {
        document.getElementById('edit_id').value = data.id;
        document.getElementById('edit_title').value = data.title;
        document.getElementById('edit_artist').value = data.artist;
        document.getElementById('edit_language').value = data.language;
        document.getElementById('edit_release_year').value = data.release_year;
        document.getElementById('edit_description').value = data.description;
        document.getElementById('editModal').style.display = 'flex';
      }

      function closeModal() {
        document.getElementById('editModal').style.display = 'none';
      }
    </script>

  </body>

  </html>