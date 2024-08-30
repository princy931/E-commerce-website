<?php
include('../includes/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $release_date = $_POST['release_date'];
    $poster = $_POST['poster'];  // Changed to use link

    $sql = "INSERT INTO movies (title, genre, description, duration, release_date, poster) VALUES ('$title', '$genre', '$description', '$duration', '$release_date', '$poster')";
    if ($conn->query($sql) === TRUE) {
        echo "Movie added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Movie</title>
</head>
<body>
    <h1>Add Movie</h1>
    <form method="POST" action="add_movie.php">
        Title: <input type="text" name="title" required><br>
        Genre: <input type="text" name="genre" required><br>
        Description: <textarea name="description" required></textarea><br>
        Duration: <input type="number" name="duration" required><br>
        Release Date: <input type="date" name="release_date" required><br>
        Poster Link: <input type="text" name="poster" required><br>
        <button type="submit">Add Movie</button>
    </form>
</body>
</html>