<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$song_id = (int)$_POST['song_id'];
$rating = (int)$_POST['rating'];
$review = trim($_POST['review']);

$stmt = $conn->prepare("
    INSERT INTO reviews
    (user_id,song_id,rating,review)
    VALUES (?,?,?,?)
");

$stmt->bind_param(
    "iiis",
    $user_id,
    $song_id,
    $rating,
    $review
);

$stmt->execute();

echo "success";
