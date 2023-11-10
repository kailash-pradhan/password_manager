<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Database connection parameters
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "password_manager";

    // Create a database connection
    $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // SQL query to retrieve user data
    $checkEmailQuery = "SELECT * FROM registration WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);
    
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $storedSalt = $row['salt'];
            $storedHashedPassword = $row['hashedpassword'];

            // Hash the entered password with the retrieved salt
            $computedHash = password_hash($password . $storedSalt, PASSWORD_BCRYPT);
            
            // Compare the computed hash with the stored hashed password
            if (password_verify($password . $storedSalt, $storedHashedPassword)) {
                
                $_SESSION["user_name"] = $row['name'];
                $_SESSION["user_id"] = $row['email'];
                header("Location: dashboard.php");
                exit();
                // Add code to set the user's session and redirect to the dashboard
            } else {
                
echo "<script type='text/javascript'>alert('Login failed. Please check your credentials.');
window.location.replace('index.html');
</script>";

                //$login_error = "Login failed. Please check your credentials.";
            }

            
        } else {
            echo "<script type='text/javascript'>alert('Please Enter Correct Email ID');
window.location.replace('index.html');
</script>";
            
        }
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "<script type='text/javascript'>alert('Form submission method is not POST.');
window.location.replace('index.html');
</script>";
    
}
?>
