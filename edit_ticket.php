<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ticket</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <h1>Uprav hlášení</h1>
    <?php
    // Establishing connection to the database
    $servername = "localhost";
    $username = "---";
    $password = "---";
    $database = "---";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $id = $_GET["id"];

        // Retrieving data for the selected ticket
        $sql = "SELECT * FROM Tickets WHERE TicketID = $id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            ?>
            <form action="update_ticket.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                
                <label for="receiving_date">Ticket přijmut:</label>
                <input type="date" id="receiving_date" name="receiving_date" value="<?php echo $row["ReceivingDate"]; ?>" readonly><br><br>
                
                <label for="place">Místo závady:</label>
                <input type="text" id="place" name="place" value="<?php echo $row["Place"]; ?>" required><br><br>
                
                <label for="issue_description">Popis závady:</label><br>
                <textarea id="issue_description" name="issue_description" rows="4" cols="50" required><?php echo $row["IssueDescription"]; ?></textarea><br><br>
                
                <label for="maintenance_person">Zodpovědný údržbář:</label>
                <input type="text" id="maintenance_person" name="maintenance_person" value="<?php echo $row["MaintenancePerson"]; ?>" required><br><br>
                
                <label for="start_date">Začalo se řešit:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo $row["StartDate"]; ?>"><br><br>
                
                <label for="end_date">Problém vyřešen:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo $row["EndDate"]; ?>"><br><br>

                <label for="note_from_maintenance">Poznámka od údržby:</label><br>
                <textarea id="note_from_maintenance" name="note_from_maintenance" rows="4" cols="50"><?php echo $row["NoteFromMaintenance"]; ?></textarea><br><br>

                <label for="is_done">Hotovo:</label>
                <input type="checkbox" id="is_done" name="is_done" <?php echo $row["IsDone"] ? "checked" : ""; ?>><br><br>
                
                <input type="submit" value="Submit">
            </form>
            <?php
        } else {
            echo "Ticket not found.";
        }
    } else {
        echo "Invalid request.";
    }
    $conn->close();
    ?>
</body>
</html>
