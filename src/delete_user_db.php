<?php
session_start();

require_once 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าเข้าสู่ระบบแล้วและมี role เป็น admin หรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // ถ้าไม่ใช่ admin ให้ redirect ไปหน้า login หรือหน้าอื่น
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่า user_id ถูกส่งมาหรือไม่
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // ตรวจสอบว่า user_id เป็นจำนวนที่ถูกต้องหรือไม่
    if (is_numeric($user_id)) {
        // ลบผู้ใช้จากฐานข้อมูล
        $sql = "DELETE FROM users WHERE user_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {
                // ถ้าลบสำเร็จ, redirect ไปที่หน้า admin dashboard หรือหน้าที่ต้องการ
                header("Location: delete_user.php?success=1");
                exit();
            } else {
                // ถ้ามีข้อผิดพลาดในการลบ
                echo '<p class="text-red-600">ไม่สามารถลบผู้ใช้ได้: ' . $stmt->error . '</p>';
            }
        } else {
            echo '<p class="text-red-600">เกิดข้อผิดพลาดในการเตรียมคำสั่ง: ' . $conn->error . '</p>';
        }
    } else {
        // ถ้า user_id ไม่ใช่ตัวเลข
        echo '<p class="text-red-600">ID ผู้ใช้ไม่ถูกต้อง</p>';
    }
} else {
    // ถ้าไม่ได้ส่ง user_id
    echo '<p class="text-red-600">ไม่พบข้อมูลผู้ใช้</p>';
}

$conn->close();
?>
