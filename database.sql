CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(15),
    address TEXT
);


CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    genre VARCHAR(100),
    description TEXT,
    duration INT,
    release_date DATE,
    poster VARCHAR(255)
);

CREATE TABLE showtimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT,
    theater_id INT,
    show_time DATETIME,
    FOREIGN KEY (movie_id) REFERENCES movies(id),
    FOREIGN KEY (theater_id) REFERENCES theaters(id)
);

CREATE TABLE theaters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    location VARCHAR(255)
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    showtime_id INT,
    seats INT,
    booking_time DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (showtime_id) REFERENCES showtimes(id)
);

INSERT INTO movies (title, genre, description, duration, release_date, poster) VALUES
('Movie 1', 'Action', 'Description of Movie 1', 120, '2024-01-01', 'https://via.placeholder.com/300x450?text=Movie+Poster+1'),
('Movie 2', 'Drama', 'Description of Movie 2', 90, '2024-02-01', 'https://via.placeholder.com/300x450?text=Movie+Poster+2'),
('Movie 3', 'Drama', 'Description of Movie 3', 140, '2024-02-01', 'https://via.placeholder.com/300x450?text=Movie+Poster+2');

INSERT INTO movies (title, genre, description, duration, release_date, poster) VALUE
('fukrey','comendy','nice',120,'2024-03-01','../assets/images/fukrey.jpg');

CREATE TABLE showtimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT,
    theater_id INT,
    show_time DATETIME,
    available_seats INT,
    FOREIGN KEY (movie_id) REFERENCES movies(id),
    FOREIGN KEY (theater_id) REFERENCES theaters(id)
);

INSERT INTO showtimes (movie_id, theater_id, show_time, available_seats)
VALUES
(1, 1, '2024-08-10 18:00:00', 50),
(1, 1, '2024-08-10 21:00:00', 45),
(2, 1, '2024-08-11 17:30:00', 60),
(2, 1, '2024-08-11 20:30:00', 40);

CREATE TABLE seats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    showtime_id INT,
    seat_row CHAR(1),
    seat_number INT,
    is_booked BOOLEAN DEFAULT 0,
    FOREIGN KEY (showtime_id) REFERENCES showtimes(id)
);

INSERT INTO seats (showtime_id, seat_row, seat_number)
VALUES
(1, 'A', 1), (1, 'A', 2), (1, 'A', 3), (1, 'A', 4), (1, 'A', 5),
(1, 'B', 1), (1, 'B', 2), (1, 'B', 3), (1, 'B', 4), (1, 'B', 5),
(2, 'A', 1), (2, 'A', 2), (2, 'A', 3), (2, 'A', 4), (2, 'A', 5),
(2, 'B', 1), (2, 'B', 2), (2, 'B', 3), (2, 'B', 4), (2, 'B', 5);
