<?php
include 'database/connectdb.php';

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if email already exists
    $checkEmailStmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    if ($checkEmailStmt->num_rows > 0) {
        $message = "Email ID already exists";
        $toastClass = "#007bff"; // Primary color
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password_hashed, $role);

        if ($stmt->execute()) {
            $message = "Account created successfully";
            $toastClass = "#28a745"; // Success color
        } else {
            $message = "Error: " . $stmt->error;
            $toastClass = "#dc3545"; // Danger color
        }

        $stmt->close();
    }

    $checkEmailStmt->close();
    $conn->close();
}
?>

<?php include 'header.php';?>
<link rel="stylesheet" href="styling/register.css">
  <div class="container">
  <form action="registratie.php" method="post">
        Registreer een gebruiker<br><br>
        <label for="name">Naam:</label>
        <input type="text" id="name" placeholder="name" name="name" required><br>
        <label for="username">Email:</label>
        <input type="email" id="email" placeholder="email" name="email" required><br>
        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" placeholder="password" name="password" required><br>
        <label for="role">Rol:</label>
        <select id="role" name="role">
                        <option value="medewerker">medewerker</option>
                        <option value="admin">admin</option>
                    </select><br><br>
        <input type="submit" value="registreer" name="register_submit">
    </form>
  </div>