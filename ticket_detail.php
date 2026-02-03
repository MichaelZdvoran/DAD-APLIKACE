<?php
require 'php/db.php';
session_start();

$ticket_id = $_GET['ticket_id']; // Tohle získává ticket_id z URL

$sql = "SELECT m.message, m.created_at, u.id
        FROM messages m
        JOIN users u ON m.user_id = u.id
        WHERE m.ticket_id = ? 
        ORDER BY m.created_at ASC";
$stmt = $pdo->prepare($sql);

$stmt->execute([$ticket_id]);


$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Detail Tiketu</title>
    <link rel="stylesheet" href="styles/ticket.css?v=<?php echo time(); ?>">
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
            <span class="user-role"><?php echo htmlspecialchars($_SESSION['role']); ?></span>
            <a href="php/logout.php" class="logout-btn">Odhlásit se</a>
        <?php else: ?>
            <a href="index.php">Přihlásit se</a>
        <?php endif; ?>
    </div>
</header>

<h2>Detail Tiketu #<?php echo htmlspecialchars($ticket_id); ?></h2>

<div class="chat-container">
    <?php foreach ($messages as $message): ?>
        <div class="message">
            <div class="message-content">
                <strong><?php echo htmlspecialchars($message['id']); ?>:</strong>
                <p><?php echo htmlspecialchars($message['message']); ?></p>
            </div>
            <div class="message-time">
                <small><?php echo $message['created_at']; ?></small>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="response-form">
    <form action="php/respond_to_ticket.php" method="POST">
        <textarea name="message" rows="4" cols="50" required></textarea><br>
        <button type="submit">Odeslat</button>
        <input type="hidden" name="ticket_id" value="<?php echo htmlspecialchars($ticket_id); ?>">
    </form>
</div>

</body>
</html>
