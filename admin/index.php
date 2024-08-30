<?php
include('../includes/db.php');
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <nav>
        <a href="add_movie.php">Add Movie</a>
        <a href="add_showtime.php">Add Showtime</a>
        <a href="manage_bookings.php">Manage Bookings</a>
    </nav>
</body>
</html>