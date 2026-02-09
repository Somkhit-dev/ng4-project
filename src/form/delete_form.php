<?php
session_start();
require '../config.php';

// 1. ตรวจสอบว่าล็อกอินหรือยัง
if (!isset($_SESSION['user_id'])) {
    die("กรุณาล็อกอินก่อนใช้งาน");
}

$status = "error";
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role']; // เก็บ role ไว้ตรวจสอบหน้าที่จะ redirect กลับ

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 2. เงื่อนไขการลบ:
    // ถ้าเป็น admin อาจจะอนุญาตให้ลบได้ทุก ID (หรือเฉพาะของตัวเองตามโค้ดเก่าคุณ)
    // ในที่นี้ผมยึดตามความปลอดภัยเดิมคือ ลบได้เฉพาะ "เจ้าของฟอร์ม" (user_id ตรงกัน)
    $stmt = $conn->prepare("DELETE FROM form_fields WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $status = "success";
        } else {
            $status = "not_found"; // ไม่พบข้อมูลหรือไม่มีสิทธิ์ลบ
        }
    }
    $stmt->close();
}

// 3. ตรวจสอบเส้นทางที่จะส่งกลับ (Redirect Logic)
if ($role === 'admin') {
    // ถ้าเป็น admin ให้กลับไปหน้า admin_form.php
    header("Location: ../admin_form.php?status=" . $status);
} else {
    // ถ้าเป็น member ให้กลับไปหน้า user_dashboard.php
    header("Location: ../user_dashboard.php?status=" . $status);
}
exit();
?>