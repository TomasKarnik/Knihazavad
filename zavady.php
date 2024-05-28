<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<nav>
            <ul>
                <li><a href="zavady.php">Kniha závad</a></li>
                <li><a href="add_ticket.html">Nahlaš závadu</a></li>
            </ul>
        </nav>
    <h1>Kniha závad</h1>
    <table>
        <tr>
            <th>Ticket ID</th>
            <th>Receiving Date</th>
            <th>Place</th>
            <th>Issue Description</th>
            <th>Reported By</th>
            <th>Maintenance Person</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Note from Maintenance</th>
            <th>Edit</th>
        </tr>
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

        // Fetching data from the Tickets table
        $sql = "SELECT * FROM Tickets";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Outputting data rows
            while($row = $result->fetch_assoc()) {
                // Determine row color based on IsDone
                $row_class = $row["IsDone"] == 1 ? "green" : "";

                // Truncate text if it exceeds 50 characters
                $issue_description = (strlen($row["IssueDescription"]) > 50) ? substr($row["IssueDescription"], 0, 50) . '...' : $row["IssueDescription"];
                $note_from_maintenance = (strlen($row["NoteFromMaintenance"]) > 50) ? substr($row["NoteFromMaintenance"], 0, 50) . '...' : $row["NoteFromMaintenance"];

                echo "<tr class='$row_class'>
                        <td>".$row["TicketID"]."</td>
                        <td>".$row["ReceivingDate"]."</td>
                        <td>".$row["Place"]."</td>
                        <td>".$issue_description."</td>
                        <td>".$row["ReportedByName"]."</td>
                        <td>".$row["MaintenancePerson"]."</td>
                        <td>".$row["StartDate"]."</td>
                        <td>".$row["EndDate"]."</td>
                        <td>".$note_from_maintenance."</td>
                        <td><a href='edit_ticket.php?id=".$row["TicketID"]."'>Edit</a></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No tickets found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
