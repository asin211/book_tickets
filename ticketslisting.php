<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse bookings</title>
</head>

<body>

    <?php
    include "checksession.php";
    checkUser();
    loginStatus();
    include "config.php";
    $DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error:unable to connect to Mysql." . mysqli_connect_error();
        exit; //stop processing the page further
    }


    //prepare a query and send it to the server
    $query = 'SELECT ticketID, flightcode, departureDate, arrivalDate FROM ticket ORDER BY flightcode ';
    $result = mysqli_query($DBC, $query);
    $rowcount = mysqli_num_rows($result);
    ?>


    <h1>Current tickets</h1>
    <h2><a href="bookticket.php">[Book a ticket]</a><a href="/booktickets/">[Return to main page]</a></h2>

    <table border="1">
        <thead>
            <tr>
                <th>Current tickets (Flights, departureDate, arrivalDate)</th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
        if ($rowcount > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['ticketID'];
                $fc = $row['flightcode'];

                //https://www.php.net/manual/en/language.operators.execution.php
                $sql = 'SELECT flightcode, flightname, departure_location, destination_location FROM `flight` WHERE flightcode=' . $fc;
                $res = mysqli_query($DBC, $sql);
                $rowc = mysqli_num_rows($res);

                if ($rowc > 0) {
                    $rowr = mysqli_fetch_assoc($res);
                }

                echo '<tr><td>' . $rowr['flightname'] . ', ' . $row['departureDate']
                    . ', ' . $row['arrivalDate'] . '</td>';

                echo     '<td><a href="ticketdetails.php?id=' . $id . '">[view] </a>';
                echo         '<a href="editbooking.php?id=' . $id . '">[edit] </a>';
                echo         '<a href="editseats.php?id=' . $id . '">[manage seats] </a>';
                echo         '<a href="deleteticket.php?id=' . $id . '">[delete] </a></td>';
                echo '</tr>' . PHP_EOL;
                mysqli_free_result($res); //free any memory used by the query

            }
        } else echo "<h2>No tickets found!</h2>";

        mysqli_free_result($result);
        mysqli_close($DBC);

        ?>

    </table>



</body>

</html>