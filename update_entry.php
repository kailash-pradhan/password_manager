<?php
 // Resume the session

// Check if the user is logged in (session variables are set)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // Access user information from session
    $user_id = $_SESSION["user_id"];

    
    $username = $_POST["web_username"];
    $websiteName = $_POST["webname"];
    $password = $_POST["pass"];


    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "password_manager";

    // Create a database connection
    $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (isset($_POST['update'])) {
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
    echo "$username\n";
    echo "$encryptedPassword\n";
    echo "\n$user_id\n";
    echo $websiteName;
    $update_query="update saved_passwords set username='$username', encrypted_password='$encryptedPassword' where email='$user_id' and website_name='$websiteName'";

    if (mysqli_query($conn, $update_query)) {
        
        echo "<script type='text/javascript'>alert('Password updated successfully.');
window.location.replace('dashboard.php');
</script>";

    } else {
        echo "Error: " . mysqli_error($conn);
    }
    // Close the database connection
    mysqli_close($conn);
}
else if (isset($_POST['delete'])) {
    $del_query="delete from saved_passwords where email='$user_id' and website_name='$websiteName'";
    if (mysqli_query($conn, $del_query)) {
        
        echo "<script type='text/javascript'>alert('Password deleted successfully.');
window.location.replace('dashboard.php');
</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    // Close the database connection
    mysqli_close($conn);

}
} else {
    echo "<script type='text/javascript'>alert('Form submission method is not POST.');
window.location.replace('dashboard.php');
</script>";
}


?>




