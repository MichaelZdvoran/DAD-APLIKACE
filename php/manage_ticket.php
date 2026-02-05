<?php
session_start();
require "db.php";

/* ============================
   ZOBRAZENÍ CHYB (dočasně!)
   ============================ */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ============================
   Ověření přihlášení a role
   ============================ */
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'it_worker') {
    header("Location: ../index.php");
    exit;
}

/* ============================
   Zpracování akce
   ============================ */
if (isset($_POST['ticket_id']) && isset($_POST['action'])) {

    $ticket_id = (int)$_POST['ticket_id'];
    $action = $_POST['action'];

    try {

        if ($action === 'close') {

            // Uzavření ticketu
            $stmt = $pdo->prepare(
                "UPDATE tickets SET status = 'closed' WHERE ticket_id = ?"
            );
            $stmt->execute([$ticket_id]);

        } elseif ($action === 'delete') {

            // Bezpečné mazání – transakce
            $pdo->beginTransaction();

            // 1️⃣ Smazat všechny zprávy k ticketu
            $stmt = $pdo->prepare(
                "DELETE FROM messages WHERE ticket_id = ?"
            );
            $stmt->execute([$ticket_id]);

            // 2️⃣ Smazat samotný ticket
            $stmt = $pdo->prepare(
                "DELETE FROM tickets WHERE ticket_id = ?"
            );
            $stmt->execute([$ticket_id]);

            $pdo->commit();
        }

        // Návrat zpět
        header("Location: ../ticket_management.php");
        exit;

    } catch (PDOException $e) {

        // Pokud něco spadne → vrátí změny
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        echo "<h2>Chyba databáze:</h2>";
        echo "<pre>" . $e->getMessage() . "</pre>";
        exit;
    }
}
?>
