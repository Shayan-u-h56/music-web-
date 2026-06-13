<?php
session_start();
include("connection.php");

// Admin check
if ($_SESSION['rol_id'] != 2) {
    header("Location: index.php");
    exit();
}
// Users list
if (isset($_GET['search'])) {
    $search   = $_GET['search'];
    $usersRes = mysqli_query($conn, "SELECT * FROM userdetails WHERE u_name LIKE '%$search%'");
} else {
    $usersRes = mysqli_query($conn, "SELECT * FROM userdetails");
}

// Active section
$section = isset($_GET['section']) ? $_GET['section'] : 'songs';



// Song add
if (isset($_POST['add_song'])) {
    $title     = $_POST['title'];
    $artist_id = $_POST['artist_id'];

    // Artist name artists table se lo
    $aRes    = mysqli_query($conn, "SELECT name FROM artists WHERE id = $artist_id");
    $aRow    = mysqli_fetch_assoc($aRes);
    $artist  = $aRow['name'];

    // Files upload
    $cover = $_FILES['cover_image']['name'];
    $audio = $_FILES['audio_file']['name'];
    move_uploaded_file($_FILES['cover_image']['tmp_name'], "img/covers/$cover");
    move_uploaded_file($_FILES['audio_file']['tmp_name'], "songs/$audio");

    mysqli_query($conn, "INSERT INTO songs (title, artist, artist_id, cover_image, audio_file) VALUES ('$title', '$artist', $artist_id, '$cover', '$audio')");
    header("Location: admin.php?section=songs&msg=song_added");
    exit();
}

// Songs list
$songsRes  = mysqli_query($conn, "SELECT * FROM songs");
$songsList = mysqli_fetch_all($songsRes, MYSQLI_ASSOC);

// Artists dropdown ke liye
$artistsRes  = mysqli_query($conn, "SELECT * FROM artists");
$artistsList = mysqli_fetch_all($artistsRes, MYSQLI_ASSOC);

// Song delete
if (isset($_GET['delete_song'])) {
    $songId = $_GET['delete_song'];
    mysqli_query($conn, "DELETE FROM songs WHERE id = $songId");
    header("Location: admin.php?section=songs&msg=song_deleted");
    exit();
}



// Video add
if (isset($_POST['add_video'])) {
    $title = $_POST['title'];

    $thumbnail  = $_FILES['thumbnail']['name'];
    $video_file = $_FILES['video_file']['name'];
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], "img/thumbnails/$thumbnail");
    move_uploaded_file($_FILES['video_file']['tmp_name'], "videos/$video_file");

    mysqli_query($conn, "INSERT INTO videos (title, thumbnail, video_file) VALUES ('$title', '$thumbnail', '$video_file')");
    header("Location: admin.php?section=videos&msg=video_added");
    exit();
}

// Videos list
$videosRes  = mysqli_query($conn, "SELECT * FROM videos");
$videosList = mysqli_fetch_all($videosRes, MYSQLI_ASSOC);

