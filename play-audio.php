<?php
include 'admin/build/components/connection.php'; // DB connection

// Check if media_id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "No media ID provided.";
}


$media_id = $_GET['id'];

// Prepare and execute SQL
$stmt = $conn->prepare("SELECT title, artist, genre, release_year, media_type, description, thumbnail_path, media_path FROM media_library WHERE id = ?");



$stmt->bind_param("i", $media_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "Media not found.";
    exit;
}

$stmt->bind_result($title, $artist, $file_path, $thumbnail);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Play Audio</title>
</head>
<body>
  <h2><?= htmlspecialchars($title) ?></h2>
  <p><strong>Artist:</strong> <?= htmlspecialchars($artist) ?></p>

  <?php if ($thumbnail): ?>
    <img src="<?= htmlspecialchars($thumbnail) ?>" alt="Thumbnail" style="width:200px;height:auto;">
  <?php endif; ?>

  <?php if (file_exists($file_path)): ?>
    <audio controls>
      <source src="<?= htmlspecialchars($file_path) ?>" type="audio/mpeg">
      Your browser does not support the audio element.
    </audio>
  <?php else: ?>
    <p>Audio file not found.</p>
  <?php endif; ?>
</body>
</html>
