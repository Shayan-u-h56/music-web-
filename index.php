<?php
include("connection.php");
session_start();
$albums = $conn->query("SELECT * FROM albums");
$album_id = $_GET['album'] ?? 1;
$stmt = $conn->prepare("SELECT * FROM albums WHERE id = ?");
$stmt->bind_param("i", $album_id);
$stmt->execute();
$album = $stmt->get_result()->fetch_assoc();
$folder = "songs/" . $album['folder_name']
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/utility.css">
    <title>Spotify - Web Player: Music for everyone</title>
</head>

<body>
    <div class="header">
        <div class="nav">
            <div class="hamburgerContainer">
                <img width="40" class="invert hamburger" src="img/hamburger.svg" alt="">
                <img width="110" class="invert " src="img/logo.svg" alt="">
                <div class="icon">
                    <img class="invert" id="hicon"  src="img/home.svg" alt="home">
                    <form action="">
                        <img class="invert " width="25px" src="img/search.svg" alt="home">
                        <input type="search" placeholder="What do you want to play?">
                    </form>

                </div>

            </div>
        </div>
        <div class="buttons ">
            <a href="">Premium</a>
            <a href="">Support</a>
            <a href="">Download</a>
            |
            <?php if (isset($_SESSION['loginedin'])) { ?>
                <?php echo $_SESSION['loginemail']; ?>
                <button class="loginbtn" onclick="window.location.href='logout.php'">log out</button>

            <?php } else { ?>
                <button class="signupbtn" onclick="window.location.href='login.php'">Sign up</button>
                <button class="loginbtn" onclick="window.location.href='login.php'">Log in</button>
            <?php } ?>
        </div>
    </div>
    <div class="container flex bg-black">
        <div class="left">
            <div class="close">
                <img width="30" class="invert" src="img/close.svg" alt="">
            </div>
            <!-- <div class="home bg-grey rounded m-1 p-1">
                <div class="logo"><img width="110" class="invert" src="img/logo.svg" alt=""></div>
                <ul>
                    <li><img class="invert" src="img/home.svg" alt="home">Home</li>
                    <li><img class="invert" src="img/search.svg" alt="home">Search</li>
                </ul>
            </div> -->

            <div class="library bg-grey rounded m-1 p-1">
                <div class="heading">
                    <img class="invert" src="img/playlist.svg" alt="">
                    <h2>
                        Your Library
                    </h2>
                </div>

                <div class="songList">
                    <div class="songList">
                        <ul>

                            <?php

                            $files = scandir($folder);

                            foreach ($files as $file) {

                                if (pathinfo($file, PATHINFO_EXTENSION) === "mp3") {

                            ?>

                                    <li
                                        data-src="<?= $folder . '/' . $file ?>"
                                        data-title="<?= pathinfo($file, PATHINFO_FILENAME) ?>">

                                        <img class="invert" width="34" src="img/music.svg" alt="">

                                        <div class="info">
                                            <div>
                                                <?= pathinfo($file, PATHINFO_FILENAME) ?>
                                            </div>

                                            <div>
                                                Unknown Artist
                                            </div>
                                        </div>

                                        <div class="playnow">
                                            <span>Play Now</span>
                                            <img class="invert" src="img/play.svg" alt="">
                                        </div>

                                    </li>

                            <?php
                                }
                            }
                            ?>

                        </ul>
                    </div>
                </div>

                <div class="footer">
                    <div><a href="https://www.spotify.com/jp/legal/"><span>Legal</span></a></div>
                    <div><a href="https://www.spotify.com/jp/privacy/"><span>Privacy Center</span></a></div>
                    <div><a href="https://www.spotify.com/jp/legal/privacy-policy/"><span>Privacy Policy</span></a>
                    </div>
                    <div><a href="https://www.spotify.com/jp/legal/cookies-policy/"><span>Cookies</span></a></div>
                    <div><a href="https://www.spotify.com/jp/legal/privacy-policy/#s3"><span>About Ads</span></a></div>
                    <div><a href="https://www.spotify.com/jp/accessibility/"><span>Accessibility</span></a></div>
                </div>
            </div>
        </div>
        <div class="right bg-grey rounded">
            <!-- <div class="header">
                <div class="nav">
                    <div class="hamburgerContainer">

                        <img width="40" class="invert hamburger" src="img/hamburger.svg" alt="">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 6L9.70711 11.2929C9.37377 11.6262 9.20711 11.7929 9.20711 12C9.20711 12.2071 9.37377 12.3738 9.70711 12.7071L15 18"
                                stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9 18L14.2929 12.7071C14.6262 12.3738 14.7929 12.2071 14.7929 12C14.7929 11.7929 14.6262 11.6262 14.2929 11.2929L9 6"
                                stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="buttons">
                    <?php if (isset($_SESSION['loginedin'])) { ?>
                        <?php echo $_SESSION['loginemail']; ?>
                        <button class="loginbtn" onclick="window.location.href='logout.php'">log out</button>

                    <?php } else { ?>
                        <button class="signupbtn" onclick="window.location.href='login.php'">Sign up</button>
                        <button class="loginbtn" onclick="window.location.href='login.php'">Log in</button>
                    <?php } ?>
                </div>
            </div> -->
            <div class="spotifyPlaylists">
                <h1>Spotify Playlists</h1>


                <div class="cardContainer">
                    <?php while ($album = $albums->fetch_assoc()): ?>
                        <div class="card"
                            data-id="<?= $album['id'] ?>"
                            data-folder="<?= $album['folder_name'] ?>"
                            onclick="window.location='index.php?album=<?= $album['id'] ?>'">
                            <div class="play">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 20V4L19 12L5 20Z" fill="#000" stroke="#141B34" stroke-width="1.5" />
                                </svg>
                            </div>
                            <img src="songs/<?= $album['folder_name'] ?>/cover.jpg" alt="<?= $album['title'] ?>">
                            <h2><?= $album['title'] ?></h2>
                            <p><?= $album['description'] ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="playbar">
                    <div class="seekbar">
                        <div class="circle">

                        </div>
                    </div>
                    <div class="abovebar">


                        <div class="songinfo">

                        </div>
                        <div class="songbuttons">
                            <img width="25" id="previous" src="img/prevsong.svg" alt="">
                            <img width="25" id="play" src="img/play.svg" alt="">
                            <img width="25" id="next" src="img/nextsong.svg" alt="">
                        </div>
                        <div class="timevol">


                            <div class="songtime">

                            </div>
                            <div class="volume">
                                <img width="20" src="img/volume.svg" alt="">
                                <div class="range">
                                    <input type="range" name="volume" id="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>