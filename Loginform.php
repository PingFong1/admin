<?php
// Include your database connection file
require_once 'includes/db_conn.php';

// Check if $conn is instantiated
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are set and not empty
    if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        // Prepare SQL statement to fetch user
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = mysqli_stmt_init($conn);
        
        // Check if statement initialization succeeds
        if (!$stmt) {
            $error = "Statement initialization failed: " . mysqli_error($conn);
        } else {
            // Prepare the statement
            if (mysqli_stmt_prepare($stmt, $sql)) {
                // Bind parameters to the prepared statement
                mysqli_stmt_bind_param($stmt, "ss", $_POST['username'], $_POST['password']);
                
                // Execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);

                    // Check if user exists
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        // Redirect user to dashboard or any other page after successful login
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        $error = "Invalid username or password";
                    }
                } else {
                    $error = "Error executing statement: " . mysqli_stmt_error($stmt);
                }
            } else {
                $error = "Error preparing statement: " . mysqli_stmt_error($stmt);
            }
        }
    } else {
        $error = "Please fill out all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminLTE | Log in</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Your custom CSS -->
    <style>
        body {
            background-image: url("Sakura.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <h2 class="text-center">AdminLTE</h2>
                <div class="login-container">
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="text-center">Sign in to start your session</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
                            <?php if (isset($error)) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="username">User Name</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="User Name">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <p class="mb-1">
                        <a href="forgot-password.html">I forgot my password</a>
                    </p>
                    <p class="mb-0">
                        <a href="register.html" class="text-center">Register a new membership</a>
                    </p>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            if (username.trim() == "" || password.trim() == "") {
                alert("Please fill out all fields.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>