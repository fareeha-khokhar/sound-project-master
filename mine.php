<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SoundWave</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    :root {
      --primary: #E50417;
      --secondary: #DD26C0;
      --dark: #651973;
      --blue-dark: #245BA0;
      --aqua: #1FDFFF;
    }

    body {
      background: linear-gradient(135deg, var(--dark), var(--aqua));
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }

    .song-card {
      background-color: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      padding: 1rem;
      margin-bottom: 1rem;
    }

    .progress {
      height: 6px;
      background-color: rgba(255, 255, 255, 0.2);
    }

    .progress-bar {
      background-color: var(--aqua);
    }

    .btn-custom {
      background-color: var(--primary);
      color: white;
    }

    .btn-custom:hover {
      background-color: var(--secondary);
      color: white;
    }
  </style>
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4 text-center">🎵 SoundWave Library</h1>

    <!-- Search Input -->
    <div class="mb-3">
      <input type="text" id="searchInput" class="form-control" placeholder="Search for a song..." />
    </div>

    <!-- Progress Bar -->
    <div id="progressWrapper" class="mb-3" style="display: none;">
      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
      </div>
    </div>

    <!-- Song Results -->
    <div id="songResults">
      <!-- Results appear here -->
    </div>
  </div>

  <script>
    const searchInput = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('songResults');
    const progressWrapper = document.getElementById('progressWrapper');

    searchInput.addEventListener('keyup', function () {
      const query = this.value.trim();

      if (query.length === 0) {
        resultsContainer.innerHTML = '';
        return;
      }

      progressWrapper.style.display = 'block';

      // Simulate AJAX
      setTimeout(() => {
        progressWrapper.style.display = 'none';

        // Dummy data (Replace with actual AJAX call)
        const results = [
          { title: 'Midnight City', artist: 'M83' },
          { title: 'Youngblood', artist: '5 Seconds of Summer' },
          { title: 'Lose Yourself', artist: 'Eminem' },
        ].filter(song => song.title.toLowerCase().includes(query.toLowerCase()));

        resultsContainer.innerHTML = results.map(song => `
          <div class="song-card d-flex justify-content-between align-items-center">
            <div>
              <h5 class="mb-1">${song.title}</h5>
              <small>${song.artist}</small>
            </div>
            <button class="btn btn-sm btn-custom">Play</button>
          </div>
        `).join('') || `<p>No songs found.</p>`;
      }, 800);
    });
  </script>
</body>
</html>
