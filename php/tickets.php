<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Nejste přihlášen!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $severity = $_POST['severity']; // Nově přidané pole
    $user_id = $_SESSION['user_id'];

    if (empty($severity)) { // Kontrola, jestli je vyplněná závažnost
        die("Vyplňte závažnost!");
    }

    $stmt = $pdo->prepare("INSERT INTO tickets (user_id, title, description, severity) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $description, $severity]);

    header("Location: ../ticket.php");
    exit;
}
?>

