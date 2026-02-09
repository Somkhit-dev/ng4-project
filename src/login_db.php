<?php
// Ensure no output is sent before session_start or header calls
ob_start();
session_start();
require_once 'config.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        if (!$conn) {
            throw new Exception("เชื่อมต่อฐานข้อมูลล้มเหลว!");
        }

        $stmt = $conn->prepare("SELECT user_id, firstname, lastname, password, role, approve FROM users WHERE email = ?");
        if (!$stmt) {
            throw new Exception("เกิดข้อผิดพลาดในการเตรียม SQL: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $firstname, $lastname, $hashed_password, $role, $approve);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // ✅ ตรวจสอบข้อความ "อนุมัติแล้ว"
                if ($approve !== 'อนุมัติแล้ว') {
                    $_SESSION['error'] = "บัญชีของคุณยังไม่ได้รับการอนุมัติ";
                    header("Location: login.php");
                    exit();
                }

                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $firstname . " " . $lastname;
                $_SESSION['role'] = $role;
                $_SESSION['success'] = "เข้าสู่ระบบสำเร็จ!";

                if ($role === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: user_dashboard.php");
                }
                exit();
            } else {
                $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
            }
        } else {
            $_SESSION['error'] = "ไม่พบบัญชีผู้ใช้";
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
    }

    header("Location: login.php");
    exit();
}
?>
