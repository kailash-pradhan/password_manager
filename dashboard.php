<?php
session_start(); // Resume the session

// Check if the user is logged in (session variables are set)
if (!isset($_SESSION["user_id"])) {
    // If not logged in, redirect to the login page
    header("Location: index.html");
    exit();
}

// Access user information from session
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "password_manager";

// Create a database connection
$conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT website_name, username, encrypted_password FROM saved_passwords WHERE email = '$user_id'";
$mob_query="SELECT mobile from registration where email='$user_id'";
$mob_result=mysqli_query($conn,$mob_query);
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
}
if(!$mob_result){
    echo "Error: ".mysqli_error($conn);
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        table.tbcenter {
            margin-left: auto; 
            margin-right: auto;
            width: 70%;
            text-align: center;
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Welcome, <?php echo $user_name; ?>!</h2>
                <!-- Your dashboard content here -->
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <a href="addpassword.php" class="btn btn-primary">Add Password</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
            <div class="col-md-12">
                <form method="POST" action="update_entry.php" id="Update_form">
                <!-- Display saved passwords in a table-like structure -->
                <table class="table table-bordered tbcenter">
                    <thead>
                        <tr>
                            <th colspan="5">Your Saved Passwords (Decrypted)</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th>Website Name</th>
                            <th>Username</th>
                            <th>Decrypted Password</th>
                            <th>Edit</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through and display user's saved passwords
                        $row_mob=mysqli_fetch_assoc($mob_result);
                        function xor_decrypt($encryptedData, $key) {
                                $encryptedData = base64_decode($encryptedData);
                                $keyLength = strlen($key);
                                $decryptedData = '';

                                for ($i = 0; $i < strlen($encryptedData); $i++) {
                                    $decryptedData .= $encryptedData[$i] ^ $key[$i % $keyLength];
                                }

                                return $decryptedData;
                            }
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            $web=$row['website_name'];
                            $uniqueId = 'webname_' . $web; // Create a unique ID for each field
                            echo '<td><input type="text" disabled id="'.$uniqueId.'" name="webname" value="'. $web .' "></td>';
                            echo '<td><input type="text" disabled id="web_username" name="web_username" value="' . $row['username'] . '"></td>';

                            
                            $decryptedPassword = xor_decrypt($row['encrypted_password'], $row_mob['mobile']);
                            //$decryptedPassword = decrypt();
                            echo '<td><input type="text" disabled id="pass" name="pass" value="' . $decryptedPassword . '"></td>';
                            echo '<td><input type="button" name="edit" value="Edit" onclick="enableInputBoxes(this)"></td>';
                            echo '<td><input type="submit" disabled name="update" value="Update" onclick="enableInputBox(\'' . $uniqueId . '\')"></td>';


                            echo '<td><input type="submit" disabled id="del" name="delete" value="Delete" onclick="enableInputBox(\'' . $uniqueId . '\')"></td>';

                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </form>
            </div>
        </div>


    <!-- Include Bootstrap JS (jQuery and Popper.js are required) -->
    <script>
    function enableInputBoxes(button) {
    var row = button.closest('tr');
    var inputElements = row.getElementsByTagName('input');
    for (var i = 1; i < inputElements.length; i++) {
        inputElements[i].disabled = false;
        
    }
}

function enableInputBox(id) {
    document.getElementById(id).disabled = false;
}
function del(id){
    var tar="delete_recod.php";
    document.getElementById('id').disabled=false;
    var form = document.getElementById('d');

    // Submit the form
    window.location.href=tar;
}

// New Changes


// End Changes

</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
