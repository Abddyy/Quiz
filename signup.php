<?php
include 'db.php';

$error = ''; // To hold any error messages
$emailError = ''; // Specific error message for email

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $role = $_POST['role'] ?? '';

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (empty($role)) {
        $error = "Please select a role.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Check if the email already exists
            $checkEmailQuery = "SELECT COUNT(*) FROM users WHERE email = :email";
            $stmt = $pdo->prepare($checkEmailQuery);
            $stmt->execute([':email' => $email]);
            $emailExists = $stmt->fetchColumn();

            if ($emailExists > 0) {
                $emailError = "This email is already registered. Please use a different email.";
            } else {
                // Proceed with inserting data
                $query = "INSERT INTO users (username, email, password_hash, fullName, role) 
                          VALUES (:username, :email, :password, :fullname, :role)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':fullname' => $fullname,
                    ':role' => $role
                ]);

                // Redirect or show success message
                header("Location: success.php");
                exit;
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
