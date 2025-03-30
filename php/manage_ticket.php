<?php
session_start();
require "db.php";

// Ověření přihlášení a role
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'it_worker') {
    header("Location: ../index.php");
    exit;
}

if (isset($_POST['ticket_id']) && isset($_POST['action'])) {
    $ticket_id = $_POST['ticket_id'];
    $action = $_POST['action'];

    if ($action === 'close') {
        // Uzavření ticketu
        $stmt = $pdo->prepare("UPDATE tickets SET status = 'closed' WHERE ticket_id = ?");
        $stmt->execute([$ticket_id]);
    } elseif ($action === 'delete') {
        // Smazání ticketu
        $stmt = $pdo->prepare("DELETE FROM tickets WHERE ticket_id = ?");
        $stmt->execute([$ticket_id]);
    }

    // Přesměrování zpět na správu ticketů
    header("Location: ../ticket_management.php");
    exit;
}
?>
