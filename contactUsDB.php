<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

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
$dbname = "contactUS";

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
    $tableSql = "CREATE TABLE IF NOT EXISTS yourMessage (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(30) NOT NULL,
        lastName VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        userMessage VARCHAR(80) NOT NULL
    )";

    // Check if table creation was successful
    if ($conn->query($tableSql) === FALSE) {
        echo "Error creating table: " . $conn->error;
    } else {
        // Retrieve form data submitted via POST method
        // (Assuming form fields are named 'firstName', 'lastName', etc.)
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $userMessage = $_POST["userMessage"];

        // Display a confirmation message to the user
        echo "Hello $firstName! Your message has been sent to us. Thank you for the kind words :) <br><br>";

        // Display submitted data in a table
        $table = "<table border='1'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>$firstName</td>
                    <td>$lastName</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$userMessage</td>
                </tr>
            </tbody>
        </table>";

        // Display the table
        echo $table;

        // Prepare and execute a SQL statement to insert data into the 'yourMessage' table
        $insertSql = "INSERT INTO yourMessage (firstName, lastName, email, phone, userMessage)
                      VALUES (?,?,?,?,?)";

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $userMessage);

        // Check if the insertion was successful and provide feedback to the user
        if ($stmt->execute()) {
            echo "<a href='contact us.html'><button>Go Back</button></a>";
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