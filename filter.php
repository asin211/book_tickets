<?
include "config.php";
$DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);


if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; //stop processing the page further
}

$sql = "SELECT * FROM ticket WHERE departureDate >= ? AND arrivalDate <= ?";

$stmt = $DBC->prepare($sql);
$stmt->bind_param("ss", $from_date, $to_date);
$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();

if ($result) {
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
        <th>Ticket ID</th>
        <th>flight</th>
        <th>Ticket Price</th>
        <th>Departure Date</th>
        <th>Departure Date</th>
        <th>Departure Date</th>
        <th>Departure Date</th>
      
        
        </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['ticketID '] . "</td>";
            echo "<td>" . $row['flightcode '] . "</td>";
            echo "<td>" . $row['customerID '] . "</td>";
            echo "<td>" . $row['departureDate'] . "</td>";
            echo "<td>" . $row['arrivalDate'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['seat_options'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No tickets found.";
    }
} else {
    echo "Error executing the query: " . $conn->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$DBC->close();
?>