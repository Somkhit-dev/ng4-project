<?php
session_start();

require_once 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าเข้าสู่ระบบแล้วและมี role เป็น admin หรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // ถ้าไม่ใช่ admin ให้ redirect ไปหน้า login หรือหน้าอื่น
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่า user_id ถูกส่งมาจากฟอร์มหรือไม่
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // สร้างคำสั่ง SQL เพื่ออัพเดตสถานะการอนุมัติ
    $sql = "UPDATE users SET approve = 'อนุมัติแล้ว' WHERE user_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // ผูกพารามิเตอร์
        $stmt->bind_param("i", $user_id);

        // ทำการ execute คำสั่ง SQL
        if ($stmt->execute()) {
            // ถ้าการอัพเดตสำเร็จ
            header("Location: approve_users.php"); // กลับไปยังหน้าจัดการ
            exit();
        } else {
            // ถ้ามีข้อผิดพลาดในการอัพเดต
            echo '<p class="text-red-600">เกิดข้อผิดพลาดในการอัพเดตสถานะ: ' . $conn->error . '</p>';
        }

        // ปิดการเชื่อมต่อ
        $stmt->close();
    } else {
        echo '<p class="text-red-600">เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL</p>';
    }
} else {
    echo '<p class="text-red-600">ไม่พบข้อมูลผู้ใช้ที่ต้องการอนุมัติ</p>';
}

$conn->close();
?>
