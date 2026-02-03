<?php
session_start();
require "php/db.php";

// Ověření, zda je uživatel přihlášen a zda má roli 'it_worker'
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'it_worker') {
    header("Location: index.php"); // Pokud není IT pracovník, přesměruj na přihlašovací stránku
    exit;
}

// Načtení tiketů
$stmt = $pdo->prepare("SELECT * FROM tickets");
$stmt->execute();
$tickets = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa Ticketů</title>
    <link rel="stylesheet" href="styles/management.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <div class="header-left">
            <h1>Fix IT</h1>
            <nav>
                <ul>
                    <li><a href="ticket.php">Správa Ticketů</a></li>
                    <li><a href="aboutus.php">O Nás</a></li>
                </ul>
            </nav>
        </div>

        <div class="user-container">
            <?php if (isset($_SESSION['user_email'])): ?>
                <span class="user-email"><?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                <span class="user-role"><?php echo htmlspecialchars($_SESSION['role']); ?></span> <!-- Zobrazení role -->
                <a href="php/logout.php" class="logout-btn">Odhlásit se</a>
            <?php else: ?>
                <a href="index.php">Přihlásit se</a>
            <?php endif; ?>
        </div>
    </header>


    <main>
        <section class="container">
            <h2>Seznam Ticketů</h2>
            <div class="tickets-list">
                <?php foreach ($tickets as $ticket): ?>
                    <div class="ticket">
                        <h3><?php echo htmlspecialchars($ticket['title']); ?></h3>
                        <p><?php echo htmlspecialchars($ticket['description']); ?></p>
                        <p><strong>Závažnost:</strong> <?php echo htmlspecialchars($ticket['severity']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($ticket['status']); ?></p>
                        <form action="php/manage_ticket.php" method="post">
                            <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                            <button type="submit" name="action" value="close">Uzavřít</button>
                            <button type="submit" name="action" value="delete">Smazat</button>
                            <?php
                                foreach ($tickets as $ticket) {
                                    echo "

                                            <a href='ticket_detail.php?ticket_id={$ticket['ticket_id']}'>Zobrazit detail</a>
                                           
                                        ";
                                }

                            ?>

                            
                            
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Fix IT Ticketovací Systém</p>
    </footer>
</body>
</html>
