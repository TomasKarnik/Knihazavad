<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kniha závad</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<nav>
    <ul>
        <li><a href="zavady.php">Kniha závad</a></li>
        <li><a href="add_ticket.html">Nahlaš závadu</a></li>
        <li><a href="navod.html">Návod</a></li>
    </ul>
</nav>
<h1>Kniha závad</h1>
<table>
    <tr>
        <th>Ticket ID</th>
        <th>Datum přijetí</th>
        <th>Místo závady</th>
        <th>Popis závady</th>
        <th>Nahlásila osoba</th>
        <th>Zodpovědný údržbář</th>
        <th>Start</th>
        <th>Konec</th>
        <th>Poznámka od údržby</th>
        <th>Upravit</th>
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

    // Fetching data from the Tickets table, sorted by ReceivingDate in descending order
    $sql = "SELECT * FROM Tickets ORDER BY ReceivingDate DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Outputting data rows
        while ($row = $result->fetch_assoc()) {
            // Determine row color based on IsDone
            $row_class = $row["IsDone"] == 1 ? "green" : "";

            // Truncate text if it exceeds 50 characters
            $issue_description = (strlen($row["IssueDescription"]) > 50) ? substr($row["IssueDescription"], 0, 50) . '...' : $row["IssueDescription"];
            $note_from_maintenance = (strlen($row["NoteFromMaintenance"]) > 50) ? substr($row["NoteFromMaintenance"], 0, 50) . '...' : $row["NoteFromMaintenance"];

            echo "<tr class='$row_class'>
                    <td>" . $row["TicketID"] . "</td>
                    <td>" . $row["ReceivingDate"] . "</td>
                    <td>" . $row["Place"] . "</td>
                    <td>" . $issue_description . "</td>
                    <td>" . $row["ReportedByName"] . "</td>
                    <td>" . $row["MaintenancePerson"] . "</td>
                    <td>" . $row["StartDate"] . "</td>
                    <td>" . $row["EndDate"] . "</td>
                    <td>" . $note_from_maintenance . "</td>
                    <td><a href='edit_ticket.php?id=" . $row["TicketID"] . "'>Edit</a></td>
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
