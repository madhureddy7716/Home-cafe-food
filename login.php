<?php
include "db_connect.php"; // Connect to DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    // Fetch user
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            echo "✅ Login successful! Welcome, " . htmlspecialchars($user["username"]);
            // TODO: set session for real login
        } else {
            echo "❌ Invalid password!";
        }
    } else {
        echo "❌ No account found with that email!";
    }

    $stmt->close();
    $conn->close();
}
?>
