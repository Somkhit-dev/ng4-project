<?php
session_start();
require_once 'config.php';

if (isset($_GET['id']) && $_SESSION['role'] === 'admin') {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM news_announcements WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: news.php?msg=deleted");
    }
}
?>