<?php
/* Submit a new user to the Users database */

require_once('connect.php');
  // Connect to the database
  
  // Define database connection constants
  

  $dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
  if (!$dbc) {
    die('Could not connect: ' . mysql_error());
  }
else{
// Declare variables
$user_name        = $_POST[user_name];
$password        = $_POST[password];
//$hashed_password = base64_encode(hash('sha256', $password));

$user_id = "024";
$sql = "INSERT INTO log_in (user_id,user_name, password) VALUES ('$user_id','$user_name', '$password')";


// Send query
if (mysqli_query($conn, $sql)) {
    // Redirect to login page after successful registration
header("homepage.html");

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
$conn->close();
}
?>
