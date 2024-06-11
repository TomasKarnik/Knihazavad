<?php
// Establishing connection to the database
$servername = "localhost";
$username = "---";
$password = "-----";
$database = "-----";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $receiving_date = $_POST["receiving_date"];
    $place = $_POST["place"];
    $issue_description = $_POST["issue_description"];
    $maintenance_person = $_POST["maintenance_person"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $is_done = isset($_POST["is_done"]) ? 1 : 0;
    $note_from_maintenance = $_POST["note_from_maintenance"];

    // Convert empty strings to NULL
    $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
    $end_date = !empty($end_date) ? "'$end_date'" : "NULL";
    $note_from_maintenance = !empty($note_from_maintenance) ? "'$note_from_maintenance'" : "NULL";

    // Updating data in the Tickets table
    $sql = "UPDATE Tickets
            SET ReceivingDate = '$receiving_date', Place = '$place', IssueDescription = '$issue_description',
                MaintenancePerson = '$maintenance_person', StartDate = $start_date, EndDate = $end_date,
                IsDone = $is_done, NoteFromMaintenance = $note_from_maintenance
            WHERE TicketID = $id";

    // For debugging: Echo the SQL query
    echo "SQL query: $sql";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect to zavady.php after updating the ticket
    header("Location: zavady.php");
    exit(); // Make sure to exit after the redirect
}

$conn->close();
?>

