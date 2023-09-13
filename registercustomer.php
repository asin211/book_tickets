<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register new customer</title>
</head>

<body>

  <?php
  //fucntion to clean input but not validate type and content
  //https://www.w3schools.com/php/func_string_stripslashes.asp
  //The stripslashes() function removes backslashes,  added by the addslashes() function.
  //Tip: This function can be used to clean up data retrieved from a database or from an HTML form.
  //Trim, stripslashes, htmlspecialchars functions
  //https://www.techfry.com/php-tutorial/validate-form-data-with-php
  //https://topic.alibabacloud.com/a/trim-stripslashes-htmlspecialchars-functions_4_86_30945815.html

  // input may have some unnecessary characters such as space or figures

  function cleanInput($data)
  {
    return htmlspecialchars(stripslashes(trim($data)));
  }

  //the data was sent using a form therefore we use the $_POST instead of $_GET
  //check if we are saving data first by checking if the submit button exists in the array

  //isset — Determine if a variable is declared and is different than null

  if (
    isset($_POST['submit']) and !empty($_POST['submit'])
    and ($_POST['submit'] == 'Register')
  ) {
    //if ($_SERVER["REQUEST_METHOD"] == "POST") { //alternative simpler POST test    

    include "config.php"; //load in any variables
    $DBC = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
      echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
      exit; //stop processing the page further
    }

    //validate incoming data - only the first field is done for you in this example 
    //- rest is up to you do
    //firstname
    $error = 0; //clear our error flag
    $msg = 'Error: ';

    if (
      isset($_POST['firstname']) and !empty($_POST['firstname'])
      and is_string($_POST['firstname'])
    ) {

      $fn = cleanInput($_POST['firstname']);

      //https://www.php.net/manual/en/function.substr.php
      //substr — Return part of a string



      $firstname = (strlen($fn) > 50) ? substr($fn, 3, 50) : $fn; //check length and clip if too big
      //we would also do context checking here for contents, etc       
    } else {
      $error++; //bump the error flag
      $msg .= 'Invalid firstname '; //append eror message
      $firstname = '';
    }
    //lastname
    $lastname = cleanInput($_POST['lastname']);
    //email
    $email = cleanInput($_POST['email']);


    //password    
    $password = cleanInput($_POST['password']);

    //save the customer data if the error flag is still clear

    //https://www.w3schools.com/php/php_mysql_prepared_statements.asp
    //Prepared Statements and Bound Parameters

    if ($error == 0) {
      $query = "INSERT INTO customer (fname,lname,email, password) VALUES (?,?,?,?)";

      $stmt = mysqli_prepare($DBC, $query); //prepare the query

      mysqli_stmt_bind_param($stmt, 'ssss', $firstname, $lastname, $email, $password);

      /*
          check before using?- w3school ==> https://www.w3schools.com/php/php_mysql_prepared_statements.asp OR https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php 
          'ssss' = string 
          'i' = number
          'double' = double
          */

      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      echo "<h2>customer saved</h2>";
    } else {

      echo "<h2>$msg</h2>" . PHP_EOL;
    }

    mysqli_close($DBC); //close the connection once done
  }
  ?>

  <h1>New Customer Registration</h1>
  <h2><a href='memberslisting.php'>[Return to the Customer listing]</a>
    <a href='/booktickets/'>[Return to the main page]</a>
  </h2>

  <form method="POST" action="registercustomer.php">

    <p>
      <label for="firstname">First Name: </label>
      <input type="text" id="firstname" name="firstname" minlength="3" maxlength="50" required>
    </p>


    <p>
      <label for="lastname">Last Name: </label>
      <input type="text" id="lastname" name="lastname" minlength="3" maxlength="50" required>
    </p>


    <p>
      <label for="email">Email: </label>
      <input type="email" id="email" name="email" maxlength="100" size="50" required>
    </p>

    <p>
      <label for="password">Password: </label>
      <input type="password" id="password" name="password" minlength="8" maxlength="32">
    </p>

    <input type="submit" name="submit" value="Register">
  </form>
</body>

</html>