<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABASE</title>
    <style>

        body
            {
                background-color: #3a3b3c;
                color: white;
            }

        .container 
            {
                max-width: 600px;
                margin: auto;
            }

        table 
            {
                border: 1px solid #ddd;
                border-collapse: collapse;
                margin: 20px auto;
            }

        th, td 
            {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

    </style>
</head>
<body>
<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "confirm_booking";

// Create a new mysqli connection
$conn = new mysqli($servername, $username, $password);

// Check connection and handle errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create or use an existing database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {

    // Select the created or existing database
    $conn->select_db($dbname);

    // Create a table if it doesn't exist
    $tableSql = "CREATE TABLE IF NOT EXISTS reservations (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        visitor_name VARCHAR(30) NOT NULL,
        visitor_email VARCHAR(50) NOT NULL,
        visitor_phone VARCHAR(15) NOT NULL,
        total_adults INT(2) NOT NULL,
        total_children INT(2) NOT NULL,
        checkin DATE NOT NULL,
        checkout DATE NOT NULL,
        room_preference VARCHAR(20) NOT NULL,
        visitor_message TEXT NOT NULL,
        hotel VARCHAR(50) NOT NULL,
        total DECIMAL(10,2) NOT NULL
    )";

    // Check if table creation was successful
    if ($conn->query($tableSql) === FALSE) {
        echo "Error creating table: " . $conn->error;
    } else {
        // Retrieve form data submitted via POST method
        // (Assuming form fields are named 'visitor_name', 'visitor_email', etc.)
        $visitor_name = $_POST['visitor_name'];
        $visitor_email = $_POST['visitor_email'];
        $visitor_phone = $_POST['visitor_phone'];
        $total_adults = $_POST['total_adults'];
        $total_children = $_POST['total_children'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $room_preference = $_POST['room_preference'];
        $visitor_message = $_POST['visitor_message'];
        $hotel = $_POST['hotel'];
        $total = $_POST['total'];

        // Display a confirmation message to the user
        echo "Hello $visitor_name! Your info has been added to the database<br>";
        echo "Your check-in date is $checkin at the $hotel <br><br>";

        // Display submitted data in a table
        $table = "<table border='1'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Room Preference</th>
                    <th>Message</th>
                    <th>Hotel</th>
                    <th>Total (OMR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>$visitor_name</td>
                    <td>$visitor_email</td>
                    <td>$visitor_phone</td>
                    <td>$total_adults</td>
                    <td>$total_children</td>
                    <td>$checkin</td>
                    <td>$checkout</td>
                    <td>$room_preference</td>
                    <td>$visitor_message</td>
                    <td>$hotel</td>
                    <td>$total</td>
                </tr>
            </tbody>
        </table>";

        // Display the table
        echo $table;

        // Prepare and execute a SQL statement to insert data into the 'reservations' table
        $insertSql = "INSERT INTO reservations (visitor_name, visitor_email, visitor_phone, total_adults, total_children, checkin, checkout, room_preference, visitor_message, hotel, total)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("sssiisssssd", $visitor_name, $visitor_email, $visitor_phone, $total_adults, $total_children, $checkin, $checkout, $room_preference, $visitor_message, $hotel, $total);

        // Check if the insertion was successful and provide feedback to the user
        if ($stmt->execute()) {
            echo "<a href=confirmBooking.html><button>Go Back</button></a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
} else {
    // Display an error message if database creation fails
    echo "Error creating database: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
 
</body>
</html>