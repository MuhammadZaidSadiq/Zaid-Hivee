<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $username = trim($_POST['user']);
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);
    $confirmPassword = trim($_POST['cpass']);

    // Validate passwords match
    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Passwords do not match!');
                window.location.href = 'signup.php';
              </script>";
        exit();
    }

    // Check if username already exists
    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Username already exists!');
                window.location.href = 'signup.php';
              </script>";
        exit();
    }

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Email already registered!');
                window.location.href = 'signup.php';
              </script>";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Please login.');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Registration failed! Please try again.');
                window.location.href = 'signup.php';
              </script>";
    }
}
?>