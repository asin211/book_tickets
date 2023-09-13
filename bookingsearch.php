<?php
include "config.php"; //load in any variables
$DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

$sqa = $_POST['sqa'];
$sqb = $_POST['sqb'];

$searchresult = '';
if (true) {

    $query = "SELECT flightcode, flightname, departure_location,
    destination_location FROM flight WHERE flightcode 
    NOT IN (SELECT flightcode FROM ticket 
    WHERE departureDate >= '$sqa' AND arrivalDate <='$sqb')";
    $result = mysqli_query($DBC, $query);
    $rowcount = mysqli_num_rows($result);

    if ($rowcount > 0) {
        $row = []; //start an empty array
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        //take the array of our 1 or more bookings and turn it into a JSON text
        $searchresult = json_encode($rows);

        header('Content-Type: text/json; charset=utf-8');
    } else echo "<tr><td colspan=3><h5>No bookings found!</h5></td></tr>";
    
} else echo "<tr><td colspan=3><h6>Invalid search query</h6></td></tr>";

mysqli_free_result($result);
mysqli_close($DBC);

echo $searchresult;
?>