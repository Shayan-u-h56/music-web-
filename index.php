<?php
include("connection.php");
session_start();

//serach
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
  $sql   = "SELECT * FROM songs WHERE title LIKE '%$search%' OR artist LIKE '%$search%'";
  $qSafe = mysqli_query($conn, $sql);
} else {
  $sql = "SELECT * FROM songs";
}

// cards
$result     = mysqli_query($conn, $sql);
$tracks     = mysqli_fetch_all($result, MYSQLI_ASSOC);
$firstTrack = $tracks[0] ?? null;
mysqli_free_result($result);
// artitst
$result  = mysqli_query($conn, "SELECT * FROM artists");
$artists = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
// getreview
if ($firstTrack) {
  $song_id = $firstTrack['id'];
  $stmt = $conn->prepare("
    SELECT r.*, u.u_name
    FROM reviews r
    JOIN userdetails u ON r.user_id = u.id
    WHERE r.song_id = ?
    ORDER BY r.id DESC
");
  $stmt->bind_param("i", $song_id);
  $stmt->execute();
  $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Music App</title>
  <link rel="stylesheet" href="css/style.css">
  <?php if ($firstTrack) { ?>
    <link rel="preload" as="image" href="img/covers/<?= $firstTrack['cover_image'] ?>">
  <?php } ?>
</head>

<body>

  <div class="overlay" id="overlay"></div>

  <div class="app">
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-logo">
        <svg viewBox="0 0 32 32" fill="none">
          <circle cx="16" cy="16" r="15" fill="#1db954" />
          <circle cx="16" cy="16" r="7" fill="#000" opacity="0.55" />
          <circle cx="16" cy="16" r="3" fill="#1db954" />
          <line x1="16" y1="1" x2="16" y2="9" stroke="#000" stroke-width="2.5" />
        </svg>
        MusicApp
        <button class="sidebar-close" id="sidebarClose">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg>
        </button>
      </div>

      <nav id="sidebarNav">
        <div class="nav-item active" data-nav="playlist">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 18V5l12-2v13" />
            <circle cx="6" cy="18" r="3" />
            <circle cx="18" cy="16" r="3" />
          </svg>
          Playlist
        </div>
        <div class="nav-item" data-nav="last">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
          </svg>
          Last Listening
        </div>
        <div class="nav-item" data-nav="recommended">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
          </svg>
          Recommended
        </div>
      </nav>

      <div class="sidebar-divider"></div>
      <div class="sidebar-section">Queue</div>

      <div class="sidebar-queue" id="sidebar-tracks">
        <?php foreach ($tracks as $i => $track) { ?>
          <div class="playlist-item" data-index="<?= $i ?>">
            <span class="playlist-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
            <img loading="lazy" src="img/covers/<?= $track['cover_image'] ?>" alt="">
            <div class="track-info">
              <div class="track-title"><?= $track['title'] ?></div>
              <div class="track-artist"><?= $track['artist'] ?></div>
            </div>
          </div>
        <?php } ?>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <!-- TOP BAR -->
      <div class="top-bar">
        <div class="top-left">
          <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="3" y1="6" x2="21" y2="6" />
              <line x1="3" y1="12" x2="21" y2="12" />
              <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
          </button>
          <div class="main-nav" id="mainNav">
            <div class="main-tab active" data-tab="discover">Discover</div>
            <a href="video.php">
              <div class="main-tab" data-tab="library">Videos</div>
            </a>
            <a href="#">
              <div class="main-tab" data-tab="artists">Albums</div>
            </a>
          </div>
        </div>
        <div class="top-right">
          <div class="search-wrap">
            <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <form action="" method="get">
              <input class="search-input" id="searchInput" name="search" type="search"
                placeholder="Search..."
                value="<?= $search ?>">
            </form>
            <div class="search-dropdown" id="searchDrop"></div>
          </div>
          <div class="auth-btns" id="authBtns">
            <?php if (isset($_SESSION['loginedin'])) { ?>
              <?= $_SESSION['loginemail'] ?>
              <button class="btn-signup" onclick="window.location.href='logout.php'">Log out</button>
            <?php } else { ?>
              <button class="btn-login" id="btnLogin" onclick="window.location.href='login.php'">Login</button>
              <button class="btn-signup" id="btnSignup" onclick="window.location.href='login.php'">Sign Up</button>
            <?php } ?>
          </div>
          <div class="avatar" id="userAvatar" style="display:none;">DJ</div>
        </div>
      </div>

      <!-- HERO -->
      <div class="hero">

        <?php if ($firstTrack) { ?>
          <img class="hero-bg" id="hero-img" loading="eager" fetchpriority="high"
            src="img/covers/<?= $firstTrack['cover_image'] ?>" alt="">
          <div class="hero-content">
            <div class="hero-title" id="hero-title"><?= $firstTrack['title'] ?></div>
            <div class="hero-desc" id="hero-desc"><?= $firstTrack['artist'] ?></div>
            <div class="hero-btns">
              <button class="btn-play" id="heroPlayBtn">▶ PLAY</button>
              <button class="btn-follow" id="heroFollowBtn">FOLLOW</button>
            </div>
          </div>
        <?php } else { ?>
          <div class="hero-content">
            <div class="hero-title">No results found</div>
            <div class="hero-desc">Try searching something else</div>
          </div>
        <?php } ?>
      </div>

      <!-- POPULAR SONGS -->
      <div class="section">
        <div class="section-header">
          <div class="section-title">Popular Song</div>
          <div class="nav-arrows">
            <div class="arrow-btn" id="songsLeft">&#8592;</div>
            <div class="arrow-btn" id="songsRight">&#8594;</div>
          </div>
        </div>

        <div class="songs-scroll" id="songsRow">
          <?php foreach ($tracks as $i => $track) { ?>
            <div class="song-card"
              data-index="<?= $i ?>"
              data-title="<?= $track['title'] ?>"
              data-artist="<?= $track['artist'] ?>"
              data-cover="img/covers/<?= $track['cover_image'] ?>"
              data-audio="songs/<?= $track['audio_file'] ?>">

              <div class="song-card-img">

                <img loading="<?= $i < 4 ? 'eager' : 'lazy' ?>"
                  src="img/covers/<?= $track['cover_image'] ?>" alt="">
                <div class="song-card-overlay">
                  <div class="play-circle">▶</div>
                </div>
              </div>

              <div class="song-card-name"><?= $track['title'] ?></div>
              <div class="song-card-sub"><?= $track['artist'] ?></div>
            </div>
          <?php } ?>
        </div>
      </div>

      <!-- POPULAR ARTISTS -->
      <div class="section" style="padding-top:0;">
        <div class="section-header">
          <div class="section-title">Popular Artists</div>
          <div class="nav-arrows">
            <div class="arrow-btn" id="artistsLeft">&#8592;</div>
            <div class="arrow-btn" id="artistsRight">&#8594;</div>
          </div>
        </div>
        <div class="artists-scroll" id="artistsRow">
          <?php foreach ($artists as $artist) { ?>
            <a href="artist.php?id=<?= $artist['id'] ?>">
              <div class="artist-card">
                <div class="artist-circle">
                  <img loading="lazy" src="img/artists/<?= $artist['image'] ?>" alt="">
                </div>
                <div class="artist-name"><?= $artist['name'] ?></div>
              </div>
            </a>
          <?php } ?>
        </div>
      </div>

      <div style="height:20px;"></div>
      <!-- review -->
      <div class="review-box">

        <h3>Leave a Review</h3>

        <form method="POST" action="sumit_review.php">

          <input type="hidden" name="song_id" value="<?= $firstTrack ? $firstTrack['id'] : 0 ?>">
          <select name="rating" required>
            <option value="">Select Rating</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
          </select>

          <textarea
            name="review"
            placeholder="Share your thoughts about this song..."
            required></textarea>

          <button type="submit" name="submit_review">
            Submit Review
          </button>

        </form>

      </div>
      <!-- show review -->
      <div class="reviews-list">
        <h3>User Reviews</h3>

        <?php if ($result->num_rows > 0) { ?>

          <?php while ($review = $result->fetch_assoc()) { ?>

            <div class="review-card">
              <h4><?= $review['u_name'] ?></h4>

              <div>
                <?= str_repeat("⭐", $review['rating']) ?>
              </div>

              <p><?= $review['review'] ?></p>
            </div>

          <?php } ?>

        <?php } else { ?>

          <p>No reviews yet.</p>

        <?php } ?>
      </div>
      <!-- FOOTER  -->
      <?php include('footer.php') ?>
      <!-- <hr class="footer-line-separator">
      <footer class="app-footer">
        <div class="footer-wrapper">
          <div class="footer-navigation">
            <div class="footer-section-col">
              <h3>Company</h3>
              <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Jobs</a></li>
                <li><a href="#">For the Record</a></li>
              </ul>
            </div>
            <div class="footer-section-col">
              <h3>Communities</h3>
              <ul>
                <li><a href="#">For Artists</a></li>
                <li><a href="#">Developers</a></li>
                <li><a href="#">Advertising</a></li>
                <li><a href="#">Investors</a></li>
                <li><a href="#">Vendors</a></li>
              </ul>
            </div>
            <div class="footer-section-col">
              <h3>Useful links</h3>
              <ul>
                <li><a href="#">Support</a></li>
                <li><a href="#">Free Mobile App</a></li>
              </ul>
            </div>
          </div>
          <div class="footer-social-links">

            <a href="#" class="social-circle-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="2" width="20" height="20" rx="5" />
                <circle cx="12" cy="12" r="5" />
                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" />
              </svg>
            </a>

            <a href="#" class="social-circle-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
              </svg>
            </a>

            <a href="#" class="social-circle-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
              </svg>
            </a>
          </div>
        </div>
        <hr class="footer-line-separator">
        <div class="footer-base">
          <div class="legal-policy-links">
            <a href="#">Legal</a>
            <a href="#">Safety & Privacy Center</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Cookies</a>
            <a href="#">About Ads</a>
            <a href="#">Accessibility</a>
          </div>
          <p class="copyright-text">&copy; 2026 BrandName</p>
        </div>
      </footer> -->
    </main>
  </div>

  <!-- PLAYER -->
  <div class="player">
    <div class="player-info">
      <img class="player-thumb" id="player-thumb"
        src="<?= $firstTrack ? 'img/covers/' . $firstTrack['cover_image'] : '' ?>" alt="">
      <div class="player-text">
        <div class="player-title" id="player-title"><?= $firstTrack ? $firstTrack['title'] : '—' ?></div>
        <div class="player-artist" id="player-artist"><?= $firstTrack ? $firstTrack['artist'] : '—' ?></div>
      </div>
    </div>

    <div class="player-controls">
      <div class="ctrl-btns">
        <button class="ctrl-btn" id="shuffleBtn" title="Shuffle">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="16 3 21 3 21 8" />
            <line x1="4" y1="20" x2="21" y2="3" />
            <polyline points="21 16 21 21 16 21" />
            <line x1="4" y1="4" x2="9" y2="9" />
          </svg>
        </button>
        <button class="ctrl-btn" id="prevBtn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <polygon points="19 20 9 12 19 4 19 20" />
            <line x1="5" y1="19" x2="5" y2="5" stroke="currentColor" stroke-width="2" />
          </svg>
        </button>
        <button class="ctrl-btn play-main" id="playMainBtn">
          <svg id="playIcon" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <polygon points="5 3 19 12 5 21 5 3" />
          </svg>
        </button>
        <button class="ctrl-btn" id="nextBtn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <polygon points="5 4 15 12 5 20 5 4" />
            <line x1="19" y1="5" x2="19" y2="19" stroke="currentColor" stroke-width="2" />
          </svg>
        </button>
        <button class="ctrl-btn dl-btn" id="downloadBtn" title="Download">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
            <polyline points="7 10 12 15 17 10" />
            <line x1="12" y1="15" x2="12" y2="3" />
          </svg>
        </button>
      </div>
      <div class="progress-wrap">
        <span class="time-label" id="curTime">0:00</span>
        <div class="progress-bar" id="progressBar">
          <div class="progress-fill" id="progressFill"></div>
        </div>
        <span class="time-label" id="durTime">0:00</span>
      </div>
    </div>

    <div class="player-right">
      <div class="vol-wrap">
        <button class="icon-btn" id="muteBtn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5" />
            <path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07" />
          </svg>
        </button>
        <input type="range" class="vol-slider" id="volSlider" min="0" max="100" value="80">
      </div>
    </div>
  </div>

  <audio id="audioEl" preload="none"></audio>

  <script src="js/script.js" defer></script>
</body>

</html>