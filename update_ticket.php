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
    $id = $_POST["id"];
    $receiving_date = $_POST["receiving_date"];
    $place = $_POST["place"];
    $issue_description = $_POST["issue_description"];
    $maintenance_person = $_POST["maintenance_person"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $is_done = isset($_POST["is_done"]) ? 1 : 0;
    $note_from_maintenance = $_POST["note_from_maintenance"];

    // Updating data in the Tickets table
    $sql = "UPDATE Tickets 
            SET ReceivingDate = '$receiving_date', Place = '$place', IssueDescription = '$issue_description', 
                MaintenancePerson = '$maintenance_person', StartDate = '$start_date', EndDate = '$end_date', 
                IsDone = $is_done, NoteFromMaintenance = '$note_from_maintenance' 
            WHERE TicketID = $id";
    
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
