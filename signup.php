<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $fullname = $_POST['fullname'];
    $role = $_POST['role'];

    // Validate inputs
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $query = "INSERT INTO Users (Username, Email, PasswordHash, FullName,role)
         VALUES (:username, :email, :password, :fullname, :role)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':fullname' => $fullname,
            ':role' => $role
        ]);

        echo "Signup successful! You can now log in.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
