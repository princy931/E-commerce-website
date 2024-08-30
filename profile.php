<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <main>
        <h2>Profile</h2>
        <p>Name: <?php echo $user['name']; ?></p>
        <p>Email: <?php echo $user['email']; ?></p>
        <p>Phone: <?php echo $user['phone']; ?></p>
        <p>Address: <?php echo $user['address']; ?></p>
    </main>

    <?php include('includes/footer.php'); ?>
    
    <script src="assets/js/script.js"></script>
</body>
</html>