<?php
session_start();
require "db.php"; // připojení k databázi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Upravený dotaz pro získání role pomocí JOIN
    $stmt = $pdo->prepare("SELECT users.id, users.email, users.password, roles.name 
                           FROM users 
                           JOIN roles ON users.role_id = roles.id 
                           WHERE users.email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Uložení informací do session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email']; // Uložení emailu do session
        $_SESSION['role'] = $user['name']; // Uložení názvu role do session

        // Přesměrování na základě role
        if ($user['name'] === 'it_worker') {
            header("Location: ../ticket_management.php"); // Předpokládám stránku pro IT pracovníka
        } else {
            header("Location: ../ticket.php"); // Běžná stránka pro uživatele
        }
        exit;
    } else {
        echo "Neplatné přihlašovací údaje";
    }
}
?>
