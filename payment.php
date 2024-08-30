<?php
include('includes/db.php');

session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch movie and showtime details
if (isset($_GET['showtime_id']) && isset($_GET['seats'])) {
    $showtime_id = $_GET['showtime_id'];
    $seats = $_GET['seats'];

    $sql = "SELECT movies.title, showtimes.show_time, theaters.name as theater_name, theaters.location 
            FROM showtimes 
            JOIN movies ON showtimes.movie_id = movies.id 
            JOIN theaters ON showtimes.theater_id = theaters.id 
            WHERE showtimes.id = $showtime_id";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $showtime = $result->fetch_assoc();
    } else {
        echo "Invalid Showtime.";
        exit();
    }
} else {
    echo "Invalid Request.";
    exit();
}

// Handle payment form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    // Here, you would typically integrate with a payment gateway API.
    // For this example, we'll simulate a successful payment.

    $booking_time = date("Y-m-d H:i:s");

    // Insert booking record
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO bookings (user_id, showtime_id, seats, booking_time) 
            VALUES ('$user_id', '$showtime_id', '$seats', '$booking_time')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Payment successful! Your booking has been confirmed.";
        // Redirect to a confirmation page
        header("Location: confirmation.php?booking_id=" . $conn->insert_id);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header>
        <h1>Payment for <?php echo $showtime['title']; ?></h1>
    </header>
    
    <main>
        <h2>Showtime Details</h2>
        <p><strong>Movie:</strong> <?php echo $showtime['title']; ?></p>
        <p><strong>Theater:</strong> <?php echo $showtime['theater_name'] . ', ' . $showtime['location']; ?></p>
        <p><strong>Showtime:</strong> <?php echo $showtime['show_time']; ?></p>
        <p><strong>Seats:</strong> <?php echo $seats; ?></p>

        <h2>Payment Details</h2>
        <form method="POST" action="payment.php?showtime_id=<?php echo $showtime_id; ?>&seats=<?php echo $seats; ?>">
            <label for="card_number">Card Number:</label>
            <input type="text" id="card_number" name="card_number" required>

            <label for="expiry_date">Expiry Date:</label>
            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" required>

            <button type="submit">Pay Now</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Movie Ticket Booking. All Rights Reserved.</p>
    </footer>
</body>
</html>
