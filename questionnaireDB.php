<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionnaire</title>

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
$dbname = "questionnaire";

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
    $tableSql = "CREATE TABLE IF NOT EXISTS feedback (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        yourName VARCHAR(30) NOT NULL,
        services VARCHAR(30) NOT NULL,
        experience VARCHAR(30) NOT NULL,
        comments VARCHAR(50) NOT NULL
    )";

    // Check if table creation was successful
    if ($conn->query($tableSql) === FALSE) {
        echo "Error creating table: " . $conn->error;
    } else {
        // Retrieve form data submitted via POST method
        // (Assuming form fields are named 'yourName', 'services', etc.)
        $name = $_POST["yourName"];
        $services = $_POST["services"];
        $experience = $_POST["experience"];
        $comments = $_POST["comments"];

        // Display a thank you message to the user
        echo "Hello $name! Thank you for your feedback. We will improve based on your input - Hotel & Co Staff! <br><br>";

        // Display submitted data in a table
        $table = "<table border='1'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Services</th>
                    <th>Experience</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>$name</td>
                    <td>$services</td>
                    <td>$experience</td>
                    <td>$comments</td>
                </tr>
            </tbody>
        </table>";

        // Display the table
        echo $table;

        // Prepare and execute a SQL statement to insert data into the 'feedback' table
        $insertSql = "INSERT INTO feedback (yourName, services, experience, comments)
                      VALUES (?,?,?,?)";

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ssss", $name, $services, $experience, $comments);

        // Check if the insertion was successful and provide feedback to the user
        if ($stmt->execute()) {
            echo "<a href='Questionnaire.html'><button>Go Back</button></a>";
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