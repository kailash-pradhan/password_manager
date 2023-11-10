<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Password</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Welcome, <?php session_start();
                    if (!isset($_SESSION["user_id"])) {
                    // If not logged in, redirect to the login page
                        header("Location: index.html");
                        exit();
                    }
                        $user_name = $_SESSION["user_name"]; 
                        echo $user_name; ?>!</h2>
                <!-- Your dashboard content here -->
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h3>Add New Password</h3>
                <!-- Create a Bootstrap form for adding passwords -->
                <form action="saved_passwords.php" method="POST">
                    <div class="mb-3">
                        <label for="websiteName" class="form-label">Website Name</label>
                        <input type="text" class="form-control" id="websiteName" name="websiteName" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Password</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (jQuery and Popper.js are required) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
