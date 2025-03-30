<?php
session_start();
require "db.php"; // připojení k databázi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email']; // Uložení emailu do session
        header("Location: ../ticket.php");
        exit;
    } else {
        echo "Neplatné přihlašovací údaje";
    }
}

?>
