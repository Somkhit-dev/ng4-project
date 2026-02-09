<?php
require_once '../config.php';
session_start();

// ตรวจสอบสิทธิ์ admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$status = "error"; // ค่าเริ่มต้น

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // ลบข้อมูล
    $stmt = $conn->prepare("DELETE FROM form_fields WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $status = "success";
    }
    $stmt->close();
}

// กลับไปหน้า edit_index.php พร้อมส่ง status
header("Location: ../list_form.php?status=" . $status);
exit();
?>
