<?php
// Establishing connection to the database
$servername = "localhost";
$username = "vratnice";
$password = "Vratnice.Infotex1";
$database = "knihazavad";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receiving_date = date("Y-m-d"); // Set receiving date to current date
    $place = $_POST["place"];
    $issue_description = $_POST["issue_description"];
    $reported_by_name = $_POST["reported_by_name"]; // New field
    $start_date = NULL; // Set start date to NULL
    $end_date = NULL; // Set end date to NULL

    // Inserting data into the Tickets table
    $sql = "INSERT INTO Tickets (ReceivingDate, Place, IssueDescription, ReportedByName, StartDate, EndDate) 
            VALUES ('$receiving_date', '$place', '$issue_description', '$reported_by_name', '$start_date', '$end_date')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect to index.html after adding the ticket
    header("Location: index.html");
    exit(); // Make sure to exit after the redirect
}

$conn->close();
?>
