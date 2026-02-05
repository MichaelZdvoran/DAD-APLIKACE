<?php
require 'db.php';
session_start();

// Zkontroluj, jestli je uživatel přihlášen a má správné session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['ticket_id']) && isset($_POST['message'])) {
    $ticket_id = $_POST['ticket_id'];
    $message = $_POST['message'];

    // Ověření, že hodnoty nejsou prázdné
    if (!empty($ticket_id) && !empty($message)) {
        // Vložení nové zprávy do databáze
        $sql = "INSERT INTO messages (ticket_id, user_id, message) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt) {
            $stmt->execute([$ticket_id, $user_id, $message]);
            // Přesměrování zpět na detail tiketu
            header("Location: ../ticket_detail_admin.php?ticket_id=" . $ticket_id);
            exit();
        } else {
            echo "Chyba při přípravě dotazu!";
        }
    } else {
        echo "Chybí data! Ujistěte se, že ticket_id a message nejsou prázdné.";
    }
} else {
    echo "Nebyly odeslány požadované hodnoty!";
}
?>
