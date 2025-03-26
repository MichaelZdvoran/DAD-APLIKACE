<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Nejste přihlášen!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO tickets (user_id, title, description) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $title, $description]);

    header("Location: ../ticket.php");
    exit;
}
?>
