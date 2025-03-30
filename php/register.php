<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);  // Odstraní mezery na začátku a konci e-mailu
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!str_contains($email, 'souepl')) {
        die("Registrace povolena pouze pro @souepl e-maily.");
    }

    // Přidání uživatele do databáze
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $password]);

    header("Location: ../index.php?registered=1");
    exit;
}
?>