// Video delete
if (isset($_GET['delete_video'])) {
    $videoId =$_GET['delete_video'];
    mysqli_query($conn, "DELETE FROM videos WHERE id = $videoId");
    header("Location: admin.php?section=videos&msg=video_deleted");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>

    <div class="admin-layout">

        <!-- SIDEBAR -->
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <svg viewBox="0 0 32 32" fill="none" width="26" height="26">
                    <circle cx="16" cy="16" r="15" fill="#1db954" />
                    <circle cx="16" cy="16" r="7" fill="#000" opacity="0.55" />
                    <circle cx="16" cy="16" r="3" fill="#1db954" />
                    <line x1="16" y1="1" x2="16" y2="9" stroke="#000" stroke-width="2.5" />
                </svg>
                Music<span>Admin</span>
            </div>

            <nav class="admin-nav">
                <a href="admin.php?section=users"
                    class="admin-nav-item <?php if ($section == 'users') echo 'active'; ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                    Users
                </a>
                <a href="admin.php?section=songs"
                    class="admin-nav-item <?php if ($section == 'songs') echo 'active'; ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M9 18V5l12-2v13" />
                        <circle cx="6" cy="18" r="3" />
                        <circle cx="18" cy="16" r="3" />
                    </svg>
                    Songs
                </a>

                <a href="admin.php?section=videos"
                    class="admin-nav-item <?php if ($section == 'videos') echo 'active'; ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <rect x="2" y="3" width="20" height="14" rx="2" />
                        <path d="M8 21h8M12 17v4" />
                    </svg>
                    Videos
                </a>
            </nav>

            <div class="admin-sidebar-bottom">
                <?php if (isset($_SESSION['loginedin'])) { ?>
                    <div class="admin-user-info">
                        <div class="admin-user-avatar">
                            <?php echo strtoupper(substr($_SESSION['loginemail'], 0, 1)); ?>
                        </div>
                        <div class="admin-user-email"><?php echo $_SESSION['loginemail']; ?></div>
                    </div>
                    <a href="logout.php" class="btn-logout">Logout</a>
                    <a href="index.php" class="btn-home">← Back to Site</a>
                <?php } ?>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="admin-main">

            <!-- TOPBAR -->
            <div class="admin-topbar">
                <div class="admin-page-title">
                    <?php
                    if ($section == 'songs') {
                        echo '🎵 Songs';
                    }
                    if ($section == 'videos') {
                        echo '🎬 Videos';
                    }
                    if ($section == 'users') {
                        echo '👥 Users';
                    }
                    ?>
                </div>
                <?php if ($section == 'users') { ?>
                    <form action="" method="get" class="admin-search-form">
                        <input type="hidden" name="section" value="users">
                        <input class="admin-search" name="search" type="search" placeholder="Search users..."
                            value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button class="btn-search" type="submit">Search</button>
                    </form>
                <?php } ?>
            </div>

            <!-- ALERTS -->
            <?php if (isset($_GET['msg'])) { ?>
                <?php if ($_GET['msg'] == 'song_added') { ?>
                    <div class="admin-alert success">✓ Song added successfully!</div>
                <?php } ?>
                <?php if ($_GET['msg'] == 'song_deleted') { ?>
                    <div class="admin-alert danger">✓ Song deleted!</div>
                <?php } ?>
                <?php if ($_GET['msg'] == 'update') { ?>
                    <div class="admin-alert success">✓ User updated successfully!</div>
                <?php } ?>
                <?php if ($_GET['msg'] == 'delete') { ?>
                    <div class="admin-alert danger">✓ User deleted!</div>
                <?php } ?>
                <?php if ($_GET['msg'] == 'video_added') { ?>
                    <div class="admin-alert success">✓ Video added successfully!</div>
                <?php } ?>
                <?php if ($_GET['msg'] == 'video_deleted') { ?>
                    <div class="admin-alert danger">✓ Video deleted!</div>
                <?php } ?>
            <?php } ?>
            <!-- USERS SECTION -->
            <?php if ($section == 'users') { ?>
                <div class="admin-card">
                    <div class="admin-card-title">👥 All Users</div>
                    <div class="table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($usersRes)) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td>
                                            <?php if ($row['rol_id'] == 2) { ?>
                                                <span class="badge-admin">Admin</span>
                                            <?php } else { ?>
                                                <span class="badge-user">User</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $row['u_name']; ?></td>
                                        <td><?php echo $row['u_email']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td><?php echo $row['update_at']; ?></td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                                            <?php if ($_SESSION['user_id'] != $row['id']) { ?>
                                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete"
                                                    onclick="return confirm('Are you sure?')">Delete</a>

                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>

            <!-- SONGS SECTION -->
            <?php if ($section == 'songs') { ?>

                <!-- ADD FORM -->
                <div class="admin-card">
                    <div class="admin-card-title">➕ Add New Song</div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="song-form-grid">
                            <div class="form-group">
                                <label>Song Title</label>
                                <input type="text" name="title" placeholder="Enter song title" required>
                            </div>
                            <div class="form-group">
                                <label>Artist</label>
                                <select name="artist_id" required>
                                    <option value="">Select Artist</option>
                                    <?php foreach ($artistsList as $a) { ?>
                                        <option value="<?php echo $a['id']; ?>"><?php echo $a['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Cover Image</label>
                                <input type="file" name="cover_image" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label>Audio File</label>
                                <input type="file" name="audio_file" accept="audio/*" required>
                            </div>
                        </div>
                        <button type="submit" name="add_song" class="btn-add">Add Song</button>
                    </form>
                </div>

                <!-- SONGS LIST -->
                <div class="admin-card">
                    <div class="admin-card-title">🎵 All Songs</div>
                    <div class="table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    <th>Artist</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($songsList as $song) { ?>
                                    <tr>
                                        <td><?php echo $song['id']; ?></td>
                                        <td>
                                            <img src="img/covers/<?php echo $song['cover_image']; ?>"
                                                style="width:42px;height:42px;border-radius:6px;object-fit:cover;">
                                        </td>
                                        <td><?php echo $song['title']; ?></td>
                                        <td><?php echo $song['artist']; ?></td>
                                        <td>
                                            <a href="admin.php?section=songs&delete_song=<?php echo $song['id']; ?>"
                                                class="btn-delete" onclick="return confirm('Delete this song?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php } ?>
            <!-- VIDEOS SECTION -->
            <?php if ($section == 'videos') { ?>

                <!-- ADD VIDEO FORM -->
                <div class="admin-card">
                    <div class="admin-card-title">➕ Add New Video</div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="song-form-grid">
                            <div class="form-group">
                                <label>Video Title</label>
                                <input type="text" name="title" placeholder="Enter video title" required>
                            </div>
                            <div class="form-group">
                                <label>Thumbnail Image</label>
                                <input type="file" name="thumbnail" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label>Video File</label>
                                <input type="file" name="video_file" accept="video/*" required>
                            </div>
                        </div>
                        <button type="submit" name="add_video" class="btn-add">Add Video</button>
                    </form>
                </div>

                <!-- VIDEOS LIST -->
                <div class="admin-card">
                    <div class="admin-card-title">🎬 All Videos</div>
                    <div class="table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Thumbnail</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($videosList as $video) { ?>
                                    <tr>
                                        <td><?php echo $video['id']; ?></td>
                                        <td>
                                            <img src="img/thumbnails/<?php echo $video['thumbnail']; ?>"
                                                style="width:60px;height:38px;border-radius:6px;object-fit:cover;">
                                        </td>
                                        <td><?php echo $video['title']; ?></td>
                                        <td>
                                            <a href="admin.php?section=videos&delete_video=<?php echo $video['id']; ?>"
                                                class="btn-delete" onclick="return confirm('Delete this video?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php } ?>


        </main>
    </div>

</body>

</html>