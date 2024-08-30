<!-- <?php
include('includes/db.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $seats = $_POST['seats'];
    $showtime_id = $_POST['showtime_id'];

    $sql = "INSERT INTO bookings (user_id, showtime_id, seats, booking_time) VALUES ('$user_id', '$showtime_id', '$seats', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Movie</title>
    <link rel="stylesheet" href="./assets/css/booking.css" >
</head>
<body>
<?php 
                        $posterPath = $movie['poster'];
                        
                        // Check if it's a relative path and convert it to an absolute path if needed
                        if (strpos($posterPath, 'http://') === false && strpos($posterPath, 'https://') === false) {
                            $posterPath = './assets/images/' . basename($posterPath);
                        }
                        
                        // Check if the file exists or if it's a valid URL
                        if (file_exists(__DIR__ . '/' . $posterPath) || filter_var($posterPath, FILTER_VALIDATE_URL)) {
                            echo '<img src="' . $posterPath . '" alt="' . $movie['title'] . '" style="height:300px; width: 40%;">';
                        } else {
                            echo '<p>Image not found for ' . $movie['title'] . '</p>';
                        }
                    ?>
    <h2>Book Movie: <?php echo $movie['title']; ?></h2>
    <p>Genre: <?php echo $movie['genre']; ?></p>
    <p>Duration: <?php echo $movie['duration']; ?> minutes</p>
    <p>Release Date: <?php echo $movie['release_date']; ?></p>

    <form method="POST" action="booking.php?id=<?php echo $movie_id; ?>">
        Seats: <input type="number" name="seats" required><br>
        Showtime: 
        <select name="showtime_id" required>
            <!-- Populate showtimes from the database -->
            <?php
            $showtimes_sql = "SELECT * FROM showtimes WHERE movie_id = $movie_id";
            $showtimes_result = $conn->query($showtimes_sql);

            while ($showtime = $showtimes_result->fetch_assoc()) {
                echo '<option value="' . $showtime['id'] . '">' . $showtime['show_time'] . '</option>';
            }
            ?>
        </select><br>
        <button type="submit">Book Now</button>
    </form>
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

// Handle booking submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_showtime = $_POST['showtime'];
    $selected_seats = $_POST['seats'];

    // You can add further processing here, such as storing the booking details in the database or redirecting to a payment page.
    // For now, let's just display the selected information.
    echo "You have selected $selected_seats seats for the showtime on " . $selected_showtime . ".";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Movie: <?php echo $movie['title']; ?></title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header>
        <h1>Book Movie: <?php echo $movie['title']; ?></h1>
    </header>
    
    <main>
        <div class="movie-details">
            <img src="<?php echo $movie['poster']; ?>" alt="<?php echo $movie['title']; ?>" class="movie-poster">
            <div class="movie-info">
                <h2><?php echo $movie['title']; ?></h2>
                <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
                <p><strong>Duration:</strong> <?php echo $movie['duration']; ?> minutes</p>
                <p><strong>Release Date:</strong> <?php echo $movie['release_date']; ?></p>
            </div>
        </div>

        <form method="POST" action="booking.php?id=<?php echo $movie_id; ?>">
            <div class="form-group">
                <label for="showtime">Showtime:</label>
                <select name="showtime" id="showtime" required>
                    <option value="">Select Showtime</option>
                    <?php while($showtime = $showtimes->fetch_assoc()): ?>
                        <option value="<?php echo $showtime['show_time']; ?>">
                            <?php echo $showtime['show_time'] . " - " . $showtime['theater_name'] . ", " . $showtime['location']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="seats">Seats:</label>
                <input type="number" id="seats" name="seats" min="1" max="10" required>
            </div>

            <button type="submit" class="btn">Book Now</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Movie Ticket Booking. All Rights Reserved.</p>
    </footer>
</body>
</html>


