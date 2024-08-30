<?php
include('../includes/db.php');
session_start();

$result = $conn->query("SELECT bookings.id, users.name AS user_name, movies.title AS movie_title, theaters.name AS theater_name, showtimes.date, showtimes.time, seats.seat_row, seats.seat_number, bookings.payment_status FROM bookings 
    JOIN users ON bookings.user_id = users.id
    JOIN showtimes ON bookings.showtime_id = showtimes.id
    JOIN movies ON showtimes.movie_id = movies.id
    JOIN theaters ON showtimes.theater_id = theaters.id
    JOIN seats ON bookings.seat_id = seats.id");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings</title>
</head>
<body>
    <h1>Manage Bookings</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Movie</th>
            <th>Theater</th>
            <th>Date</th>
            <th>Time</th>
            <th>Seat</th>
            <th>Payment Status</th>
        </tr>
        <?php while($booking = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $booking['id']; ?></td>
                <td><?php echo $booking['user_name']; ?></td>
                <td><?php echo $booking['movie_title']; ?></td>
                <td><?php echo $booking['theater_name']; ?></td>
                <td><?php echo $booking['date']; ?></td>
                <td><?php echo $booking['time']; ?></td>
                <td><?php echo $booking['seat_row'] . $booking['seat_number']; ?></td>
                <td><?php echo $booking['payment_status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>