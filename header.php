<?php
session_start();
include 'database/connectdb.php';
?>
<link rel="stylesheet" href="styling/styling.css">
<header>
        <nav>
            <a href="index.php">Home</a>
            |
            <?php if (isset($_SESSION["username"])): ?>
                <a href="logout.php">Log out</a>
            <?php else: ?>
                <a href="login.php">Log in</a>
            <?php endif; ?>
        </nav>
    </header>