<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $websiteName = $_POST["websiteName"];
    $username = $_POST["username"];
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
    session_start();
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    // Prepare and execute the SQL query to insert the data
    $mob_query="select mobile from registration where email='$user_id'";
    $result = mysqli_query($conn,$mob_query);
    

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $mob=$row['mobile'];
        }
    }
    
    function xor_encrypt($data, $key) {
        $keyLength = strlen($key);
        $encryptedData = '';

        for ($i = 0; $i < strlen($data); $i++) {
            $encryptedData .= $data[$i] ^ $key[$i % $keyLength];
        }   

        return base64_encode($encryptedData);
    }
    $encryptedPassword = xor_encrypt($password, $mob);
    $sql = "INSERT INTO saved_passwords (email,website_name, username, encrypted_password) VALUES ('$user_id','$websiteName', '$username', '$encryptedPassword')";
    if (mysqli_query($conn, $sql)) {
        
        echo "<script type='text/javascript'>alert('Password added successfully.');
window.location.replace('dashboard.php');
</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    
    // Close the database connection
    mysqli_close($conn);
} else {
    
    echo "<script type='text/javascript'>alert('Form submission method is not POST.');
window.location.replace('dashboard.php');
</script>";
}
?>


