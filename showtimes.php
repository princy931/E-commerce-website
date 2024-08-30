<!-- <?php
include('includes/db.php');

$movie_id = $_GET['movie_id'];
$result = $conn->query("SELECT * FROM showtimes WHERE movie_id=$movie_id");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Showtimes</title>
</head>
<body>
    <h1>Showtimes</h1>
    <div>
        <?php while($showtime = $result->fetch_assoc()): ?>
            <div>
                <p>Date: <?php echo $showtime['date']; ?></p>
                <p>Time: <?php echo $showtime['time']; ?></p>
                <a href="booking.php?showtime_id=<?php echo $showtime['id']; ?>">Book Now</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html> -->
<?php
include('includes/db.php');

// Fetch movie details
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
    echo "Invalid Movie ID.";
    exit();
}

// Fetch showtimes for this movie
$showtimes = $conn->query("SELECT showtimes.id, showtimes.show_time, theaters.name as theater_name, theaters.location 
                            FROM showtimes 
                            JOIN theaters ON showtimes.theater_id = theaters.id 
                            WHERE movie_id = $movie_id 
                            ORDER BY show_time ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Showtime - <?php echo $movie['title']; ?></title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header>
        <h1>Select Showtime for <?php echo $movie['title']; ?></h1>
    </header>
    
    <main>
        <h2>Available Showtimes</h2>
        <?php if ($showtimes->num_rows > 0): ?>
            <ul>
                <?php while($showtime = $showtimes->fetch_assoc()): ?>
                    <li>
                        <strong><?php echo $showtime['show_time']; ?></strong> - 
                        <?php echo $showtime['theater_name'] . ', ' . $showtime['location']; ?>
                        <a href="select_seat.php?showtime_id=<?php echo $showtime['id']; ?>">Select Seats</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No showtimes available for this movie.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Movie Ticket Booking. All Rights Reserved.</p>
    </footer>
</body>
</html>
