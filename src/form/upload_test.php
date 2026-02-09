<?php
session_start();
require __DIR__ . '/../config.php'; // ปรับ path ให้ถูกต้อง


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image_file'])) {
    $file = $_FILES['image_file'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploaded_files/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('img_', true) . '.' . $fileExt;
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // ใช้ mysqli เตรียม statement
            $stmt = $conn->prepare("INSERT INTO uploaded_images (form_id, image_url) VALUES (?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            // ตรวจสอบ form_id ใน session ว่ามีหรือไม่
            $form_id = $_SESSION['form_id'] ?? null;
            if ($form_id === null) {
                die("ไม่มี form_id ใน session");
            }

            $stmt->bind_param("is", $form_id, $uploadPath);
            if ($stmt->execute()) {
                echo "อัปโหลดและบันทึกลงฐานข้อมูลสำเร็จ!";
            } else {
                echo "Execute failed: " . $stmt->error;
            }
            $stmt->close();

        } else {
            echo "ไม่สามารถย้ายไฟล์ได้";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการอัปโหลด: " . $file['error'];
    }
} else {
    echo "ไม่มีไฟล์ส่งมาจากฟอร์ม";
}
