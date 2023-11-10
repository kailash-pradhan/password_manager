<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // Access user information from session
    $user_id = $_SESSION["user_id"];

    
    $websiteName = $_POST["webname"];


    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "password_manager";

    // Create a database connection
    $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $delete_query="delete from saved_passwords where email='$user_id' and website_name='$websiteName'";

    if (mysqli_query($conn, $delete_query)) {
        echo "Password deleted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Form submission method is not POST.";
}
?>