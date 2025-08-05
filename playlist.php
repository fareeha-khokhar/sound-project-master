<?php
include 'admin/build/components/connection.php'; // Your DB connection
?>

<?php

// Fetch all songs
$stmt = $conn->prepare("SELECT id, title, artist, genre, release_year, media_type,media_path, description, thumbnail_path FROM media_library WHERE media_type = 'audio' ORDER BY id DESC");
$stmt->execute();
$stmt->bind_result($id, $song_name, $artist_name, $genre, $release_year, $media_type,$media_path, $lyrics, $thumbnail_path);

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

    body {
      margin: 0;
      background: #121212;
      color: #fff;
      font-family: 'Inter', Arial, sans-serif;
      overflow-x: hidden;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    .maindiv {
      display: flex;
      height: 100vh;
      width: 100%;
      overflow: hidden;
    }

    /* LEFT COLUMN */
    .sidebar {
      width: 300px;
      background: #000;
      display: flex;
      flex-direction: column;
      padding: 20px;
    }

    .sidebar-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: #fff;
      font-weight: 700;
      font-size: 20px;
      margin-bottom: 25px;
    }

    .sidebar-header span {
      cursor: pointer;
      font-weight: 700;
    }

    .sidebar-buttons {
      display: flex;
      gap: 8px;
      margin-bottom: 20px;
    }

    .btn {
      background: #282828;
      padding: 8px 16px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      user-select: none;
    }

    .btn.active {
      background: #fff;
      color: #000;
    }

    .search-box {
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

    .library-list {
      flex-grow: 1;
      overflow-y: auto;
    }

    .library-item {
      display: flex;
      align-items: center;
      padding: 8px 6px;
      border-radius: 4px;
      cursor: pointer;
      color: #b3b3b3;
      font-size: 14px;
      margin-bottom: 5px;
    }

    .library-item.active,
    .library-item:hover {
      background: #282828;
      color: #1db954;
    }

    .library-item .icon {
      width: 32px;
      height: 32px;
      background: linear-gradient(135deg, #B60B68, #41157F);
      border-radius: 6px;
      margin-right: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .library-item .icon svg {
      fill: #fff;
      width: 18px;
      height: 18px;
    }

    .library-list::-webkit-scrollbar {
      width: 6px;
    }

    .library-list::-webkit-scrollbar-thumb {
      background-color: #444;
      border-radius: 3px;
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

    table {
      width: 100%;
      border-collapse: collapse;
      color: #b3b3b3;
      font-size: 14px;
    }

    thead {
      border-bottom: 1px solid #282828;
    }

    th,
    td {
      text-align: left;
      padding: 12px 10px;
    }

    th {
      text-transform: uppercase;
      font-weight: 600;
      opacity: 0.7;
    }

    tbody tr {
      cursor: pointer;
    }

    tbody tr:hover {
      background: #282828;
      color: white;
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
  </style>
</head>

<body>
  <!-- Header Area -->
  <?php include 'components/nav.php'; ?>
  <!-- Header Area End -->
  <div class="mt-5 mb-5 pt-1">

  </div>
  <div class="maindiv">
    <!-- LEFT COLUMN -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <span>Your Library</span>
        <span>＋</span>
      </div>

      <div class="sidebar-buttons">
        <div class="btn active">Playlists</div>
        <div class="btn">Artists</div>
        <div class="btn">Albums</div>
      </div>

      <div class="search-box">
        <input type="text" placeholder="Search your library" />
      </div>

      <div class="library-list" tabindex="0">
        <div class="library-item active">
          <div class="icon">
            <svg viewBox="0 0 24 24">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3 9.24 3 10.91 3.81 12 5.09 13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
          </div>
          Liked Songs
        </div>
        <div class="library-item">
          <img src="img/cover/see you again.jpg" alt="JANI" style="width: 32px; height: 32px; border-radius: 6px; margin-right: 12px;">
          JANI
        </div>
        <div class="library-item">
          <img src="img/cover/see you again.jpg" alt="Guzaarishien" style="width: 32px; height: 32px; border-radius: 6px; margin-right: 12px;">
          Guzaarishien (From "Parwari...")
        </div>
        <div class="library-item">
          <img src="img/cover/see you again.jpg" alt="Talha Anjum" style="width: 32px; height: 32px; border-radius: 6px; margin-right: 12px;">
          Talha Anjum
        </div>
        <div class="library-item">
          <img src="img/cover/see you again.jpg" alt="My Terrible Mind" style="width: 32px; height: 32px; border-radius: 6px; margin-right: 12px;">
          My Terrible Mind
        </div>
        <div class="library-item">
          <img src="img/cover/see you again.jpg" alt="Soulfly" style="width: 32px; height: 32px; border-radius: 6px; margin-right: 12px;">
          Soulfly
        </div>
        <div class="library-item">
          <img src="img/cover/see you again.jpg" alt="Galera" style="width: 32px; height: 32px; border-radius: 6px; margin-right: 12px;">
          Galera
        </div>
        <div class="library-item">
          <img src="img/cover/see you again.jpg" alt="Eminem" style="width: 32px; height: 32px; border-radius: 6px; margin-right: 12px;">
          Eminem
        </div>
        <div class="library-item">
          <img src="img/cover/see you again.jpg" alt="Yun Jin" style="width: 32px; height: 32px; border-radius: 6px; margin-right: 12px;">
          Yun Jin
        </div>

        <!-- Add more library items as needed -->
      </div>
    </aside>

    <!-- CENTER COLUMN -->
    <section class="playlist-section" aria-label="Playlist">
      <header class="playlist-header">
        <div class="playlist-cover" aria-label="Playlist cover">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
            <rect width="24" height="24" rx="4" fill="#FFFFFF" />
            <path d="M12 7v10l6-5-6-5z" fill="#430C86" />
          </svg>
        </div>
        <div class="playlist-info">
          <small>PLAYLIST</small>
          <h1>My Favorite Songs</h1>
          <span>24 songs, 1 hr 25 mins</span>
          
          <div class="search-box">
        <input type="text" placeholder="Search your library" />
      </div>
        </div>
      </header>


      <table aria-describedby="playlist-description" role="table">
        <thead>
          <tr>
            <th class="song-number" scope="col">#</th>
            <th scope="col">Thumbnail</th>
            <th scope="col">Album</th>
            <th scope="col">Title</th>
            <th scope="col">Genre</th>
            <th scope="col" style="text-align:right;">Duration</th>
            <th scope="col" style="text-align:right;">Duration</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($stmt->fetch()): ?>
            <tr tabindex="0" aria-label="1. Midnight City by M83, Duration 4 minutes 4 seconds" class="border-t">
              <td class="song-number"><?= htmlspecialchars($id) ?></td>
              <td class="song-title">
                <img src="admin/<?= htmlspecialchars($thumbnail_path) ?>" class="w-full h-40 object-cover rounded mb-3">
                <div class="song-details">
                </div>
              </td>
              <td>
                <div class="artist-name"><?= htmlspecialchars($artist_name) ?></div>
              </td>
              <td>
                <div class="song-name"><?= htmlspecialchars($song_name) ?></div>
              </td>
              <td class="song-album"><?= htmlspecialchars($genre) ?></td>
              <td class="song-duration"><audio controls class="w-full mt-2">
                    <source src="admin/<?= htmlspecialchars($media_path) ?>" type="audio/mpeg">
                  </audio></td>
              <td class="song-duration"><i class="fas fa-play"></i></td>
            </tr>

          <?php endwhile; ?>

        <tbody>
      </table>
    </section>

    <!-- RIGHT COLUMN -->
    <aside class="right-panel" aria-label="Currently Playing">
      <h3>Now Playing</h3>
      <div class="current-song" tabindex="0" aria-live="polite">
        <img src="img/cover/7years.jpg" alt="Midnight City Album Art" />
        <div style="display: flex; gap: 40px; align-items: center;">
          <div class="current-song-info" style="display: inline;">7 Years</div>
          <div class="current-song-artist" style="display: inline; font-style: italic;">by Lukas Graham</div>

        </div>
        <p>Once, I was seven years old, my mama told me
          "Go make yourself some friends or you'll be lonely"</p>
      </div>
    </aside>
  </div>

  <!-- Bottom Player Bar -->
  <div class="player-bar" role="region" aria-label="Music player controls">
    <div class="player-info">
      <img src="img/cover/7years.jpg" alt="Midnight City Album Art" />
      <div class="player-info-details">
        <div class="player-song-title">7 Years</div>
        <div class="player-artist">by Lukas Graham</div>
      </div>
    </div>
    <div class="player-controls" role="group" aria-label="Playback controls" style="display: flex; justify-content: center; gap: 20px; margin: 20px 0;">
      <button aria-label="Previous" style="background-color: white; color: #3B126C; border: none; padding: 10px 16px; font-size: 18px; border-radius: 50%; cursor: pointer; transition: 0.3s;">
        &#9664;&#9664;
      </button>
      <button aria-label="Play/Pause" style="background-color: white; color: #3B126C; border: none; padding: 12px 18px; font-size: 20px; border-radius: 50%; cursor: pointer; transition: 0.3s;">
        &#9654;
      </button>
      <button aria-label="Next" style="background-color: white; color: #3B126C; border: none; padding: 10px 16px; font-size: 18px; border-radius: 50%; cursor: pointer; transition: 0.3s;">
        &#9654;&#9654;
      </button>
    </div>

  </div>
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