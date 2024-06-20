<?php
session_start();
require "../models/db.model.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($username) || empty($password)) {
        echo "Please fill in both username and password.";
        exit();
    }

    $stmt = $pdo->prepare("SELECT users.user_id, users.username, users.password, roles.role_name
                           FROM Users 
                           JOIN Roles  ON users.role_id = roles.role_id
                           WHERE users.username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role_name'];

        if ($user['role_name'] == 'admin') {
            header("Location: ../views/admin-space.view.php");
        } else {
            header("Location: ../views/employee-space.view.php");
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>
