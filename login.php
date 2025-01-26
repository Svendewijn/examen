<?php include 'header.php';?>
<?php
include 'database/connectdb.php'; // Include the database connection file

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submit'])) {
    // Function for data validation to prevent SQL injection
    function validateData($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate and sanitize user input
    $email = validateData($_POST['email']);
    $_pwd = validateData($_POST['password']);

    // SQL query to fetch user data
    $sql = "SELECT email, password, name, role, id FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_email);
        $param_email = $email;
        $stmt->execute();
        $stmt->bind_result($b_email, $b_pwd, $b_name, $b_role, $b_ID);
        $stmt->store_result();
        $stmt->fetch();

        // Check if user exists
        if ($stmt->num_rows > 0) {
            // Verify password
            if (password_verify($_pwd, $b_pwd)) {
                // Set session variables
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = intval($b_ID);
                $_SESSION["email"] = $b_email;
                $_SESSION["username"] = $b_name;
                $_SESSION["role"] = $b_role;
                header('Location: index.php');
                exit();
            } else {
                $error_message = 'Password invalid';
            }
        } else {
            $error_message = 'Email invalid';
        }
    }
    $stmt->close();
    exit();
}

// checks if user has an active session and redirects to the index
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header('Location: index.php');
    exit();
}
// include_once('includes/head.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>placeholder</title>
</head>
<body>
<div class="container">
    <form action="login.php" method="post">
        login<br><br>
        <label for="username">Email:</label>
        <input type="email" id="email" placeholder="email" name="email" required><br>
        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" placeholder="password" name="password" required><br><br>
        <input type="submit" value="Sign In" name="login_submit">
    </form>
</div>
</body>
</html>