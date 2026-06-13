<?php
include("connection.php");
session_start();

$artistId = $_GET['id'];

// Artist info
$res    = mysqli_query($conn, "SELECT * FROM artists WHERE id = $artistId");
$artist = mysqli_fetch_assoc($res);

// Us artist ke songs
$res   = mysqli_query($conn, "SELECT * FROM songs WHERE artist_id = $artistId");
$songs = mysqli_fetch_all($res, MYSQLI_ASSOC);

$firstSong = $songs[0] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $artist['name'] ?> - Music App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/artisit.css">
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
                <div class="nav-item" onclick="window.location.href='index.php'">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    Home
                </div>
                <div class="nav-item active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <circle cx="12" cy="12" r="4" />
                    </svg>
                    Artist
                </div>
            </nav>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section"><?= $artist['name'] ?> — Songs</div>

            <!-- Sidebar mein songs -->
            <div class="sidebar-queue" id="sidebar-tracks">
                <?php foreach ($songs as $i => $song){ ?>
                    <div class="playlist-item" data-index="<?= $i ?>">
                        <span class="playlist-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                        <img loading="lazy" src="img/covers/<?= $song['cover_image'] ?>" alt="">
                        <div class="track-info">
                            <div class="track-title"><?= $song['title'] ?></div>
                            <div class="track-artist"><?= $song['artist'] ?></div>
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
                        <a href="index.php">
                            <div class="main-tab">Discover</div>
                        </a>
                        <a href="video.php">
                            <div class="main-tab">Videos</div>
                        </a>
                        <div class="main-tab active">Albums</div>
                    </div>
                </div>
                <div class="top-right">
                    <div class="auth-btns">
                        <?php if (isset($_SESSION['loginedin'])) { ?>
                            <?= $_SESSION['loginemail'] ?>
                            <button class="btn-signup" onclick="window.location.href='logout.php'">Log Out</button>
                        <?php } else {  ?>
                            <button class="btn-login" onclick="window.location.href='login.php'">Login</button>
                            <button class="btn-signup" onclick="window.location.href='login.php'">Sign Up</button>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- ARTIST HERO -->
            <div class="artist-hero">
                <img class="artist-hero-bg" src="img/artists/<?= $artist['image'] ?>" alt="">
                <div class="artist-hero-content">
                    <div class="artist-hero-label">Artist</div>
                    <div class="artist-hero-name"><?= $artist['name'] ?></div>


                </div>
            </div>

            <!-- SONGS LIST -->
            <div class="artist-songs-wrap">
                <div class="artist-songs-title">Songs</div>

                <?php foreach ($songs as $i => $song){ ?>
                    <div class="artist-song-row song-card"
                        data-index="<?= $i ?>"
                        data-title="<?= $song['title'] ?>"
                        data-artist="<?= $song['artist'] ?>"
                        data-cover="img/covers/<?= $song['cover_image'] ?>"
                        data-audio="songs/<?= $song['audio_file'] ?>">

                        <div class="artist-song-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></div>

                        
                        
                            <img loading="lazy" src="img/covers/<?= $song['cover_image'] ?>" alt="">
                            <div class="artist-song-title"><?= $song['title'] ?></div>
                            <div class="artist-song-artist"><?= $song['artist'] ?></div>
                            <div class="artist-song-play">▶</div>
                        

                    </div>
                <?php } ?>
            </div>

            <div style="height:100px;"></div>
            <?php include('footer.php') ?>
        </main>
    </div>

    <!-- PLAYER -->
    <div class="player">
        <div class="player-info">
            <img class="player-thumb" id="player-thumb"
                src="<?= $firstSong ? 'img/covers/' . $firstSong['cover_image'] : '' ?>" alt="">
            <div class="player-text">
                <div class="player-title" id="player-title"><?= $firstSong ? $firstSong['title']  : '—' ?></div>
                <div class="player-artist" id="player-artist"><?= $firstSong ? $firstSong['artist'] : '—' ?></div>
            </div>
        </div>
        <div class="player-controls">
            <div class="ctrl-btns">
                <button class="ctrl-btn" id="shuffleBtn">
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
                <button class="ctrl-btn" id="downloadBtn">
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