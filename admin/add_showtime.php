<?php
include('../includes/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $theater_id = $_POST['theater_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO showtimes (movie_id, theater_id, date, time) VALUES ('$movie_id', '$theater_id', '$date', '$time')";
    if ($conn->query($sql) === TRUE) {
        echo "Showtime added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch movies and theaters for dropdowns
$movies = $conn->query("SELECT * FROM movies");
$theaters = $conn->query("SELECT * FROM theaters");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Showtime</title>
</head>
<body>
    <h1>Add Showtime</h1>
    <form method="POST" action="add_showtime.php">
        Movie: 
        <select name="movie_id" required>
            <?php while($movie = $movies->fetch_assoc()): ?>
                <option value="<?php echo $movie['id']; ?>"><?php echo $movie['title']; ?></option>
            <?php endwhile; ?>
        </select><br>
        Theater: 
        <select name="theater_id" required>
            <?php while($theater = $theaters->fetch_assoc()): ?>
                <option value="<?php echo $theater['id']; ?>"><?php echo $theater['name']; ?></option>
            <?php endwhile; ?>
        </select><br>
        Date: <input type="date" name="date" required><br>
        Time: <input type="time" name="time" required><br>
        <button type="submit">Add Showtime</button>
    </form>
</body>
</html>