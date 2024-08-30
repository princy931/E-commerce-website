<?php
include('includes/db.php');

// Fetch all movies
$movies = $conn->query("SELECT * FROM movies ORDER BY release_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Movie Ticket Booking</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to Movie Ticket Booking</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </nav>
    </header>
    
    <main>
        <h2>Now Showing</h2>
        <div class="movies">
            <?php while($movie = $movies->fetch_assoc()): ?>
                <div class="movie">
                    <!-- Ensure correct path and filename in src attribute -->
                    <?php 
                        $posterPath = $movie['poster'];
                        
                        // Check if it's a relative path and convert it to an absolute path if needed
                        if (strpos($posterPath, 'http://') === false && strpos($posterPath, 'https://') === false) {
                            $posterPath = './assets/images/' . basename($posterPath);
                        }
                        
                        // Check if the file exists or if it's a valid URL
                        if (file_exists(__DIR__ . '/' . $posterPath) || filter_var($posterPath, FILTER_VALIDATE_URL)) {
                            echo '<img src="' . $posterPath . '" alt="' . $movie['title'] . '">';
                        } else {
                            echo '<p>Image not found for ' . $movie['title'] . '</p>';
                        }
                    ?>
                    <h3><?php echo $movie['title']; ?></h3>
                    <p>Genre: <?php echo $movie['genre']; ?></p>
                    <p>Duration: <?php echo $movie['duration']; ?> minutes</p>
                    <p>Release Date: <?php echo $movie['release_date']; ?></p>
                    <a href="booking.php?id=<?php echo $movie['id']; ?>">View Details & Book</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2024 Movie Ticket Booking. All Rights Reserved.</p>
    </footer>
    
    <script src="./assets/js/script.js"></script>
</body>
</html>

