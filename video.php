<?php
include("connection.php");
session_start();

$result = mysqli_query($conn, "SELECT * FROM videos");
$videos = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Music App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/video.css">
</head>

<body>

    <div class="overlay" id="overlay"></div>

    <!-- VIDEO POPUP OVERLAY -->
    <div class="video-overlay" id="videoOverlay">
        <div class="video-popup">
            <div class="video-popup-header">
                <div class="video-popup-title" id="videoTitle">—</div>
                <button class="video-close-btn" id="videoCloseBtn">✕</button>
            </div>
            <video id="videoPlayer" controls>
                <source id="videoSource" src="" type="video/mp4">
            </video>
        </div>
    </div>

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
                        <rect x="2" y="3" width="20" height="14" rx="2" />
                        <path d="M8 21h8M12 17v4" />
                    </svg>
                    Videos
                </div>
            </nav>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section">Videos</div>

            <!-- Sidebar mein videos list -->
            <div class="sidebar-queue">
                <?php foreach ($videos as $i => $video) { ?>
                    <div class="playlist-item" data-index="<?php echo $i; ?>"
                        data-video="videos/<?php echo $video['video_file']; ?>"
                        data-title="<?php echo $video['title']; ?>">
                        <span class="playlist-num"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
                        <img loading="lazy" src="img/thumbnails/<?php echo $video['thumbnail']; ?>" alt="">
                        <div class="track-info">
                            <div class="track-title"><?php echo $video['title']; ?></div>
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
                        <div class="main-tab active">Videos</div>
                        <a href="index.php">
                            <div class="main-tab">Albums</div>
                        </a>
                    </div>
                </div>
                <div class="top-right">
                    <div class="auth-btns">
                        <?php if (isset($_SESSION['loginedin'])) { ?>
                            <?php echo $_SESSION['loginemail']; ?>
                            <button class="btn-signup" onclick="window.location.href='logout.php'">Log Out</button>
                        <?php } else { ?>
                            <button class="btn-login" onclick="window.location.href='login.php'">Login</button>
                            <button class="btn-signup" onclick="window.location.href='login.php'">Sign Up</button>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- PAGE HEADER -->
            <div class="library-header">
                <div class="library-title">Videos</div>
                <div class="library-count"><?php echo count($videos); ?> Videos</div>
            </div>

            <!-- VIDEOS GRID -->
            <?php if (!empty($videos)) { ?>
                <div class="videos-grid">
                    <?php foreach ($videos as $i => $video) { ?>
                        <div class="video-card"
                            data-video="videos/<?php echo $video['video_file']; ?>"
                            data-title="<?php echo $video['title']; ?>">
                            <div class="video-card-thumb">
                                <img loading="lazy" src="img/thumbnails/<?php echo $video['thumbnail']; ?>" alt="">
                                <div class="video-card-overlay">
                                    <div class="video-play-btn">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#000">
                                            <polygon points="5 3 19 12 5 21 5 3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="video-card-info">
                                <div class="video-card-title"><?php echo $video['title']; ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="no-videos">
                    <div class="no-videos-icon">🎬</div>
                    <div class="no-videos-text">No videos yet</div>
                </div>
            <?php } ?>

            <div style="height:40px;"></div>
            <?php include('footer.php') ?>

        </main>
    </div>

    <script src="js/video.js" defer></script>
</body>

</html>