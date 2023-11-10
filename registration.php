<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $phone = $_POST["mobile"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // Get the plain text password

    // Generate a random salt
    $salt = random_bytes(16);

    // Hash the password using bcrypt with the generated salt
    $hashedPassword = password_hash($password . $salt, PASSWORD_BCRYPT);

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

    // SQL query to insert data
    $sql = "INSERT INTO registration (name, mobile, email, salt, hashedpassword) VALUES ('$name', $phone, '$email', '$salt', '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {
        
        echo "<script type='text/javascript'>alert('Data inserted successfully.');
window.location.replace('index.html');
</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    
    echo "<script type='text/javascript'>alert('Form submission method is not POST.');
window.location.replace('index.html');
</script>";
}
?>
