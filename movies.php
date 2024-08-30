<!-- <?php
include('includes/db.php');

$result = $conn->query("SELECT * FROM movies");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Movies</title>
</head>
<body>
    <h1>Available Movies</h1>
    <div>
        <?php while($movie = $result->fetch_assoc()): ?>
            <div>
                <img src="assets/images/<?php echo $movie['poster']; ?>" alt="<?php echo $movie['title']; ?>">
                <h2><?php echo $movie['title']; ?></h2>
                <p><?php echo $movie['description']; ?></p>
                <a href="showtimes.php?movie_id=<?php echo $movie['id']; ?>">View Showtimes</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html> -->

<?php
include('includes/db.php');

if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];
    $sql = "SELECT * FROM movies WHERE id = $movie_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        echo "Movie not found.";
        exit();
    }
} else {
    echo "Invalid movie ID.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $movie['title']; ?></title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <h2><?php echo $movie['title']; ?></h2>
    <p>Genre: <?php echo $movie['genre']; ?></p>
    <p>Duration: <?php echo $movie['duration']; ?> minutes</p>
    <p>Release Date: <?php echo $movie['release_date']; ?></p>
    <a href="booking.php?id=<?php echo $movie_id; ?>">View Details & Book</a>
</body>
</html>
