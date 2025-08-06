<?php
include 'admin/build/components/connection.php'; // Your DB connection
?>

<?php

// Fetch all songs
$stmt = $conn->prepare("SELECT id, title, artist, genre, release_year, media_type,media_path, description, thumbnail_path FROM media_library WHERE media_type = 'audio' ORDER BY id DESC");
$stmt->execute();
$stmt->bind_result($id, $song_name, $artist_name, $genre, $release_year, $media_type, $media_path, $lyrics, $thumbnail_path);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Spotify-like Playlist UI</title>
  <!-- Stylesheet -->
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <!-- favicon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

   
    .search-box {
      margin-top: 15px;
      margin-bottom: 15px;
    }

    .search-box input {
      width: 100%;
      padding: 8px 12px;
      background: #121212;
      border: 1px solid #282828;
      border-radius: 4px;
      color: #fff;
      font-size: 14px;
    }

    .search-box input::placeholder {
      color: #666;
    }

    /* CENTER COLUMN */
    .playlist-section {
      flex-grow: 1;
      /* background: linear-gradient(180deg, #4a2fbd 0%, #121212 100%); */
      padding: 30px;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }


    .playlist-header {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 30px;
    }

    .playlist-cover {
      width: 150px;
      height: 150px;
      background: linear-gradient(135deg, #B60B68, #41157F);
      border-radius: 8px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .playlist-cover svg {
      width: 60px;
      height: 60px;
      fill: white;
    }

    .playlist-info {
      color: white;
      display: flex;
      flex-direction: column;
    }

    .playlist-info small {
      font-weight: 400;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      opacity: 0.7;
      margin-bottom: 4px;
    }

    .playlist-info h1 {
      font-size: 48px;
      font-weight: 700;
      line-height: 1;
      margin-bottom: 10px;
    }

    .playlist-info p {
      font-weight: 600;
      opacity: 0.8;
    }

    .playlist-actions {
      margin-top: 20px;
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .btn-play {
      background: #3B126C;
      border: none;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      font-size: 22px;
      cursor: pointer;
      color: #000;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 6px 15px #001407ef;
      transition: background 0.3s ease;
    }

    .btn-play:hover {
      background: #430c86ff;
    }

    .btn-download {
      background: white;
      border: 2px solid #430C86;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      color: #430C86;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .btn-download:hover {
      border: 2px solid #000000ff;
      color: #430C86;
    }

  
    .song-number {
      width: 30px;
    }

    .song-title {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .song-cover {
      width: 40px;
      height: 40px;
      border-radius: 4px;
      background-color: #444;
      flex-shrink: 0;
    }

    .song-details {
      display: flex;
      flex-direction: column;
      line-height: 1.1;
    }

    .song-name {
      font-weight: 700;
      color: white;
    }

    .artist-name {
      font-size: 13px;
      color: #b3b3b3;
    }

    .song-album {
      color: #b3b3b3;
    }

    .song-duration {
      width: 50px;
      text-align: right;
    }

    /* RIGHT COLUMN */
    .right-panel {
      width: 280px;
      background: #121212;
      padding: 20px;
      overflow-y: auto;
    }

    .right-panel h3 {
      color: white;
      margin-bottom: 15px;
      font-weight: 700;
    }

    .current-song {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .current-song img {
      border-radius: 8px;
      width: 100%;
    }

    .current-song-info {
      font-weight: 700;
      font-size: 16px;
    }

    .current-song-artist {
      font-weight: 400;
      color: #b3b3b3;
      font-size: 14px;
      margin-top: 2px;
    }

    /* Bottom player controls */
    .player-bar {
      position: fixed;
      bottom: 0;
      left: 0px;
      right: 0px;
      height: 70px;
      background: #000000;
      display: flex;
      align-items: center;
      padding: 0 30px;
      border-top: 1px solid #282828;
      z-index: 1000;
    }

    .player-info {
      display: flex;
      align-items: center;
      gap: 12px;
      flex: 1;
    }

    .player-info img {
      height: 48px;
      width: 48px;
      border-radius: 4px;
    }

    .player-info-details {
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: white;
    }

    .player-song-title {
      font-weight: 700;
    }

    .player-artist {
      font-size: 13px;
      color: #b3b3b3;
    }

    .player-controls {
      display: flex;
      gap: 30px;
      font-size: 28px;
      color: #b3b3b3;
      cursor: pointer;
    }

    .player-controls:hover {
      color: #fff;
    }

    .right-panel::-webkit-scrollbar {
      width: 6px;
    }

    .right-panel::-webkit-scrollbar-thumb {
      background-color: #444;
      border-radius: 3px;
    }

    @media (max-width: 1200px) {
      .right-panel {
        display: none;
      }

      .player-bar {
        left: 280px;
        right: 0;
      }
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
      }

      .sidebar {
        width: 100%;
        flex-direction: row;
        overflow-x: auto;
        padding: 10px;
        gap: 20px;
      }

      .playlist-section {
        padding: 15px;
        order: 3;
      }

      .player-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
      }
    }
/* Optional: Make hover rows visually pop */
table tbody tr.hover-row:hover {
  background-color: #1e1e1e !important;
  color: #fff;
}

/* Improve readability */
table td,
table th {
  vertical-align: middle;
}

  </style>
</head>

<body class="bg-dark text-light" style="font-family: 'Inter', sans-serif;">
  <!-- Header Area -->
  <?php include 'components/nav.php'; ?>
  <!-- Header Area End -->

  <div class="container-fluid mt-5 pt-3">
    <div class="row">

      <!-- CENTER COLUMN -->
      <section class="col-md-8 playlist-section" aria-label="Playlist">
        <header class="d-flex align-items-center gap-4 mb-4">
          <div class="playlist-cover d-flex justify-content-center align-items-center">
            <svg viewBox="0 0 24 24">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
              2 5.42 4.42 3 7.5 3 9.24 3 10.91 3.81 
              12 5.09 13.09 3.81 14.76 3 16.5 3 
              19.58 3 22 5.42 22 8.5c0 3.78-3.4 
              6.86-8.55 11.54L12 21.35z" />
            </svg>
          </div>

          <div class="playlist-info">
            <small>PLAYLIST</small>
            <h1>My Favorite Songs</h1>
            <span>24 songs, 1 hr 25 mins</span>

            <div class="search-box mt-3">
              <input type="text" placeholder="Search your library" class="form-control bg-dark text-light" />
            </div>
          </div>
        </header>

        <table class="table table-borderless text-light align-middle">
  <thead class="border-bottom border-secondary">
    <tr>
      <th scope="col" class="text-secondary">#</th>
      <th scope="col" class="text-secondary">Thumbnail</th>
      <th scope="col" class="text-secondary">Artist</th>
      <th scope="col" class="text-secondary">Title</th>
      <th scope="col" class="text-secondary">Genre</th>
      <th scope="col" class="text-end text-secondary">Play</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($stmt->fetch()): ?>
      <tr class="hover-row">
        <td><?= htmlspecialchars($id) ?></td>
        <td>
          <img src="admin/<?= htmlspecialchars($thumbnail_path) ?>" class="img-fluid rounded" style="max-width: 60px;">
        </td>
        <td><?= htmlspecialchars($artist_name) ?></td>
        <td><?= htmlspecialchars($song_name) ?></td>
        <td><?= htmlspecialchars($genre) ?></td>
        <td class="text-end">
          <audio controls style="width: 220px;">
            <source src="admin/<?= htmlspecialchars($media_path) ?>" type="audio/mpeg">
          </audio>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

      </section>

      <!-- RIGHT COLUMN -->
      <aside class="col-md-4 right-panel bg-dark p-4 rounded">
        <h3 class="text-white mb-3">Now Playing</h3>
        <div class="current-song">
          <img src="img/cover/7years.jpg" class="img-fluid rounded mb-3" alt="Current song">
          <div class="fw-bold fs-5">7 Years</div>
          <div class="text-secondary fst-italic mb-2">by Lukas Graham</div>
          <p class="text-light small">
            Once, I was seven years old, my mama told me
            "Go make yourself some friends or you'll be lonely"
          </p>
        </div>
      </aside>
    </div>
  </div>

  <!-- Bottom Player Bar -->
  <!-- <div class="player-bar d-flex justify-content-between align-items-center px-4">
    <div class="player-info d-flex align-items-center gap-3">
      <img src="img/cover/7years.jpg" class="rounded" style="width: 48px; height: 48px;">
      <div>
        <div class="fw-bold">7 Years</div>
        <small class="text-secondary">by Lukas Graham</small>
      </div>
    </div>
    <div class="player-controls d-flex gap-3">
      <button class="btn btn-light rounded-circle px-3 py-2">&#9664;&#9664;</button>
      <button class="btn btn-light rounded-circle px-4 py-2">&#9654;</button>
      <button class="btn btn-light rounded-circle px-3 py-2">&#9654;&#9654;</button>
    </div>
  </div> -->
</body>


</html>