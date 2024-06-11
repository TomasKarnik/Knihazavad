<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Establishing connection to the database
$servername = "localhost";
$username = "------";
$password = "------";
$database = "------";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receiving_date = date("Y-m-d"); // Set receiving date to current date
    $place = $conn->real_escape_string($_POST["place"]);
    $issue_description = $conn->real_escape_string($_POST["issue_description"]);
    $reported_by_name = $conn->real_escape_string($_POST["reported_by_name"]); // New field

    // Inserting data into the Tickets table
    $sql = "INSERT INTO Tickets (ReceivingDate, Place, IssueDescription, ReportedByName, StartDate, EndDate)
            VALUES ('$receiving_date', '$place', '$issue_description', '$reported_by_name', NULL, NULL)";

    if ($conn->query($sql) === TRUE) {
        // Send email notification
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sender mail';
            $mail->Password = 'Pass';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Enable verbose debug output
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = 'html'; // Outputs debug information in HTML format

            // Recipients
            $mail->setFrom('mail@domain.cz', 'Ticket System');
            $mail->addAddress('mail@sdomain.cz', 'Recipient Name');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Ticket Added';
            $mail->Body = "A new ticket has been added:<br>
                           <strong>Place:</strong> $place<br>
                           <strong>Description:</strong> $issue_description<br>
                           <strong>Reported By:</strong> $reported_by_name<br>
                           <strong>Receiving Date:</strong> $receiving_date";

            $mail->send();
            echo 'Email has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Redirect to index.html after adding the ticket
        header("Location: index.html");
        exit(); // Make sure to exit after the redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
